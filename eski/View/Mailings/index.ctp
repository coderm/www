<!-- File: /app/View/Mailings/index.ctp -->
<?php echo $this->Html->link('Yeni Mailing Oluştur', array('controller' => 'mailings', 'action' => 'add')); ?>
<h3>Tüm Mailingler</h3>
<table>
    <tr>
        <th>Id</th>
        <th>Id Metni</th>
        <th>Adı</th>
        <th>Açıklaması</th>
        <th>Kampanya Bağlantısı</th>
        <th>Resimli Gösterim Sayısı</th>
        <th>Created</th>
        <th>Modified</th>
        <th>İşlem</th>
    </tr>
    <?php foreach ($mailings as $mailing): ?>
    <tr>
        <td><?php echo $mailing['Mailing']['id']; ?></td>
        <td><?php echo $mailing['Mailing']['idStr']; ?></td>
        <td><?php echo $mailing['Mailing']['mailing_name']; ?></td>
        <td><?php echo $mailing['Mailing']['description']; ?></td>
        <td><?php echo $mailing['Mailing']['campaign_path']; ?></td>
        <td><?php echo $mailing['Mailing']['image_view_count']; ?></td>
        <td><?php echo $mailing['Mailing']['created']; ?></td>
        <td><?php echo $mailing['Mailing']['modified']; ?></td>
        <td>
            <?php echo $this->Html->link('Görüntüle', array('controller' => 'mailings', 'action' => 'view', $mailing['Mailing']['idStr'])); ?>
            <?php echo $this->Html->link('Düzenle', array('controller' => 'mailings', 'action' => 'edit', $mailing['Mailing']['idStr'])); ?>
            <?php echo $this->Html->link('Sil', array('controller' => 'mailings', 'action' => 'delete', $mailing['Mailing']['idStr']),array('confirm' => 'Bu mailingi silmek istediğinizden emin misiniz?')); ?>
            
        </td>
    </tr>
    <?php endforeach; ?>

</table>