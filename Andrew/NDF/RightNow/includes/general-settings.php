<?php
add_action('admin_menu', 'add_control_panel'); 
function add_control_panel()
{
	add_menu_page('Right Now Panel', 'Right Now', 'manage_options', 'top-level-menu-action', 'rightnowsettings', '','64');
	add_action( 'admin_init', 'reg_settings' );  
}

$addScript = '';
function create_backgrounds_table(){
global $wpdb;
$prf = $wpdb->prefix;
$create_query = <<<EOT
CREATE TABLE `{$prf}backgrounds` (
  `IMAGEID` int(11) NOT NULL auto_increment,
  `GALLERYID` bigint(20) unsigned NOT NULL,
  `SLIDERORDER` int(11) unsigned NOT NULL,
  `EXT` varchar(255) default NULL,
  `CAPTION` text,
  `DESCRIPTION` mediumtext NOT NULL,
  `TYPE` varchar(20) default NULL,
  `CONTENT` text,
  `THUMB` text,
  `WIDTH` int(11) default NULL,
  `HEIGHT` int(11) default NULL,
  PRIMARY KEY  (`IMAGEID`),
  KEY `GALLERYID` (`GALLERYID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
EOT;
$create = $wpdb->get_results($create_query);
}

function create_galleries_table(){
global $wpdb;
$prf = $wpdb->prefix;
$create_query = <<<EOT
CREATE TABLE `{$prf}galleries` (
  `GALLERYID` int(10) unsigned NOT NULL auto_increment,
  `GALLERYNAME` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`GALLERYID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
EOT;
$create = $wpdb->get_results($create_query);
}

//Check Tables
if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}backgrounds'") != $wpdb->prefix.'backgrounds')
	create_backgrounds_table();
if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}galleries'") != $wpdb->prefix.'galleries')
	create_galleries_table();

function reg_settings()
{
	global $regSettings, $addScript;
	foreach($regSettings as $regKey => $regValue){
		register_setting( 'rightnowsettings', $regKey);
		if(get_option($regKey)=='' && !empty($regValue)){
			update_option($regKey, $regValue);
		}
	}
		
	// Define Google Web Fonts
	register_setting('rightnowsettings', 'fonts');
	if(get_option('fonts')=='' || isset($_GET['updatefonts']))
	{
		$googleFonts = @file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBgeqKlFdYj3Y7VwmrEXnXzpnx5TfKXG4o');
		if(empty($googleFonts))
		{
			include 'googleFontList.php';
			$googleFonts = $googleFontList;
		}else{
			if(get_option('fonts')!='')
				$addScript .= 'alert("Google Fonts has been updated");';
		}
		update_option('fonts', $googleFonts);
	}
}


function rightnowsettings()
{
wp_enqueue_media();
global $wpdb, $addScript;
$pURL = str_replace('http://'.$_SERVER['SERVER_NAME'],'',get_template_directory_uri());
$fonts = json_decode(get_option('fonts'));
?>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/ibutton/jquery.ibutton.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/ibutton/jquery.ibutton.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript">
	<?php echo $addScript; ?>
	<?php 
		global $regSettings;
		$settingsVar = "var settingsVar = new Array(";
		foreach($regSettings as $regKey => $regValue)
			$settingsVar .= "'".$regKey."', ";
		$settingsVar = substr($settingsVar,0,-2);
		$settingsVar.=");\n";
		echo $settingsVar;
	?>
	var $ = jQuery.noConflict();
	
	function getStyleOptions(){
		$('#rbcontent > div').slideUp('slow');
		var arr = new Array();
		$('#styleoptions input[type!=submit], #styleoptions select').each(function(){
			arr.push($(this).attr('name'));
		});
		getSettings(arr, $('#styleoptions'));
	}
	
	function getGeneralSettings(){
		$('#rbcontent > div').slideUp('slow');
		var arr = new Array();
		$('#generaloptions input[type!=submit], #generaloptions select').each(function(){
			arr.push($(this).attr('name'));
		});
		getSettings(arr, $('#generaloptions'));
	}
	
	function getTextOptions(){
		$('#rbcontent > div').slideUp('slow');
		var arr = new Array();
		$('#textoptions input[type!=submit], #textoptions select').each(function(){
			arr.push($(this).attr('name'));
		});
		getSettings(arr, $('#textoptions'));
	}
	
	function getGalleriesList(){
		$('#rbcontent > div').slideUp('slow');
		showMessage('waiting', 'Getting gallery list...', 'getgallery');
		$.post(ajaxurl, {'action':'get_gallery_list'}, function(data){
			$('#gallerieslistbody').html(data);
			$('#gallerieslist').slideDown('slow');
			showMessage('successful', 'Gallery list has been gotted successfully', 'getgallery');
		});	
	}
	

	function themeCheck(){
		$('#rbcontent > div').slideUp('slow');
		
		showMessage('waiting', 'Theme checking...', 'ctheme');
		$.post(ajaxurl, {'action':'check_theme'}, function(data){
			$('#checktheme').html(data);
			$('#checktheme').slideDown('slow');
			showMessage('successful', 'Theme has been checked successfully', 'ctheme');
		});	
	}
	
	function detailGallery(no, name){
		$('#rbcontent > div').slideUp('slow');
		$('#gallerydetailid').text(no);
		$('#gallerydetailname').text(name);
		$('#gallerieslistbody').html('');
		getSliderDetail(no);
		
		var bg_multi_image_uploader;
		$('#clickandload').unbind('click');
		$('#clickandload').click(function(e) {
			e.preventDefault();
	 
			if (bg_multi_image_uploader) {
				bg_multi_image_uploader.open();
				return;
			}
	 
			bg_multi_image_uploader = wp.media.frames.file_frame = wp.media({
				multiple: true,
				library: {
				  type: 'image'
				},
				title: 'Choose an Image',
				button: {
					text: 'Choose an Image'
				}
			});
	 
			bg_multi_image_uploader.on('select', function() {
				var selection = bg_multi_image_uploader.state().get('selection');
				var urls = new Array();
				selection.map( function( attachment ) {
				  attachment = attachment.toJSON();
				  urls.push(attachment.url);
				});
				if(urls.length>0){
					$.post(ajaxurl, {action:'insert_new_bg_item', urls:urls, GALLERYID:no},function(data){
						data = $.parseJSON(data);
						if(data.status=='OK')
							getSliderDetail(no);

			
							
						if(data.Err) alert(data.Err);
					});
				}
			});
			bg_multi_image_uploader.open();
	 
		});
		
		
		
		$('#gallerydetail').slideDown('slow');
	}
	
		
	
	function setFrontpageGallery(no){
		if(window.confirm('Are you sure set this item as Front Page Gallery?')){
			showMessage('waiting', 'Setting gallery as Front Page Gallery...', 'setfpgallery');
			$.post(ajaxurl, {'action':'setfp_gallery', 'GALLERYID':no}, function(data){
				data = $.parseJSON(data);
				if(data.status=='OK'){
					$('#gallerieslistbody .settedfp').remove();
					$('#glist_'+no+' td::nth-child(2)').append($(' <span class="settedfp">[Front Page]</span>'));
					showMessage('successful', 'Gallery has been setted as front page gallery successfully', 'setfpgallery');
				}else
					showMessage('error', 'Have got an error while setting gallery as front page gallery.', 'setfpgallery');
			});	
		}
	}
	
	function removeGallery(no){
		if(window.confirm('Are you sure delete?')){
			showMessage('waiting', 'Deleteting gallery...', 'delgallery');
			$.post(ajaxurl, {'action':'delete_gallery', 'GALLERYID':no}, function(data){
				data = $.parseJSON(data);
				if(data.status=='OK'){
					$('#glist_'+no).slideUp('slow', function(){
						$(this).remove();
					});
					showMessage('successful', 'Gallery has been deleted successfully', 'delgallery');
				}else
					showMessage('error', 'Have got an error while deleting gallery.', 'delgallery');
			});	
		}
	}
	
	function getAudioManager(){
		$('#rbcontent > div').slideUp('slow');
		showMessage('waiting', 'Getting audio list...', 'getaudio');
		$.post(ajaxurl, {'action':'get_audio_list'}, function(data){
			$('#audiomanager').slideDown('slow');
			$('#audiomanager form tbody').html(data);
			$('#audiomanagerbody').sortable({
				start:function(event, ui){
					ui.item.addClass('activeMove');
				},
				stop:function(event, ui){ 
					ui.item.removeClass('activeMove');
				},
				cancel: 'input, textarea'
			});
			showMessage('successful', 'Audio list has been getted successfully', 'getaudio');
		});
	}
	
	function removeAudioItem(obj){
		if(window.confirm('Are you sure delete?')){
			$(obj).closest('table').slideUp('slow', function(){
				$(this).closest('tr').remove();
			});
		}
	}
	
	jQuery(document).ready(function($){
		
		$('#rbmenu li a').click(function(){
			$(this).parent().parent().find('li').removeClass('selected');
			$(this).parent().addClass('selected');
		});
		
		$('#addAudioButton').click(function(){
			var emptyAudioItem = '<?php echo str_replace(array("\r\n", "\n", "\r"), '', createAudioItem('', '', '')); ?>';
			$('#audiomanager form > table > tbody').append($(emptyAudioItem));
		});
		
		$('#textoptions select[name=headerFont], #textoptions select[name=contentFont]').change(function(){
			loadFontVariants($(this).attr('name'), $(this).val()); 
		});  
		
		$('#addGallery').click(function(){
			var galleryName = window.prompt('Please enter a name', '');
			if(galleryName && $.trim(galleryName)!=''){
				showMessage('waiting', 'Creating a new gallery...', 'addgallery');
				$.post(ajaxurl, {'action':'add_new_gallery', 'name':$.trim(galleryName)}, function(data){
					data = $.parseJSON(data);
					if(data.status=='OK'){
						$('#gallerieslistbody').append($(data.html));
						showMessage('successful', 'New gallery has been created successfully', 'addgallery');
					}else
						showMessage('error', 'Have got an error while creation new gallery.', 'addgallery');
				});
			}
		});
		
		
		/* Gallery Detail*/
		$('#addBg ul li a').click(function(){
			$('#addBg ul li a').removeClass('selected');
			$(this).addClass('selected');
			if($(this).attr('rel')=='video')
			{
				$('#addBg .video').show();
				$('#addBg .image').hide();
			}else{
				$('#addBg .video').hide();
				$('#addBg .image').show();
			}
		});

				
		$('#sliderImageForm').submit(function(){
			showMessage('waiting', 'Slider items are saving...', 'slideritemssave');
			var serialdata = $(this).serialize();
			serialdata+='&action=save_slider_items';
			$.ajax({
			   type: "POST",
			   url: ajaxurl,
			   data: serialdata,
			   success: function(msg){
				 showMessage('successful', 'Slider items has been saved successfuly.', 'slideritemssave');
				}
			});
			return false;
		});
		
		$('#addBg .video select').change(function(){
			var videoType = $('#addBg .video select option:selected').val();
			$('#addBg .video .videotype').hide();
			if(videoType=='youtube' || videoType=='vimeo')
				$('#addBg .video .videoid').show();
			else if(videoType=='selfhosted')
				$('#addBg .video .videourl').show();
			else if(videoType=='flash')
				$('#addBg .video .videourl').show();
			
			if(videoType=='youtube' || videoType=='vimeo' || videoType=='selfhosted' || videoType=='flash')
				$('#addBg .video .videowh').show();
		});
		
		$('#addVideo').click(function(){
			var videoType = $('#addBg .video select option:selected').val();
			var videoData = '';
			if(videoType=='youtube' || videoType=='vimeo')
				videoData = $('#addBg .video .videoid input').val();
			else if(videoType=='selfhosted' || videoType=='flash')
				videoData = $('#addBg .video .videourl input').val();
			
			var vW = $('#addBg .video .videowh input[name=width]').val();
			var vH = $('#addBg .video .videowh input[name=height]').val();
			
			if(videoType=='youtube' || videoType=='vimeo' || videoType=='selfhosted' || videoType=='flash')
			{
				if(videoData=='' || vW=='' || vH=='' ){
					alert('You must fill all field');
					return;
				}
			}
			
			showMessage('waiting', 'Adding your video item...', 'additem');
			$.post(ajaxurl, {action:'add_video_item', type:videoType, data:videoData, width:vW, height:vH, GALLERYID:$('#gallerydetailid').text()},function(data){
				data = $.parseJSON(data);
				if(data.status=='OK')
				{
					getSliderDetail(data.GALLERYID);
					showMessage('successful', 'New video item has been added successfully.', 'additem');
				}
				else
					showMessage('error', 'Have been an error while adding video item.', 'additem');
			});
			
		});
		
		
		$('#themeCheckBtn').trigger('click');
	});
	

	jQuery(document).ready(function($){
	
		locateMsg();
		$(window).bind('resize', function() {
					locateMsg();
				});
		$(window).bind('scroll', function() {
					locateMsg();
				});
	
		$('.colorSelector').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).find('input').val(hex);
				$(el).find('div').css('backgroundColor', '#'+hex);
				$(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor($(this).find('input').val());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		
		$('.colorSelectorControl').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).find('input').val(hex);
				$(el).find('div').css('backgroundColor', '#'+hex);
				$(el).ColorPickerHide();
				setBg($(el).parent().parent());
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor($(this).find('input').val());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		
	});
	
	function locateMsg()
	{					
		var top = $(window).height()+$(window).scrollTop()-100;
		$('#messageArea').css('top', top+'px');
	}
		
	function showMessage(type, message, id)
	{
		if(type=='waiting')
		{
			$('#messageArea').append('<div class="waiting" id="waiting_'+id+'">'+message+'</div>').find('#waiting_'+id).slideDown('slow');
		}
		else if(type=='successful')
		{
			$('#waiting_'+id).slideUp('slow', function(){$(this).remove()});
			$('#messageArea').append('<div class="successful" id="successful_'+id+'">'+message+'</div>').find('#successful_'+id).slideDown('slow').delay(3000).slideUp('slow',function(){$(this).remove();});
		}
		else if(type=='error')
		{
			$('#waiting_'+id).slideUp('slow', function(){$(this).remove()});
			$('#messageArea').append('<div class="error2" id="error_'+id+'">'+message+'</div>').find('#error_'+id).slideDown('slow').delay(3000).slideUp('slow',function(){$(this).remove();});
		}
	}
	
	function saveAudio(){
		var settingsData = $('#audiomanager form').serialize();
		settingsData+="&action=save_audio_list";
		
		
		showMessage('waiting', 'Saving audio list...', 'saveaudio');
		$.post(ajaxurl, settingsData, function(data){
			showMessage('successful', 'Audio list has been saved successfully', 'saveaudio');
		});
		return false;
	}
	
	
	
	function saveSettings(objName)
	{
		if(!window.confirm('Are you sure to apply. If you continue all current settings will be change.'))
			return false;
		
		var varList ='';
		$(objName+' input[type!=submit], '+objName+' select').each(function(){
			varList += '&vars[]='+$(this).attr('name');
		});
		
		settingsData = '';
		$.each(settingsVar,function(i,el){
			if($(objName+' input[name='+el+']').length==1)
				if($(objName+' input[name='+el+']').is(':checkbox'))
				{
					if($(objName+' input[name='+el+']').is(':checked'))
						settingsData+='&'+el+'='+$(objName+' input[name='+el+']').first().val();
				}
				else
					settingsData+='&'+el+'='+$(objName+' input[name='+el+']').val();
			else if($(objName+' select[name='+el+']').length==1)
				settingsData+='&'+el+'='+$(objName+' select[name='+el+']').val();		
		});
		settingsData += varList;
		settingsData+="&action=General_save";
			
		showMessage('waiting', 'Saving general settings...', 'Generalsave');
		$.post(ajaxurl, settingsData, function(data){

		data = $.parseJSON(data);
		if(data.status=='OK')
		{			
			showMessage('successful', 'General settings has been updated successfully', 'Generalsave');
		}
		else
			showMessage('error', 'Have got an error while saving settings.', 'Generalsave');
			
		});
		return false;
	}
	
	function getSettings(varList, openElement)
	{
		showMessage('waiting', 'Getting current settings...', 'get_general');
		$.post(ajaxurl, {'action':'get_general','vars':varList}, function(data){
			data = $.parseJSON(data);
			showMessage('successful', 'Current settings has been gotten successfully', 'get_general');	
			setForm(data);
			if($(openElement).is(':hidden'))
				$(openElement).slideDown('slow');
		});
	}
	
	function getSliderDetail(no)
	{
		showMessage('waiting', 'Backgrounds are getting...', 'slider_details');
		$.post(ajaxurl, {action:'list_slider_items', GALLERYID:no},function(data){
			showMessage('successful', 'Backgrounds has been getted successfully.', 'slider_details');
			$('#sliderImageItems tbody').html(data);
			$( "#sliderImageItems tbody").sortable({
				start:function(event, ui){
					ui.item.addClass('activeMove');
				},
				stop:function(event, ui){
					ui.item.removeClass('activeMove');
				},
				cancel: 'input, textarea, object, embed'
			});
			$( "#sliderImageItems input, #sliderImageItems textarea, #sliderImageItems object, #sliderImageItems embed" ).bind('click.sortable mousedown.sortable',function(ev){
				ev.target.focus();
			});
		});
	}
	
	function imageDelete(imgID, imgName)
	{
		if(window.confirm('Are you sure to delete this image?'))
		{
			showMessage('waiting', 'Deleting image...', 'delete_image');
			$.post(ajaxurl, {'action':'delete_image', 'imgID':imgID, 'imgName':imgName}, function(data){
				data = $.parseJSON(data);
				if(data.status=='OK')
				{
					showMessage('successful', 'Settings has been deleted successfully', 'delete_image');	
					$('#imgs'+data.imgID).remove();
				}else
					showMessage('error', 'Have got an error while deleting image.'+data.ERR, 'delete_image');
			});
		}
	}
	
	function loadFontVariants(area, font)
	{
		if(font!=undefined){
		$.ajax({ url:ajaxurl,
				 async: false,
				 data: {'action':'load_font_variants', 'font':font },
				 dataType:'text',
				 type: "POST",
				 success:function(data){
					data = $.parseJSON(data); 
					if(data.status=='OK' && data.variants!=null)
					{
						$('#rbcontent select[name="'+area+'Variant"] option').remove();
						for(i=0; i<data.variants.length; i++)
							$('#rbcontent select[name="'+area+'Variant"]').append($('<option></option>').text(data.variants[i]).attr('value', data.variants[i]));
					}else
						showMessage('error', 'Have got an error while getting font variant', 'get_variant');
					}
			});
		}
	}
	
	function setForm(data)
	{
		$('#rbcontent input[type=text]').val('');
		$('#rbcontent select').selectedIndex = -1;
		$('#rbcontent .colorSelectorControl div').css("backgroundColor",'#FFFFFF');
		
		loadFontVariants('headerFont', data.headerFont);
		loadFontVariants('contentFont', data.contentFont);
		
			$.each(data, function(name,i){
				if($('#rbcontent input:checkbox[name='+name+']').length==1){
					if($('#rbcontent input:checkbox[name='+name+']').val()==data[name])
					{
						$('#rbcontent input:checkbox[name='+name+']').attr('checked','checked');
					}else{
						$('#rbcontent input:checkbox[name='+name+']').removeAttr('checked');
					}
				}else{
					$('#rbcontent input[name='+name+']').val(data[name]);
					$('#rbcontent select[name='+name+']').attr('selectedIndex', -1).find('option[value="'+data[name]+'"]').attr('selected','selected');
					$('#rbcontent input[name='+name+'][name*="color"]').parent().find("div").css('backgroundColor', '#'+data[name]);
				}
			});
		
		$(":checkbox").iButton("repaint");
	}
	
	
	
	var urlObj; 
	var activeLink;
	function getUrlFromFile(el) 
	{
		var file_manager;
		if (file_manager) {
			file_manager.open();
			return;
		}
 
		file_manager = wp.media.frames.file_frame = wp.media({
			multiple: false,
			library: {
			  type: 'image'
			},
			title: 'Choose an Image',
			button: {
				text: 'Choose an Image'
			}
		});
 
		file_manager.on('select', function() {
			attachment = file_manager.state().get('selection').first().toJSON();
			$(el).parent().find('input').val(attachment.url);
		});
		file_manager.open();
	}
	
	function deleteItemImage(me)
	{
		if(window.confirm('Are you sure to delete this image?'))
		{
			var imgID = $(me).parent().parent().parent().find("input[name='imageID[]']").val();
			if(imgID!=undefined){
				showMessage('waiting', 'Image is deleting...', 'delete_image'+imgID);
				$.post(ajaxurl, {action:"remove_item_image", IMAGEID:imgID}, function(data){
					var jdata = $.parseJSON(data);
					if(jdata.status=='OK')
					{
						showMessage('successful', 'Image has been deleted successfully.', 'delete_image'+jdata.IMAGEID);
						$("#sliderImageItems input[name='imageID[]'][value='"+jdata.IMAGEID+"']").parent().parent().remove();
					}
					else
					{
						showMessage('error', 'Image coudn\'t be deleted.', 'delete_image'+jdata.IMAGEID);
					}
				});
			}
		}
	}
	
	function changeDimension(me, type)
	{
		var imgID = $(me).parent().parent().parent().find("input[name='imageID[]']").val();
		var dimValue = $(me).text();
		var newValue = window.prompt('Please enter a new value', dimValue);
		if(newValue!=false && dimValue!=newValue)
		{
			$('#imageID'+imgID+' .video'+type+' a').text(newValue);
			showMessage('waiting', 'Dimension of Video is deleting...', 'dim_video'+imgID);
			$.post(ajaxurl, {action:"change_video_dimension", IMAGEID:imgID, dimType:type, value:newValue}, function(data){
				var jdata = $.parseJSON(data);
				if(jdata.status=='OK')
				{
					showMessage('successful', 'Dimension of Video has been updated successfully.', 'dim_video'+jdata.IMAGEID);
					$('#imageID'+jdata.IMAGEID+' .video'+jdata.dimType+' a').text(jdata.value);
				}
				else
				{
					showMessage('error', 'Dimension of Video coudn\'t be updated.', 'dim_video'+jdata.IMAGEID);
				}
			});
		}
	}
	
	function thumUploader(me){
		var imgID = $(me).parent().parent().parent().find("input[name='imageID[]']").val();
		$('.thumbUplodifyWrap').remove();
		if($('#imageID'+imgID+' td:nth-child(2) .thumbUplodifyWrap').length==0)
		{
			var bg_thumb_uploader;
			if (bg_thumb_uploader) {
				bg_thumb_uploader.open();
				return;
			}
	 
			bg_thumb_uploader = wp.media.frames.file_frame = wp.media({
				multiple: false,
				library: {
				  type: 'image'
				},
				title: 'Choose a Thumbnail',
				button: {
					text: 'Choose an Image'
				}
			});
	 
			bg_thumb_uploader.on('select', function() {
				attachment = bg_thumb_uploader.state().get('selection').first().toJSON();
				
				$.post(ajaxurl, {action:'change_thumb_of_item', url:attachment.url, imageid:imgID },function(data){
					data = $.parseJSON(data);
					if(data.status=='OK')
					{
						if(data.status=='OK')
						$('#imageID'+imgID+' td:nth-child(1) .sliderImageItemImage img').attr('src', data.thumbpath);
					}
						
					if(data.Err) alert(data.Err);
				});
				
			});
			bg_thumb_uploader.open();
		}
	}
	
</script>
<style>
#messageArea { position:absolute; left:0px; top:0px; width:800px; z-index:999;}
#messageArea .waiting{padding:5px 5px 5px 25px; background:url('<?php echo get_template_directory_uri(); ?>/images/admin-loading.gif') #FF7300 5px center no-repeat; color:#FFFFFF; display:none;}
#messageArea .successful{padding:5px; background-color:#10CD02; color:#FFFFFF; display:none;}
#messageArea .error2{padding:5px; background-color:#FF0000; color:#FFFFFF; display:none;}

.widefat td{
	padding:8px;
}

#imageManager{
	display:none;
	opacity:0;
	position: absolute;
	left: 830px;
	top:20px;
	z-index:998;
}

.trueHeader{
	background: url('../images/gray-grad.png') repeat-x scroll left top #DFDFDF;	
	-moz-border-radius-topleft:3px;
	-moz-border-radius-topright:3px;
	padding:10px;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
	border:1px solid #DFDFDF;
}
.trueWrapper{
	background-color:#FFFFFF;
	-moz-border-radius-topleft:3px;
	-moz-border-radius-topright:3px;
	-moz-border-radius-bottomleft:3px;
	-moz-border-radius-bottomright:3px;
	border:1px solid #DFDFDF;
}
.colorSelectorWrapper{
	height:35px;
}
.colorSelector, .colorSelectorControl {
	width: 36px;
	height: 36px;
	float:left;
}
.colorSelector div, .colorSelectorControl div{
	top: 4px;
	left: 4px;
	width: 28px;
	height: 28px;
	background: url(<?php echo get_template_directory_uri(); ?>/includes/colorpicker/images/select2.png) center;
}
.color{
	display:none;
	margin-left:40px;
}
.bgcontrol > div {
	clear:both;
}
.bgcontrol select{
	width:100px;
}
.bgcontrol label{
	float:left;
	width:80px;
}

.gl{
	border:3px solid #ddd;
	padding:2px;
	text-align:center;
	margin:2px auto;
}
.gl_active
{
	border-color:#bbb; 
}
.da{
	width:200px;
}
.glcontrol{
	border: 2px solid #ddd;
	background-color: #eee;
	position:absolute;
	padding:5px;
} 
.glcontrol h5{
	margin:0;
}

.subText{
	float:left;
	margin-right:5px;
	width:50px;
}
#settingShow{
	display:none;
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
	.colorpicker{
		z-index:99;
	}
	.settedfp{
		font-weight:bold;
		color:red;
	}
	
	
	#rbwrap{width:800px; margin-top:20px;}
	#rbheader{height:46px;}
	.rbheaderbordertop{height:3px; background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/header-bg1.png');}
	.rbheaderborderbottom{height:3px; background-color:#2c2c2c;}
	#rbheadermenu{height:40px; background-color:#333;}
	#rbmenu{background-color:#2c2c2c; width:170px; float:left;}
	#rbheadermenuleft{
		float:left;
		width:250px;
	}
	#rbheadermenuright{
		text-align:right;
		float:right;
		width:500px;
	}
	#rbbody{background-color:#eeeeee;}
	#rbcontent{background-color:#eeeeee; width:630px; float:left;}
	
	
	#rbmenu ul{list-style:none; margin:0;}
	#rbmenu ul li{
		width:164px; 
		height:40px; 
		margin:0 3px;
		background-color:#333333;
		margin-bottom:3px;
	}
	#rbmenu ul li a:link,
	#rbmenu ul li a:visited{
		-moz-transition: all 0.5s ease-in-out 0s;
		transition: all 0.5s ease-in-out;
		-webkit-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		
		display:block;
		height:40px;
		font-size:11px; 
		font-family: 'Open Sans', sans-serif; 
		font-weight:800;
		text-decoration:none;
		box-shadow: 1px 1px rgba(255,255,255,.1) inset, -1px -1px rgba(0,0,0,.3) inset;
		
		background: -moz-linear-gradient(top,  rgba(255,255,255,0.07) 0%, rgba(255,255,255,0) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0.07)), color-stop(100%,rgba(255,255,255,0))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  rgba(255,255,255,0.07) 0%,rgba(255,255,255,0) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  rgba(255,255,255,0.07) 0%,rgba(255,255,255,0) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  rgba(255,255,255,0.07) 0%,rgba(255,255,255,0) 100%); /* IE10+ */
		background: linear-gradient(top,  rgba(255,255,255,0.07) 0%,rgba(255,255,255,0) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#12ffffff', endColorstr='#00ffffff',GradientType=0 ); /* IE6-9 */

	}
	#rbmenu ul li a:hover,
	#rbmenu ul li a:active{		
		background: -moz-linear-gradient(top,  rgba(255,255,255,0) 0%, rgba(255,255,255,0.07) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(100%,rgba(255,255,255,0.07))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.07) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.07) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.07) 100%); /* IE10+ */
		background: linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.07) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#12ffffff',GradientType=0 ); /* IE6-9 */
	}
	#rbmenu ul li a:hover span,
	#rbmenu ul li a:active span{	
		background-position:0 -40px;
	}
	#rbmenu ul li a:hover div,
	#rbmenu ul li a:active div{
		color:#bbbbbb;
	}
	#rbmenu .styleoptions span{
		background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_picker.png');
		background-repeat:repeat-y;
		background-position: 0px 0px;
	}
	#rbmenu .generalsettings span{
		background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_generalsettings.png');
		background-repeat:repeat-y;
		background-position: 0px 0px;
	}
	#rbmenu .textoptions span{
		background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_textoptions.png');
		background-repeat:repeat-y;
		background-position: 0px 0px;
	}
	#rbmenu .gallerymanager span{
		background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_gallerymanager.png');
		background-repeat:repeat-y;
		background-position: 0px 0px;
	}
	#rbmenu .audiomanager span{
		background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_audiomanager.png');
		background-repeat:repeat-y;
		background-position: 0px 0px;
	}
	#rbmenu .themecheck span{
		background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_themecheck.png');
		background-repeat:repeat-y;
		background-position: 0px 0px;
	}
	#rbmenu .help span{
		background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_help.png');
		background-repeat:repeat-y;
		background-position: 0px 0px;
	}
	#rbmenu ul li a div{
		-moz-transition: all 0.5s ease-in-out 0s;
		transition: all 0.5s ease-in-out;
		-webkit-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		
		vertical-align:top;
		display:inline-block;
		height:40px;
		color:#6e6e6e;
		line-height:40px;
	}
	#rbmenu ul li a span{
		-moz-transition: all 0.5s ease-in-out 0s;
		transition: all 0.5s ease-in-out;
		-webkit-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		
		display:inline-block;
		width:40px;
		height:40px;
	}
	
	#rbmenu ul li.selected{
		width:167px; 
		height:40px; 
		margin:0 0 3px 3px;
		background-color:#eeeeee;
	}
	#rbmenu ul li.selected a:link,
	#rbmenu ul li.selected a:visited,
	#rbmenu ul li.selected a:hover,
	#rbmenu ul li.selected a:active{
		cursor:default;
		color:6e6e6e;
		background:none;
		box-shadow:none;
		box-shadow: 1px 1px rgba(255,255,255,1) inset;
	}
	#rbmenu ul li.selected a:link span,
	#rbmenu ul li.selected a:visited span,
	#rbmenu ul li.selected a:hover span,
	#rbmenu ul li.selected a:active span{
		background-position:0 0;
	}
	#rbmenu ul li.selected a:link div,
	#rbmenu ul li.selected a:visited div,
	#rbmenu ul li.selected a:hover div,
	#rbmenu ul li.selected a:active div{
		color:#6e6e6e;
	}
	
	#rbheadermenuleft a:link,
	#rbheadermenuleft a:visited{
		display:inline-block;
		height:40px;
		line-height:40px;
		padding:0 15px;
		font-size:14px; 
		font-family: 'Open Sans', sans-serif; 
		font-weight:800;
		color:#ffffff;
		background-color:#3d3d3d;
		text-decoration:none;
	}
	#rbheadermenuleft a:hover,
	#rbheadermenuleft a:active{
		color:#ffffcc;
	}
	#rbheadermenuright a:link,
	#rbheadermenuright a:visited{
		text-align:left;
		display:inline-block;
		height:33px;
		line-height:1.2em;
		padding:7px 13px 0px 46px;
		font-size:10px; 
		font-family: Tahoma;
		color:#ffffff;
		background-color:#3d3d3d;
		text-decoration:none;
		margin-left:1px;
		background-position:6px 7px;
		background-repeat:no-repeat;
	}
	#rbheadermenuright a:hover,
	#rbheadermenuright a:active{
		color:#ffffcc;
	}
	
	
	
	.statusIcon{
		width:15px;
		height:15px;
		margin:2px auto 0 auto;
	}
	.statusOK{	background:url("<?php echo get_template_directory_uri(); ?>/images/list-check.png") no-repeat; }
	.statusNOK{	background:url("<?php echo get_template_directory_uri(); ?>/images/list-cross.png") no-repeat; }

	.ErrInfo, .attentionbox, .downloadbox, .ErrMessage{
		padding:20px 20px 20px 75px;
		border:2px solid #333;
		margin:10px;
	}
	.ErrInfo{
		border-color:#0066cc;
		color:#0066cc;
		background: url('<?php echo get_template_directory_uri(); ?>/images/box-info.png') 20px center no-repeat;
	}
	.attentionbox{
		border-color:#ffcc00;
		color:#ffcc00;
		background: url('<?php echo get_template_directory_uri(); ?>/images/box-attention.png') 20px center no-repeat;
	}
	.downloadbox{
		border-color:#009900;
		color:#009900;
		background: url('<?php echo get_template_directory_uri(); ?>/images/box-download.png') 20px center no-repeat;
	}
	.ErrMessage{
		border-color:#ff0000;
		color:#ff0000;
		background: url('<?php echo get_template_directory_uri(); ?>/images/box-cross.png') 20px center no-repeat;
	}
	.statusWait{ display:none; }
	
	
	
	/* Gallery Detail*/
	#addBg{ width:590px; margin:20px;}
	#addBg ul{list-style:none;}
	#addBg ul li{
		float:left;
		margin:0 5px 0 0;
	}
	#addBg ul li a:link,
	#addBg ul li a:visited{
		display:block;
		padding:6px 12px;
		color:#333333;
		background-color: #F1F1F1;
		background-image:-moz-linear-gradient(center top , #F9F9F9, #dddddd);
		font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
		text-decoration:none;
		border-radius:6px 6px 0px 0px;
		text-shadow:0 1px 0 rgba(255, 255, 255, 0.8);
	}
	#addBg ul li a:hover,
	#addBg ul li a:active{
		color:#333333;
		background-image:-moz-linear-gradient(center top , #dddddd, #F9F9F9);
	}
	#addBg ul li a.selected:link,
	#addBg ul li a.selected:visited,
	#addBg ul li a.selected:hover,
	#addBg ul li a.selected:active
	{
		color:#F1F1F1;
		background-color: #333333;
		background-image: none;
		text-shadow:0 1px 0 rgba(0, 0, 0, 0.8);
	}
	
	.sliderItem{padding:3px; background-color:#EEEEEE; margin-bottom:3px}
	.sliderImageItemImage{}
	.sliderImageItem, .sliderImageItem td{cursor:move;}
	.sliderImageItem{
		background: url('<?php echo get_template_directory_uri(); ?>/images/lined.png') repeat;
	}
	.activeMove{
		background-color:#FEFFE2;
	}
	#sliderOptions form input[type="text"], #sliderOptions form select{
		width:150px;
	}
	#sliderOptions form input[type="text"]{
		text-align:right;
	}
	.video{
		display:none;
		clear:both;
		border:1px solid #dddddd;
		padding:10px;
		margin-bottom:10px;
		background-color:#f9f9f9;
		border-radius:0 3px 3px 3px;
	}
	.image{
		clear:both;
		border:1px solid #dddddd;
		padding:10px;
		margin-bottom:10px;
		background-color:#f9f9f9;
		border-radius:0 3px 3px 3px;
	}
	</style>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,800' rel='stylesheet' type='text/css'>
	
	<div id="messageArea"></div> 
	
	<div id="rbwrap">
		<div id="rbheader">
			<div class="rbheaderbordertop"></div>
			<div id="rbheadermenu">
				<div id="rbheadermenuleft"><a href="http://themeforest.net/user/RenkliBeyaz/portfolio" target="_blank">RENKLIBEYAZ'S THEMES</a></div>
				<div id="rbheadermenuright">
					<a href="http://themeforest.net/user/renklibeyaz/follow" target="_blank" style="background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_star.png');">Follow us on<br />Themeforest</a>
					<a href="http://renklibeyaz.com/forum/purchisecode.html" target="_blank" style="background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_lock.png');">Forum<br />Register Code</a>
					<a href="http://renklibeyaz.com/forum/" target="_blank" style="background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_forum.png');">Support<br />Forum</a>
					<a href="http://twitter.com/renklibeyaz" target="_blank" style="background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_tw.png');">Follow us on<br />Twitter</a>
				</div>
			</div>
			<div class="rbheaderborderbottom"></div>
		</div>
		<div id="rbbody"> 
			<div id="rbmenu">
				<ul> 
					<li><a class="generalsettings" href="javascript:void(0);" onclick="getGeneralSettings();"><span></span><div>GENERAL SETTINGS</div></a></li>
					<li><a class="styleoptions" href="javascript:void(0);" onclick="getStyleOptions();"><span></span><div>STYLE OPTIONS</div></a></li> 
					<li><a class="textoptions" href="javascript:void(0);" onclick="getTextOptions();"><span></span><div>TEXT OPTIONS</div></a></li>
					<li><a class="gallerymanager" href="javascript:void(0);" onclick="getGalleriesList();"><span></span><div>GALLERY MANAGER</div></a></li>
					<li><a class="audiomanager" href="javascript:void(0);" onclick="getAudioManager();"><span></span><div>AUDIO MANAGER</div></a></li>
					<li><a class="themecheck" href="javascript:void(0);" id="themeCheckBtn" onclick="themeCheck();"><span></span><div>THEME CHECK</div></a></li>
					<li><a class="help" href="javascript:void(0);" id="themeCheckBtn" onclick="themeCheck();"><span></span><div>HELP</div></a></li>
				</ul>
			</div>
			<div id="rbcontent">
			<!-- ******************************   CONTENT START   ****************************** -->
			
			
			
			
			
			
			
			
			
			<!-- ****   GENERAL OPTIONS START   **** -->
			<div id="generaloptions" style="display:none">
			<form method="post" action="#" onsubmit="return saveSettings('#generaloptions');"> 
			<table cellpadding="0" style="width:590px; margin:20px;" class="widefat">
				<thead>
					<tr>
						<th>Option</th>
						<th>Value</th>
					</tr>
				</thead>                
				<tbody>
					<tr class="gs">
						<td align="left">
	                        <input type="submit" id="apply" class="button" value="Apply Settings" />
                        </td>
						<td align="right"></td>
					</tr>
					<tr class="gs">
						<td>Video Loop</td>
						<td>
							<input type="checkbox" name="videoLoop" value="true" id="videoLoop" />
						</td>
					</tr>
					<tr class="gs">
						<td>Video Mute</td>
						<td>
							<input type="checkbox" name="videoMuted" value="true" id="videoMuted" />
						</td>
					</tr>
					<tr class="gs">
						<td>Mute the Sound When Bg Vide Plays</td>
						<td>
							<input type="checkbox" name="muteWhilePlayVideo" value="true" id="muteWhilePlayVideo" />
						</td>
					</tr>
					<tr class="gs">
						<td>Normal Fade Animation</td>
						<td>
							<input type="checkbox" name="bgNormalFade" value="true" id="bgNormalFade" />
						</td>
					</tr>
					<tr class="gs">
						<td>Audio AutoPlay</td>
						<td>
							<input type="checkbox" name="autoPlay" value="true" id="autoPlay" />
						</td>
					</tr>
					<tr class="gs">
						<td>Audio Loop</td>
						<td>
							<input type="checkbox" name="loop" value="true" id="loop" />
						</td>
					</tr>
					<tr class="gs">
						<td>Videos doesn't start auto</td>
						<td>
							<input type="checkbox" name="videoPaused" value="true" id="videoPaused" />
						</td>
					</tr>
					<tr class="gs">
						<td>Stretch Background Image and Videos</td>
						<td>
							<input type="checkbox" name="bgStretch" value="true" id="bgStretch" />
						</td>
					</tr>
					
					<tr class="gs">
						<td>Background Animation Duration</td>
						<td>
							<input type="text" name="bgAniTime" value="" id="bgAniTime" /> ms
						</td>
					</tr>
					<tr class="gs">
						<td>Menu Delay</td>
						<td>
							<input type="text" name="menuDelay" value="" id="menuDelay" /> ms
						</td>
					</tr>
					
					<tr class="gs">
						<td>Front Page URL</td>
						<td>
							<input type="text" name="frontPageURL" value="" style="width:300px;"/>
						</td>
					</tr>
					<tr class="gs">
						<td>Link Hover Sound Mp3</td>
						<td>
							<input type="text" name="btnSoundURLMp3" value="" style="width:300px;"/>
						</td>
					</tr>
					<tr class="gs">
						<td>Link Hover Sound Ogg</td>
						<td>
							<input type="text" name="btnSoundURLOgg" value="" style="width:300px;"/>
						</td>
					</tr>
					<tr class="gs">
						<td>Copyright Text</td>
						<td>
							<input type="text" name="copyrighttext" value="" style="width:300px;" />
						</td>
					</tr>
					<tr class="gs">
						<td>Google Analytics Code</td>
						<td>
							<input type="text" name="analyticsCode" value="" style="width:300px;" />
						</td>
					</tr>
					<tr class="gs">
						<td align="left">
	                        <input type="submit" id="apply2" class="button" value="Apply Settings" />
                        </td>
						<td align="right"></td>
					</tr>
				</tbody>
			</table>
			</form>
			</div>
			<!-- ****   GENERAL OPTIONS END   **** -->
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<!-- ****   STYLE OPTIONS START   **** -->
			<div id="styleoptions" style="display:none">
			<form method="post" action="#" onsubmit="return saveSettings('#styleoptions')"> 
			<table cellpadding="0" style="width:590px; margin:20px;" class="widefat">
				<thead>
					<tr>
						<th>Option</th>
						<th>Value</th>
					</tr>
				</thead>                
				<tbody>
					<tr class="gs">
						<td align="left">
	                        <input type="submit" id="apply" class="button" value="Apply Settings" />
                        </td>
						<td align="right"></td>
					</tr>
					<tr class="gs">
						<td>Theme Style</td>
						<td>
							<select name="theme_style" style="width:100px;">
								<option value="light">Light</option>
								<option value="dark">Dark</option>
							</select>
						</td>
					</tr>
					<tr class="gs">
						<td>First Color</td>
						<td>
							<div class="colorSelector"><div style="background-color:"></div>
							<input type="text" class="color" name="colorFirst" value="" />
							</div>
						</td>
					</tr>
					<tr class="gs">
						<td>Second Color</td>
						<td>
							<div class="colorSelector"><div style="background-color:"></div>
							<input type="text" class="color" name="colorSecond" value="" />
							</div>
						</td>
					</tr>
					<tr class="gs">
						<td>Background Color</td>
						<td>
							<div class="colorSelector"><div style="background-color:"></div>
							<input type="text" class="color" name="colorBackground" value="" />
							</div>
						</td>
					</tr>
					<tr class="gs">
						<td>Line Color</td>
						<td>
							<div class="colorSelector"><div style="background-color:"></div>
							<input type="text" class="color" name="colorLine" value="" />
							</div>
						</td>
					</tr>
					<tr class="gs">
						<td>Button Color</td>
						<td>
							<div class="colorSelector"><div style="background-color:"></div>
							<input type="text" class="color" name="colorPasifButtonBg" value="" />
							</div>
						</td>
					</tr>
					<tr class="gs">
						<td>Background Animation Pause</td>
						<td>
							<input type="checkbox" name="bgPaused" value="true" id="bgPaused" />
						</td>
					</tr>
					<tr class="gs">
						<td>Background Items Loop</td>
						<td>
							<input type="checkbox" name="loopBg" value="true" id="loopBg" />
						</td>
					</tr>
					<tr class="gs">
						<td>Draw Actions</td>
						<td> 
							<input type="checkbox" name="drawActions" value="true" id="drawActions" />
						</td>
					</tr>
					<tr class="gs">
						<td>Audio Controller</td>
						<td>
							<input type="checkbox" name="audioController" value="block" id="audioController" />
						</td>
					</tr>
					<tr class="gs">
						<td>Background Controller</td>
						<td>
							<input type="checkbox" name="bgController" value="block" id="bgController" />
						</td>
					</tr>
					<tr class="gs">
						<td>Share Icons</td>
						<td>
							<input type="checkbox" name="shareIcons" value="block" id="shareIcons" />
						</td>
					</tr>
					<tr class="gs">
						<td>Thumbnail Sidebar</td>
						<td>
							<input type="checkbox" name="thController" value="block" id="thController" />
						</td>
					</tr>
					<tr class="gs">
						<td>Background Pattern</td>
						<td>
							<input type="checkbox" name="bgPattern" value="block" id="bgPattern" />
						</td>
					</tr>
					<tr class="gs">
						<td>Logo URL</td>
						<td>
								<div class="url">
									<input type="text" name="logo_url" value="" style="width:300px;"/>
									<a href="javascript:void(0);" onclick="getUrlFromFile(this)">Get URL</a>
								</div>
						</td>
					</tr>
					<tr class="gs">
						<td>Loading Logo URL</td>
						<td>
								<div class="url">
									<input type="text" name="loading_logo_url" value="" style="width:300px;"/>
									<a href="javascript:void(0);" onclick="getUrlFromFile(this)">Get URL</a>
								</div>
						</td>
					</tr>
					<tr class="gs">
						<td>Favicon URL (Only .ico file )</td>
						<td>
								<div class="url">
									<input type="text" name="favicon" value="" style="width:300px;"/>
									<a href="javascript:void(0);" onclick="getUrlFromFile(this)">Get URL</a>
								</div>
						</td>
					</tr>
					<tr class="gs">
						<td align="left">
	                        <input type="submit" id="apply2" class="button" value="Apply Settings" />
                        </td>
						<td align="right"></td>
					</tr>
				</tbody>
			</table>
			</form>
			</div>
			<!-- ****   STYLE OPTIONS END   **** -->
			
			
			
			
			
			
			
			
			
			
			
			
			<!-- ****   TEXT OPTIONS START   **** -->
			<div id="textoptions" style="display:none">
			<form method="post" action="#" onsubmit="return saveSettings('#textoptions')"> 
			<table cellpadding="0" style="width:590px; margin:20px;" class="widefat">
				<thead>
					<tr>
						<th>Option</th>
						<th>Value</th>
					</tr>
				</thead>                
				<tbody>
					<tr class="gs">
						<td align="left">
	                        <input type="submit" id="apply" class="button" value="Apply Settings" />
                        </td>
						<td align="right"></td>
					</tr>
					<tr class="gs">
						<td>Text Color</td>
						<td>
							<div class="colorSelector"><div style="background-color:"></div>
							<input type="text" class="color" name="colorText" value="" />
							</div>
						</td>
					</tr>
					<tr class="gs">
						<td>Header Font</td>
						<td>
							<select name="headerFont" style="width:200px;">
								<option value="">Default</option>
								<?php for($i=0; $i<sizeof($fonts->items); $i++){ ?>
								<option value="<?php echo $fonts->items[$i]->family; ?>" ><?php echo $fonts->items[$i]->family;?></option>
								<?php } ?>
							</select>
							<select name="headerFontVariant" style="width:100px;">
							</select>
						</td>
					</tr>
					<tr class="gs">
						<td>Content Font</td>
						<td>
							<select name="contentFont" style="width:200px;">
								<option value="">Default</option>
								<?php for($i=0; $i<sizeof($fonts->items); $i++){ ?>
								<option value="<?php echo $fonts->items[$i]->family; ?>" ><?php echo $fonts->items[$i]->family;?></option>
								<?php } ?>
							</select> 
							<select name="contentFontVariant" style="width:100px;" >
							</select>
						</td>
					</tr>
					<tr class="gs">
						<td>Content Font Size</td>
						<td>
							<input type="text" name="contentFontSize" style="width:50px;" value="" /> px
						</td>
					</tr>
					
					<tr class="gs">
						<td>H1 Font Size </td>
						<td>
							<input type="text" name="h1FontSize" style="width:50px;" value="" /> px
						</td>
					</tr>
					<tr class="gs">
						<td>H2 Font Size </td>
						<td>
							<input type="text" name="h2FontSize" style="width:50px;" value="" /> px
						</td>
					</tr>
					<tr class="gs">
						<td>H3 Font Size </td>
						<td>
							<input type="text" name="h3FontSize" style="width:50px;" value="" /> px
						</td>
					</tr>
					<tr class="gs">
						<td>H4 Font Size </td>
						<td>
							<input type="text" name="h4FontSize" style="width:50px;" value="" /> px
						</td>
					</tr>
					<tr class="gs">
						<td>H5 Font Size </td>
						<td>
							<input type="text" name="h5FontSize" style="width:50px;" value="" /> px
						</td>
					</tr>
					<tr class="gs">
						<td>H6 Font Size </td>
						<td>
							<input type="text" name="h6FontSize" style="width:50px;" value="" /> px
						</td>
					</tr>
					<tr class="gs">
						<td>Fonts Update</td>
						<td>
							<a href="?page=top-level-menu-action&updatefonts=true">Update Google Fonts</a>
						</td>
					</tr>
					
					
					
					<tr class="gs">
						<td align="left">
	                        <input type="submit" id="apply2" class="button" value="Apply Settings" />
                        </td>
						<td align="right"></td>
					</tr>
				</tbody>
			</table>
			</form>
			</div>
			<!-- ****   TEXT OPTIONS END   **** -->
			
			
			
			
			
			
			
			
			
			
			
			
			<!-- ****   AUDIO MANAGER START   **** -->
			<div id="audiomanager" style="display:none">
			<form method="post" action="#" onsubmit="return saveAudio();"> 
			<table cellpadding="0" style="width:590px; margin:20px;" class="widefat">
				<thead>
					<tr>
						<th colspan="2">AUDIO LIST</th>
					</tr>
				</thead>                
				<tbody id="audiomanagerbody">
				
				</tbody>
				<tfoot>
					<tr>
						<td>
							<input type="submit" name="saveAudioBtn" id="saveAudioBtn" class="button" value="Save Audio List" />
						</td>
						<td align="right">
							<input class="button" type="button" name="addAudioButton" id="addAudioButton" value="Add Audio"/>
						</td>
					</tr>
				</tfoot>
			</table>
			</form>
			</div>
			<!-- ****   AUDIO MANAGER END   **** -->
			
			
			
			
			
			
			
			
			
			
			<!-- ****  GALLERIES LIST START   **** -->
			<div id="gallerieslist" style="display:none">
			<table cellpadding="0" style="width:590px; margin:20px;" class="widefat">
				<thead>
					<tr>
						<th colspan="3">GALLERIES</th>
					</tr>
					<tr>
						<th width="50">ID</th>
						<th >NAME</th>
						<th width="280">ACTIONS</th>
					</tr>
				</thead>                
				<tbody id="gallerieslistbody">
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2">
							<input type="button" name="addGallery" id="addGallery" class="button" value="Add a New Gallery" />
						</td>
					</tr>
				</tfoot>
			</table>
			</div>
			<!-- ****   GALLERIES LIST END   **** -->
			
			
			
			
			
			
			
			
			
			
			<!-- ****  GALLERY DETAIL START   **** -->
			<div id="gallerydetail" style="display:none">
				<div id="addBg">
					<ul>
					 <li><a rel="image" class="selected" href="javascript:void(0);" >Image</a></li>
					 <li><a rel="video" href="javascript:void(0);" >Video</a></li>
					</ul>
					<div class="image">
						<input type="button" id="clickandload" class="button" value="Choose Image" />
					</div>
					<div class="video">
						<form>
						<select name="type" style="float:left; width:200px">
							<option value="youtube">Youtube</option>
							<option value="vimeo">Vimeo</option>
							<option value="selfhosted">Self Hosted Video</option>
							<option value="flash">Flash SWF File</option>
						</select>
						<div class="videotype videoid" style="float:left; margin-left:10px">
							<label style="width:100px">Video ID</label>
							<input type="text" name="id" value="" style="width:100px" />
						</div>
						<div class="videotype videourl" style="display:none">
							<label>Video URL</label>
							<input type="text" name="url" value="" />
						</div>
						<div class="videotype videocode" style="display:none; clear:both; padding:10px 0;">
							<label style="vertical-align: top; padding-right:150px;">Iframe Code</label>
							<textarea name="iframecode" style="width:400px;"></textarea>
						</div>
						<div class="videotype videowh" style="clear:both; padding:10px 0;">
							<label>Width</label>
							<input type="text" name="width" value="" style="width:50px; margin-left:15px" />
							<label>Height</label>
							<input type="text" name="height" value="" style="width:50px"/>
						</div>
						<input type="button" name="addVideo" id="addVideo" class="button" value="Add Video" />
						</form>
					</div>
				</div>
				<div id="sliderImages">
					<form id="sliderImageForm">
					<table id="sliderImageItems" class="widefat" cellspacing="0" style="width:590px; margin:20px;">
						<thead>
							<tr>
								<td colspan="2"><input type="button" name="backtoGallery" id="backtoGallery" class="button" onclick="getGalleriesList();" value="Back to Gallery List" style="float:right" /></td>
							<tr>
							<tr>
								<th colspan="2">[ID:<span id="gallerydetailid"></span>] <span id="gallerydetailname"></span> Gallery</th>
							</tr>
							<tr>
								<th>Image</th>
								<th>Informations</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="2">
									<input type="submit" name="submit" class="button" value="Save Changes" />
								</td>
							</tr>
						</tfoot>
						<tbody>
						</tbody>
					</table>
					</form>
				</div>
			</div>
			<!-- ****  GALLERY DETAIL END   **** -->
			
			
			
			
			
			<!-- ****  THEME CHECK START   **** -->
			<div id="checktheme" style="display:none">
			</div>
			<!-- ****  THEME CHECK END   **** -->
			
			
			
			
				
				<!-- ******************************   CONTENT END   ****************************** -->
			</div>
		<div class="clearfix"></div>
		</div>
	<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
<!-- New Theme END -->


<?php
}
?>