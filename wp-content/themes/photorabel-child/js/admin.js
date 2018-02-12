jQuery(document).ready(function($) {
	/* Function Area */

	function allEvents() {
		var navHeight = $('#mainNav').outerHeight();
		var navWidth = $('#mainNav .navbar-collapse .navbar-nav.sidebar-nav').outerWidth();
		var navWidthInner = $('#mainNav .navbar-collapse .navbar-nav.sidebar-nav > ul > li').outerWidth();
		var winHeight = $(window).outerHeight();
		var winWidth = $(window).outerWidth();
		var marRight = (navWidth - navWidthInner) * -1;
		$('#mainNav .navbar-collapse .navbar-nav.sidebar-nav').removeAttr('style');
		$('#mainNav .navbar-collapse .navbar-nav.sidebar-nav').css({
			'margin-top': navHeight,
			'height': winHeight + 18 - navHeight
		});

		$('.admin-section').css({
			'margin-left': navWidth,
			'margin-top': navHeight,
			'width': winWidth - navWidth
		});

		$('#mainNav .navbar-collapse .navbar-nav.sidebar-nav > ul').css({
			"margin-right": marRight
		});

		if (winWidth < 992) {
			$('#mainNav .navbar-collapse .navbar-nav.sidebar-nav, .admin-section').removeAttr('style');
		}

		var a = window.location.pathname;
		$('.sidebar-nav ul li').each(function() {
			var b = $(this).find('a').attr('href');
			if (a.indexOf(b) > -1) {
				console.log(a + ' = ' + b);
				$(this).addClass('current-menu-item');
				$(this).siblings().removeClass('current-menu-item');
			} else {
				$(this).removeClass('current-menu-item');
			}
		});

		var smallWidth = $('.noti-count small').outerWidth() + 16;
		$('.noti-count').css({
			'height': smallWidth,
			'width': smallWidth
		});
	}

	/*/////////////////////////// Event Area ///////////////////////////*/

	/* Ready Event */
	allEvents();

	/* Load Event */
	$(window).on('load', function() {
		allEvents();
	});
	/* Resize Event */
	$(window).on('resize', function() {
		allEvents();
	});

	/*////////////////////////// Custom Events //////////////////////////*/
	$('.tabSection').on('click', 'a', function() {
		var tabtarget = $(this).data('tabtarget');
		if(tabtarget != 'undefined') {
			$(this).parent().siblings().removeClass('active');
			$(this).parent().addClass('active');
			$('.tabs').hide();
			$('.tabs.' + tabtarget).show();
		}
	})
});