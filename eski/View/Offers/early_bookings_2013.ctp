<?php
    $tabElements = array();
    $tabElements[] = $this->Html->link('Tümü',array('controller'=>'offers','action'=>'view',2));
    $tabElements['didim'] = $this->Html->link('Didim',array('controller'=>'offers','action'=>'view',2,'location'=>'didim'));
    $tabElements['bodrum'] = $this->Html->link('Bodrum',array('controller'=>'offers','action'=>'view',2,'location'=>'bodrum'));
    
    if(isset($this->passedArgs['location']))
	$activeTab = $this->passedArgs['location'];
    else
	$activeTab = 0;
    
?>

 

<div class="row clear">
    <h4 class="headline shadow">2013 Erken Rezervasyon Fırsatları</h4>
</div>
<div>
	<ul class="nav nav-tabs">
	<?php
	    foreach($tabElements as $key => $tabElement)
	    {
		if($activeTab === $key)
		    echo '<li class="active">'.$tabElement.'</li>';
		else
		    echo '<li>'.$tabElement.'</li>';
	    }
	?>
	</ul>
</div>

<div>
<?php echo $this->Element('pages/home/advert_list',array('adverts'=>$adverts,'label'=>false,'modelName'=>'vw_get_adverts')) ;?>	
</div>

<hr/>


<div class="row clear">
    <h4 class="headline shadow">2013 Erken Rezervasyon Kampanyası Koşulları</h4>
</div>
<div class="clear">
	<?php echo $this->Html->image('offers/2013_erken_rezervasyon.jpg');?>
</div>

<div class="well">
    <h5>Erken Rezervasyon</h5>
    <p>TatilEvim.com 400'den fazla erken rezervasyon indiriminin geçerli olduğu evle %30'a varan indirim imkanı veya kişi başı 20TL'den başlayan çok uygun fiyatlarla konaklama imkanı sunmaktadır. Erken Rezervasyon imkanı misafirlerimizin ekonomik tatile gitmelerini sağlayan bir sistemdir. Erken rezervasyonunuzu ne kadar erken dönemde yaparsanız alacağınız indirim oranı o derece fazla olmaktadır.</p>
    <h5>Erken Rezervasyon Şartları</h5>
    <p>Erken rezervasyon indiriminden yararlanmak için 15 Şubat 2013 tarihine kadar kesin rezervasyonunuzu yaptırmanız gerekmektedir.</p>
    <h5>Erken Rezervasyon İptal Şartları</h5>
    <p>Erken rezervasyon sigortanız varsa tatiliniz, belirtilen giriş gününden 72 saate önceye kadar sigorta kapsamına alındığından, herhangi bir nedenle rezervasyonunuzu koşulsuz olarak iptal edebilirsiniz.<br/>
Erken rezervasyon sigortanız yoksa rezervasyonunuz iptal edildiğinde ücret iadesi yapılmamaktadır.</p>
    <h5>Erken Rezervasyon Sigortası</h5>
    <p>Erken rezervasyon sigortası misafirlerimizin tatilevine giriş yapacakları günden 72 saat öncesine kadar mazeretsiz olarak rezervasyonlarını iptal etme ve ödemiş oldukları ücretin konaklamaya dair olan kısmını tamamen geri alma imkanı sunan bir hizmettir.</p>
    <p>Erken rezervasyon sigortası sadece konaklama bedelini kapsamakta olup tatilevim.com hizmet bedelinin geri ödenmesini sağlamaz.<br/>
Sigorta bedeli konaklama tutarına göre belirlenir ve aşağıdaki tabloda yer almaktadır.</p>
</div> 