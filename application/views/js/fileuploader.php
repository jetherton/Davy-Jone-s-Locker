  <script type="text/javascript">
  $(document).ready(function() {
	  
	  var uploader = new qq.FileUploader({
          element: document.getElementById('<?php echo $element_id; ?>'),
          action: '<?php echo url::base();?>home/wish/fileuploader/?wish_id=<?php echo $wish_id; ?>',
          debug: false,
          allowedExtensions: <?php echo isset($extensions) ?  '['.implode(',',$extensions). ']' : '[]';?>,
          onComplete: function(id, fileName, responseJSON){
				if(responseJSON['success'])
				{
					var fileHtml = '<div id="image_'+responseJSON['id']+'" style="height:90px;" class="image_thumb"><div style="float:left;">';
					fileHtml += '<img src="'+responseJSON['thumbnail'] + '"';
					fileHtml += ' style="margin:3px;"></div>'+responseJSON['title'];
					fileHtml += '<span style="float:right;"><a href="#" onclick="deletePic('+responseJSON['id']+'); return false;">';
					fileHtml += '<?php echo __('delete picture'); ?></a></span>';				
					fileHtml += '<?php echo __('insert'); ?> -- <a href="#" onclick="insertLink(\''+responseJSON['link']+'\', \''+responseJSON['title']+'\'); return false;"><?php echo __('link');?> </a>';
					fileHtml +='</div>';							
					$("#images").append(fileHtml);
				}
				$(".qq-upload-list").delay(1000).fadeOut(500);
			  }
      });           
    
  });
  
  function deletePic(id)
  {
	  $.post("<?php echo url::base();?>home/wish/deleteimage", {'id':id}, function (data){
			if(data.status == "success")
			{
				$("#image_"+id).fadeOut(500);
			}
		  }, 'json');
  }
  </script>
