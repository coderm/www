<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


    echo $this->Element('/renterDashboard/common/tabs');
    
    $buttonClass = 'btn btn-success btn-small';
    
    
    foreach($myPlaces as $place)
    {
	$operations = $this->Html->link('Bilgileri Düzenle',array('controller'=>'renterDashboards','action'=>'myPlaces',$place['Advertisement']['advert_id'],'advertBasics'),array('class'=>$buttonClass));
	$operations.= $this->Html->link('Takvim ve Fiyatları Güncelle',array('controller'=>'renterDashboards','action'=>'myPlaces',$place['Advertisement']['advert_id'],'calendar'),array('class'=>$buttonClass));
	$operations = $this->Html->tag('p',$operations);
	
	echo $this->element('list_item',array('advert'=>$place,'maxTitleLength'=>100,'maxDescriptionLength'=>140,'operations'=>$operations));
    }
    
?>
