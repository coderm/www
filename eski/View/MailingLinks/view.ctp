<!-- app/View/Mailing/index.ctp -->
<?php echo $this->Html->link('Tüm Mailingler', array('controller' => 'mailings','action'=>'index')); ?>
<h3>Mailing Detayları</h3>
<table>
    <tr>
        <td>Id:</td>
        <td><?php echo $mailing['Mailing']['id'] ?></td>
    </tr>    
    <tr>
        <td>Id Metni:</td>
        <td><?php echo $mailing['Mailing']['idStr'] ?></td>
    </tr>       
    <tr>
        <td>Adı:</td>
        <td><?php echo $mailing['Mailing']['mailing_name'] ?></td>
    </tr>
    <tr>
        <td>Açıklaması:</td>
        <td><?php echo $mailing['Mailing']['description'] ?></td>
    </tr>
    <tr>
        <td>Resimli Gösterim Sayısı:</td>
        <td><?php echo $mailing['Mailing']['image_view_count'] ?></td>
    </tr>   
    <tr>
        <td>Oluşturulma</td>
        <td><?php echo $mailing['Mailing']['created'] ?></td>
    </tr>       
    <tr>
        <td>Son Düzenleme</td>
        <td><?php echo $mailing['Mailing']['modified'] ?></td>
    </tr>  
    <tr>
        <td>İşlem</td>
        <td>
            <?php echo $this->Html->link('Sil', array('controller' => 'mailings', 'action' => 'delete', $mailing['Mailing']['idStr']),array('confirm' => 'Bu mailingi silmek istediğinizden emin misiniz?')); ?>
        </td>
    </tr>      
</table>
