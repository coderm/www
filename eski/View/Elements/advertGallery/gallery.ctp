<div id="advertGallery">
    <div class="mainImageContainer">
        <img src="<?php echo  $imagePath;?>" style="height:389px;"/><br/>
    </div>
    <div class="thumbs">
        <div class="control up"></div>
        <div class="thumbsMask">
            <div class="thumbsContainer">
            <div class="indicator"></div>
            <?php 
                foreach($images as $image)
                    echo $this->element('/advertGallery/thumb',array('imageName'=>$image['name'],'advertId'=>$placeId));
            ?>
            </div>
        </div>
        <div class="control down"></div>
    </div>
    
    <div style="position: relative;width:100%;clear:both;height:0;">&nbsp;</div>
</div>


<?php 
    $this->Js->Buffer('
                        var ifp = "'.$imagePath.'";
                        $(document).ready(function(){$("#advertGallery").advertGallery({imageFolderPath:ifp})});
                    '); 
?>