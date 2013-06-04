<?php
    $extraGuestsCountOptions = array();
    for($i=0;$i<16;$i++)
	$extraGuestsCountOptions[] = $i.' '.__('extra_price_for_extra_person_after_person_count');

    $discountRateInputOptions['div'] = array('class'=>'input-append','style'=>'margin-right:20px;');
    $discountRateInputOptions['after'] = '<span class="add-on">%</span>';
    $discountRateInputOptions['bsSpan'] = 1;
    
    $priceInputOptions['div'] = array('class'=>'input-append','style'=>'margin-right:20px;');
    $priceInputOptions['after'] = '<span class="add-on">TL</span>';
    $priceInputOptions['bsSpan'] = 2;

    echo $this->Html->tag('h5',__('conditional_pricing_weekend_price_headline'));
    echo '<div class="row">';    
    echo $this->Element('common/ui/price_calculator',array('showCurrencyOptions'=>false,'ModelClass'=>'weekend_'));
    echo '</div>';    
    
    echo $this->Html->tag('h5',__('conditional_pricing_damage_deposit_headline'));
    echo '<div class="row">';  
    $priceInputOptions['label'] = __('deposit_damage_label');
    echo $this->BSForm->input('Advertisement.deposit_damage',$priceInputOptions);
    echo '</div>';     
    
    echo $this->Html->tag('h5',__('conditional_extra_prices'));
    echo '<div class="row">';  
    $priceInputOptions['label'] = __('extra_price_cleaning_label');
    echo $this->BSForm->input('Advertisement.cleaning_price',$priceInputOptions);
    
    echo $this->BSForm->newRow();
    $priceInputOptions['label'] = __('extra_price_for_extra_person_label');
    echo $this->BSForm->input('Advertisement.extra_charge_per_guest',$priceInputOptions);
    echo $this->BSForm->input('Advertisement.guests_included_in_the_demand',array('options'=>$extraGuestsCountOptions,'label'=>__('extra_price_for_extra_person_after_label'),'bsSpan'=>2));
    
    echo '</div>';            
	
    echo $this->Html->tag('h5',__('conditional_pricing_discount_rates_headline'));
    echo '<div class="row">';  
    $discountRateInputOptions['label'] = __('discount_rate_weekly_label');
    echo $this->BSForm->input('Advertisement.weekly_discount_rate',$discountRateInputOptions);
    $discountRateInputOptions['label'] = __('discount_rate_monthly_label');
    echo $this->BSForm->input('Advertisement.monthly_discount_rate',$discountRateInputOptions);
    
    echo '</div>';       
?>

