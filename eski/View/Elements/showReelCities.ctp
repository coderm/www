<div style="position:relative;margin:0;padding:0">
<div style="background: url('/img/transparent/white90.png');border:1px solid #ffffff;height:63px;margin:0;padding:10px;z-index: 150000;">
<div style='font-size:22px;margin-bottom:3px;font-weight: bold;'><?php echo __('headline_show_reel_cities');?></div>
<?php echo __('headline_sub_show_reel_cities');?><br/>
<p style='font-size: 11px;margin:7px 0;padding:0;'>
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


        echo '<ul style="margin:0;font-size:12px;line-height:18px;">';
        foreach($cities as $city)
        {
            $linkOptions = array();
            $linkOptions['controller'] = 'searches';
            $linkOptions['action'] = 'index';
            $linkOptions[] = $city['rootCategory'];
            $linkOptions[] = $city['city'];
            $linkOptions[] = $city['county'];
            $linkOptions[] = $city['zone'];
            echo '<li style="display:inline;margin:0;margin-right:11px;width:auto;">';
            echo $this->Html->link($city['label'],$linkOptions, array('escape' => false,'style'=>''));
            echo '</li>';
        }
        echo '<ul>';
    ?>
</p>
</div>
</div>    