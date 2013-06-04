<?php
$msg = "Sayın kullanıcımız,\n";
$msg.= "tatilevim.com'a hoş geldiniz!\n\n";
$msg.= "Aşağıda belirtilen onay kodunuzu kullanarak veya aşağıdakli linke tıklayarak üyeliğinizi aktive edin\n";
$msg.= "Üyeliğinizi aktive eder etmez sadece 1 dakikanızı ayırarak ilanınızı yükleyin ve diğer kullanıcılarımız gibi siz de avantajlarımızdan faydalanın.\n\n";
$msg.= "www.tatilevim.com üyelik onay kodunuz:\n\n";
$msg.= $confirmCode."\n\n"; 
$msg.= "Üyeliğiniz aktive etmek için aşağıdaki bağlantıya gidin:\n";
$msg.= "http://www.tatilevim.com/users/activate/".$email."/".$confirmCode;
echo $msg;
?>


