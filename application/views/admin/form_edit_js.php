<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* form_edit_js.php - View
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
?>

<script type="text/javascript">
	
	var catCounts = <?php echo $cat_counts; ?>;

	
	function updateOrder()
	{
			var currentCategory = $("#category option:selected").val();
			console.log(currentCategory);
			var catCount = catCounts[currentCategory];
			if( catCount == null && catCount == undefined)
			{
				catCount = 1;
			}
			//remove the current options first
			$("#order option").remove();
			
			//add the new ones
			for(i = 1; i <= catCount; i++)
			{
				$('#order')
					.append($("<option></option>")
					.attr("value",i)
					.text(i)); 
			}
	}
	
	function deleteForm(id)
	{
		if (confirm("<?php echo __('are you sure you want to delete form');?>"))
		{
			$("#form_id").val(id);
			$("#action").val('delete');
			$("#edit_form_form").submit();
		}
	}

	
	function editForm(formId, catId, order, title, description)
	{
		if($("#order option").size() > numberOfCats)
		{
			$("#order option:last").remove();
		}
	
		$("#form_id").val(formId);
		$("#title").val(title);
		$("#description").val(description);
		$("#order").val(order);

	}
	
	$(document).ready(function () {
		updateOrder();
	});
	
	
</script>
