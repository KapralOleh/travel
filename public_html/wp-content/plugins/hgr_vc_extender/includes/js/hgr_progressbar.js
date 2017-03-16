jQuery(document).ready(function() {
  "use strict";
	var el = jQuery(".hgr_progressbar");
	jQuery(el).each(function() {
		jQuery(this).appear(function() {
			var percent = '0.'+jQuery(this).find(".hgr_progressbarfill").attr("data-value");
			var filltime = parseInt(jQuery(this).find(".hgr_progressbarfill").attr("data-time"));	
			var add_width = (percent*jQuery(".hgr_progressbarfill").parent().width())+'px';
			jQuery(this).find(".hgr_progressbarfill").animate({
				width: add_width
			}, { duration: filltime, queue: false });
		});
	});
});