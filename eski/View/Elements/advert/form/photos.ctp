<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h3><?php echo __('place_photos_headline');?></h3>
<div class="advertImageUploader">
    <?php echo $this->BSForm->input('image_upload',array('type'=>'file','style'=>'display:none;','div'=>false,'label'=>false));?>

 
    
    <iframe id="upload_frame" name="upload_frame" frameborder="0" border="0" src="" scrolling="No" scrollbar="no" > </iframe>
    <button class="btn btn-warning" type="button"><i class="icon-picture icon-white"></i> <?php echo __('place_photos_add_photo_button_label');?></button>
    <div class="uploadProgress" style="display:none;">
	<?php echo __('place_photos_photo_uploading_message');?>
	<div class="progress progress-striped active">
	  <div class="bar" style="width: 100%;"></div>
	</div>    
    </div>      
    <div class="imagesContainer">
	<?php
	    if(!isset($this->request->data['Uploads']) && isset($this->request->data['Advertisement']['picture']))
		$this->request->data['Uploads'] = $this->request->data['Advertisement']['picture'];

	    if(isset($this->request->data['Uploads']))
	    {
		foreach($this->request->data['Uploads'] as $image)
		    echo $this->element('/advert/form/photo_upload_item',array('image'=>$image));
	    }


	    
	?>
    </div>
     
</div>
<br/><br/>
<div class="alert alert-info">
    <h5><i class="icon-hand-right"></i> <?php echo __('place_photos_tips_headline');?></h5>
    <?php echo __('place_photos_tips_content');?>
</div>
<div class="clear"></div>

<?php

    $this->Js->Buffer('
	    $(".advertImageUploader").advertImageUploader();
	    
	    function uploadResult(result, html)
	    {
		$(".advertImageUploader").advertImageUploader("imageUploadResultHandler",html);
	    };
	    
	    $(".imagesContainer").sortable();
	');
?>
