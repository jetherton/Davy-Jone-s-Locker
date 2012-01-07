<?php defined('SYSPATH') or die('No direct access allowed.');
/***********************************************************
* form.php - model for storing forms
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/23/2011
*************************************************************/

class Model_Formfieldresponse extends ORM {

	//belongs to a category
	protected $_belongs_to = array('formfields' => array(),
		'wishes'=>array());

	/**
	 * Rules function
	 * @see Kohana_ORM::rules()
	 */
	public function rules()
	{
		return array(
				
			'formfield_id' => array(
				array('not_empty'),
				),
				
			'wish_id' => array(
				array('not_empty'),
				),
				
			'response'=>array(
				array('max_length', array(':value', 254)),
				array('min_length', array(':value', 1))
				),


			);		
	}//end function
	
	
	/**
	* Update an existing formfieldresponse
	*
	* Example usage:
	* ~~~
	* $form_field_response = ORM::factory('formfieldresponse', $id)->update_formfieldresponse($_POST);
	* ~~~
	*
	* @param array $values
	* @throws ORM_Validation_Exception
	*/
	public function update_formfieldresponse($values)
	{

		$expected = array('formfield_id', 'wish_id', 'response');	

			
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}//end function
	
	
	/**
	 * Delete a form field response
	 * 
	 * Model_Formfieldresponse::delete_formfieldresponse($id);
	 * 
	 * @param id $id - the ID of the form you want to delete
	 * */
	public static function delete_formfieldresponse($id)
	{
		$formfieldoption = ORM::factory('formfieldresponse', $id);
		
		$formfieldoption->delete();
	}//end function

	
} // End Category Model
