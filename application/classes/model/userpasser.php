<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Userpasser extends ORM {

	/**
	 * Gets the passers of this user
	 * @param user_obj $user
	 * @return array of passers
	 */
	public static function get_passer($user)
	{		
		return $user->passers->find_all();
	}
	
	/**
	 * Gets a passer for a user
	 * @param obj $user the user who we're seeing if we can find one of their passers
	 * @param unknown_type $passer_id the ID of a potential passer
	 * @return Ambigous <ORM, Database_Result, Kohana_ORM, object, mixed, number, Database_Result_Cached, multitype:>
	 */
	public static function get_one_passer($user, $passer_id)
	{
		return ORM::factory('user')
			->join('userpassers', 'left')
			->on('user.id', '=', 'userpassers.user_id')
			->where('userpassers.passer_id', '=', $passer_id)
			->where('userpassers.user_id', '=', $user->id)
			->find();
	}
	
	/**
	 * Add a passer
	 * @param obj $user
	 * @param int $passer_id
	 */
	public static function add_passer($user, $passer_id)
	{
		//make sure such a connection doesn't already exist
		$existing_passer = ORM::factory('userpasser')->where('user_id','=',$user->id)->where('passer_id','=',$passer_id);
		if($existing_passer->loaded())
		{
			return;
		}
		
		$passer = ORM::factory('userpasser');
		$passer->user_id = $user->id;
		$passer->passer_id = $passer_id;
		$passer->save();
		
		//make an update
		$message = __('update :user added you as a passer :id', array(':user'=>$user->full_name(), ':id'=>$user->id));
		ORM::factory('update')->create_update($message, $passer_id);
	}
	
	public static function delete_passer($user, $passer_id)
	{
		$passer = ORM::factory('userpasser')
			->where('user_id', '=', $user->id)
			->where('passer_id', '=', $passer_id)
			->find()
			->delete();
	}
	
} // End User Model
