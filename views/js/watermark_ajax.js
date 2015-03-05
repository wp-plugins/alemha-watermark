jQuery(document).ready(function($){
    $('.my-color-field').wpColorPicker();
	$('.my-color-field_bg').wpColorPicker();
    $("#background").change(function(){
		$('.bg_tr').toggle();
		});	
	//
	$("input[value='watermark']").closest('form').submit(function( event ) {
		$('#rgb_ID').val(hexToRgb($('.my-color-field').val()));
		$('#rgb_bg_ID').val(hexToRgb($('.my-color-field_bg').val()));
	});
	
	//
	if($("#background").val()=='no'){
		$('.bg_tr').hide();
	}
	
});



function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})|([a-f\d]{1})([a-f\d]{1})([a-f\d]{1})$/i.exec(hex);
  return result ? {        
    r: parseInt(hex.length <= 4 ? result[4]+result[4] : result[1], 16),
    g: parseInt(hex.length <= 4 ? result[5]+result[5] : result[2], 16),
    b: parseInt(hex.length <= 4 ? result[6]+result[6] : result[3], 16),
    toString: function() {
      var arr = [];
      arr.push(this.r);
      arr.push(this.g);
      arr.push(this.b);
      return  arr.join(",");
    }
  } : null;
}