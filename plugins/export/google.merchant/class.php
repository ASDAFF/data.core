<?
/**
 * Data Core: Google merchant base plugin
 * @documentation https://support.google.com/merchants/answer/7052112?hl=ru
 */

namespace Data\Core\Export\Plugins;

use \Bitrix\Main\Localization\Loc,
	\Data\Core\Helper,
	\Data\Core\Export\Plugin,
	\Data\Core\Log;

Loc::loadMessages(__FILE__);

class GoogleMerchant extends Plugin {
	
	/**
	 * Base constructor.
	 */
	public function __construct($strModuleId) {
		parent::__construct($strModuleId);
	}
	
	/**
	 * Get plugin unique code ([A-Z_]+)
	 */
	public static function getCode() {
		return 'GOOGLE_MERCHANT';
	}
	
	/**
	 * Get plugin short name
	 */
	public static function getName() {
		return static::getMessage('NAME');
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
	public function processElement($arProfile, $intIBlockID, $arElement, $arFields){
		return parent::processElement($arProfile, $intIBlockID, $arElement, $arFields);
	}

}

?>