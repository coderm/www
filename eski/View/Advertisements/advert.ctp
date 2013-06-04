<!-- File: /app/View/Advertisements/advert.ctp -->
<?php
    switch($category)
    {
        case 'lac-summer':
            $preTitle = 'Günlük Kiralık Yazlık';
        break;
        case 'lac-city':
            $preTitle = 'Günlük Kiralık Ev';
        break;    
    }

    $this->set('title_for_layout', $preTitle.' | '.$advertTitle.' | '.ucwords(strtolower($zone.','.$county.' '.$city)));
    $this->set('description_for_layout', $preTitle.'/'.ucwords($categoryName).' :'.$this->EaseText->excerpt(Sanitize::html($advertDescription, array('remove' => true)),'...',200));
    
    
    echo $this->Html->addCrumb('Arama Sonuçları', array('controller'=>'searches','action'=>'index',$category));
    echo $this->Html->addCrumb($advertTitle);

    
    
?>


<?php 
    if(!isset($bookingInputType))
	echo $this->ReservationForm->create($advertId,$guestCountAndPriceOptions); 
    else
    {
	echo $this->ReservationForm->createCompleteOfferButton($advertId); 
    }
    
?>



    <?php
    if($advertStatus == 'waiting_for_approval' || $advertStatus == 'passive')
    {
        echo '<div class="advertDetail">';
        switch($advertStatus)
        {
            case 'waiting_for_approval':
                echo '<h2 style="padding:20px;background-color: #f8d735;text-align: center;clear:both;">İlanınız onay sürecindedir&nbsp;<img src="/img/sandClockIcon.png" style="vertical-align: top;"/></h2>';
                break;
            case 'passive':
                echo '<h2 style="padding:20px;background-color: #f8d735;text-align: center;clear:both;">İlanınız pasif durumdadır&nbsp;<img src="/img/sandClockIcon.png" style="vertical-align: top;"/></h2>';                
                break;
        }
        echo '</div>';
    }

    ?>    
            
<div class="row">    
    <div class="span advertDetail">
	<div style="height: 55px;position: relative;width: 100%;margin-top:7px;margin-bottom:10px;">
		<h4><?php echo $advertTitle;?></h4>
		<?php
		$averageRate = $comments['score'][0][0]['average'];
		$averageRate = $this->Number->precision($averageRate,1)
		?>
		<h2 style="color:#166A9A;position: absolute;right: 120px;bottom:1px;">
		    <span style="font-size:9px;">ilan no:</span><span style="font-size:14px;font-weight: bold;"><?php echo $advertId;?></span>
		</h2>
		<div style="width: 150px;position: absolute;right:0px;top:0px;text-align: right;">
		    <?php echo $this->GooglePlus->Button('http://www.tatilevim.com/'.$this->here);?>
		    <?php echo $this->PinIt->Button();?>
		    <?php echo $this->TwitterShare->shareButton($advertTitle.' '.$this->BitLy->link('http://www.tatilevim.com/'.$this->here,'json'));?>
		    <?php echo $this->FacebookShare->shareViaMetasButton();?>
		</div>
		<div style="width: 120px;position: absolute;right:0px;top:29px;text-align: right;">
		    <?php echo $this->Html->link('<span class="social favorite"></span>',array('controller'=>'favorites','action'=>'add',$advertId),array('escape'=>false));?>
		</div>
		<div style="position: absolute;left:0;bottom:2px"><?php echo $this->Element('/comments/rateForAdvert',array('label'=>$averageRate,'value'=>$averageRate));?></div>        

	</div>

	<?php if(isset($advertPermissions['lp_advert_update']) || $isUserHouseHolderOfCurrentAdvert): ?>
	<div class="blue rounded5">
	<?php 

		$advertId       = $advert['lcdt_title'][0]['advert_id'];
		$operations     = '';
		if(isset($advertPermissions['lp_advert_update']) || $isUserHouseHolderOfCurrentAdvert)
		$operations.= $this->Html->link($this->Html->tag('button','Düzenle',array('class'=>'btn btn-mini btn-warning')),array('action'=>'edit/'.$advertId),array('escape'=>false));
		if(isset($advertPermissions['lp_advert_set_top']))
		$operations.= $this->Html->link($this->Html->tag('button','Öne Çıkar',array('class'=>'btn btn-mini btn-warning')),array('action'=>'markAsFuturedAdvert/'.$advertId),array('escape' => false));              
		if(isset($advertPermissions['lp_advert_delete']) || $isUserHouseHolderOfCurrentAdvert)
		$operations.= $this->Html->link($this->Html->tag('button','Sil',array('class'=>'btn btn-mini btn-warning')),array('action'=>'delete/'.$advertId),array('escape' => false),'Bu ilan yayından kalkacak! \nSilmek istediğinize emin misiniz?');
		echo '<span class="pull-right">';
		echo $operations;
		echo '</span>';
		echo '<div class="clear"></div>';

	?>           
	</div>
	<?php endif;?>



		<?php
		    $images = $advertPictures;
		    if(!is_array($images))
			$images = array($images);    

		    $imagePath = "/upload/advert_".$advertId."/";

		    echo $this->Element('/advertGallery/gallery',array('images'=>$images,'imagePath'=>$imagePath));

		?>

		<div class="advertGeneralInfoBox rounded5">
		    <span style="position:relative;float:left;background: url(/img/mapIcon.png) no-repeat 0 center;font-size:20px;font-weight: bold;padding-left:15px;"><?php echo $zone.', '.$county.' '.$city; ?></span>
		    <span style="position:relative;float:left;clear:both;font-size:16px;font-weight: normal;font-style:italic;margin-top:4px;"><?php echo $privateRoomsCount;?> oda <?php echo $sharedRoomsCount;?> salon tatil evi</span>
		    <div style="width:100px;height:51px;padding-right:26px;position:absolute;right:13px;background: url(/img/personIcon.png) no-repeat right center;text-align: right;">
			<span style="font-size:30px;font-weight: bold;font-style: italic;"><?php echo $maxGuestsCount;?></span>x</br>
			<span>kişilik</span>
		    </div>
		</div>
		<?php
		    if(isset($advertPermissions['lp_advert_view_customer_agent_note']))
		    {
			echo '<div class="blue rounded5">Yönetici Notları</div>';
			echo '<div class="rounded10" style="background-color:#ececec;padding:15px 10px 10px;margin-bottom:5px;">';

			echo '<div id="adminNotes" style="padding:10px;"></div>';
			echo '<div id="adminNoteLoadingLayer" style="text-align:center;margin:15px;"><img src="/img/loading.gif"></img></div>';                    
			echo '<center><a href="javascript:return false;"  onclick="$(\'#addAdminNoteForm\').show();">Bu ilana not ekleyin</a></center>';
			if(isset($advertPermissions['lp_advert_add_customer_agent_note']))
			{
			    if(isset($advert['lcdt_base_advert'][0]['detail']))
				$baseAdvertId = $advert['lcdt_base_advert'][0]['detail'];
			    else
				$baseAdvertId = $advertId;

			    echo '<div id="addAdminNoteForm" class="rounded10" style="background-color:#D8F9FF;padding:20px 20px;position:relative;display:none;margin-top:-20px;">';
			    echo '<div class="closeButton"></div>';
			    echo $this->Form->create('AdminNote');
			    echo $this->Form->hidden('advertId',array('value'=>$baseAdvertId));
			    echo $this->Form->hidden('selectedNoteId',array('value'=>0));
			    echo $this->Form->input('note',array('label'=>'Bu ilanla ilgilli notunuzu girin:','div'=>array('style'=>'clear:none;float:left;position:relative;width:580px;margin:0;')));
			    echo $this->Form->end(array('label'=>'Ekle','id'=>'addAdminNote','div'=>array('style'=>'clear:none;float:left;position:relative;width:80px;margin:0;text-align:right;padding-top:14px;')));
			    echo '<div style="position:relative;clear:both;height:1px;">&nbsp;</div>';
			    echo '</div>';
			}     

			echo '</div>';
		    }


		    if(isset($advertPermissions['lp_advert_view_customer_agent_note'])) //bu perm özelleştirilecek
		    {
			echo '<div style="clear:both">';
			if(is_array($advertLogs))
			{
			    echo '<div class="blue rounded5">İşlem geçmişi</div>';
			    echo '<table>';
			    foreach($advertLogs as $advertLog)
			    {
				echo '<tr>';
				echo '<td>'.$advertLog['vw_adverts_log']['date'].'</td>';
				echo '<td>'.$advertLog['vw_adverts_log']['action'].'</td>';
				echo '<td>'.$advertLog['vw_adverts_log']['user'].'</td>';			    
				echo '</tr>';
			    }
			    echo '</table>';
			}
			echo '</div>';
		    }



		?>
		<div class="blue rounded5">Tatil Evi Hakkında <span class="showCommentsButton rounded2">Yorumlara Gözat<img src="/img/commentIcon.png" style="margin-left:4px;"/></span></div>            
		<div style="position: relative;float:left;width:100%;margin-bottom:20px;">
			<div class="htmlContent">
			    <table class="table table-bordered">
				<tr>
				    <?php 
					if(isset($advertPrice)){ echo $this->element('price',array('label'=>'Sezon dışı fiyatı','price'=>$advertPrice,'houseHolderPrice'=>$advertHouseHolderPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }
					if(isset($advertMayPrice)){ echo $this->element('price',array('label'=>'Mayıs fiyatı','price'=>$advertMayPrice,'houseHolderPrice'=>$advertHouseHolderMayPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }
					if(isset($advertJunePrice)){ echo $this->element('price',array('label'=>'Haziran fiyatı','price'=>$advertJunePrice,'houseHolderPrice'=>$advertHouseHolderJunePrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }
					if(isset($advertJulyPrice)){ echo $this->element('price',array('label'=>'Temmuz fiyatı','price'=>$advertJulyPrice,'houseHolderPrice'=>$advertHouseHolderJulyPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }
					if(isset($advertAugustPrice)){ echo $this->element('price',array('label'=>'Ağustos fiyatı','price'=>$advertAugustPrice,'houseHolderPrice'=>$advertHouseHolderAugustPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }
					if(isset($advertSeptemberPrice)){ echo $this->element('price',array('label'=>'Eylül fiyatı','price'=>$advertSeptemberPrice,'houseHolderPrice'=>$advertHouseHolderSeptemberPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }
					if(isset($advertOctoberPrice)){ echo $this->element('price',array('label'=>'Ekim fiyatı','price'=>$advertOctoberPrice,'houseHolderPrice'=>$advertHouseHolderOctoberPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }                                    
					if(isset($advertWeekdayPrice)){ echo $this->element('price',array('label'=>'Hafta içi fiyatı','price'=>$advertWeekdayPrice,'houseHolderPrice'=>$advertHouseHolderWeekdayPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }                                                                        
					if(isset($advertWeekendPrice)){ echo $this->element('price',array('label'=>'Hafta sonu fiyatı','price'=>$advertWeekendPrice,'houseHolderPrice'=>$advertHouseHolderWeekdayPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }                                                                                                            
				    ?>
				</tr>
			    </table>
			    <b>Önemli Not:</b> Fiyatlar tatilevim.com'da belirtildigi gibidir, hiç bir şekilde <b>komisyon talep edilmez!</b>
			</div>                    
		</div>    
		<div style="position: relative;float:left;width:100%;margin-bottom:20px;">
			<div>Açıklamalar</div>
			<div class="htmlContent">
			    <?php echo $advertDescription;?>
			</div>
		</div>
		<div style="clear:both;position: relative;float:left;width:100%;">&nbsp;</div>    

		<div class="blue rounded5">Ev Özellikleri</div>
		<div class="well">
		<?php
			   foreach($advert as $advertFeatures)
			    {
				if($advertFeatures[0]['form_element_type']=='checkbox')
				{
				    echo '<div><strong>'.__($advertFeatures[0]['detail_class_type']).'</strong></div>';
				    echo '<div	>';
				    foreach($advertFeatures as $advertFeature)
				    {
					if($advertFeature['detail']==1)
					    echo '<span class="listElement">'.__($advertFeature['detail_class']).'</span>';
				    }
				    echo '</div>';
				    echo '<hr style="margin:10px 0;"/>';
				}
			    }
		?>
		</div>

		<div class="blue rounded5">Tatil Evi Konumu</div>
		<div class="well well-small">
		<?php




		echo '<h4>';
		if($city!='')
		    echo $city;
		if($county!='')
		    echo ' / '.$county;
		if($zone!='')
		    echo ' / '.$zone;            
		echo '</h4>';

		if(isset($advert['lcdt_map'][0]['detail']))
		{
		    if($advert['lcdt_map'][0]['detail']!=null || $advert['lcdt_map'][0]['detail']!='')
		    {
			echo '<div style="margin-bottom:10px;padding:0px;">';
			echo '<div id="map" style="height:400px;width:700px;border:1px solid #44BBED;"></div>';
			echo '</div>';            
		    }
		}

		?>
		</div>
		<div style="position: relative;float:left;width:100%;margin-bottom:5px;">
			<div class="blue rounded5">Tatil Evi Günlük Fiyat Bilgileri</div>
			<div>
			    <table class="table table-bordered">
				<tr>
				    <?php 
					if(isset($advertPrice)){ echo $this->element('price',array('label'=>'Sezon dışı fiyatı','price'=>$advertPrice,'houseHolderPrice'=>$advertHouseHolderPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }
					if(isset($advertMayPrice)){ echo $this->element('price',array('label'=>'Mayıs fiyatı','price'=>$advertMayPrice,'houseHolderPrice'=>$advertHouseHolderMayPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }
					if(isset($advertJunePrice)){ echo $this->element('price',array('label'=>'Haziran fiyatı','price'=>$advertJunePrice,'houseHolderPrice'=>$advertHouseHolderJunePrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }
					if(isset($advertJulyPrice)){ echo $this->element('price',array('label'=>'Temmuz fiyatı','price'=>$advertJulyPrice,'houseHolderPrice'=>$advertHouseHolderJulyPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }
					if(isset($advertAugustPrice)){ echo $this->element('price',array('label'=>'Ağustos fiyatı','price'=>$advertAugustPrice,'houseHolderPrice'=>$advertHouseHolderAugustPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }
					if(isset($advertSeptemberPrice)){ echo $this->element('price',array('label'=>'Eylül fiyatı','price'=>$advertSeptemberPrice,'houseHolderPrice'=>$advertHouseHolderSeptemberPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }                                    
					if(isset($advertOctoberPrice)){ echo $this->element('price',array('label'=>'Ekim fiyatı','price'=>$advertOctoberPrice,'houseHolderPrice'=>$advertHouseHolderOctoberPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }  
					if(isset($advertWeekdayPrice)){ echo $this->element('price',array('label'=>'Hafta içi fiyatı','price'=>$advertWeekdayPrice,'houseHolderPrice'=>$advertHouseHolderWeekdayPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }                                                                        
					if(isset($advertWeekendPrice)){ echo $this->element('price',array('label'=>'Hafta sonu fiyatı','price'=>$advertWeekendPrice,'houseHolderPrice'=>$advertHouseHolderWeekdayPrice,'currencySymboll'=>$currencySymboll,'showNormPrice'=>($isPartner==1))); }                                                                                                                                                
				    ?>
				</tr>
			    </table>
			</div>
			<div class="blue rounded5">İptal politikası:</div>
			Bu ilan üzerinden yapılan rezervasyonlar için <b><?php echo __($cancelationTerm.'Politika');?></b> uygulanmaktadır.<br/>
			İptal politikaları hakkında detaylı bilgi için <?php echo $this->Html->link('tıklayın',array('controller'=>'pages', 'action' => 'display','cancellationPolicy'), array('escape' => false)); ?>

		</div>          
		<div style="clear:both;position: relative;float:left;width:100%;">&nbsp;</div>


		<div class="blue rounded5">Tatil Evi Uygunluk Takvimi</div>            
		<?php echo $this->element('schedule',array('bookingDays'=>$bookingDays));?>


		<?php echo $this->Element('/comments/comments');?>


		<div class="blue rounded5">Benzer İlanlar</div>  
		<?php
		foreach($similarAdverts as $similarAdvert)
		{
		    echo $this->element('list_item',array('advert'=>$similarAdvert,'maxTitleLength'=>100,'maxDescriptionLength'=>170,'operations'=>null));
		}
		?>
		<?php

		if(isset($houseHoldersSimilarAdverts))
		{
		    echo '<div class="blue rounded5">Ev Sahibi Bilgisi</div>';
		    echo '<table>';
			echo '<tr>';
			    echo '<th>Ad-Soyad</th>';
			    echo '<th>Telefon</th>';
			echo '</tr>';
			echo '<tr>';
			    echo '<td>'.$houseHolderDetails['userDetails']['name'].'</td>';
			    echo '<td>'.$houseHolderDetails['userDetails']['phone'].'</td>';
			echo '</tr>';
		    echo '</table>';            

		    echo '<div> class="blue rounded5">Aynı Ev Sahibine Ait Diğer Evler</div>';

		    foreach($houseHoldersSimilarAdverts as $houseHoldersSimilarAdvert)
		    {
			echo $this->element('list_item',array('advert'=>$houseHoldersSimilarAdvert,'maxTitleLength'=>100,'maxDescriptionLength'=>170,'operations'=>null));
		    }
		}

		?>
    </div>
</div><!--row end-->    
<div id="advertPhoneNumberNotifiation">
</div>

<?php
        
            $this->Js->buffer(
            '
                $(document).ready(function(){
                   
                    $(".advertGalleryThumb").click(function(event){
                        $("#galleryMainImage").attr("src","/upload/advert_'.$advertId.'/"+$(event.target).attr("imageName"));
                    });
                
                });
                

            ');      
            
            
                
            $this->Js->Buffer(
                                    "
                                        $('.showCommentsButton').click(function(){
                                                    $(window).scrollTop($('#commentsContainer').offset().top-50);
                                        });


                                    "


                    );            
            
            if($advert['lcdt_map'][0]['detail']!=null || $advert['lcdt_map'][0]['detail']!='')
            {
                $zoomLevel = $advert['lcdt_map'][0]['detailPrperties']['zoomLevel'];
                $latitude = $advert['lcdt_map'][0]['detailPrperties']['latitude'];
                $longitude = $advert['lcdt_map'][0]['detailPrperties']['longitude'];
		
		
		$this->Js->Buffer('
			   createMap('.$zoomLevel.','.$latitude.','.$longitude.',false);                 
		       '
		       );		
                
            }    
            
            
            if(isset($advertPermissions['lp_advert_add_customer_agent_note']))
            {
                $this->Js->get('#addAdminNote')->event('click', 
                                "sendAdminNote();"
                            );   
                $this->Js->buffer(
                '
                    function adminNotesStatus(val)
                    {
                        switch(val)
                        {
                            case "updating":
                                $("#adminNoteLoadingLayer").show();
                            break;
                            case "normal":
                                $("#adminNoteLoadingLayer").hide();
                            break;
                        }
                    }
                    function sendAdminNote()
                    {
                            adminNotesStatus(\'updating\');
                            '.
                                $this->Js->request(array(
                                'controller'=>'advertisements',
                                'action'=>'addAdminNote'
                                ), array(
                                'update'=>'#adminNotes',
                                'success'=>'adminNotesStatus(\'normal\');',
                                'async' => true,
                                'method' => 'post',
                                'dataExpression'=>true,
                                'data'=> $this->Js->serializeForm(array(
                                'isForm' => false,
                                'inline' => true
                                ))
                                ))
                    .'
                        $("#AdminNoteNote").val("");
                    }
                    
                    function deleteAdminNote(noteId)
                    {
                        adminNotesStatus(\'updating\');
                        $("#AdminNoteSelectedNoteId").val(noteId);
                    '.
                                $this->Js->request(array(
                                'controller'=>'advertisements',
                                'action'=>'deleteAdminNote'
                                ), array(
                                'update'=>'#adminNotes',
                                'success'=>'adminNotesStatus(\'normal\');',
                                'async' => true,
                                'method' => 'post',
                                'dataExpression'=>true,
                                'data'=>$this->Js->serializeForm(array(
                                'isForm' => false,
                                'inline' => true
                                ))
                                ))
                    .'
                    }

                        
                    $(document).ready(function() {
                        sendAdminNote();    
                    });
                    

                    
                    
                ');         
                

                            
            }
                    
?>


