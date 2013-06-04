<?php
    $maxTitleLength = (isset($maxTitleLength))?$maxTitleLength:100;
    $maxDescriptionLength = (isset($maxDescriptionLength))?$maxDescriptionLength:120;
    
    $root = $advert['Advertisement'];
    
    
    $id = $root['advert_id'];
    $title = $this->EaseText->excerpt($root['title'],10,$maxTitleLength);
    $description = $this->EaseText->excerpt($root['description'],10,$maxDescriptionLength);
    $demant = $root['demand'];
    $standPrice = $root['standPrice'];
    $advertStatus = isset($root['advert_status'])?$root['advert_status']:'active';
    $urlOptions = $root['urlOptions'];
    $locationLabel = '<i class="icon-map-marker alpha60"></i> '.$root['locationLabel'];
    
    $locationUrlOptions = $root['locationUrlOptions'];
    $isPartner = (isset($root['is_partner']))?($root['is_partner']>0):0;
    
    $totalPrivateRooms = isset($root['private_room_count'])?$root['private_room_count']:0;
    $totalSharedRooms = isset($root['shared_room_count'])?$root['shared_room_count']:0;
    $maxGuests = $root['maxGuests'];    
    

    $pictures = array_values($root['picture']);

    $imageName = $pictures[0]['name'];
    $imagePath = '/upload/advert_'.$id.'/thumb_'.$imageName;
    
    $rate = $root['rate'];
    
    $currencySymboll = $root['standCurrency']; 
    $prefix = $postfix = '';
    $postfix = '<span style="font-size:12px;padding-left:3px;">'.$currencySymboll.'</span>';    


?>
<div class="search-list-item">
<?php
	echo '<div class="image">';
	if(isset($imageName))
	{
	    $img =  $this->Html->image($imagePath, array('alt'=> $imageName, 'class'=>'rounded'));
	    echo $this->Html->link($img,$urlOptions,array('escape' => false));
	}
	echo '</div>';
	echo '<div class="content">';
	$title = $this->Html->tag('h5',$title);
	echo $this->Html->link($title,$urlOptions,array('escape'=>false));
	echo $this->Html->tag('p',$description);
	echo $this->Html->link($locationLabel,$locationUrlOptions,array('escape' => false,'style'=>'font-weight:normal;','class'=>'location'));
	echo '</div>';
	echo '<div class="price">';
	echo $prefix.'<strong>'.$standPrice.'</strong>'.$postfix.'<br/>Gece';
	echo '</div>';
	echo '<div class="button">';
	echo $this->Html->link('<button class="btn btn-warning">Hemen gözat</button>',$urlOptions,array('escape'=>false));
	echo '</div>';	
	echo '<div class="rate">';
	echo $this->Element('/comments/rateForAdvert',array('label'=>'','value'=>$rate));
	echo '</div>';

	if(isset($operations))
	    echo $this->Html->tag('div',$operations,array('class'=>'operations'));
?>
</div>
<?php
    
?>