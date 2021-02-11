<?php
namespace Acrit\Core\Seo;

use
	\Acrit\Core\Helper,
	\Acrit\Core\Seo\GooglePageSpeedV5;

Helper::loadMessages();

$strLang = 'ACRIT_SEO_GOOGLE_PAGESPEED_';

$arGooglePageSpeedResult = &$arParams['GOOGLE_PAGESPEED_RESULT'];
$arLighthouse = &$arParams['GOOGLE_PAGESPEED_RESULT']['lighthouseResult'];

if($arLighthouse['finalUrl'] != $arLighthouse['requestedUrl']){
	print Helper::showNote(Helper::getMessage($strLang.'FINAL_URL', ['#URL#' => $arLighthouse['finalUrl']]), true);
	print '<br/><br/>';
}

if($arGooglePageSpeedResult['error']){
	foreach($arGooglePageSpeedResult['error']['errors'] as $arError){
		print Helper::showError(null, $arError['message']);
	}
	return;
}
else{
	$arResult = GooglePageSpeedV5::prepareResultForDisplay($arLighthouse);
	$arParams['JSON_RESULT']['JS'] = $arLighthouse;
}
# Get subgroups
$arSubgroups = GooglePageSpeedV5::getOutputGroups(true);
foreach($arSubgroups as $strGroup => &$arGroup){
	$arGroup['TITLE'] = Helper::getMessage($strLang.'TYPE_'.toUpper($strGroup));
}
unset($arGroup);
# Add group name for _default
foreach($arResult['audits'] as $strCategory => &$arCategory){
	foreach($arCategory['items'] as &$arGroup){
		if($arGroup['id'] == '_default'){
			$arGroup['title'] = Helper::getMessage($strLang.'GROUP_DEFALUT');
		}
	}
	unset($arGroup);
}
unset($arCategory);
?>
<div class="acrit_seo_google_pagespeed_results">
	<?foreach($arResult['audits'] as $strCategory => $arCategory):?>
		<div class="acrit_seo_google_pagespeed_category">
			<?=Helper::showHeading($arCategory['title_score'], true);?>
			<?foreach($arCategory['items'] as $arGroup):?>
				<div class="acrit_seo_google_pagespeed_group" data-id="<?=$arGroup['id'];?>">
					<div class="acrit_seo_google_pagespeed_group_title"><?=$arGroup['title'];?></div>
					<div class="acrit_seo_google_pagespeed_group_description"><?=$arGroup['description'];?></div>
					<?foreach($arSubgroups as $strSubgroupType => $arSubgroup):?>
						<?if(is_array($arGroup[$strSubgroupType]) && !empty($arGroup[$strSubgroupType])):?>
							<?$bSingleSubgroup = count(array_intersect(array_keys($arSubgroups), array_keys($arGroup))) == 1;?>
							<div class="acrit_seo_google_pagespeed_group_data
								acrit_seo_google_pagespeed_group_data_<?=$strSubgroupType;?>">
								<?if(!$bSingleSubgroup):?>
									<div class="acrit_seo_google_pagespeed_group_toggle_wrapper">
										<a href="#" class="acrit-inline-link" data-role="acrit_seo_google_pagespeed_group_toggle">
											<?=$arSubgroup['TITLE'];?>
										</a>
									</div>
								<?endif?><?//!$bSingleSubgroup?>
								<div class="acrit_seo_google_pagespeed_audits"
									<?if($arSubgroup['COLLAPSED'] && !$bSingleSubgroup):?> style="display:none;"<?endif?>>
									<?foreach($arGroup[$strSubgroupType] as $arAudit):?>
										<div class="acrit_seo_google_pagespeed_audit" data-id="<?=$arAudit['id'];?>">
											<div class="acrit_seo_google_pagespeed_audit_title">
												<a href="#" class="acrit-inline-link" data-role="acrit_seo_google_pagespeed_audit_toggle">
													<?=$arAudit['title'];?>
												</a>
											</div>
											<div class="acrit_seo_google_pagespeed_audit_details">
												<div class="acrit_seo_google_pagespeed_audit_decription">
													<?=Helper::showNote($arAudit['description'], true);?>
												</div>
												<?if($arAudit['details']['type'] == 'opportunity'):?>
													<table class="acrit_seo_google_pagespeed_audit_opportunity">
														<thead>
															<tr>
																<?foreach($arAudit['details']['headings'] as $arHeader):?>
																	<th><?=$arHeader['label'];?></th>
																<?endforeach?><?//$arAudit['details']['headings']?>
															</tr>
														</thead>
														<tbody>
															<?foreach($arAudit['details']['items'] as $arItem):?>
																<tr>
																	<?foreach($arAudit['details']['headings'] as $arHeader):?>
																		<td data-type="<?=$arHeader['valueType'];?>"<?if(in_array($arHeader['valueType'], 
																			['bytes', 'ms'])):?>align="right"<?endif?>>
																			<?
																			switch($arHeader['valueType']){
																				case 'url':
																					$strFilename = pathinfo(parse_url($arItem[$arHeader['key']], PHP_URL_PATH), 
																						PATHINFO_BASENAME);
																					print sprintf('<a href="%1$s" title="%1$s" target="_blank">%2$s</a>', 
																						$arItem[$arHeader['key']], $strFilename);
																					break;
																				case 'bytes':
																					?><div class="acrit_seo_google_pagespeed_audit_opportunity_right"><?
																					print Helper::formatSize($arItem[$arHeader['key']]);
																					?></div><?
																					break;
																				case 'timespanMs':
																					?><div class="acrit_seo_google_pagespeed_audit_opportunity_right"><?
																					print number_format($arItem[$arHeader['key']]/1000, 2, '.', '').' s';
																					?></div><?
																					break;
																				case 'thumbnail':
																					print sprintf('<img src="%1$s" title="%1$s" />', $arItem[$arHeader['key']]);
																					break;
																			}
																			?>
																		</td>
																	<?endforeach?><?//$arAudit['details']['headings']?>
																</tr>
															<?endforeach?><?//$arAudit['details']['items']?>
														</tbody>
													</table>
												<?elseif($arAudit['details']['type'] == 'table'):?>
													<table class="acrit_seo_google_pagespeed_audit_table">
														<thead>
															<tr>
																<?foreach($arAudit['details']['headings'] as $arHeader):?>
																	<th><?=$arHeader['text'];?></th>
																<?endforeach?><?//$arAudit['details']['headings']?>
															</tr>
														</thead>
														<tbody>
															<?foreach($arAudit['details']['items'] as $arItem):?>
																<tr>
																	<?foreach($arAudit['details']['headings'] as $arHeader):?>
																		<td data-type="<?=$arHeader['itemType'];?>" <?if(in_array($arHeader['itemType'], 
																			['bytes', 'ms'])):?>align="right"<?endif?>>
																			<?
																			switch($arHeader['itemType']){
																				case 'text':
																					print $arItem[$arHeader['key']];
																					break;
																				case 'url':
																					if(strlen(parse_url($arItem[$arHeader['key']], PHP_URL_HOST))){
																						print sprintf('<a href="%1$s" title="%1$s" target="_blank">%1$s</a>', 
																							$arItem[$arHeader['key']]);
																					}
																					else{
																						print $arItem[$arHeader['key']];
																					}
																					break;
																				case 'bytes':
																					?><div class="acrit_seo_google_pagespeed_audit_table_right"><?
																					print Helper::formatSize($arItem[$arHeader['key']]);
																					?></div><?
																					break;
																				case 'ms':
																					?><div class="acrit_seo_google_pagespeed_audit_table_right"><?
																					print $arItem[$arHeader['key']].' s';
																					?></div><?
																					break;
																				case 'link':
																					print sprintf('<a href="%s" title="%s" target="_blank">%s</a>', 
																						$arItem[$arHeader['key']]['url'], 
																						implode("\n", array_column($arItem['subItems']['items'], 'url')), 
																						$arItem[$arHeader['key']]['text']);
																					break;
																				case 'code':
																					$mCode = $arItem[$arHeader['key']];
																					print sprintf('<code>%s</code>', 
																						htmlspecialcharsbx(is_array($mCode) ? $mCode['value'] : $mCode));
																					break;
																				case 'node':
																					print sprintf('<code>%s</code>', 
																						htmlspecialcharsbx($arItem[$arHeader['key']]['snippet']));
																					break;
																				case 'source-location':
																					print $arItem[$arHeader['key']]['url'];
																					break;
																				default:
																					print_r($arItem[$arHeader['key']]);
																					break;
																			}
																			?>
																		</td>
																	<?endforeach?><?//$arAudit['details']['headings']?>
																</tr>
															<?endforeach?><?//$arAudit['details']['items']?>
														</tbody>
													</table>
												<?endif?><?//opportunity?>
											</div>
										</div>
									<?endforeach?><?//$arGroup[$strSubgroupType]?>
								</div>
							</div>
						<?endif?><?//is_array($arGroup[$strSubgroupType])?>
					<?endforeach?><?//$arSubgroups?>
				</div>
			<?endforeach?><?//$arCategory['items']?>
		</div	>
	<?endforeach?>
</div>
