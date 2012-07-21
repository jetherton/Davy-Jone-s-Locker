<?php 
	if($user->id == $passed->id)
	{ //the dead are checking their own page
		?>
		<div id="right_menu">
			<a href="<?php echo url::base();?>home/passed/notpassedaway"><?php echo __('i am not dead'); ?></a>
		</div>
		<?php 
	}
?>
<h1><?php echo __(":name passed away on :date", array(':name'=>$passed->full_name(), 
		':date'=>date('l, F jS Y',strtotime($passed->date_passed))));?></h1>
		
<h2><?php echo __('below is our record of :name\'s passing :passed_id', array(':name'=>$passed->full_name(), ':passed_id'=>$passed->id));?></h2>

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
		echo __(':passer confirmed this on :date at :time saying :note', array(
				':passer'=>$passer->full_name(),
				':date'=>date('l F jS Y',strtotime($passed_request->time)),
				':time'=>date('g:ia',strtotime($passed_request->time)),
				':note'=>$passed_request->note
		));
		
	}
	
	$i++;
	echo '</div>';
}?>

<p> <?php echo __('We are deeply sorry for your loss'); ?></p>