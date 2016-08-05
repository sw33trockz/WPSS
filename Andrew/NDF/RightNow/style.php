<?php 
//Setup location of WordPress
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

//Access WordPress
require_once( $path_to_wp.'/wp-load.php' );

header ("Content-Type:text/css"); 

if(!$demo){

$ColorFirst = '#'.opt('colorFirst','');
$NormalFont = "'".opt('contentFont','')."', sans-serif";
$HeaderFont = "'".opt('headerFont','')."', sans-serif";
$ColorSecond = '#'.opt('colorSecond','');
$BackgroundColor = '#'.opt('colorBackground','');
$ThemePrefix = opt('theme_style','');
$LineColor = '#'.opt('colorLine','');
$TextColor = '#'.opt('colorText','');
$PasifButtonBg = '#'.opt('colorPasifButtonBg','');
$imagesDir = "images/";

}else{

echo '@ImagesDir: "images/";'."\n";
	$imagesDir = '@{ImagesDir}';

echo '@ColorFirst : '. "#".opt('colorFirst','').";\n";
	$ColorFirst = '@ColorFirst';
echo '@ColorSecond : '. "#".opt('colorSecond','').";\n";
	$ColorSecond = '@ColorSecond';
echo '@LineColor : '. "#".opt('colorLine','').";\n";
	$LineColor = '@LineColor';
echo '@TextColor : '. "#".opt('colorText','').";\n";
	$TextColor = '@TextColor';
echo '@BackgroundColor : '. "#".opt('colorBackground','').";\n";
	$BackgroundColor = '@BackgroundColor';
echo '@PasifButtonBg : '. "#".opt('colorPasifButtonBg','').";\n";
	$PasifButtonBg = '@PasifButtonBg';

echo '@ThemePrefix : "'. opt('theme_style','')."\";\n";
$ThemePrefix = '@{ThemePrefix}';
	
$NormalFont = "'".opt('contentFont','')."', sans-serif";
$HeaderFont = "'".opt('headerFont','')."', sans-serif";

}
?>
/*
Theme Name: RightNow
Theme URI: http://www.renklibeyaz.com/rightnowwp/
Description: RightNow HTML
Author: RenkliBeyaz - Salih Ozovali
Version: 1.0
*/

/* REF: Please Dont Change this styles */
#REF_ColorFirst{color:<?php echo $ColorFirst; ?>; display:none; }
#REF_ColorSecond{color:<?php echo $ColorSecond; ?>; display:none; }
/*REF*/


/******** CSS Start ********/

/*Body Loading*/
#bodyLoading{
	width:100%;
	position:absolute;
	left:0;
	top:0;
	text-align:center;
}
#loading{
	margin:200px auto 0px auto;
	text-align:center;
}
/* General */
* {
	-webkit-user-drag: none;
	margin:0px;
	padding:0px;
	border:none;
	outline:none;
	font-size:<?php eopt('contentFontSize','12');?>px;
	line-height:1.4em;
	color: <?php echo $TextColor; ?>;
	font-family: <?php echo $NormalFont; ?>;
}
* html .clearfix {
	height: 1%; /* IE5-6 */
	}
*+html .clearfix {
	display: inline-block; /* IE7not8 */
	}
.clearfix:after { /* FF, IE8, O, S, etc. */
	content: ".";
	display: block;
	height: 0;
	clear: both;
	visibility: hidden;
	}
::selection {
        background: <?php echo $ColorFirst; ?>; /* Safari */
		color: <?php echo $ColorSecond; ?>;  
        }
::-moz-selection {
        background: <?php echo $ColorFirst; ?>; /* Firefox */
		color: <?php echo $ColorSecond; ?>;  
}
a{
	-moz-transition: all 0.3s ease-in-out 0s;
	transition: all 0.3s ease-in-out;
	-webkit-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
}
a:link, a:visited{
	text-decoration:underline;
	color: darken(<?php echo $TextColor; ?>, 10%);
}
a:hover, a:active{
	text-decoration:none;
}

body{
	background: <?php echo $BackgroundColor; ?>;
	overflow:hidden;
}
html {
	overflow:hidden;
	background: <?php echo $BackgroundColor; ?>;
}

#fullControl{
	opacity:0;
	position:absolute;
	right:10px;
	top:100px;
}

#body-wrapper{
	width:100%;
	background-color: <?php echo $BackgroundColor; ?>;
	text-align:center;
	overflow:hidden;
	position:relative;
	opacity:0;
}
#content{
	opacity:0;
	display:none;
	position:absolute;
	overflow:hidden;
	width:600px;
	left:0px;
	top:20px;
	padding:20px;
	background: url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-content-bg.png');
}
#contentBox{
	position:relative;
	overflow:hidden;
	text-align:left;
	width:600px;
}
#contentBoxScroll{
	top:20px;
	position:absolute;
	display:none;
	text-align:left;
	width:27px;
	background: url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-content-scroll-bg.png');
}
#contentBoxContainer{
	position:relative;
}
.dragcontainer{
	position:relative;
	height:500px;
}
.dragger{
	position:absolute;
	left:5px;
	width:17px;
	height:100px;
	background-color:<?php echo $ColorFirst; ?>;
	cursor:pointer;
}
.scroll_up, .scroll_down{
	width:5px;
	height:6px;
	background-color:<?php echo $ColorFirst; ?>;
	margin:6px 0 0 6px;
	background-image:url('<?php echo $imagesDir; ?>scroll_arrow_up.png');
}
.scroll_down{
	background-image:url('<?php echo $imagesDir; ?>scroll_arrow_down.png');
	margin:76px 0 6px 6px;
}
#closeButton:link, #closeButton:visited{
	display:block;
	width:27px;
	height:27px;
	background-image:url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-close_btn_bg.png');
}
#closeButton:hover, #closeButton:active{
	background-position:0 -27px;
}

#bgImages{
	display: <?php eopt('thController','block'); ?>;
	list-style:none;
	position:absolute;
	left:0px;
	bottom:-50px;
	height:92px;
	background: url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-bgImages.png');
}
#bgImages li{
	position:relative;
	margin:0;
	float:left;
	padding:3px;
}
#bgImages img.thumb{
	height:80px;
	margin:0;
	padding:3px 0 0 0;
	cursor:pointer;
	opacity:.30;
	border-top:3px solid #666;
}
#bgImages li .thumbType{
	opacity:0;
	position:absolute;
	width:20px;
	height:20px;
	right:3px;
	bottom:7px;
	background-color:<?php echo $ColorFirst; ?>;
}
#bgImages li .thumbVideo{
	opacity:0;
	background-image: url('<?php echo $imagesDir; ?>thumb_video.png');
}
#bgImages li .thumbImage{
	opacity:0;
	background-image: url('<?php echo $imagesDir; ?>thumb_image.png');
}
#bgImages li .thumbFlash{
	opacity:0;
	background-image: url('<?php echo $imagesDir; ?>thumb_flash.png');
}
#bgImages img.source, #bgImages iframe{
	display:none;
}
#bgImages h3, #bgImages p{
	display:none;
}
#bgImages li.active img.thumb{
	border-top:3px solid <?php echo $ColorFirst; ?>;
}
#bgImage{
	position:absolute;
	left:0;
	top:0;
}
#bgText{
	display:inline-block;
	text-align:left;
	position:absolute;
	left:7px;
	bottom:64px;
	padding:10px;
}
#bgText .headerText{
	display:inline;
	font-size:54px;
	line-height:54px;
	color:<?php echo $ColorFirst; ?>;
	padding:0 10px;
	font-weight:700;
	font-family: <?php echo $HeaderFont; ?>;
	text-shadow:2px 2px rgba(0,0,0,.5);
}
#bgText .subText{
	margin-top:10px;
	display:inline;
	font-size:16px;
	line-height:16px;
	padding:0 10px;
	text-transform:uppercase;
	color:#fff;
	font-family: <?php echo $HeaderFont; ?>;
	font-weight:700;
	text-shadow:2px 2px rgba(0,0,0,.5);
}
#bgImageWrapper{
	position:relative;
}
#bgImageWrapper img{
	position:absolute;
}
#ytVideo, #vmVideo, #jwVideo, #swfContent{
	position:absolute;
}
#bgPattern{
	display: <?php eopt('bgPattern','block'); ?>;
	position:absolute;
	background: url('<?php echo $imagesDir; ?>pattern.png');
}
#videoExpander{
	display: none;
	position:absolute;
	background: url('<?php echo $imagesDir; ?>top_right_expand.png') no-repeat center center;
}
.bgCanvas{
	position:absolute;
	left:0;
	top:0;
}

/*Image Animate*/
.hoverWrapperBg{
	opacity:.50;
	background-color:<?php echo $BackgroundColor; ?>;
	box-shadow: -5px -5px <?php echo $ColorFirst; ?> inset, 5px 5px <?php echo $ColorFirst; ?> inset;
	position:absolute;
	width:100%;
	left:0px;
	top:0px;
}
.image_frame{
	position:relative;
	cursor:pointer;
}
.image_frame > a{
	display:block;
	padding:0;
	margin:0;
	font-size:0px;
}
.hoverWrapper{
	position:absolute;
	width:100%;
	left:0;
	top:0;
}
/*
.hoverWrapper .link:link, 
.hoverWrapper .link:visited, 
.hoverWrapper .modal:link,
.hoverWrapper .modal:visited,
.hoverWrapper .modalVideo:link,
.hoverWrapper .modalVideo:visited*/

.hoverWrapper .link,

.hoverWrapper .modal,

.hoverWrapper .modalVideo{
	-moz-transition: all 0.3s ease-in-out 0s;
	transition: all 0.3s ease-in-out;
	-webkit-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	background-color:<?php echo $ColorFirst; ?>;
	display:block;
	width:33px;
	height:33px;
	position:absolute;
	bottom:5px;
}
/*.hoverWrapper .link:link, .hoverWrapper .link:visited{right:15px; background-image: url('<?php echo $imagesDir; ?>imageLink.png');}
.hoverWrapper .modal:link, .hoverWrapper .modal:visited{right:49px;  background-image: url('<?php echo $imagesDir; ?>imageModal.png');}
.hoverWrapper .modalVideo:link, .hoverWrapper .modalVideo:visited{right:49px; background-image: url('<?php echo $imagesDir; ?>imageVideo.png');}*/
.hoverWrapper .link{right:15px; background-image: url('<?php echo $imagesDir; ?>imageLink.png');}

.hoverWrapper .modal{right:49px;  background-image: url('<?php echo $imagesDir; ?>imageModal.png');}

.hoverWrapper .modalVideo{right:49px; background-image: url('<?php echo $imagesDir; ?>imageVideo.png');}
.hoverWrapper .link:hover, .hoverWrapper .link:active,
.hoverWrapper .modal:hover, .hoverWrapper .modal:active,
.hoverWrapper .modalVideo:hover, .hoverWrapper .modalVideo:active{
background-position:0 -33px;
box-shadow: -2px -2px rgba(0,0,0,.5) inset, 2px 2px rgba(0,0,0,.5) inset;
}

.blogdatemeta{
	height:33px;
	padding:10px 0;
	border-top:1px solid <?php echo $LineColor; ?>;
	border-bottom:1px solid <?php echo $LineColor; ?>;
}
.blogdate{
	float:left;
	display:inline-block;
	line-height:33px;
	font-size:18px;
	color:<?php echo $ColorSecond; ?>;
	font-family:<?php echo $HeaderFont; ?>;
}
.hoverWrapper h3{
	opacity:0;
	text-align:left;
	padding:15px;
	margin:10px;
	font-size:18x;
	line-height:20px;
	color:<?php echo $ColorSecond; ?>;
	background-color:<?php echo $ColorFirst; ?>;
	font-family: <?php echo $HeaderFont; ?>;
}
.hoverWrapper .enter-text{
	opacity:0;
	text-align:left;
	padding:0px 15px 10px 15px;
	font-size:11px;
}

/*Play List*/
a.playerBtn:link, a.playerBtn:visited{
	-moz-transition: all 0.3s ease-in-out 0s;
	transition: all 0.3s ease-in-out;
	-webkit-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	display:block; 
	width:16px; height:16px;
	border:1px solid #000;
	background-color:<?php echo $PasifButtonBg; ?>;
	box-shadow: inset -1px -1px rgba(0,0,0, 0.5), inset 1px 1px rgba(255,255,255, 0.1) ;
}
a.playerBtn:hover, a.playerBtn:active{
	background-color:<?php echo $ColorFirst; ?>;
	background-position:0 -16px;
}
#playerController .play{background-image:url('<?php echo $imagesDir; ?>icon_player_play.png');}
#playerController .pause{background-image:url('<?php echo $imagesDir; ?>icon_player_pause.png');}
#playerController .stop{background-image:url('<?php echo $imagesDir; ?>icon_player_stop.png');}
#playerController .loop{background-image:url('<?php echo $imagesDir; ?>icon_player_loop.png');}
#playerController .nextsong{background-image:url('<?php echo $imagesDir; ?>icon_player_nextsong.png');}
#playerController .mute{background-image:url('<?php echo $imagesDir; ?>icon_player_mute.png'); display:none; margin-left:2px;}
#playerController .unmute{background-image:url('<?php echo $imagesDir; ?>icon_player_unmute.png'); margin-left:2px;}

#playList{
	display:none;
	position:absolute;
	left:0;
	top:0;
	background: url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-content-bg.png');
}
#playWrapper{
	padding:10px;
	position:relative;
	width:300px;
	background-image: url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-content-bg.png');
}
#playerBar{
	position:relative;
	width:100px;
	height:16px;
}
#playerBarActive{
	position:absolute;
	top:0;
	left:0;
	height:16px;
	width:0px;
	background-color:<?php echo $ColorFirst; ?>;
}
#volumeBar{
	position:relative;
	width:50px;
	height:16px;
}
#volumeBarActive{
	position:absolute;
	top:0;
	left:0;
	height:16px;
	width:0px;
	background-color:<?php echo $ColorFirst; ?>;
}
#playListCloseIcon{
	padding:5px;
	position:absolute;
	font-size:14px;
	font-family: <?php echo $HeaderFont; ?>;
	background-color:<?php echo $ColorFirst; ?>;
	color:<?php echo $ColorSecond; ?>;
}
#playerSongName{
	padding:10px 0;
	border-bottom:3px solid <?php echo $ColorFirst; ?>;
	margin-bottom:10px;
	
	font-size:14px;
	line-height:14px;
	font-family: <?php echo $HeaderFont; ?>;
	color:<?php echo $ColorFirst; ?>;
}
#playerController{
	margin-bottom:10px;
}
#playerController a{
	float:left;
	margin-right:1px;
}
#playerLoadBar{
	float:left;
	width:100px;
	height:16px;
	border:1px solid darken(<?php echo $ColorSecond; ?>, 20%);
	margin-left:4px;
}
#volumeLoadBar{
	float:left;
	width:50px;
	height:16px;
	border:1px solid darken(<?php echo $ColorSecond; ?>, 20%);
}
#playerSongDuration{
	float:left;
	width:53px;
	height:18px;
	margin-left:5px;
	margin-right:5px;
}
#playerSongDuration span{
	font-size:10px;
	font-family:'Arial';
	line-height:18px;
}
#playerSongDuration span.current{ color:<?php echo $ColorFirst; ?>; }
#playerSongDuration span.total{ color:<?php echo $ColorSecond; ?>; }
#playerController img{float:left; margin:4px 5px 0 5px;}
#audioList{
	margin-top:10px;
	clear:both;
}
#audioList ul {
	border-top:1px solid <?php echo $LineColor; ?>;
	list-style:none;
	padding:1px;
}
#audioList ul li{
	cursor:pointer;
	line-height:28px;
	border-bottom:1px solid <?php echo $LineColor; ?>;
}
#audioList ul li.active{
	background-color:<?php echo $ColorFirst; ?>;
	color:<?php echo $ColorSecond; ?>;
	text-indent:10px;
}
#audioList ul li.active > * {
	color:<?php echo $ColorSecond; ?>;
}


/*Menu*/
#logo img{
	margin:0;
	padding:0;
	line-height:1em;
}
#logo{
text-align:left;
float:left;
display:inline-block;
background-color:<?php echo $ColorFirst; ?>;
}

#menu-container{
	position:absolute;
	left:0px;
	top:20px;
	border-left:5px solid <?php echo $ColorFirst; ?>;
}
#mainmenu{
	margin:9px 0 0 10px;
}
#mainmenu ul{
	list-style:none;
}
#mainmenu  ul > li{
	position:relative;
	margin-bottom:1px;
	text-align:left;
}
#mainmenu ul li a:link,
#mainmenu ul li a:visited{
	padding:3px;
	display:inline-block;
	text-decoration:none;
	text-align:left;
}
#mainmenu ul li a:hover,
#mainmenu ul li a:active{
}
#mainmenu ul > li.active > a:link,
#mainmenu ul > li.active > a:visited{
}
#mainmenu ul li a span.title{
	display:inline-block;
	margin:0;
	padding:3px 10px 3px 10px;
	position:relative;
	color:<?php echo $ColorSecond; ?>;
	font-size:16px;
	font-family: <?php echo $HeaderFont; ?>;
	font-weight:500;
}
#mainmenu ul > li > a{
	background-image: url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-menu-bg.png');
}
#mainmenu ul li ul li a:link,
#mainmenu ul li ul li a:visited{
}
#mainmenu ul li ul li a:hover,
#mainmenu ul li ul li a:active{
}
#mainmenu ul li ul li a span.title{
	color:<?php echo $ColorSecond; ?>;
}
#mainmenu ul li a:hover span.title,
#mainmenu ul li a:active span.title,
#mainmenu ul > li.active > a:link span.title,
#mainmenu ul > li.active > a:visited span.title{
	-moz-transition: all 0.3s ease-in-out 0s;
	transition: all 0.3s ease-in-out;
	-webkit-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	color:<?php echo $ColorSecond; ?>;
	background-color:<?php echo $ColorFirst; ?>;
}
#mainmenu ul li ul li a:hover span.title,
#mainmenu ul li ul li a:active span.title{
	color:<?php echo $ColorSecond; ?>;
	background-color:<?php echo $ColorFirst; ?>;
}
#mainmenu ul .description{
	display:none;
}
#mainmenu ul ul{
	top:0;
}
#mainmenu ul ul li{
	float:left;
	margin-left:1px;
}

/* Footer */
#footer{
	position:absolute;
	left:0;
	bottom:0;
	width:100%;
	background: url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-footer.png');
	height:32px;
	padding-top:1px;
}
#footertext{
	float:left;
	padding:0 10px;
	height:30px;
	line-height:30px;
	color:<?php echo $TextColor; ?>;
}
#footeraudio{
	display: <?php eopt('audioController','block'); ?>;
	float:right;
}
#footeraudio a{
	float:left;
	margin-left:1px;
}
#footeraudio .soundmute{ display:none;}
#bgControl{
	display: <?php eopt('bgController','block'); ?>;
	position:absolute;
	right:20px;
	top:20px;
	background-color:<?php echo $ColorFirst; ?>;
	padding:5px;
	height:30px;
}
#bgControlCount{
	display:inline-block;
	padding:0 15px 0 10px;
	font-size:18px;
	line-height:30px;
	vertical-align:top;
	font-family:<?php echo $HeaderFont; ?>;
	color:<?php echo $ColorSecond; ?>;
}
#bgControlButtons{
	display:inline-block;
}
#bgControlButtons a{margin-right:1px;}
#bgControl .play, #bgControl .full, #bgControl .close, #bgControl .info{display:none;}
#bgControl .next:link, #bgControl .next:visited{ background-image: url('<?php echo $imagesDir; ?>bgControlRight.png');}
#bgControl .prev:link, #bgControl .prev:visited{ background-image: url('<?php echo $imagesDir; ?>bgControlLeft.png');}
#bgControl .pause:link, #bgControl .pause:visited{ background-image: url('<?php echo $imagesDir; ?>bgControlPause.png');}
#bgControl .play:link, #bgControl .play:visited{ background-image: url('<?php echo $imagesDir; ?>bgControlPlay.png');}
#bgControl .full:link, #bgControl .full:visited{ background-image: url('<?php echo $imagesDir; ?>bgControlFull.png');}
#bgControl .fitte:link, #bgControl .fitte:visited{ background-image: url('<?php echo $imagesDir; ?>bgControlFit.png');}
#bgControl .soundicon:link, #bgControl .soundicon:visited{display:none; background-image: url('<?php echo $imagesDir; ?>icon_sound.png');} 
#bgControl .soundmute:link, #bgControl .soundmute:visited{display:none; background-image: url('<?php echo $imagesDir; ?>icon_mute.png');} 


#bgControl .close:link, #bgControl .close:visited{ background-image: url('<?php echo $imagesDir; ?>bgControlClose.png');}
#bgControl .info:link, #bgControl .info:visited{ background-image: url('<?php echo $imagesDir; ?>bgControlInfo.png');}
#footeraudio .soundicon:link, #footeraudio .soundicon:visited{background-image: url('<?php echo $imagesDir; ?>icon_sound.png');}
#footeraudio .soundmute:link, #footeraudio .soundmute:visited{background-image: url('<?php echo $imagesDir; ?>icon_mute.png');}
#footeraudio .soundplaylist:link, #footeraudio .soundplaylist:visited{background-image: url('<?php echo $imagesDir; ?>icon_playlist.png');}

#share{float:left; display: <?php eopt('shareIcons','block'); ?>; }
#share  ul{list-style:none;}
#share li{float:left; margin-right:1px;}
a.btnCtrl:link, a.btnCtrl:visited{
	-moz-transition: all 0.3s ease-in-out 0s;
	transition: all 0.3s ease-in-out;
	-webkit-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	float:left;
	display:inline;
	width:30px; 
	height:30px;
	background-color:<?php echo $PasifButtonBg; ?>;
	box-shadow: inset -1px -1px rgba(0,0,0, 0.5), inset 1px 1px rgba(255,255,255, 0.1) ;
}
a.btnCtrl:hover, a.btnCtrl:active{
	background-color:<?php echo $ColorFirst; ?>;
	background-position:0 -30px;
}
#share .tw{background-image: url('<?php echo $imagesDir; ?>icon_tw.png');}
#share .fb{background-image: url('<?php echo $imagesDir; ?>icon_fb.png');}
#share .rss{background-image: url('<?php echo $imagesDir; ?>icon_rss.png');}
#circleC{
	display:none;
	position:absolute;
	left:200px;
	top:100px;
}

/*BLOG*/
.blogitem{margin-top:20px;}
#content h1.caption{
	padding:14px 0 15px 0;
	font-family: <?php echo $HeaderFont; ?>;
	font-size:24px;
	line-height:1.2em;
	color: <?php echo $ColorSecond; ?>;
	border-bottom:1px solid <?php echo $LineColor; ?>;
	border-top:3px solid <?php echo $ColorFirst; ?>;
}
.blogimage{
	margin-top:20px;
	float:left;
}
.blogdateLeft{
	font-size:12px;
	padding-right:3px;
	margin-top:15px;
	float:left;
	border-right:1px solid #000;
	width:30px;
	color:#000;
	text-align:right;
}
.blogdateRight{
	font-size:12px;
	padding-left:3px;
	margin-top:15px;
	float:left;
	width:29px;
	text-align:left;
	color:#000;
}
.blogcontent{
	margin-top:20px;
	width:230px;
	float:left;
	margin-left:20px;
}
.blogimage h3{
	color:<?php echo $ColorFirst; ?>;
	font-family: <?php echo $HeaderFont; ?>;
	font-size:18px;
	line-height:1.4em;
}
.blogTop{clear:both;}
.blogTop hr{
	float:left;
	width:570px;
	margin-top:8px;
	height:3px;
	background-color:#333;
}
.blogTop a:link,
.blogTop a:visited{
	display:block;
	float:right;
	color:#333;
	font-family: <?php echo $HeaderFont; ?>;
	font-size:12px;
	
	text-decoration:none;
}
.blogTop a:hover,
.blogTop a:active{
	color:#ffcc00;
}
.blogcontent p{
	margin-top:20px;
	font-size:11px;
	float:left;
}
.meta-links{
	float:right;
	display:inline-block;
}
.meta-author, .meta-comments, .meta-tags{
	-moz-transition: all 0.3s ease-in-out 0s;
	transition: all 0.3s ease-in-out;
	-webkit-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	display:block;
	background-color:<?php echo $ColorFirst; ?>;
	width:33px;
	height:33px;
	float:right;
	margin-left:1px;
}
.meta-author:link, .meta-author:visited{ background-image:url('<?php echo $imagesDir; ?>blogicon-author.png');}
.meta-comments:link, .meta-comments:visited{ background-image:url('<?php echo $imagesDir; ?>blogicon-comment.png');}
.meta-tags:link, .meta-tags:visited{ background-image:url('<?php echo $imagesDir; ?>blogicon-tag.png');}
.meta-author:hover, .meta-author:active,
.meta-comments:hover, .meta-comments:active,
.meta-tags:hover, .meta-tags:active{ 
background-position:0 -33px;
box-shadow: -2px -2px rgba(0,0,0,.5) inset, 2px 2px rgba(0,0,0,.5) inset;}

.morelink:link,
.morelink:visited{
	display:inline-block;
	font-size:14px;
	background-color:<?php echo $ColorFirst; ?>;
	color:<?php echo $ColorSecond; ?>;
	padding:5px 9px;
	text-decoration:none;
	margin-top:20px;
}
.morelink:hover,
.morelink:active{
	box-shadow: -2px -2px rgba(0,0,0,.5) inset, 2px 2px rgba(0,0,0,.5) inset;
}
.meta-tips{
	position:absolute;
	color:<?php echo $ColorSecond; ?>;
	padding:5px 10px;
	background-color:<?php echo $ColorFirst; ?>;
}
.meta-tips span{
	width:10px;
	height:10px;
	position:absolute;
	bottom:-6px;
	right:0px;
}
.meta-tips span svg polygon{
	fill:<?php echo $ColorFirst; ?>;
}

/*About*/
.personName{display:block; float:left; padding-top:14px;}
.personName h3{font-size:12px; line-height:16px;}
.personName span{font-size:11px; line-height:11px;}
.personContact{clear:both; display:block; float:right; padding-top:16px; }
.personContact a:link, .personContact a:visited{background-color:<?php echo $ColorFirst; ?>; width:33px; height:33px; display:block; float:left; margin-left:2px;}
.personContact a:hover, .personContact a:active{background-position:0 -33px; box-shadow: -2px -2px rgba(0,0,0,.5) inset, 2px 2px rgba(0,0,0,.5) inset;}
.personFacebook{background-image:url('<?php echo $imagesDir; ?>person-facebook.png');}
.personTwitter{background-image:url('<?php echo $imagesDir; ?>person-twitter.png');}
.personEmail{background-image:url('<?php echo $imagesDir; ?>person-email.png');}

/*Portfolio*/
.portfolioitems{
	list-style:none;
	width:620px;
	overflow:hidden;
}
.portfolio1columns li{
	float:left;
	margin: 20px 0 0 0;
}
.portfolio2columns li{
	float:left;
	margin: 20px 20px 0 0;
}
.portfolio3columns li{
	float:left;
	margin: 20px 20px 0 0;
}
.portfolio4columns li{
	float:left;
	margin: 20px 20px 0 0;
}
.portfolioFilter{
	width:600px;
	list-style:none;
	margin:20px 0 0 0;
	height:30px;
	padding-bottom:20px;
	border-bottom:1px solid <?php echo $LineColor; ?>;
}
.portfolioFilter li{ float:left; margin-right:10px;}
.portfolioFilter li a:link,
.portfolioFilter li a:visited{
	display:block;
	background-color:<?php echo $ColorFirst; ?>; 
	text-decoration:none;
	color:<?php echo $ColorSecond; ?>;
	font-family: <?php echo $HeaderFont; ?>;
	font-size:12px;
	line-height:30px;
	padding:0 15px;
}
.portfolioFilter li a:hover,
.portfolioFilter li a:active{
	box-shadow: -2px -2px rgba(0,0,0,.5) inset, 2px 2px rgba(0,0,0,.5) inset;
}

/*Columns*/
.c1,
.c1of2, .c1of2_end, 
.c1of3, .c1of3_end, .c2of3, .c2of3_end,
.c1of4, .c1of4_end, .c2of4, .c2of4_end, .c3of4,
.c3of4_end{float:left; margin-top:20px;}

.c1{clear:both; float:left; width:600px;}
.c1of2{float:left; width:280px; margin-right:40px;}
.c1of2_end{float:left; width:280px;}
.c1of3{float:left; width:173px; margin-right:40px;}
.c1of3_end{float:left; width:173px;}
.c2of3{float:left; width:386px; margin-right:40px;}
.c2of3_end{float:left; width:386px;}
.c1of4{float:left; width:120px; margin-right:40px;}
.c1of4_end{float:left; width:120px;}
.c2of4{float:left; width:280px; margin-right:40px;}
.c2of4_end{float:left; width:280px;}
.c3of4{float:left; width:440px; margin-right:40px;}
.c3of4_end{float:left; width:440px;}

/*STYLES*/
h1, h2, h3, h4, h5, h6{
	clear:both;
	font-family: <?php echo $HeaderFont; ?>;
	font-weight:normal;
	color: <?php echo $ColorFirst; ?>;
}
h1{font-size:<?php eopt('h1FontSize','24');?>px;}
h2{font-size:<?php eopt('h2FontSize','20');?>px;}
h3{font-size:<?php eopt('h3FontSize','18');?>px;}
h4{font-size:<?php eopt('h4FontSize','16');?>px;}
h5{font-size:<?php eopt('h5FontSize','14');?>px;}
h6{font-size:<?php eopt('h6FontSize','12');?>px;}

.divider{clear:both; height:20px;}
.vericaldivider{display:inline-block; width:20px; }
hr.seperator{clear:both; float:left; margin-top:20px; height:1px; background-color:<?php echo $LineColor; ?>; width:100%; }
hr.seperatorBold{clear:both; float:left; margin-top:20px; height:3px; background-color:<?php echo $ColorFirst; ?>; width:100%; }
.quotes-one{
	margin-left:20px;
	border-left:3px solid <?php echo $ColorFirst; ?>;
	padding-left:20px;
}
.quotes-two{
	padding-left:35px;
	background: url('<?php echo $imagesDir; ?>quote-bg.png') 0px 5px no-repeat;
}
.dropcap{
	text-align:center;
	display:block;
	float:left;
	font-weight:500;
	font-size:28px;
	line-height:40px;
	width:40px;
	font-family: <?php echo $HeaderFont; ?>;
	background-color: <?php echo $ColorFirst; ?>;
	color:<?php echo $ColorSecond; ?>;
	padding:0;
	margin:7px 5px 0 0;
}
.quotes-writer{color:#fff;}
.right{float:right; margin:5px 0 5px 15px;}
.left{float:left; margin:5px 15px 5px 0px;}
span.highlight{background-color:<?php echo $ColorFirst; ?>; color:<?php echo $ColorSecond; ?>; padding:0px 2px;}
span.textlight{color:<?php echo $ColorFirst; ?>;}
ul.list{list-style:none;}
ul.list li{padding: 3px 0 3px 20px;}
ul.check li{ background:url('<?php echo $imagesDir; ?>list-check.png') left 6px no-repeat;}
ul.cross li{ background:url('<?php echo $imagesDir; ?>list-cross.png') left 7px no-repeat;}
ul.arrow li{ background:url('<?php echo $imagesDir; ?>list-arrow.png') left 8px no-repeat;}
ul.circle li{ background:url('<?php echo $imagesDir; ?>list-circle.png') left 7px no-repeat;}

.infobox, .attentionbox, .downloadbox, .crossbox{
	padding:20px 20px 20px 75px;
	border:2px solid #333;
}
.infobox{
	border-color:#0066cc;
	color:#0066cc;
	background: url('<?php echo $imagesDir; ?>box-info.png') 20px 24px no-repeat;
}
.attentionbox{
	border-color:#ffcc00;
	color:#ffcc00;
	background: url('<?php echo $imagesDir; ?>box-attention.png') 20px 24px no-repeat;
}
.downloadbox{
	border-color:#009900;
	color:#009900;
	background: url('<?php echo $imagesDir; ?>box-download.png') 20px 24px no-repeat;
}
.crossbox{
	border-color:#ff0000;
	color:#ff0000;
	background: url('<?php echo $imagesDir; ?>box-cross.png') 20px 24px no-repeat;
}

.tipbox{
	position:absolute;
	color:#000;
	padding:10px 10px;
	background-color:#ffcc00;
	border-radius:6px;
}
.tipbox span{
	width:9px;
	height:5px;
	background:url('<?php echo $imagesDir; ?>tips-bottom.png') center center no-repeat;
	position:absolute;
	bottom:-5px;
	left:50%;
}

div.item_two_one{
	clear:both;
	float:left;
	width:80px;
	padding:12px 5px 12px 0;
	vertical-align:top;
	font-family: <?php echo $HeaderFont; ?>;
	font-size:16px;
}
div.item_two_two{
	float:left;
	width:170px;
	margin-left:10px;
	padding:15px 5px;
	border-bottom: 1px solid #333;
	vertical-align:top;
}

/*Buttons*/
.buttonSmall{
	display:inline-block;
	background: url('<?php echo $imagesDir; ?>button-white-left.png') left top no-repeat;
	height:26px;
	padding-left:5px;
}
.buttonSmall a{
	background: url('<?php echo $imagesDir; ?>button-white-center.png') left top repeat-x;
	float:left;
	font-size:12px;
	line-height:26px;
	padding:0 10px;
	text-decoration:none;
	font-family: <?php echo $HeaderFont; ?>;
	
	color:#ffffff;
}
.buttonSmall span{
	float:left;
	background: url('<?php echo $imagesDir; ?>button-white-right.png') left top no-repeat;
	height:26px;
	width:5px;
}

.smallBlack{background-image: url('<?php echo $imagesDir; ?>button-black-left.png'); }
.smallBlack a{background-image: url('<?php echo $imagesDir; ?>button-black-center.png'); }
.smallBlack span{background-image: url('<?php echo $imagesDir; ?>button-black-right.png'); }

.smallWhite{background-image: url('<?php echo $imagesDir; ?>button-white-left.png'); }
.smallWhite a{background-image: url('<?php echo $imagesDir; ?>button-white-center.png'); color:#333333;}
.smallWhite span{background-image: url('<?php echo $imagesDir; ?>button-white-right.png'); }

.smallRed{background-image: url('<?php echo $imagesDir; ?>button-red-left.png'); }
.smallRed a{background-image: url('<?php echo $imagesDir; ?>button-red-center.png'); }
.smallRed span{background-image: url('<?php echo $imagesDir; ?>button-red-right.png'); }

.smallGreen{background-image: url('<?php echo $imagesDir; ?>button-green-left.png'); }
.smallGreen a{background-image: url('<?php echo $imagesDir; ?>button-green-center.png'); }
.smallGreen span{background-image: url('<?php echo $imagesDir; ?>button-green-right.png'); }

.smallBlue{background-image: url('<?php echo $imagesDir; ?>button-blue-left.png'); }
.smallBlue a{background-image: url('<?php echo $imagesDir; ?>button-blue-center.png'); }
.smallBlue span{background-image: url('<?php echo $imagesDir; ?>button-blue-right.png'); }

.buttonMedium{
	display:inline-block;
	background: url('<?php echo $imagesDir; ?>buttonM-white-left.png') left top no-repeat;
	height:36px;
	padding-left:5px;
}
.buttonMedium a{
	background: url('<?php echo $imagesDir; ?>buttonM-white-center.png') left top repeat-x;
	float:left;
	font-size:16px;
	line-height:36px;
	padding:0 10px;
	text-decoration:none;
	font-family: <?php echo $HeaderFont; ?>;
	
	color:#ffffff;
}
.buttonMedium span{
	float:left;
	background: url('<?php echo $imagesDir; ?>buttonM-white-right.png') left top no-repeat;
	height:36px;
	width:5px;
}

.mediumBlack{background-image: url('<?php echo $imagesDir; ?>buttonM-black-left.png'); }
.mediumBlack a{background-image: url('<?php echo $imagesDir; ?>buttonM-black-center.png'); }
.mediumBlack span{background-image: url('<?php echo $imagesDir; ?>buttonM-black-right.png'); }

.mediumWhite{background-image: url('<?php echo $imagesDir; ?>buttonM-white-left.png'); }
.mediumWhite a{background-image: url('<?php echo $imagesDir; ?>buttonM-white-center.png'); color:#333333;}
.mediumWhite span{background-image: url('<?php echo $imagesDir; ?>buttonM-white-right.png'); }

.mediumRed{background-image: url('<?php echo $imagesDir; ?>buttonM-red-left.png'); }
.mediumRed a{background-image: url('<?php echo $imagesDir; ?>buttonM-red-center.png'); }
.mediumRed span{background-image: url('<?php echo $imagesDir; ?>buttonM-red-right.png'); }

.mediumGreen{background-image: url('<?php echo $imagesDir; ?>buttonM-green-left.png'); }
.mediumGreen a{background-image: url('<?php echo $imagesDir; ?>buttonM-green-center.png'); }
.mediumGreen span{background-image: url('<?php echo $imagesDir; ?>buttonM-green-right.png'); }

.mediumBlue{background-image: url('<?php echo $imagesDir; ?>buttonM-blue-left.png'); }
.mediumBlue a{background-image: url('<?php echo $imagesDir; ?>buttonM-blue-center.png'); }
.mediumBlue span{background-image: url('<?php echo $imagesDir; ?>buttonM-blue-right.png'); }

/*CONTACT FORM*/
.dform p{
	display:block;
	clear:both;
	padding:5px 5px 5px 0;
}

.dFormInput{
	float:left;
	width:157px;
	padding:5px;
	margin-left:10px;
	border-top: 1px double #080808;
	border-left: 1px double #080808;
	border-right: 1px double #161616;
	border-bottom: 1px double #161616;
	background:url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-comment-bg.png');
}
.dFormInputFocus{
	border:1px solid <?php echo $ColorFirst; ?>;
}
.dform label{
	padding-top:0px;
	float:left;
	display:inline-block;
	width:95px;
	text-decoration:none;
	font-family: <?php echo $HeaderFont; ?>;
	font-size:16px;
}
.dform input[type=text], .dform select, .dform textarea{
	background:none;
	width:100%;
}
.dform input[type=text]:focus, .dform select:focus, .dform textarea:focus{
}
.dform select{
}
.dform input[type=submit]{
	margin-left:10px;
}
.dform textarea{
	height:113px;
}
.dform label.error{
	clear:both;
	float:left;
	margin-left:95px;
	padding-left:10px;
	width:172px;
	color:<?php echo $ColorFirst; ?>;
	font-weight:normal;
	font-size:11px;
}
.form_message{
	display:none;
	padding:5px;
	background-color:<?php echo $ColorFirst; ?>;
	color:<?php echo $ColorSecond; ?>;
}
div.form_input{
	float:left;
}
.dform .submitButton{
	display:block;
	margin:10px 0 0 10px;
	color:<?php echo $ColorSecond; ?>;
	background-color:<?php echo $ColorFirst; ?>;
	line-height:14px;
	padding:10px 20px;
	text-decoration:none;
	font-family: <?php echo $HeaderFont; ?>;
	font-size:14px;
	text-transform:uppercase;
}
.dform .submitButton:hover{
	box-shadow: -2px -2px rgba(0,0,0,.5) inset, 2px 2px rgba(0,0,0,.5) inset;
}

/* Single Page **/
#singleRight{
	float:right;
	width:163px;
	padding-left:20px;
}
#singleLeft{
	float:left;
	margin-right:20px;
	width:394px;
}
#singleRight ul{
	padding-top:20px;
	list-style:none;
}
#singleRight ul li{
	padding-top:3px;
	height:33px;
	line-height:33px;
	margin-bottom:10px;
}
#singleRight ul li span{
	float:left;
	display:block;
	height:33px;
	line-height:33px;
}
#singleRight .singleAuthor,
#singleRight .singleComments,
#singleRight .singleTags{
	float:left;
	display:block;
	background-color:<?php echo $ColorFirst; ?>;
	width:33px;
	height:33px;
	margin-right:10px;
}
#singleRight .singleAuthor{background-image:url('<?php echo $imagesDir; ?>blogicon-author.png');}
#singleRight .singleComments{background-image:url('<?php echo $imagesDir; ?>blogicon-comment.png');}
#singleRight .singleTags{background-image:url('<?php echo $imagesDir; ?>blogicon-tag.png');}
#singleRight .singleDateBlock{
	height:33px;
	padding:10px 0;
	border-top:1px solid <?php echo $LineColor; ?>;
	border-bottom:1px solid <?php echo $LineColor; ?>;
}
#singleRight .singleDate{
	float:left;
	display:inline-block;
	line-height:33px;
	font-size:18px;
	color:<?php echo $ColorSecond; ?>;
	font-family:<?php echo $HeaderFont; ?>;
}
#thumbOpener{
	position:absolute;
	display:none;
	width:160px;
	height:15px;
	bottom:45px;
	left:20px;
	background-image:url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-thumbOpener.png');
}



/*DEMO CSS*/
#palette{
	display:none;
	position:absolute;
	right:20px;
	top:80px;
	background-color:#000000;
	border:1px solid #333333;
}
#paletteBody{
	width:186px;
	position:relative;
}
#colorPalette{
	margin-left:18px;
}
#colorPicker{
	position:absolute;
	left:92px;
	top:36px;
	width:10px;
	height:10px;
	border:1px solid #000000;
	border-radius:50%;
}
#paletteHeader{
	margin:1px;
	padding:3px;
	height:22px;
}
#colorResult{
	background-color:<?php echo $ColorFirst; ?>;
	float:left;
	color:#000000;
	padding:2px;
}
#paletteHeader .closeButton:link, #paletteHeader  .closeButton:visited,
#paletteHeader  .openButton:link, #paletteHeader  .openButton:visited
{
	display:block;
	float:right;
	width:20px;
	height:20px;
}
#paletteHeader  .closeButton:hover, #paletteHeader  .closeButton:active,
#paletteHeader  .openButton:hover, #paletteHeader  .openButton:active{
	background-position:0 -20px;
}
#paletteHeader  .closeButton:link, #paletteHeader  .closeButton:visited{background-image:url('<?php echo $imagesDir; ?>paletteClose.png');}
#paletteHeader  .openButton:link, #paletteHeader .openButton:visited{background-image:url('<?php echo $imagesDir; ?>paletteOpen.png');}
#paletteHeader .openButton:link, #paletteHeader  .openButton:visited{ display:none; }
#ThemeSwitch{
	height:40px;
	width:122px;
	margin:0 auto;
}
#ThemeSwitch .themeBtn:link, #ThemeSwitch .themeBtn:visited{
	float:left;
	display:block;
	padding:2px 10px;
	text-decoration:none;
	margin:5px;
	color:#dddddd;
}

#ThemeSwitch .selected:link, #ThemeSwitch .selected:visited,
#ThemeSwitch .selected:hover, #ThemeSwitch .selected:active {
	border-bottom:2px solid <?php echo $ColorFirst; ?>;
}



/*ADD WP*/
pre{
	 white-space: pre-wrap;       /* css-3 */
	white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
	white-space: -pre-wrap;      /* Opera 4-6 */
	white-space: -o-pre-wrap;    /* Opera 7 */
	overflow: auto;
	font-family: 'Consolas',monospace;
	font-size:13px;
	color: #333;
	line-height:18px;
	background: url("<?php echo $imagesDir; ?>pre-bg.png") repeat scroll left top #FFFFFF;
	border-left: 4px solid #888;
	padding:18px 5px 18px 10px;
	margin: 10px 0 10px 0;
}
div.sh_toggle{
	clear:both;
}
div.sh_toggle_text a{
	color:#fff;
	font-size: 10pt;
	
	text-decoration: none;
}
.sh_toggle_text{
	padding: 4px 4px 4px 20px;
	background:url('<?php echo $imagesDir; ?>toggle_arrow_closed.png') 0px 6px no-repeat;
	cursor:pointer;
}
.sh_toggle_text_opened{
	background:url('<?php echo $imagesDir; ?>toggle_arrow_opened.png') 0px 6px no-repeat;	
	cursor:pointer;
}
.sh_toggle_content{
	display:none;
}

.wp-pagenavi {
	margin-top:24px;
}
.wp-pagenavi .pages{
	background-color:<?php echo $ColorFirst; ?>;
	color:<?php echo $ColorSecond; ?>;
	padding:4px 8px;
	font-size:14px;
	font-family:<?php echo $HeaderFont; ?>;
	text-transform:uppercase;
}

.wp-pagenavi .current{
	margin-left:5px;
	background-color:<?php echo $ColorFirst; ?>;
	color:<?php echo $ColorSecond; ?>;
	padding:4px 8px;
	font-size:14px;
	font-family:<?php echo $HeaderFont; ?>;
	box-shadow: -2px -2px rgba(0,0,0,.5) inset, 2px 2px rgba(0,0,0,.5) inset;
}

.wp-pagenavi .page:link, 
.wp-pagenavi .page:visited, 
.wp-pagenavi .nextpostslink:link, 
.wp-pagenavi .nextpostslink:visited, 
.wp-pagenavi .previouspostslink:link,
.wp-pagenavi .previouspostslink:visited{
	margin-left:5px;
	background-color:<?php echo $ColorFirst; ?>;
	color:<?php echo $ColorSecond; ?>;
	padding:4px 8px;
	font-size:14px;
	font-family:<?php echo $HeaderFont; ?>;
	text-decoration:none;
}

.wp-pagenavi .page:hover, 
.wp-pagenavi .page:active, 
.wp-pagenavi .nextpostslink:hover, 
.wp-pagenavi .nextpostslink:active, 
.wp-pagenavi .previouspostslink:hover,
.wp-pagenavi .previouspostslink:active{
	box-shadow: -2px -2px rgba(0,0,0,.5) inset, 2px 2px rgba(0,0,0,.5) inset;
}



/* Comments CSS*/
#comments h4{
	padding-bottom:20px;
}
.comment-wrapper{
	background:url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-comment-bg.png');
	margin-bottom:20px;
}

#comments ul, #comments ol{
	list-style:none;
}

#comments ol li li{
	padding-left:100px;
	background: url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-comment-icon.png') 34px 34px no-repeat;
}

.comment-avatar{
	float:left;
	width:80px;
	height:80px;
	margin:10px;
}
.comment-text{
	padding-left:100px;
	padding-right:10px;
}
.comment-author{
	float:left;
	padding-top:10px;
	border-bottom:1px solid <?php echo $LineColor; ?>;
	padding-bottom:10px;
}
#comments li .comment-author{width:420px;}
#comments li li .comment-author{width:320px;}
#comments li li li .comment-author{width:220px;}
.author-link{
	font-size:12px;
	color:<?php echo $ColorFirst; ?>;
}
.author-date{
	font-sieze:12px;
	font-weight:italic;
}
.author-time{
	font-size:12px;
}
.comment-text p{
	float:left;
	padding: 5px 10px 10px 0;
}
.form-allowed-tags{
	display:none;
}

#comments .comment-reply-link{
	display:inline-block;
	float:left;
	margin-left:10px;
	margin-top:10px;
}
#comments .comment-reply-link:link,
#comments .comment-reply-link:visited{
	display:inline-block;
	float:right;
	font-size:11px;
	line-height:25px;
	height:25px;
	padding:1px 11px 0px 11px;
	text-transform:uppercase;
	background-color: <?php echo $ColorFirst; ?>;
	color: <?php echo $ColorSecond; ?>;
	font-family: <?php echo $HeaderFont; ?>;
	text-decoration:none;
}
@-moz-document url-prefix() {
	#comments .comment-reply-link a:link,
	#comments .comment-reply-link a:visited{
		padding:0px 11px 1px 11px;
  }
}
#comments .comment-reply-link:link,
#comments .comment-reply-link:visited{
	margin-right:0px;
	margin-bottom:10px;
}
#comments ol ul .comment-reply-link:link,
#comments ol ul .comment-reply-link:visited{
	margin-right:0px;
}
#comments .comment-reply-link:hover,
#comments .comment-reply-link:active{
	text-decoration:none;
	box-shadow: -2px -2px rgba(0,0,0,.5) inset, 2px 2px rgba(0,0,0,.5) inset;
}

/*Comment Form*/
#commentform{
}
.comment-notes, .logged-in-as{
	padding: 0 0 0 0; 
}
#commentform label{
	display:inline-block;
	width: 132px;
	font-size:14px;
	height:32px;
	vertical-align:top;
	font-family: <?php echo $HeaderFont; ?>;
	font-size:16px;
	text-transform:uppercase;
} 
#commentform .required{
	display:inline-block;
	width:15px;
	height:22px;
	color: #ff0000;
	vertical-align:top;
}
#commentform .comment-form-author label, 
#commentform .comment-form-email label{
	width:115px;
}
#commentform input[type=text], 
#commentform textarea{
	width: 250px;
	height: 22px;
	border-top: 1px double #000;
	border-left: 1px double #000;
	border-right: 1px double #333;
	border-bottom: 1px double #333;
	background:url('<?php echo $imagesDir; ?><?php echo $ThemePrefix; ?>-comment-bg.png');
	padding:5px;
}
#commentform input[type=text]:focus, 
#commentform textarea:focus{
	border:1px solid <?php echo $ColorFirst; ?>;
}
#commentform textarea{
	height:140px;
}
#commentform p{
	margin-top:20px;
	vertical-align:top;
}
#commentform input[type=submit]{
	cursor:pointer;
	margin-left:132px;
	display:inline-block;
	font-size:14px;
	line-height:35px;
	height:35px;
	padding:1px 11px 0px 11px;
	text-transform:uppercase;
	background-color: <?php echo $ColorFirst; ?>;
	color: <?php echo $ColorSecond; ?>;
	font-family: <?php echo $HeaderFont; ?>;
	text-transform:uppercase;
}
#commentform input[type=submit]:hover{
	box-shadow: -2px -2px rgba(0,0,0,.5) inset, 2px 2px rgba(0,0,0,.5) inset;
}
@-moz-document url-prefix() {
	#commentform input[type=submit]{
		padding:0px 11px 1px 11px;
  }
}