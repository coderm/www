<!-- File: /app/View/Advertisements/booking_details.ctp -->
<div style="width:700px;float:left;" class="formContainer rounded10">
<?php echo $this->element('headline',array('label'=>'Rezervasyon Bilgilerini Girin'))   ?>
    <b>Neden müşteri bilgilerini sisteme girmeliyim?</b><br/><br/>
    <p>Rezervasyon için müşterinizin bilgilerini sisteme girmeniz kendi evinizin rezervasyonlarını kolayca yönetmenizi sağlar.</p>
    <p>Ayrıca kendi rezervasyonlarını sisteme girmeniz ilanınızın uygunluk takviminin daha doğru görünmesini sağlayarak, size ve kullanıcılarımıza daha iyi hizmet verebilmemizi sağlar.</p>
    <p>Gireceginiz müşteri bilgileriniz hiç bir şekilde değiştirilmez, kullanılmaz ve 3. şahıslarla paylaşılmaz.</p>
<?php
echo $this->Form->create('User');
if(isset($showUserForm) && $showUserForm)
{
    echo $this->Form->input('name',array('label'=>'Adı'));
    echo $this->Form->input('sname',array('label'=>'Soyadı'));
    echo $this->Form->input('email1',array('label'=>'e-posta adresi'));
    echo $this->Form->input('phoneNumber',array('label'=>'Telefon numarası (örn: 532 555 55 55)','class'=>'phone'));
    //echo $this->Form->input('address',array('label'=>'Açık Adresiniz:'));
    //echo $this->Form->input('city', array('options' => $cities, 'empty' => '-- Seçiniz --','label'=>'İl'), null);
    //echo $this->Form->input('county', array('options' => array(), 'empty' => '-- İl Seçiniz --','label'=>'İlçe','ajaxParent'=>67), null);
}
echo $this->Form->input('totalGuests',array('label'=>'Toplam gelecek kişi sayısı:'));
echo $this->Form->input('note',array('label'=>'Notunuz:','rows'=>5));
echo '<center>';
echo $this->Form->end('Tamam');
echo '</center>';
echo '</div>';
if(isset($showUserForm) && $showUserForm)
{
            $parentId = '#UserCity';
            $targetId = '#UserCounty';
            
            $this->Js->get($parentId)->event('change', 
            $this->Js->request(array(
            'controller'=>'advertisements',
            'action'=>'getByCategory/68/'
            ), array(
            'update'=>$targetId,
            'async' => true,
            'method' => 'post',
            'dataExpression'=>true,
            'data'=> $this->Js->serializeForm(array(
            'isForm' => true,
            'inline' => true
            ))
            ))
            );
}
?>

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