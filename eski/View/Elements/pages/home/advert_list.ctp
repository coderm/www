<div class="clear row">
    <?php
	if($label)
	    echo '<h4 class="headline shadow">'.$label.'</h4>';
	
    ?>
    
<?php
    foreach($adverts as $advert)
    {
	echo $this->Element('list_item_bs',array('advert'=>$advert['Advertisement']));
    }
?>
</div>