<script type="text/javascript">

	function deleteYourFriend()
	{
		if(confirm("<?php echo __('are you sure delete your friend');?>"))
		{
			$("#action").val('delete');
			$("#action_form").submit();
		}
	}


	function markPassing()
	{
		if(confirm("<?php echo __('Are you sure  mark  passing of :friend?', array(':friend'=>$friend->full_name())); ?>"))
		{
			$("#action").val('passed');
			$("#action_form").submit();
		}
	}

</script>
