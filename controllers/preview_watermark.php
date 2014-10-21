<?php 
$watermark = get_post($_POST['Mnbaa_watermark_select']); 
//var_dump($watermark);
$upload_dir   = wp_upload_dir();
global $dir_name;
global $prefix;
if(isset($preview)){
	$new_image="index_".$post_id.".jpg";
	$filepath = $dir_name."/images/".$new_image ;
	
	if (file_exists($filepath))
		unlink($filepath);
	
	$filepath2 = $dir_name."/images/index.jpg" ;
	copy($filepath2, $filepath);
	include ($dir_name . '/controllers/applay_watermark.php');
}else{
	
	$img_sizes = json_decode($watermark->img_sizes);
	if($img_sizes==NULL){
		$img_sizes=array('thumbnail','medium','large','full');
	}
	
	foreach($img_sizes as $attachment_size){
	
		/*$old_img = get_post((int) $post['ID']);
		//var_dump($old_img);
		$image_path=explode('/',$old_img->guid);
		$image_name=end($image_path);
		$filepath = $upload_dir['path'] . DIRECTORY_SEPARATOR . $image_name ;*/
		$old_img=wp_get_attachment_image_src($post['ID'],$attachment_size);
		$image_path=explode('/',$old_img[0]);
		$image_name=end($image_path);
		$filepath2 = $upload_dir['path'] . DIRECTORY_SEPARATOR . $image_name ;
		
		$mime_type = wp_check_filetype($filepath2);
		$extension = $mime_type['type'];
		$new_image=$prefix.$image_name;
		$filepath = $upload_dir['path'] . DIRECTORY_SEPARATOR.$new_image ;
		copy($filepath2, $filepath);
		
		include ($dir_name . '/controllers/applay_watermark.php');
	}
	include ($dir_name . '/controllers/insert_newpost.php');

}
?>