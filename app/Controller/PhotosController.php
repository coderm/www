<?php

class PhotosController extends AppController {

    public $helpers = array('Html', 'Form');
    public $name = 'Photos';

    public function index($location, $advertId, $name) {
        $name = explode('_', $name);
        $w = $name[1];
        $h = $name[2];
        $pic = $name[3];
        $file = $_SERVER['DOCUMENT_ROOT'] . '/app/webroot/upload/advert_' . $advertId . '/original_' . $pic;
        $this->layout = false;


        if (file_exists($file)) {
            $image = imagecreatefromstring(file_get_contents($file));
        } else {
            $image = imagecreatetruecolor($w, $h);
            $text_color = imagecolorallocate($image, 233, 14, 91);
            imagestring($image, 1, 5, 5, 'Resim Bulunamadi', $text_color);
        }
        $image = $this->resize($image, $w, $h);
        if ($w > 300)
            $image = $this->watermark($image, $w, $h);
        $this->set('image', $image);
    }

    function resize($image, $w, $h) {
        $rImage = imagecreatetruecolor($w, $h);
        $pw = imagesx($image);
        $ph = imagesy($image);

        $pratio = $pw / $ph;
        $ratio = $w / $h;


        if ($pratio > $ratio) {
            $newHeight = $ph / ($pw / $w);
            imagecopyresampled($rImage, $image, 0, ($h - $newHeight) / 2, 0, 0, $w, $newHeight, $pw, $ph);
        } else {
            $newWidth = $pw / ($ph / $h);
            imagecopyresampled($rImage, $image, ($w - $newWidth) / 2, 0, 0, 0, $newWidth, $h, $pw, $ph);
        }
        return $rImage;
    }

    function watermark($image, $w, $h) {
        $watermarkLogo = imagecreatefrompng('img/waterMarkLogo.png');
        $wlw = imagesx($watermarkLogo);
        $wlh = imagesy($watermarkLogo);
        imagecopy($image, $watermarkLogo, 10, 10, 0, 0, $wlw, $wlh);

        $watermarkText = imagecreatefrompng('img/waterMarkText.png');
        $wtw = imagesx($watermarkText);
        $wth = imagesy($watermarkText);
        imagecopy($image, $watermarkText, ($w - $wtw) / 2, ($h - $wth + 20) / 2, 0, 0, $wtw, $wth);
        return $image;
    }

}