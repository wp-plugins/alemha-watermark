<?php
global $background_setting_meta_fields, $post;
    // Use nonce for verification
    //echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($background_setting_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['name'], true);
        //echo $meta;
        // begin a table row with
		if($field['name']=='bg_destance_x' || $field['name']=='bg_padding')
			$class="bg_tr";
        echo '<tr class="'.$class.'"><th><label for="' . $field['name'] . '">' . __($field['label'], 'mnbaa_watermark') . '</label></th><td>';
        switch ($field['type']) {

			case 'text' :
					Mnbaa_Watermark_small_input($field['name'], $meta);
			break;
			
            case 'select' :
               echo '<select name="'.$field['name'].'" id="'.$field['name'].'">';
				foreach ($field['options'] as $option) {
					echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.__($option['label'],'mnbaa_watermark').'</option>';
				}
				echo '</select><br /><span class="description">'.__($field['desc'], 'mnbaa_watermark').'</span>';
			break;
			
			case 'hidden' :
                Mnbaa_Watermark_hidden($field['name'], $meta);
            break;
            
            
        }//end switch
        
        echo '</td></tr>';
    }// end foreach
	$color_bg=get_post_meta($post->ID, 'color_bg', true); 
	if($color_bg=='') $color_bg='#ff0000';
	echo '<tr class="bg_tr"><th><label for="color">' . __("Select font color", 'mnbaa_watermark') . '</label></th><td>';
	echo '<input type="text" value="'.$color_bg.'" class="my-color-field_bg" name="color_bg" />';
	echo '</td></tr>';
    echo '</table>';
    // end table
?>