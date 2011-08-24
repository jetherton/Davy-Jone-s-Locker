<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Register.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 8/20/2011
*************************************************************/

class Controller_Login extends Controller_Main {

	
  	
	/**
	where users go to sign up
	*/
	public function action_index()
	{
		
		//if they're already logged in then take them to their profile
		$auth = Auth::instance();
		if( $auth->logged_in() OR $auth->auto_login())
		{
			$this->request->redirect(Session::instance()->get_once('returnUrl','home'));
		}
		 
		$this->template->html_head->title = __("login");
		$this->template->content = View::factory('login');
		$this->template->content->errors = array();
		
		if(!empty($_POST)) // They've submitted their registration form
		{
			$auth->login($_POST['username'], $_POST['password']);
			if($auth->logged_in())
			{
				$this->request->redirect(Session::instance()->get_once('returnUrl','home'));	
			}
			else
			{
				$this->template->content->errors[] = __("incorrect login");					
			}
	
		}
		else 
		{	//They're visiting for the first time		
		
		}
	}
	
	
} // End Welcome