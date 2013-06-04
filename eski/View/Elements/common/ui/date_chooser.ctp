<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $monthNow = date('F');
    $yearNow =  date('Y');
    $now = __($monthNow) . ' ' .$yearNow;
?>

<div style="text-align:center;" class="month-year-date-chooser" id="<?php echo $id; ?>">
<button class="btn prev"><i class="icon icon-chevron-left"></i>.</button>
<div class="btn-group">
  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
    <?php echo $now;?>
    <span class="caret"></span>
  </a>
  <ul class="dropdown-menu">
    <?php
	for($i=0;$i<20;$i++):
	    $next  = mktime(0, 0, 0, date("m")+$i,   date("d"),   date("Y"));
	    $a = $this->Html->tag('a',__(date('F',$next)). ' ' . __(date('Y',$next)), array('index'=>$i));
	    echo $this->Html->tag('li',$a);
	endfor;
    ?>
  </ul>
</div>
  <button class="btn next">.<i class="icon icon-chevron-right"></i></button>
</div>
<?php
$this->Js->Buffer('
	$(".month-year-date-chooser").monthYearDateChooser();
	');
?>


