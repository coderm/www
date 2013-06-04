<?php

class AdvertsText extends AppModel {

    public $name = 'AdvertsText';
    public $useTable = 'dt_advert_texts';
    public $primaryKey = 'advert_text_id';

    public function getAdvertText($advertId) {
        $lang = $this->getLanguageId();

        $result = $this->find('first',array('conditions' => array('advert_id' => $advertId, 'language_id' => $lang)));
        return $result['AdvertsText'];
    }

}