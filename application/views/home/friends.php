<div id="right_menu">
	<?php echo Kohana_Form::open(); ?>
		<?php echo Form::label('search_for_people_on_ekphora', __('search on ekphora'));  ?>
		<?php echo Form::input('search_term', null, array('id'=>'search_term'));?>
		<?php echo Form::input('friend_id', null, array('id'=>'friend_id'));?>
	<?php echo Kohana_Form::close(); ?>
	<div id="search_results"></div>
</div>
		
<h2><?php echo __("friends"); ?></h2>
<p><?php echo __("friends explanation");?></p>

<table class="list_table">
	<tr>
		<th>
			<?php echo __('friend');?>
		</th>
		<th>
			<?php echo __('groups');?>
		</th>		
	</tr>
	
	<?php
		if(count($friends) == 0)
		{
			echo '<tr><td colspan="3">'.__('you have no friends').'</td></tr>';
		}
		$i = 0;
		foreach($friends as $friend){
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

	<tr <?php echo $odd_row; ?>>
		<td>
			<a href="<?php echo url::base(). 'home/profile/view?id='.$friend->id?>"> <?php echo $friend->first_name . ' ' . $friend->last_name;?></a>
		</td>
		<td>
			Group info
		</td>
	</tr>
	<?php }?>
</table>
