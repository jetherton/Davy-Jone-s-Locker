<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* file.php - Controller - for showing files in a very private way.
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/

class Controller_Home_File extends Controller_Home {


  	
	/**
	where users go to change their profiel
	*/
	public function action_index()
	{
		//not using templates
		$this->template = "";
		$this->auto_render = FALSE;
		
		//get the picture ID
		$file_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		//is the id valid?
		if($file_id == 0)
		{
			//record where the user was trying to go
			$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			Session::instance()->set('returnUrl',$url);			
			$this->request->redirect('home');
		}
		
		
		//does this image belong to the current user
		$file = Model_Wfile::verify_file_user($file_id, $this->user);
		
		if(!$file)
		{
			//record where the user was trying to go
			$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			Session::instance()->set('returnUrl',$url);			
			$this->request->redirect('home');
		}
		
		//so now we know the requestor has permission to see this file,
		//so lets give it to them.
		
		$path = $file->get_path();
		
		$file_contents = file_get_contents($path);
		
		$this->response
			->headers('Content-Type','application/'.$file->get_extension())
			->body($file_contents)
			->check_cache(sha1($this->request->uri()).filemtime($path), $this->request); // 304 ?
		
		
	}//end action_index
	
	
	
}//end of picture class
