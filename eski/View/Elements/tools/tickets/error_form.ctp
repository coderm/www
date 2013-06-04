<?php
    echo $this->BSForm->create('Ticket');
    echo $this->BSForm->input('Description',array('label'=>'Açıklama'));
    echo $this->BSForm->newRow();
    echo $this->BSForm->submit('ok');
    echo $this->BSForm->end();
?>
