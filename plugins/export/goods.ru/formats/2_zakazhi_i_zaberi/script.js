if (!window.dataExpGoodsJsonInitialized) {
	window.dataExpGoodsJsonInitialized = true;
	
	$(document).delegate('select[data-role="data-exp-goods-json-storage-switcher"]', 'change', function(e){
		var rowInternal = $('table.data-exp-goods-storage-directory-internal').closest('tr').hide(),
			rowExternal = $('table.data-exp-goods-storage-directory-external').closest('tr').hide();
		if($(this).val() == 'external'){
			rowExternal.show();
		}
		else{
			rowInternal.show();
		}
	});
	
	function dataExpGoodsJsonTriggers(){
		$('select[data-role="data-exp-goods-json-storage-switcher"]').trigger('change');
	}
	
}

// On load
setTimeout(function(){
	dataExpGoodsJsonTriggers();
}, 500);
$(document).ready(function(){
	dataExpGoodsJsonTriggers();
});

// On current IBlock change
BX.addCustomEvent('onLoadStructureIBlock', function(a){
	dataExpGoodsJsonTriggers();
});
