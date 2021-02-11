function dataCoreFeedbackFormDisableControls(disabled){
	var controls = [
		'data-core-feedback-form-problem',
		'data-core-feedback-form-name',
		'data-core-feedback-form-email-user',
		'data-core-feedback-form-agree-checkbox',
		'data-core-feedback-form-submit',
		'data-core-feedback-form-transmit',
		'data-core-feedback-form-tech-data',
	];
	for(var i in controls){
		if(disabled){
			BX(controls[i]).setAttribute('disabled', 'disabled');
		}
		else{
			BX(controls[i]).removeAttribute('disabled');
		}
	}
}
function dataCoreFeedbackFormSubmit(){
	if(!BX('data-core-feedback-form-agree-checkbox').checked){
		alert(BX('data-core-feedback-form-submit').getAttribute('data-agree'));
		return false;
	}
	dataCoreFeedbackFormDisableControls(true);
	var ajax = BX.ajax.post(
		'/bitrix/admin/data_core_feedback.php?lang=ru&action=feedback_send',
		{
			module: BX('data-core-feedback-form-module').value,
			email_admin: BX('data-core-feedback-form-email-admin').value,
			subject: BX('data-core-feedback-form-subject').value,
			problem: BX('data-core-feedback-form-problem').value,
			name: BX('data-core-feedback-form-name').value,
			email_user: BX('data-core-feedback-form-email-user').value,
			tech: BX('data-core-feedback-form-tech-data').value,
			url: location.href
		},
		function(HTML){
			dataCoreFeedbackFormDisableControls(false);
			if(HTML == 'Y'){
				alert(BX('data-core-feedback-form-submit').getAttribute('data-success'));
			}
			else{
				alert(BX('data-core-feedback-form-submit').getAttribute('data-error'));
			}
		}
	);
	return false;
}
function dataCoreFeedbackFormTransmit(){
	BX.toggleClass(BX('data-core-feedback-form-tech'), 'visible');
	return false;
}
BX.adminFormTools.modifyCheckbox(BX('data-core-feedback-form-agree-checkbox'));