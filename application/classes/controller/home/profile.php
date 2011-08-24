<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Register.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 8/20/2011
*************************************************************/

class Controller_Home_Profile extends Controller_Home {


  	
	/**
	where users go to change their profiel
	*/
	public function action_index()
	{
		
		//The title to show on the browser
		$this->template->html_head->title = __("profile");
		//the name in the menu
		$this->template->header->menu_page = "profile";
		$this->template->content = view::factory("home/profile");
		$this->template->content->errors = array();

		
	}
	
	
} // End Welcome