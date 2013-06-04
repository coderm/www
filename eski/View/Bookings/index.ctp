<?php
    $this->DatePicker->setShowOlderDates("true");
    $this->DatePicker->init();     

    
    
    if(isset($advertId))
        echo '<h2>#'.$advertId.' Nolu İlana Ait Rezervasyonlar:</h2>';
    else
        echo '<h2>Tüm Rezervasyonlar:</h2>';
?>
<?php 

    if(isset($userPermissions['lp_user_is_admin']))
    {
                    $groupTypes = array
                    (
                      ''=>'Tümü',
                      'pending'=>'Beklemede',
                      'passive'=>'Pasif',
                      'active'=>'Aktif',
                      'cancel'=>'İptal',
                    );
    }                
    echo "<div class='formContainer rounded10'>";
    
    if(isset($userPermissions['lp_user_is_admin']))
    {
        echo "<div>";
            echo '<h3>Arama</h3>';
            echo '<div class="liveSearch formContainer rounded10">';
                echo $this->Form->input('searchString', array('label'=>'Arama (isim, soyisim, telefon numarası ya da mail adresi ile arama yapılabilir)','autocomplete'=>'off'));
                //echo $this->Form->input('location', array('label'=>'Nerede?','autocomplete'=>'off'));
                echo '<div class="results" id="liveSearchResults"></div>';
            echo '</div>';        
        echo "</div>";    
        
        if(isset($selectedUser))
        {
            echo "<div id='selectedUser' class='rounded10' style='background-color:#ECECEC;padding:10px 40px;clear:both;position:relative;margin-bottom:15px;'>";
                echo "<div class='closeButton'></div>";
                echo '<b>'. $selectedUser['User']['uname'] .'</b><br/>';
                echo $selectedUser['User']['name'].' '.$selectedUser['User']['sname'] .'<br/>';
                echo $selectedUser['User']['primary_email'] .'<br/>';
                echo $selectedUser['User']['phone'] .'<br/>';
            echo "</div>";
        }        
            
    }

        echo '<h3>Filtreleme</h3>';
        
        
        if(isset($userPermissions['lp_user_is_admin']))
        {        
            echo '<div style="width:200px;position:relative;float:left;border-right:1px solid white;">';
            echo "<b>Durum Filtresi</b><br/>";
            echo "<ul>";
            foreach($groupTypes as $key=>$groupTypeLabel)
            {
                $cssClass = '';
                if($groupType===$key)
                    $cssClass = 'selected';

                $linkOptions = array();
                $linkOptions['controller'] = 'bookings';
                $linkOptions['action'] = 'index';
                
                $linkOptions = array_merge($linkOptions,$this->passedArgs);

                if(isset($groupType))
                    $linkOptions['groupType'] = $key;
                if(isset($advertId))
                    $linkOptions['advertId'] = $advertId;

                //$linkOptions[':'] = $this->passedArgs;

                echo '<li>';
                echo $this->Html->link($groupTypeLabel,$linkOptions, array('escape' => false,'style'=>'margin-right:0;','class'=>$cssClass)); 
                echo '</li>';
            }
            echo "</ul>";  
            echo "</div>";
        }
        
        echo '<div style="position:relative;float:left;width:660px;padding-left:70px;">';
            echo "<b>Tarih Filtresi</b><br/>";
            echo $this->Form->create('DateFilter');

            $options = array('OperationDate'=>'İşlem Tarihi','StartDate'=>'Başlangıç Tarihi','EndDate'=>'Bitiş Tarihi');
            echo $this->Form->input('filterType', array('type'=>'radio','legend'=>false,'before'=>'<label>Baz alınacak tarih</label><br/>', 'options'=>$options,'default'=>'OperationDate'));    
            echo $this->Form->input('startDate',array('label'=>'İlk tarih','class'=>'pickDate','style'=>'width:85%;','div'=>array('style'=>'width:200px;position:relative;float:left;clear:none')));
            echo $this->Form->input('endDate',array('label'=>'Son tarih','class'=>'pickDate','style'=>'width:85%;','div'=>array('style'=>'width:200px;position:relative;float:left;clear:none;margin-left:30px;')));

            $options = array(
                'label' => 'Tarih Filtresini Uygula',
                'name' => 'ApplyDateFilter',
                'div' => array('style'=>'width:200px;position:relative;float:left;clear:none;margin-left:30px;margin-top:16px;')
            );
            echo $this->Form->end($options);
        echo "</div>";
    echo "<div style='clear:both'></div>";
    echo "</div>";
    
?>
<table>
    <tr>
        <th><?php echo $this->Paginator->sort('booking_id','Rezervasyon No'); ?></th>
        <th><?php echo $this->Paginator->sort('booking_date','İşlem Tarihi'); ?></th>
        <th><?php echo $this->Paginator->sort('start_date','Başlangıç Tarihi'); ?></th>
        <th><?php echo $this->Paginator->sort('end_date','Bitiş Tarihi'); ?></th>
        <th><?php echo $this->Paginator->sort('total_nights','Toplam gece'); ?></th>
        <th><?php echo $this->Paginator->sort('status','Durumu'); ?></th>
        <th>İşlemler</th>
    </tr>

<?php
    
    foreach($bookings as $booking)
    {
        $bookingNo          = $booking['Booking']['booking_id'];
        $operationDate      = $booking['Booking']['booking_date'];
        $startDate          = $booking['Booking']['start_date'];
        $endDate            = $booking['Booking']['end_date'];
        $totalNights        = $booking['Booking']['total_nights'];
        
        $lessorUserId  = $booking['Booking']['lessor_user_s_id'];
        $householderUserId  = $booking['Booking']['householder_user_s_id'];
        $customerUserId     = $booking['Booking']['renter_user_s_id'];
        $advertId           = $booking['Booking']['advert_id'];
        
        $status             = $booking['Booking']['status'];
        
        $hasAnyConflict = 0;
        if($booking['Booking']['conflicting_booking_id']!=0)
            $hasAnyConflict     = ($bookingNo!=$booking['Booking']['conflicting_booking_id']);
        
        $cssClass='';
        if($hasAnyConflict)
            $cssClass = 'conflicted';
        
        //pr($bookingPermissions);
        
        $operations     = '';
        $operations.= $this->Html->link('[Detaylar]',array('action'=>'booking/'.$bookingNo));
        
        if((isset($bookingPermissions['lp_booking_admin_list']) && $status!='active' && $status!='cancel') || $householderUserId == $lessorUserId)
        {
            $operations.= ' '.$this->Html->link('[Sil]',array('action'=>'delete/'.$bookingNo),array('confirm' => 'Rezervasyon silinecek!'));
        }
        
        
        echo '<tr class='.$cssClass.'>';
            echo '<td>'.$bookingNo.'</td>';
            echo '<td>'.$operationDate.'</td>';
            echo '<td>'.$startDate.'</td>';
            echo '<td>'.$endDate.'</td>';
            echo '<td>'.$totalNights.'</td>';
            echo '<td>'.__('booking_status_'.$status).'</td>';
            echo '<td>'.$operations.'</td>';
        echo '</tr>';
    }
?>

</table>
<?php echo $this->element('paginator'); ?>





<?php

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
