<div class="row">
<h4 class="headline">Rezervasyon ve Hesap İşlemleri</h4>
</div>
<?php
$this->DatePicker->setShowOlderDates("true");

if(isset($todaysActiveBookings))
{
    if($todaysActiveBookingsTotal>0)
    {
        echo '<div>';
        echo '<h3>Bugün Yapılan Rezervasyonlar: <span style="font-size:20px;">'.$todaysActiveBookingsTotal.'x</span></h3>';
        foreach($todaysActiveBookings as $todaysActiveBooking)
        {
            $bookingId = $todaysActiveBooking['vw_last_booking']['booking_id'];
            $bauUser = $todaysActiveBooking['vw_last_booking']['bau_user'];
            $a = split("-", $bookingId);
            $_advertId = $a[0];
            $this->Thickbox->setProperties(array('id' => $bookingId, 'type' => 'frame', 'url' => '/BookingFanouts/index/' . $bookingId .'/'. $_advertId ,'height' => '600', 'width' => '1000'));
            $this->Thickbox->setPreviewContent('<span class="smile" title="'.$bookingId.'&#13;'.$bauUser.'"></span>');                
            echo $this->Thickbox->output();
            
        }    
        echo '</div>';
        echo '<div style="clear:both;">&nbsp;</div>';
    }

}

if(isset($myTodaysActiveBookings))
{
    if($myTodaysActiveBookingsTotal>0)
    {
        echo '<div>';
        echo '<h3>Bugün Yaptığım Rezervasyonlar: <span style="font-size:20px;">'.$myTodaysActiveBookingsTotal.'x</span></h3>';
        foreach($myTodaysActiveBookings as $myTodaysActiveBooking)
        {
            $bookingId = $myTodaysActiveBooking['vw_last_booking']['booking_id'];
            $a = split("-", $bookingId);
            $_advertId = $a[0];
            $this->Thickbox->setProperties(array('id' => $bookingId, 'type' => 'frame', 'url' => '/BookingFanouts/index/' . $bookingId .'/'. $_advertId ,'height' => '600', 'width' => '1000'));
            $this->Thickbox->setPreviewContent('<span class="smile" title="'.$bookingId.'"></span>');                
            echo $this->Thickbox->output();
            
        }     
        echo '</div>';
        echo '<div style="clear:both;">&nbsp;</div>';
    }
}


if ($bookingPermissions['lp_booking_view_all_fanouts']) {

    $groupTypes = array
        (
        ''=>'Tümü',
        'pending'=>'Beklemede',
        'passive'=>'Pasif',
        'active'=>'Aktif',
        'cancel'=>'İptal'
    );
    echo "<div class='well'>";
    echo "<div class='row'>";
    echo "<div class='span6'>";
    echo "<b>Kişi Filtresi</b><br/>";
	echo '<div class="liveSearch">';
	echo $this->Form->input('searchString', array('label' => false, 'autocomplete' => 'off'));
	echo '<small>İsim, soyisim, telefon numarası ya da mail adresi ile arama yapılabilir</small>';

    //echo $this->Form->input('location', array('label'=>'Nerede?','autocomplete'=>'off'));
	echo '<div class="results" id="liveSearchResults"></div>';
	echo '</div>';
	if (isset($selectedUser)) {
	echo '<div class="alert alert-info">';
        echo $selectedUser['User']['name'] . ' ' . $selectedUser['User']['sname'] . ' | ';
        echo $selectedUser['User']['ldc_primary_email'] . ' | ';
        echo $selectedUser['User']['ldc_user_phone']['code'].' '.$selectedUser['User']['ldc_user_phone']['number'];
	echo '<a href="/bookings/index/removeNamed:searhUserId"><i class=" icon-remove-sign pull-right"></i></a>';
	echo '</div>';
	}

    echo "</div>";
    




    echo '<div class="span5">';
    echo "<b>Durum Filtresi</b><br/>";
    echo '<ul class="nav nav-pills">';

    foreach ($groupTypes as $key => $groupTypeLabel) {
        $cssClass = '';
        if ($groupType === $key)
            $cssClass = 'active';
	
	

        $linkOptions = array();
        $linkOptions['controller'] = 'BookingFanouts';
        $linkOptions['action'] = 'fanout';

        $linkOptions = array_merge($linkOptions, $this->passedArgs);

        if (isset($groupType))
            $linkOptions['groupType'] = $key;
        if (isset($advertId))
            $linkOptions['advertId'] = $advertId;

	
	
	echo '<li class="'.$cssClass.'">';
        echo $this->Html->link($groupTypeLabel, $linkOptions, array('escape' => false));
	echo '</li>';
    }
    echo '</ul>';
    echo "</div>";
    
    echo "</div>";
    
    echo "<div class='clear'></div>";
    echo $this->Html->tag('hr');
    echo "<b>Tarih Filtresi</b><br/>";
    echo $this->Form->create('DateFilter');

    
    $options = array('OperationDate' => 'İşlem Tarihi', 'StartDate' => 'Başlangıç Tarihi', 'EndDate' => 'Bitiş Tarihi','LastPaymentToHouseHolder'=>'Son E.S. Ödememiz','NextPaymentToHouseHolder'=>'Gelecek E.S. Ödememiz');
    
    echo $this->Form->input('startDate', array('label' => 'İlk tarih', 'class' => 'pickDate', 'style' => 'width:85%;', 'div' => array('style' => 'width:200px;position:relative;float:left;clear:none')));
    echo $this->Form->input('endDate', array('label' => 'Son tarih', 'class' => 'pickDate', 'style' => 'width:85%;', 'div' => array('style' => 'width:200px;position:relative;float:left;clear:none;margin-left:30px;')));
    echo '<div class="clear"></div>';
    echo $this->Form->input('filterType', array('type' => 'radio', 'legend' => false, 'before' => '', 'options' => $options, 'default' => 'OperationDate','div'=>array('class'=>'input radio inline-labels row')));
    echo '<div class="clear"></div>';
    
    $options = array(
        'label' => 'Tarih Filtresini Uygula',
        'name' => 'ApplyDateFilter',
        'class' => 'btn btn-primary pull-right'
    );
    echo $this->Form->end($options);
    echo "</div>";
    echo "<div style='clear:both'></div>";
    echo "</div>";
    ?>

    <table class="table booking-list">
        <tr>
            <th>
		<strong>Rezervasyon Bilgisi</strong><br/>
		_________________________<br/>
                <?php echo $this->Paginator->sort('booking_date', 'İşlem Tarihi'); ?><br/>
                <?php echo $this->Paginator->sort('start_date', 'Giriş Tarihi'); ?><br/>
                <?php echo $this->Paginator->sort('end_date', 'Çıkış Tarihi'); ?><br/>
                <?php echo $this->Paginator->sort('total_nights', 'Toplam Gece'); ?><br/>
		<?php echo $this->Paginator->sort('gross_profit', 'Brüt Kar'); ?><br/>
		<?php echo $this->Paginator->sort('status', 'Durum'); ?><br/>
            </th>
            <th>
		<strong>Kişiler</strong><br/>
		______________________<br/>
                <?php echo $this->Paginator->sort('lessor', 'İşlem Yapan'); ?><br/>
                <?php echo $this->Paginator->sort('renter', 'Müşteri'); ?><br/>
                <?php echo $this->Paginator->sort('householder', 'Ev Sahibi'); ?>
            </th>            
                     
            <th>
		<strong>Muhasebe</strong><br/>
		______________________________<br/>
		<?php echo $this->Paginator->sort('customer_price', 'Rezervasyon Tutarı'); ?><br/>
		<?php echo $this->Paginator->sort('active_customer_payment', 'Alınmış Toplam Tutar'); ?><br/>
		<?php echo $this->Paginator->sort('active_householder_payment', 'Ev Sahibine Ödemiş Toplam Tutar'); ?><br/>
		<?php echo $this->Paginator->sort('passive_customer_payment', 'Bekleyen Tutar'); ?><br/>
	    </th>
            
            
            <th>
		<strong>Tarihler</strong><br/>
		___________________<br/>
		<?php echo $this->Paginator->sort('first_passive_customer_payment_date', 'Bekleyen Ödeme T.'); ?></br>
		<?php echo $this->Paginator->sort('last_active_householder_payment_date', 'Son ES. Ödeme T.'); ?></br>
		<?php echo $this->Paginator->sort('first_passive_householder_payment_date', 'Gelecek ES. Ödeme T.'); ?>
		
	    </th>

            

        </tr>
        <?php
        foreach ($bookings as $booking) {
            $bookingId = $booking['BookingListFanout']['booking_id'];
            $startDate = $booking['BookingListFanout']['start_date'];
            $endDate = $booking['BookingListFanout']['end_date'];
            $totalNights = $booking['BookingListFanout']['total_nights'];
            $bookingDate = $booking['BookingListFanout']['booking_date'];
            $customerPrice = $booking['BookingListFanout']['customer_price'];
            $activeHouseholderPayment = $booking['BookingListFanout']['active_householder_payment'];
            $grossProfit = $booking['BookingListFanout']['gross_profit'];
            $activeCustomerPayment = $booking['BookingListFanout']['active_customer_payment'];
            $lastActivePaymentDate = $booking['BookingListFanout']['last_active_payment_date'];
            $passiveCustomerPayment = $booking['BookingListFanout']['passive_customer_payment'];
            $firstPassiveCustomerPaymentDate = $booking['BookingListFanout']['first_passive_customer_payment_date'];
            $lastActiveHouseholderPaymentDate = $booking['BookingListFanout']['last_active_householder_payment_date'];
            $firstPassiveHouseholderPaymentDate  = $booking['BookingListFanout']['first_passive_householder_payment_date'];
            $lessor = $booking['BookingListFanout']['lessor'];
            $status = $booking['BookingListFanout']['status'];
            $renter = $booking['BookingListFanout']['renter'] .'</br><b>'.$booking['BookingListFanout']['renter_phone'].'</b>'  ;
            $houseHolder = $booking['BookingListFanout']['householder'] .'</br><b>'.$booking['BookingListFanout']['householder_phone'].'</b>'  ;
            $advertId = $booking['BookingListFanout']['advert_id'];
            $hasAnyConflict = 0;
            if ($booking['BookingListFanout']['conflicting_booking_id'] != 0)
                $hasAnyConflict = ($bookingId != $booking['BookingListFanout']['conflicting_booking_id']);

            $cssClass = '';
            if ($hasAnyConflict)
                $cssClass = 'conflicted';


            echo '<tr class=' . $cssClass . '>';
            echo '<td class="well">';
            echo 'İşlem: '.$bookingDate.'</br>';
            echo 'Giriş: '.$startDate.'</br>';
            echo 'Çıkış: '.$endDate.'</br></br>';
            echo $totalNights.' gece</br>';
	    echo '<b>'.$grossProfit.' brüt kar</b>  '.__('booking_status_' . $status);
	    

	    echo '<hr/>';
	    echo '<div class="btn-group">';


	    $this->Thickbox->setProperties(array('id' => $bookingId, 'type' => 'frame', 'url' => '/BookingFanouts/index/' . $bookingId .'/'. $advertId ,'height' => '600', 'width' => '1000'));
	    $this->Thickbox->setPreviewContent('Muhasebe');                
	    echo $this->Thickbox->output();

	    if($status!='active' && $status!='cancel')
		echo $this->Html->link('Sil',array('controller'=>'bookings','action'=>'delete/'.$bookingId),array('confirm' => 'Rezervasyon silinecek!','class'=>'btn btn-primary btn-mini'));	    
	    echo '</div>';
            '</td>';
            echo '<td>';
            echo '<span>'.$lessor.'</span><br/><br/>';
            echo '<span>Misafir: '.$renter.'</span><br/><br/>';
	    echo '<span>Ev Sahibi: '.$houseHolder.'</span><br/>';

            echo '</td>';            
           
	    echo '<td>';
	    echo 'Rezervasyon tutarı:</br>';
            echo '<strong>'.$customerPrice . '</strong></br></br>';
	    echo 'Misafirden alınan:</br>';
            echo '<strong>'.$activeCustomerPayment . '</strong></br></br>';            
	    echo 'Ev sahibine ödenen:</br>';
            echo '<strong>'.$activeHouseholderPayment . '</strong></br></br>';            
	    echo 'Ev sahibine ödenecek:</br>';
            echo $passiveCustomerPayment . '</br>';
	    echo '</td>';
	    echo '<td>';
	    echo 'Bekleyen Ödeme:</br>';
            echo '<strong>'.$firstPassiveCustomerPaymentDate . '</strong></br></br>';
	    echo 'Yapılmış Son ES Ödemesi:</br>';
            echo '<strong>'.$lastActiveHouseholderPaymentDate . '</strong></br></br>';
	    echo 'Gelecek ES Ödemesi:</br>';
            echo '<strong>'.$firstPassiveHouseholderPaymentDate . '</strong></br></br>';
	    echo '</td>';
            
            
            //echo $this->Paginator->sort('booking_id', 'No'); 
            echo '</tr>';
        }
        ?>

    </table>
    <?php echo $this->element('paginator'); ?>
    <?php
}
$this->Js->get('#searchString')->event('sendSearchRequest', $this->Js->request(array(
            'controller' => 'users',
            
            'action' => 'searchBookingReleatedUsers/'
                ), array(
            'update' => '#liveSearchResults',
            'success'=>'ajaxSearchQueryRequestComplete = true;sendSearcQueryRequest();',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);

$this->Js->buffer('
                    
                                lastAjaxSearchQuery = "";
                                ajaxSearchQueryRequestComplete = true;
                                $("#searchString").keyup(function()
                                {
                                    sendSearcQueryRequest()
                                }
                                )
                                
                                function sendSearcQueryRequest()
                                {
                                    if($("#searchString").val().length<3)
                                        return;
                                        
                                    if(lastAjaxSearchQuery==$("#searchString").val())
                                        return;
                                        
                                    if(!ajaxSearchQueryRequestComplete)
                                        return;
                                        

                                    lastAjaxSearchQuery=$("#searchString").val()
                                        
                                    ajaxSearchQueryRequestComplete = false;
                                    $("#searchString").trigger("sendSearchRequest", ["sendSearchRequest", "Event"]);
                                }

                                $("#liveSearchResults").change(function ()
                                {
                                   if($("#liveSearchResults span").length>0)
                                   {
                                        $("#liveSearchResults").show();
                                        $("#liveSearchResults").css("z-index",2500);
                                   }
                                   else
                                        $("#liveSearchResults").hide();

  
                                });
                                var liveSearchResultsSelected = false;
				
				$("a.thickbox").addClass("btn btn-primary btn-mini");

                                '
);

$this->Js->get('#liveSearchResults')->event('mousedown', '
                 realTarg = $(event.target);
                 while(!realTarg.hasClass("eventTarget"))
                    realTarg = realTarg.parent();
                 
                 window.location = "/bookings/index/addNamed:searhUserId[=]"+($(realTarg).attr("id"));
            '
);


$this->Js->get('.liveSearch .input')->event('focusout', '
                $("#liveSearchResults").hide();
            '
);

$this->Js->get('#selectedUser .closeButton')->event('click', '
                window.location = "/bookings/index/removeNamed:searhUserId";
            '
);
?>
