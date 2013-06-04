<?php
class RenterDashboardsController extends AppController
{
    public $name = 'RenterDashboards';
    public $helpers = array('EaseText');
    
    public function beforeFilter() 
    {
        parent::beforeFilter();
	/*
	 * Kullanıcı izni sorgulanacak
	 */
    }
    
    public function index()
    {
	$this->loadModel('Advertisement');
	$myPlaces = $this->Advertisement->myAdverts();
	$myPlaces = $this->parseAdvertListResults($myPlaces);
	
	$this->set(compact('myPlaces'));
    }
    
    public function myPlaces($placeId,$action = 'overview')
    {
	$this->placeId = $placeId;
	if($this->request->isPost() || $this->request->isPut())
	{
	    $this->loadModel('Advertisement');
	    $this->request->data['Advertisement']['advertId'] = $placeId;
	    
	    $modelAction;
	    switch($action)
	    {
		case 'advertBasics':
		    $modelAction ='updateAdvertBaseDetails';
		    break;
		case 'contact':
		    $modelAction = 'updateAdvertLocationDetails';
		    break;
		case 'advertDetails':
		    $modelAction = 'addUpdateDetails';
		    break;
		case 'photos':
		    $modelAction = 'addUpdatePictures';
		    break;
		case 'advancedOptions':
			$subAction = isset($this->passedArgs[2])?$this->passedArgs[2]:'';
		    
			switch($subAction)
			{
			    case 'visibility':
				$modelAction = 'updateAdvertVisibility';
				break;
			    case 'conditional_pricing':
				$modelAction = 'updateAdvertConditionalPricing';
				break;
			    default:
				$modelAction = 'updateAdvertConditions';
				break;
			}
		    break;
	    }
	    
	    
	    $cleanData = $this->_cleanPicturesPathData($this->request->data);	    
	    //ha buraya validasyon da ekle 
	    $result = $this->Advertisement->$modelAction($cleanData);
	    //resulta göre mesaj yayınla burada
	    
	    
	}
	
	$this->set(compact('placeId'));
	$this->loadModel('Advertisement');
	$this->loadModel('Dummy');
	
	
	$advert = $this->Advertisement->advertData($placeId);
	
	
	$advert = $this->parseAdvert($advert);
	$this->request->data = $advert;
	
	
	

	switch($action)
	{
	    case 'overview':
		
		
		break;
	    case 'advertBasics':
		$this->setUpAdvertAccommodationTypeOptions();
		$this->setUpCurrencyUnitOptions();
		$this->setUpSellPriceData();

		$saveUpdateButtonLabel = 'my_places_save_button_label';
		break;
	    case 'contact':
		$this->setUpAdvertContactFormOptions();
		$saveUpdateButtonLabel = 'my_places_save_button_label';
		break;
	    case 'advertDetails':
		$this->setUpPlaceDetailsProperties();
		$saveUpdateButtonLabel = 'my_places_save_button_label';
		break;
	    case 'photos':
		$saveUpdateButtonLabel = 'my_places_save_button_label';
		break;
	    case 'calendar':
		$this->setUpCurrencyUnitOptions();
		$this->setUpCustomBookChannelOptions();
		$this->set('showCurrencyOptions',false);
		break;
	    case 'advancedOptions':
		    $subAction = isset($this->passedArgs[2])?$this->passedArgs[2]:'';
		    switch($subAction)
		    {
			case 'price_tester':
			    $this->setUpGuestCountAndPriceOptions();
			    break;
			default:
			    $this->setUpCurrencyUnitOptions();
			    $saveUpdateButtonLabel = 'my_places_save_button_label';
			    break;
		    }
		break;	    
	}

	
	$placeDetails = $advert['Advertisement'];
	$this->set(compact('saveUpdateButtonLabel'));
	$this->set(compact('placeDetails'));
	$this->set(compact('advert'));
	$this->set(compact('action'));
	
    }
    
    
    function addUpdateCalendarAjax()
    {
	$this->loadModel('Advertisement');
	$result = $this->Advertisement->updateCalendar($this->request->data);

	
	$results = $result;
	$this->set(compact('results'));
	$this->set('_serialize',array('results'));	
	
    }
    
    
    
    
    
}
?>
