<?
/**
 *	Class to work with handlers
 */

namespace Data\Core;

use
	\Data\Core\Helper,
	\Data\Core\Update;
	
Helper::loadMessages(__FILE__);

/**
 * Event handler
 */
class EventHandler {

	/**
	 *	Add menu section
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'main',
				'OnBuildGlobalMenu',
				$strModuleId,
				'\Data\Core\EventHandler',
				'OnBuildGlobalMenu'
			);
	 */
	public static function OnBuildGlobalMenu(&$arGlobalMenu, &$arModuleMenu){
		global $obAdminMenu, $APPLICATION;
		if(is_array($obAdminMenu->aGlobalMenu) && key_exists('global_menu_data', $obAdminMenu->aGlobalMenu)){
			return;
		}
		#
		$strDataMenuGroupName = Helper::getOption(DATA_CORE, 'datamenu_group_name');
		$strDataMenuGroupSort = Helper::getOption(DATA_CORE, 'datamenu_group_sort');
		$strDataMenuGroupImage = Helper::getOption(DATA_CORE, 'datamenu_group_image');
		#
		if(!strlen($strDataMenuGroupName)){
			$strDataMenuGroupName = Helper::getMessage('DATAMENU_GROUP_NAME_DEFAULT');
		}
		if(!is_numeric($strDataMenuGroupSort) || $strDataMenuGroupSort <= 0){
			$strDataMenuGroupSort = 150;
		}
		if(strlen($strDataMenuGroupImage)){
			$APPLICATION->addHeadString('<style>
				.adm-main-menu-item.adm-data .adm-main-menu-item-icon{
					background:url("'.$strDataMenuGroupImage.'") center center no-repeat;
				}
			</style>');
		}
		#
		$aMenu = array(
			'menu_id' => 'data',
			'sort' => $strDataMenuGroupSort,
			'text' => $strDataMenuGroupName,
			'icon' => 'clouds_menu_icon',
			'page_icon' => 'clouds_page_icon',
			'items_id' => 'global_menu_data',
			'items' => array()
		);
		$arGlobalMenu['global_menu_data'] = $aMenu;
	}
	
	/**
	 *	
	 */
	public static function onAfterEpilog(){
		Update::onAfterEpilog();
		# Auto start access check
		if(defined('ADMIN_SECTION')){
			if($GLOBALS['APPLICATION']->getCurPage() == '/bitrix/admin/site_checker.php'){
				if($_GET['tabControl_active_tab'] == 'edit2'){
					print('<script>
						BX.fireEvent(BX("access_submit"), "click");
					</script>');
				}
			}
		}
	}
	
	/**
	 *	
	 */
	public static function onModuleUpdate($arModules){
		Update::onModuleUpdate($arModules);
	}

}
