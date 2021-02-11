<?
/**
 * Data core
 * @package data.core
 * @copyright 2018 Data
 */
namespace Data\Core\Export;

use \Bitrix\Main\Localization\Loc,
	\Data\Core\Helper,
	\Data\Core\Export\Exporter,
	\Data\Core\DiscountRecalculation,
	\Data\Core\Export\ProfileTable as Profile,
	\Data\Core\Export\ProfileIBlockTable as ProfileIBlock,
	\Data\Core\Export\ProfileFieldTable as ProfileField,
	\Data\Core\Export\ProfileValueTable as ProfileValue,
	\Data\Core\Export\AdditionalFieldTable as AdditionalField,
	\Data\Core\Export\CategoryRedefinitionTable as CategoryRedefinition,
	\Data\Core\Export\ExportDataTable as ExportData;
	
Loc::loadMessages(__FILE__);

/**
 * Event handler
 */
class EventHandlerExport {

	/**
	 *	Add menu section
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'main',
				'OnBuildGlobalMenu',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnBuildGlobalMenu'
			);
	 */
	/*
	public static function OnBuildGlobalMenu(&$arGlobalMenu, &$arModuleMenu){
		global $obAdminMenu;
		if(is_array($obAdminMenu->aGlobalMenu) && key_exists('global_menu_data', $obAdminMenu->aGlobalMenu)){
			return;
		}
		$strDataMenuGroupName = Helper::getOption(DATA_CORE, 'datamenu_groupname');
		if(!strlen(trim($strDataMenuGroupName))){
			$strDataMenuGroupName = Loc::getMessage('DATAMENU_GROUPNAME_DEFAULT');
		}
		$aMenu = array(
			'menu_id' => 'data',
			'sort' => 150,
			'text' => $strDataMenuGroupName,
			'title' => Loc::getMessage('DATA_MENU_TITLE'),
			'icon' => 'clouds_menu_icon',
			'page_icon' => 'clouds_page_icon',
			'items_id' => 'global_menu_data',
			'items' => array()
		);
		$arGlobalMenu['global_menu_data'] = $aMenu;
	}
	*/
	
	/**
	 *	Show 'Preview' on context panel in element edit page
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'main',
				'OnAdminContextMenuShow',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnAdminContextMenuShow'
			);
	 */
	public static function OnAdminContextMenuShow(&$arItems){
		if(class_exists(__NAMESPACE__.'\Exporter')){
			$intElementID = IntVal($_GET['ID']);
			$strCurPage = $GLOBALS['APPLICATION']->GetCurPage(true);
			if(in_array($strCurPage, array('/bitrix/admin/iblock_element_edit.php', '/bitrix/admin/cat_product_edit.php'))) {
				if($intElementID > 0){
					\CJSCore::Init(['jquery', 'jquery2']);
					$obAsset = \Bitrix\Main\Page\Asset::GetInstance();
					#$GLOBALS['APPLICATION']->SetAdditionalCss('/bitrix/js/data.core/jquery.select2/select2.min.css');
					$GLOBALS['APPLICATION']->setAdditionalCss('/bitrix/js/'.DATA_CORE.'/jquery.select2/dist/css/select2.css');
					$obAsset->AddJs('/bitrix/js/data.core/jquery.data.hotkey.js');
					$obAsset->AddJs('/bitrix/js/data.core/export/preview_element.js');
					#$obAsset->AddJs('/bitrix/js/data.core/jquery.select2/select2.min.js');
					$obAsset->AddJs('/bitrix/js/'.DATA_CORE.'/jquery.select2/dist/js/select2.js');
					$strSelect2LangFile = Helper::isUtf() ? 'ru_utf8.js' : 'ru_cp1251.js';
					#$obAsset->AddJs('/bitrix/js/data.core/export/jquery.select2/'.$strSelect2LangFile);
					$obAsset->AddJs('/bitrix/js/'.DATA_CORE.'/jquery.select2/'.$strSelect2LangFile);
					$arExportModules = array_reverse(Exporter::getExportModules());
					foreach($arExportModules as $key => $strModuleId){
						if(!checkVersion(Helper::getModuleVersion($strModuleId), '8.0.0')){
							unset($arExportModules[$key]);
						}
					}
					$bSingle = count($arExportModules) == 1;
					$bSeveral = count($arExportModules) > 1;
					if($bSingle){
						foreach($arExportModules as $strModuleId){
							$arItems[] = array(
								'ICON' => 'data-exp-element-preview-button',
								'TEXT' => Loc::getMessage('DATA_EXP_EVENT_HANDLER_PREVIEW_BUTTON'),
								'ONCLICK' => 'DataExpPopupPreview.Open("'.$strModuleId.'", '.$intElementID.', \'\');',
							);
							break;
						}
					}
					elseif($bSeveral){
						$arSubmenu = [];
						foreach($arExportModules as $strModuleId){
							$arSubmenu[] = array(
								'ICON' => 'data-exp-'.$strModuleId.'-element-preview-button',
								'TEXT' => $strModuleId,
								'ONCLICK' => 'DataExpPopupPreview.Open("'.$strModuleId.'", '.$intElementID.', \'\');',
								'ICON' => 'view',
							);
						}
						$arItems[] = array(
							'ICON' => 'data-exp-element-preview-button',
							'TEXT' => Loc::getMessage('DATA_EXP_EVENT_HANDLER_PREVIEW_BUTTON'),
							'MENU' => $arSubmenu,
						);
					}
					// Text definitions for popup
					ob_start();
					?><script>
					BX.message({
						DATA_EXP_EVENT_HANDLER_PREVIEW_TITLE: '<?=Loc::getMessage('DATA_EXP_EVENT_HANDLER_PREVIEW_TITLE');?>',
						DATA_EXP_EVENT_HANDLER_PREVIEW_LOADING: '<?=Loc::getMessage('DATA_EXP_EVENT_HANDLER_PREVIEW_LOADING');?>',
						DATA_EXP_EVENT_HANDLER_PREVIEW_REFRESH: '<?=Loc::getMessage('DATA_EXP_EVENT_HANDLER_PREVIEW_REFRESH');?>',
						DATA_EXP_EVENT_HANDLER_PREVIEW_CLOSE: '<?=Loc::getMessage('DATA_EXP_EVENT_HANDLER_PREVIEW_CLOSE');?>'
					});
					window.dataExpPreviewProfileId = {};
					<?foreach($arExportModules as $strModuleId):?>
						<?$strParam = str_replace('.', '_', $strModuleId).'_'.Helper::PARAM_ELEMENT_PREVIEW;?>
						<?if($_GET[$strParam] == 'Y'):?>
							<?$strParam = str_replace('.', '_', $strModuleId).'_'.Helper::PARAM_ELEMENT_PROFILE_ID;?>
							<?$intProfileID = htmlspecialcharsbx($_GET[$strParam]);?>
							window.dataExpPreviewProfileId['<?=$strModuleId;?>'] = <?=IntVal($intProfileID);?>;
							$(document).ready(function(){
								setTimeout(function(){
									DataExpPopupPreview.Open('<?=$strModuleId;?>', '<?=$intElementID;?>', '<?=$intProfileID;?>');
								}, 500);
							});
						<?endif?>
					<?endforeach?>
					</script><?
					$strJs = ob_get_clean();
					$obAsset->AddString($strJs, true);
				}
			}
		}
	}
	
	/**
	 *	Handler element save for autogenerate
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'iblock',
				'OnAfterIBlockElementAdd',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnAfterIBlockElementAddUpdate'
			);
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'iblock',
				'OnAfterIBlockElementUpdate',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnAfterIBlockElementAddUpdate'
			);
	 */
	public static function OnAfterIBlockElementAddUpdate($arElementFields){
		if(class_exists(__NAMESPACE__.'\Exporter')){
			Exporter::addToQueue($arElementFields['ID'], $arElementFields['IBLOCK_ID']);
		}
	}
	
	/**
	 *	Handler properties save
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'iblock',
				'OnAfterIBlockElementSetPropertyValues',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnAfterIBlockElementSetPropertyValues'
			);
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'iblock',
				'OnAfterIBlockElementSetPropertyValuesEx',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnAfterIBlockElementSetPropertyValues'
			);
	 */
	public static function OnAfterIBlockElementSetPropertyValues($intElementID, $intIBlockID, $arPropertyValues, $mTrash){
		if(class_exists(__NAMESPACE__.'\Exporter')){
			Exporter::addToQueue($intElementID, $intIBlockID);
		}
	}
	
	/**
	 *	Handler for save element in admin page /bitrix/admin/iblock_element_edit.php (there is the redirect)
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'main',
				'OnBeforeLocalRedirect',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnBeforeLocalRedirect'
			);
	 */
	public static function OnBeforeLocalRedirect(&$strUrl, $bSkipSecurityCheck, $bExternal){
		# ToDo: учет $strUrl
		if(class_exists(__NAMESPACE__.'\Exporter')){
			Exporter::processQueue();
		}
	}
	
	/**
	 *	Handler for save product
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'catalog',
				'OnProductAdd',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnProductAddUpdate'
			);
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'catalog',
				'OnProductUpdate',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnProductAddUpdate'
			);
	 */
	public static function OnProductAddUpdate($intProductID, $arProduct){
		if(class_exists(__NAMESPACE__.'\Exporter')){
			Exporter::addToQueue($intProductID, $arProduct['IBLOCK_ID']);
		}
	}
	
	/**
	 *	Handler for save price
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'catalog',
				'OnPriceAdd',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnPriceAddUpdate'
			);
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'catalog',
				'OnPriceUpdate',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnPriceAddUpdate'
			);
	 */
	public static function OnPriceAddUpdate($intPriceID, $arPrice){
		if(class_exists(__NAMESPACE__.'\Exporter')){
			Exporter::addToQueue($arPrice['PRODUCT_ID']);
		}
	}
	
	/**
	 *	Handler for save product store data
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'catalog',
				'OnStoreProductAdd',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnStoreProductAddUpdate'
			);
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'catalog',
				'OnStoreProductUpdate',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnStoreProductAddUpdate'
			);
	 */
	public static function OnStoreProductAddUpdate($intStoreValueID, $arStoreValue){
		if(class_exists(__NAMESPACE__.'\Exporter')){
			Exporter::addToQueue($arStoreValue['PRODUCT_ID']);
		}
	}
	
	/**
	 *	Handler for delete element
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'iblock',
				'OnAfterIBlockElementDelete',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnAfterIBlockElementDelete'
			);
	 */
	public static function OnAfterIBlockElementDelete($arFields){
		if(class_exists(__NAMESPACE__.'\Exporter')){
			foreach(Exporter::getExportModules() as $strModuleId){
				Exporter::getInstance($strModuleId)->deleteElement($arFields['ID']);
			}
		}
	}
	
	/**
	 *	Handler for epilog, process all queue
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'main',
				'OnEpilog',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnEpilog'
			);
	 */
	public static function OnEpilog(){
		if(class_exists(__NAMESPACE__.'\Exporter')){
			Exporter::processQueue();
		}
	}
	
	// *** //
	
	/**
	 *	Handler section save for autogenerate
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'iblock',
				'OnAfterIBlockSectionUpdate',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnAfterIBlockSectionUpdate'
			);
	 */
	public static function OnAfterIBlockSectionUpdate($arSectionFields){
		if(class_exists(__NAMESPACE__.'\Exporter')){
			$intSectionID = IntVal($arSectionFields['ID']);
			$intIBlockID = IntVal($arSectionFields['IBLOCK_ID']);
			if($intIBlockID>0){
				$arModules = Exporter::getExportModules();
				foreach($arModules as $strModule){
					$arQuery = [
						'filter' => array(
							'ACTIVE' => 'Y',
							'AUTO_GENERATE' => 'Y',
						),
					];
					#$resProfiles = Profile::getList($arQuery);
					$resProfiles = Helper::call($strModule, 'Profile', 'getList', [$arQuery]);
					if($resProfiles){
						while($arProfile = $resProfiles->fetch()){
							$intProfileID = $arProfile['ID'];
							$arQuery = [
								'filter' => array(
									'PROFILE_ID' => $intProfileID,
									'IBLOCK_ID' => $intIBlockID,
									'TYPE' => 'FIELD',
									'VALUE' => 'SECTION__%',
								),
								'limit' => 1,
							];
							#$resValue = ProfileValue::getList($arQuery);
							$resValue = Helper::call($strModule, 'ProfileValue', 'getList', [$arQuery]);
							if($resValue) {
								if($resValue->fetch()){
									# Если есть значения "SECTION__", значит, нужно перестроить данные, т.е. удаляем старые записи по этому инфоблоку
									$arFilter = array(
										'IBLOCK_ID' => $intIBlockID,
										'SECTION_ID' => $intSectionID,
										'INCLUDE_SUBSECTIONS' => 'N',
									);
									$intPacketSize = 100;
									$arElementsID = array();
									$resElements = \CIBlockElement::GetList(array(), $arFilter, false, false, array('ID'));
									while($arElement = $resElements->getNext(false,false)){
										$arElementsID[] = $arElement['ID'];
										if(count($arElementsID) == $intPacketSize){
											#ExportData::deleteProfileElementsByID($intProfileID, $arElementsID);
											Helper::call($strModule, 'ExportData', 'deleteProfileElementsByID', [$intProfileID, $arElementsID]);
											$arElementsID = array();
										}
									}
									if(!empty($arElementsID)){
										#ExportData::deleteProfileElementsByID($intProfileID, $arElementsID);
										Helper::call($strModule, 'ExportData', 'deleteProfileElementsByID', [$intProfileID, $arElementsID]);
									}
								}
							}
						}
					}
				}
			}
		}
	}
	
	/**
	 *	Handler iblock save for autogenerate
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'iblock',
				'OnAfterIBlockUpdate',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnAfterIBlockUpdate'
			);
	 */
	public static function OnAfterIBlockUpdate($arIBlockFields){
		if(class_exists(__NAMESPACE__.'\Exporter')){
			$intIBlockID = IntVal($arIBlockFields['ID']);
			if($intIBlockID>0){
				foreach(Exporter::getExportModules() as $strModuleId){
					$arQuery = [
						'filter' => array(
							'ACTIVE' => 'Y',
							'AUTO_GENERATE' => 'Y',
						),
					];
					#$resProfiles = Profile::getList($arQuery);
					$resProfiles = Helper::call($strModuleId, 'Profile', 'getList', [$arQuery]);
					if($resProfiles){
						while($arProfile = $resProfiles->fetch()){
							$intProfileID = $arProfile['ID'];
							$arQuery = [
								'filter' => array(
									'PROFILE_ID' => $intProfileID,
									'IBLOCK_ID' => $intIBlockID,
									'TYPE' => 'FIELD',
									'VALUE' => 'IBLOCK__%',
								),
								'limit' => 1,
							];
							#$resValue = ProfileValue::getList($arQuery);
							$resValue = Helper::call($strModuleId, 'ProfileValue', 'getList', [$arQuery]);
							if($resValue){
								if($resValue->fetch()){
									# Если есть значения "IBLOCK__", значит, нужно перестроить данные, т.е. удаляем старые записи по этому инфоблоку
									#ExportData::deleteProfileElementsByIBlockID($intProfileID, $intIBlockID);
									Helper::call($strModuleId, 'ExportData', 'deleteProfileElementsByIBlockID', [$intProfileID, $intIBlockID]);
								}
							}
						}
					}
				}
			}
		}
	}
	
	/**
	 *	Handler iblock delete
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'iblock',
				'OnAfterIBlockDelete',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnAfterIBlockDelete'
			);
	 */
	public static function OnAfterIBlockDelete($intIBlockID){
		if(class_exists(__NAMESPACE__.'\Exporter')){
			if($intIBlockID>0){
				foreach(Exporter::getExportModules() as $strModuleId){
					# Delete settings for iblock
					$arQuery = [
						'filter' => array(
							'IBLOCK_ID' => $intIBlockID,
						),
						'select' => array(
							'ID',
						),
					];
					#$resProfileIBlocks = ProfileIBlock::getList($arQuery);
					$resProfileIBlocks = Helper::call($strModuleId, 'ProfileIBlock', 'getList', [$arQuery]);
					if($resProfileIBlocks){
						while($arProfileIBlock = $resProfileIBlocks->fetch()){
							#ProfileIBlock::delete($arProfileIBlock['ID']);
							Helper::call($strModuleId, 'ProfileIBlock', 'delete', [$arProfileIBlock['ID']]);
						}
					}
					# Delete fields
					$arQuery = [
						'filter' => array(
							'IBLOCK_ID' => $intIBlockID,
						),
						'select' => array(
							'ID',
						),
					];
					#$resItems = ProfileField::getList($arQuery);
					$resItems = Helper::call($strModuleId, 'ProfileField', 'getList', [$arQuery]);
					if($resItems){
						while($arItem = $resItems->fetch()){
							#ProfileField::delete($arItem['ID']);
							Helper::call($strModuleId, 'ProfileField', 'delete', [$arItem['ID']]);
						}
					}
					# Delete additional fields
					$arQuery = [
						'filter' => array(
							'IBLOCK_ID' => $intIBlockID,
						),
						'select' => array(
							'ID',
						),
					];
					#$resItems = AdditionalField::getList($arQuery);
					$resItems = Helper::call($strModuleId, 'AdditionalField', 'getList', [$arQuery]);
					if($resItems){
						while($arItem = $resItems->fetch()){
							#AdditionalField::delete($arItem['ID']);
							Helper::call($strModuleId, 'AdditionalField', 'delete', [$arItem['ID']]);
						}
					}
					# Delete values
					$arQuery = [
						'filter' => array(
							'IBLOCK_ID' => $intIBlockID,
						),
						'select' => array(
							'ID',
						),
					];
					#$resItems = ProfileValue::getList($arQuery);
					$resItems = Helper::call($strModuleId, 'ProfileValue', 'getList', [$arQuery]);
					if($resItems){
						while($arItem = $resItems->fetch()){
							#ProfileValue::delete($arItem['ID']);
							Helper::call($strModuleId, 'ProfileValue', 'delete', [$arItem['ID']]);
						}
					}
					# Delete category redefinitions
					$arQuery = [
						'filter' => array(
							'IBLOCK_ID' => $intIBlockID,
						),
						'select' => array(
							'ID',
						),
					];
					#$resItems = CategoryRedefinition::getList($arQuery);
					$resItems = Helper::call($strModuleId, 'CategoryRedefinition', 'getList', [$arQuery]);
					if($resItems){
						while($arItem = $resItems->fetch()){
							#CategoryRedefinition::delete($arItem['ID']);
							Helper::call($strModuleId, 'CategoryRedefinition', 'delete', [$arItem['ID']]);
						}
					}
				}
			}
		}
	}
	
	// *** //
	
	/**
	 *	Handler for add discount (for discount recalculation)
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'sale',
				'DiscountOnAfterAdd',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'DiscountOnAfterAdd'
			);
	 */
	public static function DiscountOnAfterAdd($arEvent){
		DiscountRecalculation::handleDiscountAction();
	}
	
	/**
	 *	Handler for update discount (for discount recalculation)
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'sale',
				'DiscountOnAfterUpdate',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'DiscountOnAfterUpdate'
			);
	 */
	public static function DiscountOnAfterUpdate($arEvent){
		DiscountRecalculation::handleDiscountAction();
	}
	
	/**
	 *	Handler for delete discount (for discount recalculation)
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'sale',
				'DiscountOnAfterDelete',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'DiscountOnAfterDelete'
			);
	 */
	public static function DiscountOnAfterDelete($arEvent){
		DiscountRecalculation::handleDiscountAction();
	}
	
	// *** //
	
	/**
	 *	Handler for price add
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'catalog',
				'OnGroupAdd',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnGroupAdd'
			);
	 */
	public static function OnGroupAdd($arEvent){
		DiscountRecalculation::handleDiscountAction();
	}
	
	/**
	 *	Handler for price update
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'catalog',
				'OnGroupUpdate',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnGroupUpdate'
			);
	 */
	public static function OnGroupUpdate($arEvent){
		DiscountRecalculation::handleDiscountAction();
	}
	
	/**
	 *	Handler for price delete
			\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
				'catalog',
				'OnGroupDelete',
				'data.core',
				'\Data\Core\Export\EventHandlerExport',
				'OnGroupDelete'
			);
	 */
	public static function OnGroupDelete($arEvent){
		DiscountRecalculation::handleDiscountAction();
	}

}
