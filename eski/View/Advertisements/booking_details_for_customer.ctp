<div class="row">
    <h4 class="headline shadow clear">Rezervasyon İşlemi</h4>
</div>
<?php
    $accordionElements = array();
    $accordionElements['acordion-booking-user'] = array('label'=>'Kullanıcı Bilgileri','element'=>'/users/common');
    
?>

<div class="accordion" id="booking-accordion">
<?php
    $i = 0;
    foreach($accordionElements as $id=>$accordionElement):
?>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#booking-accordion" href="#<?php echo $id?>">
        <?php echo ($i+1);?> <strong><?php echo $accordionElement['label'];?></strong>
      </a>
    </div>
    <div id="<?php echo $id?>" class="accordion-body collapse">
      <div class="accordion-inner">
        
      </div>
    </div>
  </div>
<?php
    endforeach;
?>
</div>

<?php
return;
?>

<div class="accordion" id="booking-acordion">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#booking-acordion" href="#acordion-user-data">
	  1 <strong>Rezervasyon Bilgileri</strong>
      </a>
    </div>
    <div id="acordion-user-data" class="accordion-body collapse in">
      <div class="accordion-inner">
	  <!-- USER DATA-->
	    <div class="span4">
		<div class="row"><?php echo $this->Html->image('rezervasyon.jpg', array('alt'=> 'www.tatilevim.com'));?></div>
	    </div>
	    <div class="span7">
		<h4><i class="icon-bell alpha60"></i> Rezervasyon Bilgisi</h4>
		<p>lorem ipsum dolor sit amet</p>
		
		<div class="row">
		<?php
		echo $this->BSForm->create('User');		
		echo $this->BSForm->input('User.name',array('label'=>'Adınız','bsSpan'=>3));		
		echo $this->BSForm->input('User.sname',array('label'=>'Soyadınız','bsSpan'=>3));	
		echo $this->BSForm->newRow();
		echo $this->BSForm->input('User.email',array('label'=>'E-Posta adresiniz','bsSpan'=>3));
		echo $this->BSForm->input('User.phoneCountryCode',array('bsSpan'=>1,'label'=>'Ülke K.','style'=>'text-align:right;','placeholder'=>'+90'));
		echo $this->BSForm->input('User.phoneNumber',array('bsSpan'=>2,'label'=>'Telefon No','type'=>'text')); 
		echo $this->BSForm->input('Booking.totalPeopleDescription',array('label'=>'Toplam Gelecek Kişi','bsSpan'=>6,'placeholder'=>'Örn: 5 yetişkin 2 çocuk'));	
		echo $this->BSForm->input('Booking.note',array('label'=>'Notunuz:','rows'=>5));
		$label  = $this->Html->link('Rezervasyon ve iptal koşullarını',array('controller'=>'pages','action'=>'display','cancellation_policy'),array('style'=>"font-weight:normal;text-decoration: underline;color#166A9A;")).' okudum, kabul ediyorum.';
		echo $this->BSForm->input('Booking.acceptRentalAgreement', array('type'=>'checkbox','label'=>$label));
		echo $this->BSForm->submit('Rezervasyonu Tamamla', array('class'=>'btn btn-large btn-primary pull-right'));
		echo $this->BSForm->end();
		?>
		</div>
	    </div>
	    <div class="clear"></div>
	  <!-- USER DATA END -->
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#acordion-payment-type">
        2 <strong>Ödeme Yöntemi</strong>
      </a>
    </div>
    <div id="acordion-payment-type" class="accordion-body collapse">
      <div class="accordion-inner">
        Ödeme yöntemi seçimizzz
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#acordion-payment">
        3 <strong>Ödeme</strong>
      </a>
    </div>
    <div id="acordion-payment" class="accordion-body collapse">
      <div class="accordion-inner">
        Ödeme sayfası
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#acordion-result">
        4 <strong>Özet</strong>
      </a>
    </div>
    <div id="acordion-result" class="accordion-body collapse">
      <div class="accordion-inner">
        Özet
      </div>
    </div>
  </div>      
</div>




<!-- Google Code for Rezervasyon Sayfas&#305;na Gelme Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1009776613;
var google_conversion_language = "tr";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "yBJ0CJui0QIQ5e-_4QM";
var google_conversion_value = 0;
if (5) {
  google_conversion_value = 5;
}
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1009776613/?value=5&amp;label=yBJ0CJui0QIQ5e-_4QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>