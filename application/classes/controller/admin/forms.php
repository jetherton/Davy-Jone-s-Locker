<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* forms.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/

class Controller_Admin_Forms extends Controller_Admin {


  	
	/**
	where users go to change their profiel
	*/
	public function action_index()
	{
		/***** initialize stuff****/
		//The title to show on the browser
		$this->template->html_head->title = __("forms");
		//make messages roll up when done
		$this->template->html_head->messages_roll_up = true;
		//the name in the menu
		$this->template->header->menu_page = "forms";
		$this->template->content = view::factory("admin/forms");
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		//set the JS
		$js = view::factory('admin/forms_js');
		$this->template->html_head->script_views[] = $js;
		
		/********Check if we're supposed to do something ******/
		if(!empty($_POST)) // They've submitted the form to update his/her wish
		{
			try
			{	
				if($_POST['action'] == 'delete')
				{
					Model_Category::delete_form($_POST['form_id']);
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
		}
		
		/*****Render the forms****/
		
		//get the wishes that belong to this user
		$forms = ORM::factory("form")
			->order_by('category_id', 'ASC')
			->order_by('order', 'ASC')
			->find_all();
		
		$this->template->content->forms = $forms;
		
		
	}//end action_index
	
	
	
	/**
	 * the function for editing a form
	 * super exciting
	 */
	 public function action_edit()
	 {
		/*** Make sure we have the right form ***/		
		//first order of business, get that id, if there is one
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

		//if it's 0 then we're adding a form
		if($id == 0)
		{
			$form = ORM::factory('form');
		}
		else
		{
			//get the form
			$form = ORM::factory('form', $form);

			//does the form exist?
			if(!$form->loaded())
			{
			 $this->request->redirect('admin/forms');
			}
		}
		
		/***Now that we have the form, lets initialize the UI***/
		//The title to show on the browser
		$this->template->html_head->title = __("edit form") . $form->title ? ' :: '. $form->title : '';
		//make messages roll up when done
		$this->template->html_head->messages_roll_up = true;
		//the name in the menu
		$this->template->header->menu_page = "forms";
		$this->template->content = view::factory("admin/form_edit");
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		//set the JS
		$js = view::factory('admin/form_edit_js');
		$this->template->html_head->script_views[] = $js;
		 
	 }//end action_edit
	
	
}//end of class
