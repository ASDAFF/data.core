<?
namespace Acrit\Core;

use
	\Bitrix\Main\Localization\Loc,
	\Acrit\Core\Helper;

// Core (part 1)
$strCoreId = 'acrit.core';
$strModuleId = $ModuleID = preg_replace('#^.*?/([a-z0-9]+)_([a-z0-9]+).*?$#', '$1.$2', $_SERVER['REQUEST_URI']);
$strModuleCode = preg_replace('#^(.*?)\.(.*?)$#', '$2', $strModuleId);
$strModuleUnderscore = preg_replace('#^(.*?)\.(.*?)$#', '$1_$2', $strModuleId);
define('ADMIN_MODULE_NAME', $strModuleId);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$strModuleId.'/prolog.php');
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$strCoreId.'/install/demo.php');
IncludeModuleLangFile(__FILE__);
\CJSCore::Init(array('jquery','jquery2'));

// Check rights
if($APPLICATION->GetGroupRight($strModuleId) == 'D'){
	$APPLICATION->authForm(Loc::getMessage('ACCESS_DENIED'));
}

// Input data
$obGet = \Bitrix\Main\Context::getCurrent()->getRequest()->getQueryList();
$arGet = $obGet->toArray();
$obPost = \Bitrix\Main\Context::getCurrent()->getRequest()->getPostList();
$arPost = $obPost->toArray();

// Demo
acritShowDemoExpired($strModuleId);

// Page title
$strPageTitle = Loc::getMessage('ACRIT_CORE_PAGE_TITLE_SUPPORT');

// Core notice
if(!\Bitrix\Main\Loader::includeModule($strCoreId)){
	require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php');
	?><div id="acrit-core-notifier"><?
		print '<div style="margin-top:15px;"></div>';
		print \CAdminMessage::ShowMessage(array(
			'MESSAGE' => \Bitrix\Main\Localization\Loc::getMessage('ACRIT_CORE_NOTICE', [
				'#CORE_ID#' => $strCoreId,
				'#LANG#' => LANGUAGE_ID,
			]),
			'HTML' => true,
		));
	?></div><?
	$APPLICATION->SetTitle($strPageTitle);
	die();
}

// Module
\Bitrix\Main\Loader::includeModule($strModuleId);
$strModuleName = Helper::getModuleName($strModuleId);

// Core (part 2, visual)
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php');

// Demo
acritShowDemoNotice($strModuleId);

# Update notifier
\Acrit\Core\Update::display();

// Set page title
$strPageTitle .= ' &laquo;'.$strModuleName.'&raquo; ('.$strModuleId.')';
$APPLICATION->SetTitle($strPageTitle);

# Prepare tabs
$arTabs = [];
if(in_array($strModuleId, \Acrit\Core\Export\Exporter::getExportModules(true))){
	$strTabsDir = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$strCoreId.'/include/support/export';
}
else{
	$strTabsDir = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$strModuleId.'/include/support';
}
if(is_dir($strTabsDir)){
	$arFiles = Helper::scandir($strTabsDir);
	if(is_array($arFiles)){
		foreach($arFiles as $strFile){
			Helper::loadMessages($strFile);
			$strCode = pathinfo($strFile, PATHINFO_FILENAME);
			$arTabs[$strCode] = [
				'DIV' => $strCode,
				'TAB' => Helper::getMessage(sprintf('ACRIT_CORE_TAB_%s_NAME', toUpper($strCode))),
				'TITLE' => Helper::getMessage(sprintf('ACRIT_CORE_TAB_%s_DESC', toUpper($strCode))),
				'FILE' => $strFile,
			];
		}
	}
}
# Add ask tab if it absent
if(!is_array($arTabs['ask'])){
	$arTabs['ask'] = [
		'TAB' => Helper::getMessage('ACRIT_CORE_TAB_ASK_NAME'),
		'TITLE' => Helper::getMessage('ACRIT_CORE_TAB_ASK_DESC'),
		'FILE' => realpath(__DIR__.'/../include/support/ask.php'),
	];
}
# Move array associative key to value 'DIV' and remove this associative key (array must be non-associtive)
foreach($arTabs as $strTab => &$arTab){
	$arTab['DIV'] = $strTab;
}
unset($arTab);
$arTabs = array_values($arTabs);
# Replace #MODULE_NAME# in title and description
foreach($arTabs as $strTab => &$arTab){
	$arTab['TAB'] = str_replace('#MODULE_NAME#', $strModuleName, $arTab['TAB']);
	$arTab['TITLE'] = str_replace('#MODULE_NAME#', $strModuleName, $arTab['TITLE']);
}
unset($arTab);

?><div id="acrit_core_support"><?

// Start TabControl (via CAdminForm, not CAdminTabControl)
$obTabControl = new \CAdminForm('AcritExpSupport', $arTabs);
$obTabControl->Begin(array(
	'FORM_ACTION' => $APPLICATION->getCurPageParam('', array()),
));

# Display tabs
foreach($arTabs as $arTab){
	if(strlen($arTab['FILE']) && is_file($arTab['FILE'])){
		$obTabControl->beginNextFormTab();
		require_once($arTab['FILE']);
	}
}

$obTabControl->Show();

# Get encoding more data
$strEncodingMore = sprintf(' ("%s", "%s", "2")', ini_get('default_charset'), ini_get('mbstring.internal_encoding'), 
	ini_get('mbstring.func_overload'));

?></div><?

?>
<div style="display:none">
	<form action="https://www.acrit-studio.ru/support/?show_wizard=Y" method="post" id="form-ticket" target="_blank" accept-charset="UTF-8">
		<input type="hidden" name="send_ticket_from_module" value="Y" />
		<input type="hidden" name="ticket_email" value="" />
		<input type="hidden" name="ticket_title" value="" />
		<input type="hidden" name="ticket_text" value="" />
		<input type="hidden" name="module_id" value="<?=$strModuleId;?>" />
		<input type="hidden" name="module_version" value="<?=Helper::getModuleVersion($strModuleId);?>" />
		<input type="hidden" name="core_version" value="<?=Helper::getModuleVersion($strCoreId);?>" />
		<input type="hidden" name="bitrix_version" value="<?=SM_VERSION.' ('.SM_VERSION_DATE.')';?>" />
		<input type="hidden" name="php_version" value="<?=PHP_VERSION;?>" />
		<input type="hidden" name="site_encoding" value="<?=SITE_CHARSET;?><?=$strEncodingMore;?>" />
		<input type="hidden" name="site_domain" value="<?=Helper::getCurrentDomain();?>" />
	</form>
	<script>
	$('input[type=button][data-role="ticket-send"]').click(function(e){
		e.preventDefault();
		function validateEmail(email) {
			var pattern  = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@(([[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return pattern .test(email);
		}
		var form = $('#form-ticket'),
			inputEmail = $('input[data-role="ticket-email"]'),
			inputSubject = $('input[data-role="ticket-subject"]'),
			inputMessage = $('textarea[data-role="ticket-message"]'),
			textEmail = $.trim(inputEmail.val());
			textSubject = $.trim(inputSubject.val());
			textMessage = $.trim(inputMessage.val());
		if(!textEmail.length){
			alert(inputEmail.attr('data-error'));
			return;
		}
		if(!validateEmail(textEmail)){
			alert(inputEmail.attr('data-incorrect'));
			return;
		}
		if(!textSubject.length){
			alert(inputSubject.attr('data-error'));
			return;
		}
		if(!textMessage.length){
			alert(inputMessage.attr('data-error'));
			return;
		}
		textMessage = [
			textMessage,
			'\n\n',
			'<?=Helper::getMessage('ACRIT_CORE_ASK_MODULE_ID');?>: ' + $('input[name="module_id"]', form).val(),
			'\n',
			'<?=Helper::getMessage('ACRIT_CORE_ASK_MODULE_VERSION');?>: ' + $('input[name="module_version"]', form).val() 
				+ ' / ' + $('input[name="core_version"]', form).val(),
			'\n',
			'<?=Helper::getMessage('ACRIT_CORE_ASK_BITRIX_VERSION');?>: ' + $('input[name="bitrix_version"]', form).val(),
			'\n',
			'<?=Helper::getMessage('ACRIT_CORE_ASK_PHP_VERSION');?>: ' + $('input[name="php_version"]', form).val(),
			'\n',
			'<?=Helper::getMessage('ACRIT_CORE_ASK_SITE_ENCODING');?>: ' + $('input[name="site_encoding"]', form).val(),
			'\n',
			'<?=Helper::getMessage('ACRIT_CORE_ASK_SITE_DOMAIN');?>: ' + $('input[name="site_domain"]', form).val(),
			'\n'
		];
		$('input[name="ticket_email"]', form).val(textEmail);
		$('input[name="ticket_title"]', form).val(textSubject);
		$('input[name="ticket_text"]', form).val(textMessage.join(''));
		form.submit();
	});
	</script>
</div>
<?

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_admin.php');
?>