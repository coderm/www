<?php

class Advertisement extends AppModel {

    public $name = 'Advertisement';
    public $useTable = 'dt_adverts';
    public $primaryKey = 'advert_id';
    public $belongsTo = array(
        'HouseHolder' => array(
            'className' => 'TxUser',
            'foreignKey' => 'householder_s_id'
        ),
        'AdvertClass' => array(
            'className' => 'AdvertsClass',
            'foreignKey' => 'advert_class_id'
        ),
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id'
        ),
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id'
        ),
        'County' => array(
            'className' => 'County',
            'foreignKey' => 'county_id'
        ),
        'Neighborhood' => array(
            'className' => 'Neighborhood',
            'foreignKey' => 'neighborhood_id'
        ),
        /*  'District' => array(
          'className' => 'District',
          'foreignKey' => 'district_id'
          ), */
        'CurrencyUnit' => array(
            'className' => 'CurrencyUnit',
            'foreignKey' => 'currency_id'
        )
    );
    public $hasMany = array(
        'AdvertsText' => array(
            'className' => 'AdvertsText',
            'foreignKey' => 'advert_id'
        ),
        'Booking' => array(
            'className' => 'Booking',
            'foreignKey' => 'advert_id'
        ),
        'ExceptionRate' => array(
            'className' => 'ExceptionRate',
            'foreignKey' => 'advert_id'
        )
        ,
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'advert_id'
        )
    );
    public $validate = array
        (
        'file' => array
            (
            'rule1' => array(
                'rule' => 'controlImages',
                'message' => 'En az bir adet resim eklenmelidir'
            )
        ),
        'houseHolder' => array
            (
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'L�tfen ev sahibi se�iniz'
            )
        )
        ,
        'UserPhone' => array(
            'rule1' => array(
                'rule' => '/[-\( \/]*(0{1})?[-\)\( \/]*([\d]{3})[-\) \/]*([0-9]{1})([\d]{2})[- \/]*([\d]{2})[- \/]*([\d]{2})+$/',
                'message' => 'Telefon numaras�n� kontrol edin'
            )
        )
        ,
        'acceptAgreement' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'Bu alan bo� b�rak�lamaz',
            ),
            'rule2' => array(
                'rule' => array('comparison', '!=', 0),
                'message' => 'Rezervasyon yapabilmek i�in kiralama ko�ullar�n� onaylaman�z gerekmektedir.'
            )
        )
    );
    public $quickAddValidate = array(
        'title' => array(
            'rule' => array('between', 5, 60),
            'message' => 'between_%d_to_%d'
        ),
        'description' => array(
            'rule' => array('minLength', 300),
            'message' => 'min_length_%d'
        ),
        'type' => array(
            'rule' => 'notEmpty',
            'message' => 'not_empty'
        ),
        'maxGuests' => array(
            'rule' => array('range', 0, 50),
            'message' => 'only_numeric_max_%d_to_%d'
        ),
        'demand' => array(
            'rule' => 'numeric',
            'message' => 'only_numeric'
        ),
        'currency' => array(
            'rule' => 'notEmpty',
            'message' => 'not_empty'
        ),
        'address' => array(
            'rule' => 'notEmpty',
            'message' => 'not_empty'
        )/* ,
              'country' => array(
              'rule' => 'notEmpty',
              'message' => 'not_empty'
              ),
              'city' => array(
              'rule' => 'notEmpty',
              'message' => 'not_empty'
              ),
              'district' => array(
              'rule' => 'notEmpty',
              'message' => 'not_empty'
              ),
              'subDistrict' => array(
              'rule' => 'notEmpty',
              'message' => 'not_empty'
              ),
              'phoneNumber' => array(
              'rule' => 'notEmpty',
              'message' => 'not_empty'
              ),
              'phoneCountryCode' => array(
              'rule' => 'notEmpty',
              'message' => 'not_empty'
              ), */
    );

    public function locations($string) {
        $this->recursive = 0;

        $locations = array();

        if (strlen($string) > 1) {

            $params = array();
            $params['conditions']['status'] = 'active';
            $params['conditions']['CONCAT(City.message_text_id) LIKE'] = '%' . $string . '%';
            $params['fields'] = array('count(*) as COUNT', 'CONCAT(City.message_text_id)  AS locations');
            $params['group'] = array('Advertisement.city_id');
            $params['limit'] = 15;
            $params['order'] = 'count(*) desc';
            $city = $this->find('all', $params);

            $params = array();
            $params['conditions']['status'] = 'active';
            $params['conditions']['CONCAT( City.message_text_id ,", " , County.message_text_id ) LIKE'] = '%' . $string . '%';
            $params['fields'] = array('count(*) as COUNT', 'CONCAT( City.message_text_id ,", " , County.message_text_id  ) AS locations');
            $params['group'] = array('Advertisement.city_id', 'Advertisement.county_id');
            $params['limit'] = 15;
            $params['order'] = 'count(*) desc';
            $county = $this->find('all', $params);

            $params = array();
            $params['conditions']['status'] = 'active';
            $params['conditions']['CONCAT( City.message_text_id ,", " , County.message_text_id  ,", " ,  Neighborhood.message_text_id ) LIKE'] = '%' . $string . '%';
            $params['fields'] = array('count(*) as COUNT', 'CONCAT( City.message_text_id ,", " , County.message_text_id  ,", " ,  Neighborhood.message_text_id ) AS locations');
            $params['group'] = array('Advertisement.city_id', 'Advertisement.county_id', 'Advertisement.neighborhood_id');
            $params['limit'] = 15;
            $params['order'] = 'count(*) desc';
            $neighborhood = $this->find('all', $params);




            foreach ($city as $location) {
                $locations[] = $location['0']['locations'];
            }

            foreach ($county as $location) {
                $locations[] = $location['0']['locations'];
            }
            foreach ($neighborhood as $location) {
                $locations[] = $location['0']['locations'];
            }
        }
        return $locations;
    }

    public function fastSearch($searchString, $page = 1, $count = 25) {

        if (is_numeric($searchString)) {

            $this->recursive = -1;
            $result = $this->findByAdvertId($searchString);
            if ($result['Advertisement']['status'] == 'active')
                return $searchString;
        }

        // bölge arama
        $params = array();
        $params['conditions']['message_text_id like'] = '%' . $searchString . '%';

        $params['fields'] = 'country_id';
        $country = $this->Country->find('all', $params);

        $params['fields'] = 'city_id';
        $city = $this->City->find('all', $params);

        $params['fields'] = 'county_id';
        $county = $this->County->find('all', $params);

        $params['fields'] = 'neighborhood_id';
        $neighborhood = $this->Neighborhood->find('all', $params);

        $countryIds = array();
        foreach ($country as $countryId) {
            $countryIds[] = $countryId['Country']['country_id'];
        }

        $cityIds = array();
        foreach ($city as $cityId) {
            $cityIds[] = $cityId['City']['city_id'];
        }

        $countyIds = array();
        foreach ($county as $countyId) {
            $countyIds[] = $countyId['County']['county_id'];
        }

        $neighborhoodIds = array();
        foreach ($neighborhood as $neighborhoodId) {
            $neighborhoodIds[] = $neighborhoodId['Neighborhood']['neighborhood_id'];
        }

        // metinlerde arama
        $params = array();
        $params['conditions']['OR']['title like'] = '%' . $searchString . '%';
        $params['conditions']['OR']['description like'] = '%' . $searchString . '%';
        $params['fields'] = 'advert_id';

        $texts = $this->AdvertsText->find('all', $params);
        $advertIds = array();
        foreach ($texts as $advertId) {
            $advertIds[] = $advertId['AdvertsText']['advert_id'];
        }


        if (isset($countryIds[0]))
            $data['conditions']['Or']['Advertisement.country_id'] = $countryIds;
        if (isset($cityIds[0]))
            $data['conditions']['Or']['Advertisement.city_id'] = $cityIds;
        if (isset($countyIds[0]))
            $data['conditions']['Or']['Advertisement.county_id'] = $countyIds;
        if (isset($neighborhoodIds[0]))
            $data['conditions']['Or']['Advertisement.neighborhood_id'] = $neighborhoodIds;
        if (isset($advertIds[0]))
            $data['conditions']['Or']['Advertisement.advert_id'] = $advertIds;
        $data['limit'] = $count;
        $data['page'] = $page;
        $data['order'] = 'created desc';
        return $this->advertList($data, true);
    }

    public function detailSearch($data, $page = 1, $count = 25) {

        //dolu ilanlar
        $notInAdvertIds = array();
        $advertIds = array();
        if (isset($data['Search']['startDate']) && isset($data['Search']['endDate'])) {
            $startDate = $this->formatFormDateToMySQLDate($data['Search']['startDate']);
            $endDate = $this->formatFormDateToMySQLDate($data['Search']['endDate']);
            $params = array();
            $params['conditions']['start_date <'] = $endDate;
            $params['conditions']['end_date >'] = $startDate;
            $params['conditions']['status'] = 'active';
            $params['fields'] = 'DISTINCT advert_id';
            $this->Booking->recursive = -1;
            $books = $this->Booking->find('all', $params);
            foreach ($books as $advertId) {
                $notInAdvertIds[] = $advertId['Booking']['advert_id'];
            }
        }

        // bolge arama
        if (strlen($data['Search']['location']) > 2) {
            $string = str_replace(', ', ',', $data['Search']['location']);
            $string = str_replace(',', ', ', $string);
            $params = array();
            $params['conditions']['status'] = 'active';
            $params['conditions']['CONCAT( City.message_text_id ,", " , County.message_text_id  ,", " ,  Neighborhood.message_text_id ) LIKE'] = '%' . $string . '%';
            $params['fields'] = 'advert_id';
            $this->recursive = 0;
            $location = $this->find('all', $params);

            foreach ($location as $advertId) {
                $advertIds[] = $advertId['Advertisement']['advert_id'];
            }
        }




        if (isset($notInAdvertIds[0]))
            $return['conditions']['Not']['Advertisement.advert_id'] = $notInAdvertIds;
        if (isset($advertIds[0]))
            $return['conditions']['Advertisement.advert_id'] = $advertIds;
        if (isset($data['Search']['peopleCount']))
            $return['conditions']['Advertisement.max_guests >='] = $data['Search']['peopleCount'];
        $return['conditions']['status'] = 'active';
        $return['limit'] = $count;
        $return['page'] = $page;
        $return['order'] = 'created desc';

        return $this->advertList($return, true);
    }

    public function advertData($advertId) {
        $result = $this->advertBaseData($advertId);
        $result = array_merge($result, $this->getAdvertDetails($result));
        return $result;
    }

    public function advertBaseData($advertId) {
        $this->recursive = -1;
        $result = $this->findByAdvertId($advertId);
        return $result;
    }

    public function advertCalender($data = null) {
        $endDate = date("Y-m-t", mktime(0, 0, 0, $data['month'], "1", $data['year']));
        $startDate = date("Y-m-1", mktime(0, 0, 0, $data['month'], "1", $data['year']));
        $lastDay = date("t", mktime(0, 0, 0, $data['month'], "1", $data['year']));

        $params = array();
        $params['conditions']['Booking.advert_id'] = $data['advertId'];
        $params['conditions']['Booking.start_date <='] = $endDate;
        $params['conditions']['Booking.end_date >='] = $startDate;
        $params['conditions']['Booking.status'] = 'active';
        $params['order'] = 'Booking.start_date';
        $params['recursive'] = -1;
        $booking = $this->Booking->find('all', $params);

        $params = array();
        $params['conditions']['ExceptionRate.advert_id'] = $data['advertId'];
        $params['conditions']['ExceptionRate.start_date <='] = $endDate;
        $params['conditions']['ExceptionRate.end_date >='] = $startDate;
        $params['order'] = 'ExceptionRate.start_date';
        $params['recursive'] = -1;
        $exceptionRate = $this->ExceptionRate->find('all', $params);


        $advert = $this->advertData($data['advertId']);
        $demand = $advert['Advertisement']['demand'];
        $weekendDemand = $advert['Advertisement']['weekend_demand'];
        $currency = $this->getCurrencySymboll($advert['Advertisement']['currency_id']);
        $houseHolderId = $advert['Advertisement']['householder_s_id'];
        $monthData = array();
        $position = array();
        for ($i = 1; $i <= $lastDay; $i++) {
            $onDate = strtotime($data['year'] . '-' . $data['month'] . '-' . $i);
            $weekDay = date('w', $onDate);
            $position[$i] = 'end';
            //booking
            foreach ($booking as $value) {
                $value = $value['Booking'];
                $sDate = strtotime($value['start_date']);
                $eDate = strtotime($value['end_date']);
                if ($onDate >= $sDate && $onDate <= $eDate && $position[$i] = 'end') {
                    if ($value['lessor_user_s_id'] == $houseHolderId)
                        $type = 'householderBooking';
                    else
                        $type = 'tatilevimBooking';

                    if ($onDate == $sDate)
                        $position[$i] = 'begin';
                    elseif ($onDate == $eDate)
                        $position[$i] = 'end';
                    else
                        $position[$i] = 'midle';

                    $monthData[$i] = array('date' => $i . '-' . $data['month'] . '-' . $data['year']
                        , 'type' => $type
                        , 'position' => $position[$i]
                        , 'weekDay' => $weekDay
                        , 'bookingId' => $value['booking_id']
                        , 'demand' => ''
                        , 'startDate' => date("d-m-Y", $sDate)
                        , 'endDate' => date("d-m-Y", $eDate)
                        , 'text' => $value['text']
                        , 'currency' => $currency);
                }
            }
            //exceptionRate

            if (!isset($monthData[$i]) || $position[$i] == 'end')
                foreach ($exceptionRate as $value) {
                    $value = $value['ExceptionRate'];
                    $sDate = strtotime($value['start_date']);
                    $eDate = strtotime($value['end_date']);

                    if ($onDate >= $sDate && $onDate <= $eDate) {
                        if ($onDate == $sDate || $position[$i] == 'end')
                            $position[$i] = 'begin';
                        elseif ($onDate == $eDate)
                            $position[$i] = 'end';
                        else
                            $position[$i] = 'midle';
                        $monthData[$i] = array('date' => $i . '-' . $data['month'] . '-' . $data['year']
                            , 'type' => 'exceptionRate'
                            , 'position' => $position[$i]
                            , 'weekDay' => $weekDay
                            , 'bookingId' => ''
                            , 'demand' => $value['demand']
                            , 'startDate' => date("d-m-Y", $sDate)
                            , 'endDate' => date("d-m-Y", $eDate)
                            , 'text' => $value['exception_text']
                            , 'currency' => $currency);
                    }
                }
            //weekend

            if (!isset($monthData[$i]) || $position[$i] == 'end') {
                if (isset($monthData[$i]['type']))
                    if ($monthData[$i]['type'] == 'exceptionRate') {
                        $demand = $monthData[$i]['demand'];
                        $weekendDemand = $monthData[$i]['demand'];
                    }
                if ($position[$i] == 'end')
                    $position[$i] = 'begin';
                else
                    $position[$i] = 'norm';
                if ($weekendDemand && ( date('w', $onDate) == 5 || date('w', $onDate) == 6 ))
                    $monthData[$i] = array('date' => $i . '-' . $data['month'] . '-' . $data['year']
                        , 'type' => 'weekEndDemand'
                        , 'position' => $position[$i]
                        , 'weekDay' => $weekDay
                        , 'bookingId' => ''
                        , 'demand' => $weekendDemand
                        , 'startDate' => ''
                        , 'endDate' => ''
                        , 'text' => ''
                        , 'currency' => $currency);
                else
                    $monthData[$i] = array('date' => $i . '-' . $data['month'] . '-' . $data['year']
                        , 'type' => 'normDemand'
                        , 'position' => $position[$i]
                        , 'weekDay' => $weekDay
                        , 'bookingId' => ''
                        , 'demand' => $demand
                        , 'startDate' => ''
                        , 'endDate' => ''
                        , 'text' => ''
                        , 'currency' => $currency);
            }
        }

        return $monthData;
    }

    public function updateCalendar($data) {
        $data['advert'] = $this->advertData($data['Book']['advertId']);

        if ($data['Book']['ability'] == 'yes')
            $this->addExceptionRate($data);

        $bookResult = $this->addExceptionBook($data);
        return $bookResult;
    }

    public function addExceptionBook($data) {
        $advertId = $data['Book']['advertId'];
        $demand = $data['Advertisement']['demand'];
        $channel = $data['CustomBook']['channel'];
        $startDate = $this->formatFormDateToMySQLDate($data['Book']['startDate']);
        $endDate = $this->formatFormDateToMySQLDate($data['Book']['endDate']);
        $text = $data['Book']['note'];
        $userId = CakeSession::read('User.Id');
        $houseHolderId = $data['advert']['Advertisement']['householder_s_id'];
        $this->Booking->recursive = -1;


        // kapsad�klar�n� sil
        $params = array();
        $params['advert_id'] = $advertId;
        $params['lessor_user_s_id'] = $houseHolderId;
        $params['start_date >='] = $startDate;
        $params['end_date <='] = $endDate;
        $this->Booking->deleteAll($params, FALSE);

        // soldan kesi�eni d�zenle
        $params = array();
        $params['advert_id'] = $advertId;
        $params['lessor_user_s_id'] = $houseHolderId;
        $params['end_date <='] = $endDate;
        $params['end_date >'] = $startDate;
        $fields = array();
        $fields['end_date'] = '"' . $startDate . '"';
        $this->Booking->updateAll($fields, $params);

        //sa�dan kesi�eni d�zenle
        $params = array();
        $params['advert_id'] = $advertId;
        $params['lessor_user_s_id'] = $houseHolderId;
        $params['start_date >='] = $startDate;
        $params['start_date <'] = $endDate;
        $fields = array();
        $fields['start_date'] = '"' . $endDate . '"';
        $this->Booking->updateAll($fields, $params);

        //i�ine giren soldan kesi�eni d�zenle
        $params = array();
        $params['advert_id'] = $advertId;
        $params['lessor_user_s_id'] = $houseHolderId;
        $params['start_date'] = $startDate;
        $params['end_date >'] = $endDate;
        $fields = array();
        $fields['start_date'] = '"' . $endDate . '"';
        $this->Booking->updateAll($fields, $params);

        //i�ine giren sa�dan kesi�eni d�zenle
        $params = array();
        $params['advert_id'] = $advertId;
        $params['lessor_user_s_id'] = $houseHolderId;
        $params['start_date <'] = $startDate;
        $params['end_date'] = $endDate;
        $fields = array();
        $fields['end_date'] = '"' . $startDate . '"';
        $this->Booking->updateAll($fields, $params);

        //i�ine girdi�ini b�l
        $params = array();
        $params['conditions']['advert_id'] = $advertId;
        $params['conditions']['lessor_user_s_id'] = $houseHolderId;
        $params['conditions']['start_date <'] = $startDate;
        $params['conditions']['end_date >'] = $endDate;
        $result = $this->Booking->find('first', $params);
        if (isset($result['Booking']['advert_id'])) {

            $fields = array();
            $fields['end_date'] = '"' . $startDate . '"';
            $this->Booking->updateAll($fields, $params['conditions']);
            $fields = array();
            $fields['start_date'] = $endDate;
            $fields['booking_id'] = $this->Booking->getNewBookingId($advertId);
            $fields['end_date'] = $result['Booking']['end_date'];
            $fields['advert_id'] = $result['Booking']['advert_id'];
            $fields['booking_date'] = $result['Booking']['booking_date'];
            $fields['invoice'] = $result['Booking']['invoice'];
            $fields['comment_mail'] = $result['Booking']['comment_mail'];
            $fields['lessor_user_s_id'] = $result['Booking']['lessor_user_s_id'];
            $fields['renter_user_s_id'] = $userId;
            $fields['text'] = $result['Booking']['text'];
            $fields['channel'] = $result['Booking']['channel'];
            $fields['status'] = $result['Booking']['status'];
            $this->Booking->create();
            $this->Booking->save($fields);
        }
        //yenisini ekle
        $return = array();
        $book = $this->bookConflicting($advertId, $startDate, $endDate);
        $return['success'] = $book['success'];
        if ($return['success']) {
            if ($data['Book']['ability'] == 'no') {
                $fields = array();
                $fields['booking_id'] = $this->Booking->getNewBookingId($advertId);
                $fields['start_date'] = $startDate;
                $fields['end_date'] = $endDate;
                $fields['advert_id'] = $advertId;
                $fields['status'] = 'active';
                $fields['booking_date'] = date('Y-m-d H:i:s');
                $fields['renter_user_s_id'] = $userId;
                $fields['lessor_user_s_id'] = $houseHolderId;
                $fields['text'] = $text;
                $fields['channel'] = $channel;
                $this->Booking->create();
                $this->Booking->save($fields);
                if ($data['CustomBook']['totalPrice'] > 0)
                    $this->query('select fn_booking_detail_update_or_add(
                            ' . $fields['booking_id'] . ',
                            96,
                            ' . $data['CustomBook']['totalPrice'] . ')');
                $data['CustomBook']['totalPrice'] = 0;
                $return['message_text_id'] = 'dates_were_closed';
            }else
                $return['message_text_id'] = 'dates_were_opened';
        }
        else {
            if ($data['Book']['ability'] == 'no') {
                $this->Booking->advert_id = $advertId;
                $booking = $this->Booking->findByBookingId($book['bookingId']);
                $bStartDate = strtotime($booking['Booking']['start_date']);
                $nStartDate = strtotime($startDate);
                $bEndDate = strtotime($booking['Booking']['end_date']);
                $nEndDate = strtotime($endDate);
                if ($nStartDate < $bStartDate) {
                    $fields = array();
                    $fields['booking_id'] = $this->Booking->getNewBookingId($advertId);
                    $fields['start_date'] = $startDate;
                    $fields['end_date'] = $booking['Booking']['start_date'];
                    $fields['advert_id'] = $advertId;
                    $fields['status'] = 'active';
                    $fields['booking_date'] = date('Y-m-d H:i:s');
                    $fields['renter_user_s_id'] = $userId;
                    $fields['lessor_user_s_id'] = $houseHolderId;
                    $fields['text'] = $text;
                    $fields['channel'] = $channel;
                    $this->Booking->create();
                    $this->Booking->save($fields);
                    if ($data['CustomBook']['totalPrice'] > 0)
                        $this->query('select fn_booking_detail_update_or_add(
                            ' . $fields['booking_id'] . ',
                            96,
                            ' . $data['CustomBook']['totalPrice'] . ')');
                    $data['CustomBook']['totalPrice'] = 0;
                }

                if ($nEndDate > $bEndDate) {
                    $fields = array();
                    $fields['booking_id'] = $this->Booking->getNewBookingId($advertId);
                    $fields['start_date'] = $booking['Booking']['end_date'];
                    $fields['end_date'] = $endDate;
                    $fields['advert_id'] = $advertId;
                    $fields['status'] = 'active';
                    $fields['booking_date'] = date('Y-m-d H:i:s');
                    $fields['renter_user_s_id'] = $userId;
                    $fields['lessor_user_s_id'] = $houseHolderId;
                    $fields['text'] = $text;
                    $fields['channel'] = $channel;
                    $this->Booking->create();
                    $this->Booking->save($fields);
                    if ($data['CustomBook']['totalPrice'] > 0)
                        $this->query('select fn_booking_detail_update_or_add(
                            ' . $fields['booking_id'] . ',
                            96,
                            ' . $data['CustomBook']['totalPrice'] . ')');
                    $data['CustomBook']['totalPrice'] = 0;
                }
                $return['message_text_id'] = 'dates_were_closed_together_with_our_book';
            }else
                $return['message_text_id'] = 'dates_were_opened_outside_of_our_book';
        }
        $return['message'] = __($return['message_text_id']);
        return $return;
    }

    public function addExceptionRate($data) {
        $advertId = $data['Book']['advertId'];
        $demand = $data['Advertisement']['demand'];
        $startDate = $this->formatFormDateToMySQLDate($data['Book']['startDate']);
        $endDate = $this->formatFormDateToMySQLDate($data['Book']['endDate']);
        $text = $data['Book']['note'];
        $userId = CakeSession::read('User.Id');


        $this->ExceptionRate->recursive = -1;


        // kapsad�klar�n� sil
        $params = array();
        $params['advert_id'] = $advertId;
        $params['start_date >='] = $startDate;
        $params['end_date <='] = $endDate;
        $this->ExceptionRate->deleteAll($params, FALSE);

        // soldan kesi�eni d�zenle
        $params = array();
        $params['advert_id'] = $advertId;
        $params['end_date <='] = $endDate;
        $params['end_date >'] = $startDate;
        $fields = array();
        $fields['end_date'] = '"' . $startDate . '"';
        $this->ExceptionRate->updateAll($fields, $params);

        //sa�dan kesi�eni d�zenle
        $params = array();
        $params['advert_id'] = $advertId;
        $params['start_date >='] = $startDate;
        $params['start_date <'] = $endDate;
        $fields = array();
        $fields['start_date'] = '"' . $endDate . '"';
        $this->ExceptionRate->updateAll($fields, $params);

        //i�ine giren soldan kesi�eni d�zenle
        $params = array();
        $params['advert_id'] = $advertId;
        $params['start_date'] = $startDate;
        $params['end_date >'] = $endDate;
        $fields = array();
        $fields['start_date'] = '"' . $endDate . '"';
        $this->ExceptionRate->updateAll($fields, $params);

        //i�ine giren sa�dan kesi�eni d�zenle
        $params = array();
        $params['advert_id'] = $advertId;
        $params['start_date <'] = $startDate;
        $params['end_date'] = $endDate;
        $fields = array();
        $fields['end_date'] = '"' . $startDate . '"';
        $this->ExceptionRate->updateAll($fields, $params);

        //i�ine girdi�ini b�l
        $params = array();
        $params['conditions']['advert_id'] = $advertId;
        $params['conditions']['start_date <'] = $startDate;
        $params['conditions']['end_date >'] = $endDate;
        $result = $this->ExceptionRate->find('first', $params);
        if (isset($result['ExceptionRate']['advert_id'])) {

            $fields = array();
            $fields['end_date'] = '"' . $startDate . '"';
            $this->ExceptionRate->updateAll($fields, $params['conditions']);
            $fields = array();
            $fields['start_date'] = $endDate;
            $fields['end_date'] = $result['ExceptionRate']['end_date'];
            $fields['advert_id'] = $result['ExceptionRate']['advert_id'];
            $fields['demand'] = $result['ExceptionRate']['demand'];
            $fields['created'] = $result['ExceptionRate']['created'];
            $fields['created_user_s_id'] = $result['ExceptionRate']['created_user_s_id'];
            $fields['modified_user_s_id'] = $userId;
            $fields['exception_text'] = $result['ExceptionRate']['exception_text'];
            $this->ExceptionRate->create();
            $this->ExceptionRate->save($fields);
        }



        //yenisini ekle
        if ($demand > 0) {
            $fields = array();
            $fields['start_date'] = $startDate;
            $fields['end_date'] = $endDate;
            $fields['advert_id'] = $advertId;
            $fields['demand'] = $demand;
            $fields['created_user_s_id'] = $userId;
            $fields['modified_user_s_id'] = $userId;
            $fields['exception_text'] = $text;
            $this->ExceptionRate->create();
            $this->ExceptionRate->save($fields);
        }
    }

    public function advertList($data, $paginate = false) {
        $this->recursive = -1;
        $results = $this->find('all', $data);
        $i = 0;
        $datas = array();
        foreach ($results as $result) {
            $datas[$i] = array_merge($result, $this->getAdvertDetails($result));
            $i = $i + 1;
        }
        if ($paginate) {
            $datac['conditions'] = $data['conditions'];

            $count = $this->find('count', $datac);

            $paginate = array();
            if ($count > 0) {
                $paginate['count'] = $count;
                $paginate['listCount'] = $data['limit'];
                $paginate['pagesCount'] = ceil($paginate['count'] / $data['limit']);
                $paginate['onPage'] = $data['page'];
            } else {
                $paginate['count'] = 0;
                $paginate['listCount'] = 0;
                $paginate['pagesCount'] = 0;
                $paginate['onPage'] = 0;
            }
            $datas['paginate'] = $paginate;
        }
        return $datas;
    }

    public function homePageAdverts($count = 5) {
        $data['conditions']['Advertisement.show_in_homepage'] = 1;
        $data['conditions']['Advertisement.visibility'] = 'show';
        $data['conditions']['Advertisement.status'] = 'active';
        $data['limit'] = $count;
        $data['order'] = 'rand()';
        return $this->advertList($data, false);
    }

    public function myAdverts($page = 1, $count = 25) {
        $userId = CakeSession::read('User.Id');
        $data['conditions']['Advertisement.householder_s_id'] = $userId;
        $data['limit'] = $count;
        $data['page'] = $page;
        $data['order'] = 'created desc';
        return $this->advertList($data, true);
    }

    public function lastBooksAdverts($count = 5) {
        $results = $this->query('SELECT advert_id, booking_id, min(active_date) active_date
        FROM (SELECT db.advert_id,
               dbd.booking_id,
               cast(
                  fn_get_property(dbd.booking_detail, "date=>") AS datetime)
                  AS active_date
              FROM    dt_booking_details dbd
               JOIN
                  dt_booking db
               ON dbd.booking_id = db.booking_id
         WHERE dbd.detail_class_id = 127
        ORDER BY dbd.booking_detail_id DESC
         LIMIT 30) last_booking group by booking_id order by active_date desc');
        $i = 0;
        $adverts = array();
        foreach ($results as $result) {
            if ($i < $count) {
                $advert = $this->advertData($result['last_booking']['advert_id']);
                if ($advert['Advertisement']['status'] == 'active') {
                    $i = $i + 1;
                    $adverts[] = $advert;
                }
            }
        }
        return $adverts;
    }

    public function similarAdverts($advertId, $count = 5) {
        $results = $this->query('SELECT advert_id, booking_id, min(active_date) active_date
        FROM (SELECT db.advert_id,
               dbd.booking_id,
               cast(
                  fn_get_property(dbd.booking_detail, "date=>") AS datetime)
                  AS active_date
              FROM    dt_booking_details dbd
               JOIN
                  dt_booking db
               ON dbd.booking_id = db.booking_id
         WHERE dbd.detail_class_id = 127
        ORDER BY dbd.booking_detail_id DESC
         LIMIT 30) last_booking group by booking_id order by active_date desc');
        $i = 0;
        $adverts = array();
        foreach ($results as $result) {
            if ($i < $count) {
                $advert = $this->advertData($result['last_booking']['advert_id']);
                if ($advert['Advertisement']['status'] == 'active') {
                    $i = $i + 1;
                    $adverts[] = $advert;
                }
            }
        }
        return $adverts;
    }

    public function getAdvertDetails($result) {

        $advertsText = $this->AdvertsText->getAdvertText($result['Advertisement']['advert_id']);
        $advertsMinPrice = $this->ExceptionRate->advertMinPrice($result['Advertisement']['advert_id']);

        if (($advertsMinPrice['demand'] > $result['Advertisement']['demand'] && $advertsMinPrice['notSetDays'] > 1) || $advertsMinPrice['demand'] == 0)
            $advertsMinPrice = $result['Advertisement']['demand'];
        else
            $advertsMinPrice = $advertsMinPrice['demand'];

        $multiplier = $this->convertCurrency($result['Advertisement']['currency_id']);
        $result['Advertisement']['title'] = $advertsText['title'];
        $result['Advertisement']['description'] = $advertsText['description'];
        $result['Advertisement']['details'] = unserialize(str_replace('s:1:""', 's:1:" "', $result['Advertisement']['details']));
        $result['Advertisement']['conditions'] = unserialize(str_replace('s:1:""', 's:1:" "', $result['Advertisement']['conditions']));
        $result['Advertisement']['standPrice'] = $this->priceRound($advertsMinPrice * $multiplier['multiplier'] * $this->advertSalesRatio($result['Advertisement']['advert_id']));
        $result['Advertisement']['standCurrency'] = $multiplier['Currency'];
        $result['Advertisement']['houseHolder'] = $this->HouseHolder->userData($result['Advertisement']['householder_s_id']);
        $result['Advertisement']['advertClass'] = $this->AdvertClass->idToMessageTextId($result['Advertisement']['advert_class_id']);
        $result['Advertisement']['currency'] = $this->CurrencyUnit->idToMessageTextId($result['Advertisement']['currency_id']);
        $result['Advertisement']['country'] = $this->Country->idToMessageTextId($result['Advertisement']['country_id']);
        $result['Advertisement']['city'] = $this->City->idToMessageTextId($result['Advertisement']['city_id']);
        $result['Advertisement']['county'] = $this->County->idToMessageTextId($result['Advertisement']['county_id']);
        $result['Advertisement']['neighborhood'] = $this->Neighborhood->idToMessageTextId($result['Advertisement']['neighborhood_id']);
        $result['Advertisement']['geoLocation'] = $this->propertiesToArray($result['Advertisement']['geoLocation']);
        $pictures = unserialize(str_replace('s:1:""', 's:1:" "', $result['Advertisement']['picture']));
        foreach ($pictures as $key => $picture) {
            $pictures[$key]['path'] = '/resimler/' . urlencode($result['Advertisement']['city']) . '-' . urlencode($result['Advertisement']['county']) . '/' . $result['Advertisement']['advert_id'] . '/' . str_replace('_', '-', urlencode($picture['label'])) . '_640_480_' . $picture['name'];
            $pictures[$key]['thumb'] = '/resimler/' . urlencode($result['Advertisement']['city']) . '-' . urlencode($result['Advertisement']['county']) . '/' . $result['Advertisement']['advert_id'] . '/' . str_replace('_', '-', urlencode($picture['label'])) . '_300_225_' . $picture['name'];
            $pictures[$key]['scrool'] = '/resimler/' . urlencode($result['Advertisement']['city']) . '-' . urlencode($result['Advertisement']['county']) . '/' . $result['Advertisement']['advert_id'] . '/' . str_replace('_', '-', urlencode($picture['label'])) . '_128_96_' . $picture['name'];
        }
        $result['Advertisement']['link'] = array('controller' => 'Advertisements',
            'action' => 'advert',
            $result['Advertisement']['city'],
            $result['Advertisement']['county'],
            $result['Advertisement']['neighborhood'],
            $result['Advertisement']['advert_id'],
            $result['Advertisement']['title']['tur']);
        switch (rand(1, 3)) {
            case 1:

                $color = 'red';
                break;
            case 2:

                $color = 'green';
                break;
            case 3:

                $color = 'orange';
                break;
        }
        $result['Advertisement']['color'] = $color;

        $result['Advertisement']['picture'] = $pictures;

        return $result;
    }

    public function saveQuickAdvert($data) {
        $user = $this->basicUserRegisterLogin($data);
        if ($user['success']) {
            $userId = $user['userId'];
            //$category = $data['Advertisement']['type'];
            //$advert = $this->query('SELECT fn_advert_add(' . $userId . ',' . $category . ') advert_id');
            //$save['advert_id'] = $advert['0']['0']['advert_id'];

            $save['advert_class_id'] = $data['Advertisement']['type'];
            $save['max_guests'] = $data['Advertisement']['maxGuests'];
            $save['householder_s_id'] = $userId;
            $save['demand'] = $data['Advertisement']['demand'];
            $save['currency_id'] = $data['Advertisement']['currency'];
            $save['country_id'] = $data['Advertisement']['country'];
            $save['city_id'] = $data['Advertisement']['city'];
            $save['county_id'] = $data['Advertisement']['district'];
            $save['neighborhood_id'] = $data['Advertisement']['subDistrict'];
            $save['subDistrict_text'] = $data['Advertisement']['subDistrictText'];
            $save['address'] = $data['Advertisement']['address'];
            $save['geoLocation'] = $data['Advertisement']['geoLocation'];
            $save['postCode'] = $data['Advertisement']['postCode'];
            $save['picture'] = serialize($data['Uploads']);
            $save['status'] = 'passive';
            /* $phoneNumber = array();
              $phoneNumber['phoneCountryCode'] = $data['Advertisement']['phoneCountryCode'];
              $phoneNumber['phoneNumber'] = $data['Advertisement']['phoneNumber'];
              $save['phoneNumber'] = serialize($phoneNumber); */
            $this->save($save);
            $result['advertId'] = $this->getInsertID();
            $result['success'] = TRUE;
            $this->query('INSERT INTO dt_advert_texts(language_id,
                                                        advert_id,
                                                        title,
                                                        description)
                                                        VALUES (' . $this->getLanguageId() . ',
                                                        ' . $result['advertId'] . ',
                                                        "' . $data['Advertisement']['title'] . '",
                                                        "' . $data['Advertisement']['description'] . '")');


            $this->query('INSERT INTO dt_booking (booking_id,advert_id,start_date,end_date,booking_date,renter_user_s_id,lessor_user_s_id,status) VALUES (CONCAT(' . $result['advertId'] . ',"-",999 ) ,' . $result['advertId'] . ',"2000-01-01","2000-01-02","2000-01-01",0,0,"system");
                          INSERT INTO dt_booking (booking_id,advert_id,start_date,end_date,booking_date,renter_user_s_id,lessor_user_s_id,status) VALUES (CONCAT(' . $result['advertId'] . ',"-",1000) ,' . $result['advertId'] . ',"2100-01-01","2100-01-02","2000-01-01",0,0,"system");');

            $result['userId'] = $user['userId'];
            if (isset($user['confirmCode']))
                $result['confirmCode'] = $user['confirmCode'];
        } else {
            $result['success'] = FALSE;
            $result['messageTextId'] = $user['message_text_id'];
        }
        return $result;
    }

    public function updateAdvertBaseDetails($data) {
        if (isset($data['Advertisement']['advertId'])) {
            $langId = $this->getLanguageId();
            $conditions = array();
            $conditions['conditions']['advert_id'] = $data['Advertisement']['advertId'];
            $conditions['conditions']['language_id'] = $langId;
            $text = $this->AdvertsText->find('first', $conditions);
            $save = array();
            if ($text['AdvertsText']['title'] != $data['Advertisement']['title'] ||
                    $text['AdvertsText']['description'] != $data['Advertisement']['description']) {
                $update = array();
                if (isset($text['AdvertsText']['advert_text_id']))
                    $update['advert_text_id'] = $text['AdvertsText']['advert_text_id'];
                $update['advert_id'] = $data['Advertisement']['advertId'];
                $update['Alanguage_id'] = $langId;
                $update['title'] = $data['Advertisement']['title'];
                $update['description'] = $data['Advertisement']['description'];
                $this->AdvertsText->save($update);
                $save['status'] = 'passive';
            }

            $save['advert_id'] = $data['Advertisement']['advertId'];
            $save['advert_class_id'] = $data['Advertisement']['type'];
            $save['max_guests'] = $data['Advertisement']['maxGuests'];
            $save['demand'] = $data['Advertisement']['demand'];
            $save['currency_id'] = $data['Advertisement']['currency'];
            if ($text['AdvertsText']['title'] != $data['Advertisement']['title'] ||
                    $text['AdvertsText']['description'] != $data['Advertisement']['description'])
                $save['status'] = 'passive';

            $this->save($save);

            $result['success'] = TRUE;
            $result['messageTextId'] = 'advert_base_details_updated';
        } else {
            $result['success'] = FALSE;
            $result['messageTextId'] = 'advert_base_details_not_updated';
        }

        $result['message'] = __($result['messageTextId']);
        return $result;
    }

    public function updateAdvertLocationDetails($data) {
        if (isset($data['Advertisement']['advertId'])) {
            $save['advert_id'] = $data['Advertisement']['advertId'];
            $save['country_id'] = $data['Advertisement']['country'];
            $save['city_id'] = $data['Advertisement']['city'];
            $save['county_id'] = $data['Advertisement']['district'];
            $save['neighborhood_id'] = $data['Advertisement']['subDistrict'];
            $save['subDistrict_text'] = $data['Advertisement']['subDistrictText'];
            $save['address'] = $data['Advertisement']['address'];
            $save['geoLocation'] = $data['Advertisement']['geoLocation'];
            $save['postCode'] = $data['Advertisement']['postCode'];
            $this->save($save);
            $result['success'] = TRUE;
            $result['messageTextId'] = 'advert_location_details_updated';
        } else {
            $result['success'] = FALSE;
            $result['messageTextId'] = 'advert_location_details_not_updated';
        }

        $result['message'] = __($result['messageTextId']);
        return $result;
    }

    public function addUpdateDetails($data) {
        if (isset($data['Advertisement']['advertId'])) {
            $save['advert_id'] = $data['Advertisement']['advertId'];
            $save['details'] = serialize($data['Advertisement']['details']);
            $this->save($save);
            $result['success'] = TRUE;
            $result['messageTextId'] = 'advert_details_updated';
        } else {
            $result['success'] = FALSE;
            $result['messageTextId'] = 'advert_details_not_updated';
        }

        $result['message'] = __($result['messageTextId']);
        return $result;
    }

    public function updateAdvertConditions($data) {
        if (isset($data['Advertisement']['advertId'])) {
            $save['advert_id'] = $data['Advertisement']['advertId'];
            $save['conditions'] = serialize($data['Advertisement']['conditions']);
            $save['min_stay'] = $data['Advertisement']['conditions']['rentalPeriod']['Min'];
            $this->save($save);
            $result['success'] = TRUE;
            $result['messageTextId'] = 'advert_conditions_updated';
        } else {
            $result['success'] = FALSE;
            $result['messageTextId'] = 'advert_conditions_not_updated';
        }

        $result['message'] = __($result['messageTextId']);
        return $result;
    }

    public function updateAdvertConditionalPricing($data) {
        if (isset($data['Advertisement']['advertId'])) {
            $save['advert_id'] = $data['Advertisement']['advertId'];
            $save['guests_included_in_the_demand'] = $data['Advertisement']['guests_included_in_the_demand'];
            $save['extra_charge_per_guest'] = $data['Advertisement']['extra_charge_per_guest'];
            $save['weekend_demand'] = $data['Advertisement']['weekend_demand'];
            $save['deposit_damage'] = $data['Advertisement']['deposit_damage'];
            $save['cleaning_price'] = $data['Advertisement']['cleaning_price'];
            $save['weekly_discount_rate'] = $data['Advertisement']['weekly_discount_rate'];
            $save['monthly_discount_rate'] = $data['Advertisement']['monthly_discount_rate'];
            $this->save($save);
            $result['success'] = TRUE;
            $result['messageTextId'] = 'advert_conditional_pricing_updated';
        } else {
            $result['success'] = FALSE;
            $result['messageTextId'] = 'advert_conditional_pricing_not_updated';
        }

        $result['message'] = __($result['messageTextId']);
        return $result;
    }

    public function updateAdvertVisibility($data) {
        if (isset($data['Advertisement']['advertId'])) {
            $save['advert_id'] = $data['Advertisement']['advertId'];
            $save['visibility'] = $data['Advertisement']['visibility'];
            $this->save($save);
            $result['success'] = TRUE;
            $result['messageTextId'] = 'advert_visibility_updated';
        } else {
            $result['success'] = FALSE;
            $result['messageTextId'] = 'advert_visibility_not_updated';
        }

        $result['message'] = __($result['messageTextId']);
        return $result;
    }

    public function addUpdatePictures($data) {
        if (isset($data['Advertisement']['advertId'])) {
            $save['advert_id'] = $data['Advertisement']['advertId'];
            $save['picture'] = serialize($data['Uploads']);
            $save['status'] = 'passive';
            $this->save($save);
            $result['success'] = TRUE;
            $result['messageTextId'] = 'advert_pictures_updated';
        } else {
            $result['success'] = FALSE;
            $result['messageTextId'] = 'advert_pictures_not_updated';
        }

        $result['message'] = __($result['messageTextId']);
        return $result;
    }

    function controlImages() {
        return is_array($this->data["Advertisement"]['images']);
    }

    function getAdvertSchedule($advertId, $monthCountToShow = 12) {
        $startDate = getdate();
        $startDate['mday'] = 1;
        $startDateTime = mktime(0, 0, 0, $startDate['mon'], $startDate['mday'], $startDate['year']);
        $endDateTime = mktime(0, 0, 0, $startDate['mon'] + $monthCountToShow, 0, $startDate['year']);

        $endDate = date("Y-m-d", $endDateTime);
        $startDate = date("Y-m-d", $startDateTime);

        $params = array();
        $params['conditions']['Booking.advert_id'] = $advertId;
        $params['conditions']['Booking.start_date <='] = $endDate;
        $params['conditions']['Booking.end_date >='] = $startDate;
        $params['conditions']['Booking.status'] = 'active';
        $params['order'] = 'Booking.start_date';
        $params['recursive'] = -1;
        $booking = $this->Booking->find('all', $params);

        $currentDate = $startDate;
        $monthData = array();
        while ($currentDate != $endDate) {
            $monthData[$currentDate]['day'] = $currentDate;
            $monthData[$currentDate]['isDayAveliable'] = 1;
            $monthData[$currentDate]['isDayStartDay'] = 0;
            $monthData[$currentDate]['isDayEndDay'] = 0;




            $onDate = strtotime($currentDate);
            foreach ($booking as $value) {
                $value = $value['Booking'];
                $sDate = strtotime($value['start_date']);
                $eDate = strtotime($value['end_date']);
                if ($onDate >= $sDate && $onDate <= $eDate) {
                    if ($onDate == $sDate)
                        $monthData[$currentDate]['isDayStartDay'] = 1;
                    elseif ($onDate == $eDate)
                        $monthData[$currentDate]['isDayEndDay'] = 1;

                    $monthData[$currentDate]['isDayAveliable'] = 0;
                }
            }


            if ($monthData[$currentDate]['isDayEndDay'] == 1 && $monthData[$currentDate]['isDayStartDay'] == 0)
                $monthData[$currentDate]['isDayAveliable'] = 1;
            $monthData[$currentDate]['isDayNotAveliable'] = 1 - $monthData[$currentDate]['isDayAveliable'];

            $currentDate = date("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
        }
        return $monthData;
    }

// düzenle !!!!!!.....
    public function addAdminNote($adverId, $userId, $note) {
        //  $results = $this->query('CALL prt_advert_detail_add(' . $userId . ' , ' . $adverId . ' ,124, concat("date=>",now(),"[|]","user_s_id=>",' . $userId . ',"[|]note=>",\'' . $note . '\'))');
        return $results;
    }

    public function deleteAdminNote($advertDetailId) {
        //$results = $this->query('UPDATE dt_advert_details SET advert_detail = CONCAT(advert_detail,"[|]deleted=>true") WHERE advert_detail_id =' . $advertDetailId);
        return $results;
    }

    public function getAdminNotes($advertId) {
        $results = $this->query('select * from dt_advert_details dad JOIN vw_users vu on dad.advert_detail like concat("%user_s_id=>",vu.user_s_id,"[|]%") and detail_class_id = 124 WHERE dad.advert_id=' . $advertId);
        $a = array();
        foreach ($results as $result) {

            $result['details'] = $this->parseProperties($result['dad']['advert_detail']);
            $a[] = $result;
        }
        return $a;
    }

    public function setAdvertTop($advert) {
        $this->query('update dt_adverts SET on_top_date = NOW() WHERE advert_id =' . $advert);
    }

    public function getAdvertLogs($advert, $limit = 0) {
        if ($limit == 0)
            $results = $this->query('select * from vw_adverts_log where advert_id = ' . $advert . ' order by date desc');
        else
            $results = $this->query('select * from vw_adverts_log where advert_id = ' . $advert . ' order by date desc limit ' . $limit);

        return $results;
    }

// !!!!!!!! düzenleme son
    public function getTotalWaitingForAprovals() {
        $result = $this->query('select count(*) from dt_adverts where status IN ("passive","waiting_for_approval")');
        return $result['0']['0']['count(*)'];
    }

    public function calculatePrice($data) {
        $advertId = $data['advertId'];
        $checkInDate = $this->formatFormDateToMySQLDate($data['checkInDate']);
        $checkOutDate = $this->formatFormDateToMySQLDate($data['checkOutDate']);
        $startDate = strtotime($data['checkInDate']);
        $endDate = strtotime($data['checkOutDate']);
        $guestCount = $data['totalGuests'];
        $currDate = $startDate;
        $totalNights = ($endDate - $startDate) / 86400;
        $price = array();
        $price['Conflicting'] = $this->bookConflicting($advertId, $checkInDate, $checkOutDate);
        $price['booking_id'] = '';
        $price['booking_price'] = 0;
        $price['currency_unit'] = '';
        $price['min_stay_nights'] = 0;
        $price['total_nights'] = $totalNights;
        $price['discountType'] = '';
        $price['houseHolder']['total'] = 0;
        $price['houseHolder']['lastTotal'] = 0;
        $price['houseHolder']['guestExtraCharge'] = 0;
        $price['houseHolder']['discount'] = 0;
        $price['houseHolder']['currency'] = '';
        $price['site']['total'] = 0;
        $price['site']['lastTotal'] = 0;
        $price['site']['guestExtraCharge'] = 0;
        $price['site']['discount'] = 0;
        $price['site']['currency'] = '';
        /* G�nl�k fiyatlar */
        do {
            $currPrice = $this->advertDemand($advertId, date('Y-m-d', $currDate));
            $price['Dates'][date('Y-m-d', $currDate)] = $currPrice;
            $price['houseHolder']['total'] = $price['houseHolder']['total'] + $currPrice['demand'];
            $price['site']['total'] = $price['site']['total'] + $currPrice['demandView'];
            $price['houseHolder']['currency'] = $currPrice['demandCurrency'];
            $price['site']['currency'] = $currPrice['demandViewCurrency'];
            $currDate = strtotime('+1 day', $currDate);
        } while ($currDate < $endDate);
        $guest = $this->advertExtraChargePerGuest($advertId);
        /* Ki�i Ba�� fiyatlar */
        if ($guest['extraChargePerGuestView'] > 0 && $guestCount > $guest['guestsIncludedInTheDemand']) {
            $price['site']['guestExtraCharge'] = ($guestCount - $guest['guestsIncludedInTheDemand']) * $guest['extraChargePerGuestView'] * $totalNights;
            $price['houseHolder']['guestExtraCharge'] = ($guestCount - $guest['guestsIncludedInTheDemand']) * $guest['extraChargePerGuest'] * $totalNights;
            $price['houseHolder']['total'] = $price['houseHolder']['total'] + $price['houseHolder']['guestExtraCharge'];
            $price['site']['total'] = $price['site']['total'] + $price['site']['guestExtraCharge'];
        }
        /* Ayl�k haftal�k indirim */
        if ($guest['monthlyDiscountRate'] > 0 && $guest['monthlyDiscountRate'] > $guest['weeklyDiscountRate'] && $totalNights > 27) {
            $price['houseHolder']['discount'] = $this->priceRound($price['houseHolder']['total'] * $guest['monthlyDiscountRate'] / 100);
            $price['discountType'] = 'monthly';
            $price['site']['discount'] = $this->priceRound($price['site']['total'] * $guest['monthlyDiscountRate'] / 100);
        } elseif ($guest['weeklyDiscountRate'] > 0 && $totalNights > 6) {
            $price['houseHolder']['discount'] = $this->priceRound($price['houseHolder']['total'] * $guest['weeklyDiscountRate'] / 100);
            $price['discountType'] = 'weekly';
            $price['site']['discount'] = $this->priceRound($price['site']['total'] * $guest['weeklyDiscountRate'] / 100);
        }

        $price['min_stay_nights'] = $guest['minStay'];
        $price['houseHolder']['lastTotal'] = $price['houseHolder']['total'] - $price['houseHolder']['discount'];
        $price['site']['lastTotal'] = $price['site']['total'] - $price['site']['discount'];
        $price['booking_price'] = $price['site']['lastTotal'];
        $price['currency_unit'] = $price['site']['currency'];

        return $price;
    }

    public function advertDemand($advertId, $date) {
        $result = array();
        $exception = $this->query('select demand , exception_text from dt_advert_exception_rates where advert_id = ' . $advertId . ' and "' . $date . '" between start_date and end_date');
        $advert = $this->advertBaseData($advertId);
        $multiplier = $this->convertCurrency($advert['Advertisement']['currency_id']);
        if (isset($exception['0']['dt_advert_exception_rates']['demand'])) {
            $result['demand'] = $exception['0']['dt_advert_exception_rates']['demand'];
            $result['demandCurrency'] = $this->getCurrencySymboll($advert['Advertisement']['currency_id']);
            $result['demandView'] = $this->priceRound($multiplier['multiplier'] * $exception['0']['dt_advert_exception_rates']['demand'] * $this->advertSalesRatio($advertId));
            $result['demandViewCurrency'] = $multiplier['Currency'];
            $result['text'] = $exception['0']['dt_advert_exception_rates']['exception_text'];
        } else {
            if (date("w", strtotime($date)) > 4 && $advert['Advertisement']['weekend_demand'] > 0) {
                $result['demand'] = $advert['Advertisement']['weekend_demand'];
                $result['demandCurrency'] = $this->getCurrencySymboll($advert['Advertisement']['currency_id']);
                $result['demandView'] = $this->priceRound($multiplier['multiplier'] * $advert['Advertisement']['weekend_demand'] * $this->advertSalesRatio($advertId));
                $result['demandViewCurrency'] = $multiplier['Currency'];
                $result['text'] = 'weekend';
            } else {
                $result['demand'] = $advert['Advertisement']['demand'];
                $result['demandCurrency'] = $this->getCurrencySymboll($advert['Advertisement']['currency_id']);
                $result['demandView'] = $this->priceRound($multiplier['multiplier'] * $advert['Advertisement']['demand'] * $this->advertSalesRatio($advertId));
                $result['demandViewCurrency'] = $multiplier['Currency'];
                $result['text'] = 'norm';
            }
        }
        return $result;
    }

    public function advertSalesRatio($advertId = null) {
        $ratio = $this->advertRatio($advertId);
        $return = 1 + ($ratio / (100 - $ratio));
        return $return;
    }

    public function advertRatio($advertId = null) {
        if (isset($advertId)) {
            $advert = $this->advertBaseData($advertId);
            if ($advert['Advertisement']['rate'] > 2)
                $return = $advert['Advertisement']['rate'];
            else {
                $houseHolder = $this->HouseHolder->userData($advert['Advertisement']['householder_s_id']);
                if (isset($houseHolder['User']['rate']))
                    if ($houseHolder['User']['rate'] > 2) {
                        $return = $houseHolder['User']['rate'];
                    } else {
                        $return = $this->getGlobalRate();
                    }
                else
                    $return = $this->getGlobalRate();
            }
        } else {
            $return = $this->getGlobalRate();
        }
        return $return;
    }

    public function calculatePriceByHouseDemand($demand, $advertId = NULL) {
        $sellPrice = $this->priceRound($demand * $this->advertSalesRatio($advertId));
        return $sellPrice;
    }

    public function calculateHouseDemandBySellPrice($sellPrice, $advertId = NULL) {
        $demand = $this->priceRound2($sellPrice / $this->advertSalesRatio($advertId));
        return $demand;
    }

    public function guestCountAndPriceOptions($advertId) {
        $guest = $this->advertExtraChargePerGuest($advertId);

        $options = array();
        for ($i = 1; $i <= $guest['maxGuests']; $i++) {
            if ($guest['extraChargePerGuestView'] > 0 && $i > $guest['guestsIncludedInTheDemand'])
                $options[$i] = $i . __('_person') . ' + ' . (($i - $guest['guestsIncludedInTheDemand']) * $guest['extraChargePerGuestView'] ) . ' ' . $guest['currency'];
            else
                $options[$i] = $i . ' ' . __('_person');
        }
        return $options;
    }

    public function advertExtraChargePerGuest($advertId) {
        $result = $this->advertData($advertId);
        $multiplier = $this->convertCurrency($result['Advertisement']['currency_id']);
        $guest = array();
        $guest['monthlyDiscountRate'] = $result['Advertisement']['monthly_discount_rate'];
        $guest['weeklyDiscountRate'] = $result['Advertisement']['weekly_discount_rate'];
        $guest['maxGuests'] = $result['Advertisement']['max_guests'];
        $guest['minStay'] = $result['Advertisement']['min_stay'];
        $guest['guestsIncludedInTheDemand'] = $result['Advertisement']['guests_included_in_the_demand'];
        $guest['extraChargePerGuest'] = $result['Advertisement']['extra_charge_per_guest'];
        $guest['multiplier'] = $multiplier['multiplier'];
        $guest['currency'] = $multiplier['Currency'];


        if ($guest['extraChargePerGuest'] > 0 && $guest['maxGuests'] > $guest['guestsIncludedInTheDemand'])
            $guest['extraChargePerGuestView'] = $this->priceRound($guest['multiplier'] * $guest['extraChargePerGuest'] * $this->advertSalesRatio($advertId));
        else
            $guest['extraChargePerGuestView'] = 0;
        return $guest;
    }

}