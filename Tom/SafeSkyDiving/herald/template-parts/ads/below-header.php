<?php if( $ad = herald_get_option('ad_below_header') ): ?>
	<div class="herald-ad herald-slide herald-below-header"><?php echo do_shortcode( $ad ); ?></div>
<?php endif; ?>