<?php $this->set('title_for_layout', 'Hesabım'); ?>
<?php
    if(isset($this->request->data['Form']['activeTabId']))
	$activeTabId = $this->request->data['Form']['activeTabId'];
    else
	$activeTabId = '#tab1';
?>
<div class="clear row">
    <h4 class="headline shadow">Hesabım</h4>
</div>
<div class="profile">
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Bilgilerim</a></li>
    
    <?php if(array_search('dg_householder',$usersGroups)>=0): ?>
    <li><a href="#tab2" data-toggle="tab">Banka Hesabım</a></li>
    <?php endif;?>
    
    <?php if(array_search('dg_householder',$usersGroups)>=0): ?>
    <li><a href="#tab3" data-toggle="tab">Fatura Bilgileri</a></li>
    <?php endif;?>
    
    <li><a href="#tab4" data-toggle="tab">Şifre Değişikliği</a></li>
  </ul>
    
    
  <?php
    echo $this->BSForm->create('User');
    echo $this->BSForm->hidden('Form.activeTabId');
    echo $this->BSForm->input('currentPass',array('type'=>'password','div'=>array('style'=>'display:none;')));
  ?>
  <div class="tab-content">
    <div class="tab-pane active" id="tab1">
      <?php echo $this->Element('/user/form/profile/user');?>
    </div>
      
      
    <?php if(array_search('dg_householder',$usersGroups)>=0): ?>
    <div class="tab-pane" id="tab2">      
    <?php echo $this->Element('/user/form/profile/bank_account');?>
    </div>      
    <?php endif; ?>
      
      
    <?php if(array_search('dg_householder',$usersGroups)>=0): ?>
    <div class="tab-pane" id="tab3">      
    <?php echo $this->Element('/user/form/profile/invoice');?>
    </div>      
    <?php endif; ?>   
      
      
    <div class="tab-pane" id="tab4">
      <?php echo $this->Element('/user/form/profile/password');?>
    </div>      
  </div>
  <?php echo $this->BSForm->end(array('label'=>'Tamam','class'=>'btn btn-primary pull-right'));?>    
</div>    
</div> 

<!-- Modal -->
<div id="profile-tab-before-change" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Değişiklik Onayı</h3>
  </div>
  <div class="modal-body">
    <p>Yaptığınız değişiklikleri kaybolacak?</p>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary dont-save-changes">Kaydetmeden Devam Et</button>
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">İptal</button>
    
  </div>
</div>

<!-- Modal -->
<div id="profile-password-input" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Mevcut Şifreniz</h3>
  </div>
  <div class="modal-body">
    <p>Bilgilerinizin güvenliği için lütfen şifrenizi giriniz</p>
    <input class="input" type="password" placeholder="Mevcut Şifreniz"></input>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary dont-save-changes">Tamam</button>
  </div>
</div>



<?php

    $this->Js->Buffer('
    $(document).ready(function() {
	$(".profile").userProfile();
	
	    
	$("a[href=\"'.$activeTabId.'\"]").click();
    });
    ')
?>



<?php    
    


    return;

    echo '<h5>Kullanıcı Hesap Bilgileri</h5>';
    echo $this->Form->create('User');
    echo $this->Form->input('uname',array('label'=>'Kullanıcı Adı'));
    echo $this->Form->input('email1',array('label'=>'E Posta'));
    echo $this->Form->input('email2',array('label'=>'E Posta (tekrar)'));
    echo $this->Form->input('phoneNumber',array('label'=>'Telefon (örn: 532 555 55 55)','class'=>'phone'));
    echo $this->Form->input('name',array('label'=>'Ad'));
    echo $this->Form->input('sname',array('label'=>'Soyad'));
    echo $this->Form->input('tcId',array('label'=>'TC Kimlik No'));

    echo $this->Form->input('pass1',array('label'=>'Şifre','type'=>'PASSWORD'));
    echo $this->Form->input('pass2',array('label'=>'Şifre (tekrar)','type'=>'PASSWORD'));

    echo $this->Form->input('date_of_birth', 
            array(
                'type'  => 'date',
                'label' => 'Doğum Tarihi',
                'minYear' => 1900,
                'maxYear' => 2010,
                'dateFormat'=>'MDY',
                'empty' => true
                
                )
            );
    

    echo $this->Form->input('gender', array('type'=>'radio','legend'=>false,'before'=>'<label>Cinsiyet</label><br/>', 'options'=>array('1' => 'Erkek', '2' => 'Bayan')));

    
    
    if(array_search('dg_householder',$usersGroups)>=0 || array_search('dg_normal_user', $usersGroups)>=0):
        echo '<h5>Fatura Bilgileri</h5>';
        echo $this->Form->input('taxTitle',array('label'=>'Ünvan'));
        echo $this->Form->input('taxOffice',array('label'=>'Vergi Dairesi'));
        echo $this->Form->input('taxNo',array('label'=>'Vergi No'));
        echo $this->Form->input('taxAddress',array('label'=>'Fatura Adresi','type'=>'textArea'));
        echo $this->Form->input('taxUserType', array('type'=>'radio','legend'=>false,'before'=>'<label>Vergi Kişiliği</label><br/>', 'options'=>array('1' => 'Gerçek Kişi', '2' => 'Tüzel Kişi')));   
    endif;
    
    
    
    if(array_search('dg_householder',$usersGroups)>=0):
        echo '<h5>Banka Hesap Bilgileri</h5>';
        echo $this->Form->input('bankCity', array('options' => $cities, 'empty' => '-- Seçiniz --','label'=>'İl'), null);
        echo $this->Form->input('bankName',array('options' => $bankList, 'empty' => '-- Seçiniz --','label'=>'Banka Adı'), null);
        echo $this->Form->input('bankPayeeTitle',array('label'=>'Ünvan'));
        echo $this->Form->input('bankOfficeName',array('label'=>'Şube Adı'));
        echo $this->Form->input('bankOfficeCode',array('label'=>'Şube Kodu'));
        echo $this->Form->input('bankAccountNo',array('label'=>'Hesap No'));
        echo $this->Form->input('bankAccountIBAN',array('label'=>'IBAN No'));
    endif;
    echo '<div style="height:1px;background-color:white;margin-bottom:10px;"></div>';
    echo $this->Form->input('passwordConfirm',array('label'=>'Bilgilerinizin güvenliği için lütfen mevcut şifrenizi giriniz','type'=>'password'));
    echo '<center>';
    echo $this->Form->end('Kaydet');
    echo '</center>';
?>    
</div>    
