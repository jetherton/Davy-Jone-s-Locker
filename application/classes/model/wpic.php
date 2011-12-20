<?php defined('SYSPATH') or die('No direct access allowed.');
/***********************************************************
* wpic.php - Model
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
class Model_Wpic extends ORM {

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
	* Create a new picture
	*
	* Example usage:
	* ~~~
	* $picture = ORM::factory('wpic')->create_wish_pic($values, $user);
	* ~~~
	*
	* @param array $values
	* @throws ORM_Validation_Exception
	*/
	public function create_wish_pic($values)
	{
		$expected = array('file_name', 'wish_id', 'date_created', 'title');
		$now = date('Y-m-d G:i:s');
		$values['date_created'] = $now;
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}
	
	
	/**
	 * Returns the fully qualified path of the 
	 * thumbnail
	 */
	public function full_thumbnail()
	{
		return $this->get_upload_dir() . $this->get_file_name_wo_ext() . '_t.' . $this->get_extension();
	}
	
	/**
	 * Returns the fully qualified path of the 
	 * thumbnail for web use
	 */
	public function full_web_thumbnail()
	{
		return $this->get_upload_dir_web() . $this->get_file_name_wo_ext() . '_t.' . $this->get_extension();
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
		return  url::base().'uploads/';
	}
	
		
}//end class
