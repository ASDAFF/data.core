<?

namespace Data\Core\Export\Plugins;

use \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\EventManager,
    \Data\Core\Helper,
    \Data\Core\HttpRequest,
    \Data\Core\Export\Plugin,
    \Data\Core\Export\Field\Field,
    \Data\Core\Export\Exporter,
    \Data\Core\Export\ProfileTable as Profile,
    \Data\Core\Export\ProfileIBlockTable as ProfileIBlock,
    \Data\Core\Export\Filter,
    \Data\Core\Export\ExportDataTable as ExportData,
    \Data\Core\Log,
    \Data\Core\Export\CategoryRedefinitionTable as CategoryRedefinition;

Loc::loadMessages(__FILE__);

// ��� ������������ ��� ���� �������������� ���������� � ��������, ����� ��������� ������� �� ������������
$strPluginParams = $obPlugin->getPluginParamsInputName();
$arPluginParams = $obPlugin->getPluginParams();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
$obTabControl->BeginCustomField($strPluginParams . '[LOAD_ATTR]', $obPlugin::getMessage('LOAD_ATTR'));
$intProfileID = $_GET['ID'];
if (!$arProfile['PARAMS']['OZON_LOAD_ATTR_STEP_SIZE'])
   $arProfile['PARAMS']['OZON_LOAD_ATTR_STEP_SIZE'] = 59;

$importParams = unserialize(\Bitrix\Main\Config\Option::get($strModuleId, 'OZON_LOAD_ATTR_' . $intProfileID));
?>
<tr>
   <td valign="top" style="text-align: center;" colspan="2">
      <?= $obPlugin::getMessage('OZON_LOAD_ATTR_TEXT'); ?>
   </td>
</tr>
<tr>
   <td valign="top" style="text-align: center;" colspan="2">
      <?= $obPlugin::getMessage('OZON_LOAD_ATTR_STEP_SIZE'); ?> <input  type="text" name="PROFILE[PARAMS][OZON_LOAD_ATTR_STEP_SIZE]"  value="<?= $arProfile['PARAMS']['OZON_LOAD_ATTR_STEP_SIZE'] ?>" /><br/><br/>
   </td>
</tr>
<tr><? $buttonTextLabel = ($importParams['time_first_run'] != '') ? $obPlugin::getMessage('LOAD_ATTR_CONTINUE') : $obPlugin::getMessage('LOAD_ATTR_START'); ?>
   <td valign="top" style="text-align: center;" colspan="2">
      <a href="javascript:void(0)" class="adm-btn run_load_attributes" title=""><?= $buttonTextLabel; ?></a>

   </td>
</tr>
<tr>
   <td valign="top" colspan="2" class="res_load_attributes" >



   </td>
</tr>
<?
$obTabControl->EndCustomField($strPluginParams . '[LOAD_ATTR]');
