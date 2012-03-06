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
		$this->template->content->friends = Model_Friend::get_friends($this->user);

				
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
		
		$sql = "SELECT DISTINCT CONCAT(first_name, ' ', last_name) as name, email, username, id FROM users
			WHERE ((email LIKE '%$q%') OR (CONCAT(first_name, ' ', last_name) LIKE '%$q%') OR (username LIKE '%$q%')) AND (id <> ".$this->user->id." AND ID NOT IN(SELECT friend_id from friends WHERE user_id = ".$this->user->id.")) LIMIT 20";

		
		$users = $d->query(Database::SELECT, $sql);
		
		
		//create arrays, so we can then make json		
		$return_array = array();
		foreach($users as $user)
		{
			if($this->user->id == $user['id'])
			{
				continue; //don't show them, themself
			}
			$row_array = array();
			$row_array['label'] = $user['name'] . ' ('. $user['email'].')';
			$row_array['value'] = $user['id'];
			array_push($return_array, $row_array); 
		}
		
		echo json_encode($return_array);
	}
	 
	
	/**
	 * This function is used to add a friend
	 * It takes friendid as get param so it knows which user to add as a friend
	 * Enter description here ...
	 */
	public function action_addfriend()
	{
		$this->template = null;
		$this->auto_render = false;
		
		//make sure the data is in a valid format
		if(isset($_GET['friendid']) && intval($_GET['friendid'])>0 )
		{
			$friend_id = $_GET['friendid'];
			//makre sure you're not adding yourself
			if($friend_id != $this->user->id)
			{				
				try 
				{	
					
					Model_Friend::add_friend($this->user, $friend_id);
					
					//create the table view
					$view = view::factory('home/friends_list');
					$view->friends = Model_friend::get_friends($this->user); 

					
					echo json_encode(array('status'=>'success','payload'=>$view->render()));
					return;					
				}
				catch(Exception $e)
				{
					echo json_encode(array('status'=>'error','payload'=>__('error occured while trying to add user as friend')));
					return;
				}
			}
		}
		
		echo json_encode(array('status'=>'error','payload'=>__('error occured while trying to add user as friend'). ' Input parameters do not seem to be formated correctly'));
		return;
	}//end addfriend
	
	
	/**
	 * This action is used to show details about a friend, including their wishes that they
	 * have shared with the user
	 */
	public function action_view()
	{

		//get the friend id
		$friend_id = isset($_GET['id']) ? $_GET['id'] : 0;
		//is it a valid friend number
		if(intval($friend_id) < 1)
		{
			$this->request->redirect('home/friends');
		}
		//Does this person exist?
		$friend = ORM::factory('user', $friend_id);
		if(!$friend->loaded())
		{
			$this->request->redirect('home/friends');
		}
		
		//are we really friends with them, or are they friends with us, or what?
		$is_my_friend = $this->user->has('friends', $friend_id);
		if(!$is_my_friend AND !$friend->has('friends', $this->user->id))
		{
			$this->request->redirect('home/friends');
		}

		//did it load
		if(!$friend->loaded())
		{
			$this->request->redirect('home/friends');
		}
		
		if(!empty($_POST)) // They want to perform an action, probably deleting this friend
		{
			if(isset($_POST['action']) AND $_POST['action'] == 'delete')
			{
				//delete the friendship
				$this->user->remove('friends', $friend_id);
					
				$this->request->redirect('home/friends');
			}
		}
		
		
		//make sure the JS works
		$this->template->html_head->script_views[] = view::factory('home/friend_view_js');
		
		//setup the view		
		$this->template->content = view::factory('home/friend_view');
		$this->template->content->friend = $friend;
		$this->template->content->wishes = Model_Wish::get_wishes_between_friends($this->user, $friend);
		$this->template->content->is_my_friend = $is_my_friend;
		 
		
	}//end action_view()
	
	
} // End class
