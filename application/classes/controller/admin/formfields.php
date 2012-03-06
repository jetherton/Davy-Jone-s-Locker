<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* forms.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/

class Controller_Admin_Formfields extends Controller_Admin {


  	
	/**
	where admins go to change form fields
	*/
	public function action_index()
	{		
		//initialize data
		$data = array(
			'id'=>'0',
			'form_id'=>'0',
			'title'=>'',
			'description'=>'',
			'order'=>'0',
			'type'=>0,			
			'required'=>0,
			'islockable'=>0);
		
		//make sure we have a valid form from which to make this field
		$form_id = isset($_GET['form']) ? intval($_GET['form']) : 0;
		if($form_id == 0)
		{
			$this->request->redirect('admin/forms');
		}
		//does this correspond to an existing form?
		$form = ORM::factory('form', $form_id);
		if(!$form->loaded())
		{
			$this->request->redirect('admin/forms');
		}
		 
		/*** Make sure we have the right form ***/		
		//first order of business, get that id, if there is one
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

		//if it's 0 then we're adding a form
		if($id == 0)
		{
			$form_field = null;
		}
		else
		{
			//get the form
			$form_field = ORM::factory('formfields', $id);

			//does the form exist?
			if(!$form_field->loaded())
			{
			 $this->request->redirect('admin/forms');
			}
			$data['id'] = $form_field->id;
			$data['form_id'] = $form_field->form_id;
			$data['title'] = $form_field->title;
			$data['description'] = $form_field->description;
			$data['order'] = $form_field->order;
			$data['type'] = $form_field->type;
			$data['required'] = $form_field->required;
			$data['islockable'] = $form_field->islockable;
			
		}
		
		/***Now that we have the form, lets initialize the UI***/
		//The title to show on the browser
		$header = $form_field ? __("edit form field") . ' :: '. $form_field->title : __("add form field") ;
		$this->template->html_head->title = $header;		
		//make messages roll up when done
		$this->template->html_head->messages_roll_up = true;
		//the name in the menu
		$this->template->header->menu_page = "forms";
		$this->template->content = view::factory("admin/formfield_edit");
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		$this->template->content->header = $header;
		$this->template->content->data = $data;
		$this->template->content->form_id = $form_id;
		//set the JS		
		$this->template->html_head->script_views[] = view::factory('js/messages');
		$js = view::factory('admin/formfield_edit_js');
		$js->form_field_id = $id;
		$this->template->html_head->script_views[] = $js;
		//get the status
		$status = isset($_GET['status']) ? $_GET['status'] : null;
		if($status == 'saved')
		{
				$this->template->content->messages[] = __('changes saved');
		}		
		elseif($status == 'option_saved')
		{
				$this->template->content->messages[] = __('changes saved');
		}
		elseif($status == 'option_deleted')
		{
				$this->template->content->messages[] = __('option deleted');
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
						$form_field = ORM::factory('formfields');
					}
					else
					{
						$form_field = ORM::factory('formfields', $id);
					}
					
					$form_field->update_formfield($_POST);
					$this->request->redirect('admin/formfields?form='.$form_id.'&id='.$form_field->id.'&status=saved');
				}
				elseif ($_POST['action'] == 'edit_option')
				{
					//this shouldn't happen, but just in case
					if($id == 0)
					{
						$this->template->content->errors[] = __('Must save field before adding options');
					}
					else
					{
						if($_POST['id'] == 0)
						{
							$form_field_option = ORM::factory('formfieldoption');
						}
						else
						{
							$form_field_option = ORM::factory('formfieldoption', $_POST['id']);
						}
						$form_field_option->update_formfieldoption($_POST);
					}
				}
				elseif ($_POST['action'] == 'delete')
				{
					//this shouldn't happen, but just in case
					if($id == 0)
					{
						$this->template->content->errors[] = __('Must save field before adding options');
					}
					else
					{
						Model_Formfieldoption::delete_formfieldoption($_POST['id']);
						
						$this->request->redirect('admin/formfields?form='.$form_id.'&id='.$form_field->id.'&status=option_deleted');
					}
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
				
				if($_POST['action'] == 'edit')
				{
					$data['title'] = $_POST['title'];
					$data['description'] = $_POST['description'];
					$data['order'] = $_POST['order'];
					$data['type'] = $_POST['type'];
					$data['required'] = isset($_POST['required']) ? $_POST['required'] : 0;
					$data['islockable'] = isset($_POST['islockable']) ? $_POST['islockable'] : 0;
					
					$this->template->content->data = $data;
				}
			}	
		}
		
		
		
		/**** Finish setting things up ****/
		//figure out the order
		//count how many fields there are in this form
		$increment = $id == 0 ? 1 : 0;
		$count = ORM::factory('formfields')
			->where('form_id', '=', $form_id)
			->count_all() + $increment;
			
		$orders = array();
		for($i = $count; $i >= 1; $i--)
		{
			$orders[$i] = $i;
		}
		$this->template->content->orders = $orders;
		//figure out how many options there are, if any for this field
		if($id == 0)
		{
			$this->template->content->option_orders = array(1=>1);
		}
		else
		{
			$count = ORM::factory("formfieldoption")->
				where('formfield_id', '=', $id)->
				count_all() + 1;
			$option_orders = array();
			for($i = 1; $i <= $count; $i++)
			{
				$option_orders[$i] = $i;
			}
			$this->template->content->option_orders = $option_orders;
		}
		
		
		//form field options
		/** John you need to add this **/
		$form_field_option = ORM::factory('formfieldoption')->
			where('formfield_id', '=', $id)->
			order_by('order')->
			find_all();
		$this->template->content->form_field_options = $form_field_option;
		 
	 }//end action_edit
	
	
}//end of class
