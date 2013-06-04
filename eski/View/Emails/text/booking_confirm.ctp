<?php
$msg = "Sayın:".$customer['User']['name']." ".$customer['User']['sname']."\n";
$msg.= "tatilevim.com internet sitesinden yapmış olduğunuz #".$booking['Booking']['booking_id']." nolu rezervasyonunuz onaylanmıştır.\n";
$msg.= "Rezervasyonunuz ile ilgili detaylar aşağıdadır:";
echo $msg;
?>
