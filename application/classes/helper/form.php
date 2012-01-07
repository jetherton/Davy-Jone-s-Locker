<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * @author John Etherton <john@ethertontech.com>
 * @copyright Etherton Technologies, Ltd. 2011
 */

class Helper_Form
{
	/**
	 * Use this to get a string of HTML for a form.
	 * @param db_object $form the Form in question
	 * @param db_object $wish the wish from which to pull data from, if no wish leave empty or null
	 * @return a string of html
	 */
	public static function get_html_form($form, $wish = null)
	{
		$html = '<table>';
		
		//loop over the questions
		$form_fields = ORM::factory('formfields')->
			where('form_id','=', $form->id)->
			order_by('order')->
			find_all();
		foreach($form_fields as $form_field)
		{
			if($form_field->type == 1) //text box
			{
				$html .= self::text_box($form_field, $wish);
			}
			if($form_field->type == 2) //text area
			{
				$html .= self::text_area($form_field, $wish);
			}
			if($form_field->type == 3) //date box
			{
				$html .= self::date_box($form_field, $wish);
			}
			if($form_field->type == 4) //radio buttons
			{
				$html .= self::radio_button($form_field, $wish);
			}
			if($form_field->type == 5) //check box
			{
				$html .= self::check_box($form_field, $wish);
			}
			if($form_field->type == 6) //drop down box
			{
				$html .= self::dropdown_box($form_field, $wish);
			}
			if($form_field->type == 7) //pass text box
			{
				$html .= self::password_box($form_field, $wish);
			}
			
		}//end foreach
		
		$html .= '</table>';
		return $html;
	}//end get_html_form;
	
	
	/**
	 * Use this to get the html for a text box question
	 * @param db_object $form_field the Form Field in question
	 * @param db_object $wish the wish from which to pull data from, if no wish leave empty or null
	 * @return a string of html
	 */
	public static function text_box($form_field, $wish = null)
	{
		$default_value = null;
		$required_str = $form_field->required == 1 ? "*" : "";
		$html = '<tr><td>';
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= '</td><td>';
		$html .= Form::input('ff['.$form_field->id.']', $default_value, array('id'=>'ff_'.$form_field->id, 'style'=>'width:300px;'));
		$html .= '</td></tr>';
		
		return $html;
	}//end text_box()
	
	
	/**
	 * Use this to get the html for a text area question
	 * @param db_object $form_field the Form Field in question
	 * @param db_object $wish the wish from which to pull data from, if no wish leave empty or null
	 * @return a string of html
	 */
	public static function text_area($form_field, $wish = null)
	{
		$default_value = null;
		$required_str = $form_field->required == 1 ? "*" : "";
		
		$html = '<tr><td>';
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= '</td><td>';
		$html .= Form::textarea('ff['.$form_field->id.']', $default_value, array('id'=>'ff_'.$form_field->id, 'style'=>'width:300px;'));
		$html .= '</td></tr>';
		
		return $html;
	}//end text_area()
	
	
	/**
	 * Use this to get the html for a date box question
	 * @param db_object $form_field the Form Field in question
	 * @param db_object $wish the wish from which to pull data from, if no wish leave empty or null
	 * @return a string of html
	 */
	public static function date_box($form_field, $wish = null)
	{
		$default_value = null;
		$required_str = $form_field->required == 1 ? "*" : "";
		
		$html = '<tr><td>';
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= '</td><td>';
		$html .= ' date '.Form::input('ff['.$form_field->id.']', $default_value, array('id'=>'ff_'.$form_field->id, 'style'=>'width:300px;'));
		$html .= '</td></tr>';
		
		return $html;
	}//end date_box()
	
	
	
	/**
	 * Use this to get the html for a radio button question
	 * @param db_object $form_field the Form Field in question
	 * @param db_object $wish the wish from which to pull data from, if no wish leave empty or null
	 * @return a string of html
	 */
	public static function radio_button($form_field, $wish = null)
	{
		$default_value = null;
		$required_str = $form_field->required == 1 ? "*" : "";
		
		$options = ORM::factory('formfieldoption')->
			where('formfield_id', '=', $form_field->id)->
			order_by('order')->
			find_all();
		
		$html = '<tr><td>';
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= '</td><td>';
		foreach($options as $option)
		{
			$html .= '<span class="radio_wrapper"><abbr title="'.$option->description.'">'.$option->title.'</abbr>';
			$html .= Form::radio('ff['.$form_field->id.']', $option->id, FALSE, array('id'=>'ff_'.$form_field->id.'_'.$option->id));
			$html .= '</span>';
		}
		$html .= '</td></tr>';
		
		return $html;
	}//end radio_button()
	
	
	
	/**
	 * Use this to get the html for a check box question
	 * @param db_object $form_field the Form Field in question
	 * @param db_object $wish the wish from which to pull data from, if no wish leave empty or null
	 * @return a string of html
	 */
	public static function check_box($form_field, $wish = null)
	{
		$default_value = null;
		$required_str = $form_field->required == 1 ? "*" : "";
		
		$options = ORM::factory('formfieldoption')->
			where('formfield_id', '=', $form_field->id)->
			order_by('order')->
			find_all();
		
		$html = '<tr><td>';
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= '</td><td>';
		foreach($options as $option)
		{
			$html .= '<span class="radio_wrapper"><abbr title="'.$option->description.'">'.$option->title.'</abbr>';
			$html .= Form::checkbox('ff['.$form_field->id.']', $option->id, FALSE, array('id'=>'ff_'.$form_field->id.'_'.$option->id));			
			$html .= '</span>';
		}
		$html .= '</td></tr>';
		
		return $html;
	}//end check_box()
	
	
	
	/**
	 * Use this to get the html for a dropdown box question
	 * @param db_object $form_field the Form Field in question
	 * @param db_object $wish the wish from which to pull data from, if no wish leave empty or null
	 * @return a string of html
	 */
	public static function dropdown_box($form_field, $wish = null)
	{
		$default_value = null;
		$required_str = $form_field->required == 1 ? "*" : "";
		
		$options = ORM::factory('formfieldoption')->
			where('formfield_id', '=', $form_field->id)->
			order_by('order')->
			find_all();
		//make the selections
			
		$selects = array();
		foreach($options as $option)
		{
			$selects[$option->id] = $option->title;
		}
		
		$html = '<tr><td>';
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= '</td><td>';		
		$html .= Form::checkbox('ff['.$form_field->id.']', $selects, null, array('id'=>'ff_'.$form_field->id));					
		$html .= '</td></tr>';
		
		return $html;
	}//end dropdown_box()
	
	
	
		/**
	 * Use this to get the html for a password box question
	 * @param db_object $form_field the Form Field in question
	 * @param db_object $wish the wish from which to pull data from, if no wish leave empty or null
	 * @return a string of html
	 */
	public static function password_box($form_field, $wish = null)
	{
		$default_value = null;
		$required_str = $form_field->required == 1 ? "*" : "";
		
		$html = '<tr><td>';
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= '</td><td>';
		$html .= Form::password('ff['.$form_field->id.']', $default_value, array('id'=>'ff_'.$form_field->id, 'style'=>'width:300px;'));
		$html .= '</td></tr>';
		
		return $html;
	}//end password_box()
	
}//end class
