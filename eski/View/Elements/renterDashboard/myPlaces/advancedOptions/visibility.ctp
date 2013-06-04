<?php
    $visibilityOptions = array();
    $visibilityOptions['show'] = __('visibility_option_show');
    $visibilityOptions['hide'] = __('visibility_option_hide');
    $attributes = array('legend' => false);
    echo $this->Html->tag('h5',__('visibility_headline'));
    echo '<div class="row">';    
    echo $this->BSForm->radio('Advertisement.visibility', $visibilityOptions, $attributes);
    echo '</div>';    
    
?>
