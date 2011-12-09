<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Auth_User {

	/**
	 * A user has many tokens and roles
	 *
	 * @var array Relationhips
	 */
	protected $_has_many =  array(
		'user_tokens' => array('model' => 'user_token'),
		'roles'       => array('model' => 'role', 'through' => 'roles_users'),
		'wish'		  => array(),
		'friends'       => array('model' => 'user', 'through' => 'friends', 'far_key'=>'friend_id', 'foreign_key'=>'user_id'),
	);

	
} // End User Model