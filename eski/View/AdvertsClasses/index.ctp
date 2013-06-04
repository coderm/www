<h3>İlan detay gösterim</h3>
<table>
    <tr>
        <th>Detay</th>
        <?php
        echo $this->Form->create('AdvertsClassDetails');
        foreach ($AdvertsClasses as $AdvertsClass) {
            echo '<th>' . __($AdvertsClass['AdvertsClass']['message_text_id']) . '</th>';
        }

        echo '</tr>';

        foreach ($DetailsClasses as $DetailsClass) {
            echo '<tr><th>' . __($DetailsClass['DetailsClass']['message_text_id']) . '</th>';
            foreach ($AdvertsClasses as $AdvertsClass) {
                $a = FALSE;
                foreach ($DetailsClass['AdvertClassDetail'] as $acd) {
                    if ($acd['advert_class_id'] == $AdvertsClass['AdvertsClass']['advert_class_id'])
                        $a = TRUE;
                }

                $name = 'AdvertsClassDetails.' . $DetailsClass['DetailsClass']['detail_class_id'] . '.' . $AdvertsClass['AdvertsClass']['advert_class_id'];
                echo '<th>' . $this->Form->checkbox($name, array('hiddenField' => false, 'checked' => $a)) . '</th>';
            }
            echo '</tr>';
        }
        echo '<tr><th>';
        echo $this->Form->submit('Kaydet');
        echo $this->Form->end();
        echo '</th></tr>';
        ?>
</table>
