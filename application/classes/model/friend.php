<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Friend extends ORM {

	public static $MY_FRIEND = 1;
	public static $THEIR_FRIEND = 2;
	public static $BOTH_FRIENDS = 3;

	/**
	 * Gets the friends of this user.
	 * But their friends and people who have added them
	 * Enter description here ...
	 * @param user_obj $user
	 * @return array of friends
	 */
	public static function get_friends($user)
	{
		$friends = array();
		$my_friends = $user->friends->find_all();
		
		//put my friends into an array
		foreach($my_friends as $my)
		{
			$friends[$my->id] = array('friend'=>$my, 'relationship'=>self::$MY_FRIEND);
		}
		
		$their_friends = ORM::factory('user')->
			join('friends', 'left')->
			on('user.id', '=', 'friends.user_id')->
			where('friends.friend_id', '=', $user->id)->
			find_all();
		
		//now put their friends into the array
		foreach($their_friends as $f)
		{
			if(!isset($friends[$f->id]))
			{
				$friends[$f->id] = array('friend'=>$f, 'relationship'=>self::$THEIR_FRIEND);
			}
			else
			{
				$friends[$f->id]['relationship'] = self::$BOTH_FRIENDS;
			}
		}
						
		return $friends;
	}
	
	
	/**
	 * Add a friend
	 * @param obj $user
	 * @param int $friend_id
	 */
	public static function add_friend($user, $friend_id)
	{
		$friend = ORM::factory('friend');
		$friend->user_id = $user->id;
		$friend->friend_id = $friend_id;
		$friend->save();
		
		//make an update
		$message = __('update :user added you as a friend :id', array(':user'=>$user->full_name(), ':id'=>$user->id));
		ORM::factory('update')->create_update($message, $friend_id);
	}
	
} // End User Model