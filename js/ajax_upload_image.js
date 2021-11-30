$(document).ready(function (e) {
// Function to preview image
	$(function() {
        $("#file").change(function() {
			$("#message").empty();         // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match= ["image/jpeg","image/png","image/jpg"];	
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
			{
			$('#previewing').attr('src','images/no_image.png');
			$("#message").html("圖片格式錯誤，圖片必須為jpeg、png、jpg");
			return false;
			}
            else
			{
                var reader = new FileReader();	
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }		
        });
    });
	function imageIsLoaded(e) { 
		$("#file").css("color","green");
        $('#image_preview').css("display", "block");
        $('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '250px');
		//$('#previewing').attr('height', '250px');
	};
});
