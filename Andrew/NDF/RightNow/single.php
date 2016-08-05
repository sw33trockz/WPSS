<?php
get_header(); /* get the header */

	if(@$_GET['info']=='description'){
		echo $pageDescription;
		exit; 
	}elseif(@$_GET['info']=='title'){
		wp_title( '|', true, 'right' );
		exit;
	}elseif(@$_GET['info']=='page'){
		if(have_posts())
		{
			if(have_posts())
			{
				the_post();
				$postID	= get_the_ID();
				$content = get_the_content();
				$content = apply_filters('the_content', $content);
				$title = get_the_title();
				
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
				$useInDetail = get_post_meta($post->ID, "useInDetail", true);
				
				
				$imgW = $imageW = 600;
				$imgH = $imageH = 0;
				if(!empty($sourceData))
					if($sourceType=='vimeo' || $sourceType=='youtube' ||  $sourceType=='jwplayer')
						$imgH = $imageH = 400;
						
				$sourceStr = getSource($sourceData, $imgW, $imgH);
			}
		}

?>
<h1 class="caption"><?php the_title(); ?></h1>
<div class="divider"></div>


<?php 
if((has_post_thumbnail() && $useInDetail=='use') || (!empty($sourceData) && $sourceOpen=='e' && $useInDetail=='use'))
{
	$thumbnail_src = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); 
	if($useResizer=='use' && function_exists('wpthumb'))
		$thumbnail_url = wpthumb($thumbnail_src,'width='.$imageW.'&height='.$imageH.'&resize=true&crop=1&crop_from_position='.$cropPos);
	else
		$thumbnail_url = $thumbnail_src;
	?>				
		<?php if(empty($sourceData) || empty($sourceType)){	?>
				<img width="<?php echo $imageW; ?>" class="<?php echo empty($sourceStr)?"":"videoLink"; ?>" src="<?php echo $thumbnail_url;?>" alt="<?php the_title(); ?>" />
		<?php }elseif(!empty($sourceType)){ ?>
		<?php echo $sourceStr; ?>
		<?php }?>
<?php } ?>


<div class="divider"></div>

<div id="singleLeft">
<?php $more=1; the_content(''); ?>
</div>
<div id="singleRight">
	<div class="singleDateBlock">
		<div class="singleDate"><?php echo get_the_time('d.m.Y');?></div>
	</div>
	<ul>
		<li><div class="singleAuthor"></div><span><?php echo posted_on_template();?></span></li>
		<li><div class="singleComments"></div><span><?php comments_number(__('No Comment','rb'),__('1 Comment','rb'),__('% Comments','rb')); ?></span></li>
		<?php $tags_list = wp_get_post_tags($post->ID, array( 'fields' => 'names' ));				
		if ( $tags_list ){ ?>
		<li><div class="singleTags"></div><span><?php echo implode(' ,', $tags_list);?></span></li>
		<?php } ?>
	</ul>
</div>


<hr class="seperator" />
<div class="divider"></div>

<?php 
comments_template( '', true ); ?>
<hr class="seperator" />
<div class="clearfix"></div>

<?php }else{
		redirectWithEscapeFragment();
	}
?>