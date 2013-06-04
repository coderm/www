<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'tatilevim.com');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    
    
	<?php echo $this->Html->charset(); ?>
	<title></title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('default_v3_02');
	?>
</head>
<body>
        <div id="js-debug">
        </div>
	<div id="container">
		<div id="header">
                    <?php echo $this->Html->link(
                    $this->Html->image('logo.png', array('alt'=> 'www.tatilevim.com', 'border' => '0','style'=>'margin-top:30px;')),
                    '/',
                    array('target' => '_self', 'escape' => false)
                    );
                    ?>
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>
		</div>
	</div>
</body>
</html>