<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* wish.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/

class Controller_Home_Wish extends Controller_Home {


  	
	/**
	where users go to change their profiel
	*/
	public function action_index()
	{
		
		//figure out what the category is, if not category, go home
		$cat_id = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
		if($cat_id == 0)
		{
			$this->request->redirect("home");
		}
		$cat = ORM::factory('category', $cat_id);
		if(!$cat->loaded())
		{
			$this->request->redirect("home");
		}
		
		
		//The title to show on the browser
		$this->template->html_head->title = $cat->title;
		//make messages roll up when done
		$this->template->html_head->messages_roll_up = true;
		//the name in the menu
		$this->template->header->menu_page = "cat_".$cat->title;
		$this->template->content = view::factory("home/wish");
		$this->template->content->cat = $cat;
		
		//get the wishes that belong to this user
		$wishes = ORM::factory("wish")
			->join('forms')
			->on('wish.form_id', '=', 'forms.id')
			->and_where('user_id', '=', $this->user->id)
			->and_where('forms.category_id', '=', $cat_id)
			->order_by('title', 'ASC')
			->find_all();
		
		$this->template->content->wishes = $wishes;
		
		//get the forms that correspond to this category
		$forms = ORM::factory('form')
			->and_where('category_id', '=', $cat_id)
			->order_by('order')
			->find_all();
		$this->template->content->forms = $forms;
		
	}//end action_index
	
	
	/**
	 * Used for adding new wishes, just calls edit where all the real work is done
	 */
	public function action_add()
	{
		$this->action_edit();		
	}
	
	
	/**
	 * Method for adding/editing wishes
	 * Enter description here ...
	 */
	public function action_edit()
	{
		//get the wish id
		$wish_id = isset($_GET['id']) ? $_GET['id'] : 0;
		
		$form_id = isset($_GET['form']) ? $_GET['form'] : 0;
		
		//can't not have both wish and form_id
		if($wish_id == 0 AND $form_id == 0)
		{
			$this->request->redirect('home');
		}
		
		
		//get message from session params if any
		$session_message = Session::instance()->get_once('message','<none>');
		$messages = '<none>' == $session_message ? array() : array(__($session_message));
		
		//turn on Tiny MCE
		$this->template->html_head->script_views[] = view::factory('js/tinymce');
		
		//turn on messages
		$this->template->html_head->script_views[] = view::factory('js/messages');
		
		//turn on accodion
		$this->template->html_head->script_files[] = 'media/js/jquery-ui.min.js';
		$this->template->html_head->styles['media/css/jquery-ui.css'] = 'screen';
		$this->template->html_head->script_views[] = view::factory('js/accordion');
		
		//turn on picture upload
		$this->template->html_head->script_files[] = 'media/js/fileuploader.js';
		$this->template->html_head->styles['media/css/fileuploader.css'] = 'screen';
		$picture_uploader_view = view::factory('js/pictureuploader');
		$picture_uploader_view->element_id = 'image_uploader';
		$picture_uploader_view->extension = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
		
		//turn on file upload
		$file_uploader_view = view::factory('js/fileuploader');
		$file_uploader_view->element_id = 'file_uploader';
		
		//turn on the map
		$map_view = view::factory('js/googlemaps');
		$map_view->element_id = 'map';
		$this->template->html_head->script_views[] =  $map_view;
		
		//turn on div blocking
		$this->template->html_head->script_files[] = 'media/js/jquery.blockUI.js';
		
		
		
		$this->template->content = view::factory("home/wish_edit");
		$this->template->content->errors = array();
		$this->template->content->messages = $messages;
		
		//turn set focus on title
		$this->template->html_head->script_views[] = '<script type="text/javascript">$(document).ready(function() {$("#title").focus();});</script>';
		
		//get a list of friends so we can let them view our wish
		$this->template->content->friends = $this->user->friends->find_all();
		$this->template->content->is_add = false;
		
		
		if($wish_id == 0)
		{
			//set the view to know that we're adding 
			$this->template->content->is_add = true;
			
			//since this is an add, must have a form id
			$form = ORM::factory('form',$form_id);
			if(!$form->loaded())
			{
				$this->request->redirect("home");
			}
			
			//create this wish
			$values = array('title'=>' ', 'html'=>' ', 'form_id'=>$form_id);
			$wish = ORM::factory('wish');		
			$wish->create_wish($values, $this->user);
			$wish->title = '';
			$wish->html = '';
			//The title to show on the browser
			$this->template->html_head->title = __("add wish");
			//the name in the menu
			$this->template->header->menu_page = "wish";
			//setup view			
			$this->template->content->title = __('add wish');
			$this->template->content->explanation = __('add wish explanation');
			$this->template->content->wish = $wish;
			$this->template->content->submit_button = __('add wish');
			
			//delete any outstanding wishes
			$day_ago = date('Y-m-d G:i:s', time()-(24*60*60));
			$old_wishes = ORM::factory('wish')->
				and_where('is_live', '=', 0)->
				and_where('date_created', '<', $day_ago )->
				and_where('user_id', '=', $this->user->id)->
				find_all();
			foreach($old_wishes as $w)
			{
				$temp = $w->user_id;
				$w->delete();
			}
		}
		else
		{
			//ETHERTON: this is kludgey and needs to be refactored 
			$is_add = false;
			if(!empty($_POST)) // They've submitted the form to update his/her wish
			{
				$is_add = intval($_POST['is_add']);
			}
			
			$wish = Model_Wish::validate_id_user($wish_id, $this->user, $is_add);
			if(!$wish)
			{
				$this->request->redirect("home");
			}
			//use the wishes form, not what the URL says
			$form = ORM::factory('form', $wish->form_id);
			if(!$form->loaded())
			{
				$this->request->redirect("home");
			}
			
			//The title to show on the browser
			$this->template->html_head->title = __("edit wish"). ' :: '. $wish->title;
			//the name in the menu
			$this->template->header->menu_page = "wish";
			//setup view
			$this->template->content->title = __('edit wish') . ' - '. $wish->title;
			$this->template->content->explanation = __('edit wish explanation');
			$this->template->content->wish = $wish;
			$this->template->content->submit_button = __('edit wish');			
		}
		$wish_id = $wish->id;
		
		$js_view = view::factory('home/wish_edit_js');
		$js_view->wish = $wish;
		$this->template->html_head->script_views[] = $js_view;
		
		
		//nail down that mysterious wish ID		
		$picture_uploader_view->wish_id = $wish_id;
		$file_uploader_view->wish_id = $wish_id;
		$this->template->html_head->script_views[] = $picture_uploader_view;
		$this->template->html_head->script_views[] = $file_uploader_view;
		
		//get the pictures associated with this wish		
		$this->template->content->pictures = $wish->wpics->find_all();
		
		//get the files associated with this wish		
		$this->template->content->files = $wish->wfiles->find_all();
		
		//get the form associated with this wish
		$this->template->content->form = $form;
		
		if(!empty($_POST)) // They've submitted the form to update his/her wish
		{

			try
			{
				//did they want to delete it?
				if($_POST['action'] == 'delete')
				{
					$wish->delete();
					$this->request->redirect("home/wish");
				}
				else
				{
					//or do they want to edit it?
					$wish->update_wish($_POST, $this->user);
					$this->template->content->messages[] = __('wish edited successfully');
				}

			}
			catch (ORM_Validation_Exception $e)
			{
				$errors_temp = $e->errors('register');
				if(isset($errors_temp["_external"]))
				{
					$this->template->content->errors = array_merge($errors_temp["_external"], $this->template->content->errors);
				}				
				else
				{
					foreach($errors_temp as $error)
					{
						if(is_string($error))
						{
							$this->template->content->errors[] = $error;							
						}
					}
				}
			}	
		}//end if(!empty($_POST))
		
		if($wish_id != 0)
		{
			//setup view
			$this->template->html_head->title = __("edit wish"). ' :: '. $wish->title;
			$this->template->content->title = __('edit wish') . ' - '. $wish->title;
			$this->template->content->wish = $wish;
		}
	}//end function action_edit
	
	
	
	
	
	/**
	 * This function will add friends to a wish
	 */
	public function action_addfriendwish()
	{
		$this->template = "";
		$this->auto_render = FALSE;
		//make sure the requried get arguements are present
		if(!isset($_GET['wish_id']))
		{
			echo json_encode(array("status"=>'error', "response"=>'wish_id not set'));
			return;
		}
		if(!isset($_GET['friend_id']))
		{
			echo json_encode(array("status"=>'error', "response"=>'friend_id not set'));
			return;
		}
		if(!isset($_GET['add']))
		{
			echo json_encode(array("status"=>'error', "response"=>'add not set'));
			return;
		}
		
		//make sure the required data is of a valid format
		$wish_id = intval($_GET['wish_id']);
		$friend_id = intval($_GET['friend_id']);
		$add = intval($_GET['add']);
		if($wish_id < 1)
		{
			echo json_encode(array("status"=>'error', "response"=>'wish_id not properly formatted'));
			return;
		}
		
		if($friend_id < 1)
		{
			echo json_encode(array("status"=>'error', "response"=>'friend_id not properly formatted'));
			return;
		}
		
		if($add != 1 AND $add != 2)
		{
			echo json_encode(array("status"=>'error', "response"=>'add not properly formatted'));
			return;
		}
		
		//make sure the wish and the friend exists
		$friend = ORM::factory('user', $friend_id);
		$wish = ORM::factory('wish', $wish_id);
		
		if(!$friend->loaded())
		{
			echo json_encode(array("status"=>'error', "response"=>'no such friend'));
			return;
		}
		if(!$wish->loaded())
		{
			echo json_encode(array("status"=>'error', "response"=>'no such wish'));
			return;
		}
		
		//so finally we have valid input, lets do what we came here to do.
		if($add == 1)
		{
			//try to update the wish, if possible
			try			
			{
				$wish->update_wish($_POST, $this->user);
			}
			catch(Exception $e)
			{}
			
			Model_Wish::add_friend_to_wish($wish_id, $friend_id, $this->user);
			
			echo json_encode(array("status"=>'success', "response"=>'added', 'friend_id'=>$friend_id));
			return;
		}
		else
		{
			$friend->remove('friends_wishes', $wish_id);

			echo json_encode(array("status"=>'success', "response"=>'removed','friend_id'=>$friend_id));
			return;
		}
		
	}//end addfriendwish
	
	/**
	 * Render the page for viewing someone else's wish
	 * Enter description here ...
	 */
	public function action_view()
	{
		if(!isset($_GET['id']))
		{
			$this->request->redirect("home/wish");
		}
		$wish = Model_Wish::validate_id($_GET['id']);
		if(!$wish)
		{
			$this->request->redirect("home/wish");
		}
		
		//does the current user have access to this wish?
		//is it my wish, if so we're good to go
		if($wish->user_id != $this->user->id)
		{
			//is it a friends wish that I'm allowed to see?
			$wish = Model_Wish::get_friends_wish($wish->id, $this->user->id);
			if(!$wish)
			{
				$this->request->redirect("home/wish");
			}
		}
		
		//now that we have access to this wish lets view it.
		$this->template->content = view::factory('home/wish_view');
		$this->template->content->wish = $wish;
		//get the pictures associated with this wish		
		$this->template->content->pictures = $wish->wpics->find_all();
		
		//get the files associated with this wish		
		$this->template->content->files = $wish->wfiles->find_all();
		//get the friend
		$this->template->content->friend = ORM::factory('user', $wish->user_id);
		
		//The title to show on the browser
		$this->template->html_head->title = __("wish"). ' :: '. $wish->title;
		//the name in the menu
		$this->template->header->menu_page = "wish";
	}//end action_view()
	
	
	
	/**
	 * Used to upload images to the server
	 * Enter description here ...
	 */
	public function action_imageuploader()
	{
		//this function isn't participating in the auto render side of things
		$this->template = "";
		$this->auto_render = FALSE;
		
		//make sure the wish id is valid
		if(!isset($_GET['wish_id']) OR intval($_GET['wish_id'] == 0))
		{
			echo htmlspecialchars(json_encode(array('error'=>'invalid wish ID')), ENT_NOQUOTES);
			return;
		}
		//make sure this user can mess with this wish
		$wish = Model_Wish::validate_id_user($_GET['wish_id'], $this->user);
		if(!$wish)
		{
			echo htmlspecialchars(json_encode(array('error'=>'invalid wish ID')), ENT_NOQUOTES);
			return;
		}
		
				
		// list of valid extensions, ex. array("jpeg", "xml", "bmp")
		$allowedExtensions = array('jpg', 'jpeg', 'bmp', 'png', 'gif');
		// max file size in bytes
		$sizeLimit = 6 *  1048576; //6 mega bytes
		
		$upload_folder = getcwd().'/uploads/';
		
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($upload_folder);
		//if there was an error
		if(!isset($result['success']))
		{
			echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
			return;
		}
		
		$file_name = $result['filename'];
		$file_type = $result['extention'];
		$file_name_ext = $file_name . '.' . $file_type;
		$title = substr($file_name,strrpos($file_name, '/')+1);
		
		//rename the file and make some thumb nails
		$new_filename = $this->user->id.'_'.time();
		
		
		//save the original file in it's new filename
		Image::factory($file_name_ext)
			->save($upload_folder.$new_filename.'.'.$file_type);

		// Medium size
		Image::factory($file_name_ext)->resize(300,200,Image::AUTO)
			->save($upload_folder.$new_filename.'_m.'.$file_type);
				
		// Thumbnail
		Image::factory($file_name_ext)->resize(89,59,Image::HEIGHT)
				->save($upload_folder.$new_filename.'_t.'.$file_type);
		
		//store in the Database
		$picture = ORM::factory('wpic');
		$picture->create_wish_pic(array('title'=>$title, 
			'wish_id'=>$wish->id, 
			'file_name'=>$new_filename.'.'.$file_type));

		

		//delete the original file
		unlink($file_name_ext);
		
		//unset the items used to pass info back and forth
		unset($result['filename']);
		unset($result['extention']);
		

		$result['fullsize'] = $picture->full_web_full_size();
		$result['passport'] = $picture->full_web_passport();
		$result['thumbnail'] = $picture->full_web_thumbnail();
		$result['title'] = $title;
		$result['id'] = $picture->id;
		
		// to pass data through iframe you will need to encode all html tags
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		
	}//end function
	
	
	
	/**
	 * Used to upload images to the server
	 * Enter description here ...
	 */
	public function action_fileuploader()
	{
		//this function isn't participating in the auto render side of things
		$this->template = "";
		$this->auto_render = FALSE;
		
		//make sure the wish id is valid
		if(!isset($_GET['wish_id']) OR intval($_GET['wish_id'] == 0))
		{
			echo htmlspecialchars(json_encode(array('error'=>'invalid wish ID')), ENT_NOQUOTES);
			return;
		}
		//make sure this user can mess with this wish
		$wish = Model_Wish::validate_id_user($_GET['wish_id'], $this->user);
		if(!$wish)
		{
			echo htmlspecialchars(json_encode(array('error'=>'invalid wish ID')), ENT_NOQUOTES);
			return;
		}
		
				
		// list of valid extensions, ex. array("jpeg", "xml", "bmp")
		$allowedExtensions = array();
		// max file size in bytes
		$sizeLimit = 6 *  1048576; //6 mega bytes
		
		$upload_folder = getcwd().'/uploads/';
		
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($upload_folder);
		//if there was an error
		if(!isset($result['success']))
		{
			echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
			return;
		}
		
		$file_name = $result['filename'];
		$file_type = $result['extention'];
		$file_name_ext = $file_name . '.' . $file_type;
		$title = substr($file_name,strrpos($file_name, '/')+1);
		
		// create the new name
		$new_filename = $this->user->id.'_'.time();
		
		//do the rename
		rename($file_name_ext, $upload_folder.$new_filename.'.'.$file_type);
		
		
		//store in the Database
		$file = ORM::factory('wfile');
		$file->create_wish_file(array('title'=>$title, 
			'wish_id'=>$wish->id, 
			'file_name'=>$new_filename.'.'.$file_type));

		

		//unset the items used to pass info back and forth
		unset($result['filename']);
		unset($result['extention']);
		

		$result['link'] = $file->get_link();
		$result['title'] = $title;
		$result['id'] = $file->id;
		
		// to pass data through iframe you will need to encode all html tags
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		
	}//end function
	
	
	/**
	 * Use this function to delete images
	 * that the user doesn't want any more
	 */
	public function action_deleteimage()
	{
		//this function isn't participating in the auto render side of things
		$this->template = "";
		$this->auto_render = FALSE;
		
		//verify the image id
		if(!isset($_POST['id']) OR intval($_POST['id']) == 0)
		{
				echo json_encode(array('status'=>'error'));
				return;
		}
		$image_id = $_POST['id'];
		//does this image belong to this user?
		$image = Model_Wpic::verify_image_user($image_id, $this->user, true);
		if(!$image)
		{
				echo json_encode(array('status'=>'error'));
				return;
		}
		//delete the file
		unlink($image->full_thumbnail());
		unlink($image->full_passport());
		unlink($image->full_fullsize());
		
		$image->delete();
		
		echo json_encode(array('status'=>'success'));
		return;
	}
	
	
	
	/**
	 * Use this function to delete images
	 * that the user doesn't want any more
	 */
	public function action_deletefile()
	{
		//this function isn't participating in the auto render side of things
		$this->template = "";
		$this->auto_render = FALSE;
		
		//verify the image id
		if(!isset($_POST['id']) OR intval($_POST['id']) == 0)
		{
				echo json_encode(array('status'=>'error'));
				return;
		}
		$file_id = $_POST['id'];
		//does this image belong to this user?
		$file = Model_Wfile::verify_file_user($file_id, $this->user, true);
		if(!$file)
		{
				echo json_encode(array('status'=>'error'));
				return;
		}
		//delete the file
		unlink($file->get_path());
		
		$file->delete();
		
		echo json_encode(array('status'=>'success'));
		return;
	}
	
	
} // End class





/** Stuff for uploading files**/

/**
* Handle file uploads via XMLHttpRequest
*/
class qqUploadedFileXhr {
	/**
	 * Save the file to the specified path
	 * @return boolean TRUE on success
	 */
	function save($path) {
		$input = fopen("php://input", "r");
		$temp = tmpfile();
		$realSize = stream_copy_to_stream($input, $temp);
		fclose($input);

		if ($realSize != $this->getSize()){
			return false;
		}

		$target = fopen($path, "w");
		fseek($temp, 0, SEEK_SET);
		stream_copy_to_stream($temp, $target);
		fclose($target);

		return true;
	}
	function getName() {
		return $_GET['qqfile'];
	}
	function getSize() {
		if (isset($_SERVER["CONTENT_LENGTH"])){
			return (int)$_SERVER["CONTENT_LENGTH"];
		} else {
			throw new Exception('Getting content length is not supported.');
		}
	}
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {
	/**
	 * Save the file to the specified path
	 * @return boolean TRUE on success
	 */
	function save($path) {
		if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
			return false;
		}
		return true;
	}
	function getName() {
		return $_FILES['qqfile']['name'];
	}
	function getSize() {
		return $_FILES['qqfile']['size'];
	}
}

class qqFileUploader {
	private $allowedExtensions = array();
	private $sizeLimit = 10485760;
	private $file;

	function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){
		$allowedExtensions = array_map("strtolower", $allowedExtensions);

		$this->allowedExtensions = $allowedExtensions;
		$this->sizeLimit = $sizeLimit;

		$this->checkServerSettings();

		if (isset($_GET['qqfile'])) {
			$this->file = new qqUploadedFileXhr();
		} elseif (isset($_FILES['qqfile'])) {
			$this->file = new qqUploadedFileForm();
		} else {
			$this->file = false;
		}
	}

	private function checkServerSettings(){
		$postSize = $this->toBytes(ini_get('post_max_size'));
		$uploadSize = $this->toBytes(ini_get('upload_max_filesize'));
		/*
		 if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
		$size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
		die("{'error':'increase post_max_size and upload_max_filesize to $size'}");
		}
		*/
	}

	private function toBytes($str){
		$val = trim($str);
		$last = strtolower($str[strlen($str)-1]);
		switch($last) {
			case 'g': $val *= 1024;
			case 'm': $val *= 1024;
			case 'k': $val *= 1024;
		}
		return $val;
	}

	/**
	 * Returns array('success'=>true) or array('error'=>'error message')
	 */
	function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
		if (!is_writable($uploadDirectory)){
			return array('error' => "Server error. Upload directory, $uploadDirectory, isn't writable.");
		}

		if (!$this->file){
			return array('error' => 'No files were uploaded.');
		}

		$size = $this->file->getSize();

		if ($size == 0) {
			return array('error' => 'File is empty');
		}

		if ($size > $this->sizeLimit) {
			return array('error' => 'File is too large');
		}

		$pathinfo = pathinfo($this->file->getName());
		$filename = $pathinfo['filename'];
		//$filename = md5(uniqid());
		$ext = $pathinfo['extension'];

		if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
			$these = implode(', ', $this->allowedExtensions);
			return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
		}

		if(!$replaceOldFile){
			/// don't overwrite previous files that were uploaded
			while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
				$filename .= rand(10, 99);
			}
		}

		if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
			return array('success'=>true, 'filename'=>$uploadDirectory.$filename, 'extention'=>$ext);
		} else {
			return array('error'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
		}

	}
}//end of file upload class
