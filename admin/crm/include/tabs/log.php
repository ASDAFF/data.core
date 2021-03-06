<?
namespace Data\Core\Export;

use \Bitrix\Main\Localization\Loc,
	\Data\Core\Helper,
	\Data\Core\Log;

Loc::loadMessages(__FILE__);

$strLogPreview = Log::getInstance($strModuleId)->getLogPreview($intProfileID);

$strTextareaStyle = '';
if(!strlen($strLogPreview)){
	$strTextareaStyle .= 'height:20px;';
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Log
$obTabControl->BeginCustomField('PROFILE[LOG]', Loc::getMessage('DATA_EXP_TAB_LOG_LOG'));
?>
	<tr class="heading" id="tr_LOG_HEADING">
		<td colspan="2"><?=$obTabControl->GetCustomLabelHTML()?></td>
	</tr>
	<tr id="tr_LOG">
		<td>
			<div class="data-exp-log-wrapper">
				<div data-role="profile-log-export-file-name-hidden" style="display:none">
					<?if(is_object($obPlugin)):?>
						<?=$obPlugin->showFileOpenLink(false, true);?>
					<?endif?>
				</div>
				<?=Log::getInstance($strModuleId)->showLog($intProfileID);?>
			</div>
		</td>
	</tr>
<?
$obTabControl->EndCustomField('PROFILE[LOG]');

// History
$obTabControl->BeginCustomField('PROFILE[HISTORY]', Loc::getMessage('DATA_EXP_TAB_LOG_HISTORY'));
?>
	<tr>
		<td colspan="2"><br/></td>
	</tr>
	<tr class="heading" id="tr_HISTORY_HEADING">
		<td colspan="2"><?=$obTabControl->GetCustomLabelHTML()?></td>
	</tr>
	<tr id="tr_HISTORY">
		<td>
			<?require __DIR__.'/_log_history.php';?>
		</td>
	</tr>
<?
$obTabControl->EndCustomField('PROFILE[HISTORY]');
