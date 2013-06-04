<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    
if(count($selectSubDistrictOptions)>1)
{
    $subDistrictSelectDivStyle = '';
    $subDistrictTextDivStyle = 'display:none';
} else
{
    $subDistrictSelectDivStyle = 'display:none';
    $subDistrictTextDivStyle = '';
}
    
?>
<h3><?php echo __('place_contact_headline');?></h3>
<div class="row locationSelector">
<?php
    

    echo $this->BSForm->input('Advertisement.address',array('label'=>__('place_contact_address')));
    echo $this->BSForm->input('Advertisement.country',array('label'=>__('place_contact_country'),'bsSpan'=>2,'options'=>$selectCountryOptions,'class'=>'country feed-source location-input','location-type'=>'country','feed-target'=>'city'));
    echo $this->BSForm->input('Advertisement.city',array('label'=>__('place_contact_city'),'bsSpan'=>2,'options'=>$selectCityOptions,'class'=>'city feed-source location-input','location-type'=>'city','feed-target'=>'district'));
    echo $this->BSForm->newRow();
    echo $this->BSForm->input('Advertisement.district',array('label'=>__('place_contact_district'),'bsSpan'=>2,'options'=>$selectDistrictOptions,'class'=>'district feed-source location-input','location-type'=>'district','feed-target'=>'sub-district'));
    echo $this->BSForm->input('Advertisement.subDistrict',array('label'=>__('place_contact_subdistrict'),'bsSpan'=>2,'div'=>array('style'=>$subDistrictSelectDivStyle),'options'=>$selectSubDistrictOptions,'class'=>'sub-district feed-source location-input','location-type'=>'sub-district','feed-target'=>''));
    echo $this->BSForm->input('Advertisement.subDistrictText',array('label'=>__('place_contact_subdistrict'),'bsSpan'=>2,'div'=>array('style'=>$subDistrictTextDivStyle),'class'=>'sub-district feed-source location-input','location-type'=>'sub-district','feed-target'=>''));
    echo $this->BSForm->input('Advertisement.postCode',array('bsSpan'=>2,'label'=>__('post_code')));
    echo $this->Element('/advert/form/items/map_input');

?>
</div>   
<div class="clear"></div>

<?php
    $this->Js->Buffer('
	    $(".locationSelector").locationSelector();
	');

?>




