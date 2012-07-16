<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Passingsetting extends ORM {

	protected $_belongs_to = array('user' => array());

	/**
	 * Gets the passing settings of this user.
	 * @param user_obj $user
	 * @return user_obj passing settings or null if there isn't one
	 */
	public static function get_setting($user)
	{

		$passing_setting = $user->passing_setting;
		
		return $passing_setting;
	}
	
	
	/**
	 * Add some passing settings
	 * @param array values
	 * @param user_obj $user
	 */
	public function edit_setting($values, $user)
	{
		$expected = array('min_passers', 'timeframe', 'user_id');
		$values['user_id'] = $user->id;		
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}
	

	
	
} // End User Model
