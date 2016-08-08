<div class="herald-module col-lg-<?php echo esc_attr( $module['columns']);?>" id="herald-module-<?php echo esc_attr($s_ind.'-'.$m_ind); ?>">

	<?php echo herald_get_module_heading( $module ); ?>

	<?php if(!empty($module['content'])) :?>
		<?php $module['content'] = !empty($module['autop']) ?  wpautop($module['content']) : $module['content']; ?>
		<div class="herald-txt-module"><?php echo do_shortcode( $module['content']); ?></div>
	<?php endif; ?>
</div>