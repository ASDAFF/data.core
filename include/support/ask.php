<?
namespace Acrit\Core\Export;

use
	\Bitrix\Main\Localization\Loc,
	\Acrit\Core\Helper;
?>
<?
$obTabControl->BeginCustomField('REQUIREMENTS_2', Helper::getMessage('ACRIT_CORE_REQUIREMENTS_2'));
?>
<tr class="heading"><td colspan="2"><?=$obTabControl->GetCustomLabelHTML()?></td></tr>
<tr>
	<td colspan="2">
		<div><?=Helper::getMessage('ACRIT_CORE_REQUIREMENTS_TEXT');?></div><br/>
	</td>
</tr>
<?
$obTabControl->EndCustomField('REQUIREMENTS_2');
?>
<?
//
$obTabControl->BeginCustomField('ASK_FORM', Helper::getMessage('ACRIT_CORE_ASK_FORM'));
?>
<tr class="heading"><td colspan="2"><?=$obTabControl->GetCustomLabelHTML()?></td></tr>
<tr>
	<td width="40%" class="adm-detail-content-cell-l" style="padding-top:10px; vertical-align:top;">
		<?=Helper::getMessage('ACRIT_CORE_ASK_FORM_EMAIL');?>
	</td>
	<td width="60%" class="adm-detail-content-cell-r">
		<div style="margin-bottom:6px;">
			<input type="email" style="width:96%;" data-role="ticket-email"
				value="<?=\Bitrix\Main\Config\Option::get('main', 'email_from');?>"
				data-error="<?=Helper::getMessage('ACRIT_CORE_ASK_FORM_ERROR_EMPTY_EMAIL');?>"
				data-incorrect="<?=Helper::getMessage('ACRIT_CORE_ASK_FORM_ERROR_WRONG_EMAIL');?>" />
		</div>
	</td>
</tr>
<tr>
	<td width="40%" class="adm-detail-content-cell-l" style="padding-top:10px; vertical-align:top;">
		<?=Helper::getMessage('ACRIT_CORE_ASK_FORM_SUBJECT');?>
	</td>
	<td width="60%" class="adm-detail-content-cell-r">
		<div style="margin-bottom:6px;">
			<input type="email" style="width:96%;" data-role="ticket-subject" value="<?=Helper::getMessage(
				'ACRIT_EXP_ASK_FORM_SUBJECT_DEFAULT', ['#SITE_NAME#' => Helper::getCurrentDomain()]);?>"
				data-error="<?=Helper::getMessage('ACRIT_CORE_ASK_FORM_ERROR_EMPTY_SUBJECT');?>" />
		</div>
	</td>
</tr>
<tr>
	<td width="40%" class="adm-detail-content-cell-l" style="padding-top:10px; vertical-align:top;">
		<?=Helper::getMessage('ACRIT_CORE_ASK_FORM_MESSAGE');?>
	</td>
	<td width="60%" class="adm-detail-content-cell-r">
		<div style="margin-bottom:6px;">
			<textarea cols="70" rows="10" style="resize:vertical; width:96%;" data-role="ticket-message"
				data-error="<?=Helper::getMessage('ACRIT_CORE_ASK_FORM_ERROR_EMPTY');?>"></textarea>
		</div>
	</td>
</tr>
<tr>
	<td width="40%" class="adm-detail-content-cell-l"></td>
	<td width="60%" class="adm-detail-content-cell-r">
		<div>
			<input type="button" value="<?=Helper::getMessage('ACRIT_CORE_ASK_FORM_BUTTON');?>" data-role="ticket-send" />
		</div>
	</td>
</tr>
<?
$obTabControl->EndCustomField('ASK_FORM');

//
$obTabControl->BeginCustomField('CONTACTS', Helper::getMessage('ACRIT_CORE_ASK_CONTACTS_TITLE'));
?>
<tr class="heading"><td colspan="2"><?=$obTabControl->GetCustomLabelHTML()?></td></tr>
<tr>
	<td colspan="2">
		<fieldset title="<?=$obTabControl->GetCustomLabelHTML()?>">
			<legend><?=$obTabControl->GetCustomLabelHTML()?></legend>
			<?=Helper::getMessage('ACRIT_CORE_ASK_CONTACTS_TEXT');?>
		</fieldset>
	</td>
</tr>
<?
$obTabControl->EndCustomField('CONTACTS');