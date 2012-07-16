<script type="text/javascript">

	function addParser ()
	{
		var newPasserId = $("#new_passer").val();

		$.post('<?php echo url::base();?>home/passing/addpasser',
				{
				passer_id: newPasserId,				
			},
			function(data) 	{
			$("div#passer_table").html(data);
			$("a.close").trigger('click');	
			reUpTheOverlay();	
		});
	}

	function deletePasser(passer_id)
	{
		$.post('<?php echo url::base();?>home/passing/deletepasser',
				{
				passer_id: passer_id,				
			},
			function(data) 	{
			$("div#passer_table").html(data);	
			reUpTheOverlay();
		});

		
	}

	function reUpTheOverlay()
	{
		$("a[rel]").overlay({
			mask: 'grey',
			effect: 'apple',
			onBeforeLoad: function() {
				// grab wrapper element inside content
				var wrap = this.getOverlay().find(".contentWrap");
				// load the page specified in the trigger
				var url = "<?php echo url::base();?>home/passing/addpasserfield";
				// load the page specified in the trigger
				wrap.load(url);
				}
		
			});
	}

	
	$(document).ready(function() 
	{
		
		/*Turn on tool tips*/
		$(".form_description").tooltip({ effect: 'slide',position: "bottom right"});	

		$("a[rel]").overlay({
			mask: 'grey',
			effect: 'apple',
			onBeforeLoad: function() {
				// grab wrapper element inside content
				var wrap = this.getOverlay().find(".contentWrap");
				// load the page specified in the trigger
				var url = "<?php echo url::base();?>home/passing/addpasserfield";
				// load the page specified in the trigger
				wrap.load(url);
				}
		
			});

	    });

</script>
