<?
namespace Data\Core\Export\Plugins;

use \Bitrix\Main\Localization\Loc,
	\Data\Core\Helper;

Loc::loadMessages(__FILE__);

if(is_null($arProfile['PARAMS']['CUSTOM_CSV_FIELDS'])){
	$arProfile['PARAMS']['CUSTOM_CSV_FIELDS'] = $obPlugin->getDefaultFields();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// CSV structure for custom CSV
$obTabControl->BeginCustomField('PROFILE[CUSTOM_CSV_STRUCTURE]', Loc::getMessage('DATA_EXP_CSV_FIELD'));
?>
	<tr class="heading">
		<td colspan="2"><?=$obTabControl->GetCustomLabelHTML()?></td>
	</tr>
	<tr id="tr_CUSTOM_CSV_FIELDS">
		<td colspan="2">
			<div data-role="csv-structure-wrapper">
				<textarea class="data-exp-custom-csv-structure" name="PROFILE[PARAMS][CUSTOM_CSV_FIELDS]"
					placeholder="<?=Loc::getMessage('DATA_EXP_CSV_FIELD_PLACEHOLDER');?>" style="height:200px"><?
					print htmlspecialcharsbx($arProfile['PARAMS']['CUSTOM_CSV_FIELDS']);
				?></textarea>
			</div>
			<?=Helper::showNote(Loc::getMessage('DATA_EXP_CSV_FIELDS_NOTICE'));?>
		</td>
	</tr>
	<tr class="heading">
		<td colspan="2"><?=Loc::getMessage('DATA_EXP_CSV_ADDITIONAL_SETTINGS');?></td>
	</tr>
	<tr>
		<td width="40%">
			<?=Helper::showHint(Loc::getMessage('DATA_EXP_CSV_SEPARATOR_HINT'));?>
			<label for="data-exp-csv-separator"><?=Loc::getMessage('DATA_EXP_CSV_SEPARATOR');?>:</label>
		</td>
		<td width="60%">
			<?
			$arSeparators = array();
			foreach($obPlugin->getSeparators() as $strKey => $arSeparator){
				$arSeparators[$strKey] = $arSeparator['NAME'];
			}
			$arSeparators = array(
				'REFERENCE' => array_values($arSeparators),
				'REFERENCE_ID' => array_keys($arSeparators),
			);
			print SelectBoxFromArray('PROFILE[PARAMS][CUSTOM_CSV_SEPARATOR]', $arSeparators, 
				$arProfile['PARAMS']['CUSTOM_CSV_SEPARATOR'], '', '');
			?>
		</td>
	</tr>
	<tr>
		<td width="40%">
			<?=Helper::showHint(Loc::getMessage('DATA_EXP_CSV_LINE_TYPE_HINT'));?>
			<label for="data-exp-csv-add-header"><?=Loc::getMessage('DATA_EXP_CSV_LINE_TYPE');?>:</label>
		</td>
		<td width="60%">
			<?
			$arLineTypes = array();
			foreach($obPlugin->getLineTypes() as $strKey => $arLineType){
				$arLineTypes[$strKey] = $arLineType['NAME'];
			}
			$arLineTypes = array(
				'REFERENCE' => array_values($arLineTypes),
				'REFERENCE_ID' => array_keys($arLineTypes),
			);
			print SelectBoxFromArray('PROFILE[PARAMS][CUSTOM_CSV_LINE_TYPE]', $arLineTypes, 
				$arProfile['PARAMS']['CUSTOM_CSV_LINE_TYPE'], '', '');
			?>
		</td>
	</tr>
	<tr>
		<td width="40%">
			<?=Helper::showHint(Loc::getMessage('DATA_EXP_CSV_ADD_HEADER_HINT'));?>
			<label for="data-exp-csv-add-header"><?=Loc::getMessage('DATA_EXP_CSV_ADD_HEADER');?>:</label>
		</td>
		<td width="60%">
			<input type="hidden" value="N" name="PROFILE[PARAMS][CUSTOM_CSV_ADD_HEADER]" />
			<input type="checkbox" value="Y" name="PROFILE[PARAMS][CUSTOM_CSV_ADD_HEADER]" id="data-exp-csv-add-header"
				<?if($arProfile['PARAMS']['CUSTOM_CSV_ADD_HEADER']!='N'):?>checked="checked"<?endif?> 
				data-role="custom-csv-add-header" />
		</td>
	</tr>
	<tr>
		<td width="40%">
			<?=Helper::showHint(Loc::getMessage('DATA_EXP_CSV_EXTRA_QUOTES_HINT'));?>
			<label for="data-exp-csv-extra-quotes"><?=Loc::getMessage('DATA_EXP_CSV_EXTRA_QUOTES');?>:</label>
		</td>
		<td width="60%">
			<input type="hidden" value="N" name="PROFILE[PARAMS][CUSTOM_CSV_EXTRA_QUOTES]" />
			<input type="checkbox" value="Y" name="PROFILE[PARAMS][CUSTOM_CSV_EXTRA_QUOTES]" id="data-exp-csv-extra-quotes"
				<?if($arProfile['PARAMS']['CUSTOM_CSV_EXTRA_QUOTES']!='N'):?>checked="checked"<?endif?> 
				data-role="custom-csv-extra-quotes" />
		</td>
	</tr>
	<tr>
		<td width="40%">
			<?=Helper::showHint(Loc::getMessage('DATA_EXP_CSV_ADD_UTM_HINT'));?>
			<label for="data-exp-csv-add-utm"><?=Loc::getMessage('DATA_EXP_CSV_ADD_UTM');?>:</label>
		</td>
		<td width="60%">
			<input type="hidden" value="N" name="PROFILE[PARAMS][CUSTOM_CSV_ADD_UTM]" />
			<input type="checkbox" value="Y" name="PROFILE[PARAMS][CUSTOM_CSV_ADD_UTM]" id="data-exp-csv-add-utm"
				<?if($arProfile['PARAMS']['CUSTOM_CSV_ADD_UTM']=='Y'):?>checked="checked"<?endif?> 
				data-role="custom-csv-utm-toggle" />
		</td>
	</tr>
	<tr id="tr_CUSTOM_CSV_FIELDS">
		<td colspan="2">
			<?=Helper::showNote(Loc::getMessage('DATA_EXP_CSV_MS_EXCEL_NOTICE'));?>
		</td>
	</tr>
<?
$obTabControl->EndCustomField('PROFILE[CUSTOM_CSV_STRUCTURE]');

?>