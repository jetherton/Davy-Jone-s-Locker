<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA-Ybr5ZwF918EPS7NIVvjaLudrvdci7ao&sensor=false"></script>

<script type="text/javascript">
	var map = null;  
	var marker = null;
	var geocoder = null;
	function initializeMap() 
	{
		geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(39.2, -99.39);
		var myOptions = {
				zoom: 2,
				center: latlng,
				streetViewControl: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
		map = new google.maps.Map(document.getElementById("<?php echo $element_id;?>"), myOptions);
		marker = new google.maps.Marker({
			position: latlng,
			map: map,
			draggable: true
			});
			
		google.maps.event.addListener(marker, 'dragend', function() {
				$("#lat").val(marker.getPosition().lat());
				$("#lon").val(marker.getPosition().lng());
			});
			
		google.maps.event.addListener(map, 'zoom_changed', function() {
				$("#zoom").val(map.getZoom());				
			});
		
		google.maps.event.addListener(map, 'maptypeid_changed', function() {
				$("#map_type").val(map.getMapTypeId());				
			});	
			
			
		$("#lat").val(latlng.lat());
		$("#lon").val(latlng.lng());
		$("#zoom").val(map.getZoom());	
		$("#map_type").val(map.getMapTypeId());				
		
		return  map;
	};
	
	
	function codeAddress() 
	{
		var address = document.getElementById("map_search_input").value;
		geocoder.geocode( { 'address': address}, function(results, status) 
		{
			if (status == google.maps.GeocoderStatus.OK) 
			{
				map.setCenter(results[0].geometry.location);
				marker.setPosition(results[0].geometry.location);	
				$("#lat").val(marker.getPosition().lat());
				$("#lon").val(marker.getPosition().lng());			
			} 
			else 
			{
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}
	
	
	function searchKeyPress(event, object)
	{
		
		event = (event) ? event : ((window.event) ? window.event : "")
		if (event) 
		{
			// process event here
			if ( event.keyCode==13 || event.which==13 ) 
			{
				codeAddress();
				return false;
			}
		}
		return true;
	}
	
	function toggleUseLocation()
	{
		if($("#use_location").attr('checked'))
		{
			$("#map_panel").unblock();
		}
		else
		{
			
			$("#map_panel").block({message: null});
		}
	}
	
	
	$(document).ready(function() 
	{	 	
		$("#accordion").bind('accordionchange', function(event, ui) {			
			if (ui.newContent.attr('id') == 'map_tab' && !map)
			{
				map = initializeMap();
			}
		});
	});

</script>
