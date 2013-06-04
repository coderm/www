<h3>İlan detay gösterim</h3>
<table>
    <tr>
        <th>Detay</th>
        <th>Detay</th>
    </tr>
    <?php
   // pr($DetailsClasses);

    foreach ($DetailsClasses as $DetailsClass) {
        if(isset ($DetailsClass['AdvertClassDetail'][0])) {
            echo '<tr><th>' . __($DetailsClass['DetailsClass']['message_text_id']) . '</th>';
            echo '<th>';
            echo $this->Html->link(" /\ ", array('manager' => false, 'controller' => 'AdvertsClasses', 'action' => 'order', 'up', $DetailsClass['DetailsClass']['detail_class_id']));
            echo $this->Html->link(" \/ ", array('manager' => false, 'controller' => 'AdvertsClasses', 'action' => 'order', 'down', $DetailsClass['DetailsClass']['detail_class_id']));
            echo '</th></tr>';
        }
    }
    ?>
</table>
