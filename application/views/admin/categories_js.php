<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* categories_js.php - View
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
?>

<script type="text/javascript">
	
	var numberOfCats = <?php echo $number_of_cats;?>;
	
	function deleteCategory(id)
	{
		if (confirm("<?php echo __('are you sure you want to delete category');?>"))
		{
			$("#cat_id").val(id);
			$("#action").val('delete');
			$("#edit_cat_form").submit();
		}
	}

	
	function editCat(catId, order, title, description)
	{
		if($("#order option").size() > numberOfCats)
		{
			$("#order option:last").remove();
		}
	
		$("#cat_id").val(catId);
		$("#title").val(title);
		$("#description").val(description);
		$("#order").val(order);

	}
	
	
</script>
