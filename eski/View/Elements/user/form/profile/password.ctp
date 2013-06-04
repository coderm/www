    <?php
	    echo $this->BSForm->hidden('Form.type',array('value'=>'password'));
	    echo $this->BSForm->input('passwordNew', array('label'=>'Yeni Şifre', 'type'=>'password' ,'bsSpan'=>3));
	    echo $this->BSForm->newRow();
	    echo $this->BSForm->input('passwordCheck', array('label'=>'Yeni Şifre (tekrar)', 'type'=>'password' , 'bsSpan'=>3));
    ?>
