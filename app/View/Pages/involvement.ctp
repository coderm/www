<?php $this->set('title_for_layout', 'Evini Kiraya Ver!'); ?>
<?php $this->set('description_for_layout', "Sizler de evinizi günlük kiralama sitemimize dahil ederek yüksek kazanç elde etmeye hemen başlayabilirsiniz."); ?>
<div class ="formContainer shadowGray gray rounded10">
    <?php echo $this->element('headline',array('label'=>'Evinizi Kiraya Verin'))   ?>
        <div style="padding:0 15px;">

            <p>Sizler de evinizi günlük kiralama sitemimize dahil ederek yüksek kazanç elde etmeye hemen başlayabilirsiniz. İlk aşama olarak  üyelik butonunu kullanarak sitemize üyelik başvurusu gerçekleştirin, ilanlarınızı yükleyin ve bırakın tatilevim.com sizin için çalışsın.</p>
            <h2>Tatilevim.com‘dan size özel hizmetler:</h2>
            <p>Tatilevim.com, size tam destek sağlar. Tatilevim.com sizin adınıza tüm rezervasyon sürecini profesyonelce yönetir ve süreçten sizi haberdar eder. Size özel yönetici hesabı ile yeni ilan ekleyebilir,  ilanlarınızı  güncelleyebilir,  rezervasyon bilgilerinize  anında ulaşabilirsiniz.</p>

            <div class="involementItem rounded10">
                <?php echo $this->Html->image('phoneIcon.png', array('alt'=> 'Çağrı Merkezi', 'border' => '0'));?>     
                <span>7/24 Çağrı merkezi hizmeti</span>
            </div>
            <div class="involementItem rounded10" style="float:right;">
                <?php echo $this->Html->image('assistanceIcon.png', array('alt'=> 'Çağrı Merkezi', 'border' => '0'));?>     
                <span>Misafirlerinize özel acil çözüm ve asistanlık hizmetleri</span>
            </div>
            <div class="involementItem rounded10">
                <?php echo $this->Html->image('reservationIcon.png', array('alt'=> 'Çağrı Merkezi', 'border' => '0'));?>     
                <span>Tam zamanlı ürün tanıtımı ve size özel rezervasyon yönetimi  hizmeti</span>
            </div>
            <div class="involementItem rounded10" style="float:right;">
                <?php echo $this->Html->image('grsIcon.png', array('alt'=> 'Çağrı Merkezi', 'border' => '0'));?>     
                <span>GRS (Güvenli Rezervasyon Sistemi) ile %100 güvenli  ve  risksiz ödeme alma</span>
            </div>
            <div class="involementItem rounded10">
                <?php echo $this->Html->image('paymentIcon.png', array('alt'=> 'Çağrı Merkezi', 'border' => '0'));?>     
                <span>Ödeme takip sistemi, tatilevim.com sizin için gerçekleşen rezervasyonlarla ilgili bütün ödeme süreçlerini yönetir.</span>
            </div>
            <div class="involementItem rounded10" style="float:right;">
                <?php echo $this->Html->image('calendarIcon.png', array('alt'=> 'Çağrı Merkezi', 'border' => '0'));?>     
                <span>Siz özel yönetim hesabı ile  internet üzerinden ilanlarınızı , rezervasyonları görüntüleyebilir ve yönetebilirsiniz.</span>
            </div>            
            <div class="involementItem rounded10">
                <?php echo $this->Html->image('advertIcon.png', array('alt'=> 'Çağrı Merkezi', 'border' => '0'));?>     
                <span>Tatilevim.com tatil evi  avantaj  kampanyalarına ücretsiz katılım</span>
            </div>   
            <span style="float:right;margin-top:54px;">
               
    <?php
            echo $this->Html->link(
                            'Üye Olun',
                            array('controller'=>'users', 'action' => 'register'),
                            array('target' => '_self', 'escape' => false,'class'=>'button yellow2 rounded5','style'=>'margin-left:15px;margin-right:0px;')
                    );
            echo $this->Html->link(
                            'Giriş Yapın',
                            array('controller'=>'users', 'action' => 'login'),
                            array('target' => '_self', 'escape' => false,'class'=>'button yellow2 rounded5','style'=>'margin-left:15px;margin-right:0px;')
                    ); 
    ?>    
            </span>
            <div style="width: 100%;clear:both;"/>
        </div>
</div>