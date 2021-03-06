/*
function dataCoreAjax(ajaxAction, data, callbackSuccess, callbackError, post, hideLoader){
	var lang = phpVars.LANGUAGE_ID,
		mid = location.search.match(/mid=([a-z0-9-_\.]+)/)[1];
	//
	if(typeof data == 'string' && data.substr(0,1)=='&'){
		data = data.substr(1);
	}
	//
	if(hideLoader!==true) {
		BX.showWait();
	}
	var action = '';
	if($.isArray(ajaxAction)) {
		action = ajaxAction[1];
		ajaxAction = ajaxAction[0];
	}
	if(action.length){
		action = '&action='+action;
	}
	return $.ajax({
		url: location.pathname+'?mid='+mid+'&lang='+lang+'&ajax_action='+ajaxAction+action,
		type: post==true ? 'POST' : 'GET',
		data: data,
		datatype: 'json',
		success: function(data, textStatus, jqXHR){
			if(typeof callbackSuccess == 'function') {
				callbackSuccess(data, textStatus, jqXHR);
			}
			if(hideLoader!==true) {
				BX.closeWait();
			}
		},
		error: function(jqXHR, textStatus, errorThrown){
			if(typeof callbackError == 'function') {
				callbackError(jqXHR, textStatus, errorThrown);
			}
			if(hideLoader!==true) {
				BX.closeWait();
			}
		}
	});
}
*/
/* Log */
function dataExpOptionsHandleLogTextarea(log){
	var textarea = $('textarea[data-role="module-log"]');
	if(log==true){
		log = textarea.val();
	}
	if(log && log.length){
		textarea.val(log).removeAttr('disabled').css('height','');
	}
	else {
		textarea.val('').attr('disabled', 'disabled').css('height', textarea.data('empty-height'));
	}
}
$(document).delegate('input[data-role="module-log-refresh"]', 'click', function(e){
	dataCoreAjax('log_refresh', {}, {}, function(JsonResult, textStatus, jqXHR){
		if(JsonResult.Success){
			dataExpOptionsHandleLogTextarea(JsonResult.Log);
		}
		else {
			dataExpOptionsHandleLogTextarea(null);
		}
		if(JsonResult.LogSize != undefined){
			$('[data-role="log-full-size"]').html(JsonResult.LogSize);
		}
	}, function(jqXHR){
		dataExpOptionsHandleLogTextarea(null);
	}, false);
});
$(document).delegate('input[data-role="module-log-clear"]', 'click', function(e){
	dataCoreAjax('log_clear', {}, {}, function(JsonResult, textStatus, jqXHR){
		dataExpOptionsHandleLogTextarea(null);
	}, function(jqXHR){
		dataExpOptionsHandleLogTextarea(null);
	}, false);
});
$(document).ready(function(){
	dataExpOptionsHandleLogTextarea(true);
	$('tr#data_exp_option_multithreaded input[type=checkbox]').trigger('change');
	$('tr#data_exp_option_discount_recalculation_enabled input[type=checkbox]').trigger('change');
});