<?php
$demo = false;
$upload_dir = wp_upload_dir();
$settingsimages = $upload_dir['basedir'].'/settingsimages';
$settingsimagesUrl = $upload_dir['baseurl'].'/settingsimages';
$galleryimages = $upload_dir['basedir'].'/galleryimages';
$galleryimagesUrl = $upload_dir['baseurl'].'/galleryimages';
		
include "includes/general-settings.php";
include 'includes/post-options.php';
include "includes/shortcodes.php";
include "includes/main-ajax.php";
include "includes/update_notifier.php";
include "plugins/ajax-comment-posting/ajax-comment-posting.php";

if ( ! isset( $content_width ) ) $content_width = 600;

//use thumbnail with post
add_theme_support( 'post-thumbnails' );

// For use shortcode in widgets
add_filter('widget_text', 'do_shortcode');
add_filter('widget_title', 'do_shortcode');

// localization support
load_theme_textdomain('rb');

// menus
register_nav_menu('primary', 'Main Navigation');

// options
$regSettings = array(
	'colorFirst' => 'e1523d',
	'colorSecond' => 'ffffff',
	'colorBackground' => '000000',
	'colorLine' => '333333',
	'colorText' => 'cccccc',
	'colorPasifButtonBg' => '232323',
	'contentFont' => 'PT Sans', 
	'contentFontVariant' => 'regular',
	'headerFont' => 'Terminal Dosis', 
	'headerFontVariant' => '500', 
	'copyrighttext' => 'Copyright 2012 Right Now Wordpress Theme', 
	'logo_url' => 'images/rightnow_logo.png', 
	'loading_logo_url' => 'images/logo.jpg', 
	'h1FontSize' => '24', 
	'h2FontSize' => '20', 
	'h3FontSize' => '18', 
	'h4FontSize' => '16', 
	'h5FontSize' => '14', 
	'h6FontSize' => '12', 
	'contentFontSize' => '12', 
	'analyticsCode' => '', 
	'favicon' => 'images/favicon.ico',
	'theme_style' => 'dark', 
	'bgPaused' => 'false', 
	'autoPlay' => 'true', 
	'loop' => 'false', 
	'audioController' =>'block', 
	'bgController' => 'block', 
	'thController' => 'block', 
	'shareIcons' => 'block',
	'bgPattern' => 'block', 
	'bgNormalFade' => 'false', 
	'bgAniTime' => '6000', 
	'menuDelay' => '500', 
	'frontPageURL' => '', 
	'btnSoundURLMp3' => '',
	'btnSoundURLOgg' => '',
	'drawActions' => 'true',
	'videoLoop' => 'true',
	'muteWhilePlayVideo' => 'true',
	'videoMuted' => 'false',
	'loopBg' => 'true',
	'videoPaused'=>'false',
	'bgStretch'=>'true'
); 

$defValues = array('theme_style'=>'light', 'bgPaused'=>'false', 'autoPlay'=>'false', 'loop'=>'false', 'audioController'=>'none', 'bgController'=>'none',
'thController'=>'none', 'twitter'=>'none', 'shareIcons'=>'none', 'bgPattern'=>'none', 'bgNormalFade'=>'false', 'menuPositionFixed'=>'false', 'muteWhilePlayVideo' => 'false',
'drawActions'=>'false', 'videoLoop'=>'false', 'videoMuted'=>'false', 'loopBg'=>'false', 'videoPaused'=>'false', 'bgStretch'=>'false');

// disabled auto tags such as br, p
remove_filter('the_content', 'wpautop');

function redirectWithEscapeFragment(){
	$preHTTP = 'http://';
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
		$preHTTP = 'https://';
	if(isset($_SERVER['REDIRECT_URL'])){
		$script_url = $preHTTP.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'].((!empty($_SERVER["QUERY_STRING"]))?addionalCharacter($script_url):'').$_SERVER["QUERY_STRING"];
	}else{
		$script_url = $preHTTP.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	$script_url = str_replace(home_url ().'/','', $script_url);
	header('location:'.home_url ().'/?_escaped_fragment_='.$script_url);
	exit;
}

function addionalCharacter($URL){
	if(strpos($URL, '/')===false){
		$pageName = $URL;
	}else{
		$pageName = end(explode('/',$URL));
	}
	if(strpos($URL, '?')===false)
		return '?';
	else
		return '&';
}

function get_ajax_content($addurl, $info){
	// if you want to use file_get_content func please follow lines untill next comment
	$c = curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_URL, home_url ().'/'.$addurl.addionalCharacter($addurl).'info='.$info);
	$contents = curl_exec($c);
	curl_close($c);

	if ($contents) 
		return $contents;
		
	/* if you want to use file_get_content func please remove this line and last line of comment 
	return file_get_contents(home_url ().'/'.$addurl.addionalCharacter($addurl).'info='.$info);
	*/
}

add_filter('comment_post_redirect', 'redirect_after_comment');
function redirect_after_comment(){
	$rdPage = get_permalink();
	header('location:'.$rdPage.'?info=page');
	exit();
}

if(!is_admin())
{
	add_action('wp_enqueue_scripts', 'thematic_enqueue_scripts');

}

function thematic_enqueue_scripts(){
	global $demo;
	$tmpurl = get_template_directory_uri();

	wp_enqueue_script("jquery", $tmpurl."/js/jquery-1.7.min.js", false, null); 
	wp_enqueue_script("easing",$tmpurl."/js/jquery.easing.1.3.js", false, null);
	wp_enqueue_script("quicksand", $tmpurl."/js/jquery.quicksand.js", false, null); 
	wp_enqueue_script("googlemap", "http://maps.googleapis.com/maps/api/js?sensor=true", false, null); 
	wp_enqueue_script("validate", $tmpurl."/js/jquery.validate.min.js", false, null); 
	wp_enqueue_script("history", $tmpurl."/js/jquery.history.js", false, null); 
	wp_enqueue_script("clip", $tmpurl."/js/clip.js", false, null); 
	wp_enqueue_script("vimeoapi", "http://f.vimeocdn.com/js/froogaloop2.min.js", false, null); 
	wp_enqueue_script("jwplayerapi", $tmpurl."/jwplayer/jwplayer.js", false, null); 
	wp_enqueue_script("mousewheel", $tmpurl."/js/jquery.mousewheel.min.js", false, null); 
	wp_enqueue_script("main", $tmpurl."/main.js", false, null); 
	wp_enqueue_script("swfobject", $tmpurl."/swfobject.js", false, null);
	
	if(!$demo)
		wp_enqueue_style('ThemeStyle', $tmpurl."/style.php", false, null, 'all');
	else{
		wp_enqueue_style('ThemeStyle', $tmpurl."/style.php?file=style.less", false, null, 'all');
		wp_enqueue_script("lesscss", $tmpurl."/js/less-1.1.6.js", false, null);
		wp_enqueue_script("demojs", $tmpurl."/js/demo.js", false, null);
	}
	wp_enqueue_style('generalStyle', $tmpurl."/style.css", false, null, 'all');
}

function enqueue_less_styles($tag, $handle) {
    global $wp_styles;
    $match_pattern = '/\.less$/U';
    if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
        $handle = $wp_styles->registered[$handle]->handle;
        $media = $wp_styles->registered[$handle]->args;
        $href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
        $rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
        $title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';

        $tag = "<link rel='stylesheet' id='$handle' $title href='$href' type='text/less' media='$media' />";
    }
    return $tag;
}
add_filter( 'style_loader_tag', 'enqueue_less_styles', 5, 2);


function getFont($name, $type='url', $opt='')
{
	$fonts = json_decode(get_option('fonts'));
	$font;
	for($i=0; $i<sizeof($fonts->items); $i++)
	{
		if($fonts->items[$i]->family==$name)
		{
			$font = $fonts->items[$i];
			break;
		}
	}
	
	if($type=='url' && isset($font))
	{
		$url = 'http://fonts.googleapis.com/css?family='.urlencode($font->family);
		
		if(sizeof($font->variants)==1)
		{
			$url .= ':'.$font->variants[0];
		}
		else{
			$url .= ':'.opt($opt.'Variant','');
		}
			
		$url .= '&subset='.implode(',',$font->subsets);
		return $url;
	}
	
	if($type=='variants' && isset($font))
	{
		return $font->variants;
	}
}

function opt($v, $def)
{
	if($v=='contentFontFull' || $v=='headerFontFull')
	{
		$v = str_replace('Full','', $v);
		return getFont(opt($v,''),'url',$v);
	}
	elseif(get_option($v)=='')
		return $def;
	else
			return get_option($v);
}
function eopt($v, $def)
{
	echo opt($v, $def);
}

function createItemForImageList($name, $url)
{
$id = str_replace('.', '', $name);
$ret ='
	<tr id="imgs'.$id.'" rel="'.$url.'">
		<td>';
	$ext = strtolower(end(explode('.',$name)));
	if($ext=='jpg' || $ext=='gif' || $ext=='png'){
		$thumb = $url;
		if(function_exists('wpthumb'))
			$thumb = wpthumb($thumb,'width=35&height=35&resize=true&crop=1&crop_from_position=center,center');
		$ret .= '<img id="img'.$id.'" rel="selectable" src="'. $thumb .'" width="35" height="35" style="border:1px solid #333" />';
	}else
		$ret .= '<div id="img'.$id.'" rel="selectable" style="width:35px; height:35px" style="border:1px solid #333">'.$ext.' File</div>';
$ret .= '</td>
		<td>'.$name.'<br />
			<a href="javascript:void(0);" onclick="imageDelete(\''.$id.'\',\''.$name.'\')">[Delete]</a>
		</td>
	</tr>
';
return $ret;
}

// clear page navi style
function wp_pagenavi_clear(){
	wp_deregister_style('wp-pagenavi');
}
add_action( 'wp_print_styles', 'wp_pagenavi_clear');

function wp_title_modification( $title, $separator ) {
	global $paged;

	if(is_search())
	{
		$title = __('Results for ','rb').get_search_query();
		$title .= " $separator ".get_bloginfo('name');
		return $title;
	}else{
	
		if($paged>1) 
			$title .= ' '.__('Page ','rb').$paged." $separator ";
			
		$title .= get_bloginfo('name');

		$description = get_bloginfo('description');

		if((is_home() || is_front_page()) && $description) 
			$title .= " $separator ".$description;
		return $title;
	}
} 
add_filter( 'wp_title', 'wp_title_modification', 10, 2 );

add_filter( 'the_permalink', 'the_permalink_modification');
function the_permalink_modification($link){
	$link = str_replace(home_url ().'/','', $link);
	return $link;
}

function get_ajax_permalink(){
	$link = get_permalink();
	$link = str_replace(home_url ().'/','', $link);
	return $link;
}

class My_Walker extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth=0, $args=array(), $current_object_id = 0) 
	{
		global $wp_query;
		$incount=($depth)?str_repeat( "\t",$depth):'';
		$li_class_name='';
		$val='';
 
		if(empty( $item->classes ))
			$classes=array();
		else
			$classes=(array)$item->classes;
 
		$li_class_name=join(' ',apply_filters( 'nav_menu_css_class', array_filter($classes),$item));
		$li_class_name=' class="'.esc_attr($li_class_name).'"';
 
		$output.=$incount.'<li id="menu-item-'.$item->ID.'"'.$val.$li_class_name.'>';
 
		$attributes= !empty($item->attr_title)?' title="'  .esc_attr($item->attr_title).'"':'';
		$attributes.=!empty($item->target)?' target="' .esc_attr( $item->target) .'"':'';
		$attributes.= !empty($item->xfn)?' rel="'    .esc_attr( $item->xfn).'"':'';
		$itemURL = esc_attr($item->url);
		$itemURL = str_replace(home_url ().'/','', $itemURL);
		$attributes.= !empty($item->url)?' href="'. (($item->target=='_blank')?'':'#!')   .$itemURL.'"':'';
 
		$out = '';
		$out= @$args->before;
		$out.='<a'. $attributes .'><span class="title">';
		$out.= @$args->link_before.apply_filters('the_title',$item->title,$item->ID).@$args->link_after.'</span>';
		$out.='<span class="description">'.$item->description.'</span>';
		$out.='</a>';
		$out.= @$args->after;
 
		$output.=apply_filters('walker_nav_menu_start_el',$out,$item,$depth,$args);
	}
}

//POSTED ON META INFO TEMPLATE 
function posted_on_template () {
	return __('Posted by ', 'rb').get_the_author();
}

function getSource($sourceData, $imageW, $imageH)
{
	if(!empty($sourceData))
	{
		$embedCode = '';
		$sourceType = getMediaType(trim($sourceData));
		$mediaParams = getParamsFromUrl(trim($sourceData));
		if(empty($sourceType))
			return '';
	
			if($sourceType=='vimeo')
				$embedCode = '<iframe src="http://player.vimeo.com/video/'.$mediaParams['v'].'?title=0&amp;byline=0&amp;portrait=0" width="'.$imageW.'" height="'.$imageH.'" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';
			elseif($sourceType=='youtube')
				$embedCode = '<iframe width="'.$imageW.'" height="'.$imageH.'" src="http://www.youtube.com/embed/'.$mediaParams['v'].'?wmode=transparent&rel=0" frameborder="0" allowfullscreen></iframe>';
			elseif($sourceType=='jwplayer')
			{
				$rand = createRandomKey(5);
				$embedCode = '<div id="jwEP'.$rand.'" style="width:'.$imageW.'px; height:'.$imageH.'px;"></div>
							<script>
							jwplayer("jwEP'.$rand.'").setup({
								flashplayer: "'.get_template_directory_uri().'/jwplayer/player.swf",
								autostart: false,
								skin: "'.get_template_directory_uri().'/jwplayer/glow/glow.xml",
								file: "'.$mediaParams['vurl'].'",
								height: '.$imageH.',
								width: '.$imageW.'
								});
							</script>';
			}
			elseif($sourceType=='flash')
			{
				$rand = createRandomKey(5);
				$embedCode = '<div id="flashContent'.$rand.'">
								<p>You need to <a href="http://www.adobe.com/products/flashplayer/" target="_blank">upgrade your Flash Player</a> to version 10 or newer.</p>  
							</div>
							<script type="text/javascript">  
									var flashvars = {};  
									var attributes = {};  
									attributes.wmode = "transparent";
									attributes.play = "true";
									attributes.menu = "false";
									attributes.scale = "showall";
									attributes.wmode = "transparent";
									attributes.allowfullscreen = "true";
									attributes.allowscriptaccess = "always";
									attributes.allownetworking = "all";					
									swfobject.embedSWF("'.$mediaParams['vurl'].'", "flashContent'.$rand.'", "'.$imageW.'", "'.$imageH.'", "10", "'.get_template_directory_uri().'/js/expressInstall.swf", flashvars, attributes);  
							</script>';
			}
			return $embedCode;
	}
}

function getMediaType($mediaUrl){
	if (stripos($mediaUrl, 'youtu.be')!==false || stripos($mediaUrl, 'youtube.com/watch')!==false)
		return 'youtube';
	else if(stripos($mediaUrl,'vimeo.com')!==false)
		return 'vimeo';
	else{
		$extensions = explode('.',$mediaUrl);
		if(sizeof($extensions)>1)
		{
			$qmPosition = stripos(end($extensions),'?');
			if($qmPosition>0)
				$le = substr(end($extensions), $qmPosition);
			else
				$le = end($extensions);
			$le = strtolower($le);
			
			if($le=='flv' || $le=='f4v' || $le=='m4v' || $le=='mp4' || $le=='mov')
				return 'jwplayer';
			else if($le=='swf')
				return 'flash';
			else
				return '';
		}else
			return '';
	}
}
function getParamsFromUrl($mediaURL){
	$params = array();
	$urlSections = explode('/', $mediaURL);
	$lastSection = end($urlSections);
	$qmPosition = stripos($lastSection,'?');
	if(stripos($mediaURL, '?')!==false)
		$params['vurl'] = substr($mediaURL, 0, stripos($mediaURL, '?')); //.substring(0, mediaURL.indexOf('?'));
	else
		$params['vurl'] = $mediaURL;
		
	if($qmPosition>-1){
		$params['v'] = substr($lastSection, 0, $qmPosition); //.substring(0, qmPosition);
		$queryString = substr($lastSection, $qmPosition+1);  //.substring(qmPosition+1);
		$qsSections = explode('&', $queryString);
		for($i=0; $i<sizeof($qsSections); $i++){
			$keyValue = explode('=', $qsSections[$i]);
			if(sizeof($keyValue)==2)
				$params[$keyValue[0]] = $keyValue[1];
		}
	}else{
		$params['v'] = $lastSection;
	}
	return $params;
}
 
add_filter('avatar_defaults','custom_gravatar');
function custom_gravatar($avatar_defaults) 
{
	$myavatar = get_template_directory_uri().'/images/avatar.jpg';
	$avatar_defaults[$myavatar] = 'RightNow Default Avatar'; 
	return $avatar_defaults;
}

if(!function_exists('fb_addgravatar')) 
{
	function fb_addgravatar( $avatar_defaults ) 
	{
		$myavatar = get_template_directory_uri().'/images/avatar.jpg';
		$avatar_defaults[$myavatar] = 'RightNow Default Avatar';
		return $avatar_defaults;
	}
	add_filter('avatar_defaults','fb_addgravatar');
}

function comment_callback($comments, $args, $depth ) {
	$GLOBALS['comment'] = $comments;
	switch($comments->comment_type)
	{
		case '':
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<div class="comment-wrapper clearfix">
				<div class="comment-avatar">
					<?php echo get_avatar($comments, 80); ?>
				</div>
				<div class="comment-text">
					<div class="comment-author">
						<span class="author-link"><?php echo get_comment_author_link(); ?></span> 
						<span class="author-date"><?php echo get_comment_date(); ?></span> 
						<span class="author-time"><?php echo get_comment_time(); ?></span>
					</div> 
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					<?php comment_text(); ?>
				</div>
			</div>
  <?php
			break;
		case 'pingback'  :
		case 'trackback' :
  ?>
        <li class="post pingback">
          <p>
            <?php __('Pingback:','rb'); ?>
            <?php comment_author_link(); ?>
            <?php edit_comment_link( __('Edit','rb'),''); ?>
          </p>
          <?php
			break;
	}
}

?>