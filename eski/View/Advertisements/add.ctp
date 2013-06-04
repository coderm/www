<div class="pagebanner clear">
    <h2><?php echo __('add_a_place_main_headline');?></h2>
    <p><?php echo __('add_a_place_main_description');?></p>
</div>
<div class="row">
    <div class="span7 well lightblue">
	<?php
	    echo $this->BSForm->create('Advertisement',array('class'=>'form-vertical','type'=>'file','class'=>'addEditPlaceForm'));
	    echo $this->element('/advert/form/basic_advert');
	    echo $this->element('/advert/form/contact');
	    echo $this->element('/advert/form/photos');
	    
	    if(!CakeSession::read('User.LoggedIn'))
		echo $this->element('/user/form/basic_register_login');
	    
	    echo $this->BSForm->submit(__('add_a_place_submit_button_title'),array('class'=>'btn btn-primary btn-large disabled quick-advert-submit'));
	    echo '<div class="alert alert-error submit-error" style="display:none;margin-top:10px;"><i class="icon icon-warning-sign"></i> <span></span></div>';
	    echo $this->BSForm->end();
	?>
    </div>
    <div class="span4 well lightblue">
	<?php
	    echo $this->element('/advert/module/any_questions');
	    echo $this->element('/advert/module/why_list_your_place');
	?>    
    </div>
</div>

<?php
    $this->Js->Buffer('
	    $(".addEditPlaceForm").addEditPlace();
    ');
?>