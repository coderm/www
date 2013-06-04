<?php
if (isset($skin))
    $this->layout = $skin;
?>
<div class="details">
    <div style="padding:5px;text-align: center;">
        <?php
        /*
        if (isset($bookingPermissions['lp_booking_admin_list'])) {
            $operations = $this->Html->link('Kullanıcıya onay maili gönder', array('action' => 'sendConfirmMailToUser/' . $booking['Booking']['booking_id']), array('class' => 'button rounded5'));
            $operations.= $this->Html->link('Posta için çıktı al', '#', array('class' => 'button rounded5', 'id' => 'printButton'));
            echo $operations;
        }*/
        echo "";
        ?>
    </div>
    <h2>Rezervasyon Detayları</h2>
    <h3>Özet</h3>
    <table>
        <tr>
            <td>Rezervasyon No:</td>
            <td><b>#<?php echo $booking['Booking']['booking_id']; ?></b></td>
        </tr>    
        <tr>
            <td>Başlangıç tarihi:</td>
            <td><?php echo $booking['Booking']['start_date']; ?></td>
        </tr>
        <tr>
            <td>Bitiş tarihi:</td>
            <td><?php echo $booking['Booking']['end_date']; ?></td>
        </tr>
        <tr>
            <td>Gelecek kişi sayısı:</td>
            <td><?php echo $booking['Booking']['the_number_of_guests_coming']; ?></td>
        </tr>    
        <tr>
            <td>Rezervasyonu Yapan Kişi:</td>
            <td><?php echo $operator['User']['uname'];
        ; ?></td>
        </tr>    
    </table>
    <?php if ((!isset($lttBookingCostumerPrice['BookingFanout']['price']) || !isset($lttBookingHouseholderPrice['BookingFanout']['price'])) && isset($bookingPermissions['lp_booking_admin_list'])) { ?>

        <h3>Rezervasyon Parasal Bilgiler</h3>
        <table>
            <?php if (!isset($lttBookingCostumerPrice['BookingFanout']['price'])) { ?>
                <tr>
                    <td>Toplam Tutar:</td>
                    <td><?php
        echo $booking['Booking']['booking_price'] . ' ' . $booking['Booking']['currency_unit_text'];

        echo $this->Form->create('BookingFanout', array('url' => '/BookingFanouts/index/' . $booking['Booking']['booking_id']));
        echo $this->Form->input('BookingFanout.booking_id', array('value' => $booking['Booking']['booking_id'], 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.price', array('value' => $booking['Booking']['booking_price'], 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.currency_unit_id', array('value' => $booking['Booking']['currency_unit'], 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.transaction_type_id', array('value' => '4', 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.status', array('value' => 'active', 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.transaction_date', array('value' => date("d-m-Y"), 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.note', array('value' => 'Otomatik Eklendi', 'type' => 'hidden'));
        echo $this->Form->input('backurl', array('value' => '/bookings/booking/' . $booking['Booking']['booking_id'], 'type' => 'hidden'));
        echo $this->Form->submit('Toplam Tutarı Onayla');
        echo $this->Form->end();
                ?> 
                    </td>
                </tr>   
            <?php }
            if (!isset($lttBookingHouseholderPrice['BookingFanout']['price'])) { ?>   
                <tr>
                    <td>Ev Sahibi Ödemesi:</td>
                    <td><?php
        echo $booking['Booking']['householder_price'] . ' ' . $booking['Booking']['currency_unit_text'];

        echo $this->Form->create('BookingFanout', array('url' => '/BookingFanouts/index/' . $booking['Booking']['booking_id']));
        echo $this->Form->input('BookingFanout.booking_id', array('value' => $booking['Booking']['booking_id'], 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.price', array('value' => $booking['Booking']['householder_price'], 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.currency_unit_id', array('value' => $booking['Booking']['currency_unit'], 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.transaction_type_id', array('value' => '3', 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.status', array('value' => 'active', 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.transaction_date', array('value' => date("d-m-Y"), 'type' => 'hidden'));
        echo $this->Form->input('BookingFanout.note', array('value' => 'Otomatik Eklendi', 'type' => 'hidden'));
        echo $this->Form->input('backurl', array('value' => '/bookings/booking/' . $booking['Booking']['booking_id'], 'type' => 'hidden'));
        echo $this->Form->submit('Ev Sahibi Ödemesini Onayla');
        echo $this->Form->end();
        ?></td>
                </tr>
            <?php } ?>
        </table>    
    <?php } ?>
    <h3>Ödeme Bilgileri</h3>
    <table>

        <?php if (isset($lttBookingCostumerPrice['BookingFanout']['price'])) { ?> 
            <tr>
                <td>Toplam Tutar:</td>
                <td><?php echo $lttBookingCostumerPrice['BookingFanout']['price'] . ' ' . $lttBookingCostumerPrice['CurrencyUnit']['message_text_id']; ?></td>
            </tr>  
        <?php } ?>
        <?php if (isset($lttBookingHouseholderPrice['BookingFanout']['price'])) { ?>
            <tr>
                <td>Toplam Ev Sahibi Ödemesi:</td>
                <td><?php echo $lttBookingHouseholderPrice['BookingFanout']['price'] . ' ' . $lttBookingHouseholderPrice['CurrencyUnit']['message_text_id']; ?></td>
            </tr>
        <?php } ?>
        <?php
        if (isset($lttBookingCostumerPrice['BookingFanout']['price']) &&
                isset($lttBookingHouseholderPrice['BookingFanout']['price']) &&
                $lttBookingHouseholderPrice['CurrencyUnit']['message_text_id'] == $lttBookingCostumerPrice['CurrencyUnit']['message_text_id']) {
            ?>

            <tr>
                <td>Kazanç:</td>
                <td><?php echo $this->Number->precision($lttBookingCostumerPrice['BookingFanout']['price'] - $lttBookingHouseholderPrice['BookingFanout']['price'], 2) . ' ' . $lttBookingCostumerPrice['CurrencyUnit']['message_text_id']; ?></td>
            </tr>  
        <?php } ?>

        <?php if (isset($totals[1])) { ?>
            <tr>
                <td>Alınan Toplam Ödemeler:</td>
                <td><?php
        foreach ($totals[1] as $key => $total) {
            echo $total . ' ' . $key . '<br/>';
        }
            ?></td>
            </tr>
            <?php if (isset($lttBookingCostumerPrice['BookingFanout']['price']) && isset($totals[1][$lttBookingCostumerPrice['CurrencyUnit']['message_text_id']])) { ?>

                <tr>
                    <td>Kalan Tutar:</td>
                    <td><?php echo $this->Number->precision($lttBookingCostumerPrice['BookingFanout']['price'] - $totals[1][$lttBookingCostumerPrice['CurrencyUnit']['message_text_id']], 2) . ' ' . $lttBookingCostumerPrice['CurrencyUnit']['message_text_id']; ?></td>
                </tr>  
            <?php } ?>
        <?php } ?>
        <?php if (isset($totals[0])) { ?>
            <tr>
                <td>Ev Sahibine Yapılan Toplam Ödemeler:</td>
                <td><?php
        foreach ($totals[0] as $key => $total) {
            echo $total . ' ' . $key . '<br/>';
        }
            ?> </td>
            </tr>
        <?php } ?>
        <tr>
            <td>Depozito Miktarı:</td>
            <td><?php echo $booking['Booking']['booking_deposit'] . ' ' . $booking['Booking']['currency_unit_text']; ?></td>
        </tr>
   </table> 


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
                        $bookingId = $booking['Booking']['booking_id'];
                        
                        echo '<div id="addAdminNoteForm" class="rounded10" style="background-color:#D8F9FF;padding:20px 20px;position:relative;display:none;margin-top:-20px;">';
                        echo '<div class="closeButton"></div>';
                        echo $this->Form->create('AdminNote');
                        echo $this->Form->hidden('bookingId',array('value'=>$bookingId));
                        echo $this->Form->hidden('selectedNoteId',array('value'=>0));
                        echo $this->Form->input('note',array('label'=>'Bu rezervasyonla ilgilli notunuzu girin:','div'=>array('style'=>'clear:none;float:left;position:relative;width:580px;margin:0;')));
                        echo $this->Form->end(array('label'=>'Ekle','id'=>'addAdminNote','div'=>array('style'=>'clear:none;float:left;position:relative;width:80px;margin:0;text-align:right;padding-top:14px;')));
                        echo '<div style="position:relative;clear:both;height:1px;">&nbsp;</div>';
                        echo '</div>';
                    }     
                    
                    echo '</div>';
                }               
            
                       
            
            ?>
    <h3>Müşteri Bilgisi</h3>
    <table>
        <tr>
            <td>Kullanıcı Adı:</td>
            <td><?php echo $customer['User']['uname']; ?></td>
        </tr> 
        <tr>
            <td>Cinsiyet:</td>
            <td><?php echo $customer['User']['gender']; ?></td>
        </tr>    
        <tr>
            <td>Ad:</td>
            <td><?php echo $customer['User']['name']; ?></td>
        </tr>
        <tr>
            <td>Soyad:</td>
            <td><?php echo $customer['User']['sname']; ?></td>
        </tr>
        <tr>
            <td>e-posta:</td>
            <td><?php echo $customer['User']['primary_email']; ?></td>
        </tr>    
        <tr>
            <td>Telefon:</td>
            <td><?php echo $customer['User']['phone']; ?></td>
        </tr>        
    </table>
    <h3>Ev sahibi bilgisi</h3>
    <table>
        <tr>
            <td>Kullanıcı Adı:</td>
            <td><?php echo $houseHolder['User']['uname']; ?></td>
        </tr> 
        <tr>
            <td>Cinsiyet:</td>
            <td><?php echo $houseHolder['User']['gender']; ?></td>
        </tr>    
        <tr>
            <td>Ad:</td>
            <td><?php echo $houseHolder['User']['name']; ?></td>
        </tr>
        <tr>
            <td>Soyad:</td>
            <td><?php echo $houseHolder['User']['sname']; ?></td>
        </tr>
        <tr>
            <td>e-posta:</td>
            <td><?php echo $houseHolder['User']['primary_email']; ?></td>
        </tr>    
        <tr>
            <td>Telefon:</td>
            <td><?php echo $houseHolder['User']['phone']; ?></td>
        </tr>        
    </table>
    <h3>İlan özeti</h3>
    <div>
        <?php
        echo $this->element('list_item', array('advert' => $advertForListItem, 'maxTitleLength' => 150, 'maxDescriptionLength' => 350));
        ?>
    </div>
    <span style="clear:both;width:100%;position:relative;float:left;">&nbsp;</span>
    <h3>İlan detayları</h3>
    <table>
        <tr>
            <td>İlan No</td>
            <td><b>#<?php echo $advert['lcdt_title'][0]['advert_id']; ?></b></td>
        </tr>    
        <tr>
            <td>Başlık</td>
            <td><b><?php echo $advert['lcdt_title'][0]['detail']; ?></b></td>
        </tr>
        <tr>
            <td>Açıklama</td>
            <td><?php echo $advert['lcdt_description'][0]['detail']; ?></td>
        </tr>    
        <tr>
            <?php $a = $this->requestAction('/advertisements/parseProperties/' . $advert['lcdt_city'][0]['detail']);
            $keys = array_keys($a); ?>
            <td>İl:</td>
            <td><?php echo $a[$keys[0]]; ?></td>
        </tr>
        <tr>
            <?php $a = $this->requestAction('/advertisements/parseProperties/' . $advert['lcdt_county'][0]['detail']);
            $keys = array_keys($a); ?>
            <td>İlçe:</td>
            <td><?php echo $a[$keys[0]]; ?></td>
        </tr>    
    </table>
    <?php if ($skin != 'blank') { ?>
        <h3>Rezervasyon Takvimi</h3>
        <?php echo $this->element('dateChooser', array('bookingDays' => $bookingDays));
    } ?>
</div>
<?php
$this->Js->Buffer(
        '
                $("#printButton").printPage({
                url: "/bookings/printBooking/' . $booking['Booking']['booking_id'] . '",
                attr: "href",
                message:"Döküman hazırlanıyor"
                })                
            '
);
        
         
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
