$(document).ready(function(){
	setTimeout(function(){
		// Check updates
		var div = $('#data-module-update-notifier');
		if(div.length){
			var module = (location.pathname + location.search).match(/data[._]{1}[a-z]+/)[0].replace(/_/, '.');
			$.ajax({
				url: '/bitrix/admin/data_core_check_updates.php',
				type: 'GET',
				data: {
					lang: phpVars.LANGUAGE_ID,
					module: module
				},
				datatype: 'json',
				success: function(data, textStatus, jqXHR){
					div.html(data.HTML).show();
				},
				error: function(jqXHR, textStatus, errorThrown){
					console.log(jqXHR);
					console.log(textStatus);
					console.log(errorThrown);
				}
			});
		}
	}, 1000);
});