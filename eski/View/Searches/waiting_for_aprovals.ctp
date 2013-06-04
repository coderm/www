<?php $this->set('title_for_layout', 'Onay Bekleyen Evler');?>
<div id='advertList' style="width: 100%;">
<div style="background:#ececec;padding:4px;height: 28px;line-height: 11px;margin-bottom:10px;" class="rounded5">
    <?php
    echo $this->Html->link($this->Html->image('buttons/arrowIcon.png', array('alt'=> 'www.tatilevim.com', 'border' => '0', 'style'=>'margin-bottom:2px;')).'İlan Ekle'
                                    ,
                                    '/advertisements/selectCategory/',
                                    array('target' => '_self', 'escape' => false,'class'=>'button green3 rounded5','style'=>'float:left;'));  

    ?>
</div>    
    <span style="position: relative;clear:both;width:100%;display:block;height: 0;">&nbsp;</span>    
    
<?php
    foreach($adverts as $advert)
    {
        $advertId = $advert['Search']['advert_id'];
        $operations = '';
        $advertStatus = $advert['Search']['advert_status'];
        
        if(isset($advertPermissions['lp_advert_status_update']))
        {
            if($advertStatus=='active')
                $operations.= ' '.$this->Html->link('[yayından kaldır]',array('controller'=>'advertisements', 'action'=>'updateStatus/'.$advertId.'/passive'));
            if($advertStatus=='passive' || $advertStatus=='waiting_for_approval')
                $operations.= ' '.$this->Html->link('[yayınla]',array('controller'=>'advertisements', 'action'=>'updateStatus/'.$advertId));
            
        }
        if(isset($advertPermissions['lp_advert_update']))
           $operations.= ' '.$this->Html->link('[düzenle]',array('controller'=>'advertisements', 'action'=>'edit/'.$advertId));
        if(isset($advertPermissions['lp_advert_set_top']))
           $operations.= ' '.$this->Html->link('[ön plana çıkar]',array('controller'=>'advertisements', 'action'=>'markAsFuturedAdvert/'.$advertId));        
        if(isset($advertPermissions['lp_advert_delete']))
           $operations.= ' '.$this->Html->link('[sil]',array('controller'=>'advertisements', 'action'=>'delete/'.$advertId),array(),'Bu ilan yayından kalkacak! \nSilmek istediğinize emin misiniz?');
        
        if(isset($bookingPermissions['lp_booking_show_in_admin_menu']))
            $operations.= ' '.$this->Html->link('[Rezervasyonlar]',array('controller'=>'bookings', 'action'=>'index/advertId:'.$advertId));

        if(isset($advertPermissions))
            echo $this->element('list_item',array('advert'=>$advert,'maxTitleLength'=>100,'maxDescriptionLength'=>170,'operations'=>$operations));
        
                   
    }
?>

</div>


