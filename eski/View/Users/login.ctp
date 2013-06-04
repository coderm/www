<div class="row clear">
	<div class="span8">
	    <img src="/img/myAccount.png"/>
	</div>
	<div class="span4">
	    <div class="well lightblue">
		<h5>Giriş yap <i class="icon-user alpha60 pull-right"></i></h5>    
		<?php
		echo $this->Form->create('User');
		echo $this->Form->input('uname',array('label'=>'Kullanıcı Adı / e-posta adresi','class'=>'input-block-level'));
		echo $this->Form->input('pass',array('label'=>'Şifre','type'=>'password','class'=>'input-block-level'));
		echo $this->Form->end(array('class'=>'btn btn-success btn-large btn-block pull-right','label'=>'Giriş Yap'));
		echo '<div class="clear"></div>';
		echo '<br/>';
		echo $this->Html->link('<i class="icon-question-sign alpha60"></i> Kullanıcı adımı / şifremi unuttum',array('controller'=>'users', 'action' => 'userLoginHelp'),array('escape'=>false));
		echo '<br/>';
		echo $this->Html->link('<i class="icon-hand-right alpha60"></i> Hemen üye olmak için tıklayın',array('controller'=>'users', 'action' => 'registerNew'), array('escape' => false));
		echo '<hr/>';
		
		echo '<h5>Facebook hesabınla bağlan</h5> ';
		echo '<center>';
		echo $this->Html->link(' ',$loginUrl,array('class'=>'facebookConnectButton'));
		echo '</center>';
		?>
	    </div>
	</div>
	<div class="clear"></div>
</div>

    