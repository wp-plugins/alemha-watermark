<?php
global $img_upload_setting_meta_fields, $post;
    // Use nonce for verification
    //echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($img_upload_setting_meta_fields as $field) {
        // get value of this field if it exists for this post
        $img_meta = get_post_meta($post->ID, $field['name'], true);
		$img_mesaure_x_meta = get_post_meta($post->ID, 'img_mesaure_x', true); 
		$img_mesaure_y_meta = get_post_meta($post->ID, 'img_mesaure_y', true); 
        echo '<tr><th><label for="' . $field['name'] . '">' . __($field['label'], 'mnbaa_watermark') . '</label></th><td>';
        switch ($field['type']) {
			
			case 'text' :
				if($field['name']=='img_destance_x'){
					Mnbaa_Watermark_small_input($field['name'], $img_meta);
					//echo'<br /><span class="description">' . $field['desc'] . '</span>';
					echo '<select name="img_mesaure_x" id="img_mesaure_x">';
					echo '<option', $img_mesaure_x_meta == "px" ? ' selected="selected"' : '', ' value="px">px</option>';
					echo '<option', $img_mesaure_x_meta == "%" ? ' selected="selected"' : '', ' value="%">%</option>';
					echo '</select><br />';
				}elseif($field['name']=='img_padding'){
					Mnbaa_Watermark_small_input($field['name'], $img_meta);
					//echo'<br /><span class="description">' . $field['desc'] . '</span>';
					echo '<select name="img_mesaure_y" id="img_mesaure_y">';
					echo '<option', $img_mesaure_y_meta == "px" ? ' selected="selected"' : '', ' value="px">px</option>';
					echo '<option', $img_mesaure_y_meta == "%" ? ' selected="selected"' : '', ' value="%">%</option>';
					echo '</select><br />';
				}else{
					Mnbaa_Watermark_small_input($field['name'], $img_meta);
					echo'<br /><span class="description">' . __($field['desc'], 'mnbaa_watermark') . '</span>';
				}
                break;

            case 'select' :
               echo '<select name="'.$field['name'].'" id="'.$field['name'].'">';
			   if($field['name']=='img_opicity'){
				  
				   for ($i=100; $i>=5; $i-=5){
					   
						echo '<option', $img_meta == $i ? ' selected="selected"' : '', ' value="'.$i.'">'.$i."%".'</option>';
					}
			   }else{
					foreach ($field['options'] as $option) {
						echo '<option', $img_meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.__($option['label'],'mnbaa_watermark').'</option>';
					}
			   }
				echo '</select><br /><span class="description">'.__($field['desc'], 'mnbaa_watermark').'</span>';
			break;
			
			case 'image':
    $image = plugins_url( 'images/noimage.jpg', dirname(__FILE__) );
    echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
    if ($img_meta) { $image = wp_get_attachment_image_src($img_meta, 'medium'); $image = $image[0]; }               
    echo    '<input name="'.$field['name'].'" type="hidden" class="custom_upload_image" value="'.$img_meta.'" />
                <img src="'.$image.'" class="custom_preview_image" alt="" /><br />
                    <input class="custom_upload_image_button button" type="button" value="'.__('Choose Image','mnbaa_watermark').'" />
                    <small> <a href="#" class="custom_clear_image_button">'.__('Remove Image','mnbaa_watermark').'</a></small>
                    <br clear="all" />';
break;
            
            
        }//end switch
        
        echo '</td></tr>';
    }// end foreach
    echo '</table>';
    // end table
?>