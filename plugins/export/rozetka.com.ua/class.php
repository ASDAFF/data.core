<?
/**
 * Data Core: Rozetka.com.ua plugin
 * @documentation https://rozetka.com.ua/sellerinfo/pricelist/
 */

namespace Data\Core\Export\Plugins;

use \Bitrix\Main\Localization\Loc,
	\Data\Core\Helper,
	\Data\Core\Export\Plugin,
	\Data\Core\Log;

Loc::loadMessages(__FILE__);

class RozetkaComUa extends Plugin {
	
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
		return 'ROZETKA_COM_UA';
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