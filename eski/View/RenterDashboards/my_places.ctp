<?php
    echo $this->Element('/renterDashboard/common/tabs');
    
    echo '<div class="well white">';
    echo '<div class="row">';
    echo $this->Element('/renterDashboard/myplaces/breadcrumb');
    echo $this->Element('/renterDashboard/myplaces/common/left_menu');
    
    echo '<div class="span8 pull-right">';
    if(isset($saveUpdateButtonLabel)):
	echo $this->BSForm->create('Advertisement',array('class'=>'form-vertical','type'=>'file','class'=>'addEditPlaceForm'));
	echo $this->BSForm->hidden('advertId',array('value'=>$placeId));
	echo $this->Element('/renterDashboard/myplaces/'.$action);
	echo '<div style="width:100%;clear:both;float:left;"></div>';
	echo $this->BSForm->submit(__($saveUpdateButtonLabel),array('class'=>'btn btn-primary quick-advert-submit pull-right'));
	echo '<div class="alert alert-error submit-error" style="display:none;margin-top:10px;"><i class="icon icon-warning-sign"></i> <span></span></div>';
	
	
	echo $this->BSForm->end();
    else:
	echo $this->Element('/renterDashboard/myplaces/'.$action);
    endif;
    echo '</div>';
    echo '</div>';
    echo '</div>';
?>
<?php
    return;
    $this->Js->Buffer('
	    $(".addEditPlaceForm").addEditPlace();
    ');
?>