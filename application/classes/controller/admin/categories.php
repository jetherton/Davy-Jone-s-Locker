<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Categories.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/

class Controller_Admin_Categories extends Controller_Admin {


  	
	/**
	where users go to change their profiel
	*/
	public function action_index()
	{
		/***** initialize stuff****/
		//The title to show on the browser
		$this->template->html_head->title = __("categories");
		//make messages roll up when done
		$this->template->html_head->messages_roll_up = true;
		//the name in the menu
		$this->template->header->menu_page = "categories";
		$this->template->content = view::factory("admin/categories");
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		//set the JS
		$js = view::factory('admin/categories_js');
		$this->template->html_head->script_views[] = $js;
		
		/********Check if we're supposed to do something ******/
		if(!empty($_POST)) // They've submitted the form to update his/her wish
		{
			try
			{
				//if we're editing things
				if($_POST['action'] == 'edit')
				{
					//new cat or existing cat?
					if($_POST['cat_id'] == 0)
					{
						$cat = ORM::factory('category');
					}
					else
					{
						$cat = ORM::factory('category', $_POST['cat_id']);
					}
					
					$cat->update_category($_POST);
				}
				
				else if($_POST['action'] == 'delete')
				{
					Model_Category::delete_category($_POST['cat_id']);
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
			catch(Database_Exception $e)
			{
				if($_POST['action'] == 'delete')
				{
					$this->template->content->errors[] = __('you can not delete that category');
				}
			}	
		}
		
		/*****Render the categories****/
		
		//get the categories so far
		$categories = ORM::factory("category")
			->order_by('order', 'ASC')
			->find_all();
		
		
		//get cats for drop down
		$cat_dropdown_t = Model_Category::get_categories_dropdown_array(Model_Category::get_all_categories());
		//add the top level
		$cat_dropdown = array();
		$cat_dropdown[0] = 'Top Level';
		foreach($cat_dropdown_t as $id=>$cdt)
		{
			$cat_dropdown[$id] = $cdt;
		}
		
		$this->template->content->cat_dropdown = $cat_dropdown;
		$this->template->content->categories = $categories;		
		$js->number_of_cats = count($categories);
		
	}//end action_index
	
	
}//end of class
