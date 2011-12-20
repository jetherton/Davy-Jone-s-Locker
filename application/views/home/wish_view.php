<?php
/**
 * @author John Etherton <john@ethertontech.com>
 * @copyright Etherton Technologies, Ltd. 2011
 */ 
?>


<p style="margin-top:5px;"><?php echo __('by'). ' <a href="'.url::base().'home/friends/view?id='.$friend->id.'">' . $friend->first_name. ' ' . $friend->last_name. '</a>';?></p>

<div class="wish_view_frame">
<h2 ><?php echo __('wish'). ' - '. $wish->title; ?></h2>
<div >
	<?php echo $wish->html; ?>
</div>
<div style="clear:both;"></div>
</div>
<?php echo __('last edited'). ': '. Helper_Dates::mysql_date_to_string_formal($wish->date_modified);?>
