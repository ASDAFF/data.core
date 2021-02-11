<?
namespace Data\Core\Export;

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

return [
	'NAME' => Loc::getMessage('DATA_CORE_OPTION_GROUP_UPDATES'),
	'OPTIONS' => [
		'check_updates' => [
			'NAME' => Loc::getMessage('DATA_CORE_OPTION_DYNAMIC_UPDATES'),
			'HINT' => Loc::getMessage('DATA_CORE_OPTION_DYNAMIC_UPDATES_DESC'),
			'TYPE' => 'checkbox',
		],
		'check_updates_regular' => [
			'NAME' => Loc::getMessage('DATA_CORE_OPTION_DYNAMIC_UPDATES_REGULAR'),
			'HINT' => Loc::getMessage('DATA_CORE_OPTION_DYNAMIC_UPDATES_REGULAR_DESC'),
			'TYPE' => 'checkbox',
			'CALLBACK_SAVE' => function($obOptions, $arOption){
				\Data\Core\Helper::setOption(DATA_CORE, 'check_updates_last_time', false);
			},
		],
	],
];
?>