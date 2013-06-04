<?php

App::uses('Sanitize', 'Utility', 'RequestHandler');

class AdvertisementsController extends AppController
{
    public $components = array('RequestHandler', 'Image', 'FormItem');
    public $helpers = array('Number');
    public $name = 'Advertisements';
    
    
    private $bookingFormType;
    private $bookingCurrentLevelId;
    private $isUserLoggedIn;
    private $advertId;
    private $bookingFormLevels;
    
    private $_BOOKING_NEW_BOOK = 'booking-new-book';
    private $_ACCORDION_BOOKING_USER = 'accordion-booking-user';
    private $_ACCORDION_BOOKING_INVOICE = 'accordion-booking-invoice';
    private $_ACCORDION_BOOKING_PAYMENT_TYPE = 'accordion-booking-payment-type';

    private $_ACCORDION_BOOKING_PAYMENT_CREDIT_CARD = 'accordion-booking-payment-credit-card';
    private $_ACCORDION_BOOKING_PAYMENT_EFT_ATM_TRANSFER = 'accordion-booking-payment-eft-atm-transfer';
    private $_ACCORDION_BOOKING_PAYMENT_MAIL_ORDER = 'accordion-booking-payment-mail-order';    

    function beforeFilter()
    {
	
	
	parent::beforeFilter();
	if ($this->action == 'add' || $this->action == 'edit' || $this->action == 'booking')
	    $this->disableCache();
	
	if($this->action == 'advert')
	{
	   $advertId  = $this->request->params['pass'][0];
	   $reservations = CakeSession::read('Reservation');
	   if(isset($reservations[$advertId]))
	   {
	       $this->set('bookingInputType','notCompleted');
	   }
	}
	    
	
	if($this->action == 'add' || $this->action == 'booking')
	    $this->initFacebookLogin();
	
	if($this->action == "booking"):
	    $this->advertId = isset($this->request->data['Reservation']['advertId'])?$this->request->data['Reservation']['advertId']:false;
	    $this->bookingFormType = (isset($this->request->data['Booking']['formType']))?$this->request->data['Booking']['formType']:false;
	    
	    $this->isUserLoggedIn = CakeSession::read('User.LoggedIn');
	    $this->bookingFormLevels = array( $this->_BOOKING_NEW_BOOK,
				    $this->_ACCORDION_BOOKING_USER,
				    $this->_ACCORDION_BOOKING_INVOICE,
				    $this->_ACCORDION_BOOKING_PAYMENT_TYPE
				    );


	    if(!isset($this->bookingCurrentLevelId)) $this->_setNextBookingLevel ();

	    $proceduresUsingUserModel = array($this->_ACCORDION_BOOKING_USER);
	    if(in_array($this->bookingCurrentLevelId, $proceduresUsingUserModel))
	    {
		$this->loadModel('User');
		$this->User->set($this->request->data);
	    }

	    $proceduresUsingBookModel = array($this->_ACCORDION_BOOKING_INVOICE,$this->_ACCORDION_BOOKING_PAYMENT_TYPE);
	    if(in_array($this->bookingCurrentLevelId, $proceduresUsingBookModel))
	    {
		$this->loadModel('Booking');
		$this->Booking->set($this->request->data);
	    }
	endif;
	
	

    }
    

    /*
     * BOOKING FUNCTIONS START
     */
    function booking($advertId)
    {
	$this->advertId = $advertId;

	$this->_updateBookingPostData();
	
	if ($this->request->isPost() || $this->request->isPut())
	{
	    $methodName = $this->bookingFormType;
	    $methodName = str_replace('accordion','',$methodName);
	    $methodName = str_replace("-", "_", $methodName);
	    $methodName = Inflector::variable($methodName);
	    $methodName = '_'.$methodName.'Procedure';
	    $this->$methodName();
	}
	
	$reservationData = CakeSession::read('Reservation');
	
	if($this->isUserLoggedIn && !isset($reservationData[$this->advertId]['bookingId']))
	    $this->_createNewBooking();
	

	
	$this->_bookingSetupAccordionElements();
	$this->_bookingSetupDatas();
	
	$this->set('currentLevelId',$this->bookingCurrentLevelId);
    }
    
    function _updateBookingPostData()
    {
	$reservationData = CakeSession::read('Reservation');
	
	$this->request->data['Booking'] = (isset($this->request->data['Booking']))?$this->request->data['Booking']:array();
	
	if(isset($reservationData[$this->advertId]) && is_array($reservationData[$this->advertId]))
	    $this->request->data['Booking'] = array_merge($this->request->data['Booking'], $reservationData[$this->advertId]);
	    
	$this->request->data['Booking']['userId'] = CakeSession::read('User.Id');	
	

	//unset($this->request->data['Reservation']);
    }
    
    function _setNextBookingLevel()
    {
	if(!isset($this->bookingCurrentLevelId))
	    $this->bookingCurrentLevelId = ($this->isUserLoggedIn)?$this->_ACCORDION_BOOKING_INVOICE:$this->_ACCORDION_BOOKING_USER;
	else
	{
	    $currentIndex = array_search($this->bookingCurrentLevelId, $this->bookingFormLevels);
	    $this->bookingCurrentLevelId = $this->bookingFormLevels[$currentIndex+1];
	}
    }
    
    function _createNewBooking()
    {
	$priceData = $this->Advertisement->calculatePrice($this->request->data['Booking']);
	$result = $this->Booking->createNewBooking($this->request->data,$priceData);
	if($result['success'])
	{
	    $reservedAdvertId = $result['advertId']; 
	    $reservationData = CakeSession::read('Reservation');
	    $reservationData[$reservedAdvertId]['bookingId'] = $result['bookingId'];
	    CakeSession::write('Reservation',$reservationData);
	} else
	{
	     $this->Session->setFlash(__($result['message_text_id']));
	     $advert = $this->Advertisement->getAdvert2($this->advertId);
	     $advert = $this->parseAdvert($advert,'vw_get_adverts');
	     $this->redirect($advert['vw_get_adverts']['urlOptions']);
	}
    }  
    
    function _bookingNewBookProcedure()
    {
	$reservationData = CakeSession::read('Reservation');
	$reservationData = (is_array($reservationData))?$reservationData:array();
	$reservationData[$this->advertId] = $this->request->data['Reservation'];
	CakeSession::write('Reservation',$reservationData);	
	
	$this->_updateBookingPostData();
	
	if(!isset($this->bookingCurrentLevelId))
	{
	    if(!$this->isUserLoggedIn)
		$this->bookingCurrentLevelId = $this->_ACCORDION_BOOKING_USER;
	    else
		$this->bookingCurrentLevelId = $this->_ACCORDION_BOOKING_INVOICE;	    
	}	
    }    
    
    function _bookingUserProcedure()
    {
	if($this->request->data['User']['formType']=='login')
	    $this->User->validate = $this->User->quickLogin;

	if ($this->User->validates($this->User->validate))
	{
	    $result = $this->Advertisement->basicUserRegisterLogin($this->request->data);

	    if ($result['success'])
	    {
		$this->request->data['User']['id'] = $result['userId'];

		CakeSession::write('User.loginRequesterPage','/'.$this->request->url);
		$this->_setUserLoggedIn($result['userId']);
	    } else
	    {
		$this->Session->setFlash(__($result['message_text_id']));
	    }
	} else
	{

	    $this->Session->setFlash('please_check_your_information_message', 'flash_notification');
	    $this->request->data['User']['passwordNew'] = '';
	    $this->request->data['User']['passwordCheck'] = '';
	    $this->request->data['User']['password'] = '';
	}
	

    }    

    
    function _bookingInvoiceProcedure()
    {
	$this->Booking->set($this->request->data);
	$this->Booking->validate = $this->Booking->invoiceValidation;
	if ($this->Booking->validates())
	{
	    $result = $this->Booking->addUpdateBookingInvoice($this->request->data);

	    if ($result['success'])
	    {
		$this->_setNextBookingLevel();
	    } else
	    {
		$this->Session->setFlash(__($result['message_text_id']));
	    }
	} else
	{
	    $this->Session->setFlash(__('invoice_validation_data_error_message'), 'flash_notification');
	}

    }    
    function _bookingPaymentTypeProcedure()
    {
	$this->bookingCurrentLevelId = $this->_ACCORDION_BOOKING_PAYMENT_TYPE;
	$paymentType = (isset($this->request->data['Payment']['type']))?$this->request->data['Payment']['type']:false;
	
	if($paymentType!==false)
	{
	    $result = $this->Booking->addUpdateBookingPaymentType($this->request->data);
	    
	    if ($result['success'])
	    {
		switch ($paymentType)
		{
		    case 'eft':
			$this->bookingCurrentLevelId = $this->_ACCORDION_BOOKING_PAYMENT_EFT_ATM_TRANSFER;
			break;
		    default:
			$this->setUpPayU();
			$this->bookingCurrentLevelId = $this->_ACCORDION_BOOKING_PAYMENT_CREDIT_CARD;
			break;			
		}
	    } else
	    {
		$this->Session->setFlash(__($result['message_text_id']));
	    }
	}else
	{
	    $this->Session->setFlash(__('please_select_payment_type_first_message'));
	}	
    }    
    function _bookingPaymentCreditCardProcedure()
    {
	$result = $this->Booking->addUpdatePayUPaymentResult($this->request->data);
	if ($result['success'])
	{
	    $this->_setNextBookingLevel();
	} else
	{
	    $this->Session->setFlash(__($result['message_text_id']), 'flash_notification');
	}
	
    }   
    
    function _bookingPaymentEftAtmTransferProcedure() 
    {
	if($this->request->data['Booking']['agreement']==1)
	{
	   $this->_setNextBookingLevel();
	} else
	{
	    $this->Session->setFlash(__('please_check_payment_agreement_message'), 'flash_notification');
	}
    }
    
    function _bookingSetupDatas()
    {
	switch($this->bookingCurrentLevelId)
	{
	    case $this->_ACCORDION_BOOKING_PAYMENT_CREDIT_CARD:
		$this->setUpCurrentUserData();
		break;
	}
    }
    
    function _bookingSetupAccordionElements()
    {
	$accordionElements = array();
	
	if(!$this->isUserLoggedIn)
	    $accordionElements[] = array('id'=>$this->_ACCORDION_BOOKING_USER,'label'=>__("booking_user_data_headline"),'element'=>'/user/form/basic_register_login');

	$accordionElements[] = array('id'=>$this->_ACCORDION_BOOKING_INVOICE,'label'=>__("booking_invoice_data_headline"),'element'=>'/user/form/profile/invoice');	
	
	/*
	 * set up payment type options 
	 */
	$paymentTypeOptions = array();
	if($this->bookingCurrentLevelId == $this->_ACCORDION_BOOKING_PAYMENT_TYPE
		|| $this->bookingCurrentLevelId == $this->_ACCORDION_BOOKING_PAYMENT_EFT_ATM_TRANSFER
		|| $this->bookingCurrentLevelId == $this->_ACCORDION_BOOKING_PAYMENT_CREDIT_CARD
		)
	{
	    $this->loadModel('Booking');
	    $creditCardInstallements = $this->Booking->bookingCreditCardDeals($this->request->data['Booking']['bookingId']);
	    $this->set(compact('creditCardInstallements'));
	}
	$accordionElements[] = array('id'=>$this->_ACCORDION_BOOKING_PAYMENT_TYPE,'label'=>__("booking_payment_type_chooser_headline"),'element'=>'/payment/payment-type-chooser','elementOptions'=>array('creditCardInstallements'=>$creditCardInstallements));
	
	switch($this->bookingCurrentLevelId)
	{
	    case $this->_ACCORDION_BOOKING_PAYMENT_CREDIT_CARD:
		$accordionElements[] = array('id'=>'accordion-booking-payment-credit-card','label'=>__("booking_payment_headline"),'element'=>'/payment/payu/payment');	
		break;
	    case $this->_ACCORDION_BOOKING_PAYMENT_EFT_ATM_TRANSFER:
		$accordionElements[] = array('id'=>'accordion-booking-payment-eft-atm-transfer','label'=>__("booking_payment_headline"),'element'=>'/payment/eft-atm-transfer');	
		break;
	    case $this->_ACCORDION_BOOKING_PAYMENT_MAIL_ORDER:
		$accordionElements[] = array('id'=>'accordion-booking-payment-mail-order','label'=>__("booking_payment_headline"),'element'=>'/payment/mail-order');	
		break;
	    default:
		$accordionElements[] = array('id'=>'','label'=>__("booking_payment_headline"));	
		break;
	}
	$this->set(compact('accordionElements'));
    }
    
    
    /*
     * BOOKING FUNCTIONS END
     */
    


    function add()
    {
	$this->setUpAdvertContactFormOptions();
	$this->setUpAdvertAccommodationTypeOptions();
	$this->setUpCurrencyUnitOptions();

	
	if ($this->request->isPost())
	{
	    $cleanData = $this->_cleanPicturesPathData($this->request->data);
	    
	    $this->loadModel('User');
	    
	    $this->Advertisement->set($cleanData);
	    $this->Advertisement->validate = $this->Advertisement->quickAddValidate;
	    
	    if(isset($this->request->data['User']))
	    {
		$this->User->set($this->request->data);

		if($this->request->data['User']['formType']!='register')
		    $this->User->validate = $this->User->quickLogin;

		$this->User->invalidFields();
	    }
	    
	    if ($this->Advertisement->validates($this->Advertisement->quickAddValidate) && $this->User->validates($this->User->validate))
	    {
		$result = $this->Advertisement->saveQuickAdvert($cleanData);
		
		if ($result['success'])
		{
		    $newAdvertId = $result['advertId'];
		    $userId = $result['userId'];
		    $this->_loginUser($userId);
		    
		    if(isset($result['confirmCode']))
			$this->_sendUserActivationCodeViaMail($this->request->data['User']['email'], $result['confirmCode']);
		    
		    $this->moveUploadedFilesFromTempToRealTarget($newAdvertId);
		    $this->Session->setFlash(__('please_complete_your_places_details'));
		    $this->redirect(array('controller'=>'renterDashboards','action'=>'myPlaces',$newAdvertId));
		} else
		{
		    $this->Session->setFlash($result['messageTextId']);
		}

	    } else
	    {

		$this->Session->setFlash('LÃƒÂ¼tfen bilgilerinizi kontrol ediniz', 'flash_notification');
		$this->request->data['User']['passwordCheck'] = '';
	    }
	}
	
    }



    public function getByCategory($detailClassId, $feeder = 0)
    {
	$data = $this->request;

	if (isset($data['data']['Advertisement']))
	{
	    foreach ($data['data']['Advertisement'] as $val)
	    {
		$feeder = $val;
	    }
	} else if (isset($data['data']['User']))
	{
	    $feeder = $data['data']['User']['city'];
	}
	
	$selectBoxResult = $this->Advertisement->query('CALL prt_details_class_content(' . $detailClassId . ',' . $feeder . ')');
	$a = array();
	foreach ($selectBoxResult as $result)
	{
	    $a[$result['content']['id']] = $result['content']['message_text_id'];
	}
	$this->set('selectBoxResult', $a);
	$this->layout = 'ajax';
    }

    public function index()
    {
	$this->redirect(array('controller' => 'searches'));
    }

    
    public function view($placeId)
    {
	$this->placeId = $placeId;
	$this->place = $this->Advertisement->advertData($placeId);
	
	
	
	$this->setUpPlaceDetailsProperties();
	$this->setUpGuestCountAndPriceOptions();
	$this->setUpPlaceLogsData();
	$this->setUpScheduleData();
	$this->setUpSimilarPlacesData();
	$this->setUpCommentsData();
	$this->setUpMapData();
	$this->set(compact('placeId'));
	$this->set('place',$this->place);
    }
    
    /*
     * advert eski 
     * ileride silinebilir
     * 
     */
    
    public function _advert($advertId, $advertCategory = null)
    {

	$advert = $this->Advertisement->getAdvert($advertId);

	die;
	if (!isset($advertCategory))
	{
	    $advert = $this->parseAdvert($advert, 'Advert');
	    $this->redirect($advert['Advert']['urlOptions']);
	}

	if (!CakeSession::read('User.LoggedIn') == true && isset($this->params['named']['authKey']) && isset($this->params['named']['authUserId']))
	{
	    CakeSession::write('User.loginRequesterPage', $this->here);



	    $authKey = $this->params['named']['authKey'];
	    $authUserId = $this->params['named']['authUserId'];
	    $this->redirect(array('controller' => 'users', 'action' => 'logViaAuthkey', $authKey, $authUserId));
	}

	$this->set('advert', $advert);
	$this->set('category', $advertCategory);

	$isHouseHolder = $this->isUserHouseHolderOfCurrentAdvert($advert);

	if (!isset($this->advertPermissions['lp_advert_update']) && !$isHouseHolder && $advert['lcdt_title'][0]['status'] != 'active')
	{
	    $this->Session->setFlash('Bu ilan silinmiÃ…Å¸tir ya da gÃƒÂ¼ncellenmektedir. Ã„Â°lanÃ„Â±n sahibiyseniz lÃƒÂ¼tfen giriÃ…Å¸ yapÃ„Â±nÃ„Â±z.');
	    $this->redirect(array('controller' => 'searches'));
	}

	$this->loadModel('Search');
	$this->set('details', $this->Search->getDetailedSearchElements());
	$this->set('advertId', $advertId);

	$baseAdvertId = $this->Advertisement->getBaseAdvertIdByAdvert($advert);
	$similarAdverts = $this->Advertisement->getSimilarAdverts($advertId, $baseAdvertId);

	$this->set('similarAdverts', $this->parseAdvertListResults($similarAdverts, 'similar'));

	if (isset($this->advertPermissions['lp_advert_update']))
	{
	    $houseHolderId = $advert['lcdt_user_id'][1]['detail'];
	    $this->loadModel('User');
	    $this->set('houseHolderDetails', $this->User->getHouseHolder($houseHolderId));

	    $houseHoldersSimilarAdverts = $this->Advertisement->getHouseholdersSimilarAdverts($advertId, 10);
	    $this->set('houseHoldersSimilarAdverts', $houseHoldersSimilarAdverts);

	    $this->set('houseHoldersSimilarAdverts', $this->parseAdvertListResults($houseHoldersSimilarAdverts, 'similar'));
	    
	    $advertLogs = $this->Advertisement->getAdvertLogs($advertId);
	    
	    $this->set(compact('advertLogs'));
	}

	$bookingDays = $this->Advertisement->getAdvertSchedule($advertId, 8);
	$this->set('bookingDays', $bookingDays);

	$currencySymboll = $this->Advertisement->getCurrencySymboll($advert['lcdt_price_unit'][0]['detail']);
	$this->set('currencySymboll', $currencySymboll);

	$this->set('isUserHouseHolderOfCurrentAdvert', $this->isUserHouseHolderOfCurrentAdvert($advert));

	$advertTitle = $advert['lcdt_title'][0]['detail'];
	$this->set('advertTitle', $advertTitle);
	$this->set('title_for_layout', $advertTitle);

	$advertShortDescription = $advert['lcdt_short_description'][0]['detail'];
	$this->set('advertShortDescription', $advertShortDescription);
	$this->set('advertDescription', $advert['lcdt_description'][0]['detail']);
	$this->set('advertStatus', $advert['lcdt_title'][0]['status']);
	$this->set('isPartner', $advert['isPartner'][0]);
	$this->set('categoryName', $advert['lcdt_title'][0]['category_name']);

	$advertPrices = $advert['lcdt_price'];
	$this->set('advertPrices', $advertPrices);


	foreach ($advertPrices as $adPrice)
	{
	    $detail = $adPrice['detail'];
	    switch ($adPrice['detail_class'])
	    {
		case "ldc_advert_may_price":
		    $this->set('advertMayPrice', $detail);
		    break;
		case "ldc_advert_june_price":
		    $this->set('advertJunePrice', $detail);
		    break;
		case "ldc_advert_july_price":
		    $this->set('advertJulyPrice', $detail);
		    break;
		case "ldc_advert_august_price":
		    $this->set('advertAugustPrice', $detail);
		    break;
		case "ldc_advert_september_price":
		    $this->set('advertSeptemberPrice', $detail);
		    $this->set('advertOctoberPrice', $detail);
		    break;
		case "ldc_advert_price":
		    $this->set('advertPrice', $detail);
		    break;
		case "ldc_advert_weekend_price":
		    $this->set('advertWeekendPrice', $detail);
		    break;
		case "ldc_advert_workday_price":
		    $this->set('advertWeekdayPrice', $detail);
		    break;
	    }
	}

	$roomDetails = $advert['lcdt_room'];
	$this->set('roomDetails', $roomDetails);

	foreach ($roomDetails as $roomDetail)
	{
	    $detail = $roomDetail['detail'];
	    if ($detail != '')
	    {
		$detail = $this->parseProperties($detail);
		$detail = array_values($detail);
		$detail = $detail[0];
		switch ($roomDetail['detail_class'])
		{
		    case "ldc_advert_private_room_count":
			$this->set('privateRoomsCount', $detail);
			break;
		    case "ldc_advert_shared_room_count":
			$this->set('sharedRoomsCount', $detail);
			break;
		    case "ldc_advert_bathroom_count":
			$this->set('bathroomsCount', $detail);
			break;
		}
	    }
	}

	$this->set('maxGuestsCount', $advert['lcdt_count'][0]['detail']);


	$advertHouseHolderPrices = $advert['lcdt_householder_price'];
	$this->set('advertHouseHolderPrices', $advertHouseHolderPrices);

	foreach ($advertHouseHolderPrices as $adHouseHolderPrice)
	{
	    $detail = $adHouseHolderPrice['detail'];
	    switch ($adHouseHolderPrice['detail_class'])
	    {
		case "ldc_advert_may_householder_price":
		    $this->set('advertHouseHolderMayPrice', $detail);
		    break;
		case "ldc_advert_june_householder_price":
		    $this->set('advertHouseHolderJunePrice', $detail);
		    break;
		case "ldc_advert_july_householder_price":
		    $this->set('advertHouseHolderJulyPrice', $detail);
		    break;
		case "ldc_advert_august_householder_price":
		    $this->set('advertHouseHolderAugustPrice', $detail);
		    break;
		case "ldc_advert_september_householder_price":
		    $this->set('advertHouseHolderSeptemberPrice', $detail);
		    $this->set('advertHouseHolderOctoberPrice', $detail);

		    break;
		case "ldc_advert_householder_price":
		    $this->set('advertHouseHolderPrice', $detail);
		    break;
		case "ldc_advert_workday_householder_price":
		    $this->set('advertHouseHolderWeekdayPrice', $detail);
		    break;
		case "ldc_advert_weekend_householder_price":
		    $this->set('advertHouseHolderWeekendPrice', $detail);
		    break;
	    }
	}


	$detail = $advert['ldct_cancelation_terms'][0]['detail'];
	$detail = $this->parseProperties($detail);
	$keys = array_keys($detail);
	$cancelationTerm = $detail[$keys[0]];
	$this->set('cancelationTerm', $cancelationTerm);

	$detail = $advert['lcdt_city'][0]['detail'];
	$detail = $this->parseProperties($detail);
	$keys = array_keys($detail);
	$city = $detail[$keys[0]];
	$this->set('city', $city);

	$detail = $advert['lcdt_county'][0]['detail'];
	$detail = $this->parseProperties($detail);
	$keys = array_keys($detail);
	$county = $detail[$keys[0]];
	$this->set('county', $county);

	$detail = $advert['lcdt_neighborhood'][0]['detail'];
	$detail = $this->parseProperties($detail);
	$keys = array_keys($detail);
	$district = $detail[$keys[0]];

	$detail = $advert['lcdt_district'][0]['detail'];
	$detail = $this->parseProperties($detail);
	$keys = array_keys($detail);
	$subDistrict = $detail[$keys[0]];

	$this->set('zone', $this->getZone($county, $district, $subDistrict));

	$advertPictures = $advert['lcdt_picture'];
	$this->set('advertPictures', $advertPictures);


	$metasForLayout = array();
	$metasForLayout[] = '<meta property="og:title" content="tatilevim.com ' . $advertTitle . '" />';
	$metasForLayout[] = '<meta property="og:description" content="' . $advertShortDescription . '" />';

	foreach ($advertPictures as $image)
	{
	    $metasForLayout[] = '<meta property="og:image" content="http://tatilevim.com/upload/advert_' . $advertId . '/' . $image['imageName'] . '"/>';
	}
	$this->set('metasForLayout', $metasForLayout);



	$this->loadModel('Comment');
	$comments = $this->Comment->getComment($advertId, 1);
	$comments = Sanitize::clean($comments, array('encode' => false));

	$showRatingInputs = false;
	if (CakeSession::read('User.LoggedIn'))
	{
	    $this->loadModel('User');
	    $r = $this->User->UserRateAdvert($advertId);
	    if ($r > 0)
		$showRatingInputs = true;
	}

	
	$guestCountAndPriceOptions = $this->Advertisement->guestCountAndPriceOptions($advertId);

        $this->set(compact('guestCountAndPriceOptions'));
	$this->set(compact('showRatingInputs'));
	$this->set(compact('comments'));
    }

   

    function delete($advertId)
    {
	$advert = $this->Advertisement->getAdvert($advertId);
	$isHouseHolder = $this->isUserHouseHolderOfCurrentAdvert($advert);
	if (!isset($this->advertPermissions['lp_advert_update']) && !$isHouseHolder)
	{
	    $this->Session->setFlash('LÃƒÂ¼tfen giriÃ…Å¸ yapÃ„Â±nÃ„Â±z.');
	    $this->redirect('/users/login');
	}


	$this->Advertisement->deleteCache('vw_get_advert_details_' . $advertId, 'monthly');
	$this->Advertisement->deleteCache('home_page_get_last_9_vw_get_adverts', 'hourly');

	$result = $this->Advertisement->query('CALL prt_advert_confirm(' . CakeSession::read('User.Id') . ',' . $advertId . ',"delete")');
	$this->Session->setFlash(__($result[0]['lsm']['message_text_id']));
	$this->redirect($this->referer());
    }

    function updateStatus($advertId, $status = null)
    {
	if (isset($this->advertPermissions['lp_advert_status_update']))
	{
	    $this->Advertisement->deleteCache('vw_get_advert_details_' . $advertId, 'monthly');
	    $this->Advertisement->deleteCache('home_page_get_last_9_vw_get_adverts', 'hourly');

	    if ($status == null)
		$status = 'active';
	    $result = $this->Advertisement->query('CALL prt_advert_confirm(' . CakeSession::read('User.Id') . ',' . $advertId . ',"' . $status . '")');
	    $this->Session->setFlash(__($result[0]['lsm']['message_text_id']));
	    $this->redirect($this->referer());
	} else
	{
	    $this->Session->setFlash('LÃƒÂ¼tfen giriÃ…Å¸ yapÃ„Â±nÃ„Â±z');
	    $this->redirect('/users/login');
	}
    }

    function isUserHouseHolderOfCurrentAdvert($advert)
    {
	foreach ($advert['lcdt_user_id'] as $advertUsersIdDetails)
	{
	    if ($advertUsersIdDetails['detail_class'] == 'ldc_advert_householder_user_id')
		$houseHolderId = $advertUsersIdDetails['detail'];
	}

	$isHouseHolder = false;
	if (isset($houseHolderId))
	{
	    $userId = CakeSession::read('User.Id');
	    if ($houseHolderId == $userId)
		$isHouseHolder = true;
	}

	return $isHouseHolder;
    }

    function addAdminNote()
    {
	if ($this->request->is('post'))
	{
	    $this->data = Sanitize::clean($this->data, array('encode' => false));
	    $note = $this->request->data['AdminNote']['note'];
	    $advertId = $this->request->data['AdminNote']['advertId'];
	    $userId = CakeSession::read('User.Id');

	    if (isset($note) && trim($note) != '')
		$this->Advertisement->addAdminNote($advertId, $userId, $note);

	    $this->set('adminNotes', $this->Advertisement->getAdminNotes($advertId));
	}

	$this->render('adminNotes');
    }

    function deleteAdminNote()
    {
	if ($this->request->is('post'))
	{
	    $noteId = $this->request->data['AdminNote']['selectedNoteId'];
	    $advertId = $this->request->data['AdminNote']['advertId'];
	    $this->Advertisement->deleteAdminNote($noteId);

	    $this->set('adminNotes', $this->Advertisement->getAdminNotes($advertId));
	}

	$this->render('adminNotes');
    }

    function markAsFuturedAdvert($advertId)
    {
	if (isset($this->advertPermissions['lp_advert_set_top']))
	{
	    $this->Advertisement->setAdvertTop($advertId);

	    $this->Session->setFlash($advertId . " nolu ilan ÃƒÂ¶n plana ÃƒÂ§Ã„Â±kartÃ„Â±ldÃ„Â±!");
	    $this->redirect($this->referer());
	}
    }


    
    
    /*
     * 
     * Ajax functions
     */
    function searchLocation()
    {
	$data = $this->request;
	$str = $data['data']['Search']['location'];
	$results = $this->Advertisement->locations($str);
        $this->set("locations", $results);
	$this->layout = 'ajax';
    }    
    
    public function calculatePrice()
    {
	if ($this->request->data)
	{
	    $results = $this->Advertisement->calculatePrice($this->request->data);
	    
	    $price = $results['booking_price'];
	    $currencyUnit = $results['currency_unit'];
	    $totalSelectedNights = $results['total_nights'];
	    $totalGuests = $this->request->data['totalGuests'];
	    

	    $priceTestingMode = (isset($this->request->data['priceTestingMode']))?true:false;
	    
	    $minStayNights = $results['min_stay_nights'];
	    $bookingId = $results['booking_id'];

	    

	    $message = '';
	    if ($totalSelectedNights < $minStayNights)
		$message = __("book_message_min_stay_nights").' '.$minStayNights.' '.__('book_message_min_stay_nights_append');
	    if (isset($results['Conflicting']['bookingId']) && $results['Conflicting']['bookingId']!=0)
		$message = __("book_message_selected_dates_is_not_aveliable");

	    $this->set('totalSelectedNights', $totalSelectedNights);
	    $this->set(compact('totalGuests'));
	    $this->set('price', $price);
	    $this->set('currencyUnit', $currencyUnit);
	    $this->set('message', $message);
	    $this->set(compact('results'));
	    $this->set('priceTestingMode',$priceTestingMode);
	}
	$this->layout = 'ajax';
    }    

}

?>
