<!-- File: /app/View/Mailings/index.ctp -->
<?php echo $this->Html->link('Yeni Mailing Linki Oluştur', array('controller' => 'mailingLinks', 'action' => 'add')); ?>
<h3>Tüm Mailingler</h3>
<table>
    <tr>
        <th>Id</th>
        <th>Id Metni</th>
        <th>Adı</th>
        <th>Açıklaması</th>
        <th>Bağlantı Adresi</th>
        <th>Tıklanma Sayısı</th>
        <th>Created</th>
        <th>Modified</th>
        <th>İşlem</th>
    </tr>
    <?php foreach ($mailingLinks as $mailingLink): ?>
    <tr>
        <td><?php echo $mailingLink['MailingLink']['id']; ?></td>
        <td><?php echo $mailingLink['MailingLink']['idStr']; ?></td>
        <td><?php echo $mailingLink['MailingLink']['link_name']; ?></td>
        <td><?php echo $mailingLink['MailingLink']['description']; ?></td>
        <td><?php echo $mailingLink['MailingLink']['path']; ?></td>
        <td><?php echo $mailingLink['MailingLink']['click_count']; ?></td>
        <td><?php echo $mailingLink['MailingLink']['created']; ?></td>
        <td><?php echo $mailingLink['MailingLink']['modified']; ?></td>
        <td>
            <?php echo $this->Html->link('Görüntüle', array('controller' => 'mailingLinks', 'action' => 'view', $mailingLink['MailingLink']['idStr'])); ?>
            <?php echo $this->Html->link('Düzenle', array('controller' => 'mailingLinks', 'action' => 'edit', $mailingLink['MailingLink']['idStr'])); ?>
            <?php echo $this->Html->link('Sil', array('controller' => 'mailingLinks', 'action' => 'delete', $mailingLink['MailingLink']['idStr']),array('confirm' => 'Bu mailing linkini silmek istediğinizden emin misiniz?')); ?>
            
        </td>
    </tr>
    <?php endforeach; ?>

</table>