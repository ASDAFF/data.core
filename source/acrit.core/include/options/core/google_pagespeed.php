<?
namespace Acrit\Core\Export;

use
	\Acrit\Core\Helper;

Helper::loadMessages(__FILE__);

return [
	'NAME' => Helper::getMessage('ACRIT_CORE_OPTION_GROUP_GOOGLE_PAGESPEED'),
	'OPTIONS' => [
		'google_pagespeed_v5_apikey' => [
			'NAME' => Helper::getMessage('ACRIT_CORE_OPTION_GOOGLE_PAGESPEED_APIKEY'),
			'HINT' => Helper::getMessage('ACRIT_CORE_OPTION_GOOGLE_PAGESPEED_APIKEY_HINT'),
			'ATTR' => 'size="40" maxlength=50" spellcheck="false" style="font-family:monospace;"
				placeholder="'.Helper::getMessage('ACRIT_CORE_OPTION_GOOGLE_PAGESPEEDR_APIKEY_PLACEHOLDER').'"',
			'TYPE' => 'text',
			'CALLBACK_MORE' => function($obOptions, $arOption){
				?>
				<a href="https://developers.google.com/speed/docs/insights/v5/get-started?hl=ru#key/" target="_blank">
					<?=Helper::getMessage('ACRIT_CORE_OPTION_GROUP_GOOGLE_PAGESPEED_GET');?>
				</a>
				<?
			},
		],
	],
];
?>