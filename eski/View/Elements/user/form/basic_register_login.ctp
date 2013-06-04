<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    if(isset($this->request->data['User']['formType']) && $this->request->data['User']['formType']=='login')
    {
	$registerDivStyle = $registerLinkStyle  = 'display:none';
	$loginDivStyle = $loginLinkStyle  = '';
	$formTypeValue = $this->request->data['User']['formType'];
    } else
    {
	$registerDivStyle =  $registerLinkStyle = '';
	$loginDivStyle =  $loginLinkStyle = 'display:none';
	$formTypeValue = 'register';
    }
    

    

?>
<div style="position: relative">
    <h3><?php echo __('user_register_login_headline');?></h3>
    <span class="login-link" style="<?php echo $registerLinkStyle;?>"><?php echo __('user_already_a_member_text');?><br/><a><?php echo __('user_login_text');?></a> <i class="icon-user"></i></span>
    <span class="register-link" style="<?php echo $loginLinkStyle;?>"><?php echo __('user_not_member_yet_text');?> <br/><a><?php echo __('user_register_now_text');?></a> <i class="icon-user"></i></span>
    <br/>
   <?php echo __('user_facebook_login_text');?>
    <br/>
    <?php echo $this->Html->link(' ',$loginUrl,array('class'=>'facebookConnectButton'));?>
    <br/>

    <?php
	echo $this->BSForm->input('User.formType',array('type'=>'Hidden','value'=>$formTypeValue,'div'=>false,'label'=>false,'class'=>'user-form-type'));
    ?>
    <div class="register" style="<?php echo $registerDivStyle;?>">
    <h4><?php echo __('user_about_you_headline');?></h4>
	<div class="row">
	    <?php
		$showTCIdInput = (isset($showTCIdInput))?$showTCIdInput:false;
		echo $this->Element('/user/form/register',array('showTCIdInput'=>$showTCIdInput));
	    ?>
	</div>
    </div>
    <div class="login" style="<?php echo $loginDivStyle;?>">
    <h4><?php echo __('user_login_headline');?></h4>
	<div class="row">
	<?php
	    echo $this->BSForm->input('User.uname',array('label'=>__('user_login_input_user_name_label'),'bsSpan'=>2));
	    echo $this->BSForm->input('User.password',array('label'=>__('user_login_input_user_password'),'bsSpan'=>2));
	?>
	</div>
    </div>    
</div>

<?php
    $this->Js->Buffer('
	    $(document).basicRegisterLogin();
    ');
?>