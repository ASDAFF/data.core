<?
namespace Acrit\Core;

use
	\Acrit\Core\Helper;

$strModuleId = &$arVariables['MODULE_ID'];
$strModuleCodeFull = str_replace('.', '_', $strModuleId);
$arOptions = &$arVariables['OPTIONS'];
$obOptions = &$arVariables['THIS'];

?>
<?foreach($arOptions as $arGroup):?>
	<?if(strlen($arGroup['NAME'])):?>
		<tr class="heading">
			<td colspan="2"><?=$arGroup['NAME'];?><?if($arGroup['HINT']):?> <?=Helper::showHint($arGroup['HINT']);?><?endif?></td>
		</tr>
	<?endif?>
	<?foreach($arGroup['OPTIONS'] as $strOption => $arOption):?>
		<?$obOptions->displaySingleOption($arOption);?>
	<?endforeach?>
<?endforeach?>