<div class="wish_timing" style="display:none;" id="timing_<?php echo$friend->id;?>">
	<?php 
		//get the friend wish data
		$timing_data = ORM::factory('friendswishes')
			->where('wish_id', '=', $wish->id)
			->where('friend_id', '=', $friend->id)
			->find();
	?>
	<?php print form::label('timing_type_'.$friend->id,__('when do you want :firstname to see this information', array(':firstname'=>$friend->first_name)));?>
	<?php print form::select('timing_type_'.$friend->id, Model_Wish::$timing_types, $timing_data->timing_type, 
			array('onchange'=>'timingTypeChange('.$friend->id.'); return false;',
					'id'=>'timing_type_'.$friend->id))?>
	
	<div <?php echo $timing_data->timing_type != '2' ? 'style="display:none;"' : ''; ?> id="timing_date_<?php echo$friend->id;?>">
		<br/>
		<?php print form::label('dead_line_'.$friend->id, __('date when :firstname can see this', array(':firstname'=>$friend->first_name)));?>:
		<?php print form::input('dead_line_'.$friend->id, $timing_data->dead_line,array('id'=>'dead_line_'.$friend->id));?>
		
		<script type="text/javascript">
			$().ready(function() {
				$("#dead_line_<?php echo $friend->id?>").datepicker({ 
					showOn: "both", 
					buttonImage: "<?php echo url::base(); ?>media/img/icon-calendar.gif", 
					buttonImageOnly: true 
				});
			});
		</script>
		
	</div>
	
	<div  <?php echo $timing_data->timing_type == '3' ? 'style="display:none;"' : ''; ?>  id="timing_user_can_know_<?php echo$friend->id;?>">
		<br/>
		<?php print form::label('user_can_know_'.$friend->id, __('check if :firstname can know', array(':firstname'=>$friend->first_name)));?>:
		<?php print form::checkbox('user_can_know_'.$friend->id, 'user_can_know', $timing_data->user_can_know == '1', array('id'=>'user_can_know_'.$friend->id));?>
	</div>
	<input type="BUTTON" name="wish_form" value="<?php echo __('save');?>" onclick="setTiming(<?php echo$friend->id;?>); return false;"/>
	<div id="timing_spinner_<?php echo$friend->id;?>"></div>
</div>