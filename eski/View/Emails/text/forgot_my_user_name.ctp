<?php
$msg = "Sayın kullanıcımız,\n";
$msg.= "bu e-posta tatilevim.com üzerinden yapmış olduğunuz 'Kullanıcı Adımı Unuttum' talebiniz üzerine gönderilmiştir.\n\n";
$msg.= "Eğer böyle bir talepte bulunmadıysanız lütfen bu e-posta'yı dikkate almayınız.\n";
$msg.= "Tatil Evim kullanıcı adınız:\n\n";
$msg.= $userName."\n\n"; 
$msg.= "Giriş yapmak için aşağıdaki bağlantı adresine gidin:\n";
$msg.= "http://www.tatilevim.com/uye-girisi";
echo $msg;
?>

