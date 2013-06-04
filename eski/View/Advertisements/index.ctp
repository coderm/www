<?php
    echo $this->Html->addCrumb('İlanlar', '');
?>

<div id='advertList'>
<?php
    foreach($adverts as $advert)
    {
        echo $this->element('list_item',array('advert'=>$advert,'maxTitleLength'=>100,'maxDescriptionLength'=>1000));
    }
?>
</div>