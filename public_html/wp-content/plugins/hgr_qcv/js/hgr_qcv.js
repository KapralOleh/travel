/**
 * HGR AddOn's: Quick Cart View -> Front End
 */
( function( $ ) {
	"use strict";
	function displayQCV(){$('#qcv_container').fadeIn('fast').removeClass('hidden').addClass('is-visible');}
	function hideQCV(){$('#qcv_container').fadeOut('fast').removeClass('is-visible').addClass('hidden');}
	// diabled on mobile ios
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	} 
	else {
		$(".woo_bubble").hoverIntent({over:displayQCV,out:hideQCV,timeout:250});
	}
} )( jQuery );

