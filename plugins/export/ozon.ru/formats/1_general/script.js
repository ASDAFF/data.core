/**
 *	POPUP: Export execute
 */
var DataExpPopupOzonConstructor;
$(document).ready(function () {


	$(document).delegate('input[data-role="update_items_status"]', 'click',
			function (e) {
				data = {
					x1: 'ok1',
					x3: 'ok3',
				};
				dataExpAjax(['plugin_ajax_action', 'update_items_status'], data,
						function (JsonResult, textStatus, jqXHR) {
							$('.ozone-status-table').html(JsonResult.Text);
							console.log(JsonResult);
						}, function (jqXHR) {

					console.log(jqXHR);
				}, true);
			});
	$(document).delegate('.run_sync_ext_id', 'click',
			function (e) {
				console.log('run_sync_ext_id click');
				data = {
					x1: 'ok1',
					x3: 'ok3',
				};
				dataExpAjax(['plugin_ajax_action', 'sync_ext_id'], data,
						function (JsonResult, textStatus, jqXHR) {
							$('.sync_ext_id_div').html(JsonResult.Text);
							console.log(JsonResult);
						}, function (jqXHR) {

					console.log(jqXHR);
				}, true);
			});



	DataExpPopupOzonConstructor = new BX.CDialog({
		ID: 'DataExpPopupOzonConstructor',
		title: BX.message('DATA_EXP_POPUP_EXECUTE_TITLE'),
		content: '',
		resizable: true,
		draggable: true,
		height: 350,
		width: 500
	});
	DataExpPopupOzonConstructor.Open = function () {
		this.repeatDelay = dataExpExportTimeDelay && dataExpExportTimeDelay > 0 ? dataExpExportTimeDelay : 50;
		this.Stopped = false;
		//
		this.Show();
		this.LoadContent();
	}
	DataExpPopupOzonConstructor.LoadContent = function () {
		var thisPopup = this;
		//
		thisPopup.SetContent(BX.message('DATA_EXP_POPUP_LOADING'));
		// Set popup buttons
		thisPopup.SetNavButtons();
		//
		thisPopup.EnableControls();
		//
		dataExpAjax(['plugin_ajax_action', 'build_constructor'], '', function (JsonResult, textStatus, jqXHR) {

			$(thisPopup.PARTS.CONTENT_DATA).children('.bx-core-adm-dialog-content-wrap-inner').children().html(JsonResult.Text);
			$('.bx-core-adm-dialog-content-wrap-inner', thisPopup.DIV).css({
				'height': '100%',
				'-webkit-box-sizing': 'border-box',
				'-moz-box-sizing': 'border-box',
				'box-sizing': 'border-box'
			}).children().css({
				'height': '100%'
			});
			/*
			 $('input[type=checkbox]', thisPopup.PARTS.CONTENT).not('.no-checkbox-styling').each(function () {
			 BX.adminFormTools.modifyCheckbox(this);
			 });
			 var isError = (typeof JsonResult != 'object') || !JsonResult.Success;
			 if (isError) {
			 thisPopup.SetContent(BX.message('DATA_EXP_POPUP_EXECUTE_ERROR'));
			 }
			 dataExpHandleAjaxError(jqXHR, isError);
			 */
		}, function (jqXHR) {
			/*
			 thisPopup.SetContent(BX.message('DATA_EXP_POPUP_EXECUTE_ERROR'));
			 dataExpHandleAjaxError(jqXHR, true);*/
		}, true);
	}
	DataExpPopupOzonConstructor.SetNavButtons = function () {
		$(this.PARTS.BUTTONS_CONTAINER).html('');
		this.SetButtons(
				[{
						'name': BX.message('DATA_EXP_POPUP_EXECUTE_BUTTON_START'),
						'className': 'adm-btn-green',
						'id': 'data-exp-popup-execute-button-start',
						'action': function () {
							var thisPopup = this.parentWindow;
							thisPopup.Stopped = false;
							thisPopup.Execute({first: true});
						}
					}, {
						'name': BX.message('DATA_EXP_POPUP_EXECUTE_BUTTON_STOP'),
						'id': 'data-exp-popup-execute-button-stop',
						'action': function () {
							var thisPopup = this.parentWindow;
							thisPopup.Stop();
							thisPopup.SetContent(BX.message('DATA_EXP_POPUP_EXECUTE_STOPPED'));
						}
					}, {
						'name': BX.message('DATA_EXP_POPUP_CLOSE'),
						'id': 'data-exp-popup-execute-button-close',
						'action': function () {
							this.parentWindow.Close();
						}
					}]
				)
	}
	DataExpPopupOzonConstructor.DisableControls = function () {
		$('#data-exp-popup-execute-button-start', this.DIV).attr('disabled', 'disabled');
		$('#data-exp-popup-execute-button-stop', this.DIV).removeAttr('disabled');
	}
	DataExpPopupOzonConstructor.EnableControls = function () {
		$('#data-exp-popup-execute-button-start', this.DIV).removeAttr('disabled');
		$('#data-exp-popup-execute-button-stop', this.DIV).attr('disabled', 'disabled');
	}
	DataExpPopupOzonConstructor.Execute = function (requestData) {
		var thisPopup = this;
		if (!thisPopup.Stopped) {
			if (requestData == undefined) {
				requestData = {};
			}
			thisPopup.DisableControls();
			thisPopup.AjaxRequest = dataExpAjax('export_execute', requestData, function (JsonResult, textStatus, jqXHR) {

				$(thisPopup.PARTS.CONTENT_DATA).children('.bx-core-adm-dialog-content-wrap-inner').children().html(JsonResult.HTML);
				$('.bx-core-adm-dialog-content-wrap-inner', thisPopup.DIV).css({
					'height': '100%',
					'-webkit-box-sizing': 'border-box',
					'-moz-box-sizing': 'border-box',
					'box-sizing': 'border-box'
				}).children().css({
					'height': '100%'
				});
				setTimeout(function () {
					if (JsonResult.Repeat) {
						requestData.first = false;
						if (!thisPopup.Stopped) {
							thisPopup.Execute(requestData);
						}
					} else if (JsonResult.Success) {
						thisPopup.EnableControls();
						dataExpUpdateLogAndHistory();
					} else {
						if (JsonResult.ShowError == true) {
							if (JsonResult.HTML) {
								thisPopup.SetContent(JsonResult.HTML);
							} else {
								thisPopup.SetContent(BX.message('DATA_EXP_POPUP_EXECUTE_ERROR'));
							}
						}
						thisPopup.EnableControls();
					}
				}, thisPopup.repeatDelay);
				if (JsonResult.LockedHtml != undefined) {
					$('#data-exp-lock-notifier').html(JsonResult.LockedHtml);
				}
				dataExpHandleAjaxError(jqXHR, false);
			}, function (jqXHR) {
				thisPopup.SetContent(BX.message('DATA_EXP_POPUP_EXECUTE_ERROR'));
				dataExpHandleAjaxError(jqXHR, true);
				thisPopup.EnableControls();
			}, true);
		}
	}
	DataExpPopupOzonConstructor.Stop = function () {
		this.Stopped = true;
		this.EnableControls();
		if (this.AjaxRequest && this.AjaxRequest.readyState != 4) {
			this.AjaxRequest.abort();
		}
		// Unlock on stop
		dataExpAjax('profile_unlock', '', null, null, false, false);
	}
	BX.addCustomEvent('onWindowClose', function (popupWindow) {
		if (popupWindow == DataExpPopupOzonConstructor) {
			DataExpPopupOzonConstructor.Stop();
		}
	});
});