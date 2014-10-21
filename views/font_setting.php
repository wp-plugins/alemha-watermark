<?php
global $font_setting_meta_fields, $post;
    // Use nonce for verification
    
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($font_setting_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['name'], true);
		$meta_size = json_decode(get_post_meta($post->ID, 'img_sizes', true));
		$img_sizes=array('thumbnail','medium','large','full');
        //echo $meta;
        // begin a table row with
        echo '<tr><th><label for="' . $field['name'] . '">' . __($field['label'], 'mnbaa_watermark') . '</label></th><td>';
        switch ($field['type']) {
			
			case 'text' :
					Mnbaa_Watermark_large_input($field['name'], $meta);
			break;
			case 'checkbox':
				foreach($img_sizes as $img_size){
					if(!isset($meta_size)){
						echo '<input type="checkbox" value="'.$img_size.'" name="'.$field['name'].'" id="'.$field['name'].'" checked="checked" />
							<label for="'.$img_size.'">'.$img_size.'</label>';
					}
					elseif(isset($meta_size)&&in_array($img_size,$meta_size)){
						echo '<input type="checkbox" value="'.$img_size.'" name="'.$field['name'].'" id="'.$field['name'].'" checked="checked" />
							<label for="'.$img_size.'">'.$img_size.'</label>';
					}else{
						echo '<input type="checkbox" value="'.$img_size.'" name="'.$field['name'].'" id="'.$field['name'].'" />
							<label for="'.$img_size.'">'.$img_size.'</label>';
					}
				}
			break;

            case 'select' :
               echo '<select name="'.$field['name'].'" id="'.$field['name'].'">';
				foreach ($field['options'] as $option) {
					echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
				}
				echo '</select><br /><span class="description">'.__($field['desc'], 'mnbaa_watermark').'</span>';
			break;
			
			case 'hidden' :
                Mnbaa_Watermark_hidden($field['name'], $meta);
            break;
			
            
            
        }//end switch
        
        echo '</td></tr>';
    }// end foreach
	$color=get_post_meta($post->ID, 'color', true); 
	if($color=='') $color='#260118';
	echo '<tr><th><label for="color">' . __("Select font color", 'mnbaa_watermark') . '</label></th><td>';
	echo '<input type="text" value="'.$color.'" class="my-color-field" name="color" />';
	echo '</td></tr>';
    echo '</table>';
    // end table
?>