<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* wishes.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/

class Controller_Home_Wishes extends Controller_Home {


  	
	/**
	Show all of a users updates
	*/
	public function action_index()
	{
		
	
		
		//The title to show on the browser
		$this->template->html_head->title = __('your information');
		//update the content
		$this->template->content = view::factory("home/blocklist");
		$this->template->content->title = __('your information');
		$this->template->content->description = '';
		$this->template->content->empty_string = __('you have no wishes');
		
		//turn on bricking
		$this->template->html_head->script_files[] = 'media/js/jquery.masonry.min.js';
		
		$js_view = view::factory('home/blocklist_js');
		$this->template->html_head->script_views[] = $js_view;
		
		//get the updates that belong to this user
		$this->template->content->block_view = 'home/block/wish_block';
		$this->template->content->list = ORM::factory('wish')
			->where('user_id','=', $this->user->id)
			->where('is_live','=','1')
			->order_by('date_modified', 'DESC')
			->find_all();
		
	}//end action_index
	
		
}//end of file upload class
