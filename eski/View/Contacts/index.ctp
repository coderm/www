<div class="row">
<h4 class="headline shadow clear">İletişim</h4>
</div>

<div class="row">
    <div class="span12">
	<div class="well lightblue">
	    <div class="span4">
		<?php echo $this->Html->image('contact.png', array('alt'=> 'www.tatilevim.com'));?>
	    </div>
	    <div class="span7">
		<table class="table">
		    <tr>
			<th colspan="2">İletişim Bilgileri</th>
		    </tr>
		    <tr>
			<td style="text-align: right;">Telefon:</td>
			<td>+90 216 505 06 91</td>
		    </tr>
		    <tr>
			<td style="text-align: right;">e-posta:</td>
			<td><a href="mailto:info@tatilevim.com">info@tatilevim.com</a></td>
		    </tr>	
		    <tr>
			<td style="text-align: right;">Adres:</td>
			<td>
			    Tatil Evim Turizm Emlak Bilgi Teknolojileri Pazarlama San. ve Tic. Ltd. Şti.<br/>
			    Eğitim Mh. Kasap İsmail Sk.<br/>
			    Avrasya İş Merkezi 14/32<br/>
			    TR 34722 Kadıköy / İSTANBUL
			    
			</td>
		    </tr>		    
		</table>
	    </div>
	    <div class="clear"></div>
	</div>
    </div>    
    <div class="span7 well lightblue">
	<table class="table">
	    <tr>
		<th colspan="2">Firma Bilgileri</th>
	    </tr>
	    <tr>
		<td style="text-align: right;">Ünvan:</td>
		<td>Tatil Evim Turizm, Emlak, Bilgi Teknolojileri<br/> Pazarlama San. ve Tic. Ltd. Şti.</td>
	    </tr>
	    <tr>
		<td style="text-align: right;">Vergi no:</td>
		<td>Kadıköy Vergi Dairesi 8310431689 </td>
	    </tr>	    
	    <tr>
		<th  colspan="2">Banka hesap numaraları</th>
	    </tr>
	    <tr>
		<td style="text-align: right;"></td>
		<td>Garanti Bankası Türk Lirası Hesabı</td>
	    </tr>
	    <tr>
		<td style="text-align: right;"></td>
		<td>IBAN: TR090006200078700006298617</td>
	    </tr>	
	    <tr>
		<td style="text-align: right;"></td>
		<td>Garanti Bankası Euro Hesabı</td>
	    </tr>
	    <tr>
		<td style="text-align: right;"></td>
		<td>IBAN: TR760006200078700009094988</td>
	    </tr>	
	</table>	

    </div>

    <div class="span4 well lightblue">
	<h5>Bize Yazın <i class="icon-envelope pull-right alpha60"></i> </h5>
	<?php
	    echo $this->Form->create('Contact', array('action' => 'index'));
	    echo $this->Form->input('name',array('label'=>false,'placeholder'=>'Adınız'));
	    echo $this->Form->input('sname',array('label'=>false,'placeholder'=>'Soyadınız'));
	    echo $this->Form->input('email',array('label'=>false,'placeholder'=>'e-posta adresiniz'));
	    echo $this->Form->input('phoneNumber',array('label'=>false,'placeholder'=>'Telefon numaranız'));
	    echo $this->Form->input('subject',array('label'=>false,'placeholder'=>'Konu','class'=>'input-block-level'));
	    echo $this->Form->input('message',array('label'=>false,'placeholder'=>'Mesajınız','class'=>'input-block-level'));
	    echo '<center>';
	    echo $this->Form->end(array('label'=>'Gönder','class'=>'btn btn-primary pull-right'));
	    echo '</center>';
	?>
    </div>
</div>

