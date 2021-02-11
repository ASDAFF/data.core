$.fn.dataPopup = function(options, sender) {
	
	var defaults = {
		animation: 'fadeAndPop', //fade, fadeAndPop, none
		animationspeed: 150, //how fast animtions are
		closeonbackgroundclick: true, //if you click background will modal close?
		dismissmodalclass: 'close', //the class of a button or element that will close an open modal
		callbackshow: null, // callback on each open popup
		callbackclose: null // callback on each close popup
	}; 

	var options = $.extend({}, defaults, options);

	return this.each(function() {
		
		var modal = $(this);
		
		if(this.modalTop == undefined) {
			this.modalTop = !isNaN(parseInt(modal.css('top'))) ? parseInt(modal.css('top')) : 0;
		}

		var top = this.modalTop,
			locked = false,
			modalBG = modal.next('.data-modal-bg');
		
		top_real = top + $(document).scrollTop();

		if(modalBG.length == 0) {
			modalBG = $('<div/>').addClass('data-modal-bg').insertAfter(modal);
		}

		// Entrance Animations
		modal.bind('data:open', function () {
			modalBG.unbind('click.modalDataEvent');
			$('.' + options.dismissmodalclass).unbind('click.modalDataEvent');
			if(!locked) {
				lockModal();
				if(options.animation == 'fadeAndPop') {
					modal.css({'top': $(document).scrollTop(), 'opacity' : 0, 'visibility' : 'visible', 'margin-left' : -1 * modal.width() / 2});
					modalBG.fadeIn(options.animationspeed/2);
					modal.delay(options.animationspeed/2).animate({
						'top': top_real,
						'opacity' : 1
					}, options.animationspeed,unlockModal());					
				}
				if(options.animation == 'fade') {
					modal.css({'opacity' : 0, 'visibility' : 'visible', 'top': top_real, 'margin-left' : -1 * modal.width() / 2});
					modalBG.fadeIn(options.animationspeed/2);
					modal.delay(options.animationspeed/2).animate({
						'opacity' : 1
					}, options.animationspeed,unlockModal());					
				} 
				if(options.animation == 'none') {
					modal.css({'visibility' : 'visible', 'top' : top_real});
					modalBG.css({'display':'block'});	
					unlockModal()				
				}
				if(options.callbackshow && typeof window[options.callbackshow] == 'function') {
					window[options.callbackshow](modal, modal.find('.content').first(), modal.find('.buttons').first(), modal.find('.data').first(), sender);
				}
				if(modal.data('callbackshow') && typeof window[modal.data('callbackshow')] == 'function'){
					window[modal.data('callbackshow')](modal, modal.find('.content').first(), modal.find('.buttons').first(), modal.find('.data').first(), sender);
				}
			}
			modal.unbind('data:open');
		}); 	

		// Closing Animation
		modal.bind('data:close', function () {
			if(!locked) {
				lockModal();
				if(options.animation == 'fadeAndPop') {
					modalBG.delay(options.animationspeed).fadeOut(options.animationspeed);
					modal.animate({
						'top':  $(document).scrollTop(),
						'opacity' : 0
					}, options.animationspeed/2, function() {
						modal.css({'top' : top_real, 'opacity' : 1, 'visibility' : 'hidden'});
						unlockModal();
					});					
				}  	
				if(options.animation == 'fade') {
					modalBG.delay(options.animationspeed).fadeOut(options.animationspeed);
					modal.animate({
						'opacity' : 0
					}, options.animationspeed, function() {
						modal.css({'top': top_real, 'opacity' : 1, 'visibility' : 'hidden'});
						unlockModal();
					});					
				}  	
				if(options.animation == 'none') {
					modal.css({'visibility' : 'hidden'});
					modalBG.css({'top': top_real, 'display' : 'none'});	
				}
				if(options.callbackclose && typeof window[options.callbackclose] == 'function') {
					window[options.callbackclose](modal, modal.find('.content').first(), modal.find('.buttons').first(), modal.find('.data').first(), sender);
				}
				if(modal.data('callbackclose') && typeof window[modal.data('callbackclose')] == 'function'){
					window[modal.data('callbackclose')](modal, modal.find('.content').first(), modal.find('.buttons').first(), modal.find('.data').first(), sender);
				}
			}
			modal.unbind('data:close');
		});     

		// Set vertical align
		modal.bind('data:align', function () {
			modal.delay(options.animationspeed/2).animate({
				'top': ($(document).scrollTop() + ($(window).height() - modal.height()) / 2),
				'opacity' : 1
			}, 0, unlockModal());		
		});

		//Open Modal Immediately
		modal.trigger('data:open');

		//Close Modal Listeners
		var closeButton = $('.' + options.dismissmodalclass).bind('click.modalDataEvent', function () {
			modal.trigger('data:close')
		});

		if(options.closeonbackgroundclick) {
			modalBG.css({'cursor':'pointer'})
			modalBG.bind('click.modalDataEvent', function () {
			modal.trigger('data:close')
			});
		}
		$('body').keyup(function(e) {
			if(e.which===27){ modal.trigger('data:close'); } // 27 is the keycode for the Escape key
		});

		function unlockModal() { 
			locked = false;
		}
		
		function lockModal() {
			locked = true;
		}
	
	});
}

/* Popups */
$(document).delegate('[data-data-modal]', 'click', function(e){
	e.preventDefault();
	var modalLocation = $(this).attr('data-data-modal');
	$('#'+modalLocation).dataPopup($(this).data(), $(this));
});
