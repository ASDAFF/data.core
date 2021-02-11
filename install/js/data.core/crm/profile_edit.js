
/**
 * Manual import start
 */

function DataMansyncStartExportResetVars() {
	run_enabled = true;
	mansync_count = 0;
	mansync_success = 0;
	mansync_errors = 0;
	mansync_skip = 0;
	// $('#man_sync_result .start-mansync-result-all span').text(0);
	// $('#man_sync_result .start-mansync-result-good span').text(0);
	// $('#man_sync_result .start-mansync-result-bad span').text(0);
	// $('#man_sync_result .start-mansync-result-skip span').text(0);
	DataMansyncStartExportProgress(1, 0);
	$('#start_mansync_errors').val('');
}
function DataMansyncStartExportProgress(count, current) {
	let percent, width, max_width;
	percent = 0;
	if (current > 0) {
		percent = current / count * 100;
	}
	width = 50;
	max_width = $('.adm-progress-bar-outer').width();
	width = max_width / 100 * percent;
	$('#start_export_progress .adm-progress-bar-inner').width(width + 'px');
	$('#start_export_progress .adm-progress-bar-inner-text').text(percent + '%');
	$('#start_export_progress .adm-progress-bar-outer-text').text(percent + '%');
}
function DataMansyncStartExport(next_item, count) {
	if (!run_enabled) {
		return false;
	}
	dataExpAjax('man_sync_run', {
		"next_item": next_item,
		"count": count,
	}, function (JsonResult, textStatus, jqXHR) {
		console.log(JsonResult);
		if (JsonResult.result == 'ok') {
			if (JsonResult.errors.length > 0) {
				JsonResult.errors.forEach(function(item, i, arr) {
					DataMansyncMessageAdd(item);
				});
			}
			DataMansyncStartExportProgress(count, JsonResult.next_item);
			// mansync_success += JsonResult.report.success;
			// mansync_errors += JsonResult.report.errors;
			// mansync_skip += JsonResult.report.skip;
			// $('#man_sync_result .start-mansync-result-all span').text(JsonResult.exported_count);
			// $('#man_sync_result .start-mansync-result-good span').text(mansync_success);
			// $('#man_sync_result .start-mansync-result-bad span').text(mansync_errors);
			// $('#man_sync_result .start-mansync-result-skip span').text(mansync_skip);
			if (JsonResult.next_item && JsonResult.next_item < count) {
				DataMansyncStartExport(JsonResult.next_item, count);
			}
			else {
				DataMansyncStartExportProgress(1, 1);
				$('#man_sync_stop').addClass("adm-btn-disabled");
				$('#man_sync_start').removeClass("adm-btn-disabled");
			}
		}
	}, function (jqXHR) {
		console.log(jqXHR);
	}, true);
}

function DataMansyncMessageAdd(message) {
	var text = $('#start_mansync_errors').val();
	text += message + "\n";
	$('#start_mansync_errors').val(text);
}


/**
 * JS actions
 */

$(function() {

	/**
	 * Manual export
	 */

	DataMansyncStartExportResetVars();

	$("#man_sync_start").click(function() {
		if (!$(this).hasClass("adm-btn-disabled")) {
			DataMansyncStartExportResetVars();
			$('#man_sync_start').addClass("adm-btn-disabled");
			$('#man_sync_stop').removeClass("adm-btn-disabled");
			// $('#man_sync_result').show();
			dataExpAjax('man_sync_count', {}, function (JsonResult, textStatus, jqXHR) {
				console.log(JsonResult);
				if (JsonResult.result == 'ok') {
					mansync_count = JsonResult.count;
					if (JsonResult.errors.length > 0) {
						JsonResult.errors.forEach(function(item, i, arr) {
							DataMansyncMessageAdd(item);
						});
						$('#man_sync_stop').addClass("adm-btn-disabled");
						$('#man_sync_start').removeClass("adm-btn-disabled");
					}
					else {
						DataMansyncStartExportProgress(1, 0);
						DataMansyncStartExport(0, mansync_count);
					}
				}
			}, function (jqXHR) {
				console.log(jqXHR);
			}, true);
		}
		return false;
	});

	$("#man_sync_stop").click(function() {
		if (!$(this).hasClass("adm-btn-disabled")) {
			$('#man_sync_stop').addClass("adm-btn-disabled");
			$('#man_sync_start').removeClass("adm-btn-disabled");
			run_enabled = false;
		}
		return false;
	});

	$('.data-mansync-store-fields').select2({
		width: '100%',
		language: {
			'noResults': function(){
				return loc_messages.DATA_MANSYNC_STORE_FIELDS_NOTFOUND;
			}
		}
	});

});
