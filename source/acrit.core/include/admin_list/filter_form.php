<?php
namespace Acrit\Core;

use
	\Acrit\Core\Helper;

$arCheck = [
	is_array($arParams['FIELDS']) && !empty($arParams['FIELDS']),
	!!strlen($arParams['CLASS']) && class_exists($arParams['CLASS']),
	!!strlen($arParams['ADMIN_LIST_ID']),
];
if(array_unique($arCheck) !== [true]){
	return;
}

# Prepare fields
$arFieldsAll = Helper::getEntityFields($arParams['CLASS']);
$arFields = [];
foreach($arParams['FIELDS'] as $strField => $strHandler){
	$arFields[$strField] = array_merge($arFieldsAll[$strField], ['HANDLER' => $strHandler]);
}

# Handler
$arHandlers = require __DIR__.'/filter_items.php';

# Create filter
$obFilter = new \CAdminFilter($arParams['ADMIN_LIST_ID'].'_filter', array_column($arFields, 'TITLE'));
?>
<form name="find_form" method="get" action="<?=$APPLICATION->GetCurPage();?>">
	<?$obFilter->begin();?>
	<?foreach($arFields as $strField => $arField):?>
		<tr>
			<td><b><?=$arField['TITLE'];?>:</b></td>
			<td>
				<?
				$strHandler = $arField['HANDLER'];
				if($strHandler === true){
					#P($arField);
				}
				
				
				$arHandlers[$arField['HANDLER']] ? $arField['HANDLER'] : 'DEFAULT';
				$mValue = $GLOBALS['f_'.$strField];
				call_user_func_array($arHandlers[$strHandler], [$strField, $mValue, $arFieldParams]);
				?>
			</td>
		</tr>
	<?endforeach?>
	<?/*
	<tr>
		<td><?=Helper::getMessage($strLang.'FILTER_ACTIVE')?>:</td>
		<td>
			<?
			$arActiveValues = array(
				'reference' => array(
					Helper::getMessage('MAIN_YES'),
					Helper::getMessage('MAIN_NO'),
				),
				'reference_id' => array('Y', 'N'),
			);
			print SelectBoxFromArray('find_ACTIVE', $arActiveValues, $find_ACTIVE, Helper::getMessage('MAIN_ALL'), '');
			?>
		</td>
	</tr>
	<tr>
		<td><?=Helper::getMessage($strLang.'FILTER_LOCKED')?>:</td>
		<td>
			<?
			$arActiveValues = array(
				'reference' => array(
					Helper::getMessage('MAIN_YES'),
					Helper::getMessage('MAIN_NO'),
				),
				'reference_id' => array('Y', 'N'),
			);
			print SelectBoxFromArray('find_LOCKED', $arActiveValues, $find_LOCKED, Helper::getMessage('MAIN_ALL'), '');
			?>
		</td>
	</tr>
	*/?>
	<?$obFilter->buttons(['table_id' => $arParams['ADMIN_LIST_ID'], 'url' => $APPLICATION->GetCurPage(), 'form' => 'filter_form']);?>
	<?$obFilter->end();?>
</form>
