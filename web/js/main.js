jQuery(function($) {

	$(function(){
		$('#main-slider.carousel').carousel({
			interval: 10000,
			pause: false
		});
	});

	//Ajax contact
	var form = $('.contact-form');
	form.submit(function () {
		$this = $(this);
		$.post($(this).attr('action'), function(data) {
			$this.prev().text(data.message).fadeIn().delay(3000).fadeOut();
		},'json');
		return false;
	});

	//smooth scroll
	//$('.navbar-nav > li').click(function(event) {
	//	event.preventDefault();
	//	var target = $(this).find('>a').prop('hash');
	//	$('html, body').animate({
	//		scrollTop: $(target).offset().top
	//	}, 500);
	//});

	//scrollspy
	//$('[data-spy="scroll"]').each(function () {
	//	var $spy = $(this).scrollspy('refresh')
	//})

	//PrettyPhoto
	$("a.preview").prettyPhoto({
		social_tools: false
	});
    //
    //$("*:not(.clone) a[data-rel^='prettyPhoto']").prettyPhoto({
    //    animation_speed: 'fast', /* fast/slow/normal */
    //    slideshow: 10000, /* false OR interval time in ms */
    //    autoplay_slideshow: false, /* true/false */
    //    opacity: 0.8, /* Value between 0 and 1 */
    //    show_title: true, /* true/false */
    //    allow_resize: true, /* Resize the photos bigger than viewport. true/false */
    //    default_width: 500,
    //    default_height: 344,
    //    counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
    //    theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
    //    horizontal_padding: 20, /* The padding on each side of the picture */
    //    autoplay: true, /* Automatically start videos: True/False */
    //    deeplinking: false, /* Allow prettyPhoto to update the url to enable deeplinking. */
    //    overlay_gallery: false, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
    //    keyboard_shortcuts: true, /* Set to false if you open forms inside prettyPhoto */
    //    social_tools: false /* html or false to disable; comment out this line to enable this option with default html content */
    //});

	//Isotope
	$(window).load(function(){
		$.Isotope.prototype._positionAbs = function( x, y ) {
			return { right: x, top: y };
		};
		$portfolio = $('.portfolio-items');
		$portfolio.isotope({
			itemSelector : 'li',
			layoutMode : 'fitRows',
			transformsEnabled: false
		});
		$portfolio_selectors = $('.portfolio-filter >li>a');
		$portfolio_selectors.on('click', function(){
			$portfolio_selectors.removeClass('active');
			$(this).addClass('active');
			var selector = $(this).attr('data-filter');
			$portfolio.isotope({ filter: selector });
			return false;
		});

		$('.all_portfolio_button').trigger('click');

	});
});