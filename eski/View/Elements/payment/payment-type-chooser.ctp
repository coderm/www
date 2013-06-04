<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    //echo $this->BSForm->radio('Payment.type',array('test'),array('legend'=>false,'checked'=>0));

    $installementsByTerm = array();
    $radioInputOptions = array();
    $currency = $creditCardInstallements['common']['currency'];
    
    

    
    echo $this->Html->tag('h6',__('non_installement_options_headline'));
    
    echo '<input type="radio" name="data[Payment][type]" value="eft"> '.__('payment_type_eft_payment');
    echo ' ';
    echo $this->Html->tag('strong',$creditCardInstallements['common']['eftPrice'].' <small>'.$currency.'</small>');
    
    echo '<br/>';
    
    echo '<input type="radio" name="data[Payment][type]" value="credit_card"> '.__('payment_type_credit_card');
    echo ' ';
    echo $this->Html->tag('strong',$creditCardInstallements['common']['creditCardPrice'].' <small>'.$currency.'</small>');


    echo $this->Html->tag('hr');
    echo $this->Html->tag('h6',__('installement_options_headline'));
    echo '<table class="table">';
	
    echo '<tr>';
    echo $this->Html->tag('td','');
    foreach($creditCardInstallements['installment'] as $cardProgram=>$installements)
    {
	echo $this->Html->tag('th',$this->Html->tag('span','',array('class'=>'credit-card '.$cardProgram)));
	
	foreach($installements as $key=>$installement)
	{
	    $installementsByTerm[$key][$cardProgram] = $installement;
	}
    }
    echo '</tr>';
    

    foreach($installementsByTerm as $key=>$installementsByTerm)
    {

	echo '<tr>';
	echo $this->Html->tag('td','<strong>'.$key.' taksit</strong>');
	foreach($installementsByTerm as $cardProgram=>$installement)
	{
	    $s = '<input type="radio" name="data[Payment][type]" value="installement_'.$cardProgram.'_'.$key.'">';
	    $s.= $installement['total'].' <small>'.$currency.'</small>';
	    echo $this->Html->tag('td',$s);
	}
	echo '</tr>';
    }
    
    echo '</table>';
?>


