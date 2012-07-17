<?php defined('SYSPATH') or die('No direct access allowed.');
/***********************************************************
* updates.php - Model
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
class Model_Update extends ORM {

	//belongs to a user
	protected $_belongs_to = array('user' => array());
	
	/**
	 * Rules function
	 * @see Kohana_ORM::rules()
	 */
	public function rules()
	{
		return array(
			'html' => array(
				array('not_empty'),
				array('min_length', array(':value', 1)),
				array('max_length', array(':value', 65000)),
				)		
			);		
	}
	
	
	/**
	* Create a new update
	*
	* Example usage:
	* ~~~
	* $wish = ORM::factory('update')->create_update($message, $user);
	* ~~~
	*
	* @param $message string
	* @param $user_id int
	* @throws ORM_Validation_Exception
	*/
	public function create_update($message, $user_id)
	{
		$values = array();
		$expected = array('user_id', 'html', 'date_created');
		$now = date('Y-m-d G:i:s');
		$values['date_created'] = $now;
		$values['user_id'] = $user_id;
		$values['html'] = $message;
	
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}
	
	
	
}//end class