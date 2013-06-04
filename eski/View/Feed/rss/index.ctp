<?php

$this->set('documentData', array(
    'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

$this->set('channelData', array(
    'title' => __("Tatil Evim İlanlar"),
    'link' => $this->Html->url('/', true),
    'description' => __("Tatilevim Son ilanlar"),
    'language' => 'TR-tr'));
App::uses('Sanitize', 'Utility');
foreach ($adverts as $advert) 
    {
    $postTime = strtotime($advert['vw_get_adverts']['created']);
    $urlOptions = $advert['vw_get_adverts']['urlOptions'];

    // This is the part where we clean the body text for output as the description
    // of the rss item, this needs to have only text to make sure the feed validates
   $bodyText = preg_replace('=\(.*?\)=is', '',$advert['vw_get_adverts']['description'] );
    $bodyText = $this->Text->stripLinks($bodyText);
    $bodyText = Sanitize::stripAll($bodyText);
    $bodyText = $this->Text->truncate($bodyText, 400, array(
        'ending' => '...',
        'exact' => true,
        'html' => true,
            ));
     $thumb_imgPath = $this->Html->url('/upload/advert_'. $advert['vw_get_adverts']['id'] . '/thumb_' . $advert['vw_get_adverts']['picture'], true);
     $imgPath = $this->Html->url('/upload/advert_'. $advert['vw_get_adverts']['id'] . '/' . $advert['vw_get_adverts']['picture'], true);
     
     
     $imageLinkURL = $this->Html->url($urlOptions,true);
     $imagelink = $this->Html->link(
                    $this->Html->image($thumb_imgPath, array('alt'=> 'www.tatilevim.com')),
                    $imageLinkURL,
                    array('target' => '_self', 'escape' => false)
                    );

     $bodyText = $imagelink . $bodyText;    


   echo  $this->Rss->item(array(), array(
        'title' => $advert['vw_get_adverts']['title'],
        'link' => $urlOptions,
        'guid' => array('url' => $urlOptions, 'isPermaLink' => 'true'),
        'description' => $bodyText,
        'enclosure' => array('url'=> $imgPath , 'type'=>"image/jpeg"), 
        'pubDate' => $advert['vw_get_adverts']['created'],
    ));
   
    
}

