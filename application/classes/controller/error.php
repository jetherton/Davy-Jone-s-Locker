<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* error.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 8/20/2011
*************************************************************/

class Controller_error extends Controller_Main {

	
  	
	/**
	where users go to sign up
	*/
	public function action_404()
	{
		
		$this->template->html_head->title = __("page not found - 404");
		$this->template->content = View::factory('error/404');
		$this->template->content->errors = array();

	}
	
	
} // End error