<?php defined('SYSPATH') or die('No direct access allowed.');

class Helper_Mainmenu
{
	public static function make_menu($page, $user)
	{
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
				
			
				
				//wish page
				if($page == "wish")
				{
					echo '<li class="selected">';
				}
				else
				{
					echo '<li>';
				}
				echo '<a href="'.url::base().'home/wish">'.__("wishes").'</a></li>';
				
			}
			
			//see if the given user is an admin, if so they can do super cool stuff
			$admin_role = ORM::factory('role')->where("name", "=", "admin")->find();
			if($user->has('roles', $admin_role))
			{
				
				//page for making/editing pages
				//page for making/eidting tags
				//page for making/eidting users
				
			}
		}//end is logged in
		
		
		echo '</ul>';
	}//end function
}//end class