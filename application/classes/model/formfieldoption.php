<?php defined('SYSPATH') or die('No direct access allowed.');
/***********************************************************
* form.php - model for storing forms
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/23/2011
*************************************************************/

class Model_Formfieldoption extends ORM {

	//belongs to a category
	protected $_belongs_to = array('formfields' => array());

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
				
			'formfield_id' => array(
				array('not_empty'),
				),
					
			'description' => array(
				array('not_empty'),
				array('max_length', array(':value', 254)),
				array('min_length', array(':value', 1))
				),
			);		
	}//end function
	
	
	/**
	* Update an existing formfield
	*
	* Example usage:
	* ~~~
	* $form_field_option = ORM::factory('formfieldoption', $id)->update_formfieldoption($_POST);
	* ~~~
	*
	* @param array $values
	* @throws ORM_Validation_Exception
	*/
	public function update_formfieldoption($values)
	{

		$expected = array('title', 'description', 'order', 'formfield_id');	

		//update the order first decrease everything above the forms current position
		//but only if the order is already known for this form
		if($this->order)
		{
			$formfields = ORM::factory('formfieldoption')->
				and_where('order', '>', $this->order)->
				and_where('formfield_id', '=', $this->formfield_id)->
				find_all();
			
			foreach($formfields as $ff)
			{
				$ff->order = intval($ff->order) - 1;
				$ff->save();
			}
		}

		//now push everything up that's greater than or equal to the new position
		$formfields = ORM::factory('formfieldoption')->
			and_where('order', '>=', $values['order'])->
			and_where('formfield_id', '=', $values['formfield_id'])->
			and_where('id', '!=', $this->id)->
			find_all();
		
		foreach($formfields as $ff)
		{
			$ff->order = intval($ff->order) + 1;
			$ff->save();
		}
		
		//a sanity check to make sure we don't accidentally get the order screwed up
		$num_formfields = ORM::factory('formfieldoption')->where('formfield_id', '=', $values['formfield_id'])->count_all();
		$offset = $this->order ? 0 : 1;
		if($values['order'] > $num_formfields + $offset)
		{
			$values['order'] == $num_formfields + $offset;
		}
				
		
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}//end function
	
	
	/**
	 * Delete a form field and keep the ordering in tact
	 * 
	 * Model_Formfieldoption::delete_formfieldoption($id);
	 * 
	 * @param id $id - the ID of the form you want to delete
	 * */
	public static function delete_formfieldoption($id)
	{
		$formfieldoption = ORM::factory('formfieldoption', $id);
		//update the order, this only affects categories with orders > than the current
		$formfields = ORM::factory('formfieldoption')->
			and_where('order', '>', $formfieldoption->order)->
			and_where('formfield_id', '=', $formfieldoption->formfield_id)->
			find_all();
		
		foreach($formfields as $ff)
		{
			$ff->order = intval($ff->order) - 1;
			$ff->save();
		}
		
		$formfieldoption->delete();
	}//end function

	
} // End Category Model
