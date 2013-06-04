<?php
    $elementId = $element['type'].strtolower($element['detail_class_id']);
    $options = array();
    if(isset($element['properties']['class']))
	$options['class'] = $element['properties']['class'];
    
    
    
     switch($element['type'])
     {
         case 'heading':
             echo '<h3>';
             echo __($element['message_text_id']);
             echo '</h3>';
             break;
         case 'text':
             echo $this->Form->input($elementId, array('label'=>$element['message_text_id']));
             break;
         case 'textarea':
             echo $this->Form->input($elementId,array('rows'=>'3','label'=>$element['message_text_id']));
             break;
         case 'richtext':
             echo $this->RichTextEditor->create($elementId,$element['message_text_id']);
             break;
         case 'checkbox':
             echo '<br/>';
             echo '<h3>';
             echo __($element['key']);
             echo '</h3>';
             foreach($element['items'] as $item)
             {
                 $elementId = $element['type'].strtolower($item['detail_class_id']);
                 echo "<div class='text checkbox'>";
                 echo $this->Form->checkbox($elementId, array('label'=>$element['key']));
                 echo '<label for="'.$elementId.'">'.__($item['message_text_id']).'</label>';
                 echo '</div>';
             }
             break;
         case 'radio':
             echo "<div class='text radio'>";
             echo "<label>".__($element['key'])."</label><br/>";
             echo $this->Form->input($elementId, array('options'=>$element['items'],'type'=>'radio','legend'=>false));
             echo '</div>';
             break;     
         case 'select':
             echo '<span>';
             if(isset($element['properties']['feeder']))
                $feeder = $element['properties']['feeder'];
             else
                $feeder = 0;
	     
	     $options['options'] = $element['items'];
	     $options['empty'] = '-- Seçiniz --';
	     $options['label'] = $element['message_text_id'];
	     $options['ajaxParent'] = $feeder;
	     
	     

             echo $this->Form->input($elementId, $options, null);

             //echo $this->Form->input($elementId, array('options' => $element['items'], 'empty' => '-- Seçiniz --','label'=>$element['message_text_id'],'ajaxParent'=>$feeder), null);
             echo '</span>';
             break;         
         case 'image':
             echo '<h3>İlan Resimleri</h3>';
             echo '<div id="imageUploader">';
             echo $this->Form->input('file', array(
			'type' => 'file',
                        'label' => 'Resim Seç',
		));
            echo '<div id="imageUploadingMessage" style="padding:10px;text-align:center;display:none;">';
            echo '<img src="/img/loading.gif"/><br/><br/>';
            echo '<b>İmaj yükleniyor...</b><br/>';
            echo 'Lütfen bekleyiniz';
            echo '</div>';             
             
             echo $this->Form->hidden('imagesDCI',array('value'=>$element['detail_class_id']));
             echo $this->Form->hidden('images');
             
                    echo '<ul id="imagesContainer">';                
                    if(isset($images))
                    {
                        foreach($images as $image)
                        {
                            $thumbPath =  $uploadDir.'/thumb_'.$image[0];
                            echo '<li>'.$this->element('upload_result',array("fileName"=>$image[0],"filePath"=>$thumbPath,"inlineElement"=>true)).'</li>';     
                        }
                    }
                    echo '</ul>';
                
                
                
             echo '</div>';
             break;
        case 'map':
             echo '<label>Konum</label>';
             echo '<div id="map" style="height:400px;width:98%;margin-left:1%;margin-right:1%;margin-bottom:20px;border:1px solid #44BBED;"></div>';
             echo $this->Form->hidden($elementId,array('id'=>'AdvertisementMap'));

	     
	     if(isset($advert))
	     {
		$zoomLevel = $advert['lcdt_map'][0]['detailPrperties']['zoomLevel'];
		$latitude = $advert['lcdt_map'][0]['detailPrperties']['latitude'];
		$longitude = $advert['lcdt_map'][0]['detailPrperties']['longitude'];

		$this->Js->Buffer('
			   createMap('.$zoomLevel.','.$latitude.','.$longitude.',true);                 
		       '
		       );
		
		
	     } else if(isset($this->data['Advertisement'][$elementId]))
	     {
		 pr("ok");
		 
		$mapProps = $this->Html->parseProperties($this->data['Advertisement'][$elementId]);
		 
		$zoomLevel = $mapProps['zoomLevel'];
		$latitude = $mapProps['latitude'];
		$longitude = $mapProps['longitude'];

		$this->Js->Buffer('
			   createMap('.$zoomLevel.','.$latitude.','.$longitude.',true);                 
		       '
		       );		 
	     } else
	     {
		$this->Js->Buffer('
			   createMap(5,39,35);                 
		       '
		       );		 
	     }
            break;         
        case 'hidden':
            break;
        default:
             echo 'form elementi bulunamadı';
             echo $element['type'];
             break;
     }
?>
