<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    foreach($placeDetailProperties as $n=>$s)
    {
	echo $this->Html->tag('h5',__($n.'_headline'));
	echo '<div class="row">';
	foreach($s as $property)
	{
	    $label = str_replace('Advertisement.details.', '', $property);
	    $label = explode('.',$label);
	    $label = implode('_',$label);
	    $label = $label.'_label';
	    echo $this->BSForm->input($property,array('label'=>__($label),'type'=>'checkbox','bsSpan'=>2));
	}
	echo '</div>';

   }
    
    
?>
