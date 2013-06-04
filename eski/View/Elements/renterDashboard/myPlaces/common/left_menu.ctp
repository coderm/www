<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    $menuItems = array();
    $menuItems['my_places_title_overview'] = array('action'=>'overview');        
    $menuItems['my_places_title_advertBasics'] = array('action'=>'advertBasics');        
    $menuItems['my_places_title_contact'] = array('action'=>'contact');        
    $menuItems['my_places_title_advertDetails'] = array('action'=>'advertDetails');        
    $menuItems['my_places_title_photos'] = array('action'=>'photos');        
    $menuItems['my_places_title_calendar'] = array('action'=>'calendar');        
    $menuItems['my_places_title_advancedOptions'] = array('action'=>'advancedOptions');                
?>
<div class="span3">
<ul class="nav nav-pills nav-stacked">
  <?php
  $urlOptions = array('controller'=>'renterDashboards','action'=>'myPlaces',$placeId); 

  foreach($menuItems as $label=>$menuItem)
  {
      $urlOptionsForItem = array_merge($urlOptions, array($menuItem['action']));
      $liCssClass = ($menuItem['action']==$action)?'active':'';
      $liContent = $this->Html->link(__($label),$urlOptionsForItem);
      echo $this->Html->tag('li',$liContent,array('class'=>$liCssClass));
  }
  ?>

  
</ul>
</div>