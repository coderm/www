<?php
    $uniqFormKey = uniqid();
    
    $isMainImage = false;
    if(isset($image))
    {
	$imageName = $image['name'];
	$imagePath = $image['path'];
	$imageLabel = $image['label'];
	$isMainImage = $image['isMain'];
    }
?>
<div class="item">
    <?php  echo $this->BSForm->input('Uploads.'.$uniqFormKey.'.name',array('type'=>'hidden','value'=>$imageName));?>
    <?php  echo $this->BSForm->input('Uploads.'.$uniqFormKey.'.path',array('type'=>'hidden','value'=>$imagePath));?>
    <?php  echo $this->BSForm->input('Uploads.'.$uniqFormKey.'.isMain',array('type'=>'hidden','value'=>0,'class'=>'isMainImage'));?>
    <img src="/<?php echo $imagePath;?>"/>

    
    
    <a class="close" href="#">Kaldır <i class="icon-remove-circle"></i></a>
        <?php
	if(!$isMainImage)
	    echo '<span class="mainImage">Ana resim olarak işaretle <i class="icon-flag"></i></span>';
	else
	    echo '<span class="mainImage">Ana resim <i class="icon-ok"></i></span>';
    ?>
    <div class="description">
	<?php 
	    if(isset($imageLabel) && $imageLabel!='')
		echo $this->BSForm->input('Uploads.'.$uniqFormKey.'.label',array('label'=>false,'value'=>$imageLabel,'bsSpan'=>4,'div'=>array('class'=>'pull-right')));
	    else
		echo $this->BSForm->input('Uploads.'.$uniqFormKey.'.label',array('label'=>false,'placeholder'=>'Bu resim ne ile ilgili ?','bsSpan'=>4,'div'=>array('class'=>'pull-right')));
	?>
    </div>
</div>