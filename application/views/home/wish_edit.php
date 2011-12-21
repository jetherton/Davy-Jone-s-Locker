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
				<?php echo Form::hidden('is_add', $is_add ? '1' : '0', array('id'=>'is_add'));?>	
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
						 			echo form::checkbox('friend_'.$friend->id,
										'friend_'.$friend->id, 
										$friend->has('friends_wishes', $wish->id), 
										array('id'=>'friend_'.$friend->id, 
											'onchange'=>"modifyFriend(".$friend->id."); return false;"));
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
						<div id="images">
							<?php foreach($pictures as $pic) { ?>
								<div style="height:90px;" id="image_<?php echo $pic->id;?>" class="image_thumb">				
									<div style="float:left;">
										<img src="<?php echo $pic->full_web_thumbnail();?>" style="margin:3px;">
									</div>
									<?php echo $pic->title; ?> 
									<span style="float:right;"><a href="#" onclick="deletePic(<?php echo $pic->id; ?>); return false;"><?php echo __('delete picture'); ?></a></span>
									<br/>
									<?php echo __('insert'); ?> -- <a href="#" onclick="insertLink('<?php echo $pic->full_web_full_size(); ?>', '<?php echo $pic->title;?>'); return false;"><?php echo __('link');?> </a>, 
									<a href="#" onclick="insertImage('<?php echo $pic->full_web_thumbnail(); ?>', '<?php echo $pic->full_web_full_size(); ?>'); return false;"><?php echo __('thumbnail');?></a>, 
									<a href="#" onclick="insertImage('<?php echo $pic->full_web_passport(); ?>', '<?php echo $pic->full_web_full_size(); ?>'); return false;"><?php echo __('passport');?></a>, 
									<a href="#" onclick="insertImage('<?php echo $pic->full_web_full_size(); ?>', '<?php echo $pic->full_web_full_size(); ?>'); return false;"><?php echo __('full size');?></a>
								</div>
							<?php } ?>
						</div>
						<div id="image-uploader">		
							<noscript>			
								<p>Please enable JavaScript to use file uploader.</p>
								<!-- or put a simple form for upload here -->
							</noscript>         
						</div>
					</div>
					<h3><a href="#"><?php echo __('files');?></a></h3>
					<div>
						<div id="files">
							<?php foreach($files as $file) { ?>
								<div style="height:90px;" id="image_<?php echo $file->id;?>" class="image_thumb">				
									<?php echo $file->title; ?> 
									<span style="float:right;"><a href="#" onclick="deletePic(<?php echo $file->id; ?>); return false;"><?php echo __('delete picture'); ?></a></span>
									<br/>
									<?php echo __('insert'); ?> -- <a href="#" onclick="insertLink('<?php echo $file->get_link(); ?>', '<?php echo $file->title;?>'); return false;"><?php echo __('link');?> </a>, 
								</div>
							<?php } ?>
						</div>
						 <div id="file-uploader">		
							<noscript>			
								<p>Please enable JavaScript to use file uploader.</p>
								<!-- or put a simple form for upload here -->
							</noscript>         
						</div>
					</div>
				</div>
			<td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label(__("wish"), __("wish") . ':*');  ?>
				<br/>
				<?php echo Form::textarea('html', isset($wish->html) ? $wish->html : null, array('id'=>'html', 'class'=>'tinymce', 'style'=>'width:650px; height:500px;'));?>
			</td>
		</tr>
	</table>
	<br/>
	<br/>
	<?php echo Form::submit("wish_form",  $submit_button); ?> <?php if(isset($wish->title))echo Form::input("wish_form",  __('delete wish'), array('onclick'=>'deleteWish(); return false;', 'type'=>'BUTTON')); ?>
			
<?php echo Kohana_Form::close(); ?>
