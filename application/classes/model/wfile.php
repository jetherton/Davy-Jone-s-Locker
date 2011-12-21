<?php defined('SYSPATH') or die('No direct access allowed.');
/***********************************************************
* wfile.php - Model for storing the files that are associated with a wish
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
class Model_Wfile extends ORM {

	//belongs to a user
	protected $_belongs_to = array('wish' => array());
	
	/**
	 * Rules function
	 * @see Kohana_ORM::rules()
	 */
	public function rules()
	{
		return array(
			'wish_id' => array(
				array('not_empty'),
				),
	
			'file_name' => array(
				array('not_empty'),
				),
			'title' => array(
				array('not_empty'),
				)
			);		
	}
	
	
	/**
	* Create a new file
	*
	* Example usage:
	* ~~~
	* $file = ORM::factory('wfile')->create_wish_pic($values);
	* ~~~
	*
	* @param array $values
	* @throws ORM_Validation_Exception
	*/
	public function create_wish_file($values)
	{
		$expected = array('file_name', 'wish_id', 'date_created', 'title');
		$now = date('Y-m-d G:i:s');
		$values['date_created'] = $now;
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}
	
	
	/**
	 * Get full path of file on the file system
	 */
	 public function get_path()
	 {
		 return $this->get_upload_dir().$this->get_file_name_wo_ext().'.'.$this->get_extension();
	 }
	 
	 /**
	 * Get link to this file from the web
	 */
	 public function get_link()
	 {
		 return $this->get_upload_dir_web().'?id='.$this->id;
	 }
	
	/**
	 * Get the extension of this file
	 */
	public function get_extension()
	{
		return substr($this->file_name, 1 + strrpos($this->file_name, '.'));
	}
	
	/**
	 * Get the name of the file, minus the extension
	 */
	public function get_file_name_wo_ext()
	{
		return substr($this->file_name, 0, strrpos($this->file_name, '.'));
	}
	
	/**
	 * Returns the upload directory for images
	 */
	public function get_upload_dir()
	{
		return  getcwd().'/uploads/';
	}
	
		/**
	 * Returns the upload directory for images
	 */
	public function get_upload_dir_web()
	{
		return  url::base().'home/file';
	}
	
	/**
	 * This tells you if the given file can be accessed by the given user
	 * and is a valid image
	 * @param $file_id int
	 * @param $user object
	 * @return false if the image isn't valid, otherwise the image object
	 */
	public static function verify_file_user($file_id, $user, $only_owner = false)
	{
		//get the image
		$file = ORM::factory('wfile', $file_id);
		
		if(!$file->loaded())
		{
			return false;
		}
		
		$wish = ORM::factory('wish', $file->wish_id);
		if($user->id == $wish->user_id)
		{
			return $file;
		}
		
		if($only_owner)
		{
			return false;
		}
		
		//or maybe this image belongs to a wish, that the current user is allowed to see
		$friends_wish = Model_Wish::get_friends_wish($wish->id, $user->id);
		if($friends_wish)
		{
			return $file;
		}
		
		return false;

	}//end function
	
		
}//end class
