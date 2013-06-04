<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="row clear">
    <h4 class="headline shadow">Kampanyalar</h4>
</div>

<ul style="clear:both;">
    <?php
	$link = $this->Html->link('2013 Erken Rezervasyon Kampanyası',array('controller'=>'offers','action'=>'view',2));
	echo '<li>'.$link.'</li>';
	
	$link = $this->Html->link('Haydi TatilEvine! 5% İndirim Kampanyası',array('controller'=>'offers','action'=>'view',1));
	echo '<li>'.$link.'</li>';
    ?>
</ul>
