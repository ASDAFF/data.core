/*
 * Copyright (c) 12/2/2021 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

if (!window.vkPluginInitialized) {
	// Console
	/*
	$.alt('C', function() {
		$('#data_exp_vk_console').toggle();
	});
	$(document).delegate('#data_exp_vk_console input[type=button]', 'click', function(e) {
		e.preventDefault();
		var command = $(this).closest('td').find('textarea').val(),
			container = $('#data_exp_vk_console_result');
		dataExpAjax(['plugin_ajax_action','exec_console_command'], 'command='+command, function(JsonResult, textStatus, jqXHR) {
			container.html(JsonResult.Text);
		}, function(jqXHR){
			container.html(jqXHR.responseText);
		}, true);
	});
	*/
	function vkGoodsAccessTokenHandleChange(){
		$('#data_exp_plugin_vk_access_token').unbind('textchange').bind('textchange', function(e) {
			var accessToken = $(this).val().match(/access_token=(\w+)/i);
			if(accessToken != null){
				$(this).val(accessToken[1]);
			}
		});
	}
	//
	window.vkPluginInitialized = true;

	// Reset PROCESS_NEXT_POS param
	$(document).delegate('#data_exp_plugin_vk_process_next_pos_reset', 'click', function(e) {
		var btn = $(this);
		if (!btn.hasClass('adm-btn-disabled')) {
			if (confirm(BX.message('SETTINGS_PROCESS_NEXT_POS_RESET_ALERT'))) {
				data = {};
				btn.addClass('adm-btn-disabled');
				dataExpAjax(['plugin_ajax_action', 'params_next_pos_reset'], data, function (JsonResult, textStatus, jqXHR) {
						//console.log(JsonResult);
						btn.removeClass('adm-btn-disabled');
						if (JsonResult.result == 'ok') {
							$('#data_exp_plugin_vk_process_next_pos_view').text('0');
						}
					}, function (jqXHR) {
						console.log(jqXHR);
					}, true
				);
			}
		}
		return false;
	});
}


// On page load
$(document).ready(function(){
	vkGoodsAccessTokenHandleChange();
});

// On change plugin
setTimeout(function(){
	vkGoodsAccessTokenHandleChange();
}, 500);
