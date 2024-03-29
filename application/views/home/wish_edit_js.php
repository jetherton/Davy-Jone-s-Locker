<script type="text/javascript">

	function setTiming(friendId)
	{
		var timingType = $("#timing_type_"+friendId).val();
		var deadLine = $("#dead_line_"+friendId).val();
		var userCanKnow = $("#user_can_know_"+friendId).is(":checked") ? 1 : 0;
		var wishId = <?php echo $wish->id;?>;

		$("#timing_spinner_"+friendId).html('<img src="<?php echo url::base(); ?>media/img/wait16trans.gif"/>');

		$.post('<?php echo url::base();?>home/wish/setTiming',
				{
				timing_type: timingType,
				dead_line: deadLine,
				user_can_know:userCanKnow,
				wish_id:wishId,
				friend_id:friendId
			},
			function(data) {			
			$("#timing_spinner_"+friendId).html('');
			if (data.status == 'success'){
				$("#timing_"+friendId).hide('slow');
			}
			else
			{
				alert('<?php echo __('error');?>: ' + data.message);
			}
		}, 'JSON');
	}


	function showTiming(friendId)
	{
		if($("#timing_"+friendId).is(":visible"))
		{
			$("#timing_"+friendId).hide('slow');
		}
		else
		{
			$("#timing_"+friendId).show('slow');
		}
	}

	function timingTypeChange(friendId)
	{
		var timingType = $("#timing_type_"+friendId).val();
		if(timingType == '2')
		{
			$("#timing_date_"+friendId).show('slow');
		}
		else
		{
			$("#timing_date_"+friendId).hide('slow');
		}

		if(timingType == '3')
		{
			$("#timing_user_can_know_"+friendId).hide('slow');
		}
		else
		{
			$("#timing_user_can_know_"+friendId).show('slow');
		}
	}

	
	function deleteWish()
	{
		if (confirm("<?php echo __('Are you sure you want to delete wish');?>"))
		{
			$("#action").val('delete');
			$("#wish_edit_form").submit();
		}
	}

	function toggleNotes()
	{
		var checked = $("#show_notes").is(":checked");
		if(checked)
		{
			$("#notes_area").show('slow');
		}
		else
		{
			$("#notes_area").hide('slow');
		}
	}

	
	function modifyFriend(friendId)
	{
		var checked = $("#friend_"+friendId).is(":checked");
		var add = 2; //2 means drop it
		if(checked)
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
					$("#timing_link_"+friendId).hide('slow');
					$("#timing_"+friendId).hide('slow');
				}
				else
				{
					$("#timing_link_"+friendId).show('slow');
				}
				$("#friend_item_"+data.friend_id).effect("highlight", {color:color}, 1000);
			}
			else
			{
				alert('<?php echo __('error');?>: ' + data.message);
			}
		}, 'JSON');
	}
	
	
	
	function modifyFriendField(friendId, fieldId)
	{
		var checked = $("#ffl_"+friendId+"_"+fieldId).is(":checked");
		var add = 2; //2 means drop it
		if(checked)
		{
			add = 1;
		}

		$.post('<?php echo url::base();?>home/wish/addfriendwishfield?wish_id=<?php echo $wish->id;?>&field_id='+fieldId+'&friend_id='+friendId +'&add='+add,
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
				$("#ffl_item_"+data.friend_id+"_"+data.field_id).effect("highlight", {color:color}, 1000);
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
		$(".form_description").tooltip({ effect: 'slide',position: "bottom right"});	
		
		/*enable lock tool tips*/
		// if the function argument is given to overlay,
	// it is assumed to be the onBeforeLoad event listener
	
	$("a[rel]").overlay({
		mask: 'grey',
		effect: 'apple',
		onBeforeLoad: function() {
			// grab wrapper element inside content
			var wrap = this.getOverlay().find(".contentWrap");
			// load the page specified in the trigger
			var url = "<?php echo url::base();?>home/wish/getfriendfields?fieldid=" + this.getTrigger().attr("href") + "&wishid=<?php echo $wish->id;?>";
			// load the page specified in the trigger
			wrap.load(url);
			}
	
		});
    });


</script>
