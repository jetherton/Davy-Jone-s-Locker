<h2><?php echo __("page not found - 404"); ?></h2>
<p><?php echo __("sorry we can't seem to find what you were looking for");?></p>

<?php if(count($errors) > 0 )
{
?>
	<ul class="errors">
<?php 
	foreach($errors as $error)
	{
?>
	<li> <?php echo $error; ?></li>
<?php
	} 
	?>
	</ul>
<?php 
}
?>

<a href="<?php echo url::base(); ?>" > <?php echo __("home");?></a>

