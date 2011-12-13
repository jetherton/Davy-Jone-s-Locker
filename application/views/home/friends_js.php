<script type="text/javascript">
	$(document).ready(function() {
		$("input#search_term").autocomplete({
			source: "<?php echo url::base();?>/home/friends/search",

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

		//run the get
		$.get("<?php echo url::base();?>/home/friends/addfriend?friendid=" + $("#friend_id").val(), function(data) {
			if(data.indexOf('<error>') == 0)
			{
				alert(data.substring(7));
			}
			else
			{
			  $('#friend_list').html('');
			  $('#friend_list').html(data);
			}
			
			$("#friend_search_results").hide();
			$("#search_term" ).val("");
			$("#search_term" ).focus();
		});
	}
</script>
