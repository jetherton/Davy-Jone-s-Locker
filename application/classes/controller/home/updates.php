<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* updates.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/

class Controller_Home_Updates extends Controller_Home {


  	
	/**
	Show all of a users updates
	*/
	public function action_index()
	{
		
	
		
		//The title to show on the browser
		$this->template->html_head->title = __('updates');
		//update the content
		$this->template->content = view::factory("home/blocklist");
		$this->template->content->title = __('updates');
		$this->template->content->description = '';
		
		//turn on bricking
		$this->template->html_head->script_files[] = 'media/js/jquery.masonry.min.js';
		
		$js_view = view::factory('home/blocklist_js');
		$this->template->html_head->script_views[] = $js_view;
		
		//get the updates that belong to this user
		$this->template->content->block_view = 'home/block/update_block';
		$this->template->content->list = ORM::factory('update')
			->where('user_id','=',$this->user->id)
			->order_by('date_created','DESC')
			->find_all();
		
	}//end action_index
	
		
}//end of file upload class
