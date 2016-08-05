/*

	01. - Dinamic styles holder
	02. - Drop-Down menu
	03. - Quick reply form
	04. - Textarea
	05. - Sticked div
	06. - Tag cloud
	07. - Archives & Categories
	08. - Original size of images
	09. - Max size for YouTube & Vimeo video
	10. - ST Gallery
	11. - Sticked menu
	12. - Search form on header
	13. - BuddyPress fixes
	14. - For IE only
	15. - WooCommerce
	16. - Select

*/

/* jshint -W099 */
/* global jQuery:false */

var p = jQuery.noConflict();

p(function(){

	'use strict';



/*==01.==========================================

 	D I N A M I C   S T Y L E S
	Holder for dinamic styles

===============================================*/

	if ( !p('#st-dynamic-css').length ) {

		p('head').append('<style id="st-dynamic-css" type="text/css"></style>');

	}



/*==02.==========================================

	D R O P - D O W N   M E N U
	Main menu on responsive mode

===============================================*/

/*

	1 - DROP-DOWN MENU

		1.1 - Default
		1.2 - Custom

*/

	/*-------------------------------------------
		1.1 - Default
	-------------------------------------------*/

	p('#menu #page_id').change(function() {

		var
			val = p(this).val();

			if ( val ) {
				p(this).parent().submit(); }

	});


	/*-------------------------------------------
		1.2 - Custom
	-------------------------------------------*/

	p('#selectElement').change(function() {

		if ( p(this).val() ) {
			window.open( p(this).val(), '_parent' ); }

	});



/*==03.==========================================

	Q U I C K   R E P L Y   F O R M
	Append and remove quick form

===============================================*/

/*

	1 - QUICK REPLY FORM

		1.1 - Open form
		1.2 - Cancel reply

*/

	/*-------------------------------------------
		1.1 - Open form
	-------------------------------------------*/

	p('a.quick-reply').click(function(){


		/*--- First of all -----------------------------*/

		// Make previous Reply link visible
		p('.quick-reply').removeClass('none');

		// Make previous Cancel Reply link hidden
		p('.quick-reply-cancel').addClass('none');

		// Erase all quick holders
		p('.quick-holder').html('');

		// Make comment form visible
		p('#commentform').removeClass('none');


		/*--- Append new form -----------------------------*/

		var
			id = p(this).attr('title'),
			form = p('#respond').html();

			// Make this Reply link hidden
			p(this).addClass('none');

			// Make this Cancel Reply link visible
			p(this).next().removeClass('none');

			// Hide major form
			p('#commentform, #reply-title').addClass('none');

			// Put the form to the holder
			p('#quick-holder-' + id).append(form).find('h3').remove();

			// Set an ID for hidden field
			p('#quick-holder-' + id + ' input[name="comment_parent"]').val(id);

			// Fix placeholders for IE8,9
			if ( p('body').hasClass('ie8') || p('body').hasClass('ie9') ) {
				
				p('.input-text-box input[type="text"], .input-text-box input[type="email"], .input-text-box input[type="url"]', '#quick-holder-' + id).each( function(){ p(this).val( p(this).attr('placeholder') ); } );

			}


		return false;

	});


	/*-------------------------------------------
		1.2 - Cancel reply
	-------------------------------------------*/

	p('.quick-reply-cancel').click(function(){

		// Make previous Reply link visible
		p('.quick-reply').removeClass('none');

		// Make this Cancel Reply link hidden
		p(this).addClass('none');

		// Erase all quick holders
		p('.quick-holder').html('');

		// Make comment form visible
		p('#commentform, #reply-title').removeClass('none');

		return false;

	});



/*==04.==========================================

 	T E X T A R E A
	Animation by focus

===============================================*/

	p('#layout').on('focus', 'textarea', function() {

		if ( !p(this).is('#whats-new') && p(this).height() < 151 && ! p(this).hasClass( 'height-ready' ) ) {

			p(this)
				.css({ height: 70 })
				.animate({ height: 150 }, 300, function(){ p(this).addClass( 'height-ready' ); });

		}

	});



/*==05.==========================================

 	S T I C K E D   D I V
	Sticked container

===============================================*/

	st_sticky_div();

	function st_sticky_div() {

		if ( p('#stickyDiv').length ) {
	
			var
				el = p('#stickyDiv'),
				stickyTop = p('#stickyDiv').offset().top,
				margin = p('#wpadminbar').length ? p('#wpadminbar').height() : 0;

				p(window).scroll(function(){

					var
						stickyHeight = p('#stickyDiv').outerHeight(true),
						limit = p('#footer').offset().top - stickyHeight,
						windowTop = p(window).scrollTop();


						/*--- by top -----------------------------*/
	
						if ( stickyTop < windowTop + 60 + margin ) {

							el.css({ position: 'fixed', top: 60 + margin });

						}
	
						else {

							el.css( 'position', 'static' );
	
						}

	
						/*--- by footer -----------------------------*/
	
						if ( limit < windowTop + 90 ) {
							
							var
								diff = limit - windowTop;

								el.css({ position: 'fixed', top: diff });
	
						}

				});
	
		}

	}



/*==06.==========================================

 	T A G   C L O U D
	Add number of posts for each tag

===============================================*/

	p('.tagcloud a').each(function(){

		var
			number = p(this).attr('title').split(' ');

			number = '<span>' + number[0] + '</span>';

			p(this).append(number).attr('title','');

	});



/*==07.==========================================

 	A R C H I V E S & C A T E G O R I E S
	Replace count wrapper on widgets,
	e.g. from (7) to <span>7</span>

===============================================*/

	p('.widget_archive li, .widget_categories li').each(function(){

		var
			str = p(this).html();

			str = str.replace(/\(/g,"<span>");
			str = str.replace(/\)/g,"</span>");
			
			p(this).html(str);

	});



/*==08.==========================================

 	O R I G I N A L   S I Z E
	For images and others

===============================================*/

	p('.size-original').removeAttr('width').removeAttr('height');



/*==09.==========================================

 	V I D E O   R E S I Z E
	Max size for YouTube & Vimeo video

===============================================*/

	function st_video_resize(){
//	window.st_video_resize = function(){

		p('iframe').each(function(){

			var
				src = p(this).attr('src');

				if ( src ) {

					var
						check_youtube = src.split('youtube.com'),
						check_vimeo = src.split('vimeo.com'),
						check_ted = src.split('ted.com'),
						check_ustream = src.split('ustream.tv'),
						check_metacafe = src.split('metacafe.com'),
						check_rutube = src.split('rutube.ru'),
						check_mailru = src.split('video.mail.ru'),
						check_vk = src.split('vk.com'),
						check_yandex = src.split('video.yandex'),
						check_dailymotion = src.split('dailymotion.com');
		
						if (
							check_youtube[1] ||
							check_vimeo[1] ||
							check_ted[1] ||
							check_ustream[1] ||
							check_metacafe[1] ||
							check_rutube[1] ||
							check_mailru[1] ||
							check_vk[1] ||
							check_yandex[1] ||
							check_dailymotion[1]
							) {
		
								var
									parentWidth = p(this).parent().width(),
									w = p(this).attr('width') ? p(this).attr('width') : 0,
									h = p(this).attr('height') ? p(this).attr('height') : 0,
									ratio = h / w,
									height = parentWidth * ratio;
			
									if ( w > 1 ) {
										p(this).css({ 'width': parentWidth, 'height': height }); }
		
						}

				}

		});

	}

	st_video_resize();

	p(window).resize( st_video_resize );

	// BuddyPress
	if ( p('#buddypress').length ) {
		setInterval( st_video_resize, 3000 ); }


/*==10.==========================================

 	S T   G A L L E R Y
	ST Gallery script

===============================================*/

	stG_init();
	
	function stG_init() {

		p('.st-gallery').each(function(){

			p('img',this).addClass('st-gallery-pending').last().addClass('st-gallery-last');

			var
				slides = p(this).html(),
				check = slides.split('img'),
				controls = '<ol>';

				for ( var i = 1; i < check.length; i++ ) {
					if ( i === 1 ) {
						controls += '<li class="st-gallery-tab-current"></li>'; }
					else {
						controls += '<li></li>'; }
				}

				controls += '</ol>';

				p(this).html( '<div>' + slides + '</div>' + controls );

				p('div img:first-child',this).removeClass('st-gallery-pending').addClass('st-gallery-current');

		});

	}

	p('.st-gallery div img').on( 'click touchstart', function(){

		if ( ! p(this).parent().hasClass('st-gallery-locked') ) {

			var
				img = p(this),
				gallery = p(this).parent(),
				current = gallery.find('.st-gallery-current'),
				hCurrent = gallery.height(),
				imgIndex = img.prevAll().length,
				tabs = img.parent().next( 'ol' );

				gallery.addClass('st-gallery-locked');

				var
					nextImage = ( current.hasClass('st-gallery-last') ? gallery.find('img').first() : gallery.children().eq( imgIndex + 1 ) );

					current
						.removeClass('st-gallery-current').addClass('st-gallery-flushed').stop(true,false)
						.animate({ 'opacity': 0 }, 300,
							function(){
								p(this).removeAttr('style').removeClass('st-gallery-flushed').addClass('st-gallery-pending');
								gallery.removeClass('st-gallery-locked');
							});

					nextImage.removeClass('st-gallery-pending').addClass('st-gallery-current');

					var
						hNext = nextImage.height();

						if ( hNext !== 0 ) {
							gallery.css( 'height', hCurrent ).stop(true,false).animate({ 'height': hNext }, 700 ); }
						else {
							gallery.css( 'height', 'auto' ); }

					var
						currentTab = nextImage.prevAll().length;
	
						tabs.children( '.st-gallery-tab-current' ).removeClass( 'st-gallery-tab-current' );
						tabs.children().eq( currentTab ).addClass( 'st-gallery-tab-current' );

		}

	});

	p('.st-gallery ol li').click(function(){

		p(this).each(function(){

			var
				no = p(this).prevAll().length,
				gallery = p(this).parent().parent().find('div'),
				current = gallery.find('.st-gallery-current'),
				h = gallery.children().eq( no ).height();

				p(this).parent().find('.st-gallery-tab-current').removeClass('st-gallery-tab-current');
				p(this).addClass('st-gallery-tab-current');

				current.removeClass('st-gallery-current').addClass('st-gallery-pending');

				gallery.css( 'height', h );

				gallery.children().eq( no )
					.removeClass('st-gallery-pending')
					.addClass('st-gallery-flushed')
					.css({ opacity: 0 })
					.removeClass('st-gallery-flushed')
					.addClass('st-gallery-current')
					.removeAttr('style');

				gallery.removeAttr('style');

		});

	});



/*==11.==========================================

 	S T I C K E D   M E N U
	Sticked primary menu

===============================================*/

	function st_sticky_menu_reset() {

		p('#menu').removeClass('menu-sticky menu-sticky-now').removeAttr('style');
		p('#header-holder').removeAttr('style');

	}

	function st_sticky_menu() {

		if ( !p('body').hasClass('ie8') && p('#menu').length && !p('#menu').hasClass('no-sticky-menu') ) {

			var
				el = p('#menu'),
				stickyTop = p('#menu').offset().top,
				stickyHeight = p('#menu').outerHeight(true),
				margin = p('#wpadminbar').length ? p('#wpadminbar').height() : 0;

				// Flushing
				if ( el.hasClass('menu-sticky') ) {

					el.css({ opacity: 1, top: 'auto' }).removeClass('menu-sticky').removeClass('menu-sticky-now');
					p('#header-holder').css({ paddingBottom: 0 });

				}

				p(window).scroll(function(){

					if ( p('#content-holder').width() > 934 ) {

						var
							windowTop = p(window).scrollTop();
		
		
							if ( stickyTop < windowTop - 100 ) {
	
								if ( !el.hasClass('menu-sticky') ) {
									el.addClass('menu-sticky').addClass('menu-sticky-now').css({ opacity: 1, top: -stickyHeight }).stop(true,false).animate({ top: 0 + margin }, 300);
									p('#header-holder').css({ paddingBottom: stickyHeight });
								}
		
							}
		
							else {
	
								if ( el.hasClass('menu-sticky-now') ) {

									el.removeClass('menu-sticky-now').stop(true,false).animate({ top: -stickyHeight }, 300,
										function(){
											el.css({ 'display': 'table', top: 0, opacity: 0 }).removeClass('menu-sticky').stop(true,false).animate({ top: 0, opacity: 1 }, 300, function(){ p('#menu').removeAttr('style'); });
											p('#header-holder').css({ paddingBottom: 0 });
										});

								}
	
							}

					}

					else {

						if ( el.hasClass('menu-sticky') ) {

							el.css({ opacity: 1, top: 'auto' }).removeClass('menu-sticky');
							p('#header-holder').css({ paddingBottom: 0 });

						}

					}

				});

		}

	}

	setTimeout( st_sticky_menu, 1000 );

	p(window).resize( st_sticky_menu_reset );


/*==12.==========================================

	S E A R C H
	Search form on header

===============================================*/

	/*-------------------------------------------
		2.1 - Search
	-------------------------------------------*/

	p('#layout').on('mousedown touchstart', '#search-form-header span', function(){

		if ( !p(this).parent().hasClass('search-form-header') ) {
			p(this).parent().addClass('search-form-header'); }

		else {
			p(this).parent().removeClass('search-form-header');	}

	});

	p('#search-form-header').on( 'mouseenter', 'span', function() {
		p('#search-form-header span').parent().addClass('search-form-header');
	});


/*==13.==========================================

	B U D D Y P R E S S
	BuddyPress fixes

===============================================*/

	p('body.group-create h1.page-title a').addClass('button').addClass('bp-title-button');


/*==14.==========================================

	F O R   I E   O N L Y
	IE fixes

===============================================*/

/*

	1. - Quick reply form
	2. - OnBlur/OnFocus for input fields
	3. - Dummy Search
	4. - Dummy Subscribe

*/


	if ( p('#ie8-detect').length ) { p('body').addClass('ie8'); }
	if ( p('#ie9-detect').length ) { p('body').addClass('ie9'); }


	if ( p('body').hasClass('ie8') || p('body').hasClass('ie9') ) {
	

		/*-------------------------------------------
			1 - Append and remove quick form
		-------------------------------------------*/
	
		/*
		
			1 - QUICK REPLY FORM
		
				1.1 - Remove dummy before submiting
				1.4 - Return dummy after unsuccess submiting
		
		*/
	
	
		/* 1.1 - Remove a dummy before submitting
		===========================================*/
	
		p('#layout')
	
			.on('mousedown touchstart', '.form-submit input[type="submit"]', function(){
	
				p(this).parent().parent().find('input[type="text"]')
					.each(function(){
	
						var
							dummy = p(this).attr('placeholder'),
							val = p(this).val();
			
							if ( dummy === val ) {
								p(this).val(''); }
	
					});
	
			});
	
	
		/* 1.2 - Return a dummy after unsuccess submitting
		===========================================*/
	
		p('body').on('ready mouseenter touchstart', '#layout', function(){
	
			p('input[type="text"]',this).each(function(){
	
				var
					dummy = p(this).attr('placeholder'),
					val = p(this).val();
	
					if ( !val ) {
						p(this).val(dummy); }
	
			});
	
		});
	
	
		/*-------------------------------------------
			2 - For input fields
		-------------------------------------------*/
	
		p('#layout')
	
			.on('focus', 'input[type="text"]', function(){
	
				var
					dummy = p(this).attr('placeholder'),
					val = p(this).val();
	
					if ( dummy === val ) {
						p(this).val(''); }
	
				})
	
			.on('blur', 'input[type="text"]', function(){
	
				var
					dummy = p(this).attr('placeholder'),
					val = p(this).val();
	
					if ( !val ) {
						p(this).val(dummy); }
	
				});
	
	
		/*-------------------------------------------
			3 - Dummy data for search input field
		-------------------------------------------*/
	
		p('.searchform').each(function(){
	
			var
				dummy = p('input[type="submit"]',this).val();
	
				p('input[name="s"]',this).val(dummy).attr('placeholder', dummy);
	
		});
	
	
		/*-------------------------------------------
			4 - Dummy data for subscribe form
		-------------------------------------------*/
	
		p('.feedemail-input').each(function(){
	
			var
				dummy = p(this).attr('placeholder');
	
				p(this).val(dummy);
	
		});


	} // if ( p('body').hasClass('ie8') || p('body').hasClass('ie9') )


/*==15.==========================================

	W O O C O M M E R C E
	Custom things for WooCommerce

===============================================*/

/*

	1. - Re-build thumbnail
	2. - Add class to Read More button
	3. - Remove the First class
	4. - Replace upsell products
	5. - Replace related products
	6. - Replace crosssell products

*/

	if ( p('div').hasClass('woocommerce') || p('body').hasClass('woocommerce-page') ) {
	
	
		/*-------------------------------------------
			1. - Re-build thumbnail
		-------------------------------------------*/
	
		p('ul.products > li > a:first-child').each(function(){
	
			var
				sale = p('.onsale',this).length ? p('.onsale',this)[0].outerHTML : '',
				img = p('img',this).length ? p('img',this)[0].outerHTML : '',
				title = p('h3',this).length ? p('h3',this)[0].outerHTML : '',
				rating = p('.star-rating',this).length ? p('.star-rating',this)[0].outerHTML : '',
				price = p('.price',this).length ? p('.price',this)[0].outerHTML : '';
	
				// Replace everything
				p(this).html( '<div class="div-as-table st-woo-hover"><div><div>' + rating + title + '</div></div></div>' + sale + img );
	
				// Replace a price
				p(this).parent().append( '<div class="div-as-table st-woo-price"><div><div>' + price + '</div></div></div>' );
	
				// Add class when it ready be shown
				p(this).parent().addClass('st-woo');
	
		});
	
		/*-------------------------------------------
			2. - Add class to Read More button
		-------------------------------------------*/
	
		p('a.add_to_cart_button').each(function(){
	
			var
				check = p(this).attr('href');
	
				check = check.split('?add-to-cart=');
	
				if ( check[1] === undefined ) {
					p(this).addClass('read_more_button'); }
	
		});
	
		/*-------------------------------------------
			3. - Remove the First class
		-------------------------------------------*/
	
		p('.woocommerce .product .thumbnails a').each(function(){
	
			p(this).removeClass('first').removeClass('last');
	
		});
	
		/*-------------------------------------------
			4. - Replace upsell products
		-------------------------------------------*/
	
		p('.woocommerce .product .upsells').each(function(){
	
			p('li.last',this).removeClass('last');
			p('li.first',this).removeClass('first');
	
			var
				related = p(this).html();
	
				p(this).parent().parent().append( '<div class="st-woo-upsells">' + related + '<div class="clear"></div></div>' );
	
				p(this).remove();
	
		});
	
		/*-------------------------------------------
			5. - Replace related products
		-------------------------------------------*/
	
		p('.woocommerce .product .related').each(function(){
	
			p('li.last',this).removeClass('last');
			p('li.first',this).removeClass('first');
	
			var
				related = p(this).html();
	
				p(this).parent().parent().append( '<div class="st-woo-related">' + related + '<div class="clear"></div></div>' );
	
				p(this).remove();
	
		});
	
		/*-------------------------------------------
			6. - Replace crosssell products
		-------------------------------------------*/
	
		p('.woocommerce .cross-sells').each(function(){
	
			var
				cross = p(this).html();
	
				p(this).html( '<div class="st-woo-cross">' + cross + '<div class="clear"></div></div>' );
	
				//p(this).remove();
	
		});
	
	
	} // if ( p('body').hasClass('woocommerce') )


/*==16.==========================================

	S E L E C T
	Webkit fixes

===============================================*/

	/*p('body.chrome select, body.safari select').each(function(){

		var
			tag = p(this).parent().prop('tagName');

			if ( tag !== 'LABEL' ) {

				p(this).wrap('<label class="st-select-label"></label>');

			}

	});*/


});