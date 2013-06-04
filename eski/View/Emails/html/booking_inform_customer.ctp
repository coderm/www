<style type="text/css">
#npik04GK body {
	width:100%;
	margin:0 auto;
	background-color:#5E8B46;
}
#npik04GK .yiv1283252876ExternalClass {
	width:100%;
	background-color:#5E8B46;
}
a, a:hover, a:visited {
	color:#166a9a;
	font-weight:bold;
	text-decoration:none;
}
</style>
<table class="npik04GK" style="width:100%;margin:0 auto;" bgcolor="#166a9a" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
  <tbody>
    <tr>
      <td valign="top" align="center"><table border="0" cellpadding="0" cellspacing="0" width="700" align="center">
          <tr>
            <td><table border="0" cellpadding="0" cellspacing="0" align="center" style="background:#fff;">
                <tr>
                  <td colspan="5" style="height:30px;">&nbsp;</td>
                </tr>
                <tr>
                  <td></td>
                  <td colspan="3"><a rel="nofollow" target="_blank" href="http://tatilevim.com" style="color:#8ad6f5;font-weight: bold;font-size:34px;line-height:66px;text-decoration:none;"> <img alt="tatilevim.com" src="http://tatilevim.com/mailing/npik04GK/logo.gif" style="display:block;" height="66" border="0" width="266"/> </a></td>
                  <td></td>
                </tr>
                <tr>
                  <td width="18"></td>
                  <td width="566" height="390" valign="top" style="#4a4a4a;color:#1fa2d9;"><font style="font-family:Arial, Helvetica, sans-serif;font-size:22px;line-height:normal;font-weight:bold;">
                    Tatil Evim Ön Rezervasyon Bilgilendirmesi</font><br />
                    <br/>
                    <font style="font-family:Arial, Helvetica, sans-serif;font-size:16px;color:#082433;font-weight:normal;line-height:normal;font-style: italic;">Sayın <?php echo $customer['User']['name'].' '.$customer['User']['sname'];?>,</font><br/>
                    <font style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#082433;font-weight:normal;line-height:normal;">Aşağıda ön rezervasyon bilgileriniz yer almaktadır.<br/>
                    Ön ödemenize istinaden kesin rezervasyonunuz yapılacaktır.<br/>
                    Lütfen bilgilerinizi kontrol ediniz. <br/>
                    

                    <br/>
                    Ön rezervasyonu yapılan ilanın bağlantı adresi:<br/>
                    <br/>
                    <a rel="nofollow" target="_blank" href="http://tatilevim.com<?php echo $this->Html->url($advert['vw_get_adverts']['urlOptions']) ?>">http://www.tatilevim.com/<?php echo $this->Html->url($advert['vw_get_adverts']['urlOptions']) ?></a> <br/>
                    <br/>
                    <table style="width:100%;margin:0 auto;font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#082433;font-weight:normal;line-height:normal;"  border="0" cellpadding="0" cellspacing="0" >
                      <tr>
                        <td colspan="5" style="height:10px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="5">Rezervasyon özeti</td>
                      </tr>
                      <tr style="background-color:#ececec;font-style:italic;font-size:11px;">
                        <td style="padding:3px;">İlan no</td>
                        <td style="padding:3px;">Rezervasyon no</td>
                        <td style="padding:3px;">Başlangıç tarihi</td>
                        <td style="padding:3px;">Bitiş tarihi</td>
                        <td style="padding:3px;">Kişi sayısı</td>
                      </tr>
                      <tr style="color:#166a9a; font-weight:bold;background-color:#8bd7f6;">
                        <td style="padding:3px;">#<?php echo $booking['Booking']['advert_id'];?></td>
                        <td style="padding:3px;">#<?php echo $booking['Booking']['booking_id'];?></td>
                        <td style="padding:3px;"><?php echo date("d.m.Y", strtotime($booking['Booking']['start_date']));?></td>
                        <td style="padding:3px;"><?php echo date("d.m.Y", strtotime($booking['Booking']['end_date']));?></td>
                        <td style="padding:3px;"><?php echo $booking['Booking']['the_number_of_guests_coming'];?></td>
                      </tr>
                      <tr>
                        <td colspan="5" style="height:10px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="5">Ödeme özeti</td>
                      </tr>
                      <tr style="background-color:#ececec;font-style:italic;font-size:11px;">
                        <td style="padding:3px;" colspan="2">Hesap sahibi</td>
                        <td></td>
                        <td style="padding:3px;">Tarih</td>
                        <td style="padding:3px;" align="right">Miktar</td>
                      </tr>
                      
                    <?php 
                    foreach ($bookingFanouts['fanouts']  as $bookingFanout) 
                    {
                        $date = date("d.m.Y", strtotime($bookingFanout['BookingFanout']['transaction_date']));
                        $price = $bookingFanout['BookingFanout']['price'];
                        $currency = $bookingFanout['CurrencyUnit']['message_text_id'];
                        $priceText = $this->Number->format($price, array('places' => 2, 'before'=>'', 'after' => ' '.$currency,    'escape' => false,    'decimals' => '.',    'thousands' => ','));
                        $transectionType = $bookingFanout['TransactionType']['message_text_id'];
                        
                        $show = false;
                        switch($transectionType)
                        {
                            case 'ltt_custumer_payment':
                                $paymentDescription  = 'Tatil Evim\'e yapılacak ödeme';
                                $show = true;
                                break;
                            case 'ltt_booking_costumer_pay_householder':
                                $paymentDescription  = 'Ev sahibine yapılacak ödeme';
                                $show = true;
                                break;
                            case 'ltt_booking_costumer_price':
                                $totalPrice = $price;
                                $totalPriceCurrency = $currency;
                                break;
                        }
                        if($show)
                        {
                    ?>
                            <tr style="color:#166a9a; font-weight:bold;background-color:#8bd7f6;">
                                <td style="padding:3px;" colspan="2"><?php echo $paymentDescription ?></td>
                                <td></td>
                                <td style="padding:3px;"><?php echo $date; ?></td>
                                <td style="padding:3px;" align="right"><?php echo $priceText; ?></td>
                            </tr> 
                    <?php
                        }
                    }
                    
                    $totalPriceText = $this->Number->format($totalPrice, array('places' => 2, 'before'=>'', 'after' => ' '.$totalPriceCurrency,    'escape' => false,    'decimals' => '.',    'thousands' => ','));
                    ?>

     
                    <tr style="background-color:#ececec;font-style:italic;font-size:11px;">
                            <td style="padding:3px;" colspan="4"></td>
                            <td style="padding:3px;" align="right">Toplam tutar</td>
                    </tr>
                    <tr style="color:#166a9a; font-weight:bold;background-color:#8bd7f6;">
                            <td style="padding:3px;" colspan="4"></td>
                            <td style="padding:3px;" align="right"><?php echo $totalPriceText ?></td>
                    </tr> 

                    
                    <tr>
                        <td colspan="5" style="height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">Alıcı: <i><b>Tatil Evim Turizm Emlak Ltd. Şti.</b></i></td>
                    </tr>
                    <tr style="background-color:#ececec;font-style:italic;font-size:11px;">
                        <td style="padding:3px;" colspan="3">Hesap</td>
                        <td style="padding:3px;" colspan="2">IBAN</td>
                    </tr>                    
                    <tr style="color:#166a9a; font-weight:bold;background-color:#8bd7f6;">
                        <td style="padding:3px;" colspan="3">Garanti Bankası Türk Lirası Hesabı</td>
                        <td style="padding:3px;" colspan="2">TR090006200078700006298617</td>
                    </tr>  
                    <tr style="color:#166a9a; font-weight:bold;background-color:#8bd7f6;">
                        <td style="padding:3px;" colspan="3">Garanti Bankası Euro Hesabı</td>
                        <td style="padding:3px;" colspan="2">TR760006200078700009094988</td>
                    </tr>  
                    <tr style="color:#166a9a; font-weight:bold;background-color:#8bd7f6;">
                        <td style="padding:3px;" colspan="3">Swift Kodu:</td>
                        <td style="padding:3px;" colspan="2">TGBATRIS</td>
                    </tr>
                    
                            
                      <tr>
                        <td colspan="5" style="height:10px;">&nbsp;</td>
                      </tr>
                      <tr>
                          <td colspan="5">
                              Rezervasyonunuzun iptal koşullarını aşağıdaki bağlantıya tıklayarak görüntüleyebilirsiniz:<br/>
                              http://www.tatilevim.com/iptal-kosullari
                          </td>
                      </tr>
                  
                      <tr>
                      	<td colspan="5" style="text-align:right;">www.tatilevim.com</td>
                      </tr>
                      <tr>
                        <td colspan="5" style="height:10px;">&nbsp;</td>
                      </tr>                      
                      <tr>
                          <td colspan="5" align="center" style="font-size:10px;">
                              Tatil Evim Turizm Emlak Bilgi Teknolojileri Pazarlama San. ve Tic. Ltd. Şti.<br/>
                              Eğitim Mh. Kasap İsmail Sk. Avrasya İş Merkezi 14/32 TR 34722 Kadıköy / İSTANBUL<br/> 
                              t:90 212 990 0 555
                          </td>
                      </tr>
                    </table>
                    </font><br/></td>
                  <td width="18"></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
  </tbody>
</table>
