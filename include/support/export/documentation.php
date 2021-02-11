<?
namespace Data\Core\Export;

use
	\Data\Core\Helper;
?>

<?
$obTabControl->BeginCustomField('FAQ', Helper::getMessage('DATA_EXP_FAQ'));
$strUrl = 'http://www.data-studio.ru/technical-support/configuring-the-module-export-on-trade-portals/';
?>
<tr class="heading"><td><?=$obTabControl->GetCustomLabelHTML()?></td></tr>
<tr>
	<td style="text-align:center;">
		<div><a href="<?=$strUrl;?>" target="_blank"><?=$strUrl;?></a></div><br/>
	</td>
</tr>
<?
$obTabControl->EndCustomField('FAQ');

//
$obTabControl->BeginCustomField('REQUIREMENTS_1', Helper::getMessage('DATA_EXP_REQUIREMENTS_1'));
$strUrl = 'https://www.data-studio.ru/technical-support/configuring-the-module-export-on-trade-portals/test-your-environment-before-configuring-the-module-data-export/';
?>
<tr class="heading"><td colspan="2"><?=$obTabControl->GetCustomLabelHTML()?></td></tr>
<tr>
	<td style="text-align:center;">
		<div><a href="<?=$strUrl;?>" target="_blank"><?=$strUrl;?></a></div><br/>
	</td>
</tr>
<?
$obTabControl->EndCustomField('REQUIREMENTS_1');
