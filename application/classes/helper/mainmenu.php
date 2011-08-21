<?php defined('SYSPATH') or die('No direct access allowed.');

class Helper_Mainmenu
{
	public static function make_menu()
	{
		echo '<ul><li><a href="'.url::base().'register">'.__("register").'</a></li></ul>';
	}
}