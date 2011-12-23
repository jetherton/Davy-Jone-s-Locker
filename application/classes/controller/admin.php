<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Admin.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 8/20/2011
*************************************************************/

class Controller_Admin extends Controller_Home {

	/**
	Set stuff up
	*/
	public function before()
	{
		parent::before();
		
		
		//make sure they're an admin
		$admin_role = ORM::factory('role')->where("name", "=", "admin")->find();
		if(! $this->user->has('roles', $admin_role) )
		{
			$this->request->redirect('home');
		}
		
	}
	
	
	

	
	
  	
	
	
	
} // End Welcome
