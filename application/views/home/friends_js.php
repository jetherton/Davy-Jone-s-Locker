<script type="text/javascript">
	$(document).ready(function() {
		$("input#search_term").autocomplete({
			source: "<?php echo url::base();?>home/friends/search",

			select: function( event, ui ) {
				$( "#search_term" ).val( ui.item.label );
				$( "#friend_id" ).val( ui.item.value );
				$("#friend_search_results").show();
				$("#friend_name").text(ui.item.label);

				return false;
			},

			focus: function( event, ui ) {
				$( "#search_term" ).val( ui.item.label );
				return false;
			},
		});

	});



	function clear_friends()
	{
		$("#friend_search_results").hide();
		$("#search_term" ).val("");
		$("#search_term" ).focus();
	}

	function add_friend()
	{
		//through up adding friend status bar

		add_friend_id($("#friend_id").val());
	}


	function add_friend_id(friend_id)
	{
		//through up adding friend status bar
		$("#search_wait").html('<img src="<?php echo url::base();?>media/img/wait30trans.gif" height="30" width="30"/>');

		//run the get
		$.getJSON("<?php echo url::base();?>home/friends/addfriend?friendid=" + friend_id, function(data) {
			$("#search_wait").html('');
			if(data.status == 'error')
			{
				alert(data.payload);
			}
			else
			{
				$('#friend_list').html('');
				$('#friend_list').html(data.payload);
			}			
			
			$("#friend_search_results").hide();
			$("#search_term" ).val("");
			$("#search_term" ).focus();
		});
	}
</script>
