<!-- file path View/Advertisements/calculate_price.ctp -->
<?php
    $str = '';
    if($price>0 && $totalSelectedNights>0)
    {
	$str.= '<div style="font-size:17px; text-align: center;">';
        $str.= $totalGuests.' kişi, '.$totalSelectedNights.' gecelik<br/>toplam tutar<br/>';
	$str.= '<strong>';
        $str.= $this->Number->format($price, array(
            'places' => 0,
            'before' => '',
            'escape' => false,
            'decimals' => '.',
            'thousands' => '.'
        ));
	$str.= '</strong>';
        $str.= ' '.$currencyUnit;
	$str.= '</div>';
    }
    if($str=='')
	$str.='Tarihleri kontrol ediniz';
    
    if($message!='')
    {
	$str.= '<hr style="margin:2px;"/>';
        $str.='<div class="alert alert-error" style="padding:14px;margin:0;font-size:12px"> ';
        $str.=$message;
        $str.='</div>';
    }
    
?>

    <?php if(trim($str)!=''):?>
	<div class="well well-small lightblue" style="margin-bottom:5px;">
		<?php echo $str;?>
	</div>
    <?php endif;?>


    <?php
	if(!$priceTestingMode)
	    return;
	
	

	echo '<table class="table">';
	echo '<tr>';
	    echo '<th>'.__('price_testing_result_table_date_label').'</th>';
	    echo '<th>'.__('price_testing_result_table_demand_label').'</th>';
	    echo '<th>'.__('price_testing_result_table_sale_price_label').'</th>';
	echo '</tr>';
	foreach($results['Dates'] as $key=>$date)
	{
		$demandPrice = $date['demand'];
		$demandPriceCurrency = $date['demandCurrency'];
		
		$salePrice = $date['demandView'];
		$salePriceCurrency = $date['demandViewCurrency'];
		
		$demandPriceText = $this->Number->format($demandPrice, array('places' => 2, 'before'=>'', 'after' => ' '.$demandPriceCurrency,    'escape' => false,    'decimals' => '.',    'thousands' => ','));
		$salePriceText = $this->Number->format($salePrice, array('places' => 2, 'before'=>'', 'after' => ' '.$salePriceCurrency,    'escape' => false,    'decimals' => '.',    'thousands' => ','));
		echo '<tr>';
		echo '<td>'.$key.'</td>';
		echo '<td>'.$demandPriceText.'</td>';
		echo '<td>'.$salePriceText.'</td>';
		echo '</tr>';
	}
	echo '</table>';
	
	
	
    ?>
