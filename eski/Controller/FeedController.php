<?php

class FeedController extends AppController {
public $components = array('RequestHandler');
public $helpers = array('text');
public $name = 'Feed';

public function index() {
  if ($this->RequestHandler->isRss() ) {
        $results = $this->Feed->query('select advert_id, description, title, city, county, zone, price, norm_price, currency_unit, add_date as created, picture, is_partner, advert_class, advert_status, show_in_homepage from vw_get_adverts where advert_status = "active" and show_in_homepage = 1 order by add_date desc limit 30');
        $adverts = array();
        foreach ($results as $result) {
                $item = array();
                $picture = $this->parseProperties($result['vw_get_adverts']['picture']);
                $item['vw_get_adverts']['picture'] = $picture['name'];
                $item['vw_get_adverts']['id'] = $result['vw_get_adverts']['advert_id'];
                $item['vw_get_adverts']['title'] = $result['vw_get_adverts']['title'];
                $item['vw_get_adverts']['description'] = $result['vw_get_adverts']['description'];
                $item['vw_get_adverts']['price'] = $result['vw_get_adverts']['price'];
                $item['vw_get_adverts']['created'] = $result['vw_get_adverts']['created'];
                $urlOptions = array();
                $urlOptions['controller'] = 'searches';
                $urlOptions['action'] = 'index';
                $urlOptions[] = $this->stringToSlug($result['vw_get_adverts']['city']);
                $urlOptions[] = $this->stringToSlug($result['vw_get_adverts']['county']);
                $urlOptions[] = $this->stringToSlug($result['vw_get_adverts']['zone']);
                $result['vw_get_adverts']['locationUrlOptions'] = $urlOptions; 
                $urlOptions[] = $this->stringToSlug($result['vw_get_adverts']['advert_class']);
                $urlOptions[] = $result['vw_get_adverts']['advert_id'];
                $urlOptions[] = $this->stringToSlug($result['vw_get_adverts']['title']);
                $item['vw_get_adverts']['urlOptions'] = $urlOptions;
                $adverts[] = $item;
}
     
            
         return $this->set(compact('adverts'));
      }
}

}

