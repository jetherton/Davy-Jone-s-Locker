<?php
/**
 * @author John Etherton <john@ethertontech.com>
 * @copyright Etherton Technologies, Ltd. 2011
 */ 
?>
<?php if($form->more_than_one == '1'){?>
<div id="right_menu">
<ul>
<li>
<a class="button" href="<?php echo url::base();?>home/wish/add?form=<?php echo $form->id;?>"><?php echo __('add another :form', array(':form'=>$form->title));?></a>
</li>
</ul>
</div>
<?php }?>
<h2><?php echo $title; ?></h2>
<p><?php echo $form->description;?></p>

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
<?php echo Form::hidden('action', 'none', array('id'=>'action'));?>
<?php echo Form::hidden('is_add', $is_add ? '1' : '0', array('id'=>'is_add'));?>
	<table class="wish_edit">
		<tr>			
			<td>
				
			</td>
			<td rowspan="3" class="wish_accordion">
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
						 			$link_style = $friend->has('friends_wishes', $wish->id) ? '' : 'style="display:none;"';
						 			echo '- <a '.$link_style.' id="timing_link_'.$friend->id.'" href="#" onclick="showTiming('.$friend->id.'); return false;">'.__('timing').'</a>';
						 			$timing_view = new View('home/wish_timing');
						 			$timing_view->friend = $friend;
						 			$timing_view->wish = $wish;
						 			echo $timing_view;
						 			echo '</li>';
						 		}
						 	}?>
						 </ul>
					</div>
					<?php if($form->show_location == '1') {?>
					
					<h3><a href="#"><?php echo strlen($form->location_name) > 0 ? $form->location_name : __('location');?></a></h3>
					<div id="map_tab"  style="padding-top:0px;padding-bottom:0px;">
						<?php
						echo form::checkbox('use_location',
										'use_location', isset($location), 
										array('id'=>'use_location', 
											'onchange'=>"toggleUseLocation(); return false;"));
						echo __('use location');
						?>
						 <div id="map_panel">
							 <div id="map" class="map"></div>
							 <p></p>
							 <input rel="writehere|<?php echo __('search map'); ?>|cssoff|csson" style="width:150px;"id="map_search_input" name="map_search" onkeypress="return searchKeyPress(event,this);">
							 <input type="button" id="map_search_button" value="<?php echo __('search'); ?>" onclick="codeAddress(); return false;"/>
							 <input type="hidden" name="lat" id="lat" value="<?php echo isset($location) ? $location->lat : ''; ?>"/>
							 <input type="hidden" name="lon" id="lon" value="<?php echo isset($location) ? $location->lon : ''; ?>"/>
							 <input type="hidden" name="zoom" id="zoom" value="<?php echo isset($location) ? $location->zoom : ''; ?>"/>
							 <input type="hidden" name="map_type" id="map_type" value="<?php echo isset($location) ? $location->map_type : ''; ?>"/>
							 <input type="hidden" name="location_id" id="location_id" value="<?php echo isset($location) ? $location->id : 0; ?>"/>
						 </div>
					</div>
					<?php }?>
					<?php if($form->show_pictures == '1') {?>
					<h3><a href="#"><?php echo strlen($form->pictures_name) > 0 ? $form->pictures_name : __('pictures');?></a></h3>
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
						<div id="image_uploader">		
							<noscript>			
								<p>Please enable JavaScript to use file uploader.</p>
								<!-- or put a simple form for upload here -->
							</noscript>         
						</div>
					</div>
					<?php }?>
					<?php if($form->show_files == '1') {?>
					<h3><a href="#"><?php echo strlen($form->files_name) > 0 ? $form->files_name : __('files');?></a></h3>
					<div>
						<ul id="files">
							<?php foreach($files as $file) { ?>
								<li id="file_<?php echo $file->id;?>" class="file_thumb">				
									<?php echo $file->title; ?> 
									<span style="float:right;"><a href="#" onclick="deleteFile(<?php echo $file->id; ?>); return false;"><?php echo __('delete file'); ?></a></span>
									<br/>
									<?php echo __('insert'); ?> -- <a href="#" onclick="insertLink('<?php echo $file->get_link(); ?>', '<?php echo $file->title;?>'); return false;"><?php echo __('link');?> </a>
								</li>
							<?php } ?>
						</ul>
						 <div id="file_uploader">		
							<noscript>			
								<p>Please enable JavaScript to use file uploader.</p>
								<!-- or put a simple form for upload here -->
							</noscript>         
						</div>
					</div>
					<?php }?>
				</div>
			<td>
		</tr>
		<tr>
			<td>
				<?php echo Helper_Form::get_html_form($form, $wish); ?>
			</td>
		</tr>
		<tr>
			<td>
				<br/>
				<?php print Form::checkbox('show_notes','show_notes',strlen($wish->html)>0, array('id'=>'show_notes', 'onchange'=>'toggleNotes(); return false;')); ?>				
				<?php echo Form::label(__("notes"), ''.__("notes") . ':');  ?>
				<span class="form_description" title="<?php echo __('notes explanation');?>">&nbsp;</span>
				<br/>
				<br/>
				<div id="notes_area" <?php if(strlen($wish->html)<=0){echo 'style="display:none;"';}?>>
				<?php echo Form::textarea('html', isset($wish->html) ? $wish->html : null, array('id'=>'html', 'class'=>'tinymce', 'style'=>'width:650px; height:500px;'));?>
				</div>
			</td>
		</tr>
	</table>
	<br/>
	<br/>
	<?php echo Form::submit("wish_form",  $submit_button); ?> 
	<?php if($wish->is_live == '1')echo Form::input("wish_form",  __('delete wish'), array('onclick'=>'deleteWish(); return false;', 'type'=>'BUTTON')); ?>
			
<?php echo Kohana_Form::close(); ?>

<!-- overlayed element -->
<div class="apple_overlay" id="overlay">

	<!-- the external content is loaded inside this tag -->
	<div class="contentWrap"></div>

</div>
