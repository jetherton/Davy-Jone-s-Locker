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
		
		//if this person thinks they are the initiator make sure that's true
		if(intval($values['initiator']) == 1 )
		{
			if(self::get_initiator($passed->id)->loaded())
			{
				$values['initiator'] = 0;
			}
		}
		
		$expected = array('passer_id', 'passed_id', 'time', 'note', 'confirm', 'initiator');
		$time = date('Y-m-d G:i:s');
		$values['time'] = $time;
		$values['passer_id'] = $user->id;
		$user_passed = ORM::factory('userpassed');
		$user_passed->values($values, $expected);
		$user_passed->check();
		$user_passed->save();
		
		//notify the recenlty passed
		//make an update
		$message = __(':user has marked your passing :passed_id :user_id', array(':user'=>$user->full_name(),
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
	
	
	/**
	 * Use this to find out who initiated the currently valid passed request
	 * @passed_id the Id of the user who might have passed
	 */
	public static function get_initiator($passed_id)
	{
		//get the passed
		$passed = ORM::factory('user', $passed_id);
		
		//get the passed persons passing settings
		$passing_settings = Model_Passingsetting::get_setting($passed);
		
		//set the time frame
		$timeframe = $passing_settings->timeframe;
		
		//figure out now - minues timeframe
		$end_of_time_frame = time(); - ($timeframe * 60 * 60);
		
		$initiator = ORM::factory('user')
			->join('userpassed', 'left')
			->on('user.id', '=', 'userpassed.passer_id')
			->where('userpassed.initiator', '=', '1')
			->where('userpassed.time', '>', date("r", $end_of_time_frame))
			->where('userpassed.passed_id', '=', $passed_id)
			->find();
		
		return $initiator;
	}
	
	/**
	 * Use this to get the requests, confirmations, and rejections
	 * that are currently valid
	 * * @passed_id the Id of the user who might have passed
	 */
	public static function get_current_passed_requests($passed_id)
	{
		////////////////////////////////////////////////////////////
		//////////////////////// finish this
		///////////////////////////////////////////////////////////
		
	
		//get the passed
		$passed = ORM::factory('user', $passed_id);
		
		//get the passed persons passing settings
		$passing_settings = Model_Passingsetting::get_setting($passed);
		
		//set the time frame
		$timeframe = $passing_settings->timeframe;
		
		//figure out now - minues timeframe
		$end_of_time_frame = time(); - ($timeframe * 60 * 60);
		
		$initiator = ORM::factory('user')
		->join('userpassed', 'left')
		->on('user.id', '=', 'userpassed.passer_id')
		->where('userpassed.initiator', '=', '1')
		->where('userpassed.time', '>', date("r", $end_of_time_frame))
		->where('userpassed.passed_id', '=', $passed_id)
		->find();
		
	}
	
} // End Userpassed model
