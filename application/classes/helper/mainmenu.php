<?php defined('SYSPATH') or die('No direct access allowed.');

class Helper_Mainmenu
{
	public static function make_menu($page, $user)
	{
		$end_div = false;
		echo '<ul>';
		
		//Don't show the register link if the user is logged in
		if($user == null)
		{
			//register page
			if($page == "register")
			{
				echo '<li class="selected">';
			}
			else
			{
				echo '<li>';
			}
			echo '<a href="'.url::base().'register">'.__("register").'</a></li>';
		}
		
		//if the user is logged in
		if($user != null)
		{
			$login_role = ORM::factory('role')->where("name", "=", "login")->find();

			if($user->has('roles', $login_role))
			{
				
				// home page
				if($page == "home")
				{
					echo '<li class="selected">';
				}
				else
				{
					echo '<li>';
				}
				echo '<a href="'.url::base().'home">'.__("home").'</a></li>';
				
			
				
				
				
				//friends page
				if($page == "friend")
				{
					echo '<li class="selected">';
				}
				else
				{
					echo '<li>';
				}
				echo '<a href="'.url::base().'home/friends">'.__("friends").'</a></li>';
				
				
				
				//categories
				$cats = Model_Category::get_top_level_cats();
				foreach($cats as $cat)
				{
					if($page == "cat_".$cat->title)
					{
						echo '<li class="selected">';
					}
					else
					{
						echo '<li>';
					}
					echo '<a href="'.url::base().'home/wish?cat='.$cat->id.'"</a>'.$cat->title.'</a></li>';
				}
				
			}
		
		
		
			
			//see if the given user is an admin, if so they can do super cool stuff
			$admin_role = ORM::factory('role')->where("name", "=", "admin")->find();
			if($user->has('roles', $admin_role))
			{
				$end_div = false;
				//echo '</ul>';				
				//echo '<p style="clear:both; height:1px;"></p>';
				//echo '<div class="admin_menu">';
				//echo '<ul>';
				//page for making/editing categories
				if($page == "categories")
				{
					echo '<li class="adminmenu selected">';
				}
				else
				{
					echo '<li class="adminmenu">';
				}
				echo '<a href="'.url::base().'admin/categories">'.__("categories").'</a></li>';
					
					
				//page for making/editing categories
				if($page == "forms")
				{
					echo '<li class="adminmenu selected">';
				}
				else
				{
					echo '<li class="adminmenu">';
				}
				echo '<a href="'.url::base().'admin/forms">'.__("forms").'</a></li>';
				
			}
		}//end is logged in
		
		echo '</ul>';
		echo '<p style="clear:both;"></p>';
		if($end_div)
		{
			echo '</div>';
		}
		
		
	}//end function
}//end class
