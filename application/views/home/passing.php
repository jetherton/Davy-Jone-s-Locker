<div id="right_menu">
	<a href="<?php echo url::base(). 'home/passing'; ?>"><?php  echo __("passing settings"); ?></a>
</div>

<h2><?php echo __("passing header"); ?></h2>
<p><?php echo __("passing explanation");?></p>





<?php if(count($errors) > 0 )
{
?>
	<div class="errors">
	<?php echo __("error"); ?>
		<ul>
<?php 
	foreach($errors as $error)
	{
?>
		<li> <?php echo $error; ?></li>
<?php
	} 
	?>
		</ul>
	</div>
<?php 
}
?>

<?php if(count($messages) > 0 )
{
?>
	<div class="messages">
		<ul>
<?php 
	foreach($messages as $message)
	{
?>
		<li> <?php echo $message; ?></li>
<?php
	} 
	?>
		</ul>
	</div>
<?php 
}
?>

<?php echo Kohana_Form::open(); ?>
<table class="formfields">
	<tr>
		<td class="formfieldlabel">
			<?php echo Form::label('min_passers', __("min number of passers"));  ?>
			<span class="form_description" title="<?php echo __('min number of passers detail'); ?>">&nbsp;</span>
		</td>
		<td>
			<?php echo Form::select('min_passers', array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10), $settings->min_passers ? $settings->min_passers : 0);?>
		</td>
	</tr>
	<tr>
		<td class="formfieldlabel">
			<?php echo Form::label('timeframe', __("passing time frame"));  ?>
			<span class="form_description" title="<?php echo __('passing time frame detail'); ?>">&nbsp;</span>
		</td>
		<td>
			<?php echo __('hours') . ' ' . Form::select('timeframe', array(12=>'12', 24=>'24', 36=>'36', 48=>'48', 72=>'72'), $settings->timeframe ? $settings->timeframe : 0);?>
		</td>
	</tr>
</table>

<?php echo Form::submit("profile_form",  __("update profile")); ?>
	
<br/>
<br/>
<div id="passer_table">
<?php
//the passer list
	$passer_list = new View('home/passers_list');
	$passer_list->passers = $passer; 
	echo $passer_list;

?>
</div>
			
<?php echo Kohana_Form::close(); ?>

<!-- overlayed element -->
<div class="apple_overlay" id="overlay">

	<!-- the external content is loaded inside this tag -->
	<div class="contentWrap"></div>

</div>

