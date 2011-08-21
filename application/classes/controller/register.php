<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Register.php - Controller
* Writen by John Etherton <john@ethertontech.com>
* Started on 8/20/2011
*************************************************************/

class Controller_Register extends Controller_Main {

	
  	
	/**
	where users go to sign up
	*/
	public function action_index()
	{
		if(!$_POST) // They're visiting the page for the first time.
		{
			$this->template->content = View::factory('register');
		}
		else
		{
			$post = new Validation($_POST);
		}
	}
	
	
} // End Welcome
