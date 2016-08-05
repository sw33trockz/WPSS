<?php
if(is_admin())
{
add_action('wp_ajax_load_font_variants', 'load_font_variants');
function load_font_variants()
{
	echo '{"status":"OK", "variants":'.json_encode(getFont($_POST['font'],'variants')).'}';
	die();
}

add_action('wp_ajax_General_save', 'General_save');
function General_save()
{
	global $regSettings, $defValues;
	foreach($_POST['vars'] as $regKey)
	{
		if(array_key_exists($regKey, $_POST)){
			update_option($regKey, $_POST[$regKey]);
		}else{
			if(array_key_exists($regKey, $defValues))
				update_option($regKey, $defValues[$regKey]);
			else
				update_option($regKey, '');
		}
	}
		echo '{"status":"OK", "type":"apply"}';
	die();
}

add_action('wp_ajax_General_db_save', 'General_db_save');
function General_db_save()
{
	global $regSettings, $defValues;
	global $wpdb;
	$re = '{';
	for($i=0; $i<sizeof($regSettings); $i++)
	{
		if(array_key_exists($regSettings[$i], $_POST))
			$re.='"'.$regSettings[$i].'":"'.str_replace("\'","'",$_POST[$regSettings[$i]]).'", ';
		else
			if(array_key_exists($regSettings[$i], $defValues))
				$re.='"'.$regSettings[$i].'":"'.str_replace("\'","'",$defValues[$regSettings[$i]]).'", ';
			else
				$re.='"'.$regSettings[$i].'":"", ';
	}
	$re = substr($re, 0, -2);
	$re .= '}';
	
	if(empty($_POST['settingsID']) && !empty($_POST['name']))
	{
		//insert
		$insert_query = "INSERT INTO {$wpdb->prefix}settings (ID, NAME, SETTINGS) VALUES ('NULL', '".$wpdb->escape($_POST['name'])."', '".$wpdb->escape($re)."')";
		$insert = $wpdb->get_results($insert_query);
		if(sizeof($insert)==0)
		{
			$setItem = '<tr id="set'.$wpdb->insert_id.'">
					<td>'.$_POST['name'].'</td>
					<td>
						<a href="javascript:void(0);" onclick="getSet('.$wpdb->insert_id.')" >[Get]</a>&nbsp;&nbsp;
						<a href="javascript:void(0);" onclick="deleteSet('.$wpdb->insert_id.')" >[Delete]</a>&nbsp;&nbsp;
						<a href="'.site_url().'?preview='.$wpdb->insert_id.'" target="_blank">[Preview]</a>
					</td>
				</tr>';
			$setItem = str_replace("\n",'',$setItem);
			$setItem = str_replace("\r",'',$setItem);
			$setItem = str_replace("\t",'',$setItem);
			
			$ret = array('status'=>'OK', 'type'=>'insert', 'settingsID'=>$wpdb->insert_id,
			'name'=>$_POST['name'], 'html'=>$setItem);
			echo json_encode($ret);
		}else{
			echo '{"status":"NOK", "ERR":"Have got an error when adding settings."}';
		}
	}elseif(!empty($_POST['settingsID']) && empty($_POST['name'])){
		// update
		$update_query = "UPDATE {$wpdb->prefix}settings SET SETTINGS='".$wpdb->escape($re)."' WHERE ID='".$_POST['settingsID']."'";
		$update = $wpdb->get_results($update_query);
		if(sizeof($update)==0)
		{
			echo '{"status":"OK", "type":"update", "settingsID":"'.$_POST['settingsID'].'"}';
		}else{
			echo '{"status":"NOK", "ERR":"Have got an error when updating settings."}';
		}
	}else{
		//error
		echo '{"status":"NOK", "ERR":"Data error."}';
	}
	die();
}

add_action('wp_ajax_delete_set', 'delete_set');
function delete_set()
{
	global $wpdb;
	$result = $wpdb->query("DELETE FROM {$wpdb->prefix}settings WHERE ID = ".$_POST['setID']);
	if($result>0)
		echo '{"status":"OK", "setID":"'.$_POST['setID'].'"}';
	else
		echo '{"status":"NOK", "ERR":"Have got an error when deleting."}';
	die();
}

add_action('wp_ajax_get_images', 'get_images');
function get_images()
{
	global $settingsimages, $settingsimagesUrl;
	$re = '';
	if ($handle = opendir($settingsimages)) {
		while (false !== ($imageInDir = readdir($handle))) {
			if($imageInDir!='.' && $imageInDir!=='..'){
				$imageInDir = end(explode('/', $imageInDir));
				$re .= createItemForImageList($imageInDir, $settingsimagesUrl.'/'.$imageInDir);
			}
		}
	}else	
		$re .= '<tr><td colspan="2">Directory has not been created; '.$settingsimages.'</td></tr>';

	echo $re;
	die();
}

add_action('wp_ajax_delete_image', 'delete_image');
function delete_image()
{
	global $upload_dir, $settingsimages, $settingsimagesUrl;
	$src = $settingsimages.'/'.$_POST['imgName'];	
	if(unlink($src))
	{
		echo '{"status":"OK", "imgID":"'.$_POST['imgID'].'"}';
	}else{
		echo '{"status":"NOK", "ERR":"Have got an error when deleting file."}';
	}
	die();
}

add_action('wp_ajax_get_general', 'get_general');
function get_general()
{
	global $regSettings;
	$ret = array();

	foreach($_POST['vars'] as $regKey)
		if(get_option($regKey))
			$ret[$regKey]=get_option($regKey);
		else
			$ret[$regKey]= '';
		
	echo json_encode($ret);
	die();
}

add_action('wp_ajax_get_set', 'get_set');
function get_set()
{
	global $wpdb;
	$row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}settings where ID=".$_POST['setID']);
		echo '{"status":"OK", "settingsID":"'.$row->ID.'" ,"name":"'.str_replace("\'","'",$row->NAME).'", "data":['.$row->SETTINGS.']}';
	die();
}

add_action('wp_ajax_get_audio_list', 'get_audio_list');
function get_audio_list(){
	$audioList = get_option("audioList");
	$listHTML = '';
	if(!empty($audioList))
	{
		$audioJSON = json_decode($audioList);
		for($i=0; $i<sizeof($audioJSON); $i++)
		{
			$listHTML .= createAudioItem(
				htmlentities(stripslashes($audioJSON[$i]->name),ENT_QUOTES, "UTF-8"), 
				htmlentities(stripslashes($audioJSON[$i]->mp3),ENT_QUOTES, "UTF-8"), 
				htmlentities(stripslashes($audioJSON[$i]->ogg),ENT_QUOTES, "UTF-8"));
		}
	}
	echo $listHTML;
	die();
}

add_action('wp_ajax_get_gallery_list', 'get_gallery_list');
function get_gallery_list(){
	global $wpdb;
	$listHTML = '';
	$result = $wpdb->get_results("SELECT GALLERYID, GALLERYNAME FROM {$wpdb->prefix}galleries ORDER BY GALLERYID");
	foreach($result as $row)
	{
		$listHTML .= createGalleryListItem($row->GALLERYID, $row->GALLERYNAME);
	}
	echo $listHTML;
	die();
}

add_action('wp_ajax_save_audio_list', 'save_audio_list');
function save_audio_list(){
	$datas = array();
	for($i=0; $i<sizeof($_POST['audioName']); $i++){
		array_push($datas, array('name'=>$_POST['audioName'][$i], 'mp3'=>$_POST['audioMp3Path'][$i], 'ogg'=>$_POST['audioOggPath'][$i]));
	}
	update_option('audioList', json_encode($datas));
	echo '{"status":"OK"}';
	die();
}
add_action('wp_ajax_delete_gallery', 'delete_gallery');
function delete_gallery(){
	global $wpdb;
	$result = $wpdb->query("DELETE FROM {$wpdb->prefix}galleries WHERE GALLERYID = ".$_POST['GALLERYID']);
	if($result>0)
		echo '{"status":"OK", "GALLERYID":"'.$_POST['GALLERYID'].'"}';
	else
		echo '{"status":"NOK", "GALLERYID":"'.$_POST['GALLERYID'].'"}';
	die();
}

add_action('wp_ajax_setfp_gallery', 'setfp_gallery');
function setfp_gallery(){
	update_option('fpgalleryid', $_POST['GALLERYID']);
	echo '{"status":"OK"}';
	die();
}

function createGalleryListItem($id, $name){
	$fpgalleryid = get_option('fpgalleryid');
	if(empty($fpgalleryid))
		register_setting('rightnowsettings', 'fpgalleryid');
	return '<tr id="glist_'.$id.'">
		<td>'.$id.'</td>
		<td>'.$name.(($fpgalleryid==$id)?' <span class="settedfp">[Front Page]</span>':'').'</td>
		<td>
			<input type="button" name="detailGalleryBtn" onclick="detailGallery('.$id.',\''.$name.'\');" class="button" value="Edit Gallery" />
			<input type="button" name="setFrontpageGalleryBtn" onclick="setFrontpageGallery('.$id.');" class="button" value="Set Front Page" />
			<input type="button" name="removeGalleryBtn" onclick="removeGallery('.$id.');" class="button" value="Remove" />
		</td>
	</tr>';
}

function createAudioItem($name, $mp3, $ogg){
	return '<tr>
		<td align="left" colspan="2">
			<table cellpadding="0" style="width:550px; margin:10px;" class="widefat">
			<tr style="width:100px;">
				<td>Name</td>
				<td>
					<input type="text" name="audioName[]" value="'.$name.'" style="width:200px" />
					<input class="button" onclick="removeAudioItem(this);" type="button" name="removeAudio"  value="Remove This Item"/>
				</td>
			</tr>
			<tr>
				<td>Mp3 File Path</td>
				<td><input type="text" name="audioMp3Path[]" value="'.$mp3.'" style="width:440px" /></td>
			</tr>
			<tr>
				<td>Ogg File Path</td>
				<td><input type="text" name="audioOggPath[]" value="'.$ogg.'" style="width:440px" /></td>
			</tr>
			</table>
		</td>
	</tr>';
}

function getSliderItemImage($imageID, $type, $content, $caption, $description, $thumb, $width, $height)
{
	$total = "";
	$total = 	'<tr id="imageID'.$imageID.'" class="sliderImageItem">';
	$total .= 	'<td><input type="hidden" name="imageID[]" value="'.$imageID.'" />';
	if(function_exists('wpthumb'))
		$thumb = wpthumb($thumb,'width=120&height=80&resize=true&crop=1&crop_from_position=center,center');
	$total .= 	'<div class="sliderImageItemImage">
					<img width="120" height="80" src="'.$thumb.'" />
					<br/>';
	if($type=='vimeo' || $type=='youtube' || $type=='selfhosted' || $type=='flash')
	{
		$total .= 'Video <span class="videoWidth"><a href="javascript:void(0);" onclick="changeDimension(this, \'Width\')">'.$width.'</a></span> x
					<span class="videoHeight"><a href="javascript:void(0);" onclick="changeDimension(this, \'Height\')">'.$height.'</a></span><br>';
	}
	$total .=	'<a href="javascript:void(0);" onclick="deleteItemImage(this)">[Delete]</a> <br/>
				<a class="thumbUploaderBtn" href="javascript:void(0);" onclick="thumUploader(this)">[Upload Thumbnail]</a>
				</div>
				</td>';
	$total .=	'<td>
				<input type="hidden" name="IMAGEID[]" value="'.$imageID.'" />';
	$total .=	'<div class="sliderImageItemControl">
				<span>CAPTION</span><br />
				<input type="text" name="CAPTION[]" value="'.$caption.'" style="width:400px;" />
				<br />
				<span>DESCRIPTION</span><br />
				<textarea name="DESCRIPTION[]" style="width:400px; height:50px;">'.$description.'</textarea>
				</div>';
	$total .= 	'</td>';
	$total .= 	'</tr>';
	return $total;
}

add_action('wp_ajax_list_slider_items', 'list_slider_items');
function list_slider_items()
{
	global $wpdb;
	$result = $wpdb->get_results("SELECT IMAGEID, TYPE, CONTENT, THUMB, CAPTION, DESCRIPTION, WIDTH, HEIGHT FROM {$wpdb->prefix}backgrounds WHERE GALLERYID='".$_POST['GALLERYID']."' ORDER BY SLIDERORDER");
	$i=0;
	foreach($result as $row)
	{
		echo getSliderItemImage($row->IMAGEID, $row->TYPE, $row->CONTENT, stripslashes($row->CAPTION), stripslashes($row->DESCRIPTION), $row->THUMB, $row->WIDTH, $row->HEIGHT);
		$i++;
	}
	die();
}

add_action('wp_ajax_save_slider_items', 'save_slider_items');
function save_slider_items()
{
	global $wpdb;
	for($i=0; $i<count($_POST['imageID']); $i++)
	{
		$wpdb->update($wpdb->prefix.'backgrounds', array('CAPTION'=>$_POST['CAPTION'][$i], 'DESCRIPTION'=>$_POST['DESCRIPTION'][$i], 'SLIDERORDER'=>($i+1)), array('IMAGEID'=>$_POST['imageID'][$i]), array('%s', '%s', '%d'), array('%d')); 
	}
	die();
}


add_action('wp_ajax_change_video_dimension', 'change_video_dimension');
function change_video_dimension()
{
	global $wpdb;
	$resultOld = $wpdb->get_row( "SELECT WIDTH, HEIGHT FROM {$wpdb->prefix}backgrounds WHERE IMAGEID=".$_POST['IMAGEID']);
	if($_POST['dimType']=='Width'){
		$wpdb->update($wpdb->prefix.'backgrounds', array('WIDTH'=>$_POST['value']), array('IMAGEID'=>$_POST['IMAGEID']), array('%d'), array('%d')); 
	}elseif($_POST['dimType']=='Height'){
		$wpdb->update($wpdb->prefix.'backgrounds', array('HEIGHT'=>$_POST['value']), array('IMAGEID'=>$_POST['IMAGEID']), array('%d'), array('%d')); 
	}
	$resultNew = $wpdb->get_row( "SELECT WIDTH, HEIGHT FROM {$wpdb->prefix}backgrounds WHERE IMAGEID=".$_POST['IMAGEID']);
	
	if($_POST['dimType']=='Width'){
		echo '{"status":"OK", "IMAGEID":"'.$_POST['IMAGEID'].'", "dimType":"'.$_POST['dimType'].'", "value":"'.$resultNew->WIDTH.'"}';
	}elseif($_POST['dimType']=='Height'){
		echo '{"status":"OK", "IMAGEID":"'.$_POST['IMAGEID'].'", "dimType":"'.$_POST['dimType'].'", "value":"'.$resultNew->HEIGHT.'"}';
	}
	die();
}

add_action('wp_ajax_add_video_item', 'add_video_item');
function add_video_item(){
	global $wpdb;
	$result = $wpdb->get_row( "SELECT MAX(SLIDERORDER)+1 as lastid FROM {$wpdb->prefix}backgrounds ");
	$target = $_POST['data'];
	$thumb = '';
	if($_POST['type']=='youtube')
		$thumb = 'http://img.youtube.com/vi/'.$_POST['data'].'/1.jpg';
	elseif($_POST['type']=='vimeo'){
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$_POST['data'].".php"));
		$thumb = $hash[0]['thumbnail_medium'];
	}	
	$insertResult = $wpdb->insert( $wpdb->prefix.'backgrounds', array('SLIDERORDER'=>$result->lastid, 'CONTENT'=>$target, 'TYPE'=>$_POST['type'], 
	'THUMB'=>$thumb, 'WIDTH'=>$_POST['width'], 'HEIGHT'=>$_POST['height'], 'GALLERYID'=>$_POST['GALLERYID']), array('%d','%s', '%s', '%s', '%d', '%d', '%d') );
	
	if($insertResult>0)
		echo '{"status":"OK", "IMAGEID":"'.$wpdb->insert_id.'", "GALLERYID":"'.$_POST['GALLERYID'].'"}';
	else
		echo '{"status":"NOK"}';
	
	die();
}


add_action('wp_ajax_remove_item_image', 'remove_item_image');
function remove_item_image()
{
	global $wpdb;
	$result = $wpdb->query("DELETE FROM {$wpdb->prefix}backgrounds WHERE IMAGEID = ".$_POST['IMAGEID']);
	if($result>0)
		echo '{"status":"OK", "IMAGEID":"'.$_POST['IMAGEID'].'"}';
	else
		echo '{"status":"NOK" "IMAGEID":"'.$_POST['IMAGEID'].'"}';
	die();
}

add_action('wp_ajax_add_new_gallery', 'add_new_gallery');
function add_new_gallery(){
	global $wpdb;
	$insertResult = $wpdb->insert( $wpdb->prefix.'galleries', array( 'GALLERYNAME'=>$_POST['name']), array('%s'));
	if($insertResult>0)
		echo json_encode(array('status'=>'OK', 'html'=>createGalleryListItem($wpdb->insert_id, $_POST['name'])));
	else
		echo json_encode(array('status'=>'NOK'));
	die();
}

add_action('wp_ajax_check_theme', 'check_theme');
function check_theme(){
	global $upload_dir, $settingsimages, $settingsimagesUrl, $galleryimages;
	$re = '<table cellpadding="0" style="width:590px; margin:20px;" class="widefat">
				<thead>
					<tr>
						<th colspan="2">THEME CHECK RESULTS</th>
					</tr>
					<tr>
						<th width="50">STATUS</th>
						<th>ITEM</th>
					</tr>
				</thead>                
				<tbody>';
	
	$chErr = checkDir($upload_dir['basedir'], 0777);
	$re .= @addCheckItem( array('name'=>'Upload Directory', 'status'=>$chErr['status'], 'ErrMessage'=>$chErr['err'], 'ErrInfo'=>'This directory usually being used by WordPress for all media files. <strong>Default is wp-content/uploads</strong>. For that reason, you can\'t upload any image files without createing and giving its permissions.') );
	
	$chErr = checkDir($settingsimages, 0777);
	$re .= @addCheckItem( array('name'=>'Image Manager Directory', 'status'=>$chErr['status'], 'ErrMessage'=>$chErr['err'], 'ErrInfo'=>'This folder is used by Image Manager in General Theme Settings. In order to run this function, this folder must be created.') );
	
	$chErr = checkDir($galleryimages, 0777);
	$re .= @addCheckItem( array('name'=>'Gallery Images Directory', 'status'=>$chErr['status'], 'ErrMessage'=>$chErr['err'], 'ErrInfo'=>'This folder is used for uploading images in Gallery section.') );
	
	$wpnavi = (function_exists('wp_pagenavi'))?'ok':'nok';
	$re .= @addCheckItem( array('name'=>'WP-PageNavi Plugin', 'status'=>$wpnavi, 'ErrMessage'=>'Please Install and Activate WP-PageNavi Plugin.', 'ErrInfo'=>'This plugin is used for pagination in Blog and Portfolio sections. You can find this plugin in downloaded files / plugins folder.(You can watch the video about plugin installation)') );
	
	$wpthumbplugin = (function_exists('wpthumb'))?'ok':'nok';
	$re .= @addCheckItem( array('name'=>'WP Thumb Plugin', 'status'=>$wpthumbplugin, 'ErrMessage'=>'Please Install and Activate WP Thumb Plugin.', 'ErrInfo'=>'This plugin is used for image resizing. You can find this plugin in downloaded files / plugins folder.') );
		
	$getContentRemote = @file_get_contents('http://www.renklibeyaz.com/rightnow.xml');
	$getContentRemoteStatus = empty($getContentRemote)?'nok':'ok';
	$re .= @addCheckItem( array('name'=>'file_get_contents Remote Server Access', 'status'=>$getContentRemoteStatus, 
		'ErrMessage'=>'Your server is blocking "Remote Server Connection". Please contact your host provider to allow "file_get_contents" php function.', 
		'ErrInfo'=>'This function gets the thumbnail of the video files, update the fonts and displaying notice about theme updates.') );
	
	
	$sxml = (function_exists('simplexml_load_string'))?'ok':'nok';
	$re .= @addCheckItem( array('name'=>'PHP SimpleXml Class', 'status'=>$sxml, 
		'ErrMessage'=>'Your server doesn\'t have "SimpleXml Class" which is a PHP Class.', 
		'ErrInfo'=>'This Class gets the thumbnail of the video files, displaying notice about theme updates.') );
	
	$curlStatus = (function_exists('curl_init'))?'ok':'nok';
	$re .= @addCheckItem( array('name'=>'PHP cURL Class', 'status'=>$curlStatus, 
		'ErrMessage'=>'Your server doesn\'t have "cURL Class" which is a PHP Class.', 
		'ErrInfo'=>'This Class is displaying notice about theme updates.') );
		
	$re .= '</tbody>
		<table>';
	echo $re;
	die();
}

function addCheckItem($params){
	$re = '';
	$re.= '<tr '.((!empty($params['id']))?'id="'.$params['id'].'"':'').'><td>';
	if($params['status']=='ok' || $params['status']=='wait')
		$re .= '<div class="statusIcon statusOK '.(($params['status']=='wait')?'statusWait':'').'"></div>';
	if($params['status']=='nok' || $params['status']=='wait')
		$re .= '<div class="statusIcon statusNOK '.(($params['status']=='wait')?'statusWait':'').'" ><div>';
	$re.= '</td><td>'.$params['name'];
	
	if(($params['status']=='nok' && !empty($params['ErrMessage'])) || $params['status']=='wait')
		$re.= '<div class="ErrMessage '.(($params['status']=='wait')?'statusWait':'').'">'.$params['ErrMessage'].'</div>';
	
	if(($params['status']=='nok' && !empty($params['ErrInfo'])) || $params['status']=='wait')
		$re.= '<div class="ErrInfo '.(($params['status']=='wait')?'statusWait':'').'">'.$params['ErrInfo'].'</div>';
	
	$re.= '</td></tr>';
	return $re;
}

function checkDir($dir, $mode){
	if(!is_dir($dir)){
		@mkdir($dir, $mode);
		if(!is_dir($dir)){
			return array( 'err' => 'This directory could not be created automatically. Please create "'.$dir.'" directory and give '.decoct($mode).' permission.',
				'status'=>'nok',
				'code'=>1);
		}
	}
	if(is_dir($dir)){
		if(substr(decoct( fileperms($dir) ), 2)!=decoct($mode)){
			if(!chmod($dir, $mode))
				return array( 'err' => 'This directory permissions could not be changed automatically. Please change permissions "'.$dir.'" directory as '.decoct($mode).'.',
					'status'=>'nok',
					'code'=>2);
			else
				return array('status'=>'ok', 'code'=>3);
		}else
			return array('status'=>'ok', 'code'=>4);
	}
}

add_action('wp_ajax_insert_new_bg_item', 'insert_new_bg_item');
function insert_new_bg_item(){
	global $wpdb;
	
	$gallaryid = (int) $_POST['GALLERYID'];
	if(sizeof($_POST['urls'])>0 && $gallaryid>0)
	{
		$err=0;
		foreach($_POST['urls'] as $url)
		{
			$result = $wpdb->get_row( "SELECT IFNULL(MAX(SLIDERORDER)+1,1) as lastid FROM {$wpdb->prefix}backgrounds ");
			$insertResult = $wpdb->insert( $wpdb->prefix.'backgrounds', array( 'SLIDERORDER'=>$result->lastid, 'CONTENT'=>$url, 'TYPE'=>'image', 'THUMB'=>$url, 'GALLERYID'=>$gallaryid),  array('%d','%s', '%s', '%s', '%d') );
			if(!$insertResult) $err++;
		}
		
		if($err==0)
			$ret = array('status'=>'OK');
		elseif($err==sizeof($_POST['urls']))
			$ret = array('status'=>'NOK');
		else
			$ret = array('status'=>'OK', 'Err'=>'There has been some errors while inserting to database. Please check your items.');
	}
	echo json_encode($ret);
	die();
}

add_action('wp_ajax_change_thumb_of_item', 'change_thumb_of_item');
function change_thumb_of_item(){
	global $wpdb;
	$imageid = (int) $_POST['imageid'];
	if(isset($_POST['url']) && $imageid>0)
	{
		$url = $_POST['url'];
		$updateResult = $wpdb->update($wpdb->prefix.'backgrounds', array('THUMB'=>$url), array('IMAGEID'=>$imageid), array('%s'), array('%d')); 
		
		if(sizeof($updateResult)>0){
			$thumbpath = $url;
			if(function_exists('wpthumb'))
				$thumbpath = wpthumb($thumbpath,'width=120&height=80&resize=true&crop=1&crop_from_position=center,center');
				
			$ret = array('status'=>'OK', 'IMAGEID'=>$imageid, 'thumbpath'=>$thumbpath );
		}else
			$ret = array('status'=>'NOK', 'Err'=>'Have gots an error while inserting to database.');		
	}else{
		$ret = array('status'=>'NOK', 'Err'=>'There is a prameters problem.');
	}
	echo json_encode($ret);
	die();
}

}
?>