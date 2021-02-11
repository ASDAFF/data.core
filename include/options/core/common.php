<?
namespace Data\Core\Export;

use \Bitrix\Main\Localization\Loc,
	\Data\Core\Helper;

Loc::loadMessages(__FILE__);

return [
	'NAME' => Loc::getMessage('DATA_CORE_OPTION_GROUP_COMMON'),
	'OPTIONS' => [
		'common_settings' => [
			'NAME' => Loc::getMessage('DATA_CORE_OPTION_COMMON_SETTINGS'),
			'HINT' => Loc::getMessage('DATA_CORE_OPTION_COMMON_SETTINGS_HINT'),
			'TYPE' => 'clear',
			'CALLBACK_MORE' => function($arOption){
				return '
				<a href="/bitrix/admin/settings.php?lang='.LANGUAGE_ID.'&mid='.DATA_CORE.'">
					'.Helper::getMessage('DATA_CORE_OPTION_COMMON_SETTINGS_BUTTON').'
				</a>';
			},
		],
	],
];
	
?>