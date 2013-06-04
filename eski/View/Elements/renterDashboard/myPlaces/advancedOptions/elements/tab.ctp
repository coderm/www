<?php
    $tabs = array();
    $tabs['terms_and_conditions'] = 'conditions';
    $tabs['visibility'] = 'visibility';
    $tabs['conditional_pricing'] = 'conditional_pricing';
    $tabs['price_tester'] = 'price_tester';

?>

<ul class="nav nav-tabs">
    <?php
	$activeTab = isset($this->passedArgs[2])?$this->passedArgs[2]:'conditions';
	
	foreach($tabs as $label_ext=>$tab)
	{   $cssClass = ($activeTab == $tab)?'active':'';
	    echo $this->Html->tag('li',$this->Html->link(__('my_places_advanced_options_'.$label_ext),array('controller'=>'renterDashboards','action'=>'myPlaces',$placeId,'advancedOptions',$tab)),
			array('class'=>$cssClass));
	}
    ?>
</ul>
