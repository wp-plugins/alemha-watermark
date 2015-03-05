<?php 
//if(!isset($preview)){
$insert_img_path=wp_get_attachment_image_src($attachment_id,"full");
$img_path=explode('/',$insert_img_path[0]);
$insert_img=end($img_path);	
$upload_dir = wp_upload_dir();		
$img_array=explode(".",$insert_img);
$attachment = array(
	'guid'           => $upload_dir['url'] . '/' . $watermark_prefix.$insert_img, 
	'post_mime_type' => $extension,
	'post_title'     => $watermark_prefix.$img_array[0],
	'post_status'    => 'inherit'
);
// Insert the attachment.
$attach_id = wp_insert_attachment( $attachment);
$attach_data =wp_generate_attachment_metadata( $attach_id, $upload_dir['path'] . '/' . $watermark_prefix.$insert_img );
wp_update_attachment_metadata( $attach_id,  $attach_data );
update_post_meta($attach_id, "_wp_attached_file", $upload_dir['subdir'] . '/' . $watermark_prefix.$insert_img);

$watermark_attachment = get_post($attach_id);
update_post_meta($attachment_id, "Mnbaa_watermark_attachment_id", $attach_id);
update_post_meta($attachment_id, "Mnbaa_watermark_attachment_guid", $watermark_attachment->guid);
if(!isset($send_id)){
wp_safe_redirect( "post.php?post=".$attach_id."&action=edit" );
exit; }
?>