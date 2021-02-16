<?
IncludeModuleLangFile(__FILE__);
$APPLICATION->SetTitle(GetMessage("data.uninst_fb_PAGE_TITLE", array('#MODULE_NAME#' => $GLOBALS['DATA_MODULE_NAME'])));
?>
<form action="<?=$APPLICATION->GetCurPage()?>" method="get" name="data_uninst_feedback" class="data-uninst-feedback" id="data_uninst_feedback" style="max-width: 500px; background: #fff; padding: 10px 20px 20px 20px;">
	<?=bitrix_sessid_post()?>
	<input type="hidden" name="lang" value="<?=LANG?>">
	<input type="hidden" name="id" value="<?=$GLOBALS['DATA_MODULE_ID'];?>">
	<input type="hidden" name="uninstall" value="Y">
	<input type="hidden" name="step" value="2">
	<input type="hidden" name="prevstep" value="1">

	<input type="submit" name="inst" value="<?=GetMessage("data.uninst_fb_DEL")?>">
</form>