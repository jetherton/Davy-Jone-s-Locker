<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Register.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 8/20/2011
*************************************************************/

class Controller_Register extends Controller_Main {

	
  	
	/**
	where users go to sign up
	*/
	public function action_index()
	{
		//turn set focus to first UI form element
		$this->template->html_head->script_views[] = '<script type="text/javascript">$(document).ready(function() {$("input:text:visible:first").focus();});</script>';
		
		//if they're already logged in then take them to their profile
		$auth = Auth::instance();		
		if( $auth->logged_in() OR $auth->auto_login())
		{
			$this->request->redirect(Session::instance()->get_once('returnUrl','home'));
		}
		$this->template->header->menu_page = "register";
		$this->template->html_head->title = __("register");
		$this->template->content = View::factory('register');
		$this->template->content->errors = array();
		
		if(!empty($_POST)) // They've submitted their registration form
		{
			try 
			{
				if(!isset($_POST['terms']))
				{
					$this->template->content->errors[] = __('must agree to terms of use');
					return;
				}
				$user = ORM::factory("user");
				$user->create_user($_POST, array('username','password','email', 'first_name', 'last_name'));
				// Add the login role to the user (add a row to the db)
				$login_role = new Model_Role(array('name' =>'login'));
            	$user->add('roles', $login_role);
            	
				// sign the user in
				Auth::instance()->login($_POST['username'], $_POST['password']);
				$this->request->redirect('home');
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors_temp = $e->errors('register');
				if(isset($errors_temp["_external"]))
				{
					$this->template->content->errors = array_merge($errors_temp["_external"], $this->template->content->errors);
				}				
				else
				{
					foreach($errors_temp as $error)
					{
						if(is_string($error))
						{
							$this->template->content->errors[] = $error;							
						}
					}
				}
			}	
		}
		else 
		{	//They're visiting for the first time		
		
		}
	}
	
	
} // End Welcome