<?php
    //$this->set('title_for_layout', $preTitle.' | '.$title.' | '.ucwords(strtolower($zone.','.$county.' '.$city)));
    //$this->set('description_for_layout', $preTitle.'/'.ucwords($categoryName).' :'.$this->EaseText->excerpt(Sanitize::html($advertDescription, array('remove' => true)),'...',200));
    //echo $this->Html->addCrumb('Arama Sonuçları', array('controller'=>'searches','action'=>'index',$category));
    //echo $this->Html->addCrumb($title);



    $modelName = 'Advertisement';
    $status = $place[$modelName]['status'];
    $title = $place[$modelName]['title'];
    $description = $place[$modelName]['description'];
    $rate  = $place[$modelName]['rate'];
    $images = $place[$modelName]['picture'];
    $maxGuests = $place[$modelName]['max_guests'];
    $houseHolderUserId = $place[$modelName]['householder_s_id'];
    $standPrice = $place[$modelName]['standPrice'];
    $standCurrency = $place[$modelName]['standCurrency'];

    
    
    /*
     * map data
     */
    $mapData = $place[$modelName]['mapData'];
    $zoomLevel = $mapData['zoomLevel'];
    $latitude = $mapData['latitude'];
    $longitude = $mapData['longitude'];

    
    
    
    /*
     * conditions
     */
    $conditions = $place[$modelName]['conditions'];
    $cancellationPolicyType = $conditions['cancellationPolicyType'];
    
    
    
    /*
     * details
     */
    
    $details = $place[$modelName]['details'];
    $detailsInterriorFieldOptionsRoomCount = $details['Interrior']['FieldOptions']['roomCount'];
    $detailsInterriorFieldOptionsLivingRoomCount = $details['Interrior']['FieldOptions']['livingRoomCount'];
    
    $city = $place['Search']['city'];
    $county = $place['Search']['district'];
    $zone =  $place['Search']['subDistrict']; //bu kısmı bir düşün onur
    
    
    $currentUserId = CakeSession::read('User.Id');
    $isUserHouseHolderOfCurrentAdvert = ($houseHolderUserId==$currentUserId);
    
    
?>


<?php 
    if(!isset($bookingInputType))
	echo $this->ReservationForm->create($placeId,$guestCountAndPriceOptions); 
    else
    {
	echo $this->ReservationForm->createCompleteOfferButton($placeId); 
    }
    
?>



    <?php
    if($status == 'waiting_for_approval' || $status == 'passive')
    {
        echo '<div class="advertDetail">';
        switch($status)
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
		<h4><?php echo $title;?></h4>
		<?php
		$averageRate = $this->Number->precision($rate,1)
		?>
		<h2 style="color:#166A9A;position: absolute;right: 120px;bottom:1px;">
		    <span style="font-size:9px;">ilan no:</span><span style="font-size:14px;font-weight: bold;"><?php echo $placeId;?></span>
		</h2>
		<div style="width: 150px;position: absolute;right:0px;top:0px;text-align: right;">
		    <?php echo $this->GooglePlus->Button('http://www.tatilevim.com/'.$this->here);?>
		    <?php echo $this->PinIt->Button();?>
		    <?php echo $this->TwitterShare->shareButton($title.' '.$this->BitLy->link('http://www.tatilevim.com/'.$this->here,'json'));?>
		    <?php echo $this->FacebookShare->shareViaMetasButton();?>
		</div>
		<div style="width: 120px;position: absolute;right:0px;top:29px;text-align: right;">
		    <?php echo $this->Html->link('<span class="social favorite"></span>',array('controller'=>'favorites','action'=>'add',$placeId),array('escape'=>false));?>
		</div>
		<div style="position: absolute;left:0;bottom:2px"><?php echo $this->Element('/comments/rateForAdvert',array('label'=>$averageRate,'value'=>$averageRate));?></div>        

	</div>

	<?php if(isset($advertPermissions['lp_advert_update']) || $isUserHouseHolderOfCurrentAdvert): ?>
	<div class="blue rounded5">
	<?php 

		$operations     = '';
		if(isset($advertPermissions['lp_advert_update']) || $isUserHouseHolderOfCurrentAdvert)
		$operations.= $this->Html->link($this->Html->tag('button','Düzenle',array('class'=>'btn btn-mini btn-warning')),array('controller'=>'renterDashboards','action'=>'myPlaces/',$placeId,'advertBasics'),array('escape'=>false));
		if(isset($advertPermissions['lp_advert_set_top']))
		$operations.= $this->Html->link($this->Html->tag('button','Öne Çıkar',array('class'=>'btn btn-mini btn-warning')),array('action'=>'markAsFuturedAdvert/'.$placeId),array('escape' => false));              
		if(isset($advertPermissions['lp_advert_delete']) || $isUserHouseHolderOfCurrentAdvert)
		$operations.= $this->Html->link($this->Html->tag('button','Sil',array('class'=>'btn btn-mini btn-warning')),array('action'=>'delete/'.$placeId),array('escape' => false),'Bu ilan yayından kalkacak! \nSilmek istediğinize emin misiniz?');
		echo '<span class="pull-right">';
		echo $operations;
		echo '</span>';
		echo '<div class="clear"></div>';

	?>           
	</div>
	<?php endif;?>



		<?php
		    if(!is_array($images))
			$images = array($images);    

		    $imagePath = "/upload/advert_".$placeId."/";
		    echo $this->Element('/advertGallery/gallery',array('images'=>$images,'imagePath'=>$imagePath));

		?>

		<div class="advertGeneralInfoBox rounded5">
		    <span style="position:relative;float:left;background: url(/img/mapIcon.png) no-repeat 0 center;font-size:20px;font-weight: bold;padding-left:15px;"><?php echo $zone.', '.$county.' '.$city; ?></span>
		    <span style="position:relative;float:left;clear:both;font-size:16px;font-weight: normal;font-style:italic;margin-top:4px;"><?php echo $detailsInterriorFieldOptionsRoomCount;?> oda <?php echo $detailsInterriorFieldOptionsLivingRoomCount;?> salon tatil evi</span>
		    <div style="width:100px;height:51px;padding-right:26px;position:absolute;right:13px;background: url(/img/personIcon.png) no-repeat right center;text-align: right;">
			<span style="font-size:30px;font-weight: bold;font-style: italic;"><?php echo $maxGuests;?></span>x</br>
			<span>kişilik</span>
		    </div>
		</div>
		<div style="position: relative;float:left;width:100%;margin-bottom:20px;">
			<div class="htmlContent">
			    <h4><?php echo $standPrice.' '.$standCurrency ?>'dan başlayan fiyatlarla</h4>
			    <b>Önemli Not:</b> Fiyatlar tatilevim.com'da belirtildigi gibidir, hiç bir şekilde <b>komisyon talep edilmez!</b>
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
				$baseAdvertId = $placeId;

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
			if(is_array($placeLogs))
			{
			    echo '<div class="blue rounded5">İşlem geçmişi</div>';
			    echo '<table>';
			    foreach($placeLogs as $placeLog)
			    {
				echo '<tr>';
				echo '<td>'.$placeLog['vw_adverts_log']['date'].'</td>';
				echo '<td>'.$placeLog['vw_adverts_log']['action'].'</td>';
				echo '<td>'.$placeLog['vw_adverts_log']['user'].'</td>';			    
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
			    <?php echo $description;?>
			</div>
		</div>
		<div style="clear:both;position: relative;float:left;width:100%;">&nbsp;</div>    

		<div class="blue rounded5">Ev Özellikleri</div>
		<div class="well">
		<?php
			    foreach($placeDetailProperties as $n=>$s)
			    {
				
				$propertiesString = '';
				foreach($s as $property)
				{

				    $p = explode('.',$property);
				    $arrayTestString = '$testResult = $place["'.implode('"]["',$p).'"];';
				    eval ($arrayTestString);
				    
				    if($testResult)
				    {
					$label = str_replace('Advertisement.details.', '', $property);
					$label = explode('.',$label);
					$label = implode('_',$label);
					$label = $label.'_label';
					$propertiesString.= $this->Html->tag('span',__($label),array('class'=>'listElement'));
				    }

				}
				if($propertiesString!='')
				{
				    echo $this->Html->tag('h6',__($n.'_headline'));
			    
				    echo '<div>';
				    echo $propertiesString;
				    echo '</div>';   
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


		echo '<div style="margin-bottom:10px;padding:0px;">';
		echo '<div id="map" style="height:400px;width:700px;border:1px solid #44BBED;"></div>';
		echo '</div>';            
		?>
		</div>
		<div style="position: relative;float:left;width:100%;margin-bottom:5px;">
			<div class="blue rounded5">İptal politikası:</div>
			Bu ilan üzerinden yapılan rezervasyonlar için <b><?php echo '"'.__('cancelation_type_'.$cancellationPolicyType).'"';?></b> uygulanmaktadır.<br/>
			İptal politikaları hakkında detaylı bilgi için <?php echo $this->Html->link('tıklayın',array('controller'=>'pages', 'action' => 'display','cancellationPolicy'), array('escape' => false)); ?>

		</div>          
		<div style="clear:both;position: relative;float:left;width:100%;">&nbsp;</div>


		<div class="blue rounded5">Tatil Evi Uygunluk Takvimi</div>            
		<?php echo $this->element('schedule',array('days'=>$scheduleDays));?>
    

		<?php echo $this->Element('/comments/comments');?>


		<div class="blue rounded5">Benzer İlanlar</div>  
		<?php
		foreach($similarPlaces as $place)
		{
		    //echo $this->element('list_item',array('advert'=>$place,'maxTitleLength'=>100,'maxDescriptionLength'=>140,'operations'=>null));
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
                        $("#galleryMainImage").attr("src","/upload/advert_'.$placeId.'/"+$(event.target).attr("imageName"));
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
            
	    
		$this->Js->Buffer('
		    
			   var mapOptions = {};
			   mapOptions.zoomLevel = '.$zoomLevel.';
			   mapOptions.latitude = '.$latitude.';
			   mapOptions.longitude = '.$longitude.';
			   $().googleMapHelper(mapOptions);                 
		       '
		       );		
            
            
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


