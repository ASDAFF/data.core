<?
// $ModuleID must be set before this script include!
global $APPLICATION, $USER, $MESS;

$MESS['DATA_MODULE_DEMO_NOTICE'] = '<div style="color:red;display:block;"><b>Модуль <a href="https://www.data-studio.ru/module_redirect.php?module='.$strModuleId.'" target="_blank" style="color:red;">#MODULE_NAME#</a> работает в демонстрационном режиме.</b></div><div style="display:block;">До завершения демо-режима осталось <b>#DAYS#</b>.</div><div style="display:block;">После завершения демо-режима модуль перестанет функционировать.</div><div style="display:block;">Для снятия ограничений необходимо <a href="https://www.data-studio.ru/module_buy.php?module='.$strModuleId.'" target="_blank">приобрести лицензию</a>.</div>';
$MESS['DATA_MODULE_EXPIRED'] = '<div style="color:red"><b>Демонстрационный срок работы модуля <a href="https://www.data-studio.ru/module_redirect.php?module='.$strModuleId.'" target="_blank" style="color:red">#MODULE_NAME#</a> завершен.</b></div><div>Для продолжения работы модуля необходимо <a href="https://www.data-studio.ru/module_redirect.php?module='.$strModuleId.'" target="_blank">приобрести лицензию</a>.</div>';
$MESS['DATA_MODULE_DAYS'] = ',день,дня,,,дней';

if(!(defined('BX_UTF') && BX_UTF)) {
	$MESS['DATA_MODULE_DEMO_NOTICE'] = $APPLICATION->ConvertCharset($MESS['DATA_MODULE_DEMO_NOTICE'], 'UTF-8', 'CP1251');
	$MESS['DATA_MODULE_EXPIRED'] = $APPLICATION->ConvertCharset($MESS['DATA_MODULE_EXPIRED'], 'UTF-8', 'CP1251');
	$MESS['DATA_MODULE_DAYS'] = $APPLICATION->ConvertCharset($MESS['DATA_MODULE_DAYS'], 'UTF-8', 'CP1251');
}

$strModuleId_ = str_replace('.', '_', $strModuleId);
$strModuleName = $strModuleId;
require_once(__DIR__.'/../../'.$strModuleId.'/install/index.php');
$obModule = new $strModuleId_();
$strModuleName = $obModule->MODULE_NAME;
unset($obModule);
$MESS['DATA_MODULE_DEMO_NOTICE'] = str_replace('#MODULE_NAME#', $strModuleName, $MESS['DATA_MODULE_DEMO_NOTICE']);
$MESS['DATA_MODULE_EXPIRED'] = str_replace('#MODULE_NAME#', $strModuleName, $MESS['DATA_MODULE_EXPIRED']);

$bExpired = false;

if(!function_exists('DataModuleWordForm')) {
	function DataModuleWordForm($Value, $arWord) {
		$Value = trim($Value);
		$LastSymbol = substr($Value,-1);
		$SubLastSymbol = substr($Value,-2,1);
		if (strlen($Value)>=2 && $SubLastSymbol == '1')
			return $arWord['5'];
		elseif ($LastSymbol=='1')
			return $arWord['1'];
		elseif ($LastSymbol >= 2 && $LastSymbol <= 4)
			return $arWord['2'];
		else
			return $arWord['5'];
	}
}

function dataShowDemoNote($strMessage){
	$strId = 'id_'.randString(32);
	print '<style>#'.$strId.' {margin-top:-5px;} #'.$strId.' > .adm-info-message-wrap > .adm-info-message {margin-top:0;}</style>';
	print '<div id="'.$strId.'">';
	print BeginNote();
	print $strMessage;
	print EndNote();
	print '</div>';
}

function dataShowDemoNotice($strModuleId){
	$intMode = \CModule::IncludeModuleEx($strModuleId);
	$strModuleId_ = str_replace('.','_',$strModuleId);
	if ($intMode === MODULE_DEMO) {
		$Now = time();
		if(defined($strModuleId_.'_OLDSITEEXPIREDATE') && $Now < constant($strModuleId_.'_OLDSITEEXPIREDATE')) {
			$arExpire = getdate(constant($strModuleId_.'_OLDSITEEXPIREDATE'));
			$arNow = getdate($Now);
			$intExpireDate = gmmktime($arExpire['hours'],$arExpire['minutes'],$arExpire['seconds'],$arExpire['mon'],$arExpire['mday'],$arExpire['year']);
			$intNowDate = gmmktime($arExpire['hours'],$arExpire['minutes'],$arExpire['seconds'],$arNow['mon'],$arNow['mday'],$arNow['year']);
			$intDays = ($intExpireDate-$intNowDate)/86400;
			dataShowDemoNote(GetMessage('DATA_MODULE_DEMO_NOTICE',array('#DAYS#'=>$intDays.' '.DataModuleWordForm($intDays,explode(',',GetMessage('DATA_MODULE_DAYS'))))));
		}
	}
}

function dataShowDemoExpired($strModuleId){
	global $USER, $APPLICATION, $adminPage, $adminMenu, $adminChain, $SiteExpireDate;
	$intMode = \CModule::IncludeModuleEx($strModuleId);
	$strModuleId_ = str_replace('.','_',$strModuleId);
	if ($intMode === MODULE_DEMO) {
		$Now = time();
		if(!(defined($strModuleId_.'_OLDSITEEXPIREDATE') && $Now < constant($strModuleId_.'_OLDSITEEXPIREDATE'))) {
			$bExpired = true;
		}
	}
	if ($intMode === MODULE_DEMO_EXPIRED || $bExpired) {
		require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php');
		dataShowDemoNote(GetMessage('DATA_MODULE_EXPIRED'));
		require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_admin.php');
		die();
	}
}

?>