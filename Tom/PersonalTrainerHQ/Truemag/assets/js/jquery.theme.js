/*

	1 - RELATED POSTS

		1.1 - Post height

*/

/* jshint -W099 */
/* global jQuery:false */

var t = jQuery.noConflict();

t(function(){

	'use strict';

/*

	stData[0] - Primary color
	stData[1] - Secondary color

*/

/*===============================================

	R E L A T E D   P O S T S
	Set come dimensions

===============================================*/

	/*-------------------------------------------
		1.1 - Post height
	-------------------------------------------*/

	function st_related_posts_height() {

		var
			rHeightDetails = 0;

			t('.posts-related-details-wrapper > div').each(function(){

				if ( t(this).outerHeight() > rHeightDetails ) {
					rHeightDetails = t(this).outerHeight(); }

			});

			t('.posts-related-wrapper .posts-related-details-wrapper').stop(true, false).animate({ 'height': rHeightDetails }, 250, function(){ t(this).eq(0).animate({ 'opacity': '1' }, 500); });

	}

	function st_the_related_posts_height() {
		setTimeout( st_related_posts_height, 1000 );
	}

	st_the_related_posts_height();

	t(window).resize( st_the_related_posts_height );

});