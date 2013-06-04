<table>
    <tr>
    <th>detail class id</th>
    <th>detail class type id</th>
    <th>multiple</th>
    <th>message text id</th>
    <th>description</th>
    <th>ordered</th>
    <th>işlem</th>
    </tr>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */ 
    
    foreach($formElements as $formElement):
	    echo $this->Html->tableCells(
		    array(
		    $formElement['lu_details_class']['detail_class_id'],
		    $formElement['lu_details_class']['detail_class_type_id'],
		    $formElement['lu_details_class']['multiple'],
		    $formElement['lu_details_class']['message_text_id'],
		    $formElement['lu_details_class']['description'],
		    $formElement['lu_details_class']['ordered'],
	            $this->Html->link('düzenle',array('controller'=>'siteTools','action'=>'formElementEdit',$formElement['lu_details_class']['detail_class_id']))
		    )
		    );
    endforeach;
	
?>
</table>