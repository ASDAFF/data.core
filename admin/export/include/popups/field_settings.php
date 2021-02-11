<?
namespace Data\Core\Export;

use \Bitrix\Main\Localization\Loc,
	\Data\Core\Helper,
	\Data\Core\Export\Field\Field;

Loc::loadMessages(__FILE__);

if(!Helper::isUtf()) {
	$arPost = Helper::convertEncoding($arPost);
}

$strFieldCode = $arPost['field_code'];
$strFieldType = $arPost['field_type'];
$strFieldName = $arPost['field_name'];

print Helper::showNote(Loc::getMessage('DATA_EXP_POPUP_FIELD_SETTINGS_NOTICE'), true).'<br/>';
?>

<form action="<?=POST_FORM_ACTION_URI;?>" method="post" data-role="popup-form">
<?
print $obPlugin->showFieldSettings($strFieldCode, $strFieldType, $strFieldName, $arPost, 'TOP');

if(strlen($strFieldType)) {
	$arFieldsAll = Field::getValueTypesStatic($strModuleId);
	$arField = $arFieldsAll[$strFieldType];
	if(is_array($arField) && strlen($arField['CLASS'])){
		$arCurrentParams = $arPost;
		foreach($obPlugin->getFields($intProfileID, $intIBlockID) as $obField){
			$obField->setModuleId($strModuleId);
			$obField->setPlugin($obPlugin);
			if($obField->getCode()==$strFieldCode){
				print $arField['CLASS']::showFieldSettings($obField, $strFieldCode, $strFieldName, $arPost);
			}
		}
	}
}

#$intAdditionalFieldID = AdditionalField::getIdFromCode($strFieldCode);
$intAdditionalFieldID = Helper::call($strModuleId, 'AdditionalField', 'getIdFromCode', [$strFieldCode]);
if($intAdditionalFieldID){
	print Helper::showHeading(Loc::getMessage('DATA_EXP_ADDITIONAL_FIELDS_ATTRIBUTES'));
	$arAttributes = $arPost['ADDITIONAL_ATTRIBUTES'];
	if(!is_array($arAttributes)){
		$arAttributes = array();
	}
	if(!is_array($arAttributes['NAME']) || !is_array($arAttributes['VALUE']) || count($arAttributes['NAME']) != count($arAttributes['VALUE'])){
		$arAttributes = array(
			'NAME' => array(),
			'VALUE' => array(),
		);
	}
	array_unshift($arAttributes['NAME'], '');
	array_unshift($arAttributes['VALUE'], '');
	?>
		<div>
			<table class="data-exp-table-additional-attributes">
				<tfoot>
					<tr>
						<td colspan="3">
							<input type="button" data-role="additional-attributes--add" 
								value="<?=Loc::getMessage('DATA_EXP_ADDITIONAL_FIELDS_ATTRIBUTES_ADD');?>" />
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?$bFirst = true;?>
					<?foreach($arAttributes['NAME'] as $key => $strAttrName):?>
						<?$strAttrValue = $arAttributes['VALUE'][$key];?>
						<tr<?if($bFirst):?> class="data-exp-table-additional-attributes-pattern" style="display:none" data-noserialize="Y" data-role="additional-attributes--pattern"<?endif?>>
							<td>
								<input type="text" name="ADDITIONAL_ATTRIBUTES[NAME][]" value="<?=htmlspecialcharsbx($strAttrName);?>" size="20" />
							</td>
							<td>
								<input type="text" name="ADDITIONAL_ATTRIBUTES[VALUE][]" value="<?=htmlspecialcharsbx($strAttrValue);?>" size="50" />
							</td>
							<td>
								<a href="#" title="<?=Loc::getMessage('DATA_EXP_ADDITIONAL_FIELDS_ATTRIBUTES_DELETE');?>"
									class="data-exp-table-additional-attributes-delete"
									data-role="additional-attributes--delete">&times;</a>
							</td>
						</tr>
						<?$bFirst = false;?>
					<?endforeach?>
					<tr class="data-exp-table-additional-attributes-nothing" style="display:none" data-role="additional-attributes--nothing">
						<td colspan="3"><?=Loc::getMessage('DATA_EXP_ADDITIONAL_FIELDS_ATTRIBUTES_EMPTY');?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<br/>
	<?
}

print $obPlugin->showFieldSettings($strFieldCode, $strFieldType, $strFieldName, $arPost, 'BOTTOM');
?>
<div style="display:none"><input type="submit" value="" /></div>
</form>
