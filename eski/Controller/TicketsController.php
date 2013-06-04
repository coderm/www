<?php
class TicketsController extends AppController
{
    function beforeFilter() 
    {
	Configure::write('debug', 0);
        parent::beforeFilter();
    }  
    
    
    function index()
    {
	$tickets = $this->Ticket->getTickets();
	
	$this->set(compact('tickets'));
    }
   
    function add()
    {
	$data = array();
	$data['success'] = true;
	$data['data'] = $this->request->data;
	
	$this->Ticket->add($data);
	
	$this->set(compact('data'));
	$this->set('_serialize',array('data'));
    }
    
    function resolve($ticketId)
    {
	$this->Ticket->setAsResolved($ticketId);
    }
   
}
?>
