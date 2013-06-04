<?php
foreach($poList as $po)
{
    echo 'msgid "'.$po['lu_system_messages']['message_text_id'].'"<br/>';
    echo 'msgstr "'.$po['lu_system_messages']['description'].'"<br/><br/>';
}
?>

