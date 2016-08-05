<!DOCTYPE html>
<?php
//preview settings
$tmpurl = get_template_directory_uri();

if(opt('contentFont','')!='')
	wp_enqueue_style('contentFont', opt('contentFontFull',''), false, null, 'all');
if(opt('headerFont','')!='')
	wp_enqueue_style('headerFont', opt('headerFontFull',''), false, null, 'all');
?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php if(isset($_GET['_escaped_fragment_']) && !empty($_GET['_escaped_fragment_'])){
			echo get_ajax_content($_GET['_escaped_fragment_'], 'title');
		}else{
			wp_title( '|', true, 'right' );
		} ?>
</title>
<meta name="fragment" content="!">
<meta name="description" content="<?php if(isset($_GET['_escaped_fragment_']) && !empty($_GET['_escaped_fragment_'])){
		echo get_ajax_content($_GET['_escaped_fragment_'], 'description');
	}else{ ?><?php bloginfo('description'); ?>
<?php } ?>" />
<?php wp_head(); ?>
<?php
$favicon = trim(opt('favicon',''));
if(!empty($favicon)){
if(strpos($favicon,'http')===false)
	$favicon = $tmpurl.'/'.$favicon;
?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $favicon; ?>">
<?php } ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php 
$analyticsCode = opt('analyticsCode','');

if(!empty($analyticsCode))
{
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo trim($analyticsCode); ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php } ?>

<script type='text/javascript'>
var themeURL = '<?php echo $tmpurl;?>';
var bgTime = <?php eopt('bgAniTime','6000'); ?>; // Background Image/Video animation display duration (ms)
var bgPaused= <?php eopt('bgPaused','false'); ?>; // Background Image/Video animation paused
var menuTime = <?php eopt('menuDelay','500'); ?>; // menu delay (ms)
var autoPlay = <?php eopt('autoPlay','true'); ?>; // Background audio autoplay
var loop = <?php eopt('loop','false'); ?>; // Background audio loop or next song
var NormalFade = <?php eopt('bgNormalFade','false'); ?>; // Normal fade or animated bg image
var drawActions = <?php eopt('drawActions','true'); ?>; // Enable or Disable draw actions
var videoLoop = <?php eopt('videoLoop','true'); ?>; // if true video will be play again when end of the video.
var muteWhilePlayVideo = <?php eopt('muteWhilePlayVideo','true'); ?>; // True ise video baslayinca playlis mute olur
var frontPage = '<?php eopt('frontPageURL',''); ?>'; // Front Page URL
var btnSoundUrlMp3 = '<?php eopt('btnSoundURLMp3',''); ?>'; // Button Hover Sound
var btnSoundUrlOgg = '<?php eopt('btnSoundURLOgg',''); ?>'; // Button Hover Sound
var videoMuted = <?php eopt('videoMuted','false'); ?>;
var loopBg = <?php eopt('loopBg','true'); ?>;
var bgPatternV = '<?php eopt('bgPattern','block');?>';
var bgControllerV = '<?php eopt('bgController','block');?>';
//-- v1.1
var videoPaused = <?php eopt('videoPaused','false');?>;
var bgStretch = <?php eopt('bgStretch','true');?>;

var defaultTitle = '<?php wp_title( '|', true, 'right' ); ?>';
var defaultURL = '<?php echo home_url(); ?>';
<?php if(isset($_GET['_escaped_fragment_']) && !empty($_GET['_escaped_fragment_'])){ ?>
	$(window).load(function(){
		pageLoaded();
	});
<?php }?>
</script>
</head>
<body <?php body_class(); ?>>
<!-- BEGIN: Body Wrapper -->
<div id="body-wrapper">
	<!-- BEGIN: Main Elements; Please don't change these elements -->
	<div id="bgImage"><div id="bgImageWrapper"></div></div>
	<div id="bgPattern"></div>
	<div id="videoExpander"></div>
	<div id="bgText"><div class="headerText"></div><br/><div class="subText"></div><div style="clear:both"></div></div>
	<div id="content">
		<div id="contentBox">
			<div id="contentBoxContainer">
			<?php
			if(isset($_GET['_escaped_fragment_']) && !empty($_GET['_escaped_fragment_'])){
				echo get_ajax_content($_GET['_escaped_fragment_'], 'page');
			}
			?>
			</div>
		</div>
	</div>
	<div id="contentBoxScroll">
		<a id="closeButton" href="#!//"></a>
		<div class="dragcontainer">
			<div id="contentBoxScrollDragger" class="dragger">
				<div class="scroll_up"></div>
				<div class="scroll_down"></div>
			</div>
		</div>
	</div>
	<!-- END: Main Elements -->
	<!-- BEGIN: Bottom Side Bar -->
	<ul id="bgImages">		
		<?php
			$fpgalleryid = get_option('fpgalleryid');
			if(!empty($fpgalleryid)){
				$result = $wpdb->get_results("SELECT IMAGEID, TYPE, CONTENT, THUMB, CAPTION, DESCRIPTION, WIDTH, HEIGHT FROM {$wpdb->prefix}backgrounds WHERE GALLERYID='$fpgalleryid' ORDER BY SLIDERORDER");
				foreach($result as $row)
				{
					echo "<li>\n";
									
					if($row->TYPE=='image')
						echo '<a href="'.$row->CONTENT.'" alt="'.$row->CAPTION.'" />';
					elseif($row->TYPE=='vimeo')
						echo '<a href="http://vimeo.com/'.$row->CONTENT.'?width='.$row->WIDTH.'&height='.$row->HEIGHT.'" >';
					elseif($row->TYPE=='youtube')
						echo '<a href="http://youtu.be/'.$row->CONTENT.'?width='.$row->WIDTH.'&height='.$row->HEIGHT.'" >';
					else
						echo '<a href="'.$row->CONTENT.'?width='.$row->WIDTH.'&height='.$row->HEIGHT.'" >';
					
					$thumb_src = $row->THUMB;
					if(function_exists('wpthumb'))
						$thumb_src = wpthumb($row->THUMB,'width=120&height=80&resize=true&crop=1&crop_from_position=center,center');
					echo '<img class="thumb" src="'.$thumb_src.'" alt="'.$row->CAPTION.'" />'."\n";
					
					echo '</a>';
					
					if(!empty($row->CAPTION))
						echo '<h3>'.stripslashes($row->CAPTION).'</h3>'."\n";
						
					if(!empty($row->DESCRIPTION))
						echo '<p>'.stripslashes($row->DESCRIPTION).'</p>'."\n";
					
					echo "</li>\n";
				}
			}
		?>	
	</ul>
	<!-- END: Bottom Side Bar -->
	
	<!-- BEGIN: Main Menu -->
	<div id="menu-container">
		<!-- BEGIN: Logo -->
		<div id="logo">
			<?php 
			$logoURL = opt('logo_url','');
			if(strpos($logoURL,'http')===false)
				$logoURL = $tmpurl.'/'.$logoURL;
			?>
			<img src="<?php echo $logoURL; ?>" title="<?php bloginfo('name'); ?>" border="0"/>
		</div>
		<div class="clearfix"></div>
		<!--END: Logo -->
		<div id="mainmenu">
			<?php 
			wp_nav_menu( array('container_class' => 'menu-header', 'theme_location' => 'primary', 'walker' => new My_Walker(), 'show_home' => true ) ); 
			?>
		</div>
	</div>
	<!-- END: Main Menu -->
	

	
	
	<!-- BEGIN: Footer -->
	<div id="footer">
		<!-- BEGIN: Share Buttons -->
		<?php if(isset($_GET['_escaped_fragment_']) && !empty($_GET['_escaped_fragment_'])){
			$url = home_url().'/#!'.$_GET['_escaped_fragment_'];
		}else{
			$url = home_url();
		} ?>
		<div id="share">
			<ul>
				<li><a class="btnCtrl tip fb" target="_blank" rel="http://www.facebook.com/sharer.php?u=%%url%%" href="http://www.facebook.com/sharer.php?u=http:<?php echo $url;?>" ></a></li>
				<li><a class="btnCtrl tip tw" target="_blank" rel="http://twitter.com/home?status=<?php _e('Check out this Awesome Site - ','rb'); ?>%%url%%" href="http://twitter.com/home?status=<?php _e('Check out this Awesome Site - ','rb'); ?><?php echo $url;?>" ></a></li>
				<li><a class="btnCtrl tip rss" href="<?php echo $url;?>?feed=rss" ></a></li>
			</ul>		
		</div>
		<!-- END: Share Buttons -->
		<div id="footertext"> <?php echo do_shortcode(stripslashes(opt('copyrighttext',''))); ?></div>
		<div id="footeraudio">
			<a class="btnCtrl tip soundicon" href="javascript:void(0);" ></a>
			<a class="btnCtrl tip soundmute" href="javascript:void(0);" ></a>
			<a class="btnCtrl tip soundplaylist" href="javascript:void(0);" onclick="playListShow();" ></a>
		</div>
	</div>
	<!-- END: Footer -->
	
	
	
	<!-- BEGIN: Background Controller Buttons -->
	<div id="bgControl">
		<div id="bgControlCount"></div>
		<div id="bgControlButtons">
			<a class="btnCtrl prev" href="javascript:void(0);" onclick="prevBg()"></a>
			<a class="btnCtrl play" href="javascript:void(0);" onclick="playBg()"></a>
			<a class="btnCtrl pause" href="javascript:void(0);" onclick="pauseBg()"></a>
			<a class="btnCtrl next" href="javascript:void(0);" onclick="nextBg()"></a>
			<a class="btnCtrl fitte" href="javascript:void(0);" onclick="setFit()"></a>
			<a class="btnCtrl full" href="javascript:void(0);" onclick="setFull()"></a>
			<a class="btnCtrl soundicon" href="javascript:void(0);" onclick="videoMute()"></a>
			<a class="btnCtrl soundmute" href="javascript:void(0);" onclick="videoUnMute()"></a>
			<a class="btnCtrl info" href="javascript:void(0);" onclick="setInfo()"></a>
			<a class="btnCtrl close" href="javascript:void(0);" onclick="setMin()"></a>
		</div>
	</div>
	<!-- END: Background Controller Buttons -->
	
	<!-- BEGIN: Please don't remove these elements -->
	<div id="fullControl"></div>
	<a href="javascript:void(0);" id="thumbOpener"></a>
	<!-- END -->
	
</div>
<!-- END: Body Wrapper -->


<!-- BEGIN: Music Player -->
<div id="playList">
	<div id="playWrapper">
		<!-- BEGIN: Audio Player; Please don't remove these elements -->
		<div id="player">
			<div id="playerSongName"></div>
			<div id="playerController">
				<a href="javascript:void(0);" class="playerBtn stop"></a>
				<a href="javascript:void(0);" class="playerBtn play"></a>
				<a href="javascript:void(0);" class="playerBtn pause"></a>
				<a href="javascript:void(0);" class="playerBtn loop"></a>
				<a href="javascript:void(0);" class="playerBtn nextsong"></a>
				<div id="playerLoadBar">
					<div id="playerBar">
						<div id="playerBarActive"></div>
					</div>
				</div>
				<div id="playerSongDuration"><span class="current"></span><span class="total"></span></div>
				<a href="javascript:void(0);" class="playerBtn mute"></a>
				<a href="javascript:void(0);" class="playerBtn unmute"></a>
				<div id="volumeLoadBar">
					<div id="volumeBar">
						<div id="volumeBarActive"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<!-- END: Audio Player -->
		
		
		<!-- BEGIN: Audio List -->
		<div id="audioList">
			<ul>
			<?php
				$audioList = get_option("audioList");
				$listHTML = '';
				if(!empty($audioList))
				{
					$audioJSON = json_decode($audioList);
					for($i=0; $i<sizeof($audioJSON); $i++)
						echo '<li data-mp3="'.htmlentities(stripslashes($audioJSON[$i]->mp3),ENT_QUOTES, "UTF-8").'" data-ogg="'.htmlentities(stripslashes($audioJSON[$i]->ogg),ENT_QUOTES, "UTF-8").'">'.htmlentities(stripslashes($audioJSON[$i]->name),ENT_QUOTES, "UTF-8")."</li>\n";
				}
				?>
			</ul>
		</div>
		<!-- END: Audio List -->
	</div>
	<div id="playListCloseIcon"><?php _e('CLOSE','rb');?></div>
</div>
<!-- END: Music Player -->

<!-- BEGIN: First Loading; Please don't remove this element -->
<div id="bodyLoading">
	<div id="loading">
		<!-- You can change loading logo  -->
		
		<?php 
		$llogoURL = opt('loading_logo_url','');
		if(strpos($llogoURL,'http')===false)
			$llogoURL = $tmpurl.'/'.$llogoURL;
		?>
		<img src="<?php echo $llogoURL; ?>" title="<?php bloginfo('name'); ?>" border="0"/>
	</div>
</div>
<!-- END: First Loading -->

<!-- BEGIN: Please don't remove or change these elements -->
<canvas id="circleC" width="100" height="100"></canvas>
<div id="REF_ColorFirst"></div>
<div id="REF_ColorSecond"></div>
<!-- END:  -->
<?php wp_footer();?>
</body>
</html>