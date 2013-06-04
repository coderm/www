<?php
    echo '<h2>'.$formElement[0]['lu_details_class']['message_text_id'].'</h2>';
    
    echo $this->Form->create('FormElement');
    echo $this->Form->input('properties',array('rows'=>5,'value'=>$formElement[0]['lu_details_class']['properties']));
    echo $this->Form->submit('Tamam');
	
?>
