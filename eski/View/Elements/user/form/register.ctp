	<?php
	    echo $this->BSForm->input('User.name',array('label'=>__('user_register_name_input_title'),'bsSpan'=>3));
	    echo $this->BSForm->input('User.sname',array('label'=>__('user_register_sname_input_title'),'bsSpan'=>3));
	    echo $this->BSForm->newRow();
	    echo $this->BSForm->input('User.email',array('label'=>__('user_register_email_input_title'),'bsSpan'=>3));
	    echo $this->BSForm->newRow();
	    echo $this->BSForm->input('User.phoneCountryCode',array('bsSpan'=>1,'label'=>__('user_register_phone_country_code_input_title'),'style'=>'text-align:right;','placeholder'=>'+90'));
	    echo $this->BSForm->input('User.phoneNumber',array('bsSpan'=>2,'label'=>__('user_register_phone_number_input_title'),'type'=>'text')); 
	    echo $this->BSForm->newRow();
	    echo $this->BSForm->input('User.passwordNew',array('label'=>__('user_register_password_input_title'),'bsSpan'=>3,'type'=>'password'));
	    echo $this->BSForm->input('User.passwordCheck',array('label'=>__('user_register_password_re_input_title'),'bsSpan'=>3,'type'=>'password'));
	    echo $this->BSForm->newRow();
	    echo $this->BSForm->input('User.check',array('type'=>'checkbox','label'=>__('user_register_accept_user_agreement')));
	?>
<div class="clear"></div>