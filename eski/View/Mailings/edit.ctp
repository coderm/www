<!-- app/View/Mailing/add.ctp -->
<div class="formContainer rounded10">
<?php echo $this->Form->create('Mailing');?>
    <h3>
    <?php echo __('Mailing Düzenle'); ?>
    </h3>
    <?php
        echo $this->Form->input('mailing_name');
        echo $this->Form->input('description');
        echo $this->Form->input('campaign_path');
    ?>

<?php echo $this->Form->end(__('Submit'));?>
</div>