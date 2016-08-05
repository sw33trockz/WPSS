<?php if ( !defined( 'ABSPATH' ) ) exit;

	global
		$st_;

		$st_['sidebar'] = !empty( $st_['sidebar'] ) ? $st_['sidebar'] : 'Default Sidebar';

		echo '<div id="sidebar"><div class="sidebar">';
	
			dynamic_sidebar( $st_['sidebar'] );
	
		echo '</div></div>';

?>

