/**
 *	Add checking Array.isArray (check if object is array or not)
 */
if(typeof Array.isArray === 'undefined') {
  Array.isArray = function(obj) {
    return Object.prototype.toString.call(obj) === '[object Array]';
  }
};

/**
 *	Serialize to JSON
 *	from https://css-tricks.com/snippets/jquery/serialize-form-to-json/
 */
if($.fn && !$.fn.serializeObject){
	$.fn.serializeObject = function() {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function() {
			if (o[this.name]) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
	};
}

/**
 *	Analog to http_build_query
 */
function acritCoreHttpBuildQuery(url, params){
	var query = Object.keys(params)
   .map(function(k) {return encodeURIComponent(k) + '=' + encodeURIComponent(params[k]);})
    .join('&');
	return url + (query.length ? (url.indexOf('?') == -1 ? '?' : '&') + query : '');
}

/**
 *	Analog to Bitrix CMain::getCurPageParam
 */
function acritCoreGetCurPageParam(strAdd, arRemove, bAtTheEnd){
	var arData = [];
		arDataTmp = [],
		arGetParts = location.search.substr(1).split('&'),
		strQuery = '';
	strAdd = typeof strAdd == 'string' ? strAdd : strAdd.toString();
	arRemove = typeof arRemove == 'object' ? arRemove : [arRemove];
	bAtTheEnd = bAtTheEnd === true ? true : false;
	for(var i in arGetParts){
		if(arGetParts[i].length){
			var item = arGetParts[i].split('=');
			arDataTmp.push({
				name: item[0],
				value: decodeURIComponent(item[1])
			});
		}
	}
	for(var i in arDataTmp){
		var strName = arDataTmp[i].name.split('[')[0],
			bDelete = false;
		for(var j in arRemove){
			if(arRemove[j] == strName){
				bDelete = true;
				break;
			}
		}
		if(!bDelete){
			arData.push(arDataTmp[i]);
		}
	}
	for(var i in arData){
		strQuery += '&' + arData[i].name + '=' + encodeURIComponent(arData[i].value);
	}
	strQuery = strQuery.substr(1);
	if(bAtTheEnd){
		strQuery = (strQuery.length ? strQuery + '&' : '') + strAdd;
	}
	else{
		strQuery = strAdd + (strQuery.length ? '&' + strQuery : '');
	}
	if(strQuery.substr(0, 1) == '&'){
		strQuery = strQuery.substr(1);
	}
	if(strQuery.length){
		strQuery = '?' + strQuery;
	}
	return location.href.split('?')[0] + strQuery;
}

/**
 *	Change browser url without reloading
 */
function acritCoreChangeUrl(key, value){
	if(document.readyState == 'complete') {
		value = (typeof value == 'number' && value > 0 || typeof value == 'string' && value.length 
			? key+'='+encodeURIComponent(value) : '');
		var newUrl = acritCoreGetCurPageParam(value, [key]);
		window.history.pushState('', '', newUrl);
		if(key == 'profile_id') {
			acritCoreChangeUrl('entity_type', null);
		}
	}
}

/**
 *	Ajax-request general
 *	Examples:
 *	ajaxAction = 'change_iblock';
 *	ajaxAction = ['change_iblock', 'custom_subaction'];
 */
var acritCoreAjaxObjects = {};
function acritCoreAjax(ajaxAction, get, post, success, error, hideLoader){
	var
		url = location.pathname,
		ajaxActionSub = '',
		ajaxActionFull = '',
		full = false,
		postTmp = [],
		ajax;
	//
	if(typeof post != 'object'){
		console.error('Variable post must be an object!');
		post = {};
	}
	if(!Array.isArray(post)){
		postTmp = [];
		for(var i in post){
			postTmp.push({
				name: i,
				value: post[i]
			});
		}
		post = postTmp;
	}
	postTmp = [];
	for(var i in post){
		if(typeof post[i] == 'object' && !Array.isArray(post[i]) && post[i].name == 'full' && post[i].value == 'Y'){
			full = true;
		}
		else{
			postTmp.push(post[i]);
		}
	}
	post = postTmp;
	if(full) {
		post.push({name: 'filter', value: filterData.length ? filterData : '-'});
		post.push({name: 'sections_id', value: sectionId.length ? sectionId : '-'});
	}
	//
	if(hideLoader!==true) {
		BX.showWait();
	}
	if($.isArray(ajaxAction)) {
		if(ajaxAction.length == 2){
			ajaxActionSub = ajaxAction[1];
			ajaxAction = ajaxAction[0];
		}
		else if (ajaxAction.length == 3){
			url = ajaxAction[0];
			ajaxActionSub = typeof ajaxAction[2] == 'string' && ajaxAction[2].length ? ajaxAction[2] : '';
			ajaxAction = ajaxAction[1];
		}
	}
	//
	url = acritCoreHttpBuildQuery(url, $.extend({
		ajax_action: (ajaxAction !== false && ajaxAction !== null ? ajaxAction : 'none'),
		ajax_action_sub: ajaxActionSub,
		lang: phpVars.LANGUAGE_ID
	}, get));
	//
	ajaxActionFull = ajaxAction + (ajaxActionSub.length ? '_' + ajaxActionSub : '');
	if(acritCoreAjaxObjects[ajaxActionFull] && acritCoreAjaxObjects[ajaxActionFull].readyState != 4){
		acritCoreAjaxObjects[ajaxActionFull].abort();
	}
	ajax = $.ajax({
		url: url,
		type: 'POST',
		data: post,
		datatype: 'json',
		success: function(arJson, textStatus, jqXHR){
			if(typeof success == 'function') {
				jqXHR._ajax_action = ajaxAction;
				success(jqXHR, textStatus, arJson);
			}
			if(arJson.DebugMessage){
				acritCorePopupDebug.Open(arJson.DebugMessage);
			}
			else{
				acritCorePopupDebug.Close();
			}
			if(typeof arJson != 'object'){
				acritCorePopupError.Open(jqXHR);
			}
			if(hideLoader!==true) {
				BX.closeWait();
			}
		},
		error: function(jqXHR, textStatus, errorThrown){
			jqXHR._ajax_action = ajaxAction;
			if(jqXHR.statusText != 'abort') {
				console.error(errorThrown);
				console.error(textStatus);
				console.error(jqXHR);
				if(typeof error == 'function') {
					error(jqXHR, textStatus, errorThrown);
				}
			}
			if(hideLoader!==true) {
				BX.closeWait();
			}
		}
	});
	acritCoreAjaxObjects[ajaxActionFull] = ajax;
	return ajax;
}

/**
 *	Create loading
 */
function acritCoreLoader(size, id){
	size = !isNaN(parseInt(size)) ? parseInt(size) : 24;
	id = typeof id == 'string' && id.length ? id : null;
	return $('<div class="acrit-core-loading"/>').attr('data-size', size).attr('id', id)
		.append($('<span/>').css({height:size, width:size}))
		.append($('<span/>').text(phpVars.messLoading));
}

/*** BASE POPUP ********************************************************************************************************/
let acritCorePopup = BX.CDialog;

/**
 *	Build URL for AJAX
 */
acritCorePopup.prototype.AcritCoreHttpBuildQuery = function(url, params) {
	var query = Object.keys(params)
	 .map(function(k) {return encodeURIComponent(k) + '=' + encodeURIComponent(params[k]);})
		.join('&');
	return url + (query.length ? (url.indexOf('?') == -1 ? '?' : '&') + query : '');
}

/**
 *	Load content via AJAX
 */
acritCorePopup.prototype.AcritCoreLoadContentAjax = function(ajaxAction, get, post, success, error, hideLoader) {
	let
		popup = this,
		url = location.href,
		ajaxActionSub = '';
	if($.isArray(ajaxAction)) {
		ajaxActionSub = ajaxAction[1];
		ajaxAction = ajaxAction[0];
	}
	get = typeof get == 'object' && get != null ? get : {};
	post = typeof get == 'object' && post != null ? post : {};
	get.ajax_action = ajaxAction;
	get.ajax_action_sub = ajaxActionSub;
	if(popup.AjaxUrl){
		url = popup.AjaxUrl;
	}
	return BX.ajax({
		url: popup.AcritCoreHttpBuildQuery(url, get),
		method: 'POST',
		data: post,
		dataType: 'json',
		timeout: 30,
		async: true,
		processData: true,
		scriptsRunFirst: false,
		emulateOnload: false,
		start: true,
		cache: false,
		onsuccess: function(arJsonResult){
			if(arJsonResult.Title != undefined){
				popup.AcritCoreSetTitle(arJsonResult.Title);
			}
			if(typeof success == 'function') {
				success(arJsonResult);
			}
			else if(arJsonResult.HTML != undefined){
				popup.AcritCoreSetContent(arJsonResult.HTML);
			}
			if(hideLoader!==true) {
				BX.closeWait();
			}
		},
		onfailure: function(status, error){
			console.error(error.data);
			popup.AcritCoreSetTitle('Error');
			popup.AcritCoreSetContent('<div class="acrit_core_bx_dialog_content_preformat" style="font-family:monospace;">'
				+error.data+'</div>');
			if(typeof error == 'function') {
				error(error);
			}
			if(hideLoader!==true) {
				BX.closeWait();
			}
		}
	});
}

/**
 *	Set title (considering HTML)
 */
acritCorePopup.prototype.AcritCoreSetTitle = function(title) {
	let nodes = this.PARTS.TITLEBAR.querySelectorAll('.bx-core-adm-dialog-head-inner');
	for(let i=0; i<nodes.length; i++) {
		nodes[i].innerHTML = title;
	}
}

/**
 *	Set content (and set height 100%)
 */
acritCorePopup.prototype.AcritCoreSetContent = function(html) {
	let nodes = this.PARTS.CONTENT_DATA.querySelectorAll('.bx-core-adm-dialog-content-wrap-inner');
	for(let i=0; i<nodes.length; i++) {
		nodes[i].innerHTML = '<div class="acrit_core_bx_dialog_content">' + html + '</div>';
		nodes[i].style.boxSizing = 'border-box';
		nodes[i].style.height = '100%';
		for(let j=0; j<nodes[i].childNodes.length; j++) {
			if(nodes[i].childNodes[j].nodeType == 1){
				nodes[i].childNodes[j].style.height = '100%';
			}
		}
		let scripts = nodes[i].querySelectorAll('script');
		if(scripts.length){
			for(let j=0; j<scripts.length; j++) {
				let script = document.createElement('script');
				script.text = '(function(){' + scripts[j].text + '})();';
				scripts[j].replaceWith(script);
			}
		}
		let checkboxes = this.PARTS.CONTENT_DATA.querySelectorAll('input[type="checkbox"]');
		for(let j=0; j<checkboxes.length; j++) {
			BX.adminFormTools.modifyCheckbox(checkboxes[j]);
		}
	}
	let inputs = this.PARTS.CONTENT_DATA.querySelectorAll('input[type=text],textarea');
	setTimeout(function(){
		for(let i=0; i<inputs.length; i++) {
			inputs[i].focus();
			inputs[i].setSelectionRange(inputs[i].value.length, inputs[i].value.length);
			break;
		}
	}, 1);
}

/**
 *	Set nav buttons
 */
acritCorePopup.prototype.AcritCoreSetNavButtons = function(buttons) {
	let
		empty = buttons == undefined || typeof(buttons) != 'object' || !buttons.length,
		container = this.PARTS.BUTTONS_CONTAINER;
	container.innerHTML = '';
	if(empty) {
		container.insertAdjacentHTML('beforeEnd', '<input type="button" value="0" style="visibility:hidden;" />');
	}
	else if(typeof(buttons) == 'object' || buttons.length){
		this.SetButtons(buttons);
		container.insertAdjacentHTML('beforeEnd', '<div style="clear:both"/>');
	}
}



/*** POPUPS ***********************************************************************************************************/

// POPUP: debug text
var acritCorePopupDebug;
acritCorePopupDebug = new BX.CDialog({
	ID: 'acritCorePopupDebug',
	title: '',
	content: '',
	resizable: true,
	draggable: true,
	height: 400,
	width: 1000
});
acritCorePopupDebug.Open = function(error){
	this.SetTitle(BX.message('ACRIT_CORE_POPUP_DEBUG_TITLE'));
	this.SetNavButtons();
	this.Show();
	this.LoadContent(error);
}
acritCorePopupDebug.SetTitle = function(title){
	$('.bx-core-adm-dialog-head-inner', this.PARTS.TITLEBAR).html(title);
}
acritCorePopupDebug.LoadContent = function(error){
	if(typeof error == 'object'){
		var jqXHR = error;
		error = jqXHR.responseText.replace(/<pre>/g, '<pre class="acritCore-error-text">');
		if(!error.length){
			error = '<pre class="acritCore-error-text">'+jqXHR.statusText+'</pre>'
		}
	}
	this.SetContent(error);
}
acritCorePopupDebug.SetNavButtons = function(){
	var container = $(this.PARTS.BUTTONS_CONTAINER);
	container.html('<input type="button" value="0" style="visibility:hidden;" />');
	this.SetButtons(
		[{
			'name': BX.message('ACRIT_CORE_POPUP_CLOSE'),
			'id': 'acritCore_debug_close',
			'className': 'acritCore-button-right',
			'action': function(){
				this.parentWindow.Close();
			}
		}]
	);
	container.append('<div style="clear:both"/>');
}

// POPUP: error text
var acritCorePopupError;
acritCorePopupError = new BX.CDialog({
	ID: 'acritCorePopupError',
	title: '',
	content: '',
	resizable: true,
	draggable: true,
	height: 300,
	width: 800
});
acritCorePopupError.Open = function(error){
	this.SetTitle(BX.message('ACRIT_CORE_POPUP_ERROR'));
	this.SetNavButtons();
	this.Show();
	this.LoadContent(error);
}
acritCorePopupError.SetTitle = function(title){
	$('.bx-core-adm-dialog-head-inner', this.PARTS.TITLEBAR).html(title);
}
acritCorePopupError.LoadContent = function(error){
	if(typeof error == 'object'){
		var jqXHR = error;
		error = jqXHR.responseText.replace(/<pre>/g, '<pre class="acritProcessing-error-text">');
		if(!error.length){
			error = '<pre class="acritProcessing-error-text">&lt;Empty response&gt;'+"\n\n"+'Status text: '+jqXHR.statusText+"\n\n"+jqXHR.getAllResponseHeaders()+'</pre>'
		}
	}
	this.SetContent(error);
}
acritCorePopupError.SetNavButtons = function(){
	var container = $(this.PARTS.BUTTONS_CONTAINER).html('');
	this.SetButtons(
		[{
			'name': BX.message('ACRIT_CORE_POPUP_CLOSE'),
			'id': 'acritProcessing_profile_preview_cancel',
			'className': 'acritProcessing-button-right',
			'action': function(){
				this.parentWindow.Close();
			}
		}]
	);
	container.append('<div style="clear:both"/>');
}

/**
 *	Add module version + core version to nav chain
 */
$(document).ready(function(){
	if(window.acritModuleVersion != undefined && BX.message('ACRIT_CORE_VERSION') != undefined){
		$('a[id^="bx_admin_chain_item_menu_acrit_"]>span')
			.append(' ('+acritModuleVersion+' / '+BX.message('ACRIT_CORE_VERSION')+')');
	}
});




