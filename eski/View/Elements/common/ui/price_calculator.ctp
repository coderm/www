<?php
    echo '<div class="price-calculator">';
    
    $priceInputOptions = array();
    $priceInputOptions['bsSpan'] = 2;
    
    if((isset($showCurrencyOptions) && !$showCurrencyOptions))
    {
	   $priceInputOptions['div'] = array('class'=>'input-append','style'=>'margin-right:20px;');
	   $priceInputOptions['after'] = '<span class="add-on">TL</span>';
	   
    }
    
    $demanPriceOptions = $priceInputOptions;
    $demanPriceOptions['class'] = 'demand';
    $demanPriceOptions['label'] = __('place_nightly_demand_input_label');
    
    $salePriceOptions = $priceInputOptions;
    $salePriceOptions['class'] = 'salePrice';
    $salePriceOptions['label'] = __('place_nightly_sale_price_input_label');
    
    $modelPreClass = isset($ModelClass)?$ModelClass:'';
    echo $this->BSForm->input('Advertisement.'.$modelPreClass.'demand',$demanPriceOptions);
    
    if(!isset($showCurrencyOptions) || (isset($showCurrencyOptions) && $showCurrencyOptions) )
	echo $this->BSForm->input('Advertisement.currency',array('bsSpan'=>1,'options'=>$currencyUnitOptions,'label'=>'&nbsp;'));
	
    echo $this->BSForm->input('Advertisement.'.$modelPreClass.'salePrice',$salePriceOptions);
    
    
    echo '</div>';
    
    $advertId = (isset($this->request->data['Advertisement']['advert_id']))?$this->request->data['Advertisement']['advert_id']:false;
    
    $this->Js->Buffer('
	    var options = {};
	    options.advertId = "'.$advertId.'";
	    $("div.price-calculator").priceCalculator(options);

	');
    
?>
