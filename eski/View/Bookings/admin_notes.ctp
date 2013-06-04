<?php
 $this->layout = 'empty';
    foreach($adminNotes as $adminNote)
    {
        $deleted = false;
        if(isset($adminNote['properties']['deleted']))
            $deleted = true;
        
        echo '<div style="margin-bottom:15px;position:relative;border-bottom:1px solid white;padding:4px;color:#111111;">';
        echo '<b>'.$adminNote['properties']['user']['uname'].':</b><br/>';
        if(!$deleted)
            echo $adminNote['properties']['note'];
        else
            echo '<del><i>'.$adminNote['properties']['note'].'</i></del>';
        echo '<div style="position:absolute;right:0;top:0;color:#bbbbbb">';
        if(!$deleted)
            echo '<a href="javascript:return false;" onclick="javascript:deleteAdminNote('.$adminNote['BookingDetail']['booking_detail_id'].');">[Geçersiz olarak işaretle]</a>&nbsp&nbsp&nbsp&nbsp';
        
        if(isset($adminNote['properties']['date']))
                echo $adminNote['properties']['date'];
        echo '</div>';
        echo '</div>';       
    }
	

?>