<?php 
//handle the colors
	if(!isset($color))
	{
		$color = rand(50,150);
		$color = dechex($color);
		$color = strlen($color) == 1 ? '0'.$color : $color;
		$color = '#'.$color.$color.$color;
	}
	
	$background_image_text = '';
	if(isset($background_image))
	{
		$background_image_text = 'background-image: url(\''.$background_image.'\');';
	}
?>
<div class="block" style="background-color:<?php echo $color;?>; <?php echo $background_image_text;?>">
<?php echo $content;?>
</div>