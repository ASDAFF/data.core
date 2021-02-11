<?
namespace Data\Core\Export\Plugins;

?>
<input type="text" name="PROFILE[PARAMS][API_KEY]" size="40" maxlength="36" spellcheck="false"
	data-role="data_exp_ozon_new_api_key" value="<?=htmlspecialcharsbx($this->arParams['API_KEY']);?>" />
<input type="button" data-role="data_exp_ozon_new_access_check" value="<?=static::getMessage('API_KEY_CHECK');?>"
	style="height:25px;">
