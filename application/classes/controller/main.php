<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Template {

	public $template = 'main';
	
	/**
		Set stuff up
	*/
	public function before()
	{
		parent::before();
		
		

		$this->user = null; //not logged in
		$this->session = Session::instance();
		//if auto rendere set this up
		if ($this->auto_render)
		{
			// Initialize values
			$this->template->html_head = View::factory('html_head' );
			$this->template->html_head->title = "";
			$this->template->html_head->styles = array();
			$this->template->html_head->script_files = array();
			$this->template->html_head->script_views = array();
			
			$this->template->header = View::factory('header');
			$this->template->header->menu = "menu";
			$this->template->header->menu_page = "";
			$this->template->content = '';
			$this->template->footer = View::factory('footer');
			
			//add basic css and JS
			$this->template->html_head->styles['media/css/style.css'] = 'screen';				
			$this->template->html_head->script_files[] = 'media/js/jquery.min.js';

		}
	}
  	
	
	public function action_index()
	{
		$this->template->content = '<h1>hello, world!</h1> <p> This is the home page of Ekphora.com</p><p>This site is still under development</p>';
	}
	
	/**
		Add whatever we need on the way out
	*/
	public function after()
	{
		if ($this->auto_render)
		{			
			
			$this->template->header->user = $this->user;
		}
		parent::after();
	}

} // End Welcome
