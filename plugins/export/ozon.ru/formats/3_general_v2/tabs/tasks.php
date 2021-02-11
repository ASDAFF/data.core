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
$obTabControl->BeginCustomField($strPluginParams . '[EXPORT_PROMOCODES]', $obPlugin::getMessage('EXPORT_PROMOCODES'));

$intProfileID = $_GET['ID'];
?>
<tr>
   <td valign="top" style="text-align: center;" colspan="2">
      <input data-role="update_items_status" type="button" value="<?= $obPlugin::getMessage('RELOAD_STATUS') ?>"/>
   </td>
</tr>
<tr>
   <td valign="top" colspan="2" class="ozone-status-table" >

      <?
      //Helper::call($strModuleId, 'Profile', 'getProfiles', [$intProfileID]);
      //OzonRuGeneral::ozonGetItems()
      //$arProfile['PARAMS']['FIRST_EXPORT_SYNC_ITEMS_DONE'] = OzonRuGeneral::ozonSyncItemsOnFirstExport($intProfileID);
      //$obOzonRuGeneral = new OzonRuGeneral($strModuleId);
      ?>

      <?= $obPlugin->ozoneItemsStatusTable($intProfileID, $strModuleId); ?>

   </td>
</tr>
<?
$obTabControl->EndCustomField($strPluginParams . '[EXPORT_PROMOCODES]');
