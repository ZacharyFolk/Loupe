jQuery(document).ready(function() {
 
jQuery('#upload_image_button').click(function() {
		window.send_to_editor = function(html) {
		 imgurl = jQuery('img',html).attr('src');
		 jQuery('#single_photo').val(imgurl);
		 tb_remove();		
		}

	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 return false;
	});

});
