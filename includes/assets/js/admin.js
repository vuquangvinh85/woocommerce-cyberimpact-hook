/*
ADMIN FUNCTIONS
------
Woocommerce Cyber Impact Hook related functions

*/

;woocihAdminFunc = (function($) {

	/*
		Init
	 */
	(function init() {
		newsletterCheck();
	})();
	
	
	/* 
		Newsletter Checkbox 
	 */
	function newsletterCheck() {
		$('#woocih_newsletter').change(function() {
		    if(this.checked) {
		    	$(this).val('1');
		    } else {
			    $(this).val('0');
		    }
		});
	}
	
	/*
		Settings Tab	
	 */
	$('.woocih-tabs-nav div').click(function() {
		if($(this).hasClass('active')) {
			// Do nothing
		} else {
			$('.woocih-tabs-nav').find('div').removeClass('nav-tab-active');
			var currentTab = $(this).attr('id');
			$(this).addClass('nav-tab-active');
			$('.tab').hide();
			$('.' + currentTab).show();
		}
	});
	

})(jQuery);