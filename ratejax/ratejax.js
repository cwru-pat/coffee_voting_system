(function ($) {
	Drupal.behaviors.ratejax = {
        attach: function (context, settings) {
		
			if($("body.page-arxiv-posts").length > 0) { // on arxiv posts page
				// add in rate info divs to voted-on divs 
				for(var m in settings.ratejax) {
					var votedivid = "#rate-node-" + m.substring(4) + "-2-1";
					if($(votedivid + " .rate-info").length > 0) {
						// info already exists
					} else {
						if($(votedivid).parent().not(".ratejax-processed").length > 0) {
							$(votedivid).append("<div class='rate-info'>You voted '" + settings.ratejax[m] + "'.</div>");
							$(votedivid).parent().addClass("ratejax-processed");
						}
					}
				}
			}
			
			// add in rate-info divs where needed so "saving vote..." text appears.
			$(".rate-widget").each(
				function (index, element) {
					if($(".rate-info", element).length == 0) {
						$(element).append("<div class='rate-info'>&nbsp;</div>");
					}
				}
			);

		}
	};
	
})(jQuery);
