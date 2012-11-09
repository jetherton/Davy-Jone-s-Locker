<?php defined('SYSPATH') or die('No direct script access.');

class Form extends Kohana_Form {
	
	
	/**
	 * Creates a submit form input.
	 *
	 *     echo Form::submit(NULL, 'Login');
	 *
	 * @param   string  input name
	 * @param   string  input value
	 * @param   array   html attributes
	 * @return  string
	 * @uses    Form::input
	 */
	public static function submit($name, $value, array $attributes = NULL)
	{
		$attributes['type'] = 'submit';
		$attributes['class'] = 'button';
	
		return Form::input($name, $value, $attributes);
	}
	
	
	/**
	 * Creates a form input. If no type is specified, a "text" type input will
	 * be returned.
	 *
	 *     echo Form::input('username', $username);
	 *
	 * @param   string  input name
	 * @param   string  input value
	 * @param   array   html attributes
	 * @return  string
	 * @uses    HTML::attributes
	 */
	public static function input($name, $value = NULL, array $attributes = NULL)
	{
		// Set the input name
		$attributes['name'] = $name;
	
		// Set the input value
		$attributes['value'] = $value;
				
	
		if ( ! isset($attributes['type']))
		{
			// Default type is text
			$attributes['type'] = 'text';
			$attributes['class'] = 'textfield';
		}
		else
		{
			if(strtolower($attributes['type']) == 'button')
			{
				$attributes['class'] = 'button';
			}
		}
	
		return '<input'.HTML::attributes($attributes).' />';
	}
	
	
	/**
	 * Creates a password form input.
	 *
	 *     echo Form::password('password');
	 *
	 * @param   string  input name
	 * @param   string  input value
	 * @param   array   html attributes
	 * @return  string
	 * @uses    Form::input
	 */
	public static function password($name, $value = NULL, array $attributes = NULL)
	{
		$attributes['type'] = 'password';
		$attributes['class'] = 'textfield';
	
		return Form::input($name, $value, $attributes);
	}
	
	
}
