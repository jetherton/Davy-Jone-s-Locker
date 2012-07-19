<h1><?php echo __('welcome home :user', array(":first_name"=>"$user->first_name"))?></h1>


<h2 class="sub_cat_title"><a href="<?php echo url::base();?>home/updates"><?php echo __('updates');?></a></h2>
<div id="update_container" class="block_holder">
	<?php if(count($updates) == 0)
				{
					
				}
			else
				{
					foreach($updates as $update)
					{
						
						$view = new View('home/block/update_block');
						$view->item = $update;	
						
						echo $view;
					}
				}
				?>
				
</div>
<a href="<?php echo url::base();?>home/updates"><?php echo __('more...')?></a>

<h2 class="sub_cat_title"><a href="<?php echo url::base();?>home/wishes"><?php echo __('your wishes');?></a></h2>
<div id="wish_container" class="block_holder">
<?php if(count($wishes) == 0)
				{
					echo __('you have no wishes');
				}
				else
				{
					foreach($wishes as $wish)
					{
						if(intval($wish->is_live) == 1)
						{
							$view = new View('home/block/wish_block');
							$view->item = $wish;
							echo $view;
						}
						
					}	
				}
				?>
</div>
<a href="<?php echo url::base();?>home/wishes"><?php echo __('more...')?></a>

<h2 class="sub_cat_title"><a href="<?php echo url::base();?>home/friends"><?php echo __('friends');?></a></h2>
<div id="friend_container" class="block_holder">
			<?php if(count($friends) == 0)
				{
					echo __('you have no friends');
				}
				else
				{
					foreach($friends as $friend_a)
					{
						$friend = $friend_a['friend'];
						$relationship = $friend_a['relationship'];
						$relationship_txt = "&lt;----&gt;";
						if($relationship == Model_Friend::$MY_FRIEND)
							$relationship_txt = "&lt;--";
						else if($relationship == Model_Friend::$THEIR_FRIEND)
							$relationship_txt = "--&gt;";

						
							
							$view = new View('home/block');
							$content = '<a href="'. url::base() . 'home/friends/view?id='.$friend->id.'">'. $friend->first_name . ' ' . $friend->last_name.'</a><br/>'.$relationship_txt;
							$view->content = $content;
							echo $view;
							
					 
					}
					
				}
				?>
</div>
<a href="<?php echo url::base();?>home/friends"><?php echo __('more...')?></a>





