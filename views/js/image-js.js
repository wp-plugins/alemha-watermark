jQuery(function(jQuery) {
    jQuery('.custom_upload_image_button').click(function() {
		
        formfield = jQuery(this).siblings('.custom_upload_image');
        preview = jQuery(this).siblings('.custom_preview_image');
		image_url = jQuery(this).siblings('.custom_upload_image_url');
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        window.send_to_editor = function(html) {
		
            imgurl = jQuery('img',html).attr('src');
			width = jQuery('img',html).attr('width');
			height = jQuery('img',html).attr('height');
			
            classes = jQuery('img', html).attr('class');
            id = classes.replace(/(.*?)wp-image-/, '');
			
				jQuery.ajax({
					type : "post",
					 url: myAjax.ajaxurl,
					  data: {
						  
					action: "get_watermark_image",
				    id : id,
					width : width,
					height :height
				},
				
				success: function(response){
					//alert(response);
					if(response !=''){
						var arr = response.split('+');
						formfield.val(arr[0]);
            			preview.attr('src', arr[1]);
						image_url.val(arr[1]);
					}else{
						formfield.val(id);
           			 	preview.attr('src', imgurl);
						image_url.val(imgurl);
					}
					 }
			   });
			
            
            tb_remove();
        }
        return false;
    });
     
    jQuery('.custom_clear_image_button').click(function() {
        var defaultImage = jQuery(this).parent().siblings('.custom_default_image').text();
        jQuery(this).parent().siblings('.custom_upload_image').val('');
		jQuery(this).parent().siblings('.custom_upload_image_url').val('');
        jQuery(this).parent().siblings('.custom_preview_image').attr('src', defaultImage);
        return false;
    });
 
});

