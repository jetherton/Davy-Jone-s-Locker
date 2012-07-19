<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * @author John Etherton <john@ethertontech.com>
 * @copyright Etherton Technologies, Ltd. 2011
 */

class Helper_Dates
{
	/**
	 * takes a mysql date and turns it into
	 * an appropriately formatted string
	 * @param string $date
	 * @return string
	 */
	public static function mysql_date_to_string_formal($date)
	{
		$time = strtotime($date);
		return date('l, F j, Y', $time) . ' at '. date('g:ia', $time);
	}//end function
	
	/**
	 * Creates a short, relative if a short distance from now, time string
	 * @param string $date
	 * @return string
	 */
	public static function mysql_to_short_relative($date)
	{
		$time = strtotime($date);
		$time_dif = time() - $time;
		if($time_dif < 60)
		{
			return __('a few seconds ago');
		}
		else if($time_dif < 60 * 60)
		{
			$minutes = intval($time_dif/60);
			return __(':minutes minutes ago', array(':minutes'=>$minutes));
		}
		else if($time_dif < 60 * 60 * 24)
		{
			$hours = intval($time_dif/(60*60));
			return __(':hours hours ago', array(':hours'=>$hours));
		}
		else
		{
			//return date('n/j/Y g:ia', $time);
			return date('n/j/Y', $time);
		}
	}
}//end class