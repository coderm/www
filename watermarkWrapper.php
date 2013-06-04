<?php


echo $_SERVER['REQUEST_URI'];
die;
// Path the the requested file
$path = $_SERVER['DOCUMENT_ROOT'].'/app/webroot'.$_SERVER['REQUEST_URI'];

// Load the requested image
$image = imagecreatefromstring(file_get_contents($path));

$w = imagesx($image);
$h = imagesy($image);


if(!($pos = strrpos($path, "thumb")>0))
{
    $siteWidth = 400;
    $siteHeight = 301;
    $new_image = imagecreatetruecolor($siteWidth, $siteHeight);   
    
    
    $backgroundColor = imagecolorallocate($new_image, 241, 241, 241);
    imagefill($new_image, 0, 0, $backgroundColor);
    
    $siteImageRatio = $siteWidth / $siteHeight;
    $sourceImageRatio = $w / $h;
    
    
    //echo $siteImageRatio;
    //echo '<br/>';
    //echo $sourceImageRatio;
    
    if($siteImageRatio<$sourceImageRatio)
    {
        $newHeight = $h/($w/$siteWidth);
        imagecopyresampled($new_image, $image, 0, ($siteHeight - $newHeight)/2, 0, 0, $siteWidth, $newHeight, $w, $h);
    }
    else
    {
        $newWidth = $w/($h/$siteHeight);
        imagecopyresampled($new_image, $image, ($siteWidth - $newWidth)/2, 0, 0, 0, $newWidth, $siteHeight, $w, $h);
    }
        
    
    $image = $new_image;
        
    $watermarkEffect = imagecreatefrompng('img/waterMarkEffect.png');
    $wew = imagesx($watermarkEffect);
    $weh = imagesy($watermarkEffect);
    imagecopy($image, $watermarkEffect, 0, 0, 0, 0, $wew, $weh);    
    

    $watermarkLogo = imagecreatefrompng('img/waterMarkLogo.png');
    $wlw = imagesx($watermarkLogo);
    $wlh = imagesy($watermarkLogo);
    imagecopy($image, $watermarkLogo, 20, 20, 0, 0, $wlw, $wlh);

    $watermarkText = imagecreatefrompng('img/waterMarkText.png');
    $wtw = imagesx($watermarkText);
    $wth = imagesy($watermarkText);
    imagecopy($image, $watermarkText, ($siteWidth - $wtw)/2, $siteHeight-$wth-20, 0, 0, $wtw, $wth);
}

header('Content-type: image/JPEG');
imagejpeg($image);
exit();
?> 