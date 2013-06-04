<?php
$msg = "Sayın kullanıcımız,\n";
$msg.= "bu e-posta tatilevim.com üzerinden yapmış olduğunuz 'Şifremi Unuttum' talebiniz üzerine gönderilmiştir.\n\n";
$msg.= "Eğer böyle bir talepte bulunmadıysanız lütfen bu e-posta'yı dikkate almayınız.\n\n";
$msg.= "Tatil Evim şifrenizi yeniden düzenlemek için aşağıdaki bağlantı adresine gidin:.\n\n";
$msg.= "http://www.tatilevim.com/sifre-yenile/".$email."/".$securityCodeForUser;
echo $msg;
?>

