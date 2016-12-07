//	Backbone v1.7, Copyright 2014, Joe Mottershaw, https://github.com/joemottershaw/
//	================================================================================

//	Table of Contents
//	==================================================
//		#Tipsy
//		#Scroll To Top


//	#Tipsy
//	==================================================

	// Show/Hide
		$('.tip-tl').tipsy({ gravity: 'se', html: true, title: 'data-tooltip', offset: 5 });
		$('.tip-t').tipsy({ gravity: 's', html: true, title: 'data-tooltip', offset: 5 });
		$('.tip-tr').tipsy({ gravity: 'sw', html: true, title: 'data-tooltip', offset: 5 });
		$('.tip-r').tipsy({ gravity: 'w', html: true, title: 'data-tooltip', offset: 5 });
		$('.tip-br').tipsy({ gravity: 'nw', html: true, title: 'data-tooltip', offset: 5 });
		$('.tip-b').tipsy({ gravity: 'n', html: true, title: 'data-tooltip', offset: 5 });
		$('.tip-bl').tipsy({ gravity: 'ne', html: true, title: 'data-tooltip', offset: 5 });
		$('.tip-l').tipsy({ gravity: 'e', html: true, title: 'data-tooltip', offset: 5 });

	// Fade In/Out
		$('.tip-tl-fade').tipsy({ gravity: 'se', html: true, title: 'data-tooltip', offset: 5, fade: true, fadeSpeed: 150 });
		$('.tip-t-fade').tipsy({ gravity: 's', html: true, title: 'data-tooltip', offset: 5, fade: true, fadeSpeed: 150 });
		$('.tip-tr-fade').tipsy({ gravity: 'sw', html: true, title: 'data-tooltip', offset: 5, fade: true, fadeSpeed: 150 });
		$('.tip-r-fade').tipsy({ gravity: 'w', html: true, title: 'data-tooltip', offset: 5, fade: true, fadeSpeed: 150 });
		$('.tip-br-fade').tipsy({ gravity: 'nw', html: true, title: 'data-tooltip', offset: 5, fade: true, fadeSpeed: 150 });
		$('.tip-b-fade').tipsy({ gravity: 'n', html: true, title: 'data-tooltip', offset: 5, fade: true, fadeSpeed: 150 });
		$('.tip-bl-fade').tipsy({ gravity: 'ne', html: true, title: 'data-tooltip', offset: 5, fade: true, fadeSpeed: 150 });
		$('.tip-l-fade').tipsy({ gravity: 'e', html: true, title: 'data-tooltip', offset: 5, fade: true, fadeSpeed: 150 });


//	#Scroll To Top
//	==================================================

	$(document).ready(function() {
		$('.scroll-to-top').click(function() {
			$('html, body').animate({ scrollTop: 0 }, 1600, 'easeInOutQuart');
			return false;
		});
	});