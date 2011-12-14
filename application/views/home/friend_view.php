<?php if ($is_my_friend){?>
<div id="right_menu">
		<?php
		echo form::open(null, array('id'=>'action_form'));
		echo form::input('delete_friend', __('remove your friend'), array('type'=>'BUTTON', 'id'=>'delete_friend', 'onclick'=>'deleteYourFriend(); return false;'));
		echo form::hidden('action', '', array('id'=>'action'));
		echo form::close(); 
	?>
</div>
<?php }?>
		
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
				<?php echo __('tags');?>
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
			<a href="<?php echo url::base(). 'home/wish/view?id='.$wish->id?>"> <?php echo $wish->title;?></a>
		</td>
		<td>
			blank for now
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
				<a href="<?php echo url::base(). 'home/wish/edit?id='.$wish->id?>"> <?php echo $wish->title;?></a>
			</td>
			<td>
				blank for now
			</td>
		</tr>
	<?php }?>
	</tbody>
</table>
