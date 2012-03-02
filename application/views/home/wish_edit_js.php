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

		$.post('<?php echo url::base();?>home/wish/addfriendwish?wish_id=<?php echo $wish->id;?>&friend_id='+friendId +'&add='+add,
				{
				html: $("#html").val(),
				title: $("#title").val(),
				is_add:$("#is_add").val(),
				action:$("#action").val()
			},
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
		}, 'JSON');
	}
	
	
	function insertImage(url, imageLink)
	{
		tinyMCE.execCommand("mceInsertContent", false, '<a href="'+imageLink+'"><img style="margin:8px;" src="'+url+'"/></a>');
	}
	
	function insertLink(url, title)
	{
		tinyMCE.execCommand("mceInsertContent", false, '<a href="'+url+'">'+ title + '</a>');
	}
	
	
	function setWriteHere(search) 
	{
		/* add on click event handler */
		$("input[rel^="+search+"]").click( function () {
			var ar = $(this).attr('rel').split('|');
			if($(this).val()==ar[1]) { $(this).val(""); $(this).attr('class',ar[3]); }
		} );
		/* add on blur event handler */
		$("input[rel^="+search+"]").blur( function () {
			var ar = $(this).attr('rel').split('|');
			if($(this).val()=="") { $(this).val(ar[1]); $(this).attr('class',ar[2]); }
		} );
		/* trigger blur event */
		$("input[rel^="+search+"]").each( function () { $(this).blur(); } );
	}
	
	$(document).ready(function() 
	{
		/* fix forms when ready */
		setWriteHere("writehere");
		toggleUseLocation();
		/*Turn on tool tips*/
		$(".form_description").tooltip();	
    });


</script>
