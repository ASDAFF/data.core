<?php
namespace Data\Core\Export;

use
	\Bitrix\Main\Loader,
	\Data\Core\Helper,
	\Data\Core\Export\Exporter,
	\Data\Core\Cli,
	\Data\Core\Log;

define('DATA_EXP_CRON', true);
define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);

# Arguments
$arArguments = require(__DIR__.'/../../include/cli/parse_arguments.php');
if(isset($arArguments['site']) && strlen($arArguments['site'])){
	define('SITE_ID', $arArguments['site']);
}

# Get real document root
$_SERVER['DOCUMENT_ROOT'] = $DOCUMENT_ROOT = realpath(__DIR__.'/../../../../../');
if(preg_match('#^(.*?)/(bitrix|local)/modules/#', reset($argv), $arMatch)){
	$_SERVER['DOCUMENT_ROOT'] = $DOCUMENT_ROOT = $arMatch[1];
}

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/interface/init_admin.php');
set_time_limit(0);
ignore_user_abort(true);
$strCoreId = 'data.core';
if(Loader::includeModule($strCoreId)) {
	// Do
	if(!in_array($strModuleId, Exporter::getExportModules())){
		Log::getInstance($strCoreId)->add('No module found: '.$strModuleId.'.');
		return;
	}
	// Check if root
	if(Cli::isRoot()){
		Log::getInstance($strCoreId)->add(Loc::getMessage('DATA_EXP_ROOT_HALT_CYRILLIC'));
		print Loc::getMessage('DATA_EXP_ROOT_HALT_LATIN').PHP_EOL;
		return;
	}
	// Include module
	if(!Loader::includeModule($strModuleId)) {
		Log::getInstance($strCoreId)->add('Error using module: '.$strModuleId.'.');
		return;
	}
	Helper::setWaitTimeout();
	$obExporter = Exporter::getInstance($strModuleId);
	$obExporter->execute();
	unset($obExporter);
}
else {
	print 'Module '.$strCoreId.' is not installed.';
	return;
}
?>