<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* image.php - Controller - for showing images in a very private way.
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/

class Controller_Home_Picture extends Controller_Home {


  	
	/**
	where users go to change their profiel
	*/
	public function action_index()
	{
		//not using templates
		$this->template = "";
		$this->auto_render = FALSE;
		
		//get the picture ID
		$pic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		//is the id valid?
		if($pic_id == 0)
		{
			//record where the user was trying to go
			$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			Session::instance()->set('returnUrl',$url);			
			$this->request->redirect('home');
		}
		
		//is the image type valid?
		//get the picture type
		$pic_type = isset($_GET['type']) ? $_GET['type'] : 'x';
		if($pic_type != 'f' AND $pic_type != 'p' AND $pic_type != 't')
		{
			//record where the user was trying to go
			$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			Session::instance()->set('returnUrl',$url);			
			$this->request->redirect('home');
		}
		
		//does this image belong to the current user
		$image = Model_Wpic::verify_image_user($pic_id, $this->user);
		
		if(!$image)
		{
			//record where the user was trying to go
			$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			Session::instance()->set('returnUrl',$url);			
			$this->request->redirect('home');
		}
		
		//so now we know the requestor has permission to see this image,
		//so lets give it to them.
		
		//figure out the file path to the image
		if($pic_type == 'f')
		{
			$path = $image->full_fullsize();
		}
		else if ($pic_type == 'p')
		{
			$path = $image->full_passport();
		}
		else
		{
			$path = $image->full_thumbnail();
		}
		
		$file_size = filesize($path);
		$file = file_get_contents($path);
		
		$this->response
			->headers('Content-Type','image/'.$image->get_extension())
			->body($file)
			->check_cache(sha1($this->request->uri()).filemtime($path), $this->request); // 304 ?
		
		
	}//end action_index
	
	
	
}//end of picture class
