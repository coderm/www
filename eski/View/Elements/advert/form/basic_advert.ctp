<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<h3><?php echo __('place_basics_headilne');?></h3>
<div class="row">
<?php
    echo $this->BSForm->input('Advertisement.title',array('label'=>__('place_title_input_label'),'placeHolder'=>'Kısaca mekanınızı tanımlayın'));
    echo $this->BSForm->input('Advertisement.description',array('rows'=>3,'label'=>__('place_description_input_label'),'placeHolder'=>'Mekan hakkında açıklayıcı bilgi'));
    echo $this->BSForm->input('Advertisement.type',array('bsSpan'=>3,'options'=>$accommodationTypeOptions,'label'=>__('place_type_input_label')));
    echo $this->BSForm->input('Advertisement.maxGuests',array('bsSpan'=>1,'label'=>__('place_capacity_input_label')));
    echo $this->BSForm->newRow();
    echo $this->Element('/common/ui/price_calculator');
    //echo $this->BSForm->input('Advertisement.demand',array('bsSpan'=>2,'class'=>'demand','label'=>__('place_nightly_demand_input_label')));
    //echo $this->BSForm->input('Advertisement.currency',array('bsSpan'=>1,'options'=>$currencyUnitOptions,'label'=>'&nbsp;'));
    //echo $this->BSForm->input('Advertisement.salePrice',array('bsSpan'=>2,'class'=>'salePrice','label'=>__('place_nightly_sale_price_input_label')));
?>
</div>   
<div class="alert alert-info">
    <h5><i class="icon-hand-right"></i> <?php echo __('price_tips_headline');?></h5>
    <?php echo __('price_tips_content');?>
</div>
<div class="clear"></div>
