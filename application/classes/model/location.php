<?php defined('SYSPATH') or die('No direct access allowed.');
/***********************************************************
* location.php - Model
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
class Model_Location extends ORM {

	//belongs to a wish
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
			'zoom' => array(
				array('not_empty'),
				),
			'map_type' => array(
				array('not_empty'),
				),
			'lat' => array(
				array('not_empty'),
				),
			'lon' => array(
				array('not_empty'),
				),
	
			);		
	}
	
	
	/**
	* Create a new location
	*
	* Example usage:
	* ~~~
	* $location = ORM::factory('location')->create_location($_POST, $wish);
	* ~~~
	*
	* @param array $values
	* @param db_object $wish the wish to associate this location
	* @throws ORM_Validation_Exception
	*/
	public function create_location($values, $wish)
	{
		$expected = array('wish_id', 'zoom', 'map_type', 'lat', 'lon');
		$values['wish_id'] = $wish;
	
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}
	
	
	/**
	* Update an existing wish
	*
	* Example usage:
	* ~~~
	* $location = ORM::factory('location', $id)->update_location($_POST);
	* ~~~
	*
	* @param array $values
	* @throws ORM_Validation_Exception
	*/
	public function update_location($values)
	{
		
		$expected = array('zoom', 'map_type', 'lat', 'lon');
		$this->values($values, $expected);
		$this->check();
		$this->save();
	}
	
	/**
	 * Deletes the location assigned to a wish
	 */
	public static function delete_location($wish)
	{
		$location = ORM::factory('location')
			->and_where('wish_id', '=', $wish->id)
			->find();
		if($location->loaded())
		{
			$location->delete();
		}
	}
		
}//end class
