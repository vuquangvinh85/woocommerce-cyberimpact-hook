/*
FRONT-END FUNCTIONS
------
Woocommerce Cyber Impact Hook related functions

*/

;woocihFunc = (function($) {

	/*
		Init
	 */
	(function init() {
		woocihLang();
	})();
	
	
	/* 
		Language Populate 
	 */
	function woocihLang() {
		$('html[lang="fr-FR"] #woocih_language').val('fr_ca');
		$('html[lang="en-US"] #woocih_language').val('en_ca');
		$('#woocih_language_field').hide();
	}
	

})(jQuery);