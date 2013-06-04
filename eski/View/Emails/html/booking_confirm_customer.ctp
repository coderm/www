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
                    Tatil Evim Kesin Rezervasyon Onayı</font><br />
                    <br/>
                    <font style="font-family:Arial, Helvetica, sans-serif;font-size:16px;color:#082433;font-weight:normal;line-height:normal;font-style: italic;">Sayın <?php echo $customer['User']['name'].' '.$customer['User']['sname'];?>,</font><br/>
                    <font style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#082433;font-weight:normal;line-height:normal;">Aşağıda tatilevim.com üzerinden yapmış olduğunuz rezervasyon bilgileriniz yer almaktadır.<br/>
                    Lütfen bilgilerinizi kontrol ediniz. <br/>
                    

                    <br/>
                    Rezerve edilen ilan bağlantı adresi:<br/>
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
                        <td colspan="5">İrtibat</td>
                      </tr>
                      <tr style="background-color:#ececec;font-style:italic;font-size:11px;">
                        <td style="padding:3px;" colspan="2">Ev Sahibiniz</td>
                        <td style="padding:3px;" colspan="3">Telefonu</td>
                      </tr>
                      <tr style="color:#166a9a; font-weight:bold;background-color:#8bd7f6;">
                        <td style="padding:3px;" colspan="2"><?php echo $houseHolder['User']['name'].' '.$houseHolder['User']['sname'];?></td>
                        <td style="padding:3px;" colspan="3"><?php echo $houseHolder['User']['phone'];?></td>
                      </tr>
                      <tr>
                        <td colspan="5" style="height:10px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="5" width="100%">Ulaşım</td>
                      </tr>
                      <tr style="background-color:#ececec;font-style:italic;font-size:11px;">
                        <td style="padding:3px;" colspan="5">Adres</td>
                      </tr>
                      <tr style="color:#166a9a; font-weight:bold;background-color:#8bd7f6;">
                        <td style="padding:3px;" colspan="5"><?php echo $advert['vw_get_adverts']['address'];?></td>
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
                        $status = $bookingFanout['BookingFanout']['status'];
                        
                        
                        $show = false;
                        switch($transectionType)
                        {
                            case 'ltt_custumer_payment':
                                $paymentDescription  = 'Tatil Evim\'e';
                                $show = true;
                                break;
                            case 'ltt_booking_costumer_pay_householder':
                                $paymentDescription = 'Ev sahibine';
                                $show = true;
                                break;
                            case 'ltt_booking_costumer_price':
                                $totalPrice = $price;
                                $totalPriceCurrency = $currency;
                                break;
                        }
                        
                        if($show)
                        {
                            if($status=='active')
                                $paymentDescription.=' yapılmış ödeme';
                            else
                                $paymentDescription.=' yapılacak ödeme';                            
                            
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
                      <tr style="font-size:11px;">
                          <td colspan="5">
                              <p>Tatilevim.com ‘ dan kiraladığınız tatil evlerinde, Tatilevim.com’un  sorumluluğu sadece rezervasyon işlemlerinin gerçekleştirilmesi , ödemelerin ‘’Güvenli Rezervasyon Sistemi’’  ile alınması, Konutun misafire ilanda belirtildiği gibi sorunsuz şekilde teslim edilmesi halinde yine bu ödemelerin Ev sahiplerine ödenmesi, bu ödeme süreçlerinin takibi ve tatil evi ile diğer rezervasyon süreçlerinin yönetilmesini kapsamaktadır.</p>
                              <ul style="margin:0 0 0 10px;padding:0;">
                                    <li>Seyahat planınızı yapmadan önce ev sahibinizle lütfen iletişim kurun, yolculuk planınızı ev sahibinden destek alarak oluşturabilirsiniz.</li>
                                    <li>Ev sahibinizden tatil evinize ulaşım, adres, eve giriş ve çıkış saatleri ile ilgili bilgileri almanızı öneririz.</li>
                                    <li>Tatil evlerinde, tatil süresince tatil evinin sorumluluğunun sizde olduğunu unutmayın, eve giriş yaptığınızda ev sahibinizle beraber evi kontrol edin. Herhangi hasarlı bir eşya veya  can güvenliginizi tehlikeye atacak (açık kablo, kırık piriz vb.) bir durum varsa ev sahibinizi bilgilendirin ve sorunun giderilmesini isteyin.</li>
                                    <li>Tatil evinizi özenli kullanmaya özen gösterin. İyi bir misafir olun.</li>
                                    <li>Bölge hakkında daha fazla bilgi edinmek istiyorsanız önceden araştırma yapın veya sorularınız varsa ev sahibinizden destek alabilirsiniz.</li>
                                    <li>Kiraladığınız ev ile ilgili olarak eve girişte ve evden çıkışta herhangi bir sıkıntı ile karşılaşmamak için sizden talep edilebilecek hasar depozitosu, elektrik, su ve temizlik ücretleri ile ilgili olarak tatile çıkmadan önce mutlaka ev sahibinizi arayarak bilgi alınız.</li>
                              </ul>                              
                              
                          </td>
                      </tr>     
                      <tr>
                        <td colspan="5" style="height:10px;">&nbsp;</td>
                      </tr>                      
                      <tr>
                        <td colspan="5" style="text-align:right;"><font style="color:#166a9a;font-weight:bold;font-style:italic;font-family:Arial, Helvetica, sans-serif;color:#4a4a4a;">Mutlu tatiller dileriz!</font></td>
                      </tr>
                      <tr>
                      	<td colspan="5" style="text-align:right;">www.tatilevim.com</td>
                      </tr>
                      <tr>
                        <td colspan="5" style="height:10px;">&nbsp;</td>
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
