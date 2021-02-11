<?
/**
 * Class to work with simple values in fields
 */

namespace Data\Core\Export\Field;

use \Bitrix\Main\Localization\Loc,
	\Data\Core\Helper,
	\Data\Core\Export\Field\Field;

class ValueSimple extends ValueBase {
	
	protected $strValueType; // just FIELD || CONST
	
	/**
	 *	Create
	 */
	public function __construct(){
		parent::__construct();
		$this->setMultiple(true);
	}
	
	/**
	 *	
	 */
	public static function getName(){
		return static::getMessage('NAME');
	}
	
	/**
	 *	
	 */
	public static function getCode(){
		return 'FIELD';
	}
	
	/**
	 *	
	 */
	public static function getSort(){
		return 10;
	}
	
	/**
	 *	Set type
	 */
	public function setValueType($strValueType){
		$this->strValueType = $strValueType; // just FIELD || CONST
	}
	
	/**
	 *	Show html-code for item
	 *	@return string [html]
	 */
	protected function displayItem(){
		ob_start();
		if(!is_array($this->arValues)){
			$this->arValues = array();
		}
		?>
		<div class="data-exp-field-value" data-role="field-value">
			<table>
				<tbody>
					<?foreach($this->arValues as $arValue):?>
						<?
						$bIsField = $arValue['TYPE']=='FIELD' ? true : false;
						?>
						<tr data-role="field-simple--value-item" data-type="<?if($bIsField):?>FIELD<?else:?>CONST<?endif?>">
							<td class="data-exp-field-value-select"<?if(strlen($this->strValueType)):?> style="display:none"<?endif?>>
								<select name="<?=static::INPUTNAME_DEFAULT;?>[<?=$this->intIBlockID;?>][<?=$this->strFieldCode;?>][type][<?=$this->strValueSuffix;?>][]" data-role="field-simple--value-type">
									<option value="FIELD"<?if($bIsField):?> selected="selected"<?endif?>><?=static::getMessage('TYPE_FIELD');?></option>
									<option value="CONST"<?if(!$bIsField):?> selected="selected"<?endif?>><?=static::getMessage('TYPE_CONST');?></option>
								</select>
							</td>
							<td class="data-exp-field-value-bottom-field">
								<input type="hidden" name="<?=static::INPUTNAME_DEFAULT;?>[<?=$this->intIBlockID;?>][<?=$this->strFieldCode;?>][value][<?=$this->strValueSuffix;?>][]" value="<?=(isset($arValue['VALUE'])?$arValue['VALUE']:'');?>" data-role="field-simple--value-value" />
								<table>
									<tbody>
										<tr>
											<td>
												<div class="data-exp-field-value-input">
													<input type="text" class="data-exp-input-value-title" name="<?=static::INPUTNAME_DEFAULT;?>[<?=$this->intIBlockID;?>][<?=$this->strFieldCode;?>][title][<?=$this->strValueSuffix;?>][]" value="<?=(isset($arValue['TITLE'])?$arValue['TITLE']:'');?>" data-role="field-simple--value-title" readonly="readonly" placeholder="<?=static::getMessage('TYPE_FIELD_PLACEHOLDER');?>" />
													<a href="#" class="data-exp-button-value-clear" data-role="field-simple--value-clear">&times;</a>
												</div>
											</td>
											<td class="data-exp-field-value-button-wrapper">
												&nbsp;
												<input type="button" value="" class="data-exp-button-value-select" data-role="field-simple--button-select-field" title="<?=static::getMessage('BUTTON_SELECT');?>" />
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td class="data-exp-field-value-bottom-const">
								<?$strConstValue = !$bIsField && isset($arValue['CONST']) ? $arValue['CONST'] : ''; ?>
								<?$arAllowedValues = $this->obField->getAllowedValues();?>
								<?$bAllowedValuesUseSelect = $this->obField->isAllowedValuesUseSelect();?>
								<?$bAllowedValuesAssociative = $this->obField->isAllowedValuesAssociative();?>
								<table>
									<tbody>
										<tr>
											<td>
												<?if($bAllowedValuesUseSelect && is_array($arAllowedValues) && !empty($arAllowedValues)):?>
													<select name="<?=static::INPUTNAME_DEFAULT;?>[<?=$this->intIBlockID;?>][<?=$this->strFieldCode;?>][const][<?=$this->strValueSuffix;?>][]" class="data-exp-select-const" data-role="field-simple--value-const-select">
														<?
															$bGroup = false;
															foreach($this->obField->getAllowedValues() as $strKey => $strValue){
																if(!$bAllowedValuesAssociative){
																	$strKey = $strValue;
																}
																if($this->obField->isAllowedValueItemGroup($strValue)){
																	if($bGroup){
																		print '</optgroup>';
																	}
																	print '<optgroup label="'.$strValue.'">';
																}
																else{
																	print sprintf('<option value="%s"%s>%s</option>', htmlspecialcharsbx($strKey), 
																		$strKey == $strConstValue ? ' selected="selected"' : '', $strValue);
																}
															}
															if($bGroup){
																print '</optgroup>';
															}
														?>
													</select>
												<?else:?>
													<textarea name="<?=static::INPUTNAME_DEFAULT;?>[<?=$this->intIBlockID;?>][<?=$this->strFieldCode;?>][const][<?=$this->strValueSuffix;?>][]" class="data-exp-textarea-line" data-role="field-simple--value-const" rows="1" placeholder="<?=static::getMessage('TYPE_CONST_PLACEHOLDER');?>"><?=htmlspecialcharsbx($strConstValue);?></textarea>
												<?endif?>
											</td>
											<td class="data-exp-field-value-button-wrapper">
												&nbsp;
												<?if(!is_array($arAllowedValues) || empty($arAllowedValues)):?>
													<input type="button" value="" class="data-exp-button-value-select" data-role="field-simple--button-select-const" title="<?=static::getMessage('BUTTON_SELECT');?>" />
												<?else:?>
													<input type="button" value="" class="data-exp-button-value-select" style="visibility:hidden;" />
												<?endif?>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							<?if($this->bMultiple):?>
								<?if(!$this->bHiddenParams):?>
									<td class="data-exp-field-value-button-wrapper">
										&nbsp;
										<input type="button" value="" class="data-exp-button-value-settings" data-role="field-simple--button-params" title="<?=static::getMessage('BUTTON_PARAMS');?>" />
										<input type="hidden" name="<?=static::INPUTNAME_DEFAULT;?>[<?=$this->intIBlockID;?>][<?=$this->strFieldCode;?>][params][<?=$this->strValueSuffix;?>][]" value="<?=Helper::compileParams($arValue['PARAMS']);?>" data-role="field-simple--value-params" />
									</td>
								<?else:?>
									<input type="hidden" name="<?=static::INPUTNAME_DEFAULT;?>[<?=$this->intIBlockID;?>][<?=$this->strFieldCode;?>][params][<?=$this->strValueSuffix;?>][]" value="<?=Helper::compileParams($arValue['PARAMS']);?>" data-role="field-simple--value-params" />
								<?endif?>
								<td class="data-exp-field-value-button-wrapper">
									&nbsp;
									<input type="button" value="..." class="data-exp-button-value-add" data-role="field-simple--value-add" title="<?=static::getMessage('BUTTON_ADD');?>" />
								</td>
								<td class="data-exp-field-value-delete" data-role="field-simple--value-delete">
									<a href="#" title="<?=static::getMessage('BUTTON_DELETE');?>">&times;</a>
								</td>
							<?endif?>
						</tr>
						<?if(!$this->bMultiple){break;}?>
					<?endforeach?>
				</tbody>
			</table>
		</div>
		<?
		return ob_get_clean();
	}
	
	/**
	 *	Display field
	 *	@return string [html]
	 */
	public function display(){
		return $this->displayItem();
	}
	
	/**
	 *	Process saved values!
	 */
	public function processValuesForElement(array $arElement, array $arProfile){
		$intProfileID = $arProfile['ID'];
		#
		$mResult = array();
		foreach($this->arValues as $arValue){
			$mResult[] = $this->processSingleValue($arValue, $arElement, $arProfile, $this->obField);
		}
		return $mResult;
	}
		
	
}

?>