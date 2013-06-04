<?php
App::uses('Sanitize', 'Utility');
class BookingFanoutsController extends AppController {

    public $name = 'BookingFanouts';
    public $helpers = array('Thickbox', 'DatePicker','Number');

    public function index($bookingNo=NULL,$advertId = null)
    {
       
        if ($this->request->is('post')) 
        {
                $this->request->data['BookingFanout']['last_modified_user_s_id'] = CakeSession::read('User.Id');
                $this->request->data['BookingFanout']['transaction_date'] = $this->BookingFanout->formatFormDateToMySQLDate($this->request->data['BookingFanout']['transaction_date']);
                if (!isset($this->request->data['BookingFanout']['booking_fanout_id'])) {
                    $this->request->data['BookingFanout']['created_user_s_id'] = CakeSession::read('User.Id');
                    if (!$this->bookingPermissions['lp_booking_add_fanouts']) {
                        echo 'Hesap özeti ekleme yetkiniz yok';
                        exit;
                    }
                } else {
                    if (!$this->bookingPermissions['lp_booking_edit_all_fanouts']) {
                        echo 'Hesap özeti düzenleme yetkiniz yok';
                        exit;
                    }
                    if ($this->request->data['BookingFanout']['status'] == 'deleted' && !$this->bookingPermissions['lp_booking_delete_all_fanouts']) {
                        echo 'Hesap özeti silme yetkiniz yok';
                        exit;
                    }
                }
            
            

        

                if ($this->request->data['BookingFanout']['transaction_type_id'] == '3') {
                    $result = $this->BookingFanout->find('all', array('conditions' => array('TransactionType.transaction_type_id' => '3', 'BookingFanout.booking_id' => $bookingNo, 'NOT' => array('BookingFanout.status' => 'deleted'))));
                    if (!(count($result) == 0)) {
                        if (isset($this->request->data['BookingFanout']['booking_fanout_id'])) {
                            if (!($result['0']['BookingFanout']['booking_fanout_id'] == $this->request->data['BookingFanout']['booking_fanout_id'])) {
                                echo 'Sadece 1 tane ev sahibi booking fiyatı olabilir';
                                exit;
                            }
                        } else {
                            echo 'Sadece 1 tane ev sahibi booking fiyatı olabilir';
                            exit;
                        }
                    }
                }

                if ($this->request->data['BookingFanout']['transaction_type_id'] == '4') {
                    $result = $this->BookingFanout->find('all', array('conditions' => array('TransactionType.transaction_type_id' => '4', 'BookingFanout.booking_id' => $bookingNo, 'NOT' => array('BookingFanout.status' => 'deleted'))));
                    if (!(count($result) == 0)) {
                        if (isset($this->request->data['BookingFanout']['booking_fanout_id'])) {
                            if (!($result['0']['BookingFanout']['booking_fanout_id'] == $this->request->data['BookingFanout']['booking_fanout_id'])) {
                                echo 'Sadece 1 tane müşteri booking fiyatı olabilir';
                                exit;
                            }
                        } else {
                            echo 'Sadece 1 tane müşteri booking fiyatı olabilir';
                            exit;
                        }
                    }
                }
                if ($this->BookingFanout->save($this->request->data)) 
                {
                    if(isset($this->request->data['BookingFanout']['backurl']))
                        $this->redirect($this->request->data['BookingFanout']['backurl']);
                    else
                        $this->redirect(array('action' => 'index/' . $bookingNo . '/'. $advertId));
                }   
                

            }
           
            
            
            if (!$this->bookingPermissions['lp_booking_view_all_fanouts'])
                return;
            
            
            $this->loadModel('Booking');
            $this->loadModel('Advertisement');
            $this->loadModel('BookingListFanout');
            $this->loadModel('User');
            $this->loadModel('TransactionType');
            $this->loadModel('BookingDetail');
            
            
            
            $bookingFanouts = $this->BookingFanout->getBookingFanouts($bookingNo,true);
            $this->set('bookingFanouts', $bookingFanouts);
            $payable = $bookingFanouts['outline']['payable'];
            $paid = $bookingFanouts['outline']['paid'];
            $ourPayable = $bookingFanouts['outline']['ourPayable'];
            $ourPaid = $bookingFanouts['outline']['ourPaid'];
            $ourTotal = $bookingFanouts['outline']['ourTotal'];
            $houseHolderPayable = $bookingFanouts['outline']['houseHolderPayable'];
            $houseHolderPaid = $bookingFanouts['outline']['houseHolderPaid'];
            $customersToHouseholderTotalAmaunt = $bookingFanouts['outline']['customersToHouseholderTotalAmaunt'];
            $totalPrice = $bookingFanouts['outline']['totalPrice'];
            $houseHolderPrice = $bookingFanouts['outline']['houseHolderPrice'];
            $houseHolderToPay = $bookingFanouts['outline']['houseHolderToPay'];
            $activeHouseHolderToPay = $bookingFanouts['outline']['activeHouseHolderToPay'];
            $passiveHouseHolderToPay = $bookingFanouts['outline']['passiveHouseHolderToPay'];
            $grossProfit = $bookingFanouts['outline']['grossProfit'];
            $grossProfitPercent = $bookingFanouts['outline']['grossProfitPercent'];
            $cancellationPayable = $bookingFanouts['outline']['cancellationPayable'];
            $cancellationPaid = $bookingFanouts['outline']['cancellationPaid'];
	    
	    
          
            $this->set('advertDetails',$this->Advertisement->getAdvert($advertId));
            
            $bookingDetail =$this->BookingDetail->getBookingDetails($bookingNo);
           
            if( $ourPaid > 0  && $cancellationPaid == 0)
                $this->Booking->updateBookingStatus($bookingNo,'active');  
            elseif ($cancellationPaid > 0)
                $this->Booking->updateBookingStatus($bookingNo,'cancel');                  
            elseif (isset($bookingDetail['EmailHistory'][0]['DetailsClass']['message_text_id'] ))
                $this->Booking->updateBookingStatus($bookingNo,'passive'); 
            else
                $this->Booking->updateBookingStatus($bookingNo,'pending'); 
                

            

            $results = $this->BookingListFanout->findByBookingId($bookingNo);
        
            $bookingListFanouts = array();
            
            foreach ($results as $key => $result) 
            {
                foreach ($result as $key2 => $data)
                {
                    if (strpos($key2, 'date') === false)
                        $bookingListFanouts[$key][$key2] = $data;
                    else
                        $bookingListFanouts[$key][$key2] = $this->BookingListFanout->formatMySQLDateToFormDate($data);
                }
            }

        
            $this->loadModel('TxUser');
            //$householder = $this->TxUser->getUser( $bookingListFanouts['BookingListFanout']['householder_user_s_id']);
	    $householder = $this->TxUser->userData( $bookingListFanouts['BookingListFanout']['householder_user_s_id']);
	    
	    
            $this->set('householder', $householder);
            $this->set('bookingListFanout',$bookingListFanouts);
            $this->set('bookingNo', $bookingNo);
            $results = $this->BookingFanout->TransactionType->find('list', array('fields' => array('transaction_type_id', 'message_text_id')));
            $bookingFanoutTransactionTypeId = array();
            foreach ($results as $key => $result) {
                $bookingFanoutTransactionTypeId[$key] = __(trim($result));
            }
            
            $results = $this->BookingFanout->BankingAccount->find('list', array('fields' => array('banking_account_id', 'message_text_id')));
            $bookingFanoutBankingAccountId= array();
            foreach ($results as $key => $result) {
                $bookingFanoutBankingAccountId[$key] = __(trim($result));
            }
            

            $this->set('bookingPermissions', $this->bookingPermissions);
            $this->set('bookingDetails', $bookingDetail);
            $this->set('bookingFanoutTransactionTypeId', $bookingFanoutTransactionTypeId);
            $this->set('bookingFanoutBankingAccountId', $bookingFanoutBankingAccountId);
            $this->set('bookingFanoutCurrencyUnitId', $this->BookingFanout->CurrencyUnit->find('list', array('fields' => array('currency_unit_id', 'message_text_id'))));
            


    }
    public function fanout() 
    {

        $this->loadModel('BookingListFanout');


        $this->convertPostDateToGet('DateFilter', array('groupType', 'actionType', 'searhUserId'));

        if (isset($this->request->params['named']['groupType']))
            $groupType = $this->request->params['named']['groupType'];

        if (!isset($groupType))
            $groupType = 'pending';

        if (isset($this->request->params['named']['advertId']))
            $advertId = $this->request->params['named']['advertId'];

        if (isset($this->request->params['named']['searhUserId']))
            $searchUserId = $this->request->params['named']['searhUserId'];

        
        $userId = CakeSession::read('User.Id');

        $conditions = array();

        if (isset($advertId)) {
            $conditions[] = array('advert_id' => array('vw_bookings_fanout.advert_id' => $advertId));
            $this->set('advertId', $advertId);
        }

        if (isset($searchUserId)) {
            $conditions[] = array('OR' => array('householder_user_s_id' => array('vw_bookings_fanout.householder_user_s_id' => $searchUserId), 'renter_user_s_id' => array('vw_bookings_fanout.renter_user_s_id' => $searchUserId)));
            //$this->set('user',$advertId);
            $this->loadModel('TxUser');
            //$selectedUser = $this->User->getUser($searchUserId);
	    $selectedUser = $this->TxUser->userData($searchUserId);
            $this->set('selectedUser', $selectedUser);
        }


        if (isset($groupType)) {
            if ($groupType != '')
                $conditions[] = array('status' => $groupType);

            $this->set('groupType', $groupType);
        }

        if (isset($this->userPermissions['lp_user_is_admin'])) {
            $conditions[] = array('householder_user_s_id != lessor_user_s_id');
        }

        if (isset($this->bookingPermissions['lp_booking_show_my_houses_bookings'])) {
            if (!empty($this->request->params['named'])) {
                if ($this->request->params['named']['actionType'] == 'showMyHousesBookings') {
                    $conditions[] = array('householder_user_s_id' => array('vw_bookings_fanout.householder_user_s_id' => $userId));
                    $conditions[] = array('status' => array('Booking.status' => 'active'));
                }
            }
        }

        $order = array('booking_date' => 'desc');


        if (isset($this->request->data['DateFilter']['filterType'])) 
        {
            $filterType = $this->request->data['DateFilter']['filterType'];
            $startDate = $this->request->data['DateFilter']['startDate'];
            $endDate = $this->request->data['DateFilter']['endDate'];



            if ($startDate != '' || $endDate != '') {
                $filterColumn = '';
                switch ($filterType) {
                    case 'StartDate':
                        $filterColumn = 'start_date';
                        break;
                    case 'EndDate':
                        $filterColumn = 'end_date';
                        break;
                    case 'OperationDate':
                        $filterColumn = 'booking_date';
                        break;
                    case 'LastPaymentToHouseHolder':
                        $filterColumn = 'last_active_householder_payment_date';
                        break;
                    case 'NextPaymentToHouseHolder':
                        $filterColumn = 'first_passive_householder_payment_date';
                        break;
                }
                if ($startDate != '') {
                    $startDate = $this->BookingFanout->formatFormDateToMySQLDate($startDate);
                    $conditions[] = array($filterColumn . ' >' => $startDate);
                    $order = array($filterColumn => 'desc');
                }
                if ($endDate != '') {
                    $endDate = $this->BookingFanout->formatFormDateToMySQLDate($endDate);
                    $conditions[] = array($filterColumn . ' <' => $endDate);
                    $order = array($filterColumn => 'desc');
                }
            }
        }
       
        $this->paginate = array(
            'conditions' => $conditions,
            'limit' => 20,
            'order' => $order
        );

        $results = $this->paginate('BookingListFanout');
	
        $this->set('modelName', 'BookingListFanout');


        $bookingFanouts = array();
        foreach ($results as $key => $result) {
            foreach ($result as $key2 => $result2) {
                foreach ($result2 as $key3 => $data) {
                    if (strpos($key3, 'date') === false || $key3=='booking_date')
                        $bookingFanouts[$key][$key2][$key3] = $data;
                    else
                        $bookingFanouts[$key][$key2][$key3] = $this->BookingFanout->formatMySQLDateToFormDate($data);
                }
            }
        }



        $this->set('bookings', $bookingFanouts);

        if (isset($this->userPermissions['lp_user_is_admin']))
        {
            //$this->set('todaysActiveBookingsTotal',$this->BookingFanout->getTodaysActiveBookingsTotal());
            //$this->set('myTodaysActiveBookingsTotal',$this->BookingFanout->getTodaysActiveBookingsTotal(CakeSession::read('User.Id')));            
            
            
            $todaysActiveBookings = $this->BookingFanout->getTodaysActiveBookings();
            $myTodaysActiveBookings = $this->BookingFanout->getTodaysActiveBookings(CakeSession::read('User.Id'));
            $this->set('todaysActiveBookings',$todaysActiveBookings);
            $this->set('myTodaysActiveBookings',$myTodaysActiveBookings);       
            
            $this->set('todaysActiveBookingsTotal',count($todaysActiveBookings));
            $this->set('myTodaysActiveBookingsTotal',count($myTodaysActiveBookings));    
        }
    }
    function addAdminNote()
    {
            
        if($this->request->is('post')) 
        {   $this->loadModel('BookingDetail');
            $this->data = Sanitize::clean($this->data, array('encode' => false));
            $note = $this->request->data['AdminNote']['note'];
            $bookingId = $this->request->data['AdminNote']['bookingId'];
            if(isset($note) && trim($note)!='')
                $this->BookingDetail->addBookingNote($bookingId,$note);
            $adminNotes = $this->BookingDetail-> getBookingDetails($bookingId);
            $adminNotes = $adminNotes['Notes'];
            $this->set('adminNotes',$adminNotes);
        }
        
        $this->render('adminNotes');
    }
     function deleteAdminNote()
    {
        if($this->request->is('post')) 
        {   $this->loadModel('BookingDetail');
            $noteId = $this->request->data['AdminNote']['selectedNoteId'];
            $bookingId = $this->request->data['AdminNote']['bookingId'];
            $this->BookingDetail->deleteAdminNote($noteId);
            
            $adminNotes = $this->BookingDetail-> getBookingDetails($bookingId);
            $adminNotes = $adminNotes['Notes'];
            $this->set('adminNotes',$adminNotes);
            
       }
        
        $this->render('adminNotes');
    }  

}