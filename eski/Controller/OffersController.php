<?php
App::uses('Sanitize', 'Utility');
class OffersController extends AppController
{

    public $name = 'Offers';

    public function index()
    {
	
    }
    
    public function view($offerId = null)
    {
	switch($offerId)
	{
	    case '1':
		$this->render('discount_comment_feedback');
		break;
	    case '2':
		if(isset($this->passedArgs['location']))
		    $location = $this->passedArgs['location'];
		else
		    $location = null;
		
		$this->loadModel('Offer');
		$adverts = $this->Offer->getoffers(2,$location);
		$adverts = $this->parseAdvertListResults($adverts,'vw_get_adverts');
		$this->set(compact('adverts'));
		$this->render('early_bookings_2013');
		break;
	}
	
    }
    
}