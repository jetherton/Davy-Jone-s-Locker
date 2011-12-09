<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* friends.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/

class Controller_Home_Friends extends Controller_Home {


  	
	/**
	where users go to change their profiel
	*/
	public function action_index()
	{
		//The title to show on the browser
		$this->template->html_head->title = __("friends");
		//turn on messages
		$this->template->html_head->script_views[] = view::factory('js/messages');
		
		//add custom javascript for friends
		$this->template->html_head->script_views[] = view::factory('home/friends_js');
		$this->template->html_head->script_files[] = 'media/js/jquery-ui.min.js';
		$this->template->html_head->styles['media/css/jquery-ui.css'] = 'screen';
		
		//the name in the menu
		$this->template->header->menu_page = "friend";
		$this->template->content = view::factory("home/friends");
		$this->template->content->friends = $this->user->friends->find_all();
				
	}//end action_index
	
	
	/**
	 * Used to populate the autocomplete results
	 */
	public function action_search()
	{
		$this->template = null;
		$this->auto_render = false;
		
		if(!isset($_GET['term']))
		{
			return;
		}
		$q = $_GET["term"];
		if (!$q) return;

		$d = Database::instance('default');
		
		$sql = "SELECT DISTINCT CONCAT(first_name, ' ', last_name) as name, email, username, id FROM users WHERE (email LIKE '%$q%') OR (CONCAT(first_name, ' ', last_name) LIKE '%$q%') OR (username LIKE '%$q%') LIMIT 20";

		$users = $d->query(Database::SELECT, $sql);
		
		
		//create arrays, so we can then make json		
		$return_array = array();
		foreach($users as $user)
		{
			$row_array = array();
			$row_array['label'] = $user['name'] . ' ('. $user['email'].')';
			$row_array['value'] = $user['id'];
			array_push($return_array, $row_array); 
		}
		
		echo json_encode($return_array);
	}
	 

	
} // End class