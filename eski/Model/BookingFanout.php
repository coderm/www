<?php
class BookingFanout extends AppModel
{
    public $name = 'BookingFanout';
    public $useTable = 'dt_booking_fanout';
    public $primaryKey = 'booking_fanout_id';
    public $belongsTo= array(
        'CreatedUser' => array(
            'className' => 'TxUser',
            'foreignKey' => 'created_user_s_id'
        ),
        'LastModifiedUser' => array(
            'className' => 'TxUser',
            'foreignKey' => 'last_modified_user_s_id'
        ),
        'TransactionType' => array(
            'className' => 'TransactionType',
            'foreignKey' => 'transaction_type_id'
        ),
        'BankingAccount' => array(
            'className' => 'BankingAccount',
            'foreignKey' => 'banking_account_id'
        ),
        'CurrencyUnit' => array(
            'className' => 'CurrencyUnit',
            'foreignKey' => 'currency_unit_id'
        )
    );
    
    
    public function getBookingFanouts($bookingId,$validate=true)
    {
        $results = $this->find('all',array('conditions' => array('BookingFanout.booking_id' => $bookingId ,'BookingFanout.status <>' => 'deleted'),'order' => array('transaction_date'=>'asc')));
        $a = array();
         foreach ($results as $key => $result) {
                    foreach ($result as $key2 => $result2) {
                        foreach ($result2 as $key3 => $data) {
                            if (strpos($key3, 'date') === false)
                                $a[$key][$key2][$key3] = $data;
                            else
                                $a[$key][$key2][$key3] = $this->formatMySQLDateToFormDate($data);
                        }
                    }
                }
        
        $bookingFanouts['fanouts'] = $a;
        
        
        $payable = 0; /* ödenecek tutar*/
        $paid = 0; /* ödenen tutar*/
        $ourPayable = 0; /*bize ödenecek tutar*/
        $ourPaid = 0; /*evsahibine ödenen tutar*/
        $houseHolderPayable = 0; /* ödenecek tutar*/
        $houseHolderPaid = 0; /* ödenen tutar*/
        $totalPrice = 0; /* Toplam Tutar */
        $houseHolderPrice = 0; /* Ev sahibi Tutarı*/
        $activeHouseHolderToPay = 0; /*bizim  Ev sahibine ödediğimiz */
        $passiveHouseHolderToPay = 0; /*bizim  Ev sahibine ödeyeceğimiz */
        $cancellationPayable = 0 ;
        $cancellationPaid = 0 ;
        
        
  
        foreach ($bookingFanouts['fanouts'] as $bookingFanout) 
        { 

            if ($bookingFanout['TransactionType']['message_text_id']=='ltt_custumer_payment') 
            {
                if ($bookingFanout['BookingFanout']['status']=='active')
                    $ourPaid += $bookingFanout['BookingFanout']['price'] ;
                else
                    $ourPayable += $bookingFanout['BookingFanout']['price'] ;   
            }

            if ($bookingFanout['TransactionType']['message_text_id']=='ltt_payment_of_cancellation') 
            {
                if ($bookingFanout['BookingFanout']['status']=='active')
                    $cancellationPaid += $bookingFanout['BookingFanout']['price'] ;
                else
                    $cancellationPayable += $bookingFanout['BookingFanout']['price'] ;   
            }

            if ($bookingFanout['TransactionType']['message_text_id']=='ltt_householder_to_pay') 
            {
                if ($bookingFanout['BookingFanout']['status']=='active')
                    $activeHouseHolderToPay += $bookingFanout['BookingFanout']['price'] ;
                else
                    $passiveHouseHolderToPay += $bookingFanout['BookingFanout']['price'] ;   
            }

            if ($bookingFanout['TransactionType']['message_text_id']=='ltt_booking_costumer_pay_householder') 
            {
                if ($bookingFanout['BookingFanout']['status']=='active')
                    $houseHolderPaid += $bookingFanout['BookingFanout']['price'] ;
                else
                    $houseHolderPayable += $bookingFanout['BookingFanout']['price'] ; 
            }

            if ($bookingFanout['TransactionType']['message_text_id']=='ltt_booking_householder_price') 
                $houseHolderPrice += $bookingFanout['BookingFanout']['price'] ;

            if ($bookingFanout['TransactionType']['message_text_id']=='ltt_booking_costumer_price') 
                $totalPrice += $bookingFanout['BookingFanout']['price'] ;

        }        
        
        $payable = $ourPayable + $houseHolderPayable; /* ödenecek tutar*/
        $paid =  $ourPaid + $houseHolderPaid ;/* ödenen tutar*/
        $houseHolderToPay = $activeHouseHolderToPay + $passiveHouseHolderToPay;
        $customersToHouseholderTotalAmaunt = $houseHolderPaid + $houseHolderPayable ;
        $ourTotal = $ourPayable + $ourPaid;
        $grossProfit = $totalPrice - $houseHolderPrice;
        $fanoutOutline = array();
        
        $fanoutOutline['payable'] = $payable;
        $fanoutOutline['paid'] = $paid;
        $fanoutOutline['cancellationPayable'] = $cancellationPayable;
        $fanoutOutline['cancellationPaid'] = $cancellationPaid;
        $fanoutOutline['ourPayable'] = $ourPayable;
        $fanoutOutline['ourPaid'] = $ourPaid;
        $fanoutOutline['ourTotal'] = $ourTotal;
        $fanoutOutline['houseHolderPayable'] = $houseHolderPayable;
        $fanoutOutline['houseHolderPaid'] = $houseHolderPaid;
        $fanoutOutline['customersToHouseholderTotalAmaunt'] = $customersToHouseholderTotalAmaunt;
        $fanoutOutline['totalPrice'] = $totalPrice;
        $fanoutOutline['houseHolderPrice'] = $houseHolderPrice;
        $fanoutOutline['houseHolderToPay'] = $houseHolderToPay;
        $fanoutOutline['activeHouseHolderToPay'] = $activeHouseHolderToPay;
        $fanoutOutline['passiveHouseHolderToPay'] = $passiveHouseHolderToPay;
        $fanoutOutline['grossProfit'] = $grossProfit;
        if (($grossProfit*$totalPrice) != 0)
            $fanoutOutline['grossProfitPercent'] = (($grossProfit   * 100) / $totalPrice );
        else
            $fanoutOutline['grossProfitPercent'] = 0 ;
        $bookingFanouts['outline'] = $fanoutOutline;
        
        
        if ($validate)
            $bookingFanouts['validateCalculationsResult'] = $this->validateCalculations($payable,$paid,$totalPrice,$houseHolderPrice,$houseHolderToPay,$ourTotal,$grossProfit);
        
        return $bookingFanouts;
    }
        
    public function validateCalculations($payable,$paid,$totalPrice,$houseHolderPrice,$houseHolderToPay,$ourTotal,$grossProfit)
    {
        if(!isset($payable) || $payable == '')
           $payable  = 0 ;
        if(!isset($paid) || $paid == '')
            $paid = 0 ;
        if(!isset($totalPrice) || $totalPrice == '')
           $totalPrice  = 0 ;
        if(!isset($houseHolderPrice) || $houseHolderPrice == '')
            $houseHolderPrice = 0 ;
        if(!isset($houseHolderToPay) || $houseHolderToPay == '')
            $houseHolderToPay = 0 ;
        if(!isset($ourTotal) || $ourTotal == '')
            $ourTotal = 0 ;
        if(!isset($grossProfit) || $grossProfit == '')
            $grossProfit = 0 ;
             
      
          
        
        if((($payable + $paid) == $totalPrice)  && /*($houseHolderToPay > 0) && */ ($totalPrice > $houseHolderPrice ) && ($houseHolderPrice >= $houseHolderToPay) && /*($paid >= $grossProfit ) && */ (($ourTotal - $grossProfit) == $houseHolderToPay)) 
            return true;    
        else
            return false;
    }
        
    public function getTodaysActiveBookingsTotal($userId=null)
    {
       if(!isset($userId))
        $results = $this->query('select count(booking_id) from vw_last_booking where active_time>CAST(NOW() AS DATE)');
       else
        $results = $this->query('select count(booking_id) from vw_last_booking where active_time>CAST(NOW() AS DATE) AND bau_user_s_id='.$userId);  
       
       return $results[0][0]['count(booking_id)'];
    }
    
    public function getTodaysActiveBookings($userId = null)
    {
       if(!isset($userId))
        $results = $this->query('select * from vw_last_booking where active_time>CAST(NOW() AS DATE)');
       else
        $results = $this->query('select * from vw_last_booking where active_time>CAST(NOW() AS DATE) AND bau_user_s_id='.$userId);  
       
       
       return $results;
    }

}
?>
