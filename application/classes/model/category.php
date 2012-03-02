<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Category extends Model_Auth_User {

		
	protected $_table_name = 'categories';


	protected $_has_many =  array(
				'forms' => array('model' => 'form'),
		);
		
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
				array('max_length', array(':value', 65533)),
				array('min_length', array(':value', 1))
				),
			);		
	}//end function
	
	
	/**
	 * The to string method. Ahh Java, how I miss the
	 */
	public function __toString()
	{
		return $this->title;
	}
	
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

		//update the order first decrease everything above the cats current position
		//but only if the order is already known for this cat
		if($this->order)
		{
			$cats = ORM::factory('category')->
				where('order', '>', $this->order)->
				find_all();
			
			foreach($cats as $cat)
			{
				$cat->order = intval($cat->order) - 1;
				$cat->save();
			}
		}

		//now push everything up that's greater than or equal to the new position
		$cats = ORM::factory('category')->
			where('order', '>=', $values['order'])->
			where('id', '!=', $this->id)->
			find_all();
		
		foreach($cats as $cat)
		{
			$cat->order = intval($cat->order) + 1;
			$cat->save();
		}
		
		//a sanity check to make sure we don't accidentally get the order screwed up
		$num_cats = ORM::factory('category')->count_all();
		$offset = $this->order ? 0 : 1;
		if($values['order'] > $num_cats + $offset)
		{
			$values['order'] == $num_cats + $offset;
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
