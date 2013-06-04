<?php

class AdvertCopy extends AppModel {

    public $name = 'AdvertCopy';
    public $useTable = false;

    public function getNextAdvert($advertId = NULL) {
        if (isset($advertId))
            $result = $this->query('SELECT *
            FROM (SELECT *
          FROM homelet.dt_adverts
         WHERE advert_id = ' . $advertId . ' ) a');
        else
            $result = $this->query('SELECT *
                FROM (SELECT advert_id,
               advert_class_id,
               status,
               on_top_date,
               if(show_in_homepage = 1, TRUE, FALSE) "show_in_homepage"
          FROM homelet.dt_adverts
         WHERE advert_id NOT IN (SELECT advert_id FROM tatilevim.dt_adverts)
        ORDER BY homelet.dt_adverts.advert_id
         LIMIT 1) a');
        return $result[0]['a'];
    }

    public function getOldAdvertDetails($advertId) {
        $results = $this->query('select Details.advert_detail , DC.message_text_id, DC.description ,DC.multiple  from homelet.dt_advert_details Details 
JOIN lu_details_class DC on Details.detail_class_id = DC.detail_class_id
where advert_id = ' . $advertId);
        $return = array();
        foreach ($results as $result) {
            if ($result['DC']['multiple'])
                $return[$result['DC']['message_text_id']][] = $result['Details']['advert_detail'];
            else
                $return[$result['DC']['message_text_id']] = $result['Details']['advert_detail'];
        }


        return $return;
    }

}
