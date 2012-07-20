<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Profile.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 8/20/2011
*************************************************************/

class Controller_Home_Profile extends Controller_Home {


  	
	/**
	where users go to change their profiel
	*/
	public function action_index()
	{
		
		//turn on messages
		$this->template->html_head->script_views[] = view::factory('js/messages');
		
		//turn set focus to first UI form element
		$this->template->html_head->script_views[] = '<script type="text/javascript">$(document).ready(function() {$("input:text:visible:first").focus();});</script>';
		
		//turn on jquery UI
		$this->template->html_head->script_files[] = 'media/js/jquery-ui.min.js';
		$this->template->html_head->styles['media/css/jquery-ui.css'] = 'screen';
		
		//The title to show on the browser
		$this->template->html_head->title = __("profile");
		//the name in the menu
		$this->template->header->menu_page = "profile";
		$this->template->content = view::factory("home/profile");
		$this->template->content->user = $this->user;
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		
		//turn on picture upload
		$this->template->html_head->script_files[] = 'media/js/fileuploader.js';
		$this->template->html_head->styles['media/css/fileuploader.css'] = 'screen';
		$picture_uploader_view = view::factory('js/pictureuploader');
		$picture_uploader_view->element_id = 'image_uploader';
		$picture_uploader_view->extension = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
		//nail down that mysterious wish ID
		$picture_uploader_view->wish_id = $this->user->id;
		$this->template->html_head->script_views[] = $picture_uploader_view;
		
		if(!empty($_POST)) // They've submitted the form to update their profile
		{
			try
			{
				//check and see if the orignal password matches
				if(!Auth::instance()->login($this->user->username, $_POST['current_password']))
				{
					$this->template->content->errors[] = __('incorrect login');
					return;
				}
				//conver the DOB to a format mysql recognizes
				$_POST['dob'] = date('Y-m-d ', strtotime($_POST['dob'])). '00:00:00';
				$user = $this->user;
				$user->update_user($_POST);
				 
				// sign the user in
				Auth::instance()->login($_POST['username'], $_POST['password']);
				$this->template->content->user = $user;
				$this->template->content->messages = array(_('profile update successful'));
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

		
	}
	
	
} // End Welcome
