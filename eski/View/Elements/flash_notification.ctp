<?php
    
    if(!isset($type))
	$type = '';
    
    $cssClass;
    $iconClass;
    
    switch($type)
    {
	case 'success':
	    $cssClass = 'alert alert-success';
	    $iconClass = 'icon icon-ok';
	    break;
	case 'error':
	    $cssClass = 'alert alert-error';
	    $iconClass = 'icon icon-warning-sign';	    
	    break;
	default:
	    $cssClass = 'alert alert-error';
	    $iconClass = 'icon icon-warning-sign';
	    break;
    }
?>
<div id="flashMessage" class="message clear <?php echo $cssClass;?>">
    <i class="<?php echo $iconClass; ?>"></i> <?php echo $message;?>
</div>