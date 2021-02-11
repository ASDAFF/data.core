<?
use \Bitrix\Main\EventManager;

$strModuleId = 'data.core';

/*** CORE ***/

// Add menu section
EventManager::getInstance()->registerEventHandler(
	'main',
	'OnBuildGlobalMenu',
	$strModuleId,
	'\Data\Core\EventHandler',
	'OnBuildGlobalMenu'
);

// Auto check updates
EventManager::getInstance()->registerEventHandler(
	'main',
	'OnAfterEpilog',
	$strModuleId,
	'\Data\Core\EventHandler',
	'OnAfterEpilog'
);

// Update modules
EventManager::getInstance()->registerEventHandler(
	'main',
	'OnModuleUpdate',
	$strModuleId,
	'\Data\Core\EventHandler',
	'OnModuleUpdate'
);

// Handler for GoogleTagManager
EventManager::getInstance()->registerEventHandler(
	'main',
	'OnEndBufferContent',
	$strModuleId,
	'\Data\Core\GoogleTagManager',
	'OnEndBufferContent'
);

// Handler for DynamicRemarketing
EventManager::getInstance()->registerEventHandler(
	'main',
	'OnEndBufferContent',
	$strModuleId,
	'\Data\Core\DynamicRemarketing',
	'OnEndBufferContent'
);

/*** EXPORT ***/

// Show 'Preview' on context panel in element edit page
EventManager::getInstance()->registerEventHandler(
	'main',
	'OnAdminContextMenuShow',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnAdminContextMenuShow'
);

// Handler element save for autogenerate
EventManager::getInstance()->registerEventHandler(
	'iblock',
	'OnAfterIBlockElementAdd',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnAfterIBlockElementAddUpdate'
);
EventManager::getInstance()->registerEventHandler(
	'iblock',
	'OnAfterIBlockElementUpdate',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnAfterIBlockElementAddUpdate'
);

// Handler properties save
EventManager::getInstance()->registerEventHandler(
	'iblock',
	'OnAfterIBlockElementSetPropertyValues',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnAfterIBlockElementSetPropertyValues'
);
EventManager::getInstance()->registerEventHandler(
	'iblock',
	'OnAfterIBlockElementSetPropertyValuesEx',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnAfterIBlockElementSetPropertyValues'
);

//Handler for save element in admin page /bitrix/admin/iblock_element_edit.php (there is the redirect)
EventManager::getInstance()->registerEventHandler(
	'main',
	'OnBeforeLocalRedirect',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnBeforeLocalRedirect'
);

// Handler for save product
EventManager::getInstance()->registerEventHandler(
	'catalog',
	'OnProductAdd',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnProductAddUpdate'
);
EventManager::getInstance()->registerEventHandler(
	'catalog',
	'OnProductUpdate',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnProductAddUpdate'
);

// Handler for save price
EventManager::getInstance()->registerEventHandler(
	'catalog',
	'OnPriceAdd',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnPriceAddUpdate'
);
EventManager::getInstance()->registerEventHandler(
	'catalog',
	'OnPriceUpdate',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnPriceAddUpdate'
);

// Handler for save product store data
EventManager::getInstance()->registerEventHandler(
	'catalog',
	'OnStoreProductAdd',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnStoreProductAddUpdate'
);
EventManager::getInstance()->registerEventHandler(
	'catalog',
	'OnStoreProductUpdate',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnStoreProductAddUpdate'
);

// Handler for delete element
EventManager::getInstance()->registerEventHandler(
	'iblock',
	'OnAfterIBlockElementDelete',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnAfterIBlockElementDelete'
);

// Handler for epilog, process all queue
EventManager::getInstance()->registerEventHandler(
	'main',
	'OnEpilog',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnEpilog'
);

// Handler section save for autogenerate
EventManager::getInstance()->registerEventHandler(
	'iblock',
	'OnAfterIBlockSectionUpdate',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnAfterIBlockSectionUpdate'
);

// Handler iblock save for autogenerate
EventManager::getInstance()->registerEventHandler(
	'iblock',
	'OnAfterIBlockUpdate',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnAfterIBlockUpdate'
);

// Handler iblock delete
EventManager::getInstance()->registerEventHandler(
	'iblock',
	'OnAfterIBlockDelete',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnAfterIBlockDelete'
);

// Handler for add discount (for discount recalculation)
EventManager::getInstance()->registerEventHandler(
	'sale',
	'DiscountOnAfterAdd',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'DiscountOnAfterAdd'
);

// Handler for update discount (for discount recalculation)
EventManager::getInstance()->registerEventHandler(
	'sale',
	'DiscountOnAfterUpdate',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'DiscountOnAfterUpdate'
);

// Handler for delete discount (for discount recalculation)
EventManager::getInstance()->registerEventHandler(
	'sale',
	'DiscountOnAfterDelete',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'DiscountOnAfterDelete'
);

// Handler for price add
EventManager::getInstance()->registerEventHandler(
	'catalog',
	'OnGroupAdd',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnGroupAdd'
);

// Handler for price update
EventManager::getInstance()->registerEventHandler(
	'catalog',
	'OnGroupUpdate',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnGroupUpdate'
);

// Handler for price delete
EventManager::getInstance()->registerEventHandler(
	'catalog',
	'OnGroupDelete',
	$strModuleId,
	'\Data\Core\Export\EventHandlerExport',
	'OnGroupDelete'
);

?>