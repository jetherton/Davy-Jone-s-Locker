<?php
/**
 * @author John Etherton <john@ethertontech.com>
 * @copyright Etherton Technologies, Ltd. 2011
 */ 
?>




<div class="wish_view_frame">
<?php if($user->id == $wish-> user_id) { ?>
<div id="right_menu">
<ul>
<li>
<?php echo ' <a class="button" href="'.url::base().'home/wish/edit?id='.$wish->id.'">' .__('edit'). '</a>';?>
</li>
</ul>
</div>

<?php } else {?>
<p style="margin-top:5px;"><?php echo __('by'). ' <a href="'.url::base().'home/friends/view?id='.$friend->id.'">' . $friend->first_name. ' ' . $friend->last_name. '</a>';?></p>
<?php }?>
<h2 ><?php $wish_title = $wish->get_title(); echo $wish_title; ?></h2>
<p><?php echo $form->description_reader;?></p>
<div >
	<?php echo Helper_Form::get_html($form, $wish, $user); ?>
	<br/>
	<?php if(strlen($wish->html) > 0) {?>
		<h3><?php echo __('notes');?>:</h3>
		<?php echo $wish->html; ?>
	<?php }?>
</div>
<div style="clear:both;"></div>
</div>

<?php if(isset($location)) { ?>
<div class="wish_view_frame ">
	<h3><?php echo strlen($form->location_name) > 0 ? $form->location_name : __('location');?>:</h3>
	<div id="map" style="height:250px;width:100%;border:solid 1px black;">
	
	</div>
</div>
<?php } ?>

<?php if(count($pictures) > 0) { ?>
<div class="wish_view_frame ">
	<h3><?php echo strlen($form->pictures_name) > 0 ? $form->pictures_name : __('pictures');?></h3>
	<div class="scrollable">
		<table class="picture_horizontal_list">
			<tr>
				<?php foreach($pictures as $pic) { ?>
					<td>
						<a href="<?php echo $pic->full_web_full_size(); ?>"><img src="<?php echo $pic->full_web_thumbnail();?>"/></a>
					</td>
				<?php } ?>
			</tr>
			<tr>
				<?php foreach($pictures as $pic) { ?>
					<td>
						<?php echo $pic->title; ?>
					</td>
				<?php } ?>
			</tr>
		</table>
	</div>
</div>
<?php } ?>

<?php if(count($files) > 0) { ?>
<div class="wish_view_frame scrollable">
	<h3><?php echo strlen($form->files_name) > 0 ? $form->files_name : __('files');?></h3>
	<div class="scrollable">
		<table class="picture_horizontal_list">
			<tr>
				<?php foreach($files as $file) { ?>
					<td>
						<a href="<?php echo $file->get_link(); ?>"><?php echo $file->title . '.' . $file->get_extension() ;?></a>
					</td>
				<?php } ?>
			</tr>
		</table>
	</div>
</div>
<?php } ?>
<?php echo __('last edited'). ': '. Helper_Dates::mysql_date_to_string_formal($wish->date_modified);?>
