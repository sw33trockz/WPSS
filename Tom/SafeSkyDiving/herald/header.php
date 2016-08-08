<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="ad-container" style="text-align: center; padding: 15px 0;">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- skydiving header responsive -->
<ins class="adsbygoogle"
    style="display:block"
    data-ad-client="ca-pub-9002406242342564"
    data-ad-slot="6680296953"
    data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<!--<img id="ad-unit" style="margin: 0px auto; display: block;" src="http://www.shoutmeloud.com/wp-content/uploads/2012/05/Adsense-Guide1.jpg"> -->
</div>

	<header id="header" class="herald-site-header">

		<?php $header_sections = array_keys( array_filter( herald_get_option( 'header_sections' ) ) ); ?>
		<?php if ( !empty( $header_sections ) ): ?>
			<?php foreach ( $header_sections as $section ): ?>
				<?php get_template_part( 'template-parts/header/'.$section ); ?>
			<?php endforeach; ?>
		<?php endif; ?>

	</header>

	<?php if ( herald_get_option( 'header_sticky' ) ): ?>
		<?php get_template_part( 'template-parts/header/sticky' ); ?>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/header/responsive' ); ?>

	<?php get_template_part( 'template-parts/ads/below-header' ); ?>

	<div id="content" class="herald-site-content herald-slide">

	<?php if ( !is_front_page() ) { herald_breadcrumbs(); } ?>