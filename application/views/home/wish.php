<?php if($cat->parent_id != 0){
echo '<div id="right_menu"><a href="'.url::base(). 'home/wish?cat='.$parent_cat->id.'">'.__('Back to :category', array(':category'=>$parent_cat->title)). '</a></div>';
}?>
		
<h1><?php echo $cat->title; ?></h1>

<p><?php echo $cat->description;?></p>

<div id="forms">
	<?php foreach($make_form_list as $form) {
		echo '<div class="block form_block">';
		echo '<a href="'.url::base().'home/wish/add?form='.$form->id.'">'.__('Add information about'). ' '. $form->title.'</a>';
		echo '</div>';
	}?>
	<?php 
	foreach($current_wishes as $wish)
		{
			$color = rand(75,150);
			$color = dechex($color);
			$color = strlen($color) == 1 ? '0'.$color : $color;
			$color = '#'.$color.$color.$color;
			
			$view = new View('home/block');
			
			$view->wish = $wish;			
			$view->color = $color;
			
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
		<div class="block_holder" id="block_container_<?php echo $sub_cat->id?>" >
		
		<?php
		if(count($wishes_for_cats[$sub_cat->id] ) == 0)
		{
			echo '<p>'.__('add something about :category_name by clicking here :category_id', array(':category_name'=>$sub_cat->title, ':category_id'=>$sub_cat->id)).'</p>';
		}
		foreach($wishes_for_cats[$sub_cat->id] as $wish_id=>$wish)
		{
			$color = rand(75,150);
			$color = dechex($color);
			$color = strlen($color) == 1 ? '0'.$color : $color;
			$color = '#'.$color.$color.$color;
			
			$view = new View('home/block');
			
			$view->wish = $wish;			
			$view->color = $color;
			
			echo $view;
		}?>
		</div>
	<?php 
		}
	?>


</div>


