<br/><br/>
<div style="padding:10px;">
<?php
    echo 'Sayın '.$customer['User']['name'].' '.$customer['User']['sname'].',<br/>';
    echo 'tatilevim.com internet sitesinden yapmış olduğunuz <b>#'.$booking['Booking']['booking_id'].'</b> nolu rezervasyonunuz ile ilgili detaylar aşağıdadır:<br/><br/>';
?>
    <div style="width:40%;position: relative;clear:none;float:left;line-height: 20px;">
<?php
    echo 'Başlangıç tarihi:<br/>';
    echo '<b>'.$booking['Booking']['start_date'].'</b>';
    echo '<br/><br/>Bitiş tarihi:<br/>';
    echo '<b>'.$booking['Booking']['end_date'].'</b>';
?>
    </div>
    <div style="width:40%;position: relative;clear:none;float:left;line-height: 20px;">
<?php
    echo 'Giriş saati:<br/>';
    echo '<b>14:00</b>';
    echo '<br/><br/>Çıkış saati:<br/>';
    echo '<b>10:00</b>';
?>
    </div>
    
    <div style="width:100%;clear:both;position: relative;float:left;margin-top:20px;">
    Adres:<br/>
<?php
    echo $advert['ldct_address'][0]['detail'].'</br>';
    echo '<span style="float:right;">';
    $a = parseProperties($advert['lcdt_county'][0]['detail']);
    foreach($a as $key)
        echo $key;  
    echo ' / ';
    $a = parseProperties($advert['lcdt_city'][0]['detail']);
    foreach($a as $key)
        echo $key;    
    echo '</span>';    
?>
    </div>
</div>
    
<?php
    function parseProperties($propertiesString)
    {
                $propertiesString = ltrim($propertiesString);
                $propertiesString = rtrim($propertiesString);
                $a = array();
                if($propertiesString!='')
                {
                    $properties = explode('[|]',$propertiesString);
                    foreach($properties as $property)
                    {
                        $p = explode('=>',$property);
                        $p[0] = trim(str_replace("'","",$p[0]));
                        $p[1] = trim(str_replace("'","",$p[1]));
                        $a[trim($p[0])] = $p[1];
                    }
                    $properties = $a;
                }
                return $a;
    }  
?>