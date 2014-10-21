<?php
global $position_setting_meta_fields, $post;
    // Use nonce for verification
    //echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($position_setting_meta_fields as $field) {
        // get value of this field if it exists for this post
        $positon_meta = get_post_meta($post->ID, $field['name'], true);
		$mesaure_x_meta = get_post_meta($post->ID, 'mesaure_x', true);
		$mesaure_y_meta = get_post_meta($post->ID, 'mesaure_y', true);  
        echo '<tr><th><label for="' . $field['name'] . '">' . __($field['label'], 'mnbaa_watermark') . '</label></th><td>';
        switch ($field['type']) {
			
			case 'text' :
				if($field['name']=='destance_x'){
					Mnbaa_Watermark_small_input($field['name'], $positon_meta);
					//echo'<br /><span class="description">' . $field['desc'] . '</span>';
					echo '<select name="mesaure_x" id="mesaure_x">';
					echo '<option', $mesaure_x_meta == "px" ? ' selected="selected"' : '', ' value="px">px</option>';
					echo '<option', $mesaure_x_meta == "%" ? ' selected="selected"' : '', ' value="%">%</option>';
					echo '</select><br />';
				}elseif($field['name']=='padding'){
					Mnbaa_Watermark_small_input($field['name'], $positon_meta);
					echo '<select name="mesaure_y" id="mesaure_y">';
					echo '<option', $mesaure_y_meta == "px" ? ' selected="selected"' : '', ' value="px">px</option>';
					echo '<option', $mesaure_y_meta == "%" ? ' selected="selected"' : '', ' value="%">%</option>';
					echo '</select><br />';
				}else{
					Mnbaa_Watermark_small_input($field['name'], $positon_meta);
					echo'<br /><span class="description">' . __($field['desc'], 'mnbaa_watermark') . '</span>';
				}
                break;

            case 'select' :
               echo '<select name="'.$field['name'].'" id="'.$field['name'].'">';
			   if($field['name']=='opicity'){
				  
				   for ($i=100; $i>=5; $i-=5){
					   
						echo '<option', $positon_meta == $i ? ' selected="selected"' : '', ' value="'.$i.'">'.$i."%".'</option>';
					}
			   }else{
					foreach ($field['options'] as $option) {
						echo '<option', $positon_meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.__($option['label'],'mnbaa_watermark').'</option>';
					}
			   }
				echo '</select><br /><span class="description">'.__($field['desc'], 'mnbaa_watermark').'</span>';
			break;
            
            
        }//end switch
        
        echo '</td></tr>';
    }// end foreach
    echo '</table>';
    // end table
?>