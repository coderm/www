<?php
echo '<table>';
$i = 0;
pr($permissions);
    foreach ($permissions as $permission) {
        $i = $i + 1 ;
        echo '<tr>';
        echo '<td>' . $i . '</td>';
      echo  '<td>' . $permission['UserGroup']['user_s_id'] . '</td>';
      echo  '<td>' . $permission['UserGroup']['authorized'] . '</td>';
      echo  '<td>' . $permission['UserGroup']['authorized_description'] . '</td>';
      echo  '<td>' . $permission['Permission']['message_text_id'] . '</td>';
      echo  '<td>' . $permission['Permission']['description'] . '</td>';
         echo '</tr>';

    }
echo '</table>';
