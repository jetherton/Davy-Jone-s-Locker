<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Userpassed extends ORM {
	
	
	public static $PASSED = 'PASSED';
	public static $INITIATED = 'INITIATED';
	public static $NOT_ALLOWED = 'NOT_ALLOWED';
	
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
	 * @return error code
	 */
	public static function set_as_passed($user, $values)	
	{
		//get the passed
		$passed = ORM::factory('user', $values['passed_id']);
		
		if(!$passed->loaded())
		{
			return self::$NOT_ALLOWED;
		}
		
		//make sure they haven't already passed
		if($passed->date_passed != null)
		{
			return self::$PASSED;
		}
		
		//first make sure you have the right to say they've passed
		$passer = Model_Userpasser::get_one_passer($passed, $user->id);
		if(!$passer->loaded())
		{
			return self::$NOT_ALLOWED;
		}
		
		//make sure someone hasn't already cancled this
		if(self::has_pass_request_been_canceled($passed))
		{
			return self::$NOT_ALLOWED;
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
		
		
		//check if the passed is now officially gone.
		if(self::is_gone($passed))
		{
			//notify the recenlty passed
			//make an update
			$message = __('You are now considered passed away');
			ORM::factory('update')->create_update($message, $passed->id);
			////////////////////////////////////////////////////////////////////////////////////////////
			//SEND EMAIL
			/////////////////////////////////////////////////////////////////////////////////////////////
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
				$message = __(':passed has :passed_id passed away', array(':passed_id'=>$passed->id,':passed'=>$passed->full_name()));
				ORM::factory('update')->create_update($message, $p->id);
			
				/////////////////////////////////////////////////////////////////////////////////////////////
				//SEND EMAIL
				////////////////////////////////////////////////////////////////////////////////////////////
			}

			return self::$PASSED;
		}//the person has passed.
		else
		{ //still waiting on others to pass this person
			
			//notify the recenlty passed
			//make an update
			$message = __(':user has marked your passing :passed_id :user_id', array(':user'=>$user->full_name(),
					':passed_id'=>$passed->id,				
					':user_id'=>$user->id));
			ORM::factory('update')->create_update($message, $passed->id);
			
			
			////////////////////////////////////////////////////////////////////////////////////////////
			//SEND EMAIL
			/////////////////////////////////////////////////////////////////////////////////////////////
			
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
				
				/////////////////////////////////////////////////////////////////////////////////////////////
				//SEND EMAIL
				////////////////////////////////////////////////////////////////////////////////////////////
			}
			return self::$INITIATED;
		}//end if the person is still not quite passed
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
			->where('userpassed.time', '>', date('Y-m-d H:i:s', $end_of_time_frame))
			->where('userpassed.passed_id', '=', $passed_id)
			->find();
		
		return $initiator;
	}
	
	/**
	 * This will check to see if the current request has been cancelled for the passing of user specified by $passed_id
	 * @param int $passed_id
	 */
	public static function has_pass_request_been_canceled($passed_id)
	{
		//get the passed
		$passed = ORM::factory('user', $passed_id);
		
		//get the passed persons passing settings
		$passing_settings = Model_Passingsetting::get_setting($passed);
		
		//set the time frame
		$timeframe = $passing_settings->timeframe;
		
		//figure out now - minues timeframe
		$end_of_time_frame = time(); - ($timeframe * 60 * 60);
		
		$initiator_request = ORM::factory('userpassed')		
		->where('initiator', '=', '1')
		->where('time', '>', date('Y-m-d H:i:s', $end_of_time_frame))
		->where('passed_id', '=', $passed_id)
		->find();
		
		$cancelled_request = ORM::factory('userpassed')
		->where('confirm', '=', '0')
		->where('time', '>=', date('Y-m-d H:i:s', $initiator_request->time))
		->where('passed_id', '=', $passed_id)
		->order_by('time', 'DESC')
		->find();
		
		
		return $cancelled_request->loaded();
	}
	
	
	/**
	 * Use this to get the requests, confirmations, and rejections
	 * that are currently valid
	 * * @passed_id the Id of the user who might have passed
	 */
	public static function get_current_passed_requests($passed_id)
	{
		//get the passed
		$passed = ORM::factory('user', $passed_id);
		
		//get the passed persons passing settings
		$passing_settings = Model_Passingsetting::get_setting($passed);
		
		//set the time frame
		$timeframe = $passing_settings->timeframe;
		
		//figure out now - minues timeframe
		$end_of_time_frame = time(); - ($timeframe * 60 * 60);
		
		$initiator = ORM::factory('userpassed')
		->where('initiator', '=', '1')
		->where('time', '>', date('Y-m-d H:i:s', $end_of_time_frame))
		->where('passed_id', '=', $passed_id)
		->order_by('time', 'DESC')
		->find();
		
		//now get everything after that
		$passed_requests = ORM::factory('userpassed')
			->where('passed_id', '=',$passed_id)
			->where('time', '>=', $initiator->time)
			->order_by('time', 'DESC')
			->find_all();
		
		return $passed_requests;
		
	}
	
	/**
	 * Gets the most recent passed requests
	 * @passed_id the Id of the user who might have passed
	 */
	public static function get_last_passed_requests($passed_id)
	{
	
		$initiator = ORM::factory('userpassed')
		->where('initiator', '=', '1')
		->where('passed_id', '=', $passed_id)
		->order_by('time', 'DESC')
		->find();
	
		//now get everything after that
		$passed_requests = ORM::factory('userpassed')
		->where('passed_id', '=',$passed_id)
		->where('time', '>=', $initiator->time)
		->order_by('time', 'DESC')
		->find_all();
	
		return $passed_requests;
	
	}
	
	
	/**
	 * 
	 * @param obj $passed
	 */
	public static function is_gone($passed)
	{
		//first of all check if they're already set as gone
		if($passed->date_passed != null)
		{
			return true;
		}
		
		//get this person's passed settings
		$passing_settings = Model_Passingsetting::get_setting($passed);
		if(!$passing_settings->loaded())
		{
			return false;
		}
		
		//set the time frame
		$timeframe = $passing_settings->timeframe;
		
		//figure out now - minues timeframe
		$end_of_time_frame = time() - ($timeframe * 60 * 60);
		
		$userpassed = ORM::factory('userpassed')
		->where('userpassed.initiator', '=', '1')
		->where('userpassed.time', '>', date('Y-m-d H:i:s', $end_of_time_frame))
		->where('userpassed.passed_id', '=', $passed->id)
		->find();
		
		if(!$userpassed->loaded())
		{			
			//the time frame has passed
			return false;
		}
		//get all the people who have passed
		$passers = ORM::factory('userpassed')
		->where('userpassed.time', '>=', $userpassed->time)
		->where('userpassed.passed_id', '=', $passed->id)
		->find_all();
		
		$count= 1;
		foreach($passers as $passer)
		{
			if($passer->confirm == '0')
			{
				echo "3";
				exit;
				return false;
			}
			$count++;
		}
		
		if($count < $passing_settings->min_passers)
		{
			return false;
		}
		
		//set the user as passed
		$passed->date_passed = date('c');
		$passed->save();
		
		return true;
		
		
		
		
	}//end is gone
	
	

} // End Userpassed model
