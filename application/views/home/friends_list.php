

<table class="list_table">
	<thead>
		<tr class="header">
			<th style="width:200px;">
				<?php echo __('friend');?>
			</th>
			<th style="width:200px;">
				<?php echo __('relationship');?>
			</th>		
			<th style="width:300px;">
				<?php echo __('groups');?>
			</th>		
		</tr>
	</thead>
	<tbody>
	<?php
		if(count($friends) == 0)
		{
			echo '<tr><td colspan="3">'.__('you have no friends').'</td></tr>';
		}
		$i = 0;
		foreach($friends as $friend_a){
			$friend = $friend_a['friend'];
			$relationship = $friend_a['relationship'];
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

	<tr <?php echo $odd_row; ?>>
		<td style="width:200px;">
			<a href="<?php echo url::base(). 'home/friends/view?id='.$friend->id?>"> <?php echo $friend->first_name . ' ' . $friend->last_name;?></a>
			<?php if($relationship == Model_Friend::$THEIR_FRIEND){?>
			<a title="<?php echo __('add :friend as friend', array(':friend'=> $friend->full_name()));?>" style="float:right;" href="#" onclick="add_friend_id(<?php echo $friend->id;?>); return false;">+</a>
			<?php }?>
		</td>
		<td style="width:200px;">
			<?php
				if($relationship == Model_Friend::$MY_FRIEND)
				{
					echo '&lt;-- :: '.__('my friend');
				}
				else if($relationship == Model_Friend::$THEIR_FRIEND)
				{
					echo '--&gt; :: '.__('his her friend');
				} 
				else 
				{
					echo '&lt;-- --&gt; :: '.__('both friends');
				}
			?>
		</td>
		<td style="width:300px;">
			Group info
		</td>
	</tr>
	<?php }?>
	</tbody>
</table>
