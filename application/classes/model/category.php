<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Category extends Model_Auth_User {

		
	protected $_table_name = 'categories';


		/**
	 * Rules function
	 * @see Kohana_ORM::rules()
	 */
	public function rules()
	{
		return array(
			'title' => array(
				array('not_empty'),
				array('max_length', array(':value', 254)),
				array('min_length', array(':value', 1))
				),
	
			'description' => array(
				array('not_empty'),
				array('max_length', array(':value', 254)),
				array('min_length', array(':value', 1))
				),
			);		
	}//end function
	
	
	/**
	* Update an existing category
	*
	* Example usage:
	* ~~~
	* $category = ORM::factory('category', $id)->update_category($_POST);
	* ~~~
	*
	* @param array $values
	* @throws ORM_Validation_Exception
	*/
	public function update_category($values)
	{
		
		$expected = array('title', 'description', 'order');	
		
		//update the order, this only affects categories with orders > than the current
		$cats = ORM::factory('category')->
			where('order', '>=', $values['order'])->
			find_all();
		
		foreach($cats as $cat)
		{
			$cat->order = intval($cat->order) + 1;
			$cat->save();
		}
		
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}//end function
	
	
	/**
	 * Delete a catogory and keep the ordering in tact
	 * 
	 * Model_Category::delete($id);
	 * 
	 * @param id $id - the ID of the category you want to delete
	 * */
	public static function delete_category($id)
	{
		$category = ORM::factory('category', $id);
		//update the order, this only affects categories with orders > than the current
		$cats = ORM::factory('category')->
			where('order', '>', $category->order)->
			find_all();
		
		foreach($cats as $cat)
		{
			$cat->order = intval($cat->order) - 1;
			$cat->save();
		}
		
		$category->delete();
	}//end function

	
} // End Category Model
