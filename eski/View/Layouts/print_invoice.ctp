<?php
$cakeDescription = __d('cake_dev', 'tatilevim.com');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title></title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('invoice_print'), 'stylesheet', array('media' => 'print'));
                
                
	?>
</head>
<body>
        <div id="js-debug">
        </div>
	<div id="container">
		<div id="header">
		</div>
		<div id="content">
			<?php echo $content_for_layout; ?>
		</div>
	</div>
</body>
</html>