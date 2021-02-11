<?
/**
 * Data Core: zakupki.mos.ru
 */

namespace Data\Core\Export\Plugins;

use
	\Bitrix\Main\Localization\Loc,
	\Data\Core\Helper,
	\Data\Core\Export\UniversalPlugin;

Loc::loadMessages(__FILE__);

require_once realpath(__DIR__ . '/../yandex.market/class.php');

abstract class ZakupkiMosRu extends UniversalPlugin {
	
	//
	
}

?>