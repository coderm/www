<?php
class BookingDetail extends AppModel
{
    public $name = 'BookingDetail';
    public $useTable = 'dt_booking_details';
    public $primaryKey = 'booking_id';
    public $belongsTo= array(
        'DetailsClass' => array(
            'className' => 'DetailsClass',
            'foreignKey' => 'detail_class_id'
        )
    );
    
    public function getBookingDetails($bookingId)
    { 
        $bookingDetails = $this->findAllByBookingId($bookingId);
            
            $emailHistory = array();
            $notes = array();
            $details = array();
            foreach($bookingDetails as $bookingDetail)
            {
               $messageTextId = $bookingDetail['DetailsClass']['message_text_id'];
               $bookingEmailTextIds = array("ldc_customer_meta_information_mail", "ldc_customer_rezervation_confirm_mail", "ldc_householder_rezervation_confirm_mail");
               $bookingNoteTextId = array("ldc_booking_customer_note","ldc_booking_customer_agent_note");
               if (in_array($messageTextId, $bookingEmailTextIds)) 
               {
                   $bookingDetail['properties'] = $this->parseProperties($bookingDetail['BookingDetail']['booking_detail']);
                   $user = $this->query('select * from vw_users where user_s_id = '.$bookingDetail['properties']['operator_user_id']);
                   $bookingDetail['properties']['user'] = $user['0']['vw_users'];
                   $emailHistory[] = $bookingDetail;
               } elseif (in_array($messageTextId, $bookingNoteTextId)) 
               {
                   
                   $bookingDetail['properties'] = $this->parseProperties($bookingDetail['BookingDetail']['booking_detail']);
                   $user = $this->query('select * from vw_users where user_s_id = '.$bookingDetail['properties']['user_id']);
                   $bookingDetail['properties']['user'] = $user['0']['vw_users'];
                   $notes[] = $bookingDetail;
               } else
               {
                   $details[] = $bookingDetail;
               }
               
            }
            
            $bookingDetails = array();
            $bookingDetails['BookingDetails'] = $details;
            $bookingDetails['Notes'] = $notes;
            $bookingDetails['EmailHistory'] = $emailHistory;
        return $bookingDetails;
    }
    public function addBookingNote($bookingId,$notes)
    {
        $userId = CakeSession::read('User.Id');
        
        $detail = 'user_id=>'.$userId.'[|]note=>'.$notes.'[|]date=>';
        $this->query('CALL prt_booking_detail_add("'.$bookingId.'","ldc_booking_customer_agent_note",CONCAT("'.$detail.'",now()))');
        
    }
     public function deleteAdminNote($bookingDetailId)
    {
        $results = $this->query('UPDATE dt_booking_details SET booking_detail = CONCAT(booking_detail,"[|]deleted=>true") WHERE booking_detail_id ='. $bookingDetailId);
        return $results;
    }  
    
}
?>
