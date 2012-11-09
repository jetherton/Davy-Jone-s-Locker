<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Profile.php - Controller
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 8/20/2011
*************************************************************/

class Controller_Home_Profile extends Controller_Home {


  	
	/**
	where users go to change their profiel
	*/
	public function action_index()
	{
		
		//turn on messages
		$this->template->html_head->script_views[] = view::factory('js/messages');
		
		//turn set focus to first UI form element
		$this->template->html_head->script_views[] = '<script type="text/javascript">$(document).ready(function() {$("input:text:visible:first").focus();});</script>';
		
		//turn on jquery UI
		$this->template->html_head->script_files[] = 'media/js/jquery-ui.min.js';
		$this->template->html_head->styles['media/css/jquery-ui.css'] = 'screen';
		
		//The title to show on the browser
		$this->template->html_head->title = __("profile");
		//the name in the menu
		$this->template->header->menu_page = "profile";
		$this->template->content = view::factory("home/profile");
		$this->template->content->user = $this->user;
		$this->template->content->errors = array();
		$this->template->content->messages = array();
		
		//turn on picture upload
		$this->template->html_head->script_files[] = 'media/js/fileuploader.js';
		$this->template->html_head->styles['media/css/fileuploader.css'] = 'screen';
		$profile_picture_uploader_view = view::factory('js/profilepictureuploader');
		$profile_picture_uploader_view->element_id = 'image_uploader';
		$profile_picture_uploader_view->extension = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
		//nail down that mysterious wish ID
		$profile_picture_uploader_view->user_id = $this->user->id;
		$this->template->html_head->script_views[] = $profile_picture_uploader_view;
		
		if(!empty($_POST)) // They've submitted the form to update their profile
		{
			try
			{
				//check and see if the orignal password matches
				if(!Auth::instance()->login($this->user->username, $_POST['current_password']))
				{
					$this->template->content->errors[] = __('incorrect login');
					return;
				}
				//conver the DOB to a format mysql recognizes
				$_POST['dob'] = date('Y-m-d ', strtotime($_POST['dob'])). '00:00:00';
				$user = $this->user;
				$user->update_user($_POST);
				 
				// sign the user in
				Auth::instance()->login($_POST['username'], $_POST['password']);
				$this->template->content->user = $user;
				$this->template->content->messages = array(_('profile update successful'));
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
		}		
	}//end action_index()
	
	
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
		if(!isset($_GET['user_id']) OR intval($_GET['user_id'] == 0))
		{
			echo htmlspecialchars(json_encode(array('error'=>'invalid user ID')), ENT_NOQUOTES);
			return;
		}
		//make sure this user can mess with this wish
		$user = ORM::factory('user', $_GET['user_id']); 		
		if(!$user->loaded())
		{
			echo htmlspecialchars(json_encode(array('error'=>'invalid user ID')), ENT_NOQUOTES);
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
		$new_filename = 'profile_pic_'.$this->user->id;
	
	
		//save the original file in it's new filename
		//not sure we need this for profile pics, but just in case I'll leave the code here
		//Image::factory($file_name_ext)
		//->save($upload_folder.$new_filename.'.'.$file_type);
	
		// Medium size
		Image::factory($file_name_ext)->resize(300,200,Image::AUTO)
		->save($upload_folder.$new_filename.'_m.'.$file_type);
	
		// Thumbnail
		Image::factory($file_name_ext)->resize(89,59,Image::HEIGHT)
		->save($upload_folder.$new_filename.'_t.'.$file_type);
	
		//store in the Database		
		$user->picture = $new_filename.'_m.'.$file_type;
		$user->picture_small = $new_filename.'_t.'.$file_type;
		$user->save();
	
	
	
		//delete the original file
		unlink($file_name_ext);
	
		//unset the items used to pass info back and forth
		unset($result['filename']);
		unset($result['extention']);
	
	
		$result['picture'] = URL::base().'uploads/'.$user->picture;		
		$result['id'] = $user->id;
	
		// to pass data through iframe you will need to encode all html tags
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	
	}//end function
	
	
	
	
	
} // End profile class



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

	}//end method




}//end of file upload class

