<?php
class Payment extends AppModel
{

    public $name = 'Payment';
    public $useTable = false;
    
    
    public function getPaymentTypeOptions()
    {
	$results = array();
	$results[0] = 'Kredi kartı';
	$results[1] = 'EFT / Havale / Bankamatik';
	$results[2] = 'Telefon kanalıyla mail order';
	
	return $results;
    }

}

?>
