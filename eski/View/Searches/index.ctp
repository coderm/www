<?php
    switch($category)
    {
        case 'lac-all':
            $preTitle = 'Günlük Kiralıklar';
        break;
        case 'lac-summer':
            $preTitle = 'Günlük Kiralık Yazlıklar';
        break;
        case 'lac-city':
            $preTitle = 'Günlük Kiralık Evler';
        break;
	default:
	    $preTitle = 'Evlerim';
	break;
    }
    if(isset($location))
        $this->set('title_for_layout',$preTitle.' | '.ucwords(strtolower($location)));
    else
        $this->set('title_for_layout', $preTitle);
    
    if(isset($crumbString))
        $this->Html->addCrumb($crumbString, $crumbController);
?>
<div class="clear row">
<?php
    $this->Html->addCrumb('Arama Sonuçları', '');        
?>
    <div class="span3">
	<?php echo $this->SearchForm->createDetailedModule($details);?>
    </div>
    
    <div class ="span9">   
	<div class="well well-small">
	<strong>Arama sonuçları</strong> 
	<?php
	if(count($adverts)>0)
	    echo $this->Html->tag('span',$this->Paginator->sort('price','Fiyat'),array('class'=>'pull-right'));
	?>
	</div>	
	<?php
	if(count($adverts)==0)
	{
	    echo '<center>';
	    echo '<div style="padding:40px;">';
	    echo $this->Html->image('notFoundIcon.png', array('alt'=> 'sonuç bulunamadı', 'border' => '0'));
	    echo '<br/><br/><span style="font-size:18px">Belirtmiş olduğunuz kriterlerde sonuç bulunamadı</span>';
	    echo '</div>';
	    echo '</center>';
	}	
	?>
	
<?php
    foreach($adverts as $advert)
    {
        $advertId = $advert['Search']['advert_id'];
        $operations = '';
        $advertStatus = $advert['Search']['advert_status'];
        if(isset($advertPermissions))
            echo $this->element('list_item',array('advert'=>$advert,'maxTitleLength'=>100,'maxDescriptionLength'=>170,'operations'=>$operations));
    }
?>
<?php
    if(count($adverts)!=0)
    {
        echo $this->element('paginator',array('escape'=>false)); 
    }
?>
    </div>
</div>


