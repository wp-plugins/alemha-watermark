<?php
function get_watermark_image(){
	global $watermark_prefix;
	$watermark_select = get_post_meta( $_POST['id'], 'Mnbaa_watermark_select',true );
	$upload_dir = wp_upload_dir();	
	if(isset($watermark_select) && !(empty ($watermark_select))){
		$watermark_img_id = get_post_meta( $_POST['id'], 'Mnbaa_watermark_attachment_id',true );
		$watermark_img_guid = get_post_meta( $_POST['id'], 'Mnbaa_watermark_attachment_guid',true );
		/*$img_name= explode("/",$watermark_img_guid);
		$img=explode(".",end($img_name));
		$watermark_img_url=$upload_dir['url'] . '/'.$img[0].'-'.$_POST['width'].'x'.$_POST['height'].".".$img[1];*/
		$size=array($_POST['width'],$_POST['height']);
		$image_attributes = wp_get_attachment_image_src( $_POST['id'],$size );
		$img_name= explode("/",$image_attributes[0]);
		$watermark_img_name = $watermark_prefix.end($img_name);
		$watermark_img_url=$upload_dir['url'] . '/' . $watermark_img_name;
		echo $watermark_img_id."+".$watermark_img_url;
	}
	die(); 
	
}

function save_watermark(){
	
	update_post_meta($_POST['post_id'], 'Mnbaa_watermark_select', $_POST['watermark_id']);	
	die();
}

?>