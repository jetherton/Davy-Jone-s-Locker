<h2><?php echo __("page not found - 404"); ?></h2>
<p><?php echo __("sorry we can't seem to find what you were looking for");?></p>
<p><?php echo Arr::get($_SERVER, 'REQUEST_URI');?>

<p>
<?php echo __('back button')?><a href="<?php echo url::base(); ?>" > <?php echo __("home");?></a>
</p>



