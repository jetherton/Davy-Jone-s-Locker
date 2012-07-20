<?php defined('SYSPATH') or die('No direct access allowed.');
/***********************************************************
* form.php - model for storing forms
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/23/2011
*************************************************************/

class Model_Form extends ORM {

	//belongs to a category
	protected $_belongs_to = array('category' => array());
	
		protected $_has_many =  array(
				'formfields' => array('model' => 'formfield'),
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
				array('max_length', array(':value', 65533)),
				array('min_length', array(':value', 1))
				),
			);		
	}//end function
	
	
	/**
	* Update an existing form
	*
	* Example usage:
	* ~~~
	* $form = ORM::factory('form', $id)->update_form($_POST);
	* ~~~
	*
	* @param array $values
	* @throws ORM_Validation_Exception
	*/
	public function update_form($values)
	{

		$expected = array('title', 'description', 'order', 'category_id', 'primary_field_title', 'primary_field_description');	

		//update the order, first decrease everything above the cats current position
		//but only if the order is already known for this cat
		if($this->order)
		{
			$forms = ORM::factory('form')->
				and_where('order', '>', $this->order)->
				and_where('category_id', '=', $this->category_id)->
				and_where('id', '!=', $this->id)->
				find_all();
			
			foreach($forms as $form)
			{
				$form->order = intval($form->order) - 1;
				$form->save();
			}
		}

		//now push everything up that's greater than or equal to the new position
		$forms = ORM::factory('form')->
			and_where('order', '>=', $values['order'])->
			and_where('category_id', '=', $values['category_id'])->
			and_where('id', '!=', $this->id)->
			find_all();
		
		foreach($forms as $form)
		{
			$form->order = intval($form->order) + 1;
			$form->save();
		}
		
		//a sanity check to make sure we don't accidentally get the order screwed up
		$num_forms = ORM::factory('form')->where('category_id', '=', $values['category_id'])->count_all();
		$offset = $this->order ? 0 : 1;
		if($values['order'] > $num_forms + $offset)
		{
			$values['order'] == $num_forms + $offset;
		}
		
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}//end function
	
	
	/**
	 * Delete a form and keep the ordering in tact
	 * 
	 * Model_Form::delete($id);
	 * 
	 * @param id $id - the ID of the form you want to delete
	 * */
	public static function delete_form($id)
	{
		$form = ORM::factory('form', $id);
		//update the order, this only affects categories with orders > than the current
		$forms = ORM::factory('form')->
			and_where('order', '>', $form->order)->
			and_where('category_id', '=', $form->category_id)->
			find_all();
		
		foreach($forms as $f)
		{
			$f->order = intval($f->order) - 1;
			$f->save();
		}
		
		$form->delete();
	}//end function

	/**
	 * Returns the forms that go with a given category
	 * @param unknown_type $cat_id
	 */
	public static function get_forms_for_cat($cat_id)
	{
		return ORM::factory('form')
			->where('category_id', '=', $cat_id)
			->order_by('order', 'ASC')
			->find_all();
	}
	
} // End Category Model
