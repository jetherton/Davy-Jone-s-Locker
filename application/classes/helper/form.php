<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * @author John Etherton <john@ethertontech.com>
 * @copyright Etherton Technologies, Ltd. 2011
 */

class Helper_Form
{
	public static $na_str = '===na===';
	/**
	 * Use this to get a string of HTML for a form.
	 * @param db_object $form the Form in question
	 * @param db_object $wish the wish from which to pull data from, if no wish leave empty or null
	 * @return a string of html
	 */
	public static function get_html_form($form, $wish = null)
	{
		$html = '<table class="formfields">';
		
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
	 * Use this to find out what answer there is for 
	 * a form field in a given wish. Returns null if no
	 * answer
	 * @param db_object $form_field form field in question
	 * @param db_object $wish wish in question
	 * @param boolean $index if true use the value as the index in the array, false and the indexs will be sequential
	 * @return array the answer or null
	 */
	public static function get_answer($form_field, $wish, $index = false)
	{
		
		if($wish == null)
		{
			return null;
		}
		
		$response = ORM::factory('formfieldresponse')
			->and_where('formfield_id', '=', $form_field->id)
			->and_where('wish_id', '=', $wish->id)
			->find_all();
			
		$responses = array();
		foreach($response as $r)
		{
			if($index)
			{		
				$responses[$r->response] = $r->response;
			}
			else
			{
				$responses[] = $r->response;
			}
		}
		
		return $responses;
	}
	
	
	/**
	 * Use this to get the html for a text box question
	 * @param db_object $form_field the Form Field in question
	 * @param db_object $wish the wish from which to pull data from, if no wish leave empty or null
	 * @return a string of html
	 */
	public static function text_box($form_field, $wish = null)
	{
		
		//check and see if there's already an answer to this question
		$default_value = self::get_answer($form_field, $wish);		
		$default_value = (is_array($default_value) AND count($default_value) > 0) ? $default_value[0] : null;
				
		$required_str = $form_field->required == 1 ? "*" : "";
		$html = '<tr><td class="formfieldlabel">';
		$html .= self::render_lock($form_field);
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= self::render_toop_tip($form_field->description);		
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
		//check and see if there's already an answer to this question
		$default_value = self::get_answer($form_field, $wish);
		$default_value = (is_array($default_value) AND count($default_value) > 0) ? $default_value[0] : null;
				
		$required_str = $form_field->required == 1 ? "*" : "";
		
		$html = '<tr><td class="formfieldlabel">';
		$html .= self::render_lock($form_field);
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= self::render_toop_tip($form_field->description);
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
		//check and see if there's already an answer to this question
		$default_value = self::get_answer($form_field, $wish);
		$default_value = (is_array($default_value) AND count($default_value) > 0) ? $default_value[0] : null;
		$required_str = $form_field->required == 1 ? "*" : "";
		
		$html = '<tr><td class="formfieldlabel">';
		$html .= self::render_lock($form_field);
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= self::render_toop_tip($form_field->description);
		$html .= '</td><td>';
		$html .= Form::input('ff['.$form_field->id.']', $default_value, array('id'=>'ff_'.$form_field->id, 'style'=>'width:100px;'));
		$html .= '<script type="text/javascript">
							$().ready(function() {
								$("#ff_'.$form_field->id.'").datepicker({ 
									showOn: "both", 
									buttonImage: "'.url::base(). 'media/img/icon-calendar.gif", 
									buttonImageOnly: true 
								});
							});
						</script>';
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
		$default_value = self::get_answer($form_field, $wish);
		$default_value = (is_array($default_value) AND count($default_value) > 0) ? $default_value[0] : null;
		$required_str = $form_field->required == 1 ? "*" : "";
		
		$options = ORM::factory('formfieldoption')->
			where('formfield_id', '=', $form_field->id)->
			order_by('order')->
			find_all();
		
		$html = '<tr><td class="formfieldlabel">';
		$html .= self::render_lock($form_field);
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= self::render_toop_tip($form_field->description);
		$html .= '</td><td>';
		foreach($options as $option)
		{
			$checked = $default_value == $option->id;
			$html .= '<span class="radio_wrapper">';
			$html .= Form::radio('ff['.$form_field->id.']', $option->id, $checked, array('id'=>'ff_'.$form_field->id.'_'.$option->id));
			$html .= '<abbr title="'.$option->description.'">'.$option->title.'</abbr>';			
			$html .= '</span>';
		}
		
		if(intval($form_field->required) != 1)
		{
			$checked = false;
			if($default_value == self::$na_str)
			{
				$checked = true;
			}
			
			$html .='<span class="radio_wrapper">';
			$html .= Form::radio('ff['.$form_field->id.']', self::$na_str, $checked, array('id'=>'ff_'.$form_field->id.'_'.self::$na_str));			
			$html .= '<abbr title="'.__('n/a explain').'">'.__('n/a').'</abbr>';
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
		$default_value = self::get_answer($form_field, $wish, TRUE);
		$default_value = (is_array($default_value) AND count($default_value) > 0) ? $default_value : array();
		
		$required_str = $form_field->required == 1 ? "*" : "";
		
		$options = ORM::factory('formfieldoption')->
			where('formfield_id', '=', $form_field->id)->
			order_by('order')->
			find_all();
		$options_array = array();
		
		
		$html = '<tr><td class="formfieldlabel">';
		$html .= self::render_lock($form_field);
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= self::render_toop_tip($form_field->description);
		$html .= '</td><td>';
		foreach($options as $option)
		{
			//test if the checkbox should be checked
			$checked = false;
			if(isset($default_value[$option->id]))
			{
				$checked = true;
			}
			
			$html .='<span class="radio_wrapper">';
			$html .= Form::checkbox('ff['.$form_field->id.'][]', $option->id, $checked, array('id'=>'ff_'.$form_field->id.'_'.$option->id));			
			$html .= '<abbr title="'.$option->description.'">'.$option->title.'</abbr>';
			$html .= '</span>';
		}
		
		if(intval($form_field->required) != 1)
		{
			$checked = false;
			if(isset($default_value[self::$na_str]))
			{
				$checked = true;
			}
			
			$html .='<span class="radio_wrapper">';
			$html .= Form::checkbox('ff['.$form_field->id.'][]', self::$na_str, $checked, array('id'=>'ff_'.$form_field->id.'_'.self::$na_str));			
			$html .= '<abbr title="'.__('n/a explain').'">'.__('n/a').'</abbr>';
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
		//check and see if there's already an answer to this question
		$default_value = self::get_answer($form_field, $wish);
		$default_value = (is_array($default_value) AND count($default_value) > 0) ? $default_value[0] : null;
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
		
		if(intval($form_field->required) != 1)
		{
			$selects[self::$na_str] = __('n/a');
		}
		
		$html = '<tr><td class="formfieldlabel">';
		$html .= self::render_lock($form_field);
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= self::render_toop_tip($form_field->description);
		$html .= '</td><td>';		
		$html .= Form::select('ff['.$form_field->id.']', $selects, $default_value, array('id'=>'ff_'.$form_field->id));					
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
		//check and see if there's already an answer to this question
		$default_value = self::get_answer($form_field, $wish);
		$default_value = (is_array($default_value) AND count($default_value) > 0) ? $default_value[0] : null;
		$required_str = $form_field->required == 1 ? "*" : "";
		
		$html = '<tr><td class="formfieldlabel">';
		$html .= self::render_lock($form_field);
		$html .= $required_str.Form::label('ff_'.$form_field->id, $form_field->title.": ");
		$html .= self::render_toop_tip($form_field->description);
		$html .= '</td><td>';
		$html .= Form::password('ff['.$form_field->id.']', $default_value, array('id'=>'ff_'.$form_field->id, 'style'=>'width:300px;'));
		$html .= '</td></tr>';
		
		return $html;
	}//end password_box()
	
	
	
	/**
	 * this saves the post data, passed in as $values, for a given wish
	 * @param db_object $wish wish you want to save the data too
	 * @param array $values array full of data to save
	 * @return array errors, empty array if there were no errors
	 */
	public static function save_form($wish, $values)
	{
		//in case their are issues
		$errors = array();
		
		//first get the form so we know if something is missing
		$form_fields = ORM::factory('formfields')
			->and_where('form_id', '=',$wish->form_id)
			->order_by('order')
			->find_all();
		//now loop over them all
		foreach($form_fields as $form_field)
		{
			$required = $form_field->required == 1;
			
			if(!isset($values[$form_field->id]))
			{
				if($required)
				{
					$errors[] = $form_field->title .' '. __('is a required field');
				}
				continue;
			}
			
			//make sure the response isn't longer than 255 characters
			if(is_string($values[$form_field->id]) AND strlen($values[$form_field->id]) > 255)
			{
					$errors[] = $form_field->title .' '. __('cannot be longer than 255 characters');
					continue;
			}
			
			//is this a multi value answer or single answer?
			if($form_field->type == 5)
			{
				//first delete all pre-existing answer for this form and wish
				$old_responses = ORM::factory('formfieldresponse')
					->and_where('wish_id', '=', $wish->id)
					->and_where('formfield_id', '=', $form_field->id)
					->find_all();
				foreach($old_responses as $or)
				{
					$or->delete();
				}
				//now save all the new responses
				foreach($values[$form_field->id] as $selected_option_id)
				{
					$new_response = ORM::factory('formfieldresponse');
					$new_response->wish_id = $wish->id;
					$new_response->formfield_id = $form_field->id;
					$new_response->response = $selected_option_id;
					$new_response->save();
				}
				
				
			}
			else //not a multi value answer
			{
				//is there already a response for this?
				$response = ORM::factory('formfieldresponse')
					->and_where('wish_id', '=', $wish->id)
					->and_where('formfield_id', '=', $form_field->id)
					->find();
				if(!$response->loaded())
				{
					$response = ORM::factory('formfieldresponse');
				}
				
				$response->update_formfieldresponse(array('wish_id'=>$wish->id, 'formfield_id'=>$form_field->id, 'response'=>$values[$form_field->id]));
			}
		}
		
		return $errors;
	}
	
	
	
	/**
	 * Use this to get a string of HTML for a form to display the resutls.
	 * @param db_object $form the Form in question
	 * @param db_object $wish the wish from which to pull data from, if no wish leave empty or null
	 * @return a string of html
	 */
	public static function get_html($form, $wish, $user)
	{
		$html = '<table class="wish_view">';
		
		//loop over the questions
		$form_fields = ORM::factory('formfields')->
			where('form_id','=', $form->id)->
			order_by('order')->
			find_all();
		foreach($form_fields as $form_field)
		{
			//check if the user has permissions to view this field
			//is it lockable
			if($form_field->islockable == 1)
			{
				//now check and see if the user is on the approved list
				//get the users who can view this question
				$field_user = ORM::factory('friendsfields')
					->and_where('friendsfields.wish_id', '=', $wish->id)
					->and_where('friendsfields.formfield_id', '=', $form_field->id)
					->and_where('friendsfields.friend_id', '=', $user->id)
					->find_all();

				if(count($field_user) == 0)
				{
					continue;
				}
			}
			//make sure there's an answer for this question
			$response = ORM::factory('formfieldresponse')
					->and_where('wish_id', '=', $wish->id)
					->and_where('formfield_id', '=', $form_field->id)
					->find();
			if(!$response->loaded() OR strlen($response->response) == 0 OR $response->response == self::$na_str)
			{
				continue;
			}
			
			//no matter what, print the title and description
			$html .= '<tr><td>';
			$html .= Form::label('ff_'.$form_field->id, $form_field->title.": ");
			//$html .= '<br/><span class="form_description">'.$form_field->description.'</span>';
			$html .= '</td>';

			//if the info is a text value
			if($form_field->type == 1 OR 
				$form_field->type == 2 OR
				$form_field->type == 3 OR
				$form_field->type == 7) // straight up text
			{
				//get the answer text
				$response = ORM::factory('formfieldresponse')
					->and_where('wish_id', '=', $wish->id)
					->and_where('formfield_id', '=', $form_field->id)
					->find();
				$html .= '<td>'.$response->response.'</td>';
			}
			elseif($form_field->type == 4 OR $form_field->type == 6) //if the info is a single ID value
			{
				//get the answer text
				$response = ORM::factory('formfieldresponse')
					->and_where('wish_id', '=', $wish->id)
					->and_where('formfield_id', '=', $form_field->id)
					->find();
				$option = ORM::factory('formfieldoption')
					->and_where('id', '=', $response->response)
					->find();
				$html .= '<td><abbr title="'.$option->description.'">'.$option->title.'</abbr></td>';
			}
			else //if the info is a multi ID value
			{
				$html .= '<td>';
				//get the answer text
				$responses = ORM::factory('formfieldresponse')
					->and_where('wish_id', '=', $wish->id)
					->and_where('formfield_id', '=', $form_field->id)
					->find_all();
				$i = 0;
				foreach($responses as $response)
				{
					$i++;
					if($i > 1){$html .= '<br/>';}
					$option = ORM::factory('formfieldoption')
						->and_where('id', '=', $response->response)
						->find();
					$html .= '<abbr title="'.$option->description.'">'.$option->title.'</abbr>';
				}
				$html .= '</td>';
			}
			//close the table data and table row
			$html .= '</tr>';
			
		}//end foreach
		
		$html .= '</table>';
		return $html;
	}//end get_html_form;
	
	
	/**
	 * This little helper is used to render the tool tip
	 * descriptions
	 **/
	public static function render_toop_tip($description)
	{
		if($description != null && $description != "")
		{
			return '<span class="form_description" title="'.htmlspecialchars($description).'">&nbsp;</span>';
		}
		return '';
	}
	
	/**
	 * This little helper renders the lock if a question is lockable
	 */
	public static function render_lock($form_field)
	{
		if($form_field->islockable)
		{
			return '<a rel="#overlay" class="lockfield" title="'.__('lock question').'" href="'.$form_field->id.'" ><img src="'.url::base().'media/img/lock.png"/></a>';
		}
		else
		{
			return '';
		}
	}

	
}//end class
