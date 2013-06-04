<?php

    $id = $advert['advert_id'];
    
    
    if(is_array($advert['picture']))
    {
	$pictures = array_values($advert['picture']);

	$imageName = $pictures[0]['name'];
	$imagePath = '/upload/advert_'.$id.'/'.$imageName;
    } else
    {
	$imagePath = '';
    }
    
    $title = $this->EaseText->excerpt($advert['title'],10,100);
    $description = $this->EaseText->excerpt($advert['description'],10,100);
    

    
    
?>
<div class="span4 list-item">
    <div class="list-item-details-container">
	<span class="location"><?php echo $this->Html->link($advert['locationLabel'],$advert['urlOptions'],array('escape' => false,'style'=>'font-weight:normal;'));?></span>
	<?php echo $this->Html->image($imagePath,array('width'=>300));?>
	<div style="position: relative;height: 50px;">
	<h6><?php echo $title;?></h6>
	    <span class="price">
		<strong><?php echo $advert['standPrice'];?></strong> <?php echo $advert['standCurrency'];?><br/>
		Gece
	    </span>
	</div>
	<div class="details">
	    <?php echo $this->Element('/comments/rateForAdvert',array('label'=>'','value'=>5));?>
	    <p><?php echo $description;?></p>
	    <?php echo $this->Html->link($advert['locationLabel'],$advert['urlOptions'],array('escape' => false,'style'=>'font-weight:normal;'));?>
	    <div class="button-container">
    	    <?php echo $this->Html->link('<button class="btn btn-warning">Hemen gözat</button>',$advert['urlOptions'],array('escape'=>false));?>
	    </div>
	</div>
    </div>
</div>
<?php
    //pr($advert);
?>
