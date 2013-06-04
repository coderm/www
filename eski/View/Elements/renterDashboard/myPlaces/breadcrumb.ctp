
<ul class="breadcrumb well">
  <li><a href="#"><?php echo $this->Html->link(__('my_places'),array('controller'=>'renterDashboards','action'=>'index'));?></a> <span class="divider">/</span></li>
  <li><a href="#"><?php echo $this->Html->link($placeDetails['title'],array('controller'=>'renterDashboards','action'=>'myPlaces',$placeId,'overview'));?></a> <span class="divider">/</span></li>
  <li class="active"><?php echo __('my_places_title_'.$action);?></li>
</ul>

<?php 
