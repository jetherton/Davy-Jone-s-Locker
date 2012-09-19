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
		
		//turn on jquery UI
		$this->template->html_head->script_files[] = 'media/js/jquery-ui.min.js';
		$this->template->html_head->styles['media/css/jquery-ui.css'] = 'screen';
		
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
				//conver the DOB to a format mysql recognizes
				$_POST['dob'] = date('Y-m-d ', strtotime($_POST['dob'])). '00:00:00';
				$user = ORM::factory("user");
				$user->create_user($_POST, array('username','password','email', 'first_name', 'middle_name', 'last_name', 'gender','address1','address2','city','state','zip','dob','citizenship'));
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
	}//end of action_index
	
	
	public function action_verify()
	{
		//turn set focus to first UI form element
		$this->template->html_head->script_views[] = '<script type="text/javascript">$(document).ready(function() {$("input:text:visible:first").focus();});</script>';
		
		//turn on jquery UI
		$this->template->html_head->script_files[] = 'media/js/jquery-ui.min.js';
		$this->template->html_head->styles['media/css/jquery-ui.css'] = 'screen';
		
		//if they're already logged in then take them to their profile
		$auth = Auth::instance();
		$user = null;
		//see if they're logged in
		if( $auth->logged_in() OR $auth->auto_login() OR isset($_GET['id']))
		{
			if($auth->logged_in() OR $auth->auto_login())
			{
				//if so get the user info 
				$user = ORM::factory('user',$auth->get_user());
				//has this user already verified their email
				if(intval($user->email_verified) == 1)
				{
					$this->request->redirect(Session::instance()->get_once('returnUrl','home'));
				}
			}
			else
			{
				$user = ORM::factory('user', $_GET['id']);
				//has this user already verified their email
				if(intval($user->email_verified) == 1)
				{
					$this->request->redirect(Session::instance()->get_once('returnUrl','home'));
				}
			}
		}
		else
		{
			//if they aren't logged in send them to the landing page
			$this->request->redirect('');
		}
		
		//Send an email to the user with the email verification key
		//but only do this if they aren't click on the the verify me link
		if(!isset($_GET['email_key']) AND empty($_POST))
		{
			//send email
			$token =  md5(uniqid(rand(), TRUE));
			$user->email_key = $token;
			$user->save();
			
			$message = __('Hello :name we are writing to confirm your email address. Please copy and paste the key :key below, or click on this link', 
					array(':name'=>$user->first_name,
					':key'=>$token));
				
			$email = Email::factory(__('Ekphora.com - Email verification'), 'blank')
			->to($user->email, $user->full_name())
			->from('email@ekphora.com', 'Ekphora.com - No Reply')
			->message($message, 'text/html')
			->send();
		}
		
		$this->template->header->menu_page = "verify email";
		$this->template->html_head->title = __("verify email");
		$this->template->content = View::factory('verifyemail');
		$this->template->content->errors = array();
		
		if(!empty($_POST) OR isset($_GET['email_key'])) // They've submitted their registration form
		{
				$key = '';
				if(isset($_GET['email_key']))
				{
					$key = $_GET['email_key'];
				}
				else 
				{
					$key = $_POST['email_key'];
				}

				//now we need to see if this key matches the key we have on file for the user.
				if(strcmp($key, $user->email_key) == 0)
				{
					//we have a match
					$user->email_verified = 1;
					$user->save();
					$this->template->content = View::factory('verifyemailthanks');
				}
				else
				{
					//the key did not match
					$this->request->redirect('/register/verify');
				}
		}
		else
		{	//They're visiting for the first time
			
		}
	}
} // End Welcome
