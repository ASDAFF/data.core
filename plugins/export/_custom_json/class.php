<?
/**
 * Data Core: JSON base plugin
 */

namespace Data\Core\Export\Plugins;

use \Data\Core\Helper,
	\Data\Core\Export\UniversalPlugin;

abstract class CustomJson extends UniversalPlugin {
	
	/**
	 *	Show notices
	 */
	public function showMessages(){
		print Helper::showNote(static::getMessage('NOTICE_SUPPORT'), true);
	}
	
}

?>