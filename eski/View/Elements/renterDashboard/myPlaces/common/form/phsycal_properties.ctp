<?php
    
    echo $this->Html->tag('h5',__('phsycal_properties_headline'));
    echo '<div class="row">';
    for($i=1;$i<21;$i++)
	$options[$i] = $i.' '.__('bad_capacity_item');
    echo $this->BSForm->input('Advertisement.details.Interrior.FieldOptions.roomCount', array('options'=>$options,'empty'=>__('choose_one'),'label'=>__('room_count_title'),'bsSpan'=>2));      
    echo $this->BSForm->input('Advertisement.details.Interrior.FieldOptions.livingRoomCount', array('options'=>$options,'empty'=>__('choose_one'),'label'=>__('living_room_count_title'),'bsSpan'=>2));      
    echo $this->BSForm->input('Advertisement.details.Interrior.FieldOptions.bathRoomCount', array('options'=>$options,'empty'=>__('choose_one'),'label'=>__('bath_room_count_title'),'bsSpan'=>2));      
    
    $options = array();
    $options['self_contained'] = __('floor_type_self_contained');
    $options['basement_floor'] = __('floor_type_basement_floor');
    $options['garden_floor'] = __('floor_type_garden_floor');

    for($i=1;$i<101;$i++)
	$options[$i] = $i.'. '.__('floor');
    
    

    echo $this->BSForm->input('Advertisement.details.Exterrior.floorType', array('options'=>$options,'empty'=>__('choose_one'),'label'=>__('floor_type_title'),'bsSpan'=>2));    
	
    echo $this->BSForm->input('Advertisement.details.Interrior.FieldOptions.areaSquareMeters', array('label'=>__('interrior_area_square_meters'),'bsSpan'=>1));      
    echo '</div>';
    
?>
