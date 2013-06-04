<?php
	     echo '<div id="map" class="clear" style="height:200px;width:96%;margin:20px;border:1px solid #CCCCCC;"></div>';
             echo $this->BSForm->hidden('Advertisement.geoLocation');
	     
	     
	     $zoomLevel = 5;
	     $latitude = 39;
	     $longitude = 35;
	     
	     if(isset($this->data['Advertisement']['geoLocation']) && $this->data['Advertisement']['geoLocation']!='')
	     {
		$mapProps = $this->Html->parseProperties($this->data['Advertisement']['geoLocation']);
		 
		$zoomLevel = $mapProps['zoomLevel'];
		$latitude = $mapProps['latitude'];
		$longitude = $mapProps['longitude'];

		
	     }
	     
	     $this->Js->Buffer('
    		 var mapOptions = {
		    zoomLevel : '.$zoomLevel.',
		    latitude : '.$latitude.',
		    longitude : '.$longitude.'
		     };
		     
		 $(document).googleMapHelper(mapOptions);
	    ');
	     	     
	     
?>	 
    