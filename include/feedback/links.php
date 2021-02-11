<?
namespace Data\Core;

use
	\Data\Core\Helper;

?>
<fieldset title="<?=Helper::getMessage('DATA_CORE_FEEDBACK_TITLE');?>" style="line-height: 140%;">
	<legend><?=Helper::getMessage('DATA_CORE_FEEDBACK_TITLE');?></legend>
	<?=Helper::getMessage('DATA_CORE_FEEDBACK_TEXT', ['#DOMAIN#' => 'https://www.data-studio.ru']);?>
</fieldset>