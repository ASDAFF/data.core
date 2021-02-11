var DataPopupHint;
$(document).ready(function(){
	DataPopupHint = new BX.CDialog({
		ID: 'DataPopupHint',
		title: '',
		content: '',
		resizable: true,
		draggable: true,
		height: 400,
		width: 800
	});
	DataPopupHint.Open = function(title, content){
		this.SetTitle(title);
		this.SetContent(content);
		this.SetAutoSize();
		this.InitFilter();
		this.Show();
	}
	DataPopupHint.SetAutoSize = function(){
		$('.bx-core-adm-dialog-content-wrap-inner', this.DIV).css({
			'height': '100%',
			'-webkit-box-sizing': 'border-box',
				 '-moz-box-sizing': 'border-box',
							'box-sizing': 'border-box'
		}).children().css({
			'height': '100%'
		});
	}
	DataPopupHint.InitFilter = function(){
		var
			div = $('div[data-role="data-exp-field-popup-hint"]', this.DIV),
			input = $('input[data-role="data-exp-field-popup-hint-search"]', this.DIV),
			groups = $('ul[data-role="data-exp-field-popup-hint-groups"]', this.DIV).children('li');
		input.bind('input', function(e){
			var
				query = $(this).val().toLowerCase().trim(),
				emptyQuery = !query.length;
			groups.each(function(){
				var
					title = $(this).children('[data-role="data-exp-field-popup-hint-group"]').text().trim(),
					items = $(this).hide().children('ul').children('li').hide(),
					groupVisible = false;
				if(emptyQuery){
					$(this).show();
					items.show();
				}
				else{
					if(title.toLowerCase().indexOf(query) != -1){
						groupVisible = true;
						items.show();
					}
					else{
						items.each(function(){
							if($(this).text().toLowerCase().indexOf(query) != -1){
								$(this).show();
								groupVisible = true;
							}
						});
					}
					if(groupVisible){
						$(this).show();
					}
				}
			});
		});
	}
	DataPopupHint.SetHtml = function(html){
		$('.bx-core-adm-dialog-content-wrap-inner', this.PARTS.CONTENT_DATA).first().html(html);
	}
});