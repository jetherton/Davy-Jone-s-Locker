  <script type="text/javascript">
  $(document).ready(function() {
	  
	  var uploader = new qq.FileUploader({
          element: document.getElementById('<?php echo $element_id; ?>'),
          action: '<?php echo url::base();?>home/profile/imageuploader/?user_id=<?php echo $user_id; ?>',
          debug: false,
          allowedExtensions: <?php echo isset($extensions) ?  '['.implode(',',$extensions). ']' : '[]';?>,
          onComplete: function(id, fileName, responseJSON){
				if(responseJSON['success'])
				{
					var imageHtml = '<img src="'+responseJSON['picture'] + '" />';											
					$("#profile_image").html(imageHtml);
				}
				$(".qq-upload-list").delay(1000).fadeOut(500);
				$("li.qq-upload-success").delay(1050).remove();
				$("li.qq-upload-fail").delay(1050).remove();
			  },
		onSubmit:function(id, fileName){$(".qq-upload-list").fadeIn(100);}
      });           
    
  });
  
  function deletePic(id)
  {
	  $.post("<?php echo url::base();?>home/profile/deleteimage", {'id':id}, function (data){
			if(data.status == "success")
			{
				$("#image_"+id).fadeOut(500);
			}
		  }, 'json');
  }
  </script>
