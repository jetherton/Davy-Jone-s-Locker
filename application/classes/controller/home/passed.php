<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Passed.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2012
* Writen by John Etherton <john@ethertontech.com>
* Started on 7/16/2012
*************************************************************/

class Controller_Home_Passed extends Controller_Home {


  	
	/**
	Called when a user claims another user has passed
	*/
	public function action_init()
	{
		//get the id of passed
		$passed_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		//if it' not valid, bounce
		if($passed_id == 0)
		{
			$this->request->redirect('home');
		}
		
		// first make sure the current user has the permission to do this
		$passed = ORM::factory('user', $passed_id);
		if(!$passed->loaded())
		{
			$this->request->redirect('home');
		}
		
		$passer_permission = Model_Userpasser::get_one_passer($passed, $this->user->id);
		if(!$passer_permission->loaded())
		{
			$this->request->redirect('home');
		}
		
		//turn on messages
		$this->template->html_head->script_views[] = view::factory('js/messages');
		
		//turn set focus to first UI form element
		$this->template->html_head->script_views[] = '<script type="text/javascript">$(document).ready(function() {$("input:text:visible:first").focus();});</script>';
		
		//turn on tooltips
		$this->template->html_head->script_files[] = 'media/js/jquery.tools.min.js';
		
		//turn on jquery UI
		$this->template->html_head->script_files[] = 'media/js/jquery-ui.min.js';
		$this->template->html_head->styles['media/css/jquery-ui.css'] = 'screen';

		//The title to show on the browser
		$this->template->html_head->title = __("init passed");
		//the name in the menu
		$this->template->header->menu_page = "passed";
		
		$this->template->content = view::factory("home/passed_init");
		$this->template->content->user = $this->user;
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		$this->template->content->passed = $passed;
			
		//get message from session params if any
		$session_message = Session::instance()->get_once('message','<none>');
		$messages = ('<none>' == $session_message) ? array() : array(__($session_message));
		$this->template->content->messages = $messages;
			
		
				
		if(!empty($_POST)) // They've submitted the form to update their passing settings
		{
			try
			{				
				//this page implicity confirms a passing
				$_POST['confirm'] = 1;
				//set the id of the user that passed
				$_POST['passed_id'] = $passed_id;
				//save the passing
				Model_Userpassed::set_as_passed($this->user, $_POST);
				
				
				$this->template->content = view::factory("home/passed_init_submitted");
				$this->template->content->user = $this->user;
				$this->template->content->errors = array();
				$this->template->content->messages = array();
				$this->template->content->passed = $passed;
					
				//get message from session params if any
				$session_message = Session::instance()->get_once('message','<none>');
				$messages = ('<none>' == $session_message) ? array() : array(__($session_message));
				$this->template->content->messages = $messages;
					
				
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
		}//end if post				
		
	}//end action_init()
		
} // End Welcome
