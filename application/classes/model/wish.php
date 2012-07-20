<?php defined('SYSPATH') or die('No direct access allowed.');
/***********************************************************
* wish.php - Model
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
class Model_Wish extends ORM {

	public static $timing_types = array(1=>'After I pass',
			2=>'After a set time',
			3=>'Now');
	
	//belongs to a user
	protected $_belongs_to = array('user' => array(), 'form'=>array());
	
	protected $_has_many =  array(
			'wpics' => array('model' => 'wpic'),
			'wfiles' => array('model' => 'wfile'),
			'formfieldresponse'=> array('model' => 'formfieldresponse'),
	);
	
	
	/**
	 * Rules function
	 * @see Kohana_ORM::rules()
	 */
	public function rules()
	{
		return array(
				
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
		$expected = array('html', 'date_created', 'date_modified', 'user_id', 'is_live', 'form_id');
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
	 * Gets the data for this wish that will show up in the block
	 */
	public function get_block_fields()
	{
	
		$sql = 'SELECT ffr.id AS response_id, ffr.response AS response_value, ffr.formfield_id AS form_id, `formfields`.`type` AS'. 
			' `type` FROM  `formfieldresponses` AS ffr'.
			' LEFT JOIN formfields ON ffr.formfield_id = formfields.id'.		
			' WHERE ffr.wish_id = '.$this->id.
			' AND formfields.show_in_block = 1'.
			' ORDER BY formfields.order';
		
		

		$query = DB::query(Database::SELECT, $sql);
		$data = $query->execute();
		$ret_val = array();
		
		
		
		foreach($data as $d)
		{
			if($d['type'] == '4' OR $d['type'] == '5' OR $d['type'] == '6')
			{
				$option = ORM::factory('formfieldoption', $d['response_value']);
				$ret_val[$d['response_id']] = $option->title;
			}
			else
			{
				//just grab the value
				$ret_val[$d['response_id']] = $d['response_value'];
			}
			
		}
		
		if(count($ret_val) == 0)
		{
			$ret_val[0] = $this->form->title;
		}
	
		return $ret_val;
		
	}
	
	/**
	 * Gets the title
	 */
	public function get_title()
	{
	
		$sql = 'SELECT ffr.id AS response_id, ffr.response AS response_value, ffr.formfield_id AS form_id, `formfields`.`type` AS'.
				' `type` FROM  `formfieldresponses` AS ffr'.
				' LEFT JOIN formfields ON ffr.formfield_id = formfields.id'.
				' WHERE ffr.wish_id = '.$this->id.
				' AND formfields.show_in_block = 1'.
				' ORDER BY formfields.order LIMIT 1';
	
	
	
		$query = DB::query(Database::SELECT, $sql);
		$data = $query->execute();
	
	
	
		foreach($data as $d)
		{
			if($d['type'] == '4' OR $d['type'] == '5' OR $d['type'] == '6')
			{
				$option = ORM::factory('formfieldoption', $d['response_value']);
				return $option->title;
			}
			else
			{
				//just grab the value
				return $d['response_value'];
			}
				
		}
	
		return ORM::factory('form', $this->form_id)->title;
	
	}
	
	
	
	
	/**
	 * Gets the title based on the wish ID and the form ID
	 * @param unknown_type $wish_id wish whose title we want
	 * @param unknown_type $form_id the form id 
	 * @return string
	 */
	public static function get_title_static($wish_id, $form_id)
	{
	
		$sql = 'SELECT ffr.id AS response_id, ffr.response AS response_value, ffr.formfield_id AS form_id, `formfields`.`type` AS'.
				' `type` FROM  `formfieldresponses` AS ffr'.
				' LEFT JOIN formfields ON ffr.formfield_id = formfields.id'.
				' WHERE ffr.wish_id = '.$wish_id.
				' AND formfields.show_in_block = 1'.
				' ORDER BY formfields.order LIMIT 1';
	
	
	
		$query = DB::query(Database::SELECT, $sql);
		$data = $query->execute();
	
	
	
		foreach($data as $d)
		{
			if($d['type'] == '4' OR $d['type'] == '5' OR $d['type'] == '6')
			{
				$option = ORM::factory('formfieldoption', $d['response_value']);
				return $option->title;
			}
			else
			{
				//just grab the value
				return $d['response_value'];
			}
	
		}
	
		return ORM::factory('form', $form_id)->title;
	
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
		$sql = "SELECT  `wish`. * , `friends_wishes`.`timing_type` as `timing_type`, `friends_wishes`.`dead_line` as `dead_line`, 
			`friends_wishes`.`user_can_know` as `user_can_know`,
			`forms`.`title` as `form_title` 
			FROM  `wishes` AS  `wish` 
			JOIN  `friends_wishes` ON (`friends_wishes`.`wish_id` =  `wish`.`id`) 
			JOIN  `forms` ON (  `wish`.`form_id` =  `forms`.`id` )
			JOIN  `users` ON (  `users`.`id` =  `wish`.`user_id` ) 
			WHERE  `friends_wishes`.`friend_id` =  '".$user->id."'
			AND  (`friends_wishes`.`user_can_know` = 1 OR 
				(`friends_wishes`.`timing_type` = 1 AND `users`.`date_passed` IS NOT NULL) OR
				(`friends_wishes`.`timing_type` = 2 AND `friends_wishes`.`dead_line` <=  CURDATE()) OR
				(`friends_wishes`.`timing_type` = 3) )
			AND  `wish`.`user_id` =  '".$friend->id."'
			AND  `wish`.`is_live` =1
			ORDER BY  `forms`.`title` ASC ";

		$query = DB::query(Database::SELECT, $sql);
		$wishes_from_friend = $query->execute();
		
		
		$wishes_from_me = ORM::factory('wish')
			->join('friends_wishes')
			->on( 'friends_wishes.wish_id', '=', 'wish.id')
			->join('forms')
			->on('wish.form_id', '=', 'forms.id')
			->and_where('friends_wishes.friend_id', '=', $friend->id)
			->and_where('wish.user_id', '=', $user->id)
			->and_where('wish.is_live', '=', 1)
			->order_by('forms.title', 'ASC')
			->find_all();
		
		return array('from_friend'=>$wishes_from_friend, 'from_me'=>$wishes_from_me);
	}
	
	
	/**
	 * 
	 * Gets a wish from a friend, or false if I'm not allowed
	 * @param obj $wish
	 * @param obj $user
	 * @return obj or bool if not allowed
	 */
	public static function get_friends_wish($wish, $user)
	{
		
		$sql = "SELECT  `wish` . * 
			FROM  `wishes` AS  `wish` 
			JOIN  `friends_wishes` ON (  `friends_wishes`.`wish_id` =  `wish`.`id` )
			JOIN  `users` ON (`users`.`id` = `wish`.`user_id`) 
			WHERE  `friends_wishes`.`friend_id` =  '".$user->id."'
			AND ( (`friends_wishes`.`timing_type` = 2 AND `friends_wishes`.`dead_line` <=  CURDATE()) OR
			(`friends_wishes`.`timing_type` = 1 AND `users`.`date_passed` IS NOT NULL) OR
			(`friends_wishes`.`timing_type` = 3) ) 
			AND  `wish`.`id` =  '".$wish->id."' 
			AND  `wish`.`is_live` = 1 
			LIMIT 1";
		
		$query = DB::query(database::SELECT, $sql);
		$result = $query->execute();
		foreach($result as $r)
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
		
		
		if($wish->loaded() && ($wish_title = $wish->get_title()) != '')
		{
			//etherton fix this later so it only fires when it is supposed to
			/*
			//make an update	
			$message = __('update :user sent you :wish :wish-id :user-id :user', array(':user'=>$user->full_name(), 
				':wish'=>$wish_title,			
				':wish-id'=>$wish_id,
				':user-id'=>$user->id));
			ORM::factory('update')->create_update($message, $friend_id);
			*/
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
	
	
	/**
	 * Gets the wishes that belong to a user under a given category
	 * returns a DB array
	 * @param unknown_type $cat_id given category id
	 * @param unknown_type $user_id given user ID
	 */
	public static function get_my_wishes_for_cat($cat_id, $user_id)
	{
		return ORM::factory('wish')
			->join('forms', 'LEFT')			
			->on('forms.id', '=', 'wish.form_id')
			->and_where('user_id', '=', $user_id)
			->and_where('forms.category_id', '=', $cat_id)
			->and_where('is_live', '=', 1)
			->order_by('forms.order','ASC')
			->find_all();
	}
	
	/**
	 * This will return all the wishes you have under a given parent category
	 * return an array
	 * @param int $parent_cat_id the given parent category
	 * @param int $parent_cat_id user id of the user we're gettin these wishes for
	 */
	public static function find_your_wishes_for_all_sub_cats($parent_cat_id, $user_id)
	{
		$ret_val = array('id'=>$parent_cat_id, 'wishes'=>array(), 'kids'=>array());
		//get wishes for this level
		$wishes = self::get_my_wishes_for_cat($parent_cat_id, $user_id);
		foreach($wishes as $wish)
		{
			$ret_val['wishes'][$wish->id] = $wish;
		}
		
		//get the sub cats
		$kid_cats = ORM::factory('category')
			->where('parent_id', '=', $parent_cat_id)
			->order_by('order', 'ASC')
			->find_all();
		
		
		foreach($kid_cats as $kid_cat)
		{
			$ret_val['kids'][$kid_cat->id] = self::find_your_wishes_for_all_sub_cats($kid_cat->id, $user_id);
		}
		
		return $ret_val;
	}
	
	/**
	 * This will return all the wishes you have under a given parent category
	 * return an array
	 * @param int $parent_cat_id the given parent category
	 * @param int $parent_cat_id user id of the user we're gettin these wishes for
	 */
	public static function find_your_wishes_for_all_sub_cats_flat($parent_cat_id, $user_id)
	{
		$ret_val = array();
		
	
		//get the sub cats
		$kid_cats = ORM::factory('category')
		->where('parent_id', '=', $parent_cat_id)
		->order_by('order', 'ASC')
		->find_all();
	
	
		foreach($kid_cats as $kid_cat)
		{
			$ret_val[$kid_cat->id] = array();
			
			//get wishes for this level
			$wishes = self::get_my_wishes_for_cat($kid_cat->id, $user_id);
			foreach($wishes as $wish)
			{
				$ret_val[$kid_cat->id][$wish->id] = $wish;
				$kid_kid_wishes = self::find_your_wishes_for_all_sub_cats_flat($kid_cat->id, $user_id);
				//put those into this array to make things flat
				foreach($kid_kid_wishes as $kk_cat_id=>$kk_wishes)
				{
					foreach($kk_wishes as $kk_wish_id=>$kk_wish)
					{
						$ret_val[$kid_cat->id][$kk_wish_id] = $kk_wish;
					}					
				}
				unset($kid_kid_wishes);
			}
		}
	
		return $ret_val;
	}
		
}//end class
