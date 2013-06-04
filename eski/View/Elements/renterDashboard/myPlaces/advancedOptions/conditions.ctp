<?php
    $timeOptions = array();
    $timeOptions['any_time'] = __('time_option_any_time');
    for($i=0;$i<24;$i++)
    {
	$s = ($i<10)?'0'.$i:$i;
	$timeOptions[$i] = $s.':00';
    }
    
    $rentalPeriods = array();
    for($i=0;$i<31;$i++)
	$rentalPeriods[] = $i.' '.__('rental_period_night');
    
    $cancellationPolicyTypes = array();
    $cancellationPolicyTypes['flexible'] = __('cancellation_policy_type_flexible');
    $cancellationPolicyTypes['semi-flexible'] = __('cancellation_policy_type_semi_flexible');
    $cancellationPolicyTypes['stringent'] = __('cancellation_policy_type_stringent');
    
	
    echo $this->Html->tag('h5',__('cancellation_policies_headline'));
    echo '<div class="row">';    
    echo $this->BSForm->input('Advertisement.conditions.cancellationPolicyType',array('options'=>$cancellationPolicyTypes,'bsSpan'=>2,'label'=>__('cancellation_type_label')));
    echo '</div>';    
    
    
    echo $this->Html->tag('h5',__('check_in_out_time_headline'));
    echo '<div class="row">';    
    echo $this->BSForm->input('Advertisement.conditions.checkInOutTime.In',array('options'=>$timeOptions,'bsSpan'=>2,'label'=>__('check_in_time_label')));
    echo $this->BSForm->input('Advertisement.conditions.checkInOutTime.Out',array('options'=>$timeOptions,'bsSpan'=>2,'label'=>__('check_out_time_label')));
    echo '</div>';
    
    echo $this->Html->tag('h5',__('rental_period_headline'));
    echo '<div class="row">';    
    echo $this->BSForm->input('Advertisement.conditions.rentalPeriod.Min',array('options'=>$rentalPeriods,'bsSpan'=>2,'label'=>__('rental_period_label')));
    


    echo '</div>';    
    
?>
