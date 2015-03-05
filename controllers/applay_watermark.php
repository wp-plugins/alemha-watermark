<?php $mime_type = wp_check_filetype($filepath);
$extension = $mime_type['type'];
$string	= $watermark->watermark_title;
$font_color = explode(',' ,$watermark->rgb);
$r = $font_color[0];
$g = $font_color[1];
$b = $font_color[2];
$font_color_bg = explode(',' ,$watermark->rgb_bg);
$r_bg = $font_color_bg[0];
$g_bg = $font_color_bg[1];
$b_bg = $font_color_bg[2];
$txt_size = $watermark->txt_size;
$wm_rotate = $watermark->rotation;
$position = $watermark->position;
$wm_bg = $watermark->background;
$wm_opacity	= $watermark->opicity;
$txt_type = $watermark->txt_type;
$padding = $watermark->padding;
$dest_x = $watermark->destance_x;
$mes_x = $watermark->mesaure_x;
$mes_y = $watermark->mesaure_y;
$image = $watermark->image;
$wm_opacity_img = $watermark->img_opicity;
$padding_img = $watermark->img_padding;
$dest_x_img = $watermark->img_destance_x;
$mes_x_img = $watermark->img_mesaure_x;
$mes_y_img = $watermark->img_mesaure_y;
$position_img = $watermark->img_position;
$img_uploaded = get_post((int) $image);
$img_uploaded_path=explode('/',$img_uploaded->guid);
$img_uploaded_name=end($img_uploaded_path);
$img_filepath = $upload_dir['path'] . DIRECTORY_SEPARATOR . $img_uploaded_name ;
$img = $img_uploaded_name;
$img_size = $watermark->img_size;
$wm_rotate_img = $watermark->img_rotation;
$bg_destance_x = $watermark->bg_destance_x;
$bg_padding = $watermark->bg_padding;
if($wm_rotate==""){
	$wm_rotate=0;
}
									
if($extension=='image/jpg' || $extension=='image/jpeg'){
		$im = imagecreatefromjpeg($filepath);
}elseif($extension=='image/png'){
		$im = imagecreatefrompng($filepath);
		imagealphablending($im, false);
		imagesavealpha($im, true);
}elseif($extension=='image/gif'){
		$im = imagecreatefromgif($filepath);
}
						
$color = imagecolorallocate($im, $r, $g, $b);
$font = plugin_dir_path( __FILE__ ).'../libraries/fonts/'.$txt_type;
/*if (preg_match('/[أ-ي]/ui', $string)) {
	$keywords = preg_split("/[أ-ي]/ui", $string);
	$Arabic = new I18N_Arabic('Glyphs'); 
	var_dump($keywords);
	if($keywords[0] !=''){
		$arabic_arr=explode($keywords[0],$string);
		$text = $Arabic->utf8Glyphs($arabic_arr[1]);
		$text=$keywords[0].$text;
	}else{
		$text = $Arabic->utf8Glyphs($string);
	}
	
	
} else {
    $text=$string;
}*/

//$Arabic = new I18N_Arabic('Glyphs'); 
//$text = $Arabic->utf8Glyphs($string);

$keywords=explode(" ",$string);
//var_dump($keywords);
$text="";
foreach($keywords as $k=>$v){
	if (preg_match('/[أ-ي]/ui', $v)){
		$Arabic = new I18N_Arabic('Glyphs'); 
		$text .= $Arabic->utf8Glyphs($v);
	}else{
		$text .= $v;
	}
	$text .=" ";
}

$size = getimagesize($filepath);	
if($padding=="" || $padding==0){$padding=20;}
$wm_bBox = imagettfbbox($txt_size, 0, $font, $text);
$lowerLeftX = $wm_bBox[0];
$lowerLeftY = $wm_bBox[1];
$lowerRightX = $wm_bBox[2];
$lowerRightY = $wm_bBox[3];
$upperRightX = $wm_bBox[4];
$upperRightY = $wm_bBox[5];
$upperLeftX = $wm_bBox[6];
$upperLeftY = $wm_bBox[7];
if($dest_x=="" || $dest_x==0){$dest_x=20;}
if($bg_destance_x==""){
	$bg_watermark_rWidth = ($upperRightX - $upperLeftX)+ 20;
	$watermark_rWidth = ($upperRightX - $upperLeftX) + $padding ;
	
}else{
	$bg_watermark_rWidth = $bg_destance_x+20;
	$watermark_rWidth = $bg_destance_x + $padding;
}
if($bg_padding==""){
	$bg_watermark_rHeight = ($lowerLeftY - $upperLeftY) +20;
	$watermark_rHeight = ($lowerLeftY - $upperLeftY) + $padding;
}else{
	$bg_watermark_rHeight = $bg_padding +20;
	$watermark_rHeight = $bg_padding + $padding;	
}
$watermark_r = imagecreatetruecolor($bg_watermark_rWidth, $bg_watermark_rHeight);
//if($extension=='image/png'){
//	/*$background = imagecolorallocate($watermark_r, 255, 255, 255);
//	imagecolortransparent($watermark_r, $background);*/
//	imagealphablending($watermark_r, false);
//	imagesavealpha($watermark_r, true);
//}
if ($wm_bg=='yes') {
	$color_bg = imagecolorallocate($watermark_r, $r_bg, $g_bg, $b_bg);
	imagefilledrectangle($watermark_r, 0, 0, $watermark_rWidth, $watermark_rHeight, $color_bg);
}
$watermark_rWidth = imagesx($watermark_r);
$watermark_rHeight = imagesy($watermark_r);
$offset_y = ($watermark_rHeight-($wm_bBox[1] +  $wm_bBox[5]))/2  ;
$offset_x = ($watermark_rWidth-($wm_bBox[0] +  $wm_bBox[4]))/2 ;			
imagettftext($watermark_r, $txt_size, 0, $offset_x, $offset_y, $color, $font, $text);
//imagesavealpha($watermark_r, true);						
if ($wm_bg=='yes') {					
	$white = imagecolorallocate($watermark_r, 255, 255, 255);
	$watermark_r = imagerotate($watermark_r, $wm_rotate,$white,0);
	$bg = imagecolortransparent($watermark_r,$white);
}elseif($wm_bg=='no'){
	$watermark_r = imagerotate($watermark_r, $wm_rotate,0,0);
	$bg = imagecolortransparent($watermark_r,0);
}
		$watermark_rWidth = imagesx($watermark_r);
		$watermark_rHeight = imagesy($watermark_r);
	//}
								  
	if($mes_x=='%'){
		$x=$watermark_rWidth/2;
		$dest_x=(($size[0]*$dest_x)/100)-$x;
	}else{
		$dest_x=$dest_x;
	}
	
	if($mes_y=='%'){
		$y=$watermark_rHeight/2;
		$padding=(($size[1]*$padding)/100)-$y;
	}else{
		
		$padding=$padding;
	}
	
	if ($position == 'bottom') {
		$dest_y = $size[1] - ($watermark_rHeight + $padding);
	} else {
		$dest_y = $padding;
	} 
	//if($string !=''){
	//imagesavealpha($watermark_r, true);
	/*if($extension=='image/png'){
		imagecopy($im, $watermark_r, $dest_x, $dest_y, 0, 0, $watermark_rWidth, $watermark_rHeight);
	}else{*/
		imagecopymerge($im, $watermark_r, $dest_x, $dest_y, 0, 0, $watermark_rWidth, $watermark_rHeight, $wm_opacity);
	//}
	//}
						
	if($image !=''){
		if($wm_rotate_img==""){
			$wm_rotate_img=0;
		}
		$wm_image=$img_filepath;
		$factor =1/($img_size);
		$img_ext_arr=explode('.',$img);
		$img_ext=end($img_ext_arr);
		if($img_ext=='jpg' || $img_ext=='jpeg'){
			$watermark2 = imagecreatefromjpeg($wm_image);
		}elseif($img_ext=='png'){
			$watermark2 = imagecreatefrompng($wm_image);
			imagealphablending($watermark2, true);
			imagesavealpha($watermark2, true);
		}elseif($img_ext=='gif'){
			$watermark2 = imagecreatefromgif($wm_image);
		}
		$wm_width2 = imagesx($watermark2);		
		$wm_height2 = imagesy($watermark2);		
		$watermark_rWidth2 = $wm_width2 * $factor;	
		$watermark_rHeight2 = $wm_height2 * $factor;
		$watermark_r2 = @imagecreatetruecolor($watermark_rWidth2, $watermark_rHeight2);
		
		if($img_ext=='png'){
		
			$bgc = imagecolorallocate($watermark_r2, 255, 255, 255);
			imagecolortransparent($watermark_r2,$bgc);
			imagefilledrectangle($watermark_r2, 0, 0, $watermark_rWidth2, $watermark_rHeight2, $bgc);
			
			imagealphablending($watermark_r2, true);
			imagesavealpha($watermark_r2, true);
		}
		imagecopyresampled($watermark_r2, $watermark2, 0,0, 0, 0, $watermark_rWidth2, $watermark_rHeight2, $wm_width2, $wm_height2);
		
		//if ($wm_rotate_img != 0) {
			//if (phpversion() >= 5.1) { 
//					$bg2 = imagecolortransparent($watermark_r2);
//					$watermark_r2 = imagerotate($watermark_r2, $wm_rotate_img, $bg2, 1);
//			} else {
					$white = imagecolorallocate($watermark_r2, 255, 255, 255);
					$watermark_r2 = imagerotate($watermark_r2, $wm_rotate_img, $white,0);
					$bg = imagecolortransparent($watermark_r2,$white);
			//} 
									
			$watermark_rWidth2 = imagesx($watermark_r2);
			$watermark_rHeight2 = imagesy($watermark_r2);
		//}
		if($padding_img==""){$padding_img=20;}
		if($dest_x_img==""){$dest_x_img=20;}
		if($mes_x_img=='%'){
			$x=$watermark_rWidth2/2;
			$dest_x_img=(($size[0]*$dest_x_img)/100)-$x;
		}else{
			$dest_x_img=$dest_x_img;
		}
		
		if($mes_y_img=='%'){
			$y=$watermark_rHeight2/2;
			$padding_img=(($size[1]*$padding_img)/100)-$y;
		}else{
			$padding_img=$padding_img;
		}
		
		if ($position_img == 'bottom') {
			$dest_y_img= $size[1] - ($watermark_rHeight2 + $padding_img);
									 
		} else {
			$dest_y_img = $padding_img;
		} 
						
		imagecopymerge($im, $watermark_r2, $dest_x_img, $dest_y_img, 0, 0, $watermark_rWidth2, $watermark_rHeight2, $wm_opacity_img);
	}
	
	//imagealphablending($im, true);
					 
	if($extension=='image/jpg' || $extension=='image/jpeg'){		
		imagejpeg($im, $filepath, apply_filters( 'jpeg_quality', 90 ));
	}elseif($extension=='image/png'){
		imagepng($im,$filepath);
		
	}elseif($extension=='image/gif'){
		imagegif($im,$filepath);
	}

	
?>