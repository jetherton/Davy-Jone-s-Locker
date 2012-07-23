
<h2><?php echo __("confirming the passing of :passed", array(':passed'=>$passed->full_name()));?></h2>






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




<?php 
$i = 0;
foreach($passed_requests as $passed_request) {
	echo '<div class="passed_info">';
	$passer = ORM::factory('user', $passed_request->passer_id);
	if($i == 0)
	{
		echo __(':passer first marked passing of :passed on :date at :time saying :note :passed_id', array(
				':passer'=>$passer->full_name(),
				':passed'=>$passed->full_name(),
				':passed_id'=>$passed->id,
				':date'=>date('l F jS Y',strtotime($passed_request->time)),
				':time'=>date('g:ia',strtotime($passed_request->time)),
				':note'=>$passed_request->note
				));
	}
	else
	{
		if($passed_request->confirm == '1')
		{
			echo __(':passer confirmed this on :date at :time saying :note', array(
					':passer'=>$passer->full_name(),
					':passed'=>$passed->full_name(),
					':passed_id'=>$passed->id,
					':date'=>date('l F jS Y',strtotime($passed_request->time)),
					':time'=>date('g:ia',strtotime($passed_request->time)),
					':note'=>$passed_request->note
			));
		}
		
		if($passed_request->confirm == '0')
		{
			echo __(':passer denied this on :date at :time saying :note', array(
					':passer'=>$passer->full_name(),
					':passed'=>$passed->full_name(),
					':passed_id'=>$passed->id,
					':date'=>date('l F jS Y',strtotime($passed_request->time)),
					':time'=>date('g:ia',strtotime($passed_request->time)),
					':note'=>$passed_request->note
			));
		}
		
	}
	
	$i++;	
	echo '</div>';
}?>


<?php if(!$already_requested) {?>
<?php if($passed->id == $user->id){?>
<p><?php echo __("If you have acutally passed away please confirm this. If not then please deny and write a note for our records");?></p>
<?php } else {?>
<p><?php echo __("passed confirm explanation :passed", array(':passed'=>$passed->full_name(), ':possessive'=>$passed->get_gender_possessive()));?></p>
<?php }?>
<?php echo Kohana_Form::open(); ?>
<table class="formfields">
	<tr>
		<td class="formfieldlabel">
			<?php if($passed->id == $user->id){
				echo Form::label('confirm', __("do you confirm that you have passed")); 
			}
			else
			{
				echo Form::label('confirm', __("do you confirm that :passed has passed", array(':passed'=>$passed->full_name())));
			}?>
		</td>
		<td>
			<?php echo Form::radio('confirm', 1)  . ''. __('yes') ; ?>
			<?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. Form::radio('confirm', 0). ''.__('no')  ; ?>
		</td>
	</tr>
	<tr>
		<td class="formfieldlabel">
			<?php echo Form::label('note', __("note"));  ?>
		</td>
		<td>
			<?php echo Form::textarea('note',''); ?>
		</td>
	</tr>
</table>

<?php echo Form::submit("passed_form",  __("submit")); ?>
<?php }?>	


			
<?php echo Kohana_Form::close(); ?>

