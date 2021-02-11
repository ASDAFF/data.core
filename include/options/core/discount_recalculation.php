<?
namespace Data\Core\Export;

use
	\Bitrix\Main\Localization\Loc,
	\Data\Core\Helper;

Loc::loadMessages(__FILE__);

return [
	'NAME' => Loc::getMessage('DATA_CORE_OPTION_GROUP_DISCOUNT_RECALCULATION'),
	'HINT' => Loc::getMessage('DATA_CORE_OPTION_GROUP_DISCOUNT_RECALCULATION_HINT'),
	'OPTIONS' => [
		'discount_recalculation_enabled' => [
			'NAME' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_ENABLED'),
			'HINT' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_ENABLED_HINT'),
			'TYPE' => 'checkbox',
			'HEAD_DATA' => function(){
				?>
				<script>
				$(document).delegate('tr#data_exp_option_discount_recalculation_enabled input[type=checkbox]', 'change', function(e){
					$('tr#data_exp_option_discount_recalculation_calc_value').toggle($(this).is(':checked') && !$(this).is('[disabled]'));
					$('tr#data_exp_option_discount_recalculation_calc_discount').toggle($(this).is(':checked') && !$(this).is('[disabled]'));
					$('tr#data_exp_option_discount_recalculation_calc_percent').toggle($(this).is(':checked') && !$(this).is('[disabled]'));
					$('tr#data_exp_option_discount_recalculation_prices').toggle($(this).is(':checked') && !$(this).is('[disabled]'));
					$('tr#data_exp_option_discount_recalculation_iblocks').toggle($(this).is(':checked') && !$(this).is('[disabled]'));
				});
				</script>
				<?
			},
			'CALLBACK_SAVE' => function($obOptions, $arOption){
				\Data\Core\DiscountRecalculation::handleSaveOptions();
			},
		],
		'discount_recalculation_calc_value' => [
			'NAME' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_CALC_VALUE'),
			'HINT' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_CALC_VALUE_HINT'),
			'TYPE' => 'checkbox',
		],
		'discount_recalculation_calc_discount' => [
			'NAME' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_CALC_DISCOUNT'),
			'HINT' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_CALC_DISCOUNT_HINT'),
			'TYPE' => 'checkbox',
		],
		'discount_recalculation_calc_percent' => [
			'NAME' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_CALC_PERCENT'),
			'HINT' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_CALC_PERCENT_HINT'),
			'TYPE' => 'checkbox',
		],
		'discount_recalculation_calc_dates' => [
			'NAME' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_CALC_DATES'),
			'HINT' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_CALC_DATES_HINT'),
			'TYPE' => 'checkbox',
		],
		'discount_recalculation_prices' => [
			'NAME' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_PRICES'),
			'HINT' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_PRICES_HINT'),
			'CALLBACK_MAIN' => function($obOptions, $arOption){
				$arCurrentPrices = array_filter(explode(',', $arOption['VALUE']));
				?>
				<select name="<?=$arOption['CODE'];?>[]" multiple="multiple" size="5" style="min-width:200px;">
					<?foreach(Helper::getPriceList() as $arPrice):?>
						<option value="<?=$arPrice['ID'];?>"<?if(in_array($arPrice['ID'], $arCurrentPrices)):?> selected="selected"<?endif?>>[<?=$arPrice['ID'];?>, <?=$arPrice['NAME'];?>] <?=$arPrice['NAME_LANG'];?></option>
					<?endforeach?>
				</select>
				<?
			},
			'TOP' => 'Y',
			'REQUIRED' => true,
		],
		'discount_recalculation_iblocks' => [
			'NAME' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_IBLOCKS'),
			'HINT' => Loc::getMessage('DATA_CORE_OPTION_DISCOUNT_RECALCULATION_IBLOCKS_HINT'),
			'CALLBACK_MAIN' => function($obOptions, $arOption){
				print Helper::getHtmlObject(DATA_CORE, null, 'iblock_tree', 'default', [
					'CODE' => $arOption['CODE'],
					'VALUE' => $arOption['VALUE'],
					'MULTIPLE' => true,
					'SIZE' => 10,
					'MIN_WIDTH' => 350,
					'JUST_CATALOGS' => true,
				]);
			},
			'TOP' => 'Y',
			'REQUIRED' => true,
		],
	],
];
	
?>