<!-- app/View/Mailing/add.ctp -->
<div class="formContainer rounded10">
<?php echo $this->Form->create('MailingLink');?>
    <h3>
    <?php echo __('Yeni Mailing Linki Oluştur'); ?>
    </h3>
    <?php
        echo $this->Form->input('link_name');
        echo $this->Form->input('description');
        echo $this->Form->input('path');
        echo $this->Form->input('action',array('options'=>$actionList));
        echo $this->Form->input('mailing_id',array('options'=>$mailingList));
    ?>

<?php echo $this->Form->end(__('Submit'));?>
</div>