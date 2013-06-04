<?php

class AdvertsText extends AppModel {

    public $name = 'AdvertsText';
    public $useTable = 'dt_advert_texts';
    public $primaryKey = 'advert_text_id';

    public function getAdvertText($advertId) {
        $lang = $this->getLanguageId();
        $results = $this->find('all', array('conditions' => array('advert_id' => $advertId)));
        $return = array();
        foreach ($results as $value) {
            $return['title'][$this->returnLanguage($value['AdvertsText']['language_id'])] = $value['AdvertsText']['title'];
            $return['description'][$this->returnLanguage($value['AdvertsText']['language_id'])] = $value['AdvertsText']['description'];
        }
        return $return;
    }

}