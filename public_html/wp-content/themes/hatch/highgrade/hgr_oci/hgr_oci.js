(function($){
	
	$('#resetall').click(function(){
		
		var ele = $(this);
		if(ele.is(':checked')){
			$('.bootstrapguru_import').attr('data-reset','true');
    	}else{
        	$('.bootstrapguru_import').attr('data-reset','false');
    	}
	});
	
	$('.bootstrapguru_import').click(function(){
        // Alert regarding import
		$import_true = confirm('Are you sure to import dummy content?');
        if($import_true == false) return;
			
		// disable import buttons
		$('.bootstrapguru_import').attr("disabled","disabled");
			
		// scroll page to top
		$("html, body").animate({ scrollTop: 0 }, "slow");
			
		// ajax loader display and notification that import has started
       // $('.import_message').html('<img src="'+this_dir+'ajax-loader.gif"> Data is being imported please be patient, it may take a few minutes, depending on your server configuration...');
        
		var data = {
            'action'		:	'install_demo',
			'demo'		:   $(this).attr('data-install'),
			'datareset'	:	$(this).attr('data-reset'),
        };

       // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      	$.post(ajaxurl, data, function(response) {
            $('.import_message').html('<div class="import_message_success">'+ response +'</div>');
            
			$('.bootstrapguru_import').removeAttr("disabled");
			
			$('#resetall').attr('checked', false);
			
        });
		
    });
	
})(jQuery);