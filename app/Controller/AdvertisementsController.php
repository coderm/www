<?php

App::uses('Sanitize', 'Utility', 'RequestHandler');

class AdvertisementsController extends AppController {

    public $name = 'Advertisements';

    public function index() {
        $data = $this->params['url'];
        if (isset($data['fastSearch']))
            $result = $this->Advertisement->fastSearch($data['fastSearch']);

        $this->loadModel('Fixed');
        $this->set('advertProperties', $this->Fixed->getAdvertProperties());


        $this->set('advertList', $this->Advertisement->fastSearch(''));
    }

    public function advert($city = null, $county = null, $neigborhood = null, $advertId = null, $title = null) {
        if ($advertId == NULL) {
            if ($city == null)
                $data['Search']['location'] = '';
            elseif ($county == null)
                $data['Search']['location'] = $city;
            elseif ($neigborhood == null)
                $data['Search']['location'] = $city . ', ' . $county;
            else
                $data['Search']['location'] = $city . ', ' . $county . ', ' . $neigborhood;
            $this->loadModel('Fixed');
            $this->set('advertProperties', $this->Fixed->getAdvertProperties());
            $this->set('advertList', $this->Advertisement->detailSearch($data));
            $this->view = 'index';
        }
        else { 
        
            $this->set('advertdetails', $this->Advertisement->advertData($advertId));
            $this->set('advertcalender', $this->Advertisement->getAdvertSchedule($advertId,6));
            $this->loadModel('Comment');
            $this->set('advertcomments', $this->Comment->getComment($advertId));
        }
    }

    public function searchLocations($string) {
        $this->layout = false;
        $this->set('locations', $this->Advertisement->locations($string));
    }

}