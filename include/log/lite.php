<?
namespace Data\Core;

use
	\Data\Core\Helper,
	\Data\Core\Log;

$strLogPreview = Log::getInstance($strModuleId)->getLogPreview($intProfileId);

$strLogFilenameRel = Log::getInstance($strModuleId)->getLogFilename($intProfileId, true);

?>
<div class="data-core-log-preview-wrapper" data-role="log-wrapper"
	data-module-id="<?=$strModuleId;?>" data-profile-id="<?=$intProfileId;?>">
	<div class="data-core-log-control">
		<div class="data-core-log-control-left">
			<a href="javascript:void(0);" data-role="log-refresh" data-ajax="Y" class="adm-btn">
				<?=Helper::getMessage('DATA_CORE_LOG_REFRESH');?>
			</a>
		</div>
		<div class="data-core-log-control-right">
			<a href="<?=Log::getInstance($strModuleId)->getLogUrl($intProfileId, false);?>" data-role="log-open" 
				class="adm-btn" target="_blank">
				<?=Helper::getMessage('DATA_CORE_LOG_OPEN');?>
			</a>
			&nbsp;
			<a href="<?=Log::getInstance($strModuleId)->getLogUrl($intProfileId, true);?>" data-role="log-download"
				class="adm-btn" target="_blank" title="<?=$strLogFilenameRel;?>">
				<?=Helper::getMessage('DATA_CORE_LOG_DOWNLOAD');?>
			</a>
			&nbsp;
			<a href="javascript:void(0);" data-role="log-clear" data-ajax="Y" class="adm-btn" 
				data-confirm="<?=Helper::getMessage('DATA_CORE_LOG_CLEAR_CONFIRM');?>">
				<?=Helper::getMessage('DATA_CORE_LOG_CLEAR');?>
			</a>
		</div>
	</div>
	<div>
		<textarea class="data-core-log" data-role="log-content" data-empty-height="28" readonly="readonly"
			placeholder="<?=Helper::getMessage('DATA_CORE_LOG_EMPTY_PLACEHOLDER')?>"
		><?=$strLogPreview;?></textarea>
	</div>
	<div class="data-core-log-size-notice">
		<?=Helper::getMessage('DATA_CORE_LOG_SIZE_NOTICE', array(
			'#MAX_SIZE#' => Log::getInstance($strModuleId)->getMaxSize(true, true),
			'#LOG_SIZE#' => Log::getInstance($strModuleId)->getLogSize($intProfileId, true),
		))?>
	</div>
</div>