<?php 
global $more, $blogparams, $paged, $pageTitle;
$dataformat ='d.m.Y';
$metaformat = 'posted, comments, tag';
$useImage = true;

if(!empty($blogparams['dateformat']))
	$dataformat = $blogparams['dateformat'];
if(!empty($blogparams['metaformat']))
	$metaformat = $blogparams['metaformat'];

	$imageW = $imgW = 350;
	$imageH = $imgH = 225;
?>

<?php 
while(have_posts())
{
the_post();

$sourceData = get_post_meta($post->ID, "sourceData", true);
$sourceOpen = get_post_meta($post->ID, "sourceOpen", true);
$useResizer = get_post_meta($post->ID, "useResizer", true);
$cropPos 	= get_post_meta($post->ID, "cropPos", true);
$cropPos	= ($cropPos=='')?'c':$cropPos;
switch($cropPos){
	case 'tl': $cropPos = 'top,left'; break;
	case 't':  $cropPos = 'top,center'; break;
	case 'tr': $cropPos = 'top,right';	break;
	case 'l':  $cropPos = 'center,left'; break;
	case 'r':  $cropPos = 'center,right'; break;
	case 'bl': $cropPos = 'bottom,left'; break;
	case 'b':  $cropPos = 'bottom,center'; break;
	case 'br': $cropPos = 'bottom,right'; break;
	default:   $cropPos = 'center,center'; // c and empty
}
$sourceType = getMediaType($sourceData);
$sourceStr = getSource($sourceData, $imgW, $imgH);
?>
	<div id="post-<?php the_ID(); ?>"  <?php post_class('blogitem'); ?>>
		<h3><?php the_title();?></h3>
		<?php if( has_post_thumbnail() || (!empty($sourceStr) && $sourceOpen=='e')){ 
			$thumbnail_src = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); 
			if($useResizer=='use' && function_exists('wpthumb'))
				$thumbnail_url = wpthumb($thumbnail_src,'width='.$imageW.'&height='.$imageH.'&resize=true&crop=1&crop_from_position='.$cropPos);
			else
				$thumbnail_url = $thumbnail_src;
			$useImage = true;
			?>
		<div class="blogimage">
			<div class="image_frame">
				<?php if($sourceOpen=='m' || empty($sourceOpen) || empty($sourceData)){ ?>
				<a href="<?php echo empty($sourceData)?$thumbnail_src:$sourceData; ?>" title="<?php the_title();?>">
					<img src="<?php echo $thumbnail_url; ?>" width="<?php echo $imgW; ?>" height="<?php echo $imgH; ?>" alt="<?php the_title(); ?>" />
				</a>
				<div class="hoverWrapperBg"></div>
				<div class="hoverWrapper">
					<a class="link" href="#!<?php the_permalink(); ?>"></a>
					<?php
					$modalClass = 'modal';
					if($sourceType=='vimeo' || $sourceType=='youtube' || $sourceType=='jwplayer')
						$modalClass = 'modalVideo';						
					?>
					<a class="<?php echo $modalClass;?>" href="javascript:void(0);"></a>
				</div>
				<?php }elseif($sourceOpen=='e'){ ?>
				<div style="position: relative; width: <?php echo $imageW; ?>px; height: <?php echo $imageH; ?>px; background-image: none; opacity: 1;">
					<?php echo $sourceStr; ?>
				</div>
				<?php }?>
			</div>
		</div>
		<?php }else{ $useImage = false; } ?>
		<div class="blogcontent" <?php if(!$useImage){echo 'style="width:600px; margin-left:0"'; }?>>
			<div class="blogdatemeta">
				<?php if($dataformat!='none'){ ?>
				<div class="blogdate"><?php echo get_the_time($dataformat);?></div>
				<?php } ?>
				<?php if($metaformat!='none'){ ?>
				<div class="meta-links">
					<?php if(strpos($metaformat, 'posted')!==false){ ?>
					<a class="meta-author" href="javascript:void(0);" rel="<?php posted_on_template();?>"></a>
					<?php } ?>
					
					<?php if(strpos($metaformat, 'comments')!==false){ ?>
						<a class="meta-comments" href="javascript:void(0);" rel="<?php comments_number(__('No Comment', 'rb'),__('1 Comment', 'rb'),__('% Comments', 'rb'));?>"></a>
					<?php } ?>
					
					<?php if(strpos($metaformat, 'tag')!==false){ 
					$tags_list = wp_get_post_tags($post->ID, array( 'fields' => 'names' ));
					if ( $tags_list ){ ?>
					<a class="meta-tags" href="javascript:void(0);" rel="<?php echo implode(' ,', $tags_list);?>"></a>
					<?php }
					} ?>
				</div>
				<?php } ?>
			</div>
			<p>
			<?php $more=0; the_content(''); ?>
			</p>
			<a class="morelink" href="#!<?php the_permalink(); ?>"><?php echo __('READ MORE', 'rb');?></a>
		</div>
		<hr class="seperator"/>
		<div class="clearfix"></div>
	</div>
	<?php } ?>

<?php 
	if(function_exists('wp_pagenavi'))
		wp_pagenavi(); 
?>