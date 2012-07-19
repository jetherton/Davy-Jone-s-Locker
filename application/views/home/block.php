<div class="block" style="background-color:<?php echo $color;?>; <?php //if(strlen($wish->title) > 15){echo 'width:200px;';}?>">
<h3>
<a href="<?php echo url::base().'home/wish/view?id='.$wish->id;?>">
	<?php echo $wish->title; ?>
</a>
</h3>

<a href="<?php echo url::base().'home/wish/view?id='.$wish->id;?>">
	<?php  echo $wish->form->title; ?>
</a>

</div>