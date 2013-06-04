<!-- File: /app/View/Users/userLoginHelp.ctp -->
<div style="width:610px;float:left;" class="formContainer rounded10">
    <h2>e-posta adresinizi doğrulayın!</h2>
    <h6 style ='text-align: center;' class='rounded5'><?php echo $userMail;?></h6><br/>
    <p>Belirtmiş olduğunuz e-posta adresinize onay kodu gönderilmiştir, lütfen onay kodunu aşağıdaki alana giriniz.</p>
<?php    
    echo $this->Form->create('User');
    echo $this->Form->hidden('mail',array('value'=>$userMail));
    echo $this->Form->input('activationCode',array('label'=>'Onay Kodu'));
    echo '<center>';
    echo $this->Form->end('Gönder');
    echo '</center>';
?>    
</div>    
