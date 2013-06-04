<?php
    echo '<div id="price-tester" class="row">';

    echo '<div style="margin:0; border-right:1px solid #ececec;" class="span3">';
    echo $this->BSForm->hidden('Book.placeId',array('value'=>$placeId));
    echo $this->BSForm->input('Book.startDate',array('label'=>__('price_tester_check_in_input_label'),'class'=>'pickDate','bsSpan'=>2));
    echo $this->BSForm->newRow();
    echo $this->BSForm->input('Book.endDate',array('label'=>__('price_tester_check_out_input_label'),'class'=>'pickDate','bsSpan'=>2));
    echo $this->BSForm->newRow();
    echo $this->BSForm->input('Book.totalGuests',array('label'=>__('price_tester_guest_count_input_label'),'bsSpan'=>2, 'options'=>$guestCountAndPriceOptions));
    echo '</div>';
 
    
    echo '<div class="test-result span5 pull-right"></div>';
    
    echo '</div>';
    
    
    
    $this->Js->Buffer('
		$("#price-tester").priceTester();




	');
?>