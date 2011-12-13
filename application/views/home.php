<h1><?php echo __('welcome home :user', array(":first_name"=>"$user->first_name", ":last_name"=>"$user->last_name"))?></h1>

<table class="home_table">
	<thead>
		<tr>
			<th>
				<?php echo __('updates');?>
			</th>
			<th>
				<?php echo __('wishes');?>
			</th>
			<th>
				<?php echo __('friends');?>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<p>place holder text</p>
				
				<p>place holder text</p>
				
				<p>place holder text</p>
			</td>
			<td>
				<?php if(count($wishes) == 0)
				{
					echo __('you have no wishes');
				}
				else
				{
					echo '<ul>';
					foreach($wishes as $wish)
					{
					?>
						<li><a href="<?php echo url::base() . 'home/wish/edit?id=' . $wish->id;?>"><?php echo $wish->title; ?></a></li>	
					<?php 
					}
					echo '</ul>';
				}
				?>
			</td>
			<td>
				<?php if(count($friends) == 0)
				{
					echo __('you have no friends');
				}
				else
				{
					echo '<ul>';
					foreach($friends as $friend)
					{
					?>
						<li><a href="<?php echo url::base() . 'home/friends/view?id='.$friend->id;?>"><?php echo $friend->first_name . ' ' . $friend->last_name; ?></a></li>	
					<?php 
					}
					echo '</ul>';
				}
				?>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>	
			<td>
				<a href="<?php echo url::base();?>home/updates"><?php echo __('updates') . '...';?></a>
			</td>
			<td>
				<a href="<?php echo url::base();?>home/wish"><?php echo __('wishes'). '...';?></a>
			</td>
			<td>
				<a href="<?php echo url::base();?>home/friends"><?php echo __('friends'). '...';?></a>
			</td>
		</tr>
	</tfoot>
</table>



