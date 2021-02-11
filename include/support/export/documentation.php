<?
namespace Acrit\Core\Export;

use
	\Acrit\Core\Helper;
?>

<?
$obTabControl->BeginCustomField('FAQ', Helper::getMessage('ACRIT_EXP_FAQ'));
$strUrl = 'http://www.acrit-studio.ru/technical-support/configuring-the-module-export-on-trade-portals/';
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
$obTabControl->BeginCustomField('REQUIREMENTS_1', Helper::getMessage('ACRIT_EXP_REQUIREMENTS_1'));
$strUrl = 'https://www.acrit-studio.ru/technical-support/configuring-the-module-export-on-trade-portals/test-your-environment-before-configuring-the-module-acrit-export/';
?>
<tr class="heading"><td colspan="2"><?=$obTabControl->GetCustomLabelHTML()?></td></tr>
<tr>
	<td style="text-align:center;">
		<div><a href="<?=$strUrl;?>" target="_blank"><?=$strUrl;?></a></div><br/>
	</td>
</tr>
<?
$obTabControl->EndCustomField('REQUIREMENTS_1');
