
<?php
	$classes_str =  implode(' ', $classes);
?>
<div class="block <?php echo$classes_str; ?>" <?php 
	if(isset($background_image)){
		echo 'style="background-image: url(\''.$background_image.'\');"';}?>>
<?php echo $content;?>
</div>