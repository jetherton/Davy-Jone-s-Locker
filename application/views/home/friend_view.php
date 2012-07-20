
<div id="right_menu">
	<?php
	
		echo form::open(null, array('id'=>'action_form'));
		if ($is_my_friend)
		{
			echo form::input('delete_friend', __('remove your friend'), array('type'=>'BUTTON', 'id'=>'delete_friend', 'onclick'=>'deleteYourFriend(); return false;'));
		}		
		if(isset($passer))
		{
			echo form::input('mark_passing', __('mark the passing passing of :friend', array(':friend'=>$friend->first_name)), array('type'=>'BUTTON', 'id'=>'mark_passing', 'onclick'=>'markPassing(); return false;'));
		}
		echo form::hidden('action', '', array('id'=>'action'));
		echo form::close();
 
	?>
</div>

		
<h2><?php echo $friend->first_name. ' '. $friend->last_name; ?></h2>

<p><?php echo __("friend view");?></p>


<h3><?php echo __('wishes :friend has shared with you', array(':friend'=>$friend->first_name . ' ' . $friend->last_name));?></h3>
<table class="list_table">
	<thead>
		<tr class="header">
			<th>
				<?php echo __('wish');?>
			</th>
			<th>
				<?php echo __('type');?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$wishes_friend = $wishes['from_friend'];
		if(count($wishes_friend) == 0)
		{
			echo '<tr><td colspan="3">'.$friend->first_name.__('has shared no wishes').'</td></tr>';
		}
		$i = 0;
		foreach($wishes_friend as $wish){
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

	<tr <?php echo $odd_row; ?>>
		<td>
			<?php //figure out why you're seeing this
				$can_view = false;
				switch($wish['timing_type'])
				{
					case '1':
						//has the user passed
						if($friend->date_passed != null)
						{
							$can_view = true;
						}
						break;
					case '2':
						//after certain date
						if(strtotime($wish['dead_line']) <= time())
						{
							$can_view = true;
						}
						break;
					case '3':
						//they can see it now
						$can_view = true;
						break;
				}
				
				if($can_view)
				{
			?>
			<a href="<?php echo url::base(). 'home/wish/view?id='.$wish['id']?>"> <?php echo Model_Wish::get_title_static($wish['id'], $wish['form_id']); ?></a>
			<?php }else{?>
			<span class="look_dont_touch"> <?php echo Model_Wish::get_title_static($wish['id'], $wish['form_id']); ?></span>
			<?php }?>
		</td>
		<td>
			<?php echo $wish['form_title'];?>
		</td>
	</tr>
	<?php }?>
	</tbody>
</table>
<br/><br/>

<h3><?php echo __('wishes you shared with :friend', array(':friend'=>$friend->first_name . ' ' . $friend->last_name));?></h3>
<table class="list_table">
	<thead>
		<tr class="header">
			<th>
				<?php echo __('wish');?>
			</th>
			<th>
				<?php echo __('tags');?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$wishes_me = $wishes['from_me'];
		if(count($wishes_me) == 0)
		{
			echo '<tr><td colspan="3">'.__('you have not shared any wishes with :friend',array(':friend'=>$friend->first_name)).'</td></tr>';
		}
		$i = 0;
		foreach($wishes_me as $wish){
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

		<tr <?php echo $odd_row; ?>>
			<td>
				<a href="<?php echo url::base(). 'home/wish/edit?id='.$wish->id?>"> <?php echo $wish->get_title();?></a>
			</td>
			<td>
				blank for now
			</td>
		</tr>
	<?php }?>
	</tbody>
</table>
