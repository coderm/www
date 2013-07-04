<div class="fleft">
                <?php
            echo $this->Html->image('musteri-hizmetleri1.jpg', array('alt' => 'Müşteri Hizmetleri'));
            ?>
                <div class="populer-sehirler radius">
                    <div class="baslik">En Popüler Şehirler</div>
<?php
        //root kategori 'lac-all'->tümü 'lac-summer'->yazlıklar 'lac-city'->günlükler   
    
        $cities[] = array('rootCategory'=>'lac-all','label'=>'İstanbul','city'=>'istanbul','county'=>'','zone'=>'');
        $cities[] = array('rootCategory'=>'lac-all','label'=>'Ankara','city'=>'ankara','county'=>'','zone'=>'');
        $cities[] = array('rootCategory'=>'lac-all','label'=>'Bursa','city'=>'bursa','county'=>'','zone'=>'');
        $cities[] = array('rootCategory'=>'lac-all','label'=>'İzmir','city'=>'izmir','county'=>'','zone'=>'');
        $cities[] = array('rootCategory'=>'lac-all','label'=>'Bodrum','city'=>'mugla','county'=>'bodrum','zone'=>'');
        $cities[] = array('rootCategory'=>'lac-all','label'=>'Marmaris','city'=>'mugla','county'=>'marmaris','zone'=>'');
        $cities[] = array('rootCategory'=>'lac-all','label'=>'Antalya','city'=>'antalya','county'=>'','zone'=>'');
        $cities[] = array('rootCategory'=>'lac-all','label'=>'Didim','city'=>'aydin','county'=>'didim','zone'=>'');
        $cities[] = array('rootCategory'=>'lac-all','label'=>'Fethiye','city'=>'mugla','county'=>'fethiye','zone'=>'');
        $cities[] = array('rootCategory'=>'lac-all','label'=>'Kuşadası','city'=>'aydin','county'=>'kusadasi','zone'=>'');


        echo '<ul>';
        foreach($cities as $city)
        {
            $linkOptions = array();
            $linkOptions['controller'] = 'searches';
            $linkOptions['action'] = 'index';
            $linkOptions[] = $city['rootCategory'];
            $linkOptions[] = $city['city'];
            $linkOptions[] = $city['county'];
            $linkOptions[] = $city['zone'];
            echo '<li>';
            echo $this->Html->link($city['label'],$linkOptions, array('escape' => false,'style'=>''));
            echo '</li>';
        }
        echo '<ul>';
    ?>
                
                </div>
            </div>
            <div class="clear"></div>
