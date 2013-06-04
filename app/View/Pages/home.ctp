<?php

foreach ($homePageAdverts as $advert) {


    foreach ($advert['Advertisement']['picture'] as $picture) {
        echo $this->Html->image($picture['path'], array('alt' => $picture['label'], 'border' => '0'));
        echo '</br>';
        echo $this->Html->image($picture['thumb'], array('alt' => $picture['label'], 'border' => '0'));
        echo '</br>';
        echo $this->Html->image($picture['scrool'], array('alt' => $picture['label'], 'border' => '0'));
        echo '</br>';
    }
}

pr($mainBanners);
pr($homePageAdverts);
pr($lastBooksAdverts);
?>