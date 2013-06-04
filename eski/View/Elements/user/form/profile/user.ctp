<?php
    echo $this->BSForm->hidden('Form.type',array('value'=>'user'));
    echo $this->BSForm->input('User.name',array('label'=>__('user_register_name_input_label'),'bsSpan'=>3));
    echo $this->BSForm->input('User.sname',array('label'=>__('user_register_sname_input_label'),'bsSpan'=>3));
    echo $this->BSForm->newRow();
    echo $this->BSForm->input('User.email',array('label'=>__('user_register_email_input_label'),'bsSpan'=>3));
    echo $this->BSForm->newRow();
    echo $this->BSForm->input('User.phoneCountryCode',array('bsSpan'=>1,'label'=>__('user_register_phone_country_code_input_label'),'style'=>'text-align:right;','placeholder'=>'+90'));
    echo $this->BSForm->input('User.phoneNumber',array('bsSpan'=>2,'label'=>__('user_register_phone_number_input_label'),'type'=>'text'));
    echo $this->BSForm->input('User.tcId',array('label'=>__('user_register_tc_id_input_label'),'bsSpan'=>3));
    echo $this->BSForm->newRow();
    
    echo $this->BSForm->input('User.dateOfBirth', 
		array(
		    'type'  => 'date',
		    'label' => 'Doğum Tarihi',
		    'minYear' => 1900,
		    'maxYear' => 2010,
		    'dateFormat'=>'DMY',
		    'empty' => true
		    )
		);
    
    $options = Array('1'=>__('user_register_genre_male'),'2'=>__('user_register_genre_female'));
    $attributes = Array('legend'=>false);

    echo $this->BSForm->newRow();
    echo '<div class="span4">';
    echo '<label>Cinsiyet</label>';
    echo $this->BSForm->radio('gender_id',$options,$attributes);
    echo '</div>';
    //echo $this->BSForm->input('gender', array('type'=>'radio','legend'=>false,'before'=>'<label>Cinsiyet</label><br/>', 'options'=>array('1' => 'Erkek', '2' => 'Bayan')));


    
    //echo $this->Form->input('pass1',array('label'=>'Şifre','type'=>'PASSWORD'));
    //echo $this->Form->input('pass2',array('label'=>'Şifre (tekrar)','type'=>'PASSWORD'));
    //echo $this->BSForm->input('User.passwordNew',array('label'=>'Şifre','bsSpan'=>3,'type'=>'password'));
    //echo $this->BSForm->input('User.passwordCheck',array('label'=>'Şifre (tekrar)','bsSpan'=>3,'type'=>'password'));

    