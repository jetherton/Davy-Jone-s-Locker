<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Passing.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2012
* Writen by John Etherton <john@ethertontech.com>
* Started on 7/16/2012
*************************************************************/

class Controller_Home_Passing extends Controller_Home {


  	
	/**
	Where users go to set who can say they've passed
	*/
	public function action_index()
	{
		
		//the settings
		$settings = null;
		
		//turn on messages
		$this->template->html_head->script_views[] = view::factory('js/messages');
		
		//turn set focus to first UI form element
		$this->template->html_head->script_views[] = '<script type="text/javascript">$(document).ready(function() {$("input:text:visible:first").focus();});</script>';
		
		//turn on tooltips
		$this->template->html_head->script_files[] = 'media/js/jquery.tools.min.js';
		
		//turn on jquery UI
		$this->template->html_head->script_files[] = 'media/js/jquery-ui.min.js';
		$this->template->html_head->styles['media/css/jquery-ui.css'] = 'screen';
		
		
		
		$js_view = view::factory('home/passing_js');
		$this->template->html_head->script_views[] = $js_view;
		
		//The title to show on the browser
		$this->template->html_head->title = __("passing");
		//the name in the menu
		$this->template->header->menu_page = "passing";
		$this->template->content = view::factory("home/passing");
		$this->template->content->user = $this->user;
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		
		//get message from session params if any
		$session_message = Session::instance()->get_once('message','<none>');
		$messages = ('<none>' == $session_message) ? array() : array(__($session_message));
		$this->template->content->messages = $messages;
		
		
		if(!empty($_POST)) // They've submitted the form to update their passing settings
		{
			try
			{
				
				//get the model
				$settings = Model_Passingsetting::get_setting($this->user);
				//save it
				$settings->edit_setting($_POST, $this->user);
				//update the message
				$this->template->content->messages[] = __('Passing settings edited successfully');
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
		
		//get the settings
		if($settings == null)
		{
			$settings = Model_Passingsetting::get_setting($this->user);
		}
		$this->template->content->settings =  $settings;
		
		$this->template->content->passer = Model_Userpasser::get_passer($this->user);
		
	}//end action_index()
	
	/**
	 * gets the friends to fields mapping
	 */
	public function action_addpasserfield()
	{
		//this function isn't participating in the auto render side of things
		$this->template = "";
		$this->auto_render = FALSE;

		$friends = Model_Friend::get_friends($this->user);
		
		//get list of passers
		$passers = Model_Userpasser::get_passer($this->user);

		//now remove the friends that are already passers
		foreach($passers as $passer)
		{
			unset($friends[$passer->id]);
		}
		
		$available_friends = array();
		
		//now remove the friends that are not your friends
		foreach($friends as $id=>$friend)
		{
			if($friend['relationship'] != Model_Friend::$THEIR_FRIEND)
			{
				$available_friends[$id] = $friend['friend']->full_name(); 
			}
		}
			
		echo '<html><h2>'.__('Add a friend as a passer').'</h2>';
		if(count($available_friends) == 0)
		{
			echo '<ul><li>'.__('no friends to pass').'</li></ul></html>';
			return;
		}
		else
		{

			echo form::select('new_passer',$available_friends, null, array('id'=>'new_passer'));

	
		}
		echo '<br/>';
		echo '<br/>';
		echo '<button type="button" onclick="addParser(); return false;">'.__('add passers').'</button>';
		echo '</html>';
	
	}//end addfriends()
	
	
	/**
	 * Used to add friends as passers
	 */
	public function action_addpasser()
	{
		$this->template = new View('home/passers_list');		
		$this->auto_render = FALSE;
		
		//make sure the requried get arguements are present
		if(!isset($_POST['passer_id']))
		{	
			$this->template->passers = Model_Userpasser::get_passer($this->user);
			echo $this->template;
			return;
		}
		
		$passer_id = intval($_POST['passer_id']);
		
		if($passer_id < 1)
		{
			$this->template->passers = Model_Userpasser::get_passer($this->user);
			echo $this->template;
			return;
		}
		
		
		//make sure the wish and the friend exists
		$passer = ORM::factory('user', $passer_id);
		
		
		if(!$passer->loaded())
		{
			$this->template->passers = Model_Userpasser::get_passer($this->user);
			echo $this->template;
			return;
		}
		
		Model_Userpasser::add_passer($this->user, $passer_id);

		//update the table 
		$this->template->passers = Model_Userpasser::get_passer($this->user);
		echo $this->template;

		
	}//end action_addpasser
	
	/**
	 * Used to delete a passer
	 */
	public function action_deletepasser()
	{
		$this->template = new View('home/passers_list');
		$this->auto_render = FALSE;
		
		//make sure the requried get arguements are present
		if(!isset($_POST['passer_id']))
		{
			$this->template->passers = Model_Userpasser::get_passer($this->user);
			echo $this->template;
			return;
		}
		
		$passer_id = intval($_POST['passer_id']);
		
		if($passer_id < 1)
		{
			$this->template->passers = Model_Userpasser::get_passer($this->user);
			echo $this->template;
			return;
		}
		
		
		//make sure the wish and the friend exists
		$passer = ORM::factory('user', $passer_id);
		
		
		if(!$passer->loaded())
		{
			$this->template->passers = Model_Userpasser::get_passer($this->user);
			echo $this->template;
			return;
		}
		
		Model_Userpasser::delete_passer($this->user, $passer_id);
		
		//update the table
		$this->template->passers = Model_Userpasser::get_passer($this->user);
		echo $this->template;
	}//end action_deletepasser
	
} // End Welcome
