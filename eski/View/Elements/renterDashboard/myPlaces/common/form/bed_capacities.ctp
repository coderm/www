<?php
    
    echo $this->Html->tag('h5',__('bed_capacities_headline'));
    echo '<div class="row">';
    for($i=1;$i<21;$i++)
	$options[] = $i.' '.__('bad_capacity_item');
    echo $this->BSForm->input('Advertisement.details.Interrior.BedCapacity.bed.1person', array('options'=>$options,'empty'=>__('choose_one'),'label'=>__('bed_type_1_person_bed_title'),'bsSpan'=>2));      
    echo $this->BSForm->input('Advertisement.details.Interrior.BedCapacity.bed.2people', array('options'=>$options,'empty'=>__('choose_one'),'label'=>__('bed_type_1_people_bed_title'),'bsSpan'=>2));      
    echo $this->BSForm->input('Advertisement.details.Interrior.BedCapacity.sofabed.1person', array('options'=>$options,'empty'=>__('choose_one'),'label'=>__('bed_type_sofa_bed_title'),'bsSpan'=>2));      
    echo '</div>';
    
?>
