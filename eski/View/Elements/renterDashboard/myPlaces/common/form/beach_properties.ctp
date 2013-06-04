<?php
    
    echo $this->Html->tag('h5',__('beach_properties_headline'));
    echo '<div class="row">';
    $rangeOptions = array();
    
    $rangeOptions['no-beach'] = __('beach_range_option_no_beach');
    $rangeOptions['0-50'] = __('beach_range_0_50_meters');
    $rangeOptions['50-100'] = __('beach_range_50_100_meters');
    $rangeOptions['100-200'] = __('beach_range_100_200_meters');
    $rangeOptions['200-500'] = __('beach_range_200_500_meters');
    $rangeOptions['500-700'] = __('beach_range_500_700_meters');
    $rangeOptions['1000->'] = __('beach_range_more_then_1000_meters');
    
    echo $this->BSForm->input('Advertisement.details.Common.Beach.Range', array('options'=>$rangeOptions,'empty'=>__('choose_one'),'label'=>__('beach_range_options_label'),'bsSpan'=>2));      
    echo '</div>';
    
?>
