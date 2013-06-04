<div class="row">
    <h4 class="headline shadow clear">Rezervasyon İşlemi</h4>
</div>
<?php
   
    
?>

<div class="row">
    <div class="span3"><?php echo $this->Html->image('rezervasyon.jpg');?></div>
    <div class="span9">
	<div class="accordion" id="booking-accordion">
	<?php
	    $i = 0;
	    foreach($accordionElements as $index=>$accordionElement):
		$viewStateClass = ($currentLevelId==$accordionElement['id'])?'in':'';
	?>
	  <div class="accordion-group">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#booking-accordion" href="#<?php echo $accordionElement['id']?>">
		<?php echo ($i+1);?> <strong><?php echo $accordionElement['label'];?></strong>
	      </a>
	    </div>
	    <div id="<?php echo $accordionElement['label']?>" class="accordion-body collapse <?php echo $viewStateClass?>">
	      <div class="accordion-inner">
		<?php
		    echo $this->BSForm->create('Booking');
		    $elementOptions = (isset($accordionElement['elementOptions']))?$accordionElement['elementOptions']:array();
		    echo $this->element($accordionElement['element'],$elementOptions);
		    echo $this->BSForm->hidden('Booking.formType',array('value'=>$accordionElement['id']));
		    echo $this->BSForm->hidden('Booking.paymentResult');
		    
		    if($currentLevelId != 'accordion-booking-payment-credit-card' && $currentLevelId != 'accordion-booking-payment-eft-atm-transfer')
			echo $this->BSForm->submit('Devam',array('class'=>'btn btn-primary btn-large quick-advert-submit pull-right'));
		    
		    echo $this->BSForm->end();
		?>	
		  <div class="clear"></div>
	      </div>
	    </div>
	  </div>
	<?php
	    $i++;
	    endforeach;
	?>
	</div>
    </div>
</div>    

