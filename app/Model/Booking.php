<?php

class Booking extends AppModel {

    public $name = 'Booking';
    public $useTable = 'dt_booking';
    public $primaryKey = 'booking_id';
    public $bookValidate = array();
    public $invoiceValidation = array('taxTitle' => array('rule' => 'notEmpty', 'message' => 'not_empty'));
    public $hasMany = array(
        'BookingFanout' => array(
            'className' => 'BookingFanout',
            'foreignKey' => 'booking_id'
        )
    );
/*
    public function updateBookingStatus($bookingNo, $status) {
        $this->recursive = -1;
        $booking = $this->findByBookingId($bookingNo);
        $advertId = $booking['Booking']['advert_id'];
        $startDate = $booking['Booking']['start_date'];
        $endDate = $booking['Booking']['end_date'];
        $customerId = $booking['Booking']['renter_user_s_id'];
        $lessor_user_s_id = $booking['Booking']['lessor_user_s_id'];
        $this->query("CALL prt_booking_add(" . $lessor_user_s_id . "," . $advertId . ",'" . $startDate . "','" . $endDate . "'," . $customerId . ",'$status=>" . $bookingNo . "')");
        $this->deleteCache('advert_bookings_' . $advertId, 'monthly');
    }

    public function getMyBookings($userId, $userPass) {
        $user = $this->userLogin($userId, $userPass);
        $userId = $user['0']['0']['user_s_id'];
        if ($user['0']['lsm']['type'] == 'success') {
            $results = $this->query('select
                                          *
                                        from
                                          vw_bookings_fanout
                                        where
                                          householder_user_s_id = ' . $userId);
        } else {
            return $user['0']['lsm']['message_text_id'];
        }
    }

    public function createNewBooking($data, $price) {
        $advertId = $data['Booking']['advertId'];
        $checkInDate = $this->formatFormDateToMySQLDate($data['Booking']['checkInDate']);
        $checkOutDate = $this->formatFormDateToMySQLDate($data['Booking']['checkOutDate']);
        $conflicting = $this->bookConflicting($advertId, $checkInDate, $checkOutDate);
        $bookingId = 0;
        if ($data['Booking']['userId'] <> 6 && $conflicting['success']) {
            $bookingId = $this->query('select fn_booking_add(
                            ' . CakeSession::read('User.Id') . ',
                            ' . $data['Booking']['userId'] . ',
                            ' . $advertId . ',
                            "pending",
                            "' . $checkInDate . '",
                            "' . $checkOutDate . '") bookingId');
            $bookingId = $bookingId['0']['0']['bookingId'];
            $this->query('select fn_booking_detail_update_or_add(
                            ' . $bookingId . ',
                            71,
                            ' . $data['Booking']['totalGuests'] . ')');
            $price['booking_id'] = $bookingId;
            $price['checkInDate'] = $checkInDate;
            $this->addBookingfanout($price);
        }
        $result = array();
        $result['success'] = $conflicting['success'];
        $result['message_text_id'] = $conflicting['message_text_id'];
        $result['advertId'] = $advertId;
        $result['bookingId'] = $bookingId;
        return $result;
    }

    public function getNewBookingId($advertId) {
        $bookingId = $this->query('SELECT max(convert((TRIM(LEADING "' . $advertId . '-' . '" FROM booking_id)),unsigned)) bookingId FROM dt_booking where advert_id = ' . $advertId);

        if (isset($this->bookingCount))
            $this->bookingCount = $this->bookingCount + 1;
        else
            $this->bookingCount = 1;


        $bookingId = $advertId . '-' . ($bookingId['0']['0']['bookingId'] + $this->bookingCount);
        return $bookingId;
    }

    public function addUpdateBookingInvoice($data) {
        $userId = CakeSession::read('User.Id');
        $result = array();
        $invoice = array();
        $invoice['taxTitle'] = $data['Booking']['taxTitle'];
        $invoice['taxOffice'] = $data['Booking']['taxOffice'];
        $invoice['taxNo'] = $data['Booking']['taxNo'];
        $invoice['taxAddress'] = $data['Booking']['taxAddress'];
        $results = $this->query('UPDATE dt_booking_fanout
                                SET invoice_data = "' . $this->arrayToProperties($invoice) . '",
                                        last_modified_user_s_id =  "' . $userId . '" ,
                                            modified = NOW()
                                WHERE     transaction_type_id = 1
                                    AND booking_id = "' . $data['Booking']['bookingId'] . '"');

        if (is_array($results)) {
            $result['success'] = TRUE;
        } else {
            $result['success'] = FALSE;
            $result['message_text_id'] = 'booking_not_set';
        }

        return $result;
    }

    public function bookingCreditCardDeals($bookingId, $card = NULL) {
        $params = array();
        $params['conditions']['booking_id'] = $bookingId;
        $params['conditions']['transaction_type_id'] = '1';
        $params['conditions']['status'] = 'pending';
        $params['recursive'] = -1;
        $fanout = $this->BookingFanout->find('first', $params);
        $payu = $this->getPayu();
        $currency = $this->convertPayuCurrency($fanout['BookingFanout']['currency_unit_id']);
        $price = $currency['multiplier'] * $fanout['BookingFanout']['price'];
        $id = $fanout['BookingFanout']['booking_fanout_id'];
        $return = array();
        $return['common']['trackId'] = $id;
        $return['common']['eftPrice'] = $price;
        $return['common']['creditCardPrice'] = $this->priceRound($price / 0.965);
        $return['common']['currency'] = $currency['currency'];

        foreach ($payu['value'] as $key => $value) {
            if ($key == $card || $card == NULL)
                foreach ($value as $key2 => $installment) {
                    $return['installment'][$key][$key2]['total'] = $this->priceRound(($price * $installment['total']) / 100);
                    $return['installment'][$key][$key2]['installment'] = round(($return['installment'][$key][$key2]['total'] / $key2) * 100) / 100;
                }
        }
      return $return;
    }

    public function addUpdateBookingPaymentType($data) {
        $userId = CakeSession::read('User.Id');
        $result = array();
        switch ($data['Payment']['type']) {
            case 'eft' : $paymentType = 2;
                break;
      
            default;
                $paymentType = 8;
                ;
        }

        $results = $this->query('UPDATE dt_booking_fanout
                                SET banking_account_id = ' . $paymentType . ',
                                        last_modified_user_s_id =  "' . $userId . '" ,
                                            modified = NOW()
                                WHERE     transaction_type_id = 1
                                    AND booking_id = "' . $data['Booking']['bookingId'] . '"');

        if (is_array($results)) {
            $result['success'] = TRUE;
        } else {
            $result['success'] = FALSE;
            $result['message_text_id'] = 'payment_type_not_set';
        }
        return $result;
    }

    public function addUpdatePayUPaymentResult($data) {
        $userId = CakeSession::read('User.Id');
        $result = array();
        $paymentstr = 8;
        $status = 'active';
        $results = $this->query('UPDATE dt_booking_fanout
                                SET payment_str = "' . $paymentstr . '" ,
                                    status = "' . $paymentstr . '" ,
                                        last_modified_user_s_id =  "' . $userId . '" ,
                                            modified = NOW()
                                WHERE     transaction_type_id = 1 and status <> "active"
                                    AND booking_id = "' . $data['Booking']['bookingId'] . '"');

        if (is_array($results)) {
            $result['success'] = TRUE;
        } else {
            $result['success'] = FALSE;
            $result['message_text_id'] = 'payment_result_not_set';
        }
        return $result;
    }

    public function addBookingfanout($price) {
        $userId = CakeSession::read('User.Id');
        $bookingId = $price['booking_id'];
        $bookingPrice = $price['site']['lastTotal'];
        $bookingPriceCurrency = $this->getCurrencyId($price['site']['currency']);
        $bookingNote = $this->arrayToProperties($price['site']);
        $householderPrice = $price['houseHolder']['lastTotal'];
        $householderPriceCurrency = $this->getCurrencyId($price['houseHolder']['currency']);
        $householderNote = $this->arrayToProperties($price['houseHolder']);


        $this->query('INSERT INTO
                dt_booking_fanout(
                  booking_id
                 ,price
                 ,transaction_type_id
                 ,banking_account_id
                 ,currency_unit_id
                 ,payment_str
                 ,transaction_date
                 ,created_user_s_id
                 ,last_modified_user_s_id
                 ,created
                 ,modified
                 ,status)
              VALUES
                (
                  "' . $bookingId . '"
                 ,' . $householderPrice . '
                 ,3
                 ,0
                 ,' . $householderPriceCurrency . '
                 ,"' . $householderNote . '"
                 ,NOW()
                 ,' . $userId . '
                 ,' . $userId . '
                 ,NOW()
                 ,NOW()
                 ,"active")');

        $this->query('INSERT INTO
                dt_booking_fanout(
                  booking_id
                 ,price
                 ,transaction_type_id
                 ,banking_account_id
                 ,currency_unit_id
                 ,payment_str
                 ,transaction_date
                 ,created_user_s_id
                 ,last_modified_user_s_id
                 ,created
                 ,modified
                 ,status)
              VALUES
                (
                  "' . $bookingId . '"
                 ,' . $bookingPrice . '
                 ,4
                 ,0
                 ,' . $bookingPriceCurrency . '
                 ,"' . $bookingNote . '"
                 ,NOW()
                 ,' . $userId . '
                 ,' . $userId . '
                 ,NOW()
                 ,NOW()
                 ,"active")');



        $this->query('INSERT INTO
                dt_booking_fanout(
                  booking_id
                 ,price
                 ,transaction_type_id
                 ,banking_account_id
                 ,currency_unit_id
                 ,note
                 ,transaction_date
                 ,created_user_s_id
                 ,last_modified_user_s_id
                 ,created
                 ,modified
                 ,status)
              VALUES
                (
                  "' . $bookingId . '"
                 ,' . $bookingPrice . '
                 ,1
                 ,0
                 ,' . $bookingPriceCurrency . '
                 ,""
                 ,NOW()
                 ,' . $userId . '
                 ,' . $userId . '
                 ,NOW()
                 ,NOW()
                 ,"pending")');

        $this->query('INSERT INTO
                dt_booking_fanout(
                  booking_id
                 ,price
                 ,transaction_type_id
                 ,banking_account_id
                 ,currency_unit_id
                 ,note
                 ,transaction_date
                 ,created_user_s_id
                 ,last_modified_user_s_id
                 ,created
                 ,modified
                 ,status)
              VALUES
                (
                  "' . $bookingId . '"
                 ,' . $householderPrice . '
                 ,2
                 ,0
                 ,' . $householderPriceCurrency . '
                 ,""
                 ,"' . $price['checkInDate'] . '"
                 ,' . $userId . '
                 ,' . $userId . '
                 ,NOW()
                 ,NOW()
                 ,"pending")');
    }*/

}