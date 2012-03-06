<?php defined('SYSPATH') or die('No direct access allowed.');
/***********************************************************
* wish.php - Model
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
class Model_Wish extends ORM {

	//belongs to a user
	protected $_belongs_to = array('user' => array(), 'form'=>array());
	
	protected $_has_many =  array(
			'wpics' => array('model' => 'wpic'),
			'wfiles' => array('model' => 'wfile'),
	);
	
	
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
	
			'form_id'=>array(array('not_empty')),		
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
		$expected = array('title', 'html', 'date_created', 'date_modified', 'user_id', 'is_live', 'form_id');
		$now = date('Y-m-d G:i:s');
		$values['date_created'] = $now;
		$values['date_modified'] = $now;
		$values['user_id'] = $user->id;
		$values['is_live'] = 0;
	
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
		
		$expected = array('title', 'html', 'date_modified', 'user_id', 'is_live');
		$now = date('Y-m-d G:i:s');
		$values['date_modified'] = $now;
		$values['user_id'] = $user->id;
		$values['is_live'] = 1;
	
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}
	
	/**
	 * This will return an array of wishes
	 * that two friends have shared with one another
	 * @param user $user
	 * @param user $friend
	 * @return array of wishes
	 */
	public static function get_wishes_between_friends($user, $friend)
	{
		$wishes_from_friend = ORM::factory('wish')
			->join('friends_wishes')
			->on( 'friends_wishes.wish_id', '=', 'wish.id')
			->and_where('friends_wishes.friend_id', '=', $user->id)
			->and_where('wish.user_id', '=', $friend->id)
			->and_where('wish.is_live', '=', 1)
			->order_by('title', 'ASC')
			->find_all();
		
		$wishes_from_me = ORM::factory('wish')
			->join('friends_wishes')
			->on( 'friends_wishes.wish_id', '=', 'wish.id')
			->and_where('friends_wishes.friend_id', '=', $friend->id)
			->and_where('wish.user_id', '=', $user->id)
			->and_where('wish.is_live', '=', 1)
			->order_by('title', 'ASC')
			->find_all();
		
		return array('from_friend'=>$wishes_from_friend, 'from_me'=>$wishes_from_me);
	}
	
	
	/**
	 * 
	 * Gets a wish from a friend, or false if I'm not allowed
	 * @param int $wish_id
	 * @param int $user_id
	 * @return obj or bool if not allowed
	 */
	public static function get_friends_wish($wish_id, $user_id)
	{
		$wish = ORM::factory('wish')
		->join('friends_wishes')
		->on( 'friends_wishes.wish_id', '=', 'wish.id')
		->and_where('friends_wishes.friend_id', '=', $user_id)
		->and_where('wish.id', '=', $wish_id)
		->and_where('wish.is_live', '=', 1)
		->find();
		
		if($wish->loaded())
		{
			return $wish;
		}
		
		return false;
	}
	
	/**
	 * This function will validate a wish ID
	 * @param int $id
	 * @param bool $is_add - if this is the result of an add controller than ignore the is_alive bit
	 * @return object wish object or false, depending on the validity of the ID
	 */
	public static function validate_id($id, $is_add = false)
	{
		$id = intval($id);
		//if id is properly formated
		if($id < 1)
		{
			return false;
		}
		
		$wish = ORM::factory('wish', $id);
		//if the wish is the product of an add
		if($is_add == 1)
		{
			if($wish->loaded())
			{
				return $wish;
			}
		}
		//not the product of an add
		else
		{
			if($wish->loaded() AND intval($wish->is_live) == 1)
			{
				return $wish;
			}
		}
		
		return false;
	}
	
	
	/**
	 * Makes sure a wish is valid and belongs to the given user
	 * Enter description here ...
	 * @param int $id
	 * @param obj $user
	 * @param bool $is_add - if this is the result of an add controller than ignore the is_alive bit
	 * @return object - or false if not valid 
	 */
	public static function validate_id_user($id, $user, $is_add = false)
	{
		//is the wish good
		$wish = self::validate_id($id, $is_add); 
		if(!$wish)
		{
			return false;
		}
		
		//is the wish mine
		if($wish->user_id == $user->id)
		{
			return $wish;
		}
		return false;
	}
	
	
	/**
	 * This function will link a wish to a friend
	 * It will also issue the requisite updates
	 * @param int $wish_id
	 * @param int $friend_id
	 */
	public static function add_friend_to_wish($wish_id, $friend_id, $user)
	{

		$friends_wish = ORM::factory('friendswishes');
		$friends_wish->friend_id = $friend_id;
		$friends_wish->wish_id = $wish_id;
		$friends_wish->save();

		
		$wish = ORM::factory('wish', $wish_id);
		
	
		if($wish->loaded() && $wish->title != '')
		{
			//make an update	
			$message = __('update :user sent you :wish :wish-id :user-id :user', array(':user'=>$user->full_name(), 
				':wish'=>$wish->title,			
				':wish-id'=>$wish_id,
				':user-id'=>$user->id));
			ORM::factory('update')->create_update($message, $friend_id);
		}
	}//end method
	
	/**
	 * This function will link a wish field to a friend
	 * It will also issue the requisite updates
	 * @param int $wish_id
	 * @param int $field_id
	 * @param int $friend_id
	 */
	public static function add_friend_to_wish_field($wish_id, $friend_id, $field_id)
	{

		$friends_field = ORM::factory('friendsfields');
		$friends_field->friend_id = $friend_id;
		$friends_field->wish_id = $wish_id;
		$friends_field->formfield_id = $field_id;
		$friends_field->save();

	}//end method
	
	
	/**
	 * This function will remove a wish to a friend
	 * It will also issue the requisite updates
	 * @param int $wish_id
	 * @param int $field_id
	 * @param int $friend_id
	 */
	public static function remove_friend_from_wish_field($wish_id, $friend_id, $field_id)
	{
			
		db::delete('friends_fields')->and_where('friend_id', '=', $friend_id)
			->and_where('wish_id', '=', $wish_id)
			->and_where('formfield_id', '=', $field_id)
			->execute();
	}//end method
		
}//end class
