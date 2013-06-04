<?php $this->set('title_for_layout', 'Kullanıcı adı / Şifre hatırlatma'); ?>
<div class="clear row">
    <h4 class="headline shadow">Kullanıcı adı / Şifre hatırlatma</h4>
</div>

	    <div class="span4">
		<div class="well">
		<?php    
		    echo $this->BSForm->create('User');
		    $options=array('forgotUserName'=>'Kullanıcı adımı unuttum','forgotPassword'=>'Şifremi unuttum');
		    $attributes=array('legend'=>false);


		    echo $this->BSForm->radio('helpType',$options,$attributes);
		    echo $this->BSForm->input('email',array('label'=>'E-Posta adresiniz','bsSpan'=>3));
		    echo $this->BSForm->newRow();
		    echo $this->BSForm->end(array('label'=>'Gönder','class'=>'btn btn-primary pull-right'));
		?>    
		</div>		    
	    </div>
