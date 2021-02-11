<?
namespace Acrit\Core;

use
	\Acrit\Core\Helper;

$strModuleId = &$arVariables['MODULE_ID'];
$strModuleCodeFull = str_replace('.', '_', $strModuleId);
$obOptions = &$arVariables['THIS'];
$arOption = $arVariables['OPTION'];
$strOption = $arOption['CODE'];
$bWithTable = $arVariables['WITH_TABLE'] == 'Y';

$arOption['CODE'] = $strOption;
$arOption['VALUE'] = Helper::getOption($strModuleId, $strOption);
if(is_callable($arOption['CALLBACK_VALUE'])){
	call_user_func_array($arOption['CALLBACK_VALUE'], [$obOptions, &$arOption]);
}
$strValue = $arOption['VALUE'];
?>
<?if($bWithTable):?>
	<table class="adm-detail-content-table edit-table" id="acrit_core_table_<?=$strOption;?>">
<?endif?>
	<tr id="acrit_core_row_option_<?=$strOption;?>">
		<?if($arOption['FULL_WIDTH'] == 'Y'):?>
			<td colspan="2">
				<?
				if(is_callable($arOption['CALLBACK_MAIN'])){
					call_user_func_array($arOption['CALLBACK_MAIN'], [$obOptions, $arOption]);
				}
				?>
			</td>
		<?else:?>
			<td width="40%" class="adm-detail-content-cell-l"<?if($arOption['TOP'] == 'Y'):?> style="padding-top:10px; vertical-align:top;"<?endif?>>
				<?=Helper::showHint($arOption['HINT']);?>
				<label for="<?=$strModuleCodeFull;?>_option_<?=$strOption;?>">
					<?if($arOption['REQUIRED']):?>
						<b><?=$arOption['NAME'];?></b>:
					<?else:?>
						<?=$arOption['NAME'];?>:
					<?endif?>
				</label>
			</td>
			<td width="60%" class="adm-detail-content-cell-r">
				<?
				if(is_callable($arOption['CALLBACK_MAIN'])){
					call_user_func_array($arOption['CALLBACK_MAIN'], [$obOptions, $arOption]);
				}
				else{
					switch($arOption['TYPE']) {
						case 'text':
						case 'number':
						case 'email':
						case 'range':
						case 'password':
						case 'date':
							?>
							<input type="<?=$arOption['TYPE'];?>" name="<?=$strOption;?>" value="<?=$strValue;?>" <?=$arOption['ATTR'];?> 
								id="<?=$strModuleCodeFull;?>_option_<?=$strOption;?>" />
							<?
							break;
						case 'textarea':
							?>
							<textarea name="<?=$strOption;?>" <?=$arOption['ATTR'];?>
								id="<?=$strModuleCodeFull;?>_option_<?=$strOption;?>"><?=$strValue;?></textarea>
							<?
							break;
						case 'checkbox':
							if(stripos($arOption['ATTR'], 'disabled') !== false && !$arOption['PRESERVE_DISABLED_CHECKED']){
								$strValue = 'N';
							}
							?>
							<input type="hidden" name="<?=$strOption;?>" value="N" />
							<input type="checkbox" name="<?=$strOption;?>" value="Y" <?=$arOption['ATTR'];?>
								id="<?=$strModuleCodeFull;?>_option_<?=$strOption;?>"
								<?if($strValue=='Y'):?> checked="checked"<?endif?> />
							<?
							break;
						case 'select':
							?>
							<select name="<?=$strOption;?>"<?if($arOption['MULTIPLE'] == true):?> multiple="multiple"<?endif?>
								<?if($arOption['SIZE']):?> size="<?=$arOption['SIZE'];?>"<?endif?>>
								<?if(is_array($arOption['VALUES'])):?>
									<?foreach($arOption['VALUES'] as $strItemKey => $strItemValue):?>
										<option value="<?=$strItemKey;?>"
											<?if($strItemKey == $strValue):?> selected="selected"<?endif?>><?=$strItemValue;?></option>
									<?endforeach?>
								<?endif?>
							</select>
							<?
							break;
						case 'none':
						case 'custom':
							//
							break;
					}
				}
				if(is_callable($arOption['CALLBACK_MORE'])){
					print call_user_func_array($arOption['CALLBACK_MORE'], [$obOptions, $arOption]);
				}
				?>
			</td>
		<?endif?>
	</tr>
	<?
	if(is_callable($arOption['CALLBACK_BOTTOM'])){
		print call_user_func_array($arOption['CALLBACK_BOTTOM'], [$obOptions, $arOption]);
	}
	?>
<?if($bWithTable):?>
	</table>
<?endif?>