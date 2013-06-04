<!-- File: /app/View/Users/change_password.ctp -->
<div style="width:610px;float:left;" class="formContainer rounded10">
    <h2>Şifre Yenileme</h2>
<?php    
    echo $this->Form->create('User');
    echo $this->Form->input('pass1',array('label'=>'Yeni Şifreniz','type'=>'PASSWORD'));
    echo $this->Form->input('pass2',array('label'=>'Yeni Şifreniz (tekrar)','type'=>'PASSWORD'));
    echo '<center>';
    echo $this->Form->end('Gönder');
    echo '</center>';
?>    
</div>    
