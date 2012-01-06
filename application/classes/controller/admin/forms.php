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
		$this->template->html_head->script_views[] = view::factory('js/messages');
		
		/********Check if we're supposed to do something ******/
		if(!empty($_POST)) // They've submitted the form to update his/her wish
		{
			try
			{	
				if($_POST['action'] == 'delete')
				{
					Model_Form::delete_form($_POST['form_id']);
					$this->template->content->messages[] = __('form deleted');
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
		
		//get the forms that belong to this user
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
		//initialize data
		$data = array(
			'id'=>'0',
			'title'=>'',
			'description'=>'',
			'category_id'=>null,
			'order'=>null);
		
		
		 
		/*** Make sure we have the right form ***/		
		//first order of business, get that id, if there is one
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

		//if it's 0 then we're adding a form
		if($id == 0)
		{
			$form = null;
			$is_add = "true";
		}
		else
		{
			$is_add = "false";
			//get the form
			$form = ORM::factory('form', $id);

			//does the form exist?
			if(!$form->loaded())
			{
			 $this->request->redirect('admin/forms');
			}
			$data['id'] = $form->id;
			$data['title'] = $form->title;
			$data['description'] = $form->description;
			$data['category_id'] = $form->category_id;
			$data['order'] = $form->order;
		}
		
		/***Now that we have the form, lets initialize the UI***/
		//The title to show on the browser
		$header = $form ? __("edit form") . ' :: '. $form->title : __("add form") ;
		$this->template->html_head->title = $header;		
		//make messages roll up when done
		$this->template->html_head->messages_roll_up = true;
		//the name in the menu
		$this->template->header->menu_page = "forms";
		$this->template->content = view::factory("admin/form_edit");
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		$this->template->content->header = $header;
		//set the JS
		$js = view::factory('admin/form_edit_js');
		$js->is_add = $is_add;
		$this->template->html_head->script_views[] = $js;
		$this->template->html_head->script_views[] = view::factory('js/messages');
		
		//get the status
		$status = isset($_GET['status']) ? $_GET['status'] : null;
		if($status == 'saved')
		{
				$this->template->content->messages[] = __('changes saved');
		}
		
		/******* Handle incoming data*****/
		if(!empty($_POST)) // They've submitted the form to update his/her wish
		{
			try
			{
				//if we're editing things
				if($_POST['action'] == 'edit')
				{
					//new cat or existing cat?
					if($id == 0)
					{
						$form = ORM::factory('form');
					}
					else
					{
						$form = ORM::factory('form', $id);
					}
					
					$form->update_form($_POST);
				}
				
				else if($_POST['action'] == 'delete')
				{
					Model_Form::delete_form($_POST['form_id']);
				}
				
				$this->request->redirect('admin/forms/edit?id='.$form->id.'&status=saved');
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
		
		
		
		/**** Finish setting things up ****/
		//categories
		$cats = ORM::factory('category')->find_all();
		$category = array();
		foreach($cats as $cat)
		{
			$category[$cat->id] = $cat;
		}
		$this->template->content->categories = $category;
		
		//form fields
		$formfields = ORM::factory('formfields')->
			where('form_id', '=', $id)->
			order_by('order')->
			find_all();
		$this->template->content->formfields = $formfields;
		
		if($id == 0)
		{
			$js->current_cat_id = 0;
			$js->current_order = 0;
		}
		else
		{
			$js->current_cat_id = $form->category_id;
			$js->current_order = $form->order;
		}
		
		//get the number of items per category
		$forms = ORM::factory('form')
			->order_by('category_id')
			->find_all();
		$cat_counts = array();
		$current_count = 0;
		$current_cat_id = 0;
		foreach($forms as $form)
		{
			if($current_cat_id == 0)
			{
				$current_cat_id = $form->category_id;
			}
			
			if( $current_cat_id != $form->category_id)
			{
				$cat_counts[$current_cat_id] = $current_count;
				$current_count = 0;
				$current_cat_id = $form->category_id;
			}
			$current_count++;
		}
		//catch the last category group
		if($current_cat_id != 0)
		{
			$cat_counts[$current_cat_id] = $current_count;
		}
		
		$js->cat_counts = json_encode($cat_counts);
		
		$this->template->content->data = $data;
		
		 
	 }//end action_edit
	
	
}//end of class
