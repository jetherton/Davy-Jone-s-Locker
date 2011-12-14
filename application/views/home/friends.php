<div id="right_menu">

	<div id="search_wait"></div>

		<?php echo Form::label('search_for_people_on_ekphora', __('search on ekphora'));  ?>
		<?php echo Form::input('search_term', null, array('id'=>'search_term', 'style'=>'width:100%;'));?>
		<?php echo Form::hidden('friend_id', null, array('id'=>'friend_id'));?>

	<div id="friend_search_results" style="display:none;">
		<?php echo __('do you want to add');?><br/><span id="friend_name"></span><br/><?php echo __('as a friend');?><br/>
		<input type="BUTTON" value="<?php echo __('yes');?>" onclick="add_friend(); return false;"/>
		<input type="BUTTON" value="<?php echo __('no'); ?>" onclick="clear_friends(); return false;"/>
	</div>
</div>
		
<h2><?php echo __("friends"); ?></h2>
<p><?php echo __("friends explanation");?></p>
<div id="friend_list">
	<?php
		//create the table view
		$view = view::factory('home/friends_list');
		$view->friends = $friends;
		echo $view; 
	?>
</div>
