<?php

class TestsController extends AppController {

    public $helpers = array('Html', 'Form');
    public $name = 'Tests';

    public function index() {
       $this->loadModel('Advertisement');
       
       $data['Search']['startDate']= '01-06-2011';
       $data['Search']['endDate']= '01-12-2013';
       $data['Search']['peopleCount'] = 5 ;
       $data['Search']['location'] = 'didim' ;
       
// pr($this->Advertisement->locations('beşi'));    
  pr($this->Advertisement->detailSearch($data)) ;
        //die;
               
        /* echo 'openssl: ', extension_loaded('openssl') ? 'yes' : 'no', "\n";
          echo 'http wrapper: ', in_array('http', $w) ? 'yes' : 'no', "\n";
          echo 'https wrapper: ', in_array('https', $w) ? 'yes' : 'no', "\n";
          echo 'wrappers: ', var_dump($w); */
        //pr($this->Test->bookConflicting(1724, "2012-01-01", "2012-02-05"));
        /* $data = array();
          $data ['bora'] = 'ata';
          $data ['bora1'] = 'ata1';
          $data ['bora2'] = 'ata2';
          $data ['bora3'] = 'ata3';

          pr($this->Test->arrayToProperties($data)); */
        // $this->loadModel('Booking');
        // pr($this->Booking->addUpdateBookingfanout('1004-1000'));
        //  $this->loadModel('TxUser');
        // pr($this->TxUser->userData(140) );
/*
        echo '----<br>';
        echo '----<br>';
        echo '----<br>';
        echo '----<br>';
        echo '----<br>';
        $this->loadModel('TxUser');
        $data = array();
        $data['Form']['type'] = 'user';
        $data['User']['userId'] = 140 ;
        $data['User']['currentPass'] = '00197800';
        $data['User']['name'] = 'ata';
        $data['User']['sname'] = 'bora';
        $data['User']['gender_id'] = '1';
        $data['User']['phoneCountryCode'] = '541';
        $data['User']['phoneNumber'] = '9676864';
        $data['User']['email'] = 'mail';
        $data['User']['dateOfBirth']['year'] = '1980';
        $data['User']['dateOfBirth']['month'] = '12';
        $data['User']['dateOfBirth']['day'] = '10';
        
        pr($this->TxUser->updateUser($data));
       
        */
        //$this->Booking->save($fields, array('advert_id' => 3669));
        /* $t = $this->Advertisement->getCurrencyUnitOptions();
          pr($t); */


      /*    $data = array();
          $data['advertId'] = '3668';
          $data['month'] = '4';
          $data['year'] = '2013';
          pr($this->Advertisement->advertCalender($data)); 
          die;
*/
        /* $results = $this->Advertisement->query('select * from homelet.dt_advert_details where detail_class_id = 11 and advert_id > 2560');
          $data = array();
          foreach ($results as $result) {
          $pic = $this->Advertisement->propertiesToArray($result['dt_advert_details']['advert_detail']);
          $key = explode('.', $pic['name']);
          $key = $key[0];
          $isMain = 0;
          if ($pic['order'] = 0)
          $isMain = 1;
          $data[$result['dt_advert_details']['advert_id']][$key]['name'] = $pic['name'];
          $data[$result['dt_advert_details']['advert_id']][$key]['isMain'] = $isMain;
          $data[$result['dt_advert_details']['advert_id']][$key]['label'] = '';

          }

          foreach ($data as  $key => $advert ) {
          $advertisement = array();
          $advertisement['Advertisement']['picture'] = $advert ;
          $advertisement['Advertisement']['advertId'] = $key ;
          $this->Advertisement->addUpdatePictures($advertisement);
          } */
    }

}

