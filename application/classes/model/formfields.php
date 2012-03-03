<?php defined('SYSPATH') or die('No direct access allowed.');
/***********************************************************
* form.php - model for storing forms
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/23/2011
*************************************************************/

class Model_Formfields extends ORM {

	//belongs to a category
	protected $_belongs_to = array('form' => array());

	protected $_table_name = 'formfields';

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
				
			'form_id' => array(
				array('not_empty'),
				),
				
			'type' => array(
				array('not_empty'),
				),			
			'required' => array(
				array('not_empty'),
				),			

			'default_value' => array(
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
	* Update an existing formfield
	*
	* Example usage:
	* ~~~
	* $form_field = ORM::factory('formfield', $id)->update_formfield($_POST);
	* ~~~
	*
	* @param array $values
	* @throws ORM_Validation_Exception
	*/
	public function update_formfield($values)
	{

		$expected = array('title', 'description', 'order', 'form_id', 'required', 'type', 'default_value', 'islockable');	

		//update the order first decrease everything above the forms current position
		//but only if the order is already known for this form
		if($this->order)
		{
			$formfields = ORM::factory('formfields')->
				and_where('order', '>', $this->order)->
				and_where('form_id', '=', $this->form_id)->
				find_all();
			
			foreach($formfields as $ff)
			{
				$ff->order = intval($ff->order) - 1;
				$ff->save();
			}
		}

		//now push everything up that's greater than or equal to the new position
		$formfields = ORM::factory('formfields')->
			and_where('order', '>=', $values['order'])->
			and_where('form_id', '=', $values['form_id'])->
			and_where('id', '!=', $this->id)->
			find_all();
		
		foreach($formfields as $ff)
		{
			$ff->order = intval($ff->order) + 1;
			$ff->save();
		}
		
		//a sanity check to make sure we don't accidentally get the order screwed up
		$num_formfields = ORM::factory('formfields')->where('form_id', '=', $values['form_id'])->count_all();
		$offset = $this->order ? 0 : 1;
		if($values['order'] > $num_formfields + $offset)
		{
			$values['order'] == $num_formfields + $offset;
		}
		
		if(!isset($values['required']))
		{
			$values['required'] = 0;
		}
		else
		{
			$values['required'] = 1;
		}
		
		if(!isset($values['islockable']))
		{
			$values['islockable'] = 0;
		}
		else
		{
			$values['islockable'] = 1;
		}
		
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}//end function
	
	
	/**
	 * Delete a form field and keep the ordering in tact
	 * 
	 * Model_Form::delete_formfield($id);
	 * 
	 * @param id $id - the ID of the form you want to delete
	 * */
	public static function delete_formfield($id)
	{
		$formfield = ORM::factory('formfields', $id);
		//update the order, this only affects categories with orders > than the current
		$formfields = ORM::factory('formfields')->
			and_where('order', '>', $category->order)->
			and_where('form_id', '=', $category->form_id)->
			find_all();
		
		foreach($formfields as $ff)
		{
			$ff->order = intval($ff->order) - 1;
			$ff->save();
		}
		
		$formfield->delete();
	}//end function


	/**
	 * Used to get the human readable name for the type of 
	 * field
	 * @param int type id for the given type
	 * @return string human readable field type
	 **/
	public static function get_human_readable_type()
	{
			
		return array(	
		1=>__('text input'),
		2=>__('text area input'),
		3=>__('date input'),
		4=>__('radio input'),
		5=>__('check box input'),
		6=>__('dropdown input'),
		7=>__('password input')
		);

	}
	
} // End Category Model
