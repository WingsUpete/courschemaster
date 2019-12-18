window.Initialize = window.Initialize || {};

/**
 * Initialize
 *
 * This module is for initialization.
 * Components that all pages are using have
 * to specify their handlers here
 *
 * @module Initialize
 */
(function (exports) {

    'use strict';
	

	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
		
		window.console = window.console || function () {
		}; // IE compatibility
		
		//	When the window is resized, re-define the 
		//	footer's position at the page
		var t_ft = null;
		$(window).on('resize', function() {
			if (t_ft) {
				clearTimeout(t_ft);
			}
			t_ft = setTimeout(function() {
				if ($('.navbar-toggler').hasClass('change_navicon')) {
					$('.navbar-toggler').trigger('click');
				}
				GeneralFunctions.placeFooterToBottom();
			}, 500);
		}).trigger('resize');
		
		//	Loading Icon will do their work on ajax
		$(document).ajaxStart(function () {
			$('#loading').fadeIn();
		});
		$(document).ajaxStop(function () {
			$('#loading').fadeOut();
		});
		
		//	Navicon
		$('#navCourschemaster').on('show.bs.collapse', function() {
			if ($('.sidenav').css('position') === 'fixed') {
				$('.sidenav').addClass('fixed swipe_down');
			}
			$(this).find('.navbar-toggler').addClass('change_navicon');
			$(this).find('ul.navbar-nav').css('display', 'block');
			$(this).find('li.nav-item.phd').hide();
			GeneralFunctions.placeFooterToBottom();	// fix footer issue
		}).on('hidden.bs.collapse', function() {
			$(this).find('.navbar-toggler').removeClass('change_navicon');
			$(this).find('ul.navbar-nav').css('display', 'flex');
			$(this).find('li.nav-item.phd').show();
			GeneralFunctions.placeFooterToBottom();	// fix footer issue
		}).on('hide.bs.collapse', function() {
			if ($('.sidenav').css('position') === 'fixed') {
				$('.sidenav').removeClass('fixed swipe_down');
			}
			GeneralFunctions.placeFooterToBottom();	// fix footer issue
		});	
		
//		//	tooltip: my is the position of the triangle leadout,
//		//	at is the content position
//		$('.menu-item').qtip({
//			position: {
//				my: 'top center',
//				at: 'bottom center'
//			},
//			style: {
//				classes: 'qtip-green qtip-shadow custom-qtip'
//			}
//		});
		
		//	Generate a sidebar width according to the maximum item width
		var maxWidth = Number.NEGATIVE_INFINITY;
		$.each($('#sidebar .sidenav-items a span.sd_epn'), function(index, item) {
			var width = $(item).width() + 100;
			if (width > maxWidth) {
				maxWidth = width;
			}
		});
		$('head').append('<style>.sidenav.expanded{width:' + maxWidth + 'px;}.sidenav.expanded ~ .main-content{margin-left:' + maxWidth + 'px;}</style>');
		
		//	Language Selection
		GeneralFunctions.enableLanguageSelection($('#select-language'));
	});
	
	window.addEventListener('load', function() {
		//	after everything loaded, show body content
		setTimeout(function() {
			$('#body-container').css('opacity', '1.0');
			$('#bg-img').css('opacity', '0.08');
		}, 666);
	});

})(window.Initialize);
