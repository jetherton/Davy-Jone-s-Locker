<script type="text/javascript">

	function deleteYourFriend()
	{
		if(confirm("<?php echo __('are you sure delete your friend');?>"))
		{
			$("#action").val('delete');
			$("#action_form").submit();
		}
	}

</script>
