<?php
namespace Acrit\Core;

use
	\Acrit\Core\Helper;

$arItems = [];

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$arItems['DEFAULT'] = function($strField, $mValue, $arParams=[]){
	?>
	<input type="text" size="50" name="f_<?=$strField;?>" value="<?=htmlspecialcharsbx($mValue);?>" />
	<?
};

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$arItems['SUBSTRING'] = function($strField, $mValue, $arParams=[]){
	?>
	<input type="text" size="50" name="f_<?=$strField;?>" value="<?=htmlspecialcharsbx($mValue);?>" />
	<?
};

$arItems['INTEGER'] = function($strField, $mValue, $arParams=[]){
	?>
	<input type="text" size="50" name="f_<?=$strField;?>" value="<?=htmlspecialcharsbx($mValue);?>" />
	<?
};

$arItems['SITE_ID'] = function($strField, $mValue, $arParams=[]){
	$arSites = array_map(function($arSite){
		return sprintf('%s [%s]', $arSite['SITE_NAME'], $arSite['ID'], $arSite['SERVER_NAME']);
	}, Helper::getSitesList());
	$arActiveValues = [
		'reference' => array_values($arSites),
		'reference_id' => array_keys($arSites),
	];
	print selectBoxFromArray('f_'.$strField, $arActiveValues, $mValue, Helper::getMessage('MAIN_ALL'), '');
};

$arItems['ACTIVE'] = function($strField, $mValue, $arParams=[]){
	$arValues = ['Y' => Helper::getMessage('MAIN_YES'), 'N' => Helper::getMessage('MAIN_NO')];
	$arActiveValues = [
		'reference' => array_values($arValues),
		'reference_id' => array_keys($arValues),
	];
	print selectBoxFromArray('f_'.$strField, $arActiveValues, $mValue, Helper::getMessage('MAIN_ALL'), '');
};

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$arItems['INTEGER_INTERVAL'] = function($strField, $mValue, $arParams=[]){
	$intValueMin = $GLOBALS['f_'.$strField.'_min'];
	$intValueMax = $GLOBALS['f_'.$strField.'_max'];
	?>
	<input type="text" size="10" name="f_<?=$strField;?>_min" value="<?=htmlspecialcharsbx($intValueMin);?>" />
	<input type="text" size="10" name="f_<?=$strField;?>_max" value="<?=htmlspecialcharsbx($intValueMax);?>" />
	<?
};

$arItems['DATE_INTERVAL'] = function($strField, $mValue, $arParams=[]){
	$strValueMin = $GLOBALS['f_'.$strField.'_min'];
	$strValueMax = $GLOBALS['f_'.$strField.'_max'];
	print \CAdminCalendar::calendarPeriod('f_'.$strField.'_min', 'f_'.$strField.'_max', 
		htmlspecialcharsbx($strValueMin), htmlspecialcharsbx($strValueMax), true, 15, true);
};

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
return $arItems;