<?
/**
 * Acrit Core: Wildberries plugin
 */

namespace Acrit\Core\Export\Plugins;

use \Bitrix\Main\Localization\Loc,
	\Acrit\Core\Helper,
	\Acrit\Core\Export\Plugin,
	\Acrit\Core\Export\Field\Field,
	\Acrit\Core\HttpRequest,
	\Acrit\Core\Export\Filter,
	\Acrit\Core\Log,
	\Acrit\Core\Json;

Loc::loadMessages(__FILE__);

class Wildberries extends Plugin {

    CONST DATE_UPDATED = '2019-05-01';

	protected $strFileExt;

	/**
	 * Base constructor.
	 */
	public function __construct($strModuleId) {
		parent::__construct($strModuleId);
	}

	/* START OF BASE STATIC METHODS */

	/**
	 * Get plugin unique code ([A-Z_]+)
	 */
	public static function getCode() {
		return 'WILDBERRIES';
	}

	/**
	 * Get plugin short name
	 */
	public static function getName() {
		return static::getMessage('NAME');
	}
	
	/**
	 *	Include classes
	 */
	public function includeClasses(){
	}

	/**
	 *	Get list of supported currencies
	 */
	public function getSupportedCurrencies(){
		return array('RUB');
	}

	/* END OF BASE STATIC METHODS */

	/**
	 *	Show plugin settings
	 */
	public function showSettings(){
		// Show settings
		return $this->showDefaultSettings();
	}

	/**
	 *	Get adailable fields for current plugin
	 */
	public function getFields($intProfileID, $intIBlockID, $bAdmin=false){
		return array();
	}

	/**
	 *	Process single element
	 *	@return array
	 */
	public function processElement($arProfile, $intIBlockID, $arElement, $arFields) {
		// basically [in this class] do nothing, all business logic are in each format
	}

	/**
	 *	Get WB fields for identification
	 */

	public function getWBIDFields($intOrderId) {
		$arList = [];
		if ($intOrderId) {
            $arOrderRes = $this->request('new/' . $intOrderId);
			foreach ($arOrderRes['Data'][0]['Fields'] as $arItem) {
				$arList[$arItem['Id']] = $arItem['Name'].' ('.$arItem['Id'].')';
			}
		}
		return $arList;
	}

	/**
	 *	Custom ajax actions
	 */
	public function ajaxAction($strAction, $arParams, &$arJsonResult){
		$intProfileID = &$arParams['PROFILE_ID'];
//		switch($strAction){
//			case 'rest_test':
//				$arFilter = [
//					'order' => ["SORT" => "ASC"],
//					'filter' => [],
//				];
//				$arJsonResult = BitrixRest::executeMethod('crm.product.fields', $arFilter, $intProfileID, false);
//				break;
//		}
	}


	protected function request($method, $params=[], $type='get', $json=false) {
		$result = false;
		$token = $this->arProfile['PARAMS']['TOKEN'];
		if ($token) {
			$curl        = curl_init();
			$url         = "https://specifications.wildberries.ru/api/v1/Specification/" . $method;
			$headers[]   = 'Content-Type: application/json';
			$headers[]   = "X-Supplier-Cert-Serial:" . $token;
			$curl_params = [
				CURLOPT_HEADER         => 0,
				CURLOPT_HTTPHEADER     => $headers,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL            => $url,
			];
			$query_data  = http_build_query($params);
			if ($type == 'post') {
				$curl_params[CURLOPT_POST]       = 1;
				$curl_params[CURLOPT_POSTFIELDS] = $query_data;
			}
			 else {
				$curl_params[CURLOPT_URL] = $url . '?' . $query_data;
			}
			if ($json) {
				$curl_params[CURLOPT_POST]       = 1;
				$curl_params[CURLOPT_POSTFIELDS] = $json;
			}
			curl_setopt_array($curl, $curl_params);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec($curl);
			curl_close($curl);
			$result = json_decode($response, true);
			// Check errors
			if ($result['ResultCode']) {
				throw new \Exception($result['Message'], $result['ResultCode']);
			}
		}
		return $result;
	}

}

?>
