<?php
App::uses('Sanitize', 'Utility');
class BookingsController extends AppController
{
    public $name = 'Bookings';
    public $helpers = array('Number','Thickbox');


    public function afterFilter()
    {
        if(!isset($this->bookingPermissions['lp_booking_admin_list']) && !isset($this->bookingPermissions['lp_booking_show_my_houses_bookings']))
        {
            $this->Session->setFlash('Lütfen giriş yapınız.');
            $this->redirect('/users/login');
        }
    }
    
    public function index()
    {
        $this->convertPostDateToGet('DateFilter',array('groupType','actionType','searhUserId'));
        
        
        if(isset($this->request->params['named']['groupType']))
            $groupType = $this->request->params['named']['groupType'];
        
        if(!isset($groupType) && isset($this->userPermissions['lp_user_is_admin']))
            $groupType='pending';
        
        if(isset($this->request->params['named']['advertId']))
            $advertId = $this->request->params['named']['advertId'];
        
        if(isset($this->request->params['named']['searhUserId']))
            $searchUserId = $this->request->params['named']['searhUserId'];        
        
        $userId = CakeSession::read('User.Id');
        $conditions = array();
        //$conditions[] = array('order' => array('week' => 'desc')); 
        
        $conditions = array();
        
        if(isset($advertId))
        {
            $conditions[] = array('advert_id' => array('vw_booking_list.advert_id' => $advertId));  
            $this->set('advertId',$advertId);
        }
        
        if(isset($searchUserId))
        {
            $conditions[] = array('OR'=>array('householder_user_s_id' => array('vw_booking_list.householder_user_s_id' => $searchUserId),'renter_user_s_id' => array('vw_booking_list.renter_user_s_id' => $searchUserId)));  
            //$this->set('user',$advertId);
            $this->loadModel('User');
            $selectedUser = $this->User->getUser($searchUserId);
            $this->set('selectedUser',$selectedUser);
        }        
        
        
        if(isset($groupType))
        {
            if($groupType!='')
                $conditions[] = array('status'=>$groupType);          
            
                $this->set('groupType',$groupType);
            
        }        
        
        if(isset($this->userPermissions['lp_user_is_admin']))
        {
            $conditions[] = array('householder_user_s_id != lessor_user_s_id');            
        }
        
        if(isset($this->bookingPermissions['lp_booking_show_my_houses_bookings']))
        {
            if(!empty($this->request->params['named']))
            {
                if($this->request->params['named']['actionType']=='showMyHousesBookings')  
                {
                    $conditions[] = array('householder_user_s_id' => array('vw_booking_list.householder_user_s_id' => $userId));
                    $conditions[] = array('status' => array('Booking.status' => 'active'));
                }
            }
        }

        

        if(isset($this->request->data['DateFilter']['filterType']))
        {
            $filterType = $this->request->data['DateFilter']['filterType'];
            $startDate = $this->request->data['DateFilter']['startDate'];
            $endDate = $this->request->data['DateFilter']['endDate'];



            if($startDate!='' || $endDate!='')
            {
                $filterColumn = '';
                switch($filterType)
                {
                    case 'StartDate':
                        $filterColumn = 'start_date';
                        break;
                    case 'EndDate':
                        $filterColumn = 'end_date';
                        break;
                    case 'OperationDate':
                        $filterColumn = 'booking_date';
                        break;
                }
                if($startDate!='')
                {
                    $startDate = $this->Booking->formatFormDateToMySQLDate($startDate);
                    $conditions[] = array($filterColumn.' >' => $startDate);                    
                }
                if($endDate!='')
                {
                    $endDate = $this->Booking->formatFormDateToMySQLDate($endDate);
                    $conditions[] = array($filterColumn.' <' => $endDate);                    
                }

            }
        }
        


        
        
        $this->paginate = array(
                                    'conditions'=>$conditions,
                                    'limit' => 20,
                                    'order' => array(
                                    'booking_date' => 'desc'
                                    )
                                );
        
        $results = $this->paginate('Booking');
        
       

        $this->set('modelName','Booking');
        $this->set('bookings',$results);
    }

            
    
    public function confirm($bookingNo)
    {
        $booking = $this->Booking->findByBookingId($bookingNo);
        $this->set('booking', $booking);
        
        $advertId = $booking['Booking']['advert_id'];
        $startDate = $booking['Booking']['start_date'];
        $endDate = $booking['Booking']['end_date'];
        $userId = CakeSession::read('User.Id');
        $customerId = $booking['Booking']['renter_user_s_id'];

        $result =  $this->Booking->query("CALL prt_booking_add(".$userId.",".$advertId.",'".$startDate."','".$endDate."',".$customerId.",'active=>".$bookingNo."')"); 
        
        if($result[0]['lsm']['type']=='success')
        {
            $this->Booking->deleteCache('advert_bookings_'.$advertId, 'monthly');            
            $this->Session->setFlash('#'.$bookingNo.' nolu rezervasyon onaylandı!'); 
        } else
        {
            $this->Session->setFlash('Rezervasyon onaylanırken bir hata oluştu!'); 
        }
        $this->redirect($this->referer());         
    }
    
    public function cancel($bookingNo)
    {
        $booking = $this->Booking->findByBookingId($bookingNo);
        $this->set('booking', $booking);
        
        $advertId = $booking['Booking']['advert_id'];
        $startDate = $booking['Booking']['start_date'];
        $endDate = $booking['Booking']['end_date'];
        $userId = CakeSession::read('User.Id');
        $customerId = $booking['Booking']['renter_user_s_id'];

        $result =  $this->Booking->query("CALL prt_booking_add(".$userId.",".$advertId.",'".$startDate."','".$endDate."',".$customerId.",'passive=>".$bookingNo."')"); 
        
        if($result[0]['lsm']['type']=='success')
        {
            $this->Booking->deleteCache('advert_bookings_'.$advertId, 'monthly');            
            $this->Session->setFlash('#'.$bookingNo.' nolu rezervasyon onayı iptal edildi!'); 
        } else
        {
            $this->Session->setFlash('Rezervasyon onayı iptal edilirken bir hata oluştu!'); 
        }
        $this->redirect($this->referer());                
    }    
    
    public function delete($bookingNo)
    {
        $booking = $this->Booking->findByBookingId($bookingNo);
        $this->set('booking', $booking);
        
        $advertId = $booking['Booking']['advert_id'];
        $startDate = $booking['Booking']['start_date'];
        $endDate = $booking['Booking']['end_date'];
        $userId = CakeSession::read('User.Id');
        $customerId = $booking['Booking']['renter_user_s_id'];

        $result =  $this->Booking->query("CALL prt_booking_add(".$userId.",".$advertId.",'".$startDate."','".$endDate."',".$customerId.",'deleted=>".$bookingNo."')"); 
    
        if($result[0]['lsm']['type']=='success')
        {
            $this->Booking->deleteCache('advert_bookings_'.$advertId, 'monthly');
            $this->Session->setFlash('#'.$bookingNo.' nolu rezervasyon silindi!'); 
        } else
        {
            $this->Session->setFlash('Rezervasyon silinirken bir hata oluştu!'); 
        }
        $this->redirect($this->referer());      
    }    
    
    public function booking($bookingNo,$skin = null)
    {
        $this->set('skin',$skin); 
        $booking = $this->Booking->findByBookingId($bookingNo);
        
	pr($booking);
	
	die;
        $this->loadModel('CurrencyUnit');
        $currencyUnit = $this->CurrencyUnit->findByCurrencyUnitId( $booking['Booking']['currency_unit']);
        $booking['Booking']['currency_unit_text'] = $currencyUnit['CurrencyUnit']['message_text_id'];
	
	
        $this->set('booking', $booking);
        $this->loadModel('BookingFanout');
        if ($this->bookingPermissions['lp_booking_view_all_fanouts']) {
     
        $results = $this->BookingFanout->find('all', array('fields' =>
                    array('BookingFanout.booking_fanout_id',
                        'BookingFanout.booking_id',
                        'BookingFanout.price',
                        'BookingFanout.note',
                        'BookingFanout.created',
                        'BookingFanout.modified',
                        'BookingFanout.status',
                        'TransactionType.transaction_type_id',
                        'TransactionType.is_out',
                        'TransactionType.message_text_id',
                        'CurrencyUnit.currency_unit_id',
                        'CurrencyUnit.message_text_id',
                        'CreatedUser.user_s_id',
                        'CreatedUser.uname',
                        'LastModifiedUser.user_s_id',
                        'LastModifiedUser.uname'),
                    'conditions' =>
                    array('BookingFanout.booking_id' => $bookingNo, 'BookingFanout.status' => 'active')));
        
       $totals = array();
        foreach($results as $result)
        {
            if($result['TransactionType']['message_text_id'] == 'ltt_booking_householder_price')
            {
            $this->set('lttBookingHouseholderPrice', $result);
            }else if($result['TransactionType']['message_text_id'] == 'ltt_booking_costumer_price')
            {
            $this->set('lttBookingCostumerPrice', $result);
            }
            else
            {
                $currencyUnit = $result['CurrencyUnit']['message_text_id'];
                $isout = $result['TransactionType']['is_out'];
                if(isset($totals[$isout][$currencyUnit]))
                {
                    $totals[$isout][$currencyUnit]+= $result['BookingFanout']['price'];
                } else
                {
                    $totals[$isout][$currencyUnit]= $result['BookingFanout']['price'];
                }
            }
            
            
        }
        $this->set('totals', $totals);
        
        }
        $this->loadModel('BookingDetail');
           
        $adminNotes = $this->BookingDetail-> getBookingDetails($bookingNo);
        $adminNotes = $adminNotes['Notes'];
        $this->set('adminNotes',$adminNotes);

        
        $advertId = $booking['Booking']['advert_id'];
        $this->set('advertId',$advertId);
        
        $this->loadModel('Advertisement');
        $advert = $this->Advertisement->advertData($advertId);
        $this->set('advert',$advert);  

        $advertForListItem = $this->Advertisement->advertData($advertId);
        $advertForListItem = $this->parseAdvert($advertForListItem);
       
        
        $this->set('advertForListItem',$advertForListItem);  
        
        $customerId = $booking['Booking']['renter_user_s_id'];
        $houseHolderId = $advert['lcdt_user_id'][1]['detail'];
        $operatorId = $booking['Booking']['lessor_user_s_id'];
        
        $this->loadModel('TxUser');
        $customer = $this->TxUser->getUser($customerId);
        $this->set('customer',$customer);
        
        $houseHolder = $this->TxUser->getUser($houseHolderId);
        $this->set('houseHolder',$houseHolder);
        
        
        $operator = $this->TxUser->getUser($operatorId);
        $this->set('operator',$operator);


        
        $monthCountToShow = 12;
        $startDate = getdate();
        $startDate['mday'] = 1;
        $startDateTime = mktime(0, 0, 0, $startDate['mon'] , $startDate['mday'] , $startDate['year']);
        $startDateStr = date("Y-m-d", $startDateTime);
        
        $endDateTime = mktime(0, 0, 0, $startDate['mon'] + $monthCountToShow , 0 , $startDate['year']);
        $endDateStr = date("Y-m-t", $endDateTime);
        
        if ($skin != 'blank')
        {
            $results = Cache::read('advert_bookings_' . $advertId, 'monthly');
        if (!$results) {
            $results = $this->Booking->query('CALL prt_advert_bookings(' . $advertId . ',"' . $startDateStr . '","' . $endDateStr . '")');
            Cache::write('advert_bookings_' . $advertId, $results, 'monthly');
        }
            
            
            $bookingDays = array();
            foreach($results as $result)
            {
                $dayStr = $result['temp_days']['day'];
                if(!isset($bookingDays[$dayStr]))
                    $bookingDays[$dayStr] = array();

                array_push($bookingDays[$dayStr],$result['temp_days']);
            }

            $this->set('bookingDays',$bookingDays);   
        }
        
    }
    
    public function printBooking($bookingNo)
    {
        $booking = $this->Booking->findByBookingId($bookingNo);
        $this->set('booking', $booking);
        
        $advertId = $booking['Booking']['advert_id'];
        $this->set('advertId',$advertId);
        
        $this->loadModel('Advertisement');
        $advert = $this->Advertisement->getAdvert($advertId);
        $this->set('advert',$advert);  

        
        $customerId = $booking['Booking']['renter_user_s_id'];
        $operatorId = $booking['Booking']['lessor_user_s_id'];
        
        $this->loadModel('User');
        $customer = $this->User->getUser($customerId);
        $this->set('customer',$customer);
        
        $this->layout = 'print';
    }    
    
    
    
    public function sendConfirmMail($bookingNo)
    {
        if(!isset($this->bookingPermissions['lp_booking_sent_confirm_mails']))
        {
            $this->Session->setFlash('Bu işlemi yapma yetkiniz bulunmuyor!'); 
            $this->redirect($this->referer());     
        }
        
        $customerConfirmMessage = $this->sendMail('customerConfirm',$bookingNo);
        $houseHolderConfirmMessage = $this->sendMail('householderConfirm',$bookingNo);
        
        $message = '';
        if($customerConfirmMessage!=false)
        {
            $message.= $customerConfirmMessage.'\n';
        }
        
        if($houseHolderConfirmMessage!=false)
        {
            $message.= $houseHolderConfirmMessage;        
        }
            
        
        if($message!='')
            $this->Session->setFlash($message);
        else
            $this->Session->setFlash("Mail gönderimleri sırasında hatalar oluştu!");
        
        $this->redirect($this->referer());         
    }
    
    
    public function sendInformMail($bookingNo)
    {
        if(!isset($this->bookingPermissions['lp_booking_sent_inform_mail']))
        {
            $this->Session->setFlash('Bu işlemi yapma yetkiniz bulunmuyor!'); 
            $this->redirect($this->referer());     
        }
        
        $customerConfirmMessage = $this->sendMail('customerInform',$bookingNo);
        
        if($customerConfirmMessage)
        {
            $this->Session->setFlash($customerConfirmMessage);
        } else
        {
            $this->Session->setFlash("Mail gönderilemedi! Lütfen tekrar deneyiniz.");
        }
        
        $this->redirect($this->referer()); 
    }
    
    private function sendMail($mailType, $bookingNo)
    {
        $this->loadModel('Advertisement');
        $this->loadModel('User');
        $this->loadModel('BookingFanout');
        
        $booking = $this->Booking->findByBookingId($bookingNo);
        $advertId = $booking['Booking']['advert_id'];
        $operatorUserId = CakeSession::read('User.Id');
        $advert = $this->Advertisement->getAdvert2($advertId);
        $advert = $this->parseAdvert($advert,'vw_get_adverts');
        $customerId = $booking['Booking']['renter_user_s_id'];
        $customer = $this->User->getUser($customerId);
        $houseHolderId = $booking['Booking']['householder_user_s_id'];
        $houseHolder = $this->User->getUser($houseHolderId);
        $bookingFanouts = $this->BookingFanout->getBookingFanouts($bookingNo,false);

        

        
        $bookingMailDetailsString = 'operator_user_id=>'.$operatorUserId;
        switch($mailType)
        {
            case 'customerInform':
                $subject = 'Tatil Evim Ön Rezervasyon Bilgilendirmesi';
                $template = 'booking_inform_customer';
                $mailAdressToSend = $customer['User']['primary_email'];
                $bookingMailDetailId = 'ldc_customer_meta_information_mail';
                break;
            case 'customerConfirm':
                $subject = 'Tatil Evim Kesin Rezervasyon Onayı';
                $template = 'booking_confirm_customer';
                $mailAdressToSend = $customer['User']['primary_email'];
                $bookingMailDetailId = 'ldc_customer_rezervation_confirm_mail';
                break;
            case 'householderConfirm':
                $subject = 'Tatil Evim Kesin Rezervasyon Bilgilendirmesi';
                $template = 'booking_confirm_householder';
                $mailAdressToSend = $houseHolder['User']['primary_email'];
                $bookingMailDetailId = 'ldc_householder_rezervation_confirm_mail';
                break;
        }        
        
        $bookingMailDetailsString .= '[|]email=>' .$mailAdressToSend; 
        App::uses('CakeEmail', 'Network/Email');
        $cakeEmail = new CakeEmail();
        $cakeEmail->config('rezervasyon');
        $cakeEmail->from(array('rezervasyon@tatilevim.com' => 'tatilevim.com'));
        $cakeEmail->to($mailAdressToSend);
        $cakeEmail->subject($subject);
        $cakeEmail->emailFormat('html');
        $cakeEmail->template($template,'blank'); 
        $cakeEmail->helpers(array('Html', 'Number'));
        
        
           
        

        $cakeEmail->viewVars(array('booking' => $booking));
        $cakeEmail->viewVars(array('advert' => $advert));
        $cakeEmail->viewVars(array('customer' => $customer));
        $cakeEmail->viewVars(array('houseHolder' => $houseHolder));
        $cakeEmail->viewVars(array('bookingFanouts' => $bookingFanouts));

        if($cakeEmail->send())
        {
            $this->Booking->query('CALL prt_booking_detail_add(\''.$bookingNo.'\',\''.$bookingMailDetailId.'\',CONCAT(\''.$bookingMailDetailsString.'\',\'[|]status=>successful[|]date=>\',NOW()))');
            return $mailAdressToSend.' adresine #'.$booking['Booking']['booking_id'].' nolu rezervasyon onay maili gönderildi.';
        }
        else
        {
            $this->Booking->query('CALL prt_booking_detail_add(\''.$bookingNo.'\',\''.$bookingMailDetailId.'\',CONCAT(\''.$bookingMailDetailsString.'\',\'[|]status=>failed[|]date=>\',NOW()))');
            return false;
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
?>
