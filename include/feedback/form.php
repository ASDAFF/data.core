<?
namespace Data\Core;

use
	\Data\Core\Helper;

if(!strlen($strEmailAdmin) || !check_email($strEmailAdmin)){
	$strEmailAdmin = reset(explode(',', \Bitrix\Main\Config\Option::get('main', 'email_from')));
}

$arTech = [
	'MODULE_CODE' => $strModuleId,
	'MODULE_VERSION' => Helper::getModuleVersion($strModuleId),
	'BITRIX_VERSION' => SM_VERSION,
	'BITRIX_VERSION_DATE' => SM_VERSION_DATE,
	'LICENCE_HASH' => md5('BITRIX'.LICENSE_KEY.'LICENCE'),
	'SITE_CHARSET' => SITE_CHARSET,
	'FORMAT_DATE' => FORMAT_DATE,
	'FORMAT_DATETIME' => FORMAT_DATETIME,
];
$arTechTmp = [];
foreach($arTech as $key => $value){
	$arTechTmp[] = Helper::getMessage('DATA_CORE_FEEDBACK_TECH_'.$key).': '.$value;
}
$strTech = implode("\r\n", $arTechTmp);

?>
<div id="data-core-feedback-form">
	<input type="hidden" value="<?=$strModuleId;?>" id="data-core-feedback-form-module" />
	<input type="hidden" value="<?=$strEmailAdmin;?>" id="data-core-feedback-form-email-admin" />
	<input type="hidden" value="<?=Helper::getMessage('DATA_CORE_FEEDBACK_SUBJECT', [
		'#MODULE_ID#' => $strModuleId,
	]);?>" id="data-core-feedback-form-subject" />
	<table>
		<tbody>
			<tr>
				<td>
					<?=Helper::getMessage('DATA_CORE_FEEDBACK_PROBLEM');?>:
				</td>
				<td>
					<textarea cols="50" rows="5"
						id="data-core-feedback-form-problem"
						placeholder="<?=Helper::getMessage('DATA_CORE_FEEDBACK_PROBLEM_PLACEHOLDER');?>"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<?=Helper::getMessage('DATA_CORE_FEEDBACK_NAME');?>:
				</td>
				<td>
					<input type="text" size="50" maxlength="250" value="<?=$GLOBALS['USER']->getFullName();?>"
						id="data-core-feedback-form-name"
						placeholder="<?=Helper::getMessage('DATA_CORE_FEEDBACK_NAME_PLACEHOLDER');?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?=Helper::getMessage('DATA_CORE_FEEDBACK_EMAIL');?>:
				</td>
				<td>
					<input type="text" size="50" maxlength="250" value="<?=$GLOBALS['USER']->getEmail();?>"
						id="data-core-feedback-form-email-user"
						placeholder="<?=Helper::getMessage('DATA_CORE_FEEDBACK_EMAIL_PLACEHOLDER');?>" />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div id="data-core-feedback-form-agree">
						<input type="checkbox" id="data-core-feedback-form-agree-checkbox" checked="checked" />
						<label for="data-core-feedback-form-agree-checkbox">
							<?=Helper::getMessage('DATA_CORE_FEEDBACK_AGREE');?>
						</label>
					</div>
					<table id="data-core-feedback-form-buttons">
						<tbody>
							<tr>
								<td>
									<a href="javascript:void(0);" class="adm-btn adm-btn-green" id="data-core-feedback-form-submit"
										data-success="<?=Helper::getMessage('DATA_CORE_FEEDBACK_SUCCESS');?>"
										data-error="<?=Helper::getMessage('DATA_CORE_FEEDBACK_ERROR');?>"
										data-agree="<?=Helper::getMessage('DATA_CORE_FEEDBACK_MUST_AGREE');?>"
										onclick="return dataCoreFeedbackFormSubmit();">
										<?=Helper::getMessage('DATA_CORE_FEEDBACK_SUBMIT');?>
									</a>
								</td>
								<td>
									<a href="javascript:void(0);" id="data-core-feedback-form-transmit"
										onclick="return dataCoreFeedbackFormTransmit();">
										<?=Helper::getMessage('DATA_CORE_FEEDBACK_TRANSMIT');?>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr id="data-core-feedback-form-tech">
				<td>
					<?=Helper::getMessage('DATA_CORE_FEEDBACK_TECH');?>:
				</td>
				<td>
					<textarea cols="50" rows="<?=count($arTechTmp);?>" readonly="readonly"
						id="data-core-feedback-form-tech-data"
						placeholder="<?=Helper::getMessage('DATA_CORE_FEEDBACK_TECH_PLACEHOLDER');?>"><?=$strTech;?></textarea>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<style>
	#data-core-feedback-form {
		max-width:600px;
	}
	#data-core-feedback-form table {
		width:100%;
	}
	#data-core-feedback-form table td {
		vertical-align:top;
	}
	#data-core-feedback-form table td:first-child {
		padding-right:5px;
		padding-top:5px;
		text-align:right;
		width:35%;
	}
	#data-core-feedback-form table td[colspan] {
		width:auto;
	}
	#data-core-feedback-form table td textarea {
		max-height:500px;
		min-height:100px;
		resize:vertical;
		width:100%;
		-webkit-box-sizing:border-box;
		   -moz-box-sizing:border-box;
            box-sizing:border-box;
	}
	#data-core-feedback-form table td textarea[readonly] {
		background:#eee;
		height:auto;
		max-height:none;
		min-height:0;
		opacity:1!important;
		resize:none;
	}
	#data-core-feedback-form table td input[type=text] {
		width:100%;
		-webkit-box-sizing:border-box;
		   -moz-box-sizing:border-box;
            box-sizing:border-box;
	}
	#data-core-feedback-form #data-core-feedback-form-agree {
		padding:10px 0;
	}
	#data-core-feedback-form #data-core-feedback-form-agree > * {
		vertical-align:middle;
	}
	#data-core-feedback-form #data-core-feedback-form-buttons {
		width:100%;
	}
	#data-core-feedback-form #data-core-feedback-form-buttons td {
		vertical-align:middle;
	}
	#data-core-feedback-form #data-core-feedback-form-buttons td:first-child{
		text-align:left;
	}
	#data-core-feedback-form #data-core-feedback-form-buttons td:last-child{
		text-align:right;
	}
	#data-core-feedback-form #data-core-feedback-form-submit[disabled] {
		opacity:0.4;
		pointer-events:none!important;
	}
	#data-core-feedback-form #data-core-feedback-form-transmit {
		border-bottom:1px dashed #2675d7;
		color:#2675d7;
		text-decoration:none;
	}
	#data-core-feedback-form #data-core-feedback-form-transmit:hover {
		border-bottom:0;
	}
	#data-core-feedback-form #data-core-feedback-form-transmit[disabled] {
		opacity:0.4;
		pointer-events:none!important;
	}
	#data-core-feedback-form #data-core-feedback-form-tech {
		display:none;
	}
	#data-core-feedback-form #data-core-feedback-form-tech.visible {
		display:table-row;
	}
	#data-core-feedback-form #data-core-feedback-form-tech td {
		padding-bottom:20px;
		padding-top:20px;
	}
	#data-core-feedback-form #data-core-feedback-form-tech-data[readonly][disabled]{
		opacity:0.4!important;
	}
</style>
<script src="/bitrix/js/data.core/feedback-form.js?<?=microtime(true);?>"></script>
