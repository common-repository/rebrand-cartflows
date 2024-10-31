jQuery(document).ready(function() {
	
	jQuery('.flows-wl-setting-tabs').on('click', '.flows-wl-tab', function(e) {
		e.preventDefault();
		var id = jQuery(this).attr('href');
		jQuery(this).siblings().removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.flows-wl-setting-tabs-content .flows-wl-setting-tab-content').removeClass('active');
		jQuery('.flows-wl-setting-tabs-content').find(id).addClass('active');
	});


});
 
