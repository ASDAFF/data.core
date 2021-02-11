<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("acrit.core");

use Acrit\Core\Crm\Controller,
	Acrit\Core\Crm\Rest;

Controller::setModuleId($strModuleId);

$action = trim($_REQUEST['action'] ?? '');
$params = $_REQUEST['params'];
$result = [];
$result['status'] = 'error';
$result['log'] = [];

switch ($action) {
	// Reset connection
	case 'options_connect_reset':
		//// Reset placements and event handlers
		//$sync_active = Settings::get('active');
		//if ($sync_active) {
		//	Controller::removePortalPlacements();
		//	Controller::unregCrmHandlers();
		//}
		// Reset connection
		Rest::saveAuthInfo('');
		$result['status'] = 'ok';
		break;
}

echo \Bitrix\Main\Web\Json::encode($result);
