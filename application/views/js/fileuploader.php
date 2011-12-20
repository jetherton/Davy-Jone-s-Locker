  <script type="text/javascript">
  $(document).ready(function() {
	  
	  var uploader = new qq.FileUploader({
          element: document.getElementById('<?php echo $element_id; ?>'),
          action: '<?php echo url::base();?>home/wish/imageuploader/?wish_id=<?php echo $wish_id; ?>',
          debug: false,
          allowedExtensions: <?php echo isset($extensions) ?  '['.implode(',',$extensions). ']' : '[]';?>,
          onComplete: function(id, fileName, responseJSON){
				console.log(responseJSON);
				$("#images").append('<div style="height:90px;" class="image_thumb"><div style="float:left;"><img src="<?php echo url::base();?>uploads/'+responseJSON['thumbnail_file_name']+'" style="margin:3px;"></div>'+responseJSON['title']+'</div>');
				$(".qq-upload-list").delay(1000).fadeOut(500);
			  }
      });           
    
  });
  </script>
