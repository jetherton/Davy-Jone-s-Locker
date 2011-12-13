<script type="text/javascript">
	function deleteWish()
	{
		if (confirm("<?php echo __('Are you sure you want to delete wish');?>"))
		{
			$("#action").val('delete');
			$("#wish_edit_form").submit();
		}
	}

	
	function modifyFriend(friendId)
	{
		var checked = $("#friend_"+friendId).attr("checked");
		var add = 2; //2 means drop it
		if(checked == "checked")
		{
			add = 1;
		}

		$.getJSON('<?php echo url::base();?>home/wish/addfriendwish?wish_id=<?php echo $wish->id;?>&friend_id='+friendId +'&add='+add, 
			function(data) {			
			if (data.status == 'success'){
				var color = '#bbffbb';				
				if(data.response == 'removed')
				{
					color = '#FFbbbb';
				}
				$("#friend_item_"+data.friend_id).effect("highlight", {color:color}, 1000);
			}
			else
			{
				alert('<?php echo __('error');?>: ' + data.message);
			}
		});
	}

</script>