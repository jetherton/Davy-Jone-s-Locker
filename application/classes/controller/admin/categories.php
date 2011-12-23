<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Categories.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/

class Controller_Admin_Categories extends Controller_Admin {


  	
	/**
	where users go to change their profiel
	*/
	public function action_index()
	{
		//The title to show on the browser
		$this->template->html_head->title = __("categories");
		//make messages roll up when done
		$this->template->html_head->messages_roll_up = true;
		//the name in the menu
		$this->template->header->menu_page = "categories";
		$this->template->content = view::factory("admin/categories");
		
		//get the wishes that belong to this user
		$categories = ORM::factory("category")
			->order_by('order', 'ASC')
			->find_all();
		
		$this->template->content->categories = $categories;
		
	}//end action_index
	
	
}//end of class
