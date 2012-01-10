<?php
/**
 * @author John Etherton <john@ethertontech.com>
 * @copyright Etherton Technologies, Ltd. 2011
 */ 
?>


<p style="margin-top:5px;"><?php echo __('by'). ' <a href="'.url::base().'home/friends/view?id='.$friend->id.'">' . $friend->first_name. ' ' . $friend->last_name. '</a>';?></p>

<div class="wish_view_frame">
<h2 ><?php echo $wish->title; ?></h2>
<div >
	<?php echo Helper_Form::get_html($form, $wish); ?>
	<br/>
	<h3><?php echo __('notes');?>:</h3>
	<?php echo $wish->html; ?>
</div>
<div style="clear:both;"></div>
</div>

<?php if(isset($location)) { ?>
<div class="wish_view_frame ">
	<h3><?php echo __('location'); ?>:</h3>
	<div id="map" style="height:250px;width:100%;border:solid 1px black;">
	
	</div>
</div>
<?php } ?>

<?php if(count($pictures) > 0) { ?>
<div class="wish_view_frame ">
	<h3><?php echo __('wishes pictures'); ?></h3>
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
	<h3><?php echo __('wishes files'); ?></h3>
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
