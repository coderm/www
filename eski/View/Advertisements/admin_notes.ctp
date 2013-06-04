<?php
    $this->layout = 'empty';
    foreach($adminNotes as $adminNote)
    {
        $deleted = false;
        if(isset($adminNote['details']['deleted']))
            $deleted = true;
        
        echo '<div style="margin-bottom:15px;position:relative;border-bottom:1px solid white;padding:4px;">';
        echo '<b>'.$adminNote['vu']['uname'].':</b><br/>';
        if(!$deleted)
            echo $adminNote['details']['note'];
        else
            echo '<del><i>'.$adminNote['details']['note'].'</i></del>';
        echo '<div style="position:absolute;right:0;top:0;color:#bbbbbb">';
        if(!$deleted)
            echo '<a href="javascript:return false;" onclick="javascript:deleteAdminNote('.$adminNote['dad']['advert_detail_id'].');">[Geçersiz olarak işaretle]</a>&nbsp&nbsp&nbsp&nbsp';
        
        echo $adminNote['details']['date'];
        echo '</div>';
        echo '</div>';
    }

?>