<?
namespace Data\Core;

use
	\Bitrix\Main\Localization\Loc,
	\Bitrix\Main\EventManager,
	\Bitrix\Main\Application,
	\Bitrix\Main\Config\Option;

define('DATA_CORE', 'data.core');
IncludeModuleLangFile(__FILE__);

$arAutoload = [
	# General
	'Data\Core\Helper' => 'lib/helper.php',
	'Data\Core\Cli' => 'lib/cli.php',
	'Data\Core\DirScanner' => 'lib/dirscanner.php',
	'Data\Core\DiscountRecalculation' => 'lib/discountrecalculation.php',
	'Data\Core\DynamicRemarketing' => 'lib/dynamicremarketing.php',
	'Data\Core\EventHandler' => 'lib/eventhandler.php',
	'Data\Core\GoogleTagManager' => 'lib/googletagmanager.php',
	'Data\Core\HttpRequest' => 'lib/httprequest.php',
	'Data\Core\Json' => 'lib/json.php',
	'Data\Core\Log' => 'lib/log.php',
	'Data\Core\Options' => 'lib/options.php',
	'Data\Core\Thread' => 'lib/thread.php',
	'Data\Core\Xml' => 'lib/xml.php',
	'Data\Core\Update' => 'lib/update.php',
	/*** EXPORT ***/
	# CurrencyConverter
	'Data\Core\Export\CurrencyConverter\Base' => 'lib/export/currencyconverter/base.php',
	# Field
	'Data\Core\Export\Field\Field' => 'lib/export/field/field.php',
	'Data\Core\Export\Field\ValueBase' => 'lib/export/field/valuebase.php',
	'Data\Core\Export\Field\ValueSimple' => 'lib/export/field/valuesimple.php',
	'Data\Core\Export\Field\ValueCondition' => 'lib/export/field/valuecondition.php',
	# Migrator
	'Data\Core\Export\Migrator\Manager' => 'lib/export/migrator/manager.php',
	'Data\Core\Export\Migrator\Base' => 'lib/export/migrator/base.php',
	'Data\Core\Export\Migrator\FilterConverter' => 'lib/export/migrator/filter_converter.php',
	# Settings
	'Data\Core\Export\Settings\SettingsBase' => 'lib/export/settings/base.php',
	# Other
	'Data\Core\Export\AdditionalFieldTable' => 'lib/export/additionalfield.php',
	'Data\Core\Export\Backup' => 'lib/export/backup.php',
	'Data\Core\Export\CategoryCustomNameTable' => 'lib/export/categorycustomname.php',
	'Data\Core\Export\CategoryRedefinitionTable' => 'lib/export/categoryredefinition.php',
	'Data\Core\Export\Debug' => 'lib/export/debug.php',
	'Data\Core\Export\EventHandlerExport' => 'lib/export/eventhandler.php',
	'Data\Core\Export\ExportDataTable' => 'lib/export/exportdata.php',
	'Data\Core\Export\Exporter' => 'lib/export/exporter.php',
	'Data\Core\Export\ExternalIdTable' => 'lib/export/externalid.php',
	'Data\Core\Export\Filter' => 'lib/export/filter.php',
	'Data\Core\Export\HistoryTable' => 'lib/export/history.php',
	'Data\Core\Export\IBlockElementSubQuery' => 'lib/export/iblockelementsubquery.php',
	'Data\Core\Export\PluginManager' => 'lib/export/pluginmanager.php',
	'Data\Core\Export\Plugin' => 'lib/export/plugin.php',
	'Data\Core\Export\UniversalPlugin' => 'lib/export/universalplugin.php',
	'Data\Core\Export\ProfileTable' => 'lib/export/profile.php',
	'Data\Core\Export\ProfileFieldTable' => 'lib/export/profilefield.php',
	'Data\Core\Export\ProfileFieldFeature' => 'lib/export/profilefieldfeature.php',
	'Data\Core\Export\ProfileIBlockTable' => 'lib/export/profileiblock.php',
	'Data\Core\Export\ProfileValueTable' => 'lib/export/profilevalue.php',
	/*** SEO ***/
	'Data\Core\Seo\GooglePageSpeedV5' => 'lib/seo/googlepagespeedv5.php',
	/*** CRM INTEGRATION ***/
	'Data\Core\Crm\ProfilesTable' => 'lib/crm/profiles.php',
];
\Bitrix\Main\Loader::registerAutoLoadClasses(DATA_CORE, $arAutoload);
$GLOBALS['DATA_CORE_AUTOLOAD_CLASSES'] = &$arAutoload;

# Antiroot
if(Helper::getOption(DATA_CORE, 'warn_if_root') != 'N'){
	if(Cli::isCli() && Cli::isRoot()){
		Helper::obRestart();
		$strMessage = 'This script cannot be run in root mode.';
		Log::getInstance(DATA_CORE)->add($strMessage.' ['.implode(' ', $_SERVER['argv']).']');
		print $strMessage.PHP_EOL;
		Helper::addNotify(DATA_CORE, Helper::getMessage('DATA_CORE_ROOT_NOTIFY', [
			'#DATETIME#' => date(\CDatabase::dateFormatToPhp(FORMAT_DATETIME)),
			'#SCRIPT_NAME#' => is_array($_SERVER['argv']) ? implode(' ', $_SERVER['argv']) : $_SERVER['SCRIPT_NAME'],
			'#LANGUAGE_ID#' => LANGUAGE_ID,
		]), 'ROOT_NOTIFY');
		die();
	}
}

/*
# JS: Log
\CJSCore::registerExt(
	'data-core-log',
	array(
		'js' => '/bitrix/js/'.DATA_CORE.'/log.js',
	)
);
# JS: updater for each module
\CJSCore::registerExt(
	'data-core-update-module',
	array(
		'js' => '/bitrix/js/'.DATA_CORE.'/check_updates.js',
	)
);
*/

?>