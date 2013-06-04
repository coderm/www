<!-- File: /app/View/Advertisements/select_category.ctp -->
<?php
    echo $this->Html->addCrumb('İlan Ekle', '/advertisements/selectCategory');
    echo $this->Html->addCrumb('Kategori Seçimi');
?>

<div style="width:700px;float:left;min-height: 400px;" class="formContainer rounded10">
<?php 
    if($parentCategoryId==0)
        echo $this->element('headline',array('label'=>'Adım 1: Evinizin Kiralama Tipini Belirtin'));   
    else
        echo $this->element('headline',array('label'=>'Adım 2: Evinizin Hangi Kategoride?'));        
?>
<h3>İlan Kategorisi</h3>

<?php
        if($parentCategoryId==0)
          echo '<p><b>İlanınızı yayınlamadan önce lütfen okuyunuz!</b></p><p>Evinizi sadece <b>yaz sezonu</b> için kiraya vermek istiyorsanız, ilanlarınızı <b>"Yazlık Ev"</b> butonunu kullanarak yayınlayabilirsiniz.</p><p>Evinizi yıl boyunca <b>günlük olarak</b> kiraya vermek istiyorsanız <b>"Günlük ev"</b> butonunu kullanarak ilanınızı oluşturabilirsiniz. <b>Kış tatiline uygun</b> evleriniz için yine bu butonu kullanarak ilan yayınlayabilirsiniz.</p>';
        else
          echo '<p>İlanınızın hangi kategori başlığı altında yer alacağını seçin</p>';            
?>
<div style='position: relative;clear:both;'>&nbsp;</div>
<?php
echo "<center>";
    foreach($categories as $category)
    {
        $message_text_id = $category['message_text_id'];
        $advert_class_id = $category['advert_class_id'];

        $imageName = split('_', $message_text_id);
        $imageName = $imageName[2];
        $button = '<span class="categoryButton rounded10">';
        $button.= '<h2>'.__($message_text_id).'</h2>';
        $button.= $this->Html->image('/img/buttons/category/'.$imageName.'.png');
        $button.= '</span>';

        if($parentCategoryId!=0)
            echo $this->Html->link($button, array('controller'=>'advertisements', 'action' => 'add',$advert_class_id), array('escape' => false,'style'=>'margin-right:12px;position:relative;float:left;'));
        else
            echo $this->Html->link($button, array('controller'=>'advertisements', 'action' => 'selectCategory',$advert_class_id), array('escape' => false,'style'=>'margin-right:12px;position:relative;float:left;'));
    }
echo "</center>";
?>


</div>


