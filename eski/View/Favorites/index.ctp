<div class="row">
<h4 class="headline">Favori Evlerim</h4>
<?php

    foreach($favoryAdverts as $favoryAdvert)
    {
	$placeId = $favoryAdvert['Advertisement']['advert_id'];
	$operations = $this->Html->link(__('favorite_list_item_operation_remove'),array('controller'=>'favorites','action'=>'delete',$placeId),array('class'=>'btn btn-success btn-small'));
	$operations = $this->Html->tag('p',$operations);
	echo $this->element('list_item',array('advert'=>$favoryAdvert,'maxTitleLength'=>100,'maxDescriptionLength'=>170,'operations'=>$operations));
    }
?>
</div>