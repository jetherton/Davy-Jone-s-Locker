<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Userpassed extends ORM {
	
	/**
	 * Rules function
	 * @see Kohana_ORM::rules()
	 */
	public function rules()
	{
		return array(
				'note' => array(						
						array('max_length', array(':value', 65000)),
						array('min_length', array(':value', 1))
				),
	
		);
	}
	
	protected $_table_name = "userpassed";
	

	/**
	 * Sets that the user has marked the passed as passed
	 * also sends out emails and updates to everyone involved.
	 * 
	 * @param user_obj $user 
	 * @param user_obj $passed
	 */
	public static function set_as_passed($user, $values)	
	{
		//get the passed
		$passed = ORM::factory('user', $values['passed_id']);
		
		if(!$passed->loaded())
		{
			return;
		}
		
		//first make sure you have the right to say they've passed
		$passer = Model_Userpasser::get_one_passer($passed, $user->id);
		if(!$passer->loaded())
		{
			return;
		}
		
		$expected = array('passer_id', 'passed_id', 'time', 'note', 'confirm');
		$time = date('Y-m-d G:i:s');
		$values['time'] = $time;
		$values['passer_id'] = $user->id;
		$user_passed = ORM::factory('userpassed');
		$user_passed->values($values, $expected);
		$user_passed->check();
		$user_passed->save();
		
		//notify the recenlty passed
		//make an update
		$message = __('update :user has marked your passing :passed_id :user_id', array(':user'=>$user->full_name(),
				':passed_id'=>$passed->id,				
				':user_id'=>$user->id));
		ORM::factory('update')->create_update($message, $passed->id);
		
		//SEND EMAIL
		
		//find the other passers and notify them
		$passers = Model_Userpasser::get_passer($passed);
		//loop over them all
		foreach($passers as $p)
		{
			//skip ourselves
			if($p->id == $user->id)
			{
				continue;
			}
			
			//make an update
			$message = __(':user has marked the passing of :passed :passed_id :user_id', array(':user'=>$user->full_name(),
					':passed_id'=>$passed->id,
					':passed'=>$passed->full_name(),
					':user_id'=>$user->id));
			ORM::factory('update')->create_update($message, $p->id);
			
			
			//SEND EMAIL
		}
	}
	
} // End Userpassed model
