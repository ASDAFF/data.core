<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application,
	Data\Core\Helper,
	Data\Core\Crm\Rest,
	Data\Core\Crm\CrmPortal,
	Data\Core\Crm\Controller,
	Data\Core\Crm\Settings;

CModule::IncludeModule("data.core");

Controller::setModuleId('data.exportproplus');

if (!$USER->IsAdmin()) {
	die();
}

$res = Rest::restToken($_REQUEST['code']);

// Add placements and event handlers
//$sync_active = Settings::get('active');
if (Controller::checkConnection() && $sync_active) {
//	Portal::regCrmHandlers();
//	Helper::setPortalPlacements();
}

if (!$res['error']) {
    LocalRedirect('/bitrix/admin/settings.php?lang='.LANGUAGE_ID.'&mid='.Controller::$MODULE_ID.'&data_exportproplus_tab_control_active_tab=crm');
}
else {
    echo 'Authorization error: ' . $res['error'];
}
