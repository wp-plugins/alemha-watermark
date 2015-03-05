<?php
function Mnbaa_Watermark_RunPlugin() {
	add_action( 'init', 'Mnbaa_Watermark_create_watermark' );
	add_action('add_meta_boxes', 'Mnbaa_Watermark_add_meta_box');
	//add color picker
	add_action( 'admin_enqueue_scripts', 'Mnbaa_Watermark_mw_enqueue_color_picker' );
	//image uploader
	add_action( 'admin_enqueue_scripts', 'Mnbaa_Watermark_load_admin_things' );
	//save custom post
	add_action('save_post', 'Mnbaa_Watermark_save_meta_box_data');
	//applay watermark in media uploader popup
	add_filter('media_send_to_editor', 'Mnbaa_Watermark_image', 10, 3);
	// insert watermark button into edit page
	add_filter('attachment_fields_to_edit', 'Mnbaa_Watermark_add_watermark_button', 10, 2);
	//watermark taxonomy
	add_action( 'init', 'Mnbaa_Watermark_categories', 0 );
	//remove premalink form watermark posts
	add_action('admin_head', 'wpds_custom_admin_post_css');
	//insert watermarek image in editor
	add_filter('image_send_to_editor', 'Mnbaa_Watermark_image_to_editor', 20, 8);
	//applay watermark in edit image
	add_action( 'edit_attachment', 'Mnbaa_Watermark_edit_image');
	
	add_action('wp_ajax_get_watermark_image', 'get_watermark_image');
}


// create watermark custom post
function Mnbaa_Watermark_create_watermark() {
    register_post_type('watermark', array(
        'labels' => array(
            'name' => __('Watermark', 'mnbaa_watermark'),
            'singular_name' => __('Watermark', 'mnbaa_watermark'),
            'edit_item' => __('Edit Watermark', 'mnbaa_watermark'),
            'new_item' => __('New Watermark', 'mnbaa_watermark'),
            'all_items' => __('All Watermarks', 'mnbaa_watermark'),
            'view_item' => __('View Watermark', 'mnbaa_watermark'),
            'add_new_item' => __('Add New Watermark', 'mnbaa_watermark'),
            'add_new' => __('Add New Watermark', 'mnbaa_watermark')
        ),
        
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => __('watermark','mnbaa_watermark')),
        'supports' => array('title'),
        'menu_position' => 75,
		
        
       )
    );
}

// add 5 meta box  for watermark custom post
function Mnbaa_Watermark_add_meta_box() {
	
    add_meta_box('custom_meta_box', __('Image sizes & Font Setting', 'mnbaa_watermark'), 'font_setting_metabox_callback', 'watermark', 'normal');
    add_meta_box('custom_meta_box2', __('Position Setting', 'mnbaa_watermark'), 'position_setting_metabox_callback', 'watermark', 'normal');
    add_meta_box('custom_meta_box3', __('Background Setting', 'mnbaa_watermark'), 'background_setting_metabox_callback', 'watermark', 'normal');
	add_meta_box('custom_meta_box4', __('Upload Image', 'mnbaa_watermark'), 'upload_image_metabox_callback', 'watermark', 'normal');
	add_meta_box('custom_meta_box5', __('Preview', 'mnbaa_watermark'), 'preview_metabox_callback', 'watermark', 'side');
}


function font_setting_metabox_callback($post) {
	echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
	include (plugin_dir_path(__FILE__) . '../views/font_setting.php');
}

function position_setting_metabox_callback($post) {
	include (plugin_dir_path(__FILE__) . '../views/position_setting.php');
}

function background_setting_metabox_callback($post){
	include (plugin_dir_path(__FILE__) . '../views/background_setting.php');
}

function upload_image_metabox_callback($post){
	include (plugin_dir_path(__FILE__) . '../views/img_upload.php');
}

function preview_metabox_callback(){
	include (plugin_dir_path(__FILE__) . '../views/preview.php');
}

//add color picker
function Mnbaa_Watermark_mw_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	
}

function Mnbaa_Watermark_load_admin_things() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
}

// save data of meta boxes
function Mnbaa_Watermark_save_meta_box_data($post_id) {
	
    global $font_setting_meta_fields, $position_setting_meta_fields, $background_setting_meta_fields, $img_upload_setting_meta_fields;
	$fields_array=array($font_setting_meta_fields,$position_setting_meta_fields,$background_setting_meta_fields,$img_upload_setting_meta_fields);
    if ( !isset( $_POST['custom_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['custom_meta_box_nonce'], basename( __FILE__ ) ) ) 
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('watermark' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
	
	foreach ($fields_array as $fields)
		save_meta_box_data($fields,$post_id);
	$old = get_post_meta($post_id, 'color', true);
    $new = $_POST['color'];

    if ($new && $new != $old) {
       update_post_meta($post_id, 'color', $new);
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, 'color', $old);
    }
	
	$old_color = get_post_meta($post_id, 'color_bg', true);
    $new_color = $_POST['color_bg'];

    if ($new_color && $new_color != $old_color) {
       update_post_meta($post_id, 'color_bg', $new_color);
    } elseif ('' == $new_color && $old_color) {
        delete_post_meta($post_id, 'color_bg', $old_color);
    }
	
	$old_mesaure_x = get_post_meta($post_id, 'mesaure_x', true);
    $new_mesaure_x = $_POST['mesaure_x'];

    if ($new_mesaure_x && $new_mesaure_x != $old_mesaure_x) {
       update_post_meta($post_id, 'mesaure_x', $new_mesaure_x);
    } elseif ('' == $new_mesaure_x && $old_mesaure_x) {
        delete_post_meta($post_id, 'mesaure_x', $old_mesaure_x);
    }
	
	$old_mesaure_y = get_post_meta($post_id, 'mesaure_y', true);
    $new_mesaure_y = $_POST['mesaure_y'];

    if ($new_mesaure_y && $new_mesaure_y != $old_mesaure_y) {
       update_post_meta($post_id, 'mesaure_y', $new_mesaure_y);
    } elseif ('' == $new_mesaure_y && $old_mesaure_y) {
        delete_post_meta($post_id, 'mesaure_y', $old_mesaure_y);
    }
	
	$old_img_mesaure_x = get_post_meta($post_id, 'img_mesaure_x', true);
    $new_img_mesaure_x = $_POST['img_mesaure_x'];

    if ($new_img_mesaure_x && $new_img_mesaure_x != $old_img_mesaure_x) {
       update_post_meta($post_id, 'img_mesaure_x', $new_img_mesaure_x);
    } elseif ('' == $new_img_mesaure_x && $old_img_mesaure_x) {
        delete_post_meta($post_id, 'img_mesaure_x', $old_img_mesaure_x);
    }
	
	$old_img_mesaure_y = get_post_meta($post_id, 'img_mesaure_y', true);
    $new_img_mesaure_y = $_POST['img_mesaure_y'];

    if ($new_img_mesaure_y && $new_img_mesaure_y != $old_img_mesaure_y) {
       update_post_meta($post_id, 'img_mesaure_y', $new_img_mesaure_y);
    } elseif ('' == $new_img_mesaure_y && $old_img_mesaure_y) {
        delete_post_meta($post_id, 'img_mesaure_y', $old_img_mesaure_y);
    }
	
	$preview=1;
	include (plugin_dir_path(__FILE__) . '../controllers/preview_watermark.php');
}

function save_meta_box_data($fields,$post_id){
	foreach ($fields as $field) {
		if($field['type']=='checkbox' && $field['name']=='img_sizes[]'){
			$new = json_encode($_POST['img_sizes']);
			update_post_meta($post_id,'img_sizes', $new);
		}else{
			$old = get_post_meta($post_id, $field['name'], true);
			$new = $_POST[$field['name']];
			update_post_meta($post_id, $field['name'], $new);
		}
        
    } 
   
}

//add watermark button to edit page
function Mnbaa_Watermark_add_watermark_button($form_fields, $post) {
	$media_type=$post->post_mime_type ;
	$args = array(
		'post_type' => 'watermark',
		'post_status' => 'publish'
	);
	$query = new WP_Query( $args );
	$Mnbaa_watermark_select = get_post_meta($post->ID, 'Mnbaa_watermark_select', true);
	if(($media_type == 'image/jpeg') || $media_type=='image/png' || $media_type=='image/png' ){		
		$form_fields["Mnbaa_watermark_select"]["label"] = __('Select watermark', 'mnbaa_watermark');
		$form_fields["Mnbaa_watermark_select"]["input"] = "html";
		$form_fields["Mnbaa_watermark_select"]["html"] = '<select name="attachments[' . $post->ID . '][Mnbaa_watermark_select]" id="Mnbaa_watermark_select" post_id="'.$post->ID.'">';
		$form_fields["Mnbaa_watermark_select"]["html"] .= '<option value="">'.__("Select your watermark", 'mnbaa_watermark').'</option>';
		while ( $query->have_posts() ) { $query->the_post();
		if($Mnbaa_watermark_select == $query->post->ID)
			$form_fields["Mnbaa_watermark_select"]["html"] .= '<option selected="selected" value="'.$query->post->ID.'">'.$query->post->post_title.'</option>';
			else
			  $form_fields["Mnbaa_watermark_select"]["html"] .= '<option value="'.$query->post->ID.'">'.$query->post->post_title.'</option>';
		}
		$form_fields["Mnbaa_watermark_select"]["html"].='</select>';
	
	} 
	 return array_reverse($form_fields);
		
}

function Mnbaa_Watermark_edit_image( $attachment_id) {
	
    if( isset($_POST['attachments'][$attachment_id]['Mnbaa_watermark_select'])){
        
		if($_POST['attachments'][$attachment_id]['Mnbaa_watermark_select']=='')
			delete_post_meta($attachment_id, 'Mnbaa_watermark_select');
		else
			update_post_meta($attachment_id, 'Mnbaa_watermark_select', $_POST['attachments'][$attachment_id]['Mnbaa_watermark_select']);	
		if($_POST['attachments'][$attachment_id]['Mnbaa_watermark_select'] !='')
			include (plugin_dir_path(__FILE__) . '../controllers/preview_watermark.php');
		
  }
}

// Register Custom Taxonomy
function Mnbaa_Watermark_categories() {

	$labels = array(
		'name'                       => __( 'Categories', 'Categories', 'mnbaa_watermark' ),
		'singular_name'              => __( 'Categories', 'Categories', 'mnbaa_watermark' ),
		'menu_name'                  => __( 'Categories', 'mnbaa_watermark' ),
		'all_items'                  => __( 'All Categories', 'mnbaa_watermark' ),
		'new_item_name'              => __( 'New Categories Name', 'mnbaa_watermark' ),
		'add_new_item'               => __( 'Add Categories Item', 'mnbaa_watermark' ),
		'edit_item'                  => __( 'Edit Categories', 'mnbaa_watermark' ),
		'update_item'                => __( 'Update Categories', 'mnbaa_watermark' ),
		'separate_items_with_commas' => __( 'Separate Categories with commas', 'mnbaa_watermark' ),
		'search_items'               => __( 'Search Categories', 'mnbaa_watermark' ),
		'add_or_remove_items'        => __( 'Add or remove Categories', 'mnbaa_watermark' ),
		'choose_from_most_used'      => __( 'Choose from the most used Categories', 'mnbaa_watermark' ),
		'not_found'                  => __( 'Not Found', 'mnbaa_watermark' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		
               
	);
	register_taxonomy( 'Categories', array( 'watermark' ), $args );

}

function wpds_custom_admin_post_css() {

    global $post_type;

    if ($post_type == 'watermark') {
        echo "<style>#edit-slug-box {display:none;}</style>";
    }
}

function Mnbaa_Watermark_image_to_editor($html, $id, $caption, $title, $align, $url, $size, $alt) {
	global $watermark_prefix;

    $attachment = get_post($id); //fetching attachment by $id passed through
    $mime_type = $attachment->post_mime_type; //getting the mime-type
    if (substr($mime_type, 0, 5) == 'image' && $attachment->post_parent !=0) { //checking mime-type
        
		$watermark_select = get_post_meta( $id, 'Mnbaa_watermark_select',true );
		$upload_dir = wp_upload_dir();	
		if(isset($watermark_select) && !(empty ($watermark_select))){
			
			$image_attributes = wp_get_attachment_image_src( $id,$size );
			$img_name= explode("/",$image_attributes[0]);
			$watermark_img_name = $watermark_prefix.end($img_name);
			
			$html = '<img src="'.$upload_dir['url'] . '/' . $watermark_img_name.'" width="'.$image_attributes[1].'" height="'.$image_attributes[2].'" alt="'.$alt.'" align="'.$align.'" />';
			
		}
        
    }
    return $html; // return new $html
}

function Mnbaa_Watermark_image($html, $send_id, $attachment) {
	$attachment_id=$send_id;
	
    if( isset($attachment['Mnbaa_watermark_select'])){
        
		if($attachment['Mnbaa_watermark_select']=='')
			delete_post_meta($attachment_id, 'Mnbaa_watermark_select');
		else
			update_post_meta($attachment_id, 'Mnbaa_watermark_select', $attachment['Mnbaa_watermark_select']);	
		if($attachment['Mnbaa_watermark_select'] !=''){
			include (plugin_dir_path(__FILE__) . '../controllers/preview_watermark.php');
			
		}
		
		
  }
  return $html;
 
}

?>