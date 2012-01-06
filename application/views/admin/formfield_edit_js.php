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
		if ((type == 4 || type == 5 || type == 6) && <?php echo $form_field_id; ?> != 0)
		{
			$("#options_div").slideDown('slow', function(){});
		}
		else //if not a select type, hide the options stuff
		{
			$("#options_div").slideUp('slow', function(){});
		}
	}
	
	//make sure the options div is shown if need be.
	$(document).ready(function() {
		typeChange();
	});
	
	function addEditOption()
	{
		$("#edit_formfieldoption_form").submit();
	}
	
	function editFormFieldOption(title, description, order, id)
	{
		//if they're editing an existing option then get rid of the extra place
		//for new options in the order drop down.
		if($("#formfieldoption_id").val() == 0)
		{
			$("#option_order option:last").remove();
		}
		
		$("#option_title").val(title);
		$("#option_description").val(description);
		$("#option_order").val(order);
		$("#formfieldoption_id").val(id);
	}
	
	function deleteFormFieldOption(id)
	{
		$("#option_action").val('delete');
		$("#formfieldoption_id").val(id);
		$("#edit_formfieldoption_form").submit();
	}
</script>
