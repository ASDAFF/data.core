<?
namespace Data\Core;

use
	\Data\Core\Helper;
	
?>

<?if($arVariables['POPUP']):?>
	<div class="data-exp-allowed-values-wrapper" data-role="data-exp-field-popup-hint">
		<table>
			<tbody>
				<?if($arVariables['FILTER']):?>
					<tr>
						<td class="data-exp-allowed-values-filter">
							<input type="text" placeholder="<?=Helper::getMessage('DATA_CORE_FIELD_POPUP_HINT_SEARCH');?>" value=""
								data-role="data-exp-field-popup-hint-search">
						</td>
					</tr>
				<?endif?>
				<tr>
					<td class="data-exp-allowed-values-data">
						<div class="data-exp-allowed-values">
							<?if(is_array($arVariables['GROUPS'])):?>
								<ul class="data-exp-allowed-values-<?=($arVariables['LIST'] ? 'list' : 'default');?>"
									data-role="data-exp-field-popup-hint-groups">
									<?foreach($arVariables['GROUPS'] as $key1 => $arGroup):?>
										<li>
											<div class="data-exp-allowed-values-group-title" data-role="data-exp-field-popup-hint-group">
												<?=$arGroup['NAME'];?>
											</div>
											<ul>
												<?foreach($arGroup['ITEMS'] as $key2 => $strItem):?>
													<li><?=$strItem;?>, </li>
												<?endforeach?>
											</ul>
										</li>
									<?endforeach?>
								</ul>
							<?endif?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
<?else:?>
	<?if(is_array($arVariables['GROUPS'])):?>
		<?#if($arVariables['LIST']):?>
		<div class="data-exp-allowed-values">
			<ul class="data-exp-allowed-values-<?=($arVariables['LIST'] ? 'list' : 'default');?>">
				<?foreach($arVariables['GROUPS'] as $key1 => $arGroup):?>
					<li>
						<div class="data-exp-allowed-values-group-title">
							<?=$arGroup['NAME'];?>
						</div>
						<ul>
							<?foreach($arGroup['ITEMS'] as $key2 => $strItem):?>
								<li><?=$strItem;?>, </li>
							<?endforeach?>
						</ul>
					</li>
				<?endforeach?>
			</ul>
		</div>
	<?endif?>
<?endif?>
