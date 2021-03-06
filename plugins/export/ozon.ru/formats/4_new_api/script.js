if (!window.ozonNewApiInitialized) {
	
	function dataExpOzonNewApiCatAttrUpdateEnableControls(enabled){
		let
			btnStart = $('input[data-role="categories-update-attributes-start"]'),
			btnStop = $('input[data-role="categories-update-attributes-stop"]'),
			loader = $('div[data-role="categories-update-attributes-loader"]');
		if(enabled){
			btnStart.removeClass('hidden');
			btnStop.addClass('hidden');
			loader.addClass('hidden');
		}
		else{
			btnStart.addClass('hidden');
			btnStop.removeClass('hidden');
			loader.removeClass('hidden');
		}
	}
	
	function dataExpOzonNewApiCatAttrUpdateExecute(start, force, justAttr){
		let
			action = ['plugin_ajax_action', 'category_attributes_update'],
			data = {
				iblock_id: $('#field_IBLOCK').val(),
				start: start ? 'Y' : 'N'
			};
		if(force){
			data.force = 'Y';
		}
		if(justAttr){
			data.just_attr = 'Y';
		}
		dataExpOzonNewApiCatAttrUpdateEnableControls(false);
		window.dataExpOzonNewApiAjaxUpdateAttr = dataExpAjax(action, data, function (arJsonResult, textStatus, jqXHR) {
			if(arJsonResult.Continue){
				dataExpOzonNewApiCatAttrUpdateExecute(false);
			}
			else{
				dataExpOzonNewApiCatAttrUpdateEnableControls(true);
			}
			if(arJsonResult.Html){
				$('div[data-role="categories-update-attributes-result"]').html(arJsonResult.Html).closest('tr').show();
			}
		}, function (jqXHR) {
			console.log(jqXHR);
			dataExpOzonNewApiCatAttrUpdateEnableControls(true);
		}, true);
	}
	
	function dataExpOzonNewApiCatAttrUpdateStop(){
		dataExpOzonNewApiCatAttrUpdateEnableControls(true);
		if(window.dataExpOzonNewApiAjaxUpdateAttr){
			window.dataExpOzonNewApiAjaxUpdateAttr.abort();
		}
	}
	
	$(document).delegate('input[data-role="categories-update-attributes-start"]', 'click', function(e) {
		dataExpOzonNewApiCatAttrUpdateExecute(true, e.ctrlKey, e.shiftKey);
	});
	
	$(document).delegate('input[data-role="categories-update-attributes-stop"]', 'click', function(e) {
		dataExpOzonNewApiCatAttrUpdateStop();
	});
	
	$(document).delegate('input[data-role="log-tasks-refresh"]', 'click', function(e, params) {
		dataExpAjax(['plugin_ajax_action', 'refresh_tasks_list'], params, function(JsonResult, textStatus, jqXHR){
			$('#tr_LOG_CUSTOM > td').html(JsonResult.HTML);
			dataExpHandleAjaxError(jqXHR, false);
		}, function(jqXHR){
			dataExpHandleAjaxError(jqXHR, true);
		}, false);
	});
	
	$(document).delegate('a[data-role="log-tasks-item-update-status"]', 'click', function(e) {
		let
			row = $(this).closest('[data-task-id]'),
			taskId = row.attr('data-task-id'),
			data = {task_id: taskId},
			detailsShown = $('div[data-role="log-tasks-status-details-table"]', row).is(':visible');
		dataExpAjax(['plugin_ajax_action', 'update_task_status'], data, function(JsonResult, textStatus, jqXHR){
			row.find('[data-role="log-tasks-item-status"]').html(JsonResult.HTML);
			if(JsonResult.StatusUpdateDatetime){
				row.find('[data-role="log-tasks-item-status-datetime"]').html(JsonResult.StatusUpdateDatetime);
			}
			if(detailsShown){
				$('div[data-role="log-tasks-status-details-table"]', row).show();
			}
			dataExpHandleAjaxError(jqXHR, false);
		}, function(jqXHR){
			dataExpHandleAjaxError(jqXHR, true);
		}, false);
	});
	
	$(document).delegate('a[data-role="log-tasks-status-toggle"]', 'click', function(e) {
		let
			div = $(this).next();
		e.preventDefault();
		if(!div.is(':animated')){
			div.slideToggle(150);
		}
	});
	
	let timeout;
	$(document).delegate('input[data-role="allowed-values-filter-text"]', 'input', function(e) {
		let data = {
			field: $('input[data-role="allowed-values-current-field"]').val(),
			query: $.trim($(this).val())
		};
		clearTimeout(timeout);
		timeout = setTimeout(function(){
			dataExpAjax(['plugin_ajax_action', 'allowed_values_filter'], data, function(arJsonResult){
				$('div[data-role="allowed-values-filter-results"]').html(arJsonResult.HTML);	
			});
		}, 500);
	});
	
	$(document).delegate('div[data-role="allowed-values-found-items"] span', 'click', function(e) {
		let
			span = this,
			colorClass = 'colored';
		dataCoreCopyToClipboard(span);
		$(span).addClass(colorClass);
		setTimeout(function(){
			$(span).removeClass(colorClass);
		}, 300);
	});
	
	$(document).delegate('a[data-role="log-tasks-status-preview"]', 'click', function(e){
		let data = {
			history_item_id: $(this).attr('data-id')
		};
		e.preventDefault();
		DataPopupHint.SetSize({width:1000, height:400});
		DataPopupHint.Open();
		DataPopupHint.SetTitle('Json preview');
		DataPopupHint.SetHtml(BX.message('DATA_EXP_POPUP_LOADING'));
		dataExpAjax(['plugin_ajax_action', 'history_item_json_preview'], data, function(arJsonResult){
			DataPopupHint.SetHtml(arJsonResult.HTML);
			$('pre > code', DataPopupHint.PARTS.CONTENT_DATA).each(function(){
				highlighElement(this);
			});
		});
	});
	
	$(document).delegate('a[data-role="log-task-json-preview"]', 'click', function(e){
		let data = {
			task_id: $(this).attr('data-id')
		};
		e.preventDefault();
		DataPopupHint.SetSize({width:1000, height:400});
		DataPopupHint.Open();
		DataPopupHint.SetTitle('Json preview');
		DataPopupHint.SetHtml(BX.message('DATA_EXP_POPUP_LOADING'));
		dataExpAjax(['plugin_ajax_action', 'task_json_preview'], data, function(arJsonResult){
			DataPopupHint.SetHtml(arJsonResult.HTML);
			$('pre > code', DataPopupHint.PARTS.CONTENT_DATA).each(function(){
				highlighElement(this);
			});
		});
	});
	
	$(document).delegate('#checkbox_CATEGORIES_ALTERNATIVE', 'change', function(e){
		$(this).closest('tr').next().toggle($(this).is(':checked'));
		$(this).closest('tr').next().next().toggle($(this).is(':checked'));
		$('tr.adm-list-table-row[data-field="category_id"]').toggle($(this).is(':checked'));
	});
	
	$(document).delegate('input[data-role="categories-alternative-select"]', 'click', function(e){
		DataExpPopupCategoriesRedefinitionSelect.Open(this, $('#field_IBLOCK').val(), false, false);
	});
	
	$(document).delegate('input[data-role="categories-alternative-select"]', 'data:categoryselect', function(e, params){
		let
			list = $('div[data-role="categories-alternative-list"]'),
			sample = $('div[data-role="categories-alternative-list"] > div[data-role="categories-alternative-item"]:first-child'),
			categoryName = params.category,
			categoryId = categoryName.replace(/^\[(\d+)\].*?$/, '$1'),
			newItem = sample.clone();
		newItem.find('input[type="hidden"]').val(categoryId);
		newItem.find('[data-role="categories-alternative-item-name"]').text(categoryName);
		newItem.appendTo(list);
	});
	
	$(document).delegate('div[data-role="categories-alternative-item-delete"] a', 'click', function(e){
		e.preventDefault();
		$(this).closest('[data-role="categories-alternative-item"]').remove();
	});
	
	$(document).delegate('input[data-role="data_exp_ozon_new_access_check"]', 'click', function(e){
		e.preventDefault();
		let
			clientId = $('input[data-role="data_exp_ozon_new_client_id"]').val(),
			apiKey = $('input[data-role="data_exp_ozon_new_api_key"]').val(),
			data = {client_id: clientId, api_key: apiKey};
		if(clientId.length && apiKey){
			dataExpAjax(['plugin_ajax_action', 'check_access'], data, function(JsonResult, textStatus, jqXHR){
				if(JsonResult.Message){
					alert(JsonResult.Message);
				}
				dataExpHandleAjaxError(jqXHR, false);
			}, function(jqXHR){
				dataExpHandleAjaxError(jqXHR, true);
			}, false);
		}
	});
	
	function dataExpOzonNewApiTriggers(){
		$('#checkbox_CATEGORIES_ALTERNATIVE').trigger('change');
	}

	window.ozonNewApiInitialized = true;
}

// On load
setTimeout(function(){
	dataExpOzonNewApiTriggers();
}, 500);
$(document).ready(function(){
	dataExpOzonNewApiTriggers();
});

// On current IBlock change
BX.addCustomEvent('onLoadStructureIBlock', function(a){
	dataExpOzonNewApiTriggers();
});