<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div style="width:940px;float:left;min-height:400px;" class="formContainer grayContainer rounded10">
    <center style="margin-top:50px;">
        <?php echo $this->Html->image('successIcon.png'); ?>
        <h2>Rezervasyonunuz Başarıyla Alındı.</h2>
        <br/>
        <p>Rezervasyonunuzla ilgili tüm işlemlerinizi rahatca yapabilmek için aşağıdaki kodu kullanabilirsiniz.</p>
        <div class="rounded5" style="background-color:#fff; width:200px;margin:15px;padding:15px;">
            Rezervasyon referans no:<br/><br/>
            <h2>#<?php echo $bookingId; ?></h2>
        </div>
    </center>
</div>


