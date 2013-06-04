<!-- File: /app/View/Users/login.ctp -->
<img src="/img/myAccount.png"/>
<div style="width:300px;float:right;" class="formContainer rounded10">
    <h4 style="font-size:12px;"><b>TatilEvim hesabınızla giriş yapın</b></h4>    
<?php

echo $this->Form->create('User');
echo $this->Form->input('uname',array('label'=>'Kullanıcı Adı'));
echo $this->Form->input('pass',array('label'=>'Şifre','type'=>'password'));
echo '<h5 style="vertical-align:bottom;border-bottom:1px solid white;height:48px;margin-bottom:10px;">';
echo $this->Html->link('Kullanıcı adımı / şifremi unuttum',array('controller'=>'users', 'action' => 'userLoginHelp'),array('style'=>'margin-top:18px;display:inline-block;'));
echo $this->Form->submit('',array('div'=>false,'class'=>'loginButton','style'=>'float:right;'));
echo '</h5>';

echo '<h4 style="font-size:12px;"><b>Facebook hesabınızla giriş yapın</b></h4>';
echo '<h5 style="vertical-align:bottom;border-bottom:1px solid white;height:60px;margin-bottom:10px;">';
echo '<center>';
echo $this->Html->link(' ',$loginUrl,array('class'=>'facebookConnectButton'));
echo '</center>';
echo '</h5>';
?>


<center>
    <?php echo $this->Html->link('Hemen üye olmak için tıklayın',array('controller'=>'users', 'action' => 'register'), array('escape' => false)); ?>
</center>   
<hr/>
</div>

    