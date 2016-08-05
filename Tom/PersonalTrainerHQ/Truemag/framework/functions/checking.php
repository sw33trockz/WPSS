<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - CHECKING

		1.1 - ST Kit

*/

/*===============================================

	C H E C K I N G
	Compatibility

===============================================*/

	/*-------------------------------------------
		1.1 - ST Kit
	-------------------------------------------*/

	global
		$kit_,
		$st_Kit,
		$st_Options;

		if ( !empty($st_Kit) && isset($st_Options['general']['stkit-min']) && version_compare( $st_Kit['version'], $st_Options['general']['stkit-min'] ) < 0 ) {

			$kit['plugins-page'] = 'plugins.php';

			$st_['message'] = __( "You're using <strong>ST Kit</strong> plugin v.%1\$s, however <strong>%2\$s</strong> theme requires <strong>ST Kit</strong> v.%3\$s or higher. Update plugin from <a href='%4\$s'>Plugins</a> page.", 'strictthemes' );
			
			$st_['fallback_theme_notice'] = sprintf( $st_['message'], $st_Kit['version'], $st_Options['general']['label'], $st_Options['general']['stkit-min'], $kit['plugins-page'] );

			add_action( 'admin_notices', 'st_fallback_theme_notice' );

		}

?>