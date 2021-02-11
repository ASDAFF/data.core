<?
/**
 * Data Core: create tables for ozon
 * @documentation https://docs.ozon.ru/api/seller
 */

namespace Data\Core\Export\Plugins\OzonRuHelpers;

use
	\Data\Core\Helper,
	\Data\Core\Json,
	\Data\Core\Export\Exporter;
?>
<div id="data_exp_ozon_json_preview_popup">
	<?
	$arSubTabs = [];
	$arSubTabs[] = [
		'DIV' => 'json_formatted', 
		'TAB' => static::getMessage('TAB_FORMATTED'), 
	];
	$arSubTabs[] = [
		'DIV' => 'json_unformatted', 
		'TAB' => static::getMessage('TAB_UNFORMATTED'), 
	];
	$obTabControl = new \CAdminViewTabControl('DataExpOzonJsonPreview', $arSubTabs);
	$obTabControl->begin();
	$obTabControl->beginNextTab();
	$arJson = Json::decode($strJson);
	$strJsonFormatted = Json::encode($arJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	if(!Helper::isUtf()){
		$strJsonFormatted = Helper::convertEncoding($strJsonFormatted, 'UTF-8', 'CP1251');
	}
	?>
		<pre style="margin-top:0;"><code class="json"><?=$strJsonFormatted;?></code></pre>
	<?
	$obTabControl->beginNextTab();
	?>
		<pre style="margin-top:0;"><code class="json"><?=$strJson;?></code></pre>
	<?
	$obTabControl->end();
	?>
</div>