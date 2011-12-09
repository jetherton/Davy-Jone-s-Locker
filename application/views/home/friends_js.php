<script type="text/javascript">
	$(document).ready(function() {
		$("input#search_term").autocomplete({
			source: "<?php echo url::base();?>/home/friends/search"
		});
	});
</script>
