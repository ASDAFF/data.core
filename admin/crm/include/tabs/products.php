<?
namespace Data\Core\Crm;

use \Bitrix\Main\Localization\Loc,
	\Data\Core\Helper;

Loc::loadMessages(__FILE__);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$obTabControl->AddSection('HEADING_PRODUCTS_TBLCMPR', Loc::getMessage('DATA_CRM_TAB_PRODUCTS_HEADING'));

// Block for tags management
$obTabControl->BeginCustomField('PROFILE[PRODUCTS_TBLCMPR]', Loc::getMessage('DATA_CRM_PRODUCTS_TBLCMPR'));
?>
    <tr id="tr_PRODUCTS_TBLCMPR">
        <td>
        </td>
    </tr>
<?
$obTabControl->EndCustomField('PROFILE[PRODUCTS_TBLCMPR]');

?>