<?php $this->set('title_for_layout', 'Günlük Kiralık Yazlıklar'); ?>
<?php $this->set('description_for_layout', "Tüm Türkiye'den günlük kiralık yazlık, günlük kiralık ev ve günlük kiralık daireler sunar."); ?>
<?php $this->set('showBreadCrumb',false); ?>

<div id="show_reel">
    <div id="mainBannerContainer"><?php echo $this->element('mainBannersLarge');?></div>
    <div id="showReelCitiesContainer"><?php echo $this->element('showReelCities');?></div>          
    <div id="searchFormContainer"><?php echo $this->SearchForm->createModuleForm(230); ?></div>   
    <div class="clear"></div>
</div>

<div>
    <?php echo $this->Element('pages/home/advert_list',array('adverts'=>$homePageAdverts,'label'=>'<i class="icon icon-heart icon-h4 alpha60"></i> '.__('headline_home_popular_places'),'modelName'=>'vw_get_adverts')) ;?>
    <?php echo $this->Element('pages/home/advert_list',array('adverts'=>$lastActiveReservedAdverts,'label'=>'<i class="icon icon-bell icon-h4 alpha60"></i> '.__('headline_home_last_booked_places'),'modelName'=>'vw_last_booking_adverts')) ;?>
</div>
