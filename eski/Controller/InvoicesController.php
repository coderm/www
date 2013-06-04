<?php
App::uses('Sanitize', 'Utility');
class InvoicesController extends AppController
{
    public $name = 'Invoices';
    public $helpers = array('Number');
    
    function index()
    {   $results = $this->Invoice->getPreviousMonthsInvoice();
        $this->set('clientList',$results);
    }
    
    
    function invoiceDetailsList($userId)
    {
        $results = $this->Invoice->getPreviousMonthsInvoice($userId);
        $this->set('invoiceDetailsList',$results);
        
        if($this->request->is('post'))
        {
            $selectedBookings = array();
            $allBookings = $this->request->data['invoiceDetails'];
            foreach($allBookings as $booking=>$isSelected)
            {
                if($isSelected)
                    $selectedBookings[] = $booking;
            }
            if(count($selectedBookings)==0)
            {
                $this->Session->setFlash('Basım için en az bir rezervasyon seçilmelidir.');
            } 
            else
            {
                $selectedBookingsString = implode('*', $selectedBookings);
                
                $this->redirect(array('action' => 'printPreview',$userId,$selectedBookingsString));
                
            }
        }
    }
    
    public function printPreview($userId,$selectedBookingsString)
    {
        $this->set('selectedBookingsString',$selectedBookingsString);
        
        $selectedBookings = explode("*",$selectedBookingsString);
        $selectedBookingsString = implode(',', $selectedBookings);
        $s = "";
        foreach($selectedBookings as $selectedbooking)
        {
            $s .= '"'.$selectedbooking .'",';
        }
        $s .= "0";
        
        if($this->request->is('post'))
        {
            
            $this->Invoice->setInvoiced($s);
            
            $this->redirect('/invoices');
        }
        
        
        


       $results = $this->Invoice->getInvoiceData($s);   
       
       

       $this->set('rowsData',$results);
       
       
       $this->loadModel('User');
       $user = $this->User->getUser($userId);
       $this->set('user',$user);
       
       
       $userDetails = $this->User->getUserDetail($userId);
       $ud = array();
       foreach($userDetails as $userDetail)
       {
           if(isset($userDetail['ldc']))
            $ud[$userDetail['ldc']['message_text_id']] = $userDetail['dsd']['user_detail'];
       }
       $this->set('userDetails',$ud);
    }      
    
}
?>
