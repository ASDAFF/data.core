<?
namespace Data\Core\Export;

use \Data\Core\Helper;

Helper::loadMessages(__FILE__);

return [
	'NAME' => Helper::getMessage('DATA_CORE_TAB_GENERAL_GROUP_DATAMENU'),
	'OPTIONS' => [
		'datamenu_group_name' => [
			'NAME' => Helper::getMessage('DATA_CORE_OPTION_DATAMENU_GROUP_NAME'),
			'HINT' => Helper::getMessage('DATA_CORE_OPTION_DATAMENU_GROUP_NAME_HINT'),
			'TYPE' => 'text',
			'ATTR' => 'onchange="$(\'input[name=DATAMENU_GROUPNAME]\').val($(this).val())" size="30" placeholder="'.htmlspecialcharsbx(Helper::getMessage('DATAMENU_GROUP_NAME_DEFAULT')).'"',
		],
		'datamenu_group_sort' => [
			'NAME' => Helper::getMessage('DATA_CORE_OPTION_DATAMENU_GROUP_SORT'),
			'HINT' => Helper::getMessage('DATA_CORE_OPTION_DATAMENU_GROUP_SORT_HINT'),
			'TYPE' => 'text',
			'ATTR' => 'onchange="$(\'input[name=DATAMENU_GROUPNAME]\').val($(this).val())" size="20" placeholder="150"',
		],
		'datamenu_group_image' => [
			'NAME' => Helper::getMessage('DATA_CORE_OPTION_DATAMENU_GROUP_IMAGE'),
			'HINT' => Helper::getMessage('DATA_CORE_OPTION_DATAMENU_GROUP_IMAGE_HINT'),
			'TYPE' => 'text',
			'ATTR' => 'onchange="$(\'input[name=DATAMENU_GROUPNAME]\').val($(this).val())" size="50" placeholder="/bitrix/themes/.default/images/data.core/data.png"',
		],
	],
];
?>