/**
 * HGR MegaHeader: backend JS
 */
( function( $ ) {
	"use strict";
	
	 $('#menu-to-edit li.menu-item-depth-0').each(function() {

		var menu_item = $(this);
		var menu_item_id = parseInt(menu_item.attr('id').match(/[0-9]+/)[0], 10);
				
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {action: "get_megamenus", menuItemId: menu_item_id},
			cache: false,
			beforeSend: function() {},
			complete: function() {},
			success: function(response) {
				var megaMenuButton = $('<p class="field-megamenu description">').addClass("description-wide")
								.html(response)
								.on('change', function(e) {
									e.preventDefault();
									// action to be done when values is changed
									$.ajax({
										type: 'POST',
										url: ajaxurl,
										data: {
											action			:	"set_megamenu",
											'mega_menu_id'	:	$(this).find('.widefat').val(),
											'menu_item_id'	:	menu_item_id,
										},
										cache: false,
										beforeSend: function() {},
										complete: function() {},
										success: function(response) {
											//mega menu was saved for this menu item
										}
									});
								});
				$('.menu-item-settings', menu_item).append(megaMenuButton);
			}
		});
		
		
    });
	
		
} )( jQuery );