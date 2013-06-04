<?php
$this->layout = 'blank';
$this->DatePicker->setShowOlderDates("true");
?>
<script>
    function toggle(id) {
        if( document.getElementById("edit_" + id).style.display=='none' ){
            document.getElementById("edit_" + id).style.display = '';
            document.getElementById("list_" + id).style.display = 'none';
        }else{
            document.getElementById("edit_" + id).style.display = 'none';
            document.getElementById("list_" + id).style.display = '';
        }
    }

</script>

<h3>Rezervasyon Bilgileri</h3>
<?php
echo '<table>';
echo '<tr>';
echo '<td><b>'.$bookingListFanout['BookingListFanout']['booking_id'].'</b></td>';
echo '<td>Giriş Tarihi <b>'.$bookingListFanout['BookingListFanout']['start_date'].'</b></td>';
echo '<td title="'.$bookingListFanout['BookingListFanout']['renter_primary_email'].'&#013;'.$bookingListFanout['BookingListFanout']['renter_phone'].'">Müşteri <b>'.$bookingListFanout['BookingListFanout']['renter'].'</b></td>';
echo '<td title="'.$householder['User']['uname'].'&#013;'.$householder['User']['ldc_primary_email'].'&#013;'.$householder['User']['phone'].'">Ev Sahibi <b>'.$householder['User']['name'].' '.$householder['User']['sname'].'</b></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Adres</td>';
echo '<td colspan="3"><b>' .$advertDetails['ldct_address']['0']['detail'].'</b></td>';
echo '</tr>';
echo '</table>';

$tickIcon = $this->Html->image('acceptedIcon.png', array('alt'=> 'Tamam', 'border' => '0','style'=>'vertical-align:middle;'));
$alertIcon = $this->Html->image('ignoredIcon.png', array('alt'=> 'Hatalı', 'border' => '0','style'=>'vertical-align:middle;'));


echo '<div style="width:320px;float:left;">';
    echo '<h3>Rezervasyon Özeti</h3>';
    echo '<table>';
        echo '<tr>';
            echo '<td><b>Toplam Tutar</b></td>';
            echo '<td>'.$bookingFanouts['outline']['totalPrice'].'</td>';
            if($bookingFanouts['outline']['totalPrice'] == ($bookingFanouts['outline']['ourTotal'] + $bookingFanouts['outline']['customersToHouseholderTotalAmaunt']))
                echo '<td>'.$tickIcon.'</td>';
            else 
                echo '<td>'.$alertIcon.'</td>';
        echo '</tr>';
        
        echo '<tr>';
            echo '<td><b>Ev Sahibi Ödemesi</b></td>';
            echo '<td>'.$bookingFanouts['outline']['houseHolderPrice'].'</td>';
            if($bookingFanouts['outline']['houseHolderPrice'] == ($bookingFanouts['outline']['customersToHouseholderTotalAmaunt'] + ($bookingFanouts['outline']['ourTotal'] - $bookingFanouts['outline']['grossProfit'])))
                echo '<td>'.$tickIcon.'</td>';
            else 
                echo '<td>'.$alertIcon.'</td>';
        echo '</tr>';
        
        echo '<tr>';
            echo '<td><b>Kâr</b></td>';
            echo '<td>'.$bookingFanouts['outline']['grossProfit'].'</td>';
            echo '<td>&nbsp</td>';
        echo '</tr>';
        
        echo '<tr>';
            echo '<td><b>Kâr Oranı</b></td>';
            echo '<td>'.$this->Number->precision($bookingFanouts['outline']['grossProfitPercent'],1).'%</td>';
            if($bookingFanouts['outline']['grossProfitPercent'] > 10)
                echo '<td>'.$tickIcon.'</td>';
            else 
                echo '<td>'.$alertIcon.'</td>';
            echo '</tr>';            
        echo '</tr>';        
    echo '</table>';
echo '</div>';


echo '<div style="width:650px;float:right;">';
echo '<h3>Borçlar Özeti</h3>';
echo '<table>';
echo '<tr>';
echo '<td></td>';
echo '<td><b>Aktif Toplam</b></td>';
echo '<td><b>Pasif Toplam</b></td>';
echo '<td><b>Tutar</b></td>';
echo '<td></td>';
echo '</tr>';

echo '<tr>';
echo '<td>Müşteri -> Tatil Evim</td>';
echo '<td>'.$bookingFanouts['outline']['ourPaid'].'</td>';
echo '<td>'.$bookingFanouts['outline']['ourPayable'].'</td>';
echo '<td>'.$bookingFanouts['outline']['ourTotal'].'</td>';
if($bookingFanouts['outline']['ourTotal'] == ($bookingFanouts['outline']['ourPaid'] + $bookingFanouts['outline']['ourPayable']))
    echo '<td>'.$tickIcon.'</td>';
else 
    echo '<td>'.$alertIcon.'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Müşteri -> Ev Sahibi</td>';
echo '<td>'.$bookingFanouts['outline']['houseHolderPaid'].'</td>';
echo '<td>'.$bookingFanouts['outline']['houseHolderPayable'].'</td>';
echo '<td>'.$bookingFanouts['outline']['customersToHouseholderTotalAmaunt'].'</td>';
if($bookingFanouts['outline']['customersToHouseholderTotalAmaunt'] == ($bookingFanouts['outline']['houseHolderPayable'] + $bookingFanouts['outline']['houseHolderPaid']))
    echo '<td>'.$tickIcon.'</td>';
else 
    echo '<td>'.$alertIcon.'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Tatil Evim -> Ev Sahibi</td>';
echo '<td>'.$bookingFanouts['outline']['activeHouseHolderToPay'].'</td>';
echo '<td>'.$bookingFanouts['outline']['passiveHouseHolderToPay'].'</td>';
echo '<td>'.($bookingFanouts['outline']['ourTotal'] - $bookingFanouts['outline']['grossProfit']).'</td>';
if(($bookingFanouts['outline']['ourTotal'] - $bookingFanouts['outline']['grossProfit']) == ($bookingFanouts['outline']['activeHouseHolderToPay'] + $bookingFanouts['outline']['passiveHouseHolderToPay']))
    echo '<td>'.$tickIcon.'</td>';
else 
    echo '<td>'.$alertIcon.'</td>';
echo '</tr>';


echo '</table>';
echo '</div>';


echo '<table>';
    echo '<tr>';
    echo '<td style="text-align:right;"><b>Tahsil ettiğimiz toplam müşteri ön ödemesi (min '.$bookingFanouts['outline']['grossProfit'].')</b></td>';
    if($bookingFanouts['outline']['grossProfit']<=$bookingFanouts['outline']['ourPaid'])
        echo '<td width="32">'.$tickIcon.'</td>';
    else 
        echo '<td width="32">'.$alertIcon.'</td>';
    echo '</tr>';
echo '</table>';

echo '<h3>İşlem Listesi</h3>';

echo '<table>';



$options = array('active' => __('active'), 'pending' => __('pending'), 'deleted' => __('deleted'));
if ($bookingPermissions['lp_booking_view_all_fanouts']) {
    echo '<tr>';
    echo '<td width="85"><b>Ücret</b></td>';
    echo '<td width="135"><b>Hareket Tipi</b></td>';
    echo '<td width="50"><b>Durum</b></td>';
    echo '<td width="50"><b>Ödeme Tarihi</b></td>';
    echo '<td width="200"><b>Not</b></td>';
    echo '<td width="150"><b>Erişim Detayı</b></td>';
    echo '<td width="50"><b>İşlem</b></td>';
    echo '</tr>';
    foreach ($bookingFanouts['fanouts'] as $bookingFanout) {
        $booking_fanout_id = $bookingFanout['BookingFanout']['booking_fanout_id'];
        $booking_id = $bookingFanout['BookingFanout']['booking_id'];
        $price = $bookingFanout['BookingFanout']['price'];
        $note = $bookingFanout['BookingFanout']['note'];
        $created = $bookingFanout['BookingFanout']['created'];
        $modified = $bookingFanout['BookingFanout']['modified'];
        $status = $bookingFanout['BookingFanout']['status'];
        $is_out = $bookingFanout['TransactionType']['is_out'];
        $transactionDate = $bookingFanout['BookingFanout']['transaction_date'] ;
        $TransactionType = $bookingFanout['TransactionType']['message_text_id'];
        $TransactionTypeId = $bookingFanout['TransactionType']['transaction_type_id'];
        $BankingAccount = $bookingFanout['BankingAccount']['message_text_id'];
        $BankingAccountId = $bookingFanout['BankingAccount']['banking_account_id'];
        $CurrencyUnit = $bookingFanout['CurrencyUnit']['message_text_id'];
        $CurrencyUnitId = $bookingFanout['CurrencyUnit']['currency_unit_id'];
        $CreatedUserUname = $bookingFanout['CreatedUser']['uname'];
        $CreatedUserId = $bookingFanout['CreatedUser']['user_id'];
	
        $ModifiedUserUname = $bookingFanout['LastModifiedUser']['uname'];
        $ModifiedUserId = $bookingFanout['LastModifiedUser']['user_id'];
            
        echo '<tr id ="list_' . $booking_fanout_id . '">';
        echo '<td>' . $price . ' ' . $CurrencyUnit . '</td>';
        echo '<td>' . __($TransactionType) .  '</td>';
        echo '<td>' . __($status) . '</td>';
        echo '<td>' . $transactionDate . '</td>';
        echo '<td><b>' .__($BankingAccount) . '</b><br>' . $note . '</td>';
        echo '<td style="font-size: 9px"><b>E : </b> <font title="Ekleme Tarihi '. $created.'">' . $CreatedUserUname . '</font>';
        echo '<br><b>D : </b><font title="Düzenleme Tarihi '. $modified . '">' . $ModifiedUserUname . '</font></td>';

        if ($bookingPermissions['lp_booking_edit_all_fanouts']) {
            echo '<td>';
            echo $this->Html->link('[Düzenle]', '#', array('onClick' => 'toggle(' . $booking_fanout_id . ');'));
            echo '</td>';
            echo '</tr>';

            echo '<tr style="display:none;" >';
            echo '<td> </td>';
            echo '<td> </td>';
            echo '<td> </td>';
            echo '<td> </td>';
            echo '<td> </td>';
            echo '<td> </td>';
            echo '<td> </td>';
            echo '</tr>';

            echo '<tr id ="edit_' . $booking_fanout_id . '" style="display:none;" >';
            echo $this->Form->create('BookingFanout');
            echo $this->Form->input('BookingFanout.booking_id', array('value' => $bookingNo, 'type' => 'hidden'));
            echo $this->Form->input('BookingFanout.booking_fanout_id', array('value' => $booking_fanout_id, 'type' => 'hidden'));
            echo '<td>' . $this->Form->input('BookingFanout.price', array('value' => $price, 'label' => false, 'style' => 'width:80px'));
            echo $this->Form->input('BookingFanout.currency_unit_id', array('options' => $bookingFanoutCurrencyUnitId, 'default' => $CurrencyUnitId, 'label' => false, 'style' => 'width:80px;min-width:0px;')) . '</td>';
            echo '<td>' . $this->Form->input('BookingFanout.transaction_type_id', array('options' => $bookingFanoutTransactionTypeId, 'default' => $TransactionTypeId, 'label' => false)) ;
            echo $this->Form->input('BookingFanout.banking_account_id', array('options' => $bookingFanoutBankingAccountId, 'default' => $BankingAccountId, 'label' => false)) . '</td>';
            echo '<td>' . $this->Form->input('BookingFanout.status', array('options' => $options, 'default' => $status, 'label' => false)) . '</td>';
            echo '<td>' .  $this->Form->input('BookingFanout.transaction_date', array('value'=>$transactionDate, 'type'=>'text','label' => false, 'class' => 'pickDate', 'style' => 'width:85%;', 'div' => array('style' => 'width:200px;position:relative;float:left;clear:none'))) . '</td>';
            echo '<td width="200">' . $this->Form->textarea('BookingFanout.note', array('value' => $note, 'label' => false)) . '</td>';
            echo '<td><b>Ekleme : </b>' . $CreatedUserUname . '<br>' . $created;
            echo '<br><b>Düzenleme : </b>' . $ModifiedUserUname . '<br>' . $modified . '</td>';
            echo '<td><button type="submit">' . __('Edit') . '</button>';
            echo $this->Html->link('[İptal]', '#', array('onClick' => 'toggle(' . $booking_fanout_id . ');'));
            echo '</td>';
            echo $this->Form->end();
            echo '</tr>';
        } else {

            echo '<td> </td>';
            echo '</tr>';
        }
    }
}

if ($bookingPermissions['lp_booking_add_fanouts']) {
    echo '<tr>';
    echo $this->Form->create('BookingFanout');
    echo $this->Form->input('BookingFanout.booking_id', array('value' => $bookingNo, 'type' => 'hidden'));
    echo '<td>' . $this->Form->input('BookingFanout.price', array('label' => false, 'style' => 'width:80px'));
    echo $this->Form->input('BookingFanout.currency_unit_id', array('options' => $bookingFanoutCurrencyUnitId, 'label' => false, 'style' => 'width:80px;min-width:0px;')) . '</td>';
    echo '<td>' . $this->Form->input('BookingFanout.transaction_type_id', array('options' => $bookingFanoutTransactionTypeId, 'label' => false)) ;
    echo $this->Form->input('BookingFanout.banking_account_id', array('options' => $bookingFanoutBankingAccountId, 'label' => false)) . '</td>';
    $options = array('active' => __('active'), 'passive' => __('passive'), 'pending' => __('pending'));
    echo '<td>' . $this->Form->input('BookingFanout.status', array('options' => $options, 'default' => 'pending', 'label' => false)) . '</td>';
    echo '<td>' .  $this->Form->input('BookingFanout.transaction_date', array('type'=>'text', 'label' => false, 'class' => 'pickDate', 'style' => 'width:85%;', 'div' => array('style' => 'width:200px;position:relative;float:left;clear:none'))) . '</td>';
    echo '<td colspan="2">' . $this->Form->textarea('BookingFanout.note', array('label' => false)) . '</td>';
    echo '<td><button type="submit">' . __('Save') . '</button></td>';
    echo $this->Form->end();
    echo '</tr>';
}
echo '</table>';
?>

 <?php
                if(isset($bookingPermissions['lp_booking_view_customer_agent_note']))
                {
                    echo "<h3>Yönetici Notları</h3>";
                    echo '<div class="rounded10" style="background-color:#ececec;padding:15px 10px 10px;margin-bottom:5px;">';

                    echo '<div id="adminNotes" style="padding:10px;"></div>';
                    echo '<div id="adminNoteLoadingLayer" style="text-align:center;margin:15px;"><img src="/img/loading.gif"></img></div>';                    
                    echo '<center><a href="javascript:return false;"  onclick="$(\'#addAdminNoteForm\').show();">Bu ilana not ekleyin</a></center>';
                    if(isset($bookingPermissions['lp_booking_add_customer_agent_note']))
                    {
                        
                        echo '<div id="addAdminNoteForm" class="rounded10" style="background-color:#D8F9FF;padding:20px 20px;position:relative;display:none;margin-top:-20px;">';
                        echo '<div class="closeButton"></div>';
                        echo $this->Form->create('AdminNote');
                        echo $this->Form->hidden('bookingId',array('value'=>$bookingNo));
                        echo $this->Form->hidden('selectedNoteId',array('value'=>0));
                        echo $this->Form->input('note',array('label'=>'Bu rezervasyonla ilgilli notunuzu girin:','div'=>array('style'=>'clear:none;float:left;position:relative;width:580px;margin:0;')));
                        echo $this->Form->end(array('label'=>'Ekle','id'=>'addAdminNote','div'=>array('style'=>'clear:none;float:left;position:relative;width:80px;margin:0;text-align:right;padding-top:14px;')));
                        echo '<div style="position:relative;clear:both;height:1px;">&nbsp;</div>';
                        echo '</div>';
                    }     
                    
                    echo '</div>';
                }               
            
                       
            
            ?>


<h3>Gönderi Geçmişi</h3>
<table>
    <tr>
        <td>Tarih</td>
        <td>Açıklama</td>
        <td>e-posta</td>
        <td>Durum</td>
        <td>Kullanıcı</td>
    </tr>

<?php
$showInformMailButton = false;
$showConfirmMailButton = false;
foreach ($bookingDetails['EmailHistory'] as $bookingDetail) 
{
 ?>
        <tr>
            <td title="<?php echo $bookingDetail['properties']['date']?>"><?php echo date('d.m.Y H:i',  strtotime($bookingDetail['properties']['date']));?></td>
            <td><?php echo __($bookingDetail['DetailsClass']['message_text_id']);?></td>
            <td><?php echo $bookingDetail['properties']['email'];?></td>
            <td><?php echo __($bookingDetail['properties']['status']);?></td>
            <td><?php echo $bookingDetail['properties']['user']['uname'];?></td>
        </tr>
<?php
        if($bookingDetail['DetailsClass']['message_text_id'] == 'ldc_customer_meta_information_mail' &&  $bookingDetail['properties']['status'] == 'successful' && $bookingFanouts['outline']['ourPaid'] > 0)
            $showConfirmMailButton = true ;
} 
?>
    </table>
<center>
    <?php
    if($bookingFanouts['validateCalculationsResult'] == 1)
        $showInformMailButton = true;
    
    
    if($showInformMailButton)
    {
        echo $this->Html->link(
        'Bilgilendirme iletisi gönder',
        array('controller'=>'Bookings', 'action' => 'sendInformMail/'.$bookingNo),
        array('target' => '_self', 'escape' => false,'class'=>'button yellow2 rounded5','style'=>'margin:5px;')
        );     
        
    }
    
    if($showConfirmMailButton && $showInformMailButton )
    {
        echo $this->Html->link(
        'Onay iletilerini gönder',
        array('controller'=>'Bookings', 'action' => 'sendConfirmMail/'.$bookingNo),
        array('target' => '_self', 'escape' => false,'class'=>'button yellow2 rounded5','style'=>'margin:5px;')
        );       
    }
    
    
   if(isset($bookingPermissions['lp_booking_add_customer_agent_note']))
            {
                $this->Js->get('#addAdminNote')->event('click', 
                                "sendAdminNote();"
                            );   
                $this->Js->buffer(
                '
                    function adminNotesStatus(val)
                    {
                        switch(val)
                        {
                            case "updating":
                                $("#adminNoteLoadingLayer").show();
                            break;
                            case "normal":
                                $("#adminNoteLoadingLayer").hide();
                            break;
                        }
                    }
                    function sendAdminNote()
                    {
                            adminNotesStatus(\'updating\');
                            '.
                                $this->Js->request(array(
                                'controller'=>'Bookings',
                                'action'=>'addAdminNote'
                                ), array(
                                'update'=>'#adminNotes',
                                'success'=>'adminNotesStatus(\'normal\');',
                                'async' => true,
                                'method' => 'post',
                                'dataExpression'=>true,
                                'data'=> $this->Js->serializeForm(array(
                                'isForm' => false,
                                'inline' => true
                                ))
                                ))
                    .'
                        $("#AdminNoteNote").val("");
                    }
                    
                    function deleteAdminNote(noteId)
                    {
                        adminNotesStatus(\'updating\');
                        $("#AdminNoteSelectedNoteId").val(noteId);
                    '.
                                $this->Js->request(array(
                                'controller'=>'Bookings',
                                'action'=>'deleteAdminNote'
                                ), array(
                                'update'=>'#adminNotes',
                                'success'=>'adminNotesStatus(\'normal\');',
                                'async' => true,
                                'method' => 'post',
                                'dataExpression'=>true,
                                'data'=>$this->Js->serializeForm(array(
                                'isForm' => false,
                                'inline' => true
                                ))
                                ))
                    .'
                    }

                        
                    $(document).ready(function() {
                        sendAdminNote();    
                    });
                    
                    
                ');                              
                            
            } 
    
?>
</center>




