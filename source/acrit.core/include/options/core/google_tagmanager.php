<?
namespace Acrit\Core\Export;

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

return [
	'NAME' => Loc::getMessage('ACRIT_CORE_OPTION_GROUP_GOOGLE_TAGMANAGER'),
	'OPTIONS' => [
		'google_tagmanager_id' => [
			'NAME' => Loc::getMessage('ACRIT_CORE_OPTION_GOOGLE_TAGMANAGER_ID'),
			'HINT' => Loc::getMessage('ACRIT_CORE_OPTION_GOOGLE_TAGMANAGER_ID_HINT'),
			'ATTR' => 'size="40" maxlength=20" spellcheck="false" style="font-family:monospace;"
				placeholder="'.Loc::getMessage('ACRIT_CORE_OPTION_GOOGLE_TAGMANAGER_ID_PLACEHOLDER').'"',
			'TYPE' => 'text',
		],
	],
];
?>