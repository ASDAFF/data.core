<?
use \Bitrix\Main\Localization\Loc,
	\Data\Core\Helper;
?>
<?=Helper::showNote(static::getMessage('PARAGRAPH_ABOUT_REQUIRED_PARAMS'));?>
<p><?=static::getMessage('IMAGES_MAX_COUNT', array(
	'#NAME#' => static::getMessage('CATEGORY_NAME'),
	'#COUNT#' => 5,
));?></p>
<h2><?=static::getMessage('USEFUL_LINKS');?></h2>
<ul>
	<li>
		<a href="http://autoload.avito.ru/format/zapchasti_i_aksessuary" target="_blank">
			<?=static::getMessage('DOCUMENTATION');?>
		</a>
	</li>
	<li>
		<a href="http://autoload.avito.ru/format/xmlcheck/" target="_blank">
			<?=static::getMessage('CHECK_XML');?>
		</a>
	</li>
	<li>
		<a href="http://autoload.avito.ru/format/faq/" target="_blank">
			<?=static::getMessage('FAQ');?>
		</a>
	</li>
</ul>
