<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Friendswishes extends ORM {

	protected $_table_name = "friends_wishes";
	
	
	/**
	 * Update an friends wishes timing component
	 *
	 *
	 * @param array $values
	 * @throws ORM_Validation_Exception
	 */
	public function update_timing($values, $user)
	{
	
		$expected = array('timing_type', 'dead_line', 'user_can_know');
		
		if($values['timing_type'] != '2')
		{
			$values['dead_line'] = null;
		}
		if($values['timing_type'] == '3')
		{
			$values['user_can_know'] = '1';
		}
	
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}
	
} // End User Model