<?php  
get_header();
if(@$_GET['info']=='description'){
	echo $pageDescription;
	exit;
}elseif(@$_GET['info']=='title'){
	_e('404 Page not found','rb');
	exit;
}elseif(@$_GET['info']=='page'){
	?>
	<h1 class="caption"><?php _e('Page Not Found', 'rb');?></h1>
	<div class="divider"></div>
	<?php _e('Opst, page not found. This page may be removed.','rb');?>
	<?php
	wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
}else{
	redirectWithEscapeFragment();
}
?> 
