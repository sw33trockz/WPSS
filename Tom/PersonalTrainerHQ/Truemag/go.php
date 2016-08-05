<?php

/*

	Template Name: Redirect

*/

	// Check referer
	if ( strpos( $_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'] ) == false ) {

		header( 'Location: http://google.com' );
		die();

	}

	// Check query
	if ( $_SERVER['QUERY_STRING'] ) {

		header( 'Location: ' . $_SERVER['QUERY_STRING'] );
		die();

	}

	// Go to the root
	else {

		header( 'Location: /' );
		die();

	}

?>