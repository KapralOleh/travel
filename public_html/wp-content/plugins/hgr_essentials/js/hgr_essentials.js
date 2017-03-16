/**
 * HGR Essentials: Front End
 */
( function( $ ) {
	"use strict";
	
	// lock scroll position, but retain settings for later
	var scrollPosition = [
		self.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
		self.pageYOffset || document.documentElement.scrollTop  || document.body.scrollTop
	];
	
	
	$('.fssearch a').click(function(event) {
		event.preventDefault();
		
		var html = $('html'); // it would make more sense to apply this to body, but IE7 won't have that
		html.data('scroll-position', scrollPosition);
		html.data('previous-overflow', html.css('overflow'));
		html.css('overflow', 'hidden');
	  
		$('#fssearch_container').fadeIn('fast').removeClass('hidden').addClass('is-visible');
		$('.fssearch_input').focus();
		
		return false;
	});
	
	//close the testimonials modal page
	$('#fssearch_container .close-btn').click(function(event) {
		event.preventDefault();
		$('#fssearch_container').fadeOut('fast').removeClass('is-visible').addClass('hidden');
		$('.fssearch_input').attr('value','');
		// un-lock scroll position
		var html = $('html');
		var scrollPosition = html.data('scroll-position');
		html.css('overflow', html.data('previous-overflow'));
	});
	
	$(document).keyup(function(event){
		//check if user has pressed 'Esc'
    	if(event.which=='27'){
			// un-lock scroll position
			var html = $('html');
			var scrollPosition = html.data('scroll-position');
			html.css('overflow', html.data('previous-overflow'));
			$('#fssearch_container').fadeOut('fast').removeClass('is-visible').addClass('hidden');
			$('.fssearch_input').attr('value','');
	    }
    });
		
} )( jQuery );