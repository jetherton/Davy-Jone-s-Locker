<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* forms_js.php - View
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
?>

<script type="text/javascript">
	
	function deleteForm(id)
	{
		if (confirm("<?php echo __('are you sure you want to delete category');?>"))
		{
			$("#form_id").val(id);
			$("#action").val('delete');
			$("#edit_form_form").submit();
		}
	}
</script>
