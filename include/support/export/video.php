<?
namespace Data\Core\Export;

use
	\Data\Core\Helper;
?>
<?
$obTabControl->BeginCustomField('VIDEO', Helper::getMessage('DATA_EXP_VIDEO_FIELD'));
?>
<tr class="heading"><td><?=$obTabControl->GetCustomLabelHTML()?></td></tr>
<tr>
	<td style="text-align:center;">
		<div><iframe width="800" height="500" src="https://www.youtube.com/embed/ene4qDMdn6A?list=PLnH5qqS_5Wnzw10GhPty9XgZSluYlFa4y" frameborder="0" allowfullscreen></iframe><br/>
	</td>
</tr>
<?
$obTabControl->EndCustomField('VIDEO');

