<?php
add_action('admin_menu','add_post_options');
add_action('save_post','save_post_options');

function add_post_options()
{
	global $theme_name;

	add_meta_box('post-Options','Additional Post Settings','postOptions','post','normal','high');
}

function postOptions()
{
	global $post;
	?>
	<style>
	#cpositions{
		width:111px; 
		height:111px; 
		padding:3px; 
		border:1px solid #eee;
	}
	.cposition{
		display:block;
		float:left;
		margin-right:3px;
		margin-bottom:3px;
		width:33px; 
		height:33px; 
		border:1px solid #ddd;
	}
	.cpselected{
		border-color:#ff0000;
	}
	</style>
	<script>
	function setCropPos(obj, pos){
		jQuery('#cropPos').val(pos);
		jQuery('#cpositions a').removeClass('cpselected');
		jQuery(obj).addClass('cpselected');
		if(pos=='t')
			jQuery('#cpositions .tl, #cpositions .tr').addClass('cpselected');
		if(pos=='b')
			jQuery('#cpositions .bl, #cpositions .br').addClass('cpselected');
		if(pos=='l')
			jQuery('#cpositions .tl, #cpositions .bl').addClass('cpselected');
		if(pos=='r')
			jQuery('#cpositions .tr, #cpositions .br').addClass('cpselected');
	}
	</script>
	<div style="width:50%; float:left;">
	<table>
		<tr>
			<td>Show Type</td>
			<td>
				<select name="sourceOpen" style="width:300px;">
					<option value="e" <?php echo (get_post_meta( $post->ID,"sourceOpen",true)=='e')?'selected':''; ?> >Embed</option>
					<option value="m" <?php echo (get_post_meta( $post->ID,"sourceOpen",true)=='m')?'selected':''; ?>>Modal</option>
				</select>
			<input  type="hidden" name="sourceOpen_noncename" id="sourceOpen_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
			</td>
		</tr>
		<tr>
			<td>URL</td>
			<td><input name="sourceData" style="width:300px;" type="text" value="<?php echo get_post_meta( $post->ID,"sourceData",true) ?>" />
			<input  type="hidden" name="sourceData_noncename" id="sourceData_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
			</td>
		</tr>
	</table>
	</div>
	<div style="width:50%; float:left;">
		<input type="checkbox" name="useInDetail" id="useInDetail" value="use"  <?php echo (get_post_meta( $post->ID,"useInDetail",true)=='use')?'checked':''; ?> /> Use In Detail
		<input  type="hidden" name="useInDetail_noncename" id="useInDetail_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" /><br /><br />
		
		<input type="checkbox" name="useResizer" id="useResizer" value="use"  <?php echo (get_post_meta( $post->ID,"useResizer",true)=='use')?'checked':''; ?> /> Use TimTumb to resize thubnails
		<input  type="hidden" name="useResizer_noncename" id="useResizer_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" /><br /><br />
		
		Select a Crop Position
		<?php $cp = get_post_meta($post->ID,"cropPos",true); ?>
		<div id="cpositions">
			<a class="cposition tl <?php echo ($cp=='tl' || $cp=='t' || $cp=='l')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'tl');" ></a>
			<a class="cposition t <?php echo  ($cp=='t')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 't');" ></a>
			<a class="cposition tr <?php echo ($cp=='tr' || $cp=='t' || $cp=='r')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'tr');" style="margin-right:0px;"></a>
			
			<a class="cposition l <?php echo  ($cp=='l')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'l');" ></a>
			<a class="cposition c <?php echo  ($cp=='c' || $cp=='')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'c');" ></a>
			<a class="cposition r <?php echo  ($cp=='r')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'r');" style="margin-right:0px;"></a>
			
			<a class="cposition bl <?php echo ($cp=='bl' || $cp=='b' || $cp=='l')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'bl');" ></a>
			<a class="cposition b <?php echo  ($cp=='b')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'b');" ></a>
			<a class="cposition br <?php echo ($cp=='br' || $cp=='b' || $cp=='r')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'br');" style="margin-right:0px;"></a>
		</div>
		
		<input type="hidden" name="cropPos" id="cropPos" value="<?php echo (get_post_meta($post->ID,"cropPos",true)=='')?'c':get_post_meta( $post->ID,"cropPos",true); ?>" />
		<input  type="hidden" name="cropPos_noncename" id="cropPos_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
	</div>
	<div style="clear:both;"></div>
	<?php
}

function save_post_options($postID)
{
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;
	  
	if(defined('DOING_AJAX') && DOING_AJAX)
		return;

	global $post;

	$sourceData = '';
	$sourceOpen = '';
	$useResizer = '';
	$cropPos = '';
	$useInDetail = '';

	if(!empty($_POST["sourceData"]))
		$sourceData = stripslashes($_POST["sourceData"]);
	if(!empty($_POST["sourceOpen"]))
		$sourceOpen = stripslashes($_POST["sourceOpen"]);
	if(!empty($_POST["useResizer"]))
		$useResizer = stripslashes($_POST["useResizer"]);
	if(!empty($_POST["cropPos"]))
		$cropPos = stripslashes($_POST["cropPos"]);
	if(!empty($_POST["useInDetail"]))
		$useInDetail = stripslashes($_POST["useInDetail"]);
		
			
	if(get_post_meta($postID,"sourceData")=='')
		add_post_meta($postID,"sourceData",$sourceData,true);
	elseif($sourceData!=get_post_meta($postID,"sourceData", true))
		update_post_meta($postID,"sourceData",$sourceData);
	elseif($sourceData=='')
		delete_post_meta($postID,"sourceData",get_post_meta($postID,"sourceData",true));
		
	if(get_post_meta($postID,"sourceOpen")=='')
		add_post_meta($postID,"sourceOpen",$sourceOpen,true);
	elseif($sourceOpen!=get_post_meta($postID,"sourceOpen", true))
		update_post_meta($postID,"sourceOpen",$sourceOpen);
	elseif($sourceOpen=='')
		delete_post_meta($postID,"sourceOpen",get_post_meta($postID,"sourceOpen",true));
		
	if(get_post_meta($postID,"useResizer")=='')
		add_post_meta($postID,"useResizer",$useResizer,true);
	elseif($useResizer!=get_post_meta($postID,"useResizer", true))
		update_post_meta($postID,"useResizer",$useResizer);
	elseif($useResizer=='')
		delete_post_meta($postID,"useResizer",get_post_meta($postID,"useResizer",true));
		
	if(get_post_meta($postID,"useInDetail")=='')
		add_post_meta($postID,"useInDetail",$useInDetail,true);
	elseif($useInDetail!=get_post_meta($postID,"useInDetail", true))
		update_post_meta($postID,"useInDetail",$useInDetail);
	elseif($useInDetail=='')
		delete_post_meta($postID,"useInDetail",get_post_meta($postID,"useInDetail",true));
		
	if(get_post_meta($postID,"cropPos")=='')
		add_post_meta($postID,"cropPos",$cropPos,true);
	elseif($cropPos!=get_post_meta($postID,"cropPos", true))
		update_post_meta($postID,"cropPos",$cropPos);
	elseif($cropPos=='')
		update_post_meta($postID,"cropPos",'c');
}

?>