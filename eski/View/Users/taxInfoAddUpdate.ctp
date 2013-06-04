<!-- File: /app/View/Users/activate.ctp -->
<div style="width:610px;float:left;" class="formContainer rounded10">
    <h2>Siz de tatilevim.com üyesi olun!</h2>    
<p>Hem evinizi, yazlığınızı kiralamak, hem de geniş tatil evleri portföyünün tüm avantajlarından faydalanmak için 1 dakikanızı ayırmanız yeterli.</p>
<?php
echo $this->Form->create('User');
echo $this->Form->input('uname',array('label'=>'Kullanıcı Adı'));
echo $this->Form->input('email1',array('label'=>'E Posta'));
echo $this->Form->input('email2',array('label'=>'E Posta (tekrar)'));
echo $this->Form->input('phoneNumber',array('label'=>'Telefon (örn: 532 555 55 55)','class'=>'phone'));
echo $this->Form->input('name',array('label'=>'Ad'));
echo $this->Form->input('sname',array('label'=>'Soyad'));
echo $this->Form->input('pass1',array('label'=>'Şifre','type'=>'PASSWORD'));
echo $this->Form->input('pass2',array('label'=>'Şifre (tekrar)','type'=>'PASSWORD'));

echo $this->Form->input('dateOfBirth', 
        array(
            'type'  => 'date',
            'label' => 'Doğum Tarihi',
            'minYear' => 1900,
            'maxYear' => 2010,
            'dateFormat'=>'MDY'
            )
        );

echo $this->Form->input('gender', array('type'=>'radio','legend'=>false,'before'=>'<label>Cinsiyet</label><br/>', 'options'=>array('1' => 'Erkek', '2' => 'Bayan')));


    if(isset($userPermissions['lp_user_update']))
    {
        echo '<label>Kullanıcının dahil olacağı gruplar:</label>';
        foreach(array_keys($userGroups) as $key)
        {
            echo "<div class='text checkbox'>";
                $elementId = 'User.group.'.$userGroups[$key];
                echo $this->Form->checkbox($elementId, array('label'=>$userGroups[$key]));
                echo '<label for="'.$elementId.'">'.__($userGroups[$key]).'</label>';
            
            echo "</div>";
        }
        
        echo '<br/>';
        echo '<label>Kullanıcı durumu</label>';
        echo "<div class='input text radio'>";            
            echo $this->Form->radio('status', array('1' => 'Aktif', '0' => 'Pasif'), array('legend' => false));
        echo "</div>";
    } else
    {
        echo $this->Form->input('acceptAgreement', array('type'=>'checkbox','label'=>'<a target="_blank" style="font-weight:normal;text-decoration: underline;color#166A9A;" href="/uyelik-sozlesmesi">Üyelik sözleşmesini</a> okudum, kabul ediyorum.'));
    }
    
    
echo "<center>";
echo $this->Form->end('Kaydet');
echo "</center>";
?>
</div>
<div style="width:300px;float:right;" class="formContainer bgGray">
<h4 style="font-size:16px;"><b>tatilevim.com</b>'a zaten üyeyim!</h4>
    Eğer daha önce üye olduysanız 'Giriş Yap' butonuna tıklayarak işlemlerinize devam edebilirsiniz.
    <br/><br/>
    <center>
         <?php echo $this->Html->link('Giriş Yap',array('controller'=>'users', 'action' => 'login'), array('escape' => false,'class'=>'button green rounded5')); ?>
    </center>   
</div>    
