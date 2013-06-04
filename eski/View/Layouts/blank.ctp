<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Ödemeler</title>
        <?php echo $this->Html->css('default_v2') . "\n"; ?> 
    </head>
    <body>
        <div style="padding:15px 15px 50px 15px">
        <?php echo $this->Session->flash(); ?>
        <?php echo $content_for_layout; ?> 
        </div>
    </body>
    <?php echo $this->Html->script(array('jquery')); ?>
    <?php echo $scripts_for_layout; ?>
    <?php if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer();?>
<?php echo $this->element('sql_dump'); ?>
	
</html>