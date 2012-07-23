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
		
		if($passed->date_passed != null)
		{
			$this->request->redirect('home/passed/passedaway?id='.$passed_id);
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
				//this person is the initiator
				$_POST['initiator'] = 1;
				//save the passing
				$status = Model_Userpassed::set_as_passed($this->user, $_POST);
				
				if($status== Model_Userpassed::$PASSED)
				{
					$this->request->redirect('home/passed/passedaway?id='.$passed_id);
				}
				elseif($status == Model_Userpassed::$INITIATED)
				{
					//it's started, but still needs others to make it happen
					$this->template->content = view::factory("home/passed_init_submitted");
					$this->template->content->passed = $passed;
					$this->template->content->user = $this->user;
					$this->template->content->errors = array();
					$this->template->content->messages = array();
						
					//get message from session params if any
					$session_message = Session::instance()->get_once('message','<none>');
					$messages = ('<none>' == $session_message) ? array() : array(__($session_message));
					$this->template->content->messages = $messages;
				}
				elseif($status == Model_Userpassed::$NOT_ALLOWED)
				{
					//what the F you aren't allowed to do this.
					//should record this in a log file
				}	
				
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
	
	
	
	
	 
	/**
	 * Records all the events that led to the passing of a person
	 */
	public function action_passedaway()
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
	
		if($passed->date_passed == null)
		{
			$this->request->redirect('home/friends/view?id='.$passed_id);
		}

		//are they friends with us? or am I the passed or am I a passer, cause if not, bounce
		if(!$passed->has('friends', $this->user->id) AND 
				$this->user->id != $passed_id AND 
				!Model_Userpasser::get_one_passer($passed, $this->user->id)->loaded())
		{
			$this->request->redirect('home/friends');
		}

		//turn on messages
		$this->template->html_head->script_views[] = view::factory('js/messages');
	
		//The title to show on the browser
		$this->template->html_head->title = __("passed away");
		//the name in the menu
		$this->template->header->menu_page = "passed away";
	
		$this->template->content = view::factory("home/passed_away");
		$this->template->content->user = $this->user;
		$this->template->content->passed = $passed;
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		$this->template->content->passed = $passed;
		
		//get the passed away messages;
		$this->template->content->passed_requests = Model_Userpassed::get_last_passed_requests($passed->id);
			
	}//end action_passedaway()
	
	/**
	 * Called when by a user when someone said they were dead, but they're not
	 */
	public function action_notpassedaway()
	{
		//first make sure this user was dead
		$is_dead = $this->user->date_passed != null;
		
		//passed process initiated?
		$process_started = Model_Userpassed::get_initiator($this->user->id)->loaded();
		
		if($is_dead OR $process_started)
		{
			//make you undead
			$this->user->date_passed = null;
			$this->user->save();
			
			$passed_request = ORM::factory('userpassed');
			$passed_request->passer_id = $this->user->id;
			$passed_request->passed_id = $this->user->id;
			$passed_request->note = '--- User requested their account be reactivated ---';
			$passed_request->time = date('Y-m-d G:i:s');
			$passed_request->confirm = '0';
			$passed_request->initiator = '0';
			$passed_request->save();
			
			
			//The title to show on the browser
			$this->template->html_head->title = __("account restored");
			//the name in the menu
			$this->template->header->menu_page = "account restored";
			
			$this->template->content = view::factory("home/not_passed_away");
			$this->template->content->user = $this->user;
			$this->template->content->errors = array();
			$this->template->content->messages = array();
			
			$message = __('Your account has been restored. You are no longer considered passed');
			ORM::factory('update')->create_update($message, $passed->id);
			
		}
		else
		{
			
			$this->request->redirect('home');
		}
	}//end action_notpassedaway()
	
	
	
	 
	/**
	 * Called when others are checking to see the status of someone's death process being iniated
	 */
	public function action_pending()
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
	
		if($passed->date_passed != null)
		{
			$this->request->redirect('home/passed/passedaway?id='.$passed_id);
		}
		//make sure your a passer, or the alledgedly passed
		$passer_permission = Model_Userpasser::get_one_passer($passed, $this->user->id);
		if(!$passer_permission->loaded() AND $passed_id != $this->user->id)
		{
			$this->request->redirect('home');
		}
	
		//turn on messages
		$this->template->html_head->script_views[] = view::factory('js/messages');
	
		//turn set focus to first UI form element
		$this->template->html_head->script_views[] = '<script type="text/javascript">$(document).ready(function() {$("input:text:visible:first").focus();});</script>';

	
		//The title to show on the browser
		$this->template->html_head->title = __("pending request");
		//the name in the menu
		$this->template->header->menu_page = "passed pending";
	
		$this->template->content = view::factory("home/passed_pending");
		$this->template->content->user = $this->user;
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		$this->template->content->passed = $passed;
			
		//get message from session params if any
		$session_message = Session::instance()->get_once('message','<none>');
		$messages = ('<none>' == $session_message) ? array() : array(__($session_message));
		$this->template->content->messages = $messages;

		//get the current passed requests
		$pass_requests = Model_Userpassed::get_current_passed_requests($passed->id);
		$this->template->content->passed_requests = $pass_requests;
		
		//check if i've already made a request and if this has been cancelled
		$already_requested = false;
		$has_been_cancelled = false;
		foreach($pass_requests as $request)
		{
			if($request->passer_id == $this->user->id)
			{
				$already_requested = true;
			}
			if(intval($request->confirm) == 0)
			{
				$has_been_cancelled = true;
			}
		}
		
		//if this has been cancelled, go there:
		if($has_been_cancelled)
		{
			$this->request->redirect('home/passed/cancelled?id='.$passed_id);
		}
		
		$this->template->content->already_requested = $already_requested;
		
	
	
		if(!empty($_POST) AND !$already_requested) // They've submitted the form to update their passing settings and they haven't already submitted something
		{
			try
			{
				//set the id of the user that passed
				$_POST['passed_id'] = $passed_id;
				//this person is the initiator
				$_POST['initiator'] = 0;
				//save the passing
				$status = Model_Userpassed::set_as_passed($this->user, $_POST);
				
				if($status == Model_Userpassed::$CANCELLED)
				{
					//it's started, but still needs others to make it happen
					$this->template->content = view::factory("home/passed_cancelled_submitted");
					$this->template->content->passed = $passed;
					$this->template->content->user = $this->user;
					$this->template->content->errors = array();
					$this->template->content->messages = array();
				}
	
				elseif($status== Model_Userpassed::$PASSED)
				{
					$this->request->redirect('home/passed/passedaway?id='.$passed_id);
				}
				elseif($status == Model_Userpassed::$INITIATED)
				{
					//it's started, but still needs others to make it happen
					$this->template->content = view::factory("home/passed_init_submitted");
					$this->template->content->passed = $passed;
					$this->template->content->user = $this->user;
					$this->template->content->errors = array();
					$this->template->content->messages = array();
	
					//get message from session params if any
					$session_message = Session::instance()->get_once('message','<none>');
					$messages = ('<none>' == $session_message) ? array() : array(__($session_message));
					$this->template->content->messages = $messages;
				}
				elseif($status == Model_Userpassed::$NOT_ALLOWED)
				{
					//what the F you aren't allowed to do this.
					//should record this in a log file
					$this->request->redirect('home');
				}
				
				//pull this data again to make sure it's up to date
				//get the current passed requests
				$pass_requests = Model_Userpassed::get_current_passed_requests($passed->id);
				$this->template->content->passed_requests = $pass_requests;
				
				//check if i've already made a request
				$already_requested = false;
				foreach($pass_requests as $request)
				{
					if($request->passer_id == $this->user->id)
					{
						$already_requested = true;
						break;
					}
				}
				$this->template->content->already_requested = $already_requested;
				
	
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
	}//end action_pending
	
	
	
	
	
	
	
	/**
	 * Called when others are checking to see the status of someone's death process and that process has been cancelled
	 */
	public function action_cancelled()
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
	
		if($passed->date_passed != null)
		{
			$this->request->redirect('home/passed/passedaway?id='.$passed_id);
		}
		//make sure your a passer, or the alledgedly passed
		$passer_permission = Model_Userpasser::get_one_passer($passed, $this->user->id);
		if(!$passer_permission->loaded() AND $passed_id != $this->user->id)
		{
			$this->request->redirect('home');
		}
	
		//turn on messages
		$this->template->html_head->script_views[] = view::factory('js/messages');
	
		//turn set focus to first UI form element
		$this->template->html_head->script_views[] = '<script type="text/javascript">$(document).ready(function() {$("input:text:visible:first").focus();});</script>';
	
	
		//The title to show on the browser
		$this->template->html_head->title = __("pending request");
		//the name in the menu
		$this->template->header->menu_page = "passed pending";
	
		$this->template->content = view::factory("home/passed_cancelled");
		$this->template->content->user = $this->user;
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		$this->template->content->passed = $passed;
			
		//get message from session params if any
		$session_message = Session::instance()->get_once('message','<none>');
		$messages = ('<none>' == $session_message) ? array() : array(__($session_message));
		$this->template->content->messages = $messages;
	
		//get the current passed requests
		$pass_requests = Model_Userpassed::get_current_passed_requests($passed->id);
		$this->template->content->passed_requests = $pass_requests;
	
		//check if i've already made a request and if this has been cancelled
		$has_been_cancelled = false;
		foreach($pass_requests as $request)
		{
			if(intval($request->confirm) == 0)
			{
				$has_been_cancelled = true;
			}
		}
	
		//if this has been cancelled, go there:
		if(!$has_been_cancelled)
		{
			$this->request->redirect('home/passed/pending?id='.$passed_id);
		}
	
	}//end action_cancelled
		
} // End Welcome
