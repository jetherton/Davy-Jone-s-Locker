<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Template {

	public $template = 'main';
	
	/**
		Set stuff up
	*/
	public function before()
	{
		parent::before();

		$this->session = Session::instance();
		//if auto rendere set this up
		if ($this->auto_render)
		{
			// Initialize values
			$this->template->html_head = View::factory('html_head' );
			$this->template->html_head->title = "Davy Jones' Locker";
			$this->template->html_head->styles = array();
			$this->template->html_head->scripts = array();
			
			$this->template->header = View::factory('header');
			$this->template->header->menu = "menu";
			$this->template->content = '';
			$this->template->footer = View::factory('footer');

		}
	}
  	
	
	public function action_index()
	{
		 $this->template->content = 'hello, world!';
	}
	
	/**
		Add whatever we need on the way out
	*/
	public function after()
	{
		if ($this->auto_render)
		{
			$this->template->html_head->styles['media/css/style.css'] = 'screen';
			
			$this->template->html_head->scripts[] = 'media/js/jquery.min.js';
		}
		parent::after();
	}

} // End Welcome
