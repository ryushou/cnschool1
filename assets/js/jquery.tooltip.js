(function($) {
	// Register namespace
	$.extend(true, window, {
		"jqueryToolTip": Tooltip
	});

	function Tooltip(options) {
		var _defaults = {
			tooltipCss: {
				'position': 'absolute',
				'z-index': '10000',
				'left': '0px',
				'top': '0px',
				'display': 'none',
				'border': '2px solid #666',
				'border-radius': '3px',
				'background-color': '#FFF',
				'color': '#333',
				'font': '14px "Helvetica Neue",Helvetica,Arial,sans-serif',
				'text-align': 'left',
				'line-height': '150%',
				'width': 'auto',
				'z-index': '10000',
				'-moz-box-shadow': '1px 1px 3px #707070',
				'-webkit-box-shadow': '1px 1px 4px #707070'
			},
			tooltipOffsetX: 10,
	    	tooltipOffsetY: 30,
			tooltipId: 'jquery-tooltip-id',
			tooltipClass: 'span.jquery-tooltip-class',
			tooltipContentClass: 'span.jquery-tooltip-content-class'
		};
		options = $.extend(true, {}, _defaults, options);

		var $tooltip = $("<div />").css(options.tooltipCss)
                          .attr("id", options.tooltipId)
						  .appendTo("body");

		function setTooltipEvent() {
			$.each($(options.tooltipClass), function(i, elem) {
				$(elem).hover( function(e) {
					$content = $(this).find(options.tooltipContentClass);
					if($content) {
						var x = e.pageX + options.tooltipOffsetX;
			        	var y = e.pageY - options.tooltipOffsetY;
						$tooltip.css({
							'left': x,
							'top': y
						});
		                $tooltip.html($content.html());
		                $tooltip.finish().fadeIn(100);
					}
				},
				function() {
					$tooltip.fadeOut(100);
				});
			});
		}

		// Public API
	    $.extend(this, {
	      "setTooltipEvent": setTooltipEvent
	    });
	}
})(jQuery);

$(function() {
	var tooltip = new jqueryToolTip({});
	tooltip.setTooltipEvent();
});