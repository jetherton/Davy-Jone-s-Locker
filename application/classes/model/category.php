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

		$expected = array('title', 'description', 'order', 'parent_id');	

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
	
	/**
	 * Return an array of arrays of categories,
	 * The array will represent the hiearchy of categories
	 */
	public static function get_all_categories()
	{
		$retVal = array();
		
		//get top levels and then will loop over them
		$top_levels = ORM::factory('category')->where('parent_id', '=', 0)->order_by('order', 'ASC')->find_all();
		
		foreach($top_levels as $top_level)
		{
			//do this recursivley
			$retVal[$top_level->id] = self::_get_all_categories_helper($top_level);			
		}
				
		return $retVal;
	}
	
	/**
	 * Help method to recurse through the categories
	 */
	private static function _get_all_categories_helper($cat)
	{
		
		$retVal = array('cat'=>$cat, 'kids'=>array());
		//loop over kids
		$kids_db = ORM::factory('category')->where('parent_id', '=', $cat->id)->order_by('order', 'ASC')->find_all();
		foreach($kids_db as $kid)
		{
			$retVal['kids'][$kid->id] = self::_get_all_categories_helper($kid);
		}
		
		
		return $retVal;
	}
	
	/**
	 * Use this to retrieve thet top level categories
	 */
	public static function get_top_level_cats()
	{
		return ORM::factory('category')->where('parent_id', '=', 0)->order_by('order', 'ASC')->find_all();
	}
	
	/**
	 * Creates a array that's compatible with drop downs for categories
	 * based on the category array you put in here
	 * @param unknown_type $cat_array the cat array to use to build the drop down array
	 * @param int the indent level, should start at 0
	 */
	public static function get_categories_dropdown_array($cat_array, $indent_level = 0)
	{
		$ret_val = array();
		
		//loop over the current categories
		foreach($cat_array as $cat_id => $cat_data)
		{
			$name = '';
			for($i = 0; $i < $indent_level; $i++)
			{
				$name .= '---->';
			}
			$ret_val[$cat_id] = $name . $cat_data['cat']->title;
			//recursive call
			$recurse_array = self::get_categories_dropdown_array($cat_data['kids'], $indent_level + 1);
			//combine the two arrays
			foreach($recurse_array as $id=>$item)
			{
				$ret_val[$id] = $item;
			}
		}
		
		return $ret_val;
	}

	
} // End Category Model
