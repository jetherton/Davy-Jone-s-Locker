<?php
/**
 * @author John Etherton <john@ethertontech.com>
 * @copyright Etherton Technologies, Ltd. 2011
 */ 
?>

<h2><?php echo $title; ?></h2>
<p><?php echo $explanation;?></p>

<h4 class="whats_required"><?php echo __("whats required");?></h4>

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

<form method="POST" action="<?php echo url::base().'home/wish/edit?id='. $wish->id;?>" id="wish_edit_form" accept-charset="utf-8">
	<table class="wish_edit">
		<tr>
			<td>			
				<?php echo Form::hidden('action', 'none', array('id'=>'action'));?>
				<?php echo Form::label("title", __("title"). ':*');  ?>
				<br/>				
				<?php echo Form::input('title', isset($wish->title) ? $wish->title : null, array('id'=>'title'));?>
			</td>
			<td rowspan="2" class="wish_accordion">
				<div id="accordion" class="wish_accordion">
					<h3><a href="#"><?php echo __('who can view');?></a></h3>
					<div>						
						 <ul>
						 	<?php if(count($friends) < 1){?>
						 	<li> <?php echo __('you have no friends');?>
						 	<?php }
						 	else
						 	{
						 		foreach($friends as $friend)
						 		{
						 			echo '<li id="friend_item_'.$friend->id.'">';
						 			echo form::checkbox('friend_'.$friend->id,'friend_'.$friend->id, $friend->has('friends_wishes', $wish->id), array('id'=>'friend_'.$friend->id, 'onchange'=>"modifyFriend(".$friend->id."); return false;"));
						 			echo $friend->first_name . ' ' . $friend->last_name;
						 			echo '</li>';
						 		}
						 	}?>
						 </ul>
					</div>
					<h3><a href="#"><?php echo __('tags');?></a></h3>
					<div>
						 some tag stuff here
					</div>
					<h3><a href="#"><?php echo __('location');?></a></h3>
					<div>
						 add a map
					</div>
					<h3><a href="#"><?php echo __('pictures');?></a></h3>
					<div>
						 code to add pictures
					</div>
					<h3><a href="#"><?php echo __('files');?></a></h3>
					<div>
						 code to add files
					</div>
				</div>
			<td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label(__("wish"), __("wish") . ':*');  ?>
				<br/>
				<?php echo Form::textarea('html', isset($wish->html) ? $wish->html : null, array('class'=>'tinymce', 'style'=>'width:650px; height:500px;'));?>
			</td>
		</tr>
	</table>
	<br/>
	<br/>
	<?php echo Form::submit("wish_form",  $submit_button); ?> <?php if(isset($wish->title))echo Form::input("wish_form",  __('delete wish'), array('onclick'=>'deleteWish(); return false;', 'type'=>'BUTTON')); ?>
			
<?php echo Kohana_Form::close(); ?>