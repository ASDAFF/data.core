<?
namespace Acrit\Core\Export;

use \Acrit\Core\Helper,
	\Acrit\Core\Cli;

Helper::loadMessages(__FILE__);

return [
	'NAME' => Helper::getMessage('ACRIT_CORE_OPTION_GROUP_EXPORT'),
	'OPTIONS' => [
		'php_path' => [
			'NAME' => Helper::getMessage('ACRIT_CORE_OPTION_PHP_PATH'),
			'HINT' => Helper::getMessage('ACRIT_CORE_OPTION_PHP_PATH_HINT'),
			'ATTR' => 'size="30" maxlength="255" spellcheck="false"',
			'TYPE' => 'text',
			'HEAD_DATA' => function($obOptions, $arOption){
				?>
				<script>
				$(document).on('click', 'input[data-role="check-php-path"]', function(e){
					let
						phpPath = $.trim($('#acrit_core_option_<?=$arOption['CODE'];?>').val()),
						get = {
							mid: '<?=$obOptions->getModuleId()?>',
							lang: phpVars.LANGUAGE_ID
						},
						post = {
							option: '<?=$arOption["CODE"];?>',
							php_path: encodeURIComponent(btoa(phpPath))
						};
					if(phpPath.length) {
						acritCoreAjax('option_ajax', get, post, function(jqXHR, textStatus, arJsonResult){
							alert(arJsonResult.Message);
						}, function(jqXHR){
							alert('Error!');
						}, false);
					}
				});
				$(document).on( 'click', '[data-role="php-paths"] a',function(e){
					e.preventDefault();
					$('input[type=text][name=php_path]').val($(this).text());
				});
				</script>
				<?
			},
			'CALLBACK_MORE' => function($obOptions, $arOption){
				?>
				<input type="button" data-role="check-php-path" 
					value="<?=Helper::getMessage('ACRIT_CORE_OPTION_PHP_PATH_CHECK');?>" />
				<?
			},
			'CALLBACK_BOTTOM' => function($obOptions, $arOption){
				?>
				<?if(Cli::isExec()):?>
					<?$arPaths = Cli::getPotentialPhpPaths();?>
					<?if(!empty($arPaths)):?>
						<tr>
							<td style="padding-top:0;"></td>
							<td style="padding-top:0;" data-role="php-paths">
								<?
								foreach($arPaths as $key => $strPath){
									$arPaths[$key] = '<a href="javascript:void(0);" class="acrit-inline-link">'.$strPath.'</a>';
								}
								Helper::showNote(Helper::getMessage('ACRIT_CORE_OPTION_PHP_PATH_POTENTIAL', [
									'#PHP_PATHS#' => implode(', ', $arPaths),
								]), true);
								?>
							</td>
						</tr>
					<?endif?>
				<?endif?>
				<?
			},
			'CALLBACK_AJAX' => function($obOptions, $arOption, &$arJsonResult){
				$arCheckResult = Cli::checkPhpVersion(base64_decode(urldecode($obOptions->arPost['php_path'])));
				$arJsonResult['Message'] = $arCheckResult['MESSAGE'];
				$arJsonResult['Success'] = $arCheckResult['SUCCESS'];
				$arJsonResult['PhpVersionTest'] = $arCheckResult['VERSION'];
				$arJsonResult['PhpVersionSite'] = Cli::getSitePhpVersion();
			}
		],
		'php_mbstring' => [
			'NAME' => Helper::getMessage('ACRIT_CORE_OPTION_MBSTRING'),
			'HINT' => Helper::getMessage('ACRIT_CORE_OPTION_MBSTRING_HINT'),
			'TYPE' => 'checkbox',
		],
		'php_config' => [
			'NAME' => Helper::getMessage('ACRIT_CORE_OPTION_CONFIG'),
			'HINT' => Helper::getMessage('ACRIT_CORE_OPTION_CONFIG_HINT'),
			'ATTR' => 'size="60" maxlength="255" spellcheck="false"',
			'TYPE' => 'text',
		],
		'php_add_site' => [
			'NAME' => Helper::getMessage('ACRIT_CORE_OPTION_ADD_SITE'),
			'HINT' => Helper::getMessage('ACRIT_CORE_OPTION_ADD_SITE_HINT'),
			'TYPE' => 'checkbox',
		],
		'php_output_stdout' => [
			'NAME' => Helper::getMessage('ACRIT_CORE_OPTION_OUTPUT_STDOUT'),
			'HINT' => Helper::getMessage('ACRIT_CORE_OPTION_OUTPUT_STDOUT_HINT'),
			'TYPE' => 'checkbox',
		],
		'warn_if_root' => [
			'NAME' => Helper::getMessage('ACRIT_CORE_OPTION_WARN_IF_ROOT'),
			'HINT' => Helper::getMessage('ACRIT_CORE_OPTION_WARN_IF_ROOT_HINT'),
			'TYPE' => 'checkbox',
		],
		'disable_crontab_set' => [
			'NAME' => Helper::getMessage('ACRIT_CORE_OPTION_DISABLE_CRONTAB_SET'),
			'HINT' => Helper::getMessage('ACRIT_CORE_OPTION_DISABLE_CRONTAB_SET_HINT'),
			'TYPE' => 'checkbox',
		],
	],
];
?>