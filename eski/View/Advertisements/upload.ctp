<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset()."\n"; ?>
        <?php echo $this->Html->css('bootstrap.min')."\n";?>
        
</head>
<body style="background: none;">
    <script>
	parent.uploadResult(true,'<?php echo Sanitize::stripWhitespace($this->Element('/advert/form/photo_upload_item',array('imageName'=>$imageName,'imagePath'=>$imageThumbPath)));?>');
	
    </script>
</body>
</html>


