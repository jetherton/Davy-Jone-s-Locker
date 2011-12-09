<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* wish.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/

class Controller_Home_Wish extends Controller_Home {


  	
	/**
	where users go to change their profiel
	*/
	public function action_index()
	{
		//The title to show on the browser
		$this->template->html_head->title = __("wish");
		//make messages roll up when done
		$this->template->html_head->messages_roll_up = true;
		//the name in the menu
		$this->template->header->menu_page = "wish";
		$this->template->content = view::factory("home/wish");
		
		//get the wishes that belong to this user
		$wishes = ORM::factory("wish")
			->where('user_id', '=', $this->user->id)
			->order_by('title', 'DESC')
			->find_all();
		
		$this->template->content->wishes = $wishes;
		
	}//end action_index
	
	
	/**
	 * Used for adding new wishes, just calls edit where all the real work is done
	 */
	public function action_add()
	{
		$this->action_edit();		
	}
	
	
	/**
	 * Method for adding/editing wishes
	 * Enter description here ...
	 */
	public function action_edit()
	{
		//get the wish id
		$wish_id = isset($_GET['id']) ? $_GET['id'] : 0;
		
		//get message from session params if any
		$session_message = Session::instance()->get_once('message','<none>');
		$messages = '<none>' == $session_message ? array() : array(__($session_message));
		
		//turn on Tiny MCE
		$this->template->html_head->script_views[] = view::factory('js/tinymce');
		
		//turn on messages
		$this->template->html_head->script_views[] = view::factory('js/messages');
		
		//turn on accodion
		$this->template->html_head->script_files[] = 'media/js/jquery-ui.min.js';
		$this->template->html_head->styles['media/css/jquery-ui.css'] = 'screen';
		$this->template->html_head->script_views[] = view::factory('js/accordion');
		
		$this->template->content = view::factory("home/wish_edit");
		$this->template->content->errors = array();
		$this->template->content->messages = $messages;
		
		
		if($wish_id == 0)
		{
			$wish = null;
			//The title to show on the browser
			$this->template->html_head->title = __("add wish");
			//the name in the menu
			$this->template->header->menu_page = "wish";
			//setup view			
			$this->template->content->title = __('add wish');
			$this->template->content->explanation = __('add wish explanation');
			$this->template->content->wish = array();
			$this->template->content->submit_button = __('add wish');
		}
		else
		{
			$wish = ORM::factory('wish', $wish_id);
			//The title to show on the browser
			$this->template->html_head->title = __("edit wish"). ' :: '. $wish->title;
			//the name in the menu
			$this->template->header->menu_page = "wish";
			//setup view
			$this->template->content->title = __('edit wish') . ' - '. $wish->title;
			$this->template->content->explanation = __('edit wish explanation');
			$this->template->content->wish = $wish;
			$this->template->content->submit_button = __('edit wish');
		}
		
		
		
		if(!empty($_POST)) // They've submitted the form to update his/her wish
		{

			try
			{
				//is this a new wish
				if($wish_id == 0)
				{
					$wish = ORM::factory("wish");
					$wish->create_wish($_POST, $this->user);
					Session::instance()->set('message','wish added successfully');
					$this->request->redirect('home/wish/edit?id='.$wish->id);
				}
				//or an old one
				else
				{
					$wish->update_wish($_POST, $this->user);
					$this->template->content->messages[] = __('wish edited successfully');
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
		}//end if(!empty($_POST))
	}//end function action_edit
	
	
} // End class