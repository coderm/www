<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div style="width:940px;float:left;min-height:400px;" class="formContainer grayContainer rounded10">
    <center style="margin-top:50px;">
        <?php echo $this->Html->image('successIcon.png'); ?>
        <h2>İlanınız Başarıyla Eklendi</h2>
        İlanınız tatilevim.com tarafından incelendikten sonra yayınlanmaya başlayacaktır.<br/>  
        Bu ilanla ilgili tüm işlemlerinizi rahatca yapabilmek için aşağıda belirtilen kodu ("ilan no") kullanabilirsiniz.
        <div class="rounded5" style="background-color:#fff; width:200px;margin:15px;padding:15px;">
            İlan referans no:<br/><br/>
            <h2>#<?php echo $advertId;?></h2>
        </div>
        <?php 
        echo $this->Html->link('İlanınızı Görüntüleyin',
                                $advertUrlOptions,
                                array('target' => '_self', 'escape' => false,'class'=>'button rounded5','style'=>'margin-left:15px;margin-right:0px;')
                                );        
        ?>
    </center>
</div>