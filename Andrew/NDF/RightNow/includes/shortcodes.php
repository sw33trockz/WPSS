<?php	
$shorcodesUsage = array();
$shorcodesUsage['text'][] = array(	
				'code'=>'highlight', 
				'name'=>'Highlight', 
				'content'=>true
			);
$shorcodesUsage['other'][] = array(
				'code'=>'person_info', 
				'name'=>'Personel Information', 
				'content'=>false,
				'params' => array(
					'name' =>  array(
						'name' => 'Name',
						'required' => false,
						'type' => 'string'
					),
					'title' =>  array(
						'required' => false,
						'type' => 'string'
					),
					'twitter' =>  array(
						'required' => false,
						'type' => 'string'
					),
					'facebook' =>  array(
						'required' => false,
						'type' => 'string'
					),
					'email' =>  array(
						'required' => false,
						'type' => 'string'
					)
				)
			);
$shorcodesUsage['text'][] = array(	
				'code'=>'dropcap', 
				'name'=>'Dropcap', 
				'content'=>true
			);

add_shortcode('person_info', 'sh_person_info');
function sh_person_info($attr, $content=null){

	$re = '<div class="personName">
		<h3>'.$attr['name'].'</h3>
		<span>'.$attr['title'].'</span>
	</div>
	<div class="personContact">';
	if(@!empty($attr['twitter']))
		$re.='<a class="tip personTwitter" target="_blank" href="http://twitter.com/'.$attr['twitter'].'" rel="@'.$attr['twitter'].'"/></a>';
	if(@!empty($attr['facebook']))
		$re.='<a class="tip personFacebook" target="_blank" href="http://fb.me/'.$attr['facebook'].'" rel="fb.me/'.$attr['facebook'].'"/></a>';
	if(@!empty($attr['email']))
		$re.='<a class="tip personEmail" target="_blank" href="mailto:'.$attr['email'].'" rel="'.$attr['email'].'"/></a>';
	$re .= '</div>';
	return $re;
}

add_shortcode('highlight', 'sh_highlight');
function sh_highlight($attr, $content=null){
	return '<span class="highlight">'.$content.'</span>';
}

add_shortcode('video', 'sh_video');
function sh_video($attr, $content=null){
	
	$sourceStr = getSource( $attr['url'], $attr['width'], $attr['height']);
	
	$imgW = (int) $attr['width'];
	$imgH = (int) $attr['height'];
	return $sourceStr;		
}

add_shortcode('list_two', 'sh_list_two');
function sh_list_two($attr, $content=null){
	$re = '<div class="list_two">'.do_shortcode($content).'</div>';
	return $re;
}

add_shortcode('list_item', 'sh_list_item');
function sh_list_item($attr, $content=null){
	$re = '<div class="item_two_one">'.$attr['title'].'</div>';
	$re .= '<div class="item_two_two">';
	
	if(!empty($attr['type']))
	{
		if($attr['type']=='url')
			$re.='<a class="nolink" href="'.$content.'" target="_blank">'.$content.'</a>';
		elseif($attr['type']=='email')
			$re.='<a class="nolink" href="mailto:'.$content.'" >'.$content.'</a>';
	}
	else
		$re .= $content;
	
	$re .= '</div>';
	return $re;
}

add_shortcode('form', 'sh_form');
function sh_form($attr, $content=null)
{
	$class='form_'.createRandomKey(5);
	$re ='<div class="'.$class.' contactForm dform">
			<form>
			'.do_shortcode($content);
	
	if(!empty($attr['secure']))
	{
		$r1 = rand(0,9);
		$r2 = rand(0,9);
		$re.='<p>
				<input type="hidden" name="s1" value="'.$r1.'" /> 
				<input type="hidden" name="s2" value="'.$r2.'" /> 
				<label for="sec">'.$r1.'+'.$r2.'=</label><div class="dFormInput" style="width:50px"><input  type="text" id="s" name="s" class="required" value="" /></div></p>';
	}
	
	$re .= '<p><label for="submit">&nbsp;</label><div class="form_input">';
	$re .= '<a class="nolink submitButton" onclick="javascript:$(\'.'.$class.' form\').submit();" href="javascript:void(0);">'. __('Submit','rb').'</a>';
	$re .= '</div></p>
			</form>
			</div>';
	$re .= '<script>
	$(\'#contentBox\').ready(function(){
		$(".'.$class.' form").validate({
		  errorPlacement: function(error, element) {
			 error.appendTo(element.parent("div").next() );
		   }
		 });
		$(".'.$class.' form").submit(function(){
			if($(".'.$class.' form").valid())
			{
				var formdata = $(".'.$class.' form").serialize();
				$(".'.$class.' form").slideUp();
				$(".'.$class.'").append("<div class=\"form_message\">Please wait...</div>").find("div.form_message").slideDown("slow");
				$.post("'.get_template_directory_uri().'/includes/form-sender.php'.'", formdata, function(data){
					data = $.parseJSON(data); 
					if(data.status=="OK")
					{
						$(".'.$class.' .form_message").html("Your message has been send successfuly.");
					}
					else
					{
						alert(data.ERR);
						$(".'.$class.' form").slideDown();
						$(".'.$class.' .form_message").remove();
					}
				});
			}else
				alert("Please fill all required fields.");
			return false;
		});
	});
	</script>';
	
	return $re;
}

add_shortcode('form_item', 'sh_form_item');
function sh_form_item($attr, $content=null)
{
	$type='text';
	$re = '';
	$re.= '<p><label for="'.$attr['name'].'" >'.$attr['title'].'</label>';
	$re.='<input type="hidden" id="'.$attr['name'].'_title" name="title[]" value="'.$attr['title'].'" />';
	$re.='<input type="hidden" id="'.$attr['name'].'_key" name="key[]" value="'.$attr['name'].'" />';
	if(!empty($attr['type']))
		$type = $attr['type'];
	
	$re .='</p><div class="dFormInput">';
	$class = '';
	
	if(!empty($attr['validate']))
		$class = $attr['validate'];
	
	if($type=='text')
		$re.='<input class="'.$class.'" id="'.$attr['name'].'" type="text" name="'.$attr['name'].'" />';
	elseif($type=='textarea')
		$re.='<textarea class="'.$class.'" id="'.$attr['name'].'" name="'.$attr['name'].'" ></textarea>';
	elseif($type=='checkbox')
        $re.='<input class="'.$class.'" id="'.$attr['name'].'"  type="checkbox" name="'.$attr['name'].'" />';
	elseif($type=='select')
	{
		$re.='<select class="'.$class.'" id="'.$attr['name'].'" name="'.$attr['name'].'" >';
		$vals = explode(',',$attr['values']);
		foreach($vals as $val)
			$re.='<option>'.trim($val).'</option>';
		$re.='</select>';
	}
	$re .='</div>';
	$re.="</p>\n\n";
	
	return $re;
}

add_shortcode('gallery', 'sh_gallery');
function sh_gallery($attr, $content=null){
	$prm = $attr;
	global $paged, $wpdb;
	if(!isset($prm['id']))
		$cat = '';
	else
		$cat = $prm['id'];
		
	if(!isset($prm['useimageresize']) || @$prm['useimageresize']=='true')
		$useResizer = 'use';
	else
		$useResizer = $prm['useimageresize'];
		
	if(!isset($prm['image']))
		$imageType = 'portrait';
	else
		$imageType = $prm['image'];
		
	if(!isset($prm['count']))
		$count = 2;
	else
		$count = (int) $prm['count'];
	
	if(!isset($prm['text']))
		$textType = 'true';
	else
		$textType = $prm['text'];
		
		
	$pageWidth = 600;
	$spaceH = 20;
	$columnW = (int) (($pageWidth-($spaceH*($count-1)))/$count);

	$imageW = (int) ($columnW);
	if($imageType=='landscape')
		$imageH = (int) ($imageW/1.5);
	if($imageType=='portrait')
		$imageH = (int) ($imageW*1.5);
	if($imageType=='square')
		$imageH = (int)($imageW);

	 
	$re = '';		
	$re .= '<ul class="portfolioitems portfolio'.$count.'columns">';
		
	$result = $wpdb->get_results("SELECT IMAGEID, TYPE, CONTENT, THUMB, CAPTION, DESCRIPTION, WIDTH, HEIGHT FROM {$wpdb->prefix}backgrounds WHERE GALLERYID in (".$cat.") ORDER BY SLIDERORDER");
	$i=0;
	foreach($result as $row){
		$i++;
		$re .= '<li style="height:'.$imageH.'px">';
		
		$thumbnail_src = $row->THUMB;
		
		if($useResizer=='use' && function_exists('wpthumb'))
			$thumbnail_url = wpthumb($thumbnail_src,'width='.$imageW.'&height='.$imageH.'&resize=true&crop=1&crop_from_position=center,center');
		else
			$thumbnail_url = $thumbnail_src;
		
		if($row->TYPE=='image')
			$thumbnail_href = $thumbnail_src;
		elseif($row->TYPE=='vimeo')
			$thumbnail_href = 'http://vimeo.com/'.$row->CONTENT;
		elseif($row->TYPE=='youtube')
			$thumbnail_href = 'http://youtu.be/'.$row->CONTENT;
		elseif($row->TYPE=='selfhosted')
			$thumbnail_href =  $row->CONTENT;
		elseif($row->TYPE=='flash')
			$thumbnail_href =  $row->CONTENT.'?width='.$row->WIDTH.'&height='.$row->HEIGHT;
		
		$modalClass = 'modal';
		if($row->TYPE=='vimeo' || $row->TYPE=='youtube' || $row->TYPE=='selfhosted' || $row->TYPE=='flash')
			$modalClass = 'modalVideo';	

		$re .= '<div class="image_frame">';
		$re .= '<a href="'.$thumbnail_href.'"  title="'.htmlentities(stripslashes($row->CAPTION), ENT_QUOTES, "UTF-8").'">';
		$re .= '<img src="'.$thumbnail_url.'" width="'.$imageW.'" height="'.$imageH.'" title="'.htmlentities(stripslashes($row->CAPTION), ENT_QUOTES, "UTF-8").'" alt="'.htmlentities(stripslashes($row->DESCRIPTION), ENT_QUOTES, "UTF-8").'" />';		

		$re .= '<div class="hoverWrapperBg"></div>
						<div class="hoverWrapper">';
							if($textType!='none'){
								if(!empty($row->CAPTION))
									$re .= '<h3>'.stripslashes($row->CAPTION).'</h3>';
								if(!empty($row->DESCRIPTION))
									$re .= '<div class="enter-text">'.stripslashes($row->DESCRIPTION).'</div>';
							}			
						$re .= '</div>'; // end of hoverWrapper
			
		$re .= '</a>';
		$re .= '</div>'; // end of image_frame
		
		/*<div class="hoverWrapperBg"></div>
		<div class="hoverWrapper">';
			if($textType!='none'){
				if(!empty($row->CAPTION))
					$re .= '<h3>'.stripslashes($row->CAPTION).'</h3>';
				if(!empty($row->DESCRIPTION))
					$re .= '<div class="enter-text">'.stripslashes($row->DESCRIPTION).'</div>';
			}							
		$re .= '</div>
		</div>';*/
		
		$re .= '</li>';
	}
	$re .= '</ul>
		<hr class="seperator" />
		<div class="clearfix"></div>';
	return $re;
}


add_shortcode('portfolio', 'sh_portfolio');
function sh_portfolio($attr, $content=null)
{
	$prm = $attr;
	global $post, $paged, $more, $wpdb, $wp_query, $pageTitle;
	if(!isset($prm['category']))
		$cat = '';
	else
		$cat = $prm['category'];
		
	if(!isset($prm['type']))
		$type = 'pagination';
		
	else
		$type = $prm['type'];
	if(!isset($prm['image']))
		$imageType = 'portrait';
	else
		$imageType = $prm['image'];
	if(!isset($prm['count']))
		$count = 4;
	else
		$count = (int) $prm['count'];
	if(!isset($prm['text']))
		$textType = 'true';
	else
		$textType = $prm['text'];
		
	if(!isset($prm['sidebar']))
		$sidebarType = 'none';
	else
		$sidebarType = $prm['sidebar'];

	$postperpage = 10;
	if(!empty($prm['postperpage']))
		$postperpage = (int) $prm['postperpage'];
	
	$directlink = false;
	if($blogparams['directlink']=='true')
		$directlink = true;
		
	$pageWidth = 600;
	$spaceH = 20;
	$columnW = (int) (($pageWidth-($spaceH*($count-1)))/$count);

	$imageW = (int) ($columnW);
	$imageH = (int) ($imageW/1.5);

	if($postperpage<=0)
		$postperpage = 10;
	 
	$re = '';
		if($type=='filter'){
		$re .= '<ul class="portfolioFilter">';
			$cat_query = "SELECT wterms.name, wterms.term_id
						FROM $wpdb->terms wterms
						WHERE wterms.term_id in(".$cat.")
						ORDER BY wterms.name ASC";	
			$catResults = $wpdb->get_results($cat_query);
			$re .= '<li data-value="all"><a class="nolink" href="javascript:void(0);" class="selected">'.__('All','rb').'</a></li>'."\n";
			foreach($catResults as $catRow)
				$re .= '<li data-value="'.$catRow->term_id.'"><a class="nolink" href="javascript:void(0);">'.$catRow->name.'</a></li>'."\n";
		$re .= '</ul>';
		}
		
		
				$re .= '<ul class="portfolioitems portfolio'.$count.'columns">';

				if($type=='pagination')
					$wp_query = new WP_Query('post_type=post&posts_per_page='.$postperpage.'&cat='.$cat.'&paged='.$paged);
				else
					$wp_query = new WP_Query('post_type=post&cat='.$cat.'&posts_per_page=-1');
				
				if($wp_query->have_posts()){
					$i=0;
					while($wp_query->have_posts()){
					$i++;
						$wp_query->the_post();
						
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
						$sourceStr = getSource($sourceData, $imageW, $imageH);
						
				
				
				$dataID = '';
				$dataCalss='';
				if($type=='filter')
				{
					$dataID = 'data-id="id-'.$post->ID.'"';
					$catIDs = '';
					foreach((get_the_category($post->ID)) as $category)
							$catIDs .= 'cat'.$category->cat_ID.' ';
					if(!empty($catIDs))
						$dataCalss .= ' data-type="'.$catIDs.'" ';
				}		
				
				$re .= '<li '.$dataID.' '.$dataCalss.' style="height:'.$imageH.'px">';
					if(has_post_thumbnail() || (!empty($sourceStr) && $sourceOpen=='e')){
						$thumbnail_src = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); 
						
						if($useResizer=='use' && function_exists('wpthumb'))
							$thumbnail_url = wpthumb($thumbnail_src,'width='.$imageW.'&height='.$imageH.'&resize=true&crop=1&crop_from_position='.$cropPos);
						else
							$thumbnail_url = $thumbnail_src;
						
					if($sourceOpen=='m' || empty($sourceOpen) || empty($sourceData)){
						
					$re .= '<div class="image_frame">';
					if(!$directlink)
						$re .= '<a href="'.(empty($sourceData)?$thumbnail_src:$sourceData).'"  title="'.get_the_title().'">';
					else
						$re .= '<a href="#!'.get_ajax_permalink().'"  title="'.get_the_title().'">';
					$re .= '<img '.(($directlink)?'class="nomodal"':'').' src="'.$thumbnail_url.'" width="'.$imageW.'" height="'.$imageH.'" alt="'.get_the_title().'" />';

					
						$re .= '<div class="hoverWrapperBg"></div>
						<div class="hoverWrapper">';
							if($textType!='none'){
							$re .= '<h3>'.get_the_title().'</h3>
							<div class="enter-text">';
							$more = 0; 
							$re .= get_the_content('').'</div>';
							}
							$re .= '<span class="link" rel="#!'.get_ajax_permalink().'"></span>';
							
							$modalClass = 'modal';
							if($sourceType=='vimeo' || $sourceType=='youtube' || $sourceType=='jwplayer' || $sourceType=='flash')
								$modalClass = 'modalVideo';						
							
							if(!$directlink)
								$re .= '<span class="'.$modalClass.'" ></span>';
						$re .= '</div>'; // end of hoverWrapper
					
					$re .= '</a>';
					$re .= '</div>'; // end of image_frame
					}elseif($sourceOpen=='e'){
						$re .= $sourceStr;
					}
				}
				$re .= '</li>';
		}
	}
	$re .= '</ul>
		<hr class="seperator" />
		<div class="clearfix"></div>';

	if($type=='pagination'){
		if(function_exists('wp_pagenavi')){
			$re .= wp_pagenavi( array( 'query' => $wp_query, 'options' => array('return_string' => true) ));
			$re.='	<div class="divider" style="height:10px"></div>
			<div class="clearfix"></div>';
		}
	}
	wp_reset_postdata();	
	return $re;
}

add_shortcode('blog', 'sh_blog');
function sh_blog($attr, $content=null){
	global $paged, $wpdb, $more, $blogparams, $pageTitle;
	$blogparams = $attr;
	$cats = '';
	$postperpage = 10;
	$directlink = true;
	if($blogparams['directlink']=='true')
		$directlink = true;
	if(!empty($blogparams['postperpage']))
		$postperpage  = $blogparams['postperpage'];
	if(!empty($blogparams['cats']))
		$cats  = $blogparams['cats'];
	
	$dataformat ='d.m.Y';
	$metaformat = 'posted, comments, tag';
	$useImage = true;

	if(!empty($blogparams['dateformat']))
		$dataformat = $blogparams['dateformat'];
	if(!empty($blogparams['metaformat']))
		$metaformat = $blogparams['metaformat'];

		$imageW = $imgW = 350;
		$imageH = $imgH = 225;


wp_reset_postdata();
$the_query_arr = 'post_type=post&posts_per_page='.$postperpage.'&cat='.$cats.'&paged='.$paged;
$the_query = new WP_Query($the_query_arr);
$re = '';
while($the_query->have_posts()){
	$the_query->the_post();
	$sourceData = get_post_meta(get_the_ID(), "sourceData", true);
	$sourceOpen = get_post_meta(get_the_ID(), "sourceOpen", true);
	$useResizer = get_post_meta(get_the_ID(), "useResizer", true);
	$cropPos 	= get_post_meta(get_the_ID(), "cropPos", true);
	$cropPos	= ($cropPos=='')?'c':$cropPos;
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
	
	$blogClass = '';
	$blogClassArr = get_post_class(array('blogitem'), get_the_ID());
	foreach($blogClassArr as $blogClassArrItem)
		$blogClass.=$blogClassArrItem.' ';
	$re .= '<div id="post-'.get_the_ID().'" class="'.$blogClass.'">
		<h3>'.get_the_title().'</h3>';
	if( has_post_thumbnail() || (!empty($sourceStr) && $sourceOpen=='e')){ 
			$thumbnail_src = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); 
			if($useResizer=='use' && function_exists('wpthumb'))
				$thumbnail_url = wpthumb($thumbnail_src,'width='.$imageW.'&height='.$imageH.'&resize=true&crop=1&crop_from_position='.$cropPos);
			else
				$thumbnail_url = $thumbnail_src;
			$useImage = true;

	$re .= '<div class="blogimage">
			<div class="image_frame">';
			
			if($sourceOpen=='m' || empty($sourceOpen) || empty($sourceData)){
				if(!$directlink)
					$re .= '<a href="'.(empty($sourceData)?$thumbnail_src:$sourceData).'" title="'.get_the_title().'">';
				else
					$re .= '<a href="#!'.get_ajax_permalink().'" title="'.get_the_title().'">';
				$re .= '<img '.(($directlink)?'class="nomodal"':'').' src="'.$thumbnail_url.'" width="'.$imgW.'" height="'.$imgH.'" alt="'.get_the_title().'" />

					<div class="hoverWrapperBg"></div>
					<div class="hoverWrapper">
						<span class="link" rel="#!'.get_ajax_permalink().'"></span>';
						
					
					if(!$directlink){
						$modalClass = 'modal';
						if($sourceType=='vimeo' || $sourceType=='youtube' || $sourceType=='jwplayer')
							$modalClass = 'modalVideo';						
					
						$re .= '<span class="'.$modalClass.'"></span>';
					}
					$re .='</div>';
					$re .= '</a>';
				}elseif($sourceOpen=='e'){
				$re .= '<div style="position: relative; width:'.$imageW.'px; height:'.$imageH.'px; background-image: none; opacity: 1;">
					'.$sourceStr.'
				</div>';
				}
			$re .= '</div>
		</div>';
		
		}else{ $useImage = false; }
		$re .= '<div class="blogcontent" '. ((!$useImage)?'style="width:600px; margin-left:0"':'').'>
			<div class="blogdatemeta">';
				if($dataformat!='none'){ 
					$re .= '<div class="blogdate">'.get_the_time($dataformat).'</div>';
				} 
				if($metaformat!='none'){
					$re .= '<div class="meta-links">';
					if(strpos($metaformat, 'posted')!==false){
						$re .= '<a class="meta-author" href="javascript:void(0);" rel="'.posted_on_template().'"></a>';
					}
					
					if(strpos($metaformat, 'comments')!==false){
						$commentCount = get_comments_number(get_the_ID());
						if($commentCount==0)
							$commentStr = __('No Comment', 'rb');
						elseif($commentCount==1)
							$commentStr = __('1 Comment', 'rb');
						else
							$commentStr = $commentCount.__('Comments', 'rb');
						$re .= '<a class="meta-comments" href="javascript:void(0);" rel="'.$commentStr.'"></a>';
					}
					
					if(strpos($metaformat, 'tag')!==false){ 
						$tags_list = wp_get_post_tags(get_the_ID(), array( 'fields' => 'names' ));
						if ( $tags_list ){
							$re .= '<a class="meta-tags" href="javascript:void(0);" rel="'.implode(' ,', $tags_list).'"></a>';
						}
					}
				$re.='</div>';
				}
			$re .= '</div> 
			<p>';
			$more=0; 
			$re .= get_the_content('').'
			</p>
			<a class="morelink" href="#!'.get_ajax_permalink().'">'.__('READ MORE', 'rb').'</a>
		</div>
		<hr class="seperator"/>
		<div class="clearfix"></div>
	</div>';
	} 
	
	
	if(function_exists('wp_pagenavi'))
		$re .= wp_pagenavi( array( 'query' => $the_query, 'options' => array('return_string' => true) ));
	wp_reset_postdata();	
	$re.='
	<div class="divider" style="height:10px"></div>
	<div class="clearfix"></div>';
	return $re;
}


add_shortcode('map','sh_map');
function sh_map($attr, $content=null) //latlng -34.397, 150.644
{
$content = trim($content); 
//defaults
$width = '500px';
$height = '500px;';
$zoom = 11; // 0,7 to 18
$sensor = 'true'; 
$controls = 'false';
$type = 'HYBRID '; // ROADMAP | SATELLITE | TERRAIN 
$marker = '';
$marker_icon = '';
if(!empty($attr['zoom']))
	$zoom = $attr['zoom'];
if(!empty($attr['sensor']))
	$sensor = $attr['sensor'];
if(!empty($attr['nocontrols']))
	$controls = $attr['nocontrols'];
if(!empty($attr['type']))
	$type = $attr['type'];
if(!empty($attr['width']))
	$width = $attr['width'];
if(!empty($attr['height']))
	$height = $attr['height'];

$mapID = createRandomKey(5); 
if(!empty($attr['marker']) || !empty($content))
{
	if(!empty($attr['marker_icon']))
		$marker_icon = ', icon:\''.$attr['marker_icon'].'\'';
		
	$marker = 'var marker'.$mapID.' = new google.maps.Marker({map: mapObj'.$mapID.', 
		position: mapObj'.$mapID.'.getCenter()
		'.$marker_icon.'
		});';
		
	if(!empty($content))
	{
		
		$marker .= '
		var infowindow'.$mapID.' = new google.maps.InfoWindow();
		infowindow'.$mapID.'.setContent(\''.$content.'\');
		google.maps.event.addListener(marker'.$mapID.', \'click\', function() {
				infowindow'.$mapID.'.open(mapObj'.$mapID.',  marker'.$mapID.');
		});';
	}
	
}
$re = ' 
<script type="text/javascript">
$(document).bind(\'contentPageReady\', function(){
	setTimeout(function(){
	var latlng = new google.maps.LatLng('.$attr['lat'].', '.$attr['lng'].');
	var myOptions = {
	  zoom: '.$zoom.',
	  disableDefaultUI: '.$controls.',
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.'.$type.'
	};
	var mapObj'.$mapID.' = new google.maps.Map(document.getElementById("map'.$mapID.'"), myOptions);
	'.$marker.'
	}, 500);
});
</script>
<div id="map'.$mapID.'" class="mapContact" style="width:'.$width.'; height:'.$height.'"></div>
';

return $re;
}


function createRandomKey($amount){
	$keyset  = "abcdefghijklmABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$randkey = "";
	for ($i=0; $i<$amount; $i++)
		$randkey .= substr($keyset, rand(0, strlen($keyset)-1), 1);
	return $randkey;	
}


function sh_toggle($attr, $content=null){
	$style='';
	if(!empty($attr['width']))
		$style = ' style="width:'.$attr['width'].'px"';
	return '<div '.$style.' class="sh_toggle"><div class="sh_toggle_text"><a class="nolink" href="javascript:void(0);">'.$attr['title'].'</a></div><div class="sh_toggle_content">'.do_shortcode($content).'</div></div>';
}
add_shortcode('toggle','sh_toggle');

function sh_divider($attr, $content=null){
	$style="";
	if(@!empty($attr['height']))
		$style = ' style="height:'.$attr['height'].'px" ';
	return '<div class="divider" '.$style.'></div>';
}
add_shortcode('divider','sh_divider');

function sh_vdivider($attr, $content=null){
	$style="";
	if(@!empty($attr['width']))
		$style = ' style="width:'.$attr['width'].'px" ';
	return '<div class="vericaldivider" '.$style.'></div>';
}
add_shortcode('vdivider','sh_vdivider');



function sh_seperator($attr, $content=null){
	$style = '';
	if(@!empty($attr['style']))
		$style = 'style="'.$attr['style'].'" ';
	return '<hr class="seperator" '.$style.'/>';
}
add_shortcode('seperator','sh_seperator'); 

function sh_list($attr, $content=null){
	$icon = '';
	if(!empty($attr['icon']))
	{
		$icon = ' style="background:url(\''.get_template_directory_uri().'/icons/'.$attr['icon'].'.gif\') no-repeat scroll left 0px transparent;"';
		$content = str_replace('<li>', '<li '.$icon.'>', $content);
	}
	return '<ul class="sh_list" >'.do_shortcode($content).'</ul>';
}
add_shortcode('list','sh_list'); 

function sh_dropcap($attr, $content=null){
	return '<div class="dropcap">'.do_shortcode($content).'</div>';
}
add_shortcode('dropcap','sh_dropcap'); 

function sh_quotes_one($attr, $content=null){
	return '<div class="quotes-one">'.do_shortcode($content).'</div>';
}
add_shortcode('quotes_one','sh_quotes_one'); 

function sh_quotes_two($attr, $content=null){
	$style = "";
	$addClass = "";
	if(@!empty($attr['align']))
		$addClass = $attr['align'];
	if(@!empty($attr['style']))
		$style = 'style='.$attr['style'];
	return '<div class="quotes-two '.$addClass.'" '.$style.'>'.do_shortcode($content).'</div>';
}
add_shortcode('quotes_two','sh_quotes_two'); 


function sh_quotes_writer($attr, $content=null){
	return '<div class="quotes-writer">'.do_shortcode($content).'</div>';
}
add_shortcode('quotes_writer','sh_quotes_writer'); 


function sh_code($attr, $content = null){
	return '
	<pre>'.htmlspecialchars($content).'</pre>';
}
add_shortcode('code', 'sh_code');

function sh_button($attr, $content = null)
{
	$size = 'small';
	$color = 'black';
	$target = '';
	$url = '#';
	if(@!empty($attr['size']))
		$size = strtolower($attr['size']);
	if(@!empty($attr['color']))
		$color = strtolower($attr['color']);
	if(@!empty($attr['url']))
		$url = $attr['url'];
	if(@!empty($attr['target']))
		$target = 'target="'.$attr['target'].'" ';
	$box = '<div class="button'.ucfirst($size).' '.$size.ucfirst($color).'"><a href="'.$url.'" '.$target.'>'.$content.'</a><span></span></div>';
	return do_shortcode($box);
}
add_shortcode('button','sh_button');

function sh_message($attr, $content=null){
	$type="infobox";
	if(@!empty($attr['type']))
		$type = $attr['type'];
	return '<div class="'.$type.'">'.do_shortcode($content).'</div>';
}
add_shortcode('message','sh_message'); 

function sh_tip($attr, $content=null){
	return '<a href="#" class="tip" rel="'.$attr['text'].'">'.do_shortcode($content).'</a>';
}
add_shortcode('tip','sh_tip'); 

function sh_box($attr, $content = null)
{
	$style='padding:20px; margin:10px 0; ';
	$style_in ='';
	if(!empty($attr['width']))
		$style .= 'width:'.$attr['width'].'; ';
	else
		$style .= '';
		
	if(!empty($attr['height']))
		$style .= 'height:'.$attr['height'].'; ';
	else
		$style .= '';
	
	if(!empty($attr['align']))
	{
		if($attr['align']=='center')
			$style.='margin:0 auto 0 auto; ';
		elseif($attr['align']=='right')
			$style.='margin:10px 0 10px auto; ';
	}
	
	if(!empty($attr['textcolor']))
	{
		$style_in.='color:'.$attr['textcolor'].'; ';
	}else{
		$style_in.='color:#'.opt('colorFont',"").'; ';
	}
	
	if(empty($attr['border']))
	{
		if(!empty($attr['bordercolor']))
		{
			$style.='border:1px solid '.$attr['bordercolor'].'; ';
		}
	}else{
		// advanced usage
		$style.=$attr['border'].'; ';
	}
	
	if(empty($attr['background']))
	{
		if(!empty($attr['bgcolor']))
		{
			$style.='background-color:'.$attr['bgcolor'].'; ';
		}
	}else{
		// advanced usage
		$style.='background:'.$attr['background'].'; ';
	}
	
	$boxinsideClass = 'boxinside';
	if(!empty($attr['icon']))
	{
		$style_in .= 'padding-left:70px; ';
		$style_in .= 'background:url(\''.get_template_directory_uri().'/icons/'.$attr['icon'].'.png\') no-repeat left top; ';
	}else{
		$boxinsideClass = 'boxinsideNoicon';
	}
	
	$cornerData='';
	$cornerClass='';
	if(!empty($attr['corner']))
	{
		$cornerData = 'data-corner="'.$attr['corner'].'"';
		$cornerClass = ' corner ';
	}
	
	return '<div '.$cornerData.' class="box '.$cornerClass.' " style="'.$style.'"><div class="'.$boxinsideClass.'" style="'.$style_in.'">'.do_shortcode($content).'<div class="clearfix"></div></div></div>';
}
add_shortcode('box','sh_box');

/* Columns Codes **/
function sh_1of1($attr, $content = null){
	return '<div class="c1of1">'.do_shortcode($content).'</div>';
}
add_shortcode('1of1', 'sh_1of1');

function sh_1of2($attr, $content = null){
	return '<div class="c1of2">'.do_shortcode($content).'</div>';
}
add_shortcode('1of2', 'sh_1of2');

function sh_1of2_end($attr, $content = null){
	return '<div class="c1of2_end">'.do_shortcode($content).'</div>';
}
add_shortcode('1of2_end', 'sh_1of2_end');

function sh_1of3($attr, $content = null){
	return '<div class="c1of3">'.do_shortcode($content).'</div>';
}
add_shortcode('1of3', 'sh_1of3');

function sh_1of3_end($attr, $content = null){
	return '<div class="c1of3_end">'.do_shortcode($content).'</div>';
}
add_shortcode('1of3_end', 'sh_1of3_end');

function sh_2of3($attr, $content = null){
	return '<div class="c2of3">'.do_shortcode($content).'</div>';
}
add_shortcode('2of3', 'sh_2of3');

function sh_2of3_end($attr, $content = null){
	return '<div class="c2of3_end">'.do_shortcode($content).'</div>';
}
add_shortcode('2of3_end', 'sh_2of3_end');

function sh_1of4($attr, $content = null){
	return '<div class="c1of4">'.do_shortcode($content).'</div>';
}
add_shortcode('1of4', 'sh_1of4');

function sh_1of4_end($attr, $content = null){
	return '<div class="c1of4_end">'.do_shortcode($content).'</div>';
}
add_shortcode('1of4_end', 'sh_1of4_end');

function sh_2of4($attr, $content = null){
	return '<div class="c2of4">'.do_shortcode($content).'</div>';
}
add_shortcode('2of4', 'sh_2of4');

function sh_2of4_end($attr, $content = null){
	return '<div class="c2of4_end">'.do_shortcode($content).'</div>';
}
add_shortcode('2of4_end', 'sh_2of4_end');

function sh_3of4($attr, $content = null){
	return '<div class="c3of4">'.do_shortcode($content).'</div>';
}
add_shortcode('3of4', 'sh_3of4');

function sh_3of4_end($attr, $content = null){
	return '<div class="c3of4_end">'.do_shortcode($content).'</div>';
}
add_shortcode('3of4_end', 'sh_3of4_end');


function sh_clear($attr, $content = null){
	return '<div class="clearfix"></div>';
}
add_shortcode('clear', 'sh_clear');
?>