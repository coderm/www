<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    echo $this->Html->tag('h3',__('my_place_advert_details_headline'));
    echo $this->Element('/renterDashboard/myPlaces/common/form/bed_capacities');
    echo $this->Element('/renterDashboard/myPlaces/common/form/phsycal_properties');
    echo $this->Element('/renterDashboard/myPlaces/common/form/properties');
    echo $this->Element('/renterDashboard/myPlaces/common/form/beach_properties');

    
    return;

    echo $this->Html->tag('h3',__('my_place_advert_details_headline'));
    
    echo $this->Html->tag('h4','Havuz özellikleri');
    $options = array('none' => 'Havuz Yok', 'shared' => 'Paylaşımlı Havuz', 'private' => 'Özel Havuz');
    $attributes = array('legend' => false,'value'=>'none');
    echo $this->BSForm->radio('Advertisement.details.Pool', $options, $attributes);
    
    echo $this->Html->tag('h4','Mutfak Detayları');
    $options = array('dishwasher' => 'Bulaşık Makinesi', 'oven' => 'Fırın');
    $attributes = array('multiple'=>'checkbox');
    echo $this->BSForm->select('Advertisement.details.Interrior.Kitchen', $options, $attributes);   
    
    
    echo $this->Html->tag('h4','Yatak Kapasiteleri');
    $options = array('1' => '1 Adet', '2' => '2 Adet', '3' => '3 Adet');
    echo $this->BSForm->input('Advertisement.details.Interrior.BedCapacity.bed.1person', array('options'=>$options,'empty'=>__('choose_one'),'label'=>'1 Kişilik Yatak','bsSpan'=>2));      
    echo $this->BSForm->input('Advertisement.details.Interrior.BedCapacity.bed.2people', array('options'=>$options,'empty'=>__('choose_one'),'label'=>'2 Kişilik Yatak','bsSpan'=>2));      
    echo $this->BSForm->input('Advertisement.details.Interrior.BedCapacity.sofabed.1person', array('options'=>$options,'empty'=>__('choose_one'),'label'=>'1 Kişilik Çekyat','bsSpan'=>2));      
    echo $this->BSForm->newRow();
    
    
    echo $this->Html->tag('h4','Bahçe Detayları');
    $options = array('barbeque' => 'Barbekü', 'garden_wall' => 'Bahçe Duvarı');
    $attributes = array('multiple'=>'checkbox');
    echo $this->BSForm->select('Advertisement.details.Exterior.Garden', $options, $attributes);        

 
    
    echo $this->Html->tag('h4','xxx');
    $options = array('aa' => 'AA', 'bb' => 'BB');
    $attributes = array('multiple'=>true);
    echo $this->BSForm->select('Advertisement.details.Exterior.X', $options, $attributes);      
    
    echo $this->Html->tag('h4','yyy');
    $options = array('aa' => 'AA', 'bb' => 'BB');
    echo $this->BSForm->input('Advertisement.details.Exterior.Y', array('options'=>$options,'empty'=>__('choose_one')));      
    


    
?>

