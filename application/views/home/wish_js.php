<script type="text/javascript">
$(document).ready(function() 
{
	<?php foreach( $sub_cats as $sub_cat){
	?>

	$('#block_container_<?php echo $sub_cat->id;?>').masonry({
		  itemSelector: '.block'
		});
	

	<?php }?>	


	$('#forms').masonry({
		  itemSelector: '.block'
		});
	
});


</script>
