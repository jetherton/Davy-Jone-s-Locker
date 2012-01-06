<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* form_edit_js.php - View
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
?>

<script type="text/javascript">
	
	function typeChange()
	{
		var type = $("#type").val();
		
		//if a select type, show the options stuff
		if (type == 4 || type == 5 || type == 6)
		{
			$("#options_div").slideDown('slow', function(){});
		}
		else //if not a select type, hide the options stuff
		{
			$("#options_div").slideUp('slow', function(){});
		}
	}
	
	//make sure the options div is shown if need be.
	$(typeChange());
	
</script>
