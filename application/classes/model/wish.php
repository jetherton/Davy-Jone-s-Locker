<?php defined('SYSPATH') or die('No direct access allowed.');
/***********************************************************
* wish.php - Model
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
class Model_Wish extends ORM {

	//belongs to a user
	protected $_belongs_to = array('user' => array());
	
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
	
			'html' => array(
				array('not_empty'),
				array('min_length', array(':value', 1)),
				)		
			);		
	}
	
	
	/**
	* Create a new wish
	*
	* Example usage:
	* ~~~
	* $wish = ORM::factory('wish')->create_wish($_POST, $user);
	* ~~~
	*
	* @param array $values
	* @throws ORM_Validation_Exception
	*/
	public function create_wish($values, $user)
	{
		$expected = array('title', 'html', 'date_created', 'date_modified', 'user_id');
		$now = date('Y-m-d G:i:s');
		$values['date_created'] = $now;
		$values['date_modified'] = $now;
		$values['user_id'] = $user->id;
	
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}
	
	
	/**
	* Update an existing wish
	*
	* Example usage:
	* ~~~
	* $wish = ORM::factory('wish', $id)->update_wish($_POST, $user);
	* ~~~
	*
	* @param array $values
	* @throws ORM_Validation_Exception
	*/
	public function update_wish($values, $user)
	{
		$expected = array('title', 'html', 'date_modified', 'user_id');
		$now = date('Y-m-d G:i:s');
		$values['date_modified'] = $now;
		$values['user_id'] = $user->id;
	
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}
		
}//end class