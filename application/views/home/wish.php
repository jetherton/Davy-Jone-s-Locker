<?php if($cat->parent_id != 0){
echo '<div id="right_menu"><a href="'.url::base(). 'home/wish?cat='.$parent_cat->id.'">'.__('Back to :category', array(':category'=>$parent_cat->title)). '</a></div>';
}?>
		
<h1><?php echo $cat->title; ?></h1>

<p><?php echo $cat->description;?></p>

<div id="forms">
	<?php 
	
	//just do this to make things faster
	$form_to_wish = array();
	foreach($current_wishes as $wish)
	{
		$form_to_wish[$wish->form_id] = $wish;
	}
	
	foreach($make_form_list as $form) {
		
		//don't render this, if they've already entered this form type
		if(isset($form_to_wish[$form->id]))
		{
			continue;
		}
		
		$view = new View('home/block/form_block');
		$view->item = $form;
		echo $view;
		
	}?>
	<?php 
	foreach($current_wishes as $wish)
		{
			$view = new View('home/block/wish_block');
			$view->item = $wish;
			echo $view;
		}?>
	
</div>

<div class="start_blocks">

	<?php 
		srand(time());
		foreach($sub_cats as $sub_cat)
		{
	?>
	
		<h2 class="sub_cat_title"><a href="<?php echo url::base();?>home/wish?cat=<?php echo $sub_cat->id;?>"><?php echo $sub_cat->title; ?></a></h2>
		<p><?php echo $sub_cat->description;?></p>
		<div class="block_holder" id="block_container_<?php echo $sub_cat->id?>" >
		
		<?php
		if(count($wishes_for_cats[$sub_cat->id] ) == 0)
		{
			echo '<p>'.__('add something about :category_name by clicking here :category_id', array(':category_name'=>$sub_cat->title, ':category_id'=>$sub_cat->id)).'</p>';
		}
		foreach($wishes_for_cats[$sub_cat->id] as $wish_id=>$wish)
		{
			$view = new View('home/block/wish_block');
			$view->item = $wish;
			echo $view;
		}?>
		</div>
	<?php 
		}
	?>


</div>


