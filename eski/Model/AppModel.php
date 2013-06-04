<?php
App::uses('HttpSocket', 'Network/Http');

class AppModel extends Model {

    public function parseProperties($propertiesString) {
        $propertiesString;
        $a = array();
        if ($propertiesString != '') {
            $properties = explode('[|]', $propertiesString);
            foreach ($properties as $property) {
                $p = explode('=>', $property);
                $p[0] = trim(str_replace("'", "", $p[0]));
                if (count($p) > 1) {
                    $p[1] = trim(str_replace("'", "", $p[1]));
                    $a[trim($p[0])] = $p[1];
                } else {
                    $a[trim($p[0])] = null;
                }
            }
            $properties = $a;
        }
        return $a;
    }

    public function arrayToProperties($data) {
        $properties = '';
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $properties2 = '';
                foreach ($value as $key2 => $value2) {
                    $properties2 = $properties2 . $key2 . '=>' . $value2 . '[||]';
                }
                $properties = $properties . $key . '=>' . trim($properties2, '[||]') . '[|]';
            }
            else
                $properties = $properties . $key . '=>' . $value . '[|]';
        }
        return trim($properties, '[|]');
    }

    public function propertiesToArray($propertiesString) {
        $propertiesString;
        $a = array();
        if ($propertiesString != '' && strpos($propertiesString, "[|]") > 0 && strpos($propertiesString, "=>") > 0) {
            $properties = explode('[|]', $propertiesString);
            foreach ($properties as $property) {
                if (strpos($property, "[||]") > 0) {
                    $p = explode('=>', $property);
                    $key = $p[0];
                    $p = explode($p[0] . '=>', $property);
                    $properties2 = explode('[||]', $p[1]);
                    foreach ($properties2 as $property2) {
                        $p = explode('=>', $property2);
                        $a[$key][$p[0]] = $p[1];
                    }
                } else {
                    $p = explode('=>', $property);
                    $a[$p[0]] = $p[1];
                }
            }
        }
        return $a;
    }

    public function registerNewUser($data) {

        $user = $this->query('CALL prt_user_registration(0,
                           "' . $data['User']['email'] . '",
                           "' . $data['User']['email'] . '",
                           "' . $data['User']['email'] . '",
                           "' . $data['User']['name'] . '",
                           "' . $data['User']['sname'] . '",
                           "' . $data['User']['passwordNew'] . '",
                           "' . $data['User']['passwordCheck'] . '",
                           0,
                           0,
                           "code=>' . $data['User']['phoneCountryCode'] . '[|]number=>' . $data['User']['phoneNumber'] . '",
                           0)');

        $result['confirmCode'] = $user['0']['0']['confirm_code'];
        $result['userId'] = $user['0']['0']['user_s_id'];
        $result['message_text_id'] = $user['0']['lsm']['message_text_id'];
        if ($user['0']['lsm']['type'] == 'success')
            $result['success'] = 1;
        else
            $result['success'] = 0;

        return $result;
    }

    public function basicUserRegisterLogin($data) {

        if (!isset($data['User']['formType']))
            $data['User']['formType'] = '';
        if ($data['User']['formType'] == 'register')
            $user = $this->registerNewUser($data);
        elseif ($data['User']['formType'] == 'login') {
            $user = $this->userLogin($data['User']['uname'], $data['User']['password']);
            $user['userId'] = $user['0']['0']['user_s_id'];
            $user['message_text_id'] = $user['0']['lsm']['message_text_id'];
            if ($user['0']['lsm']['type'] == 'success')
                $user['success'] = 1;
            else
                $user['success'] = 0;
        }
        else {
            if (CakeSession::read('User.Id') == 6) {
                $user['success'] = 0;
                $user['message_text_id'] = 'please_login';
            } else {
                $user['userId'] = CakeSession::read('User.Id');
                $user['success'] = 1;
            }
        }
        return $user;
    }

    public function getCurrencySymboll($id) {
        $result = $this->query('SELECT * FROM lu_currency_unit WHERE currency_unit_id=' . $id);
        return $result[0]['lu_currency_unit']['currency_unit'];
    }

    public function getCurrencyId($symboll) {
        $result = $this->query('SELECT * FROM lu_currency_unit WHERE currency_unit= "' . $symboll . '"');
        return $result[0]['lu_currency_unit']['currency_unit_id'];
    }

    function stringToSlug($str) {
        Inflector::rules('transliteration', array('/Ü/' => 'u'));
        Inflector::rules('transliteration', array('/ü/' => 'u'));
        Inflector::rules('transliteration', array('/Ö/' => 'o'));
        Inflector::rules('transliteration', array('/ö/' => 'o'));
        Inflector::rules('transliteration', array('/ö/' => 'o'));
        $str = Inflector::slug($str, '-');
        $str = strtolower($str);
        return $str;
    }

    function deleteCache($key, $config) {
        Cache::delete($key, $config);
    }

    function formatFormDateToMySQLDate($dateString) {
        if ($dateString != '') {
            $a = explode('-', $dateString);
            return $a[2] . '-' . $a[1] . '-' . $a[0];
        } else
            return '';
    }

    function formatMySQLDateToFormDate($dateString) {

        if ($dateString == NULL || $dateString == '')
            return '';
        else
            return date("d-m-Y", strtotime($dateString));
    }

    public function userLogin($userId, $userPass) {
        return $this->query('call prt_login("' . $userId . '","' . $userPass . '")');
    }

    public function getSubLocations($parentLocationType, $parentLocationId = 0) {
        switch ($parentLocationType) {
            case 'world':
                $detailClassId = 18;
                break;
            case 'country':
                $detailClassId = 13;
                break;
            case 'city':
                $detailClassId = 14;
                break;
            case 'district':
                $detailClassId = 93;
                break;
            case 'subDistrict':
                $detailClassId = 94;
                break;
        }


        $results = $this->query('CALL prt_details_class_content(' . $detailClassId . ',' . $parentLocationId . ')');
        $items[-1] = '-Seçiniz-';
        foreach ($results as $result) {
            $id = $result['content']['id'];
            $text = $result['content']['message_text_id'];
            $items[$id] = $text;
        }
        return $items;
    }

    public function getCurrencyUnitOptions() {
        $results = $this->query('SELECT * FROM lu_currency_unit lcu');
        $items = array();
        foreach ($results as $result) {
            $id = $result['lcu']['currency_unit_id'];
            $text = $result['lcu']['message_text_id'];
            $items[$id] = $text;
        }
        return $items;
    }

    public function convertCurrency($currencyId = NULL, $siteCurrency = NULL) {
        // $siteCurrency = CakeSession::read('Currency.messageTextId');
        if (!isset($currencyId))
            $currencyId = 1;
        if ($siteCurrency == NULL)
            $siteCurrency = '€';
        $multiplier = $this->query('select fn_change_currency(1, message_text_id, "' . $siteCurrency . '") multiplier  from lu_currency_unit where currency_unit_id = ' . $currencyId);
        $result = array();
        $result['Currency'] = $siteCurrency;
        $result['multiplier'] = $multiplier['0']['0']['multiplier'];
        return $result;
    }

    public function addAdvertDetail($advertId, $detailClass, $detail) {
        return $this->query('call prt_add_advert_detail("' . $advertId . '","' . $detailClass . '","' . $detail . '")');
    }

    public function priceRound($pirce) {
        return round($pirce + 0.25);
    }

    public function priceRound2($pirce) {
        return round($pirce - 0.25);
    }

    public function getPayu() {
        $HttpSocket = new HttpSocket();
        $results = $HttpSocket->get('https://secure.payu.com.tr/openpayu/v2/installment_payment.json/get_available_installments/HGOEHFME/100');
        $results = $results->body;
        $results = json_decode($results, true);
        return $results;
    }

    public function bookConflicting($advertId, $startDate, $endDate) {
        $result = $this->query('SELECT fn_booking_control(' . $advertId . ', "' . $startDate . '", "' . $endDate . '") bookingId');
        $return = array();
        $return['bookingId'] = $result['0']['0']['bookingId'];
        if ($return['bookingId'] == 0) {
            $return['success'] = TRUE;
            $return['message_text_id'] = 'do_not_book_the_conflicting';
        } else {
            $return['success'] = FALSE;
            $return['message_text_id'] = 'book_conflicting';
        }


        return $return;
    }

    public function getLanguageId() {
        $lang = CakeSession::read('Config.language');
        switch ($lang) {
            case 'tur':
                $id = 1;
                break;
            case 'eng':
                $id = 2;
                break;
            case 'rus':
                $id = 3;
                break;
            default:
                $id = 1;
                break;
        }
        return $id;
    }

    public function getSellChannels() {
        $options = array();
        $options[1] = __('the_off_season');
        $options[2] = __('have_a_care');
        $options[3] = __('airbnb');
        $options[4] = __('9flats');
        $options[5] = __('booking.com');
        $options[6] = __('sahibinden.com');
        $options[7] = __('hemenkiralik.com');
        $options[8] = __('other');
        return $options;
    }

    public function getGlobalRate() {
        $result = $this->query('SELECT value FROM lu_global_variable lgv where message_text_id = "global_rate" ');
        return $result['0']['lgv']['value'];
    }

    public function convertPayuCurrency($currencyId) {
        $result = array();
        switch ($currencyId) {
            case 1:
                $result['currency'] = 'TRY';
                $result['multiplier'] = 1;
                break;

            case 2:
                $result['currency'] = 'USD';
                $result['multiplier'] = 1;
                break;

            case 3:
                $result['currency'] = 'EUR';
                $result['multiplier'] = 1;
                break;

            case 4:
                $result['currency'] = 'EUR';
                $multiplier = $this->convertCurrency(4, '€');
                $result['multiplier'] = $multiple['multiplier'];
                break;
        }
        return $result;
    }

}