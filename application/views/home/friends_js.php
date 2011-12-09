<script type="text/javascript">
	$(document).ready(function() {
		$("input#search_term").autocomplete({
			source: "<?php echo url::base();?>/home/friends/search",

			focus: function( event, ui ) {
				$( "#input#search_term" ).val( ui.item.label );
				return false;
			},
			
			select: function( event, ui ) {
				$( "#input#search_term" ).val( ui.item.label );
				$( "#search_results" ).val( ui.item.value );

				return false;
			}
		});
	});
</script>
