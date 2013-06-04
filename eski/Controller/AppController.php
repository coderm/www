<?php
App::uses('Sanitize', 'Utility');
class AppController extends Controller 
{
    public $components = array('Session','Cookie','PrgPattern','RequestHandler');
    public $helpers = array('Html','BSForm','Form','Js','Session','SearchForm','ReservationForm','Text','EaseText','Paginator','Facebook.FacebookShare','Twitter.TwitterShare','Pinterest.PinIt','Google.GooglePlus','BitLy','LightBox.LightBox');
    public $permissions = array();
    
    public $userPermissions = Array(); 
    public $advertPermissions = Array();
    public $bookingPermissions = Array();

    public $userPermissionsPreFix = 'lp_user';
    public $advertPermissionsPreFix = 'lp_advert';
    public $bookingPermissionsPreFix = 'lp_booking';
    
    public $placeId;
    public $place;
    
    public function beforeFilter() 
    {   

        App::import('Vendor', 'mobileDetect'); 
        $detect = new Mobile_Detect();

       if(CakeSession::read('User.Id')=='1815')
        {
        Configure::write('debug', 2);
        }
	
        $this->Session->valid() ;	
	
	if ($this->Session->check('Config.language'))
            Configure::write('Config.language', $this->Session->read('Config.language'));
        else	
	    $this->Session->write('Config.language', 'tur');//burada domaine bakılan bir algoritma yaz	
       


	

	
        if(CakeSession::read('User.Id')=='')
        {
            CakeSession::write('User.Id',6);
            $this->setUserPermissions();
        }        
        if(CakeSession::read('User.Permissions')=='')
                CakeSession::write('User.Permissions',array());
        if(CakeSession::read('User.LoggedIn')=='')
                CakeSession::write('User.LoggedIn',false);
        
        $userPermissions = CakeSession::read('User.Permissions');
	
	

        foreach($userPermissions as $userPermission)
        {
            $a = explode($this->userPermissionsPreFix, $userPermission); 
            if($a[0]=='')
                $this->userPermissions[$userPermission] = true;

            $a = explode($this->advertPermissionsPreFix, $userPermission);
            if($a[0]=='')
                $this->advertPermissions[$userPermission] = true;

            $a = explode($this->bookingPermissionsPreFix, $userPermission);
            if($a[0]=='')
                $this->bookingPermissions[$userPermission] = true;
        }

        $this->set('userPermissions',$this->userPermissions);
        $this->set('advertPermissions',$this->advertPermissions);
        $this->set('bookingPermissions',$this->bookingPermissions);


        if($this->request->is('post'))
            $this->data = $this->trimArray($this->data);
        
        
        
        
        if($this->Cookie->read('isFollowUsViewed')!='true' && !$detect->isMobile())
        {
            $this->set('isFollowUsViewed',false);
            $this->Cookie->write('isFollowUsViewed', 'true', false, "30 DAY");
        } else
        {
            $this->set('isFollowUsViewed',true);
        }
        
        
        if(isset($this->params['named']['showOffset']))
            $this->set('showOffset',$this->params['named']['showOffset']);
	    $this->loadModel('Favorite');
	if (CakeSession::read('User.Id') == 6) {
            $favoriteList = $this->Cookie->read('favoriteList');
            if (is_array($favoriteList))
                $result = $favoriteList;
            else {
                $result = str_replace(array('\\', '[', ']', '"'), '', $favoriteList);
                $result = explode(',', $result);
            }
            $favoriteList = array_values($result);
        } else 
            $favoriteList = $this->Favorite->listFavorite();
   
	$totalAdvertsInFavorites = $this->Favorite->totalFavorite($favoriteList);
	
	$this->set(compact('totalAdvertsInFavorites'));
	
	if(isset($this->userPermissions['lp_user_is_admin']) && $this->userPermissions['lp_user_is_admin'])
	{
	    $this->loadModel('Comment');
	    $totalWaitingForAprovalComments = $this->Comment->getTotalWaitingForAprovals();
	    $this->set(compact('totalWaitingForAprovalComments'));	    
	    
	    $this->loadModel('Advertisement');
	    $totalWaitingForAprovalAdverts = $this->Advertisement->getTotalWaitingForAprovals();
	    $this->set(compact('totalWaitingForAprovalAdverts'));
	}



    }
    

    
    
    function _loginUser($userId)
    {
	CakeSession::write('User.Id',$userId);
	CakeSession::write('User.LoggedIn',true);
	$this->setUserPermissions();
	$this->mergeFavorites();
    }
    
    function setUserPermissions()
    {
        $userId = CakeSession::read('User.Id');
         
        $this->loadModel('User');
        $results =  $this->User->query('CALL prt_permission(
                                                                '.$userId.',
                                                                "all"
                                                                )');
         
        $userPermissions = array();
        foreach($results as $result)
            $userPermissions[] =$result['lp']['message_text_id'];

        CakeSession::write('User.Permissions',$userPermissions);
    }
    
    public function get($varName)
    {
        return $this[$varName];
    }    
    
    
    function parseAdvertListResults($results)
    {
        $adverts = array();
        foreach($results as $result)
        {
	    if(isset($result['Advertisement']))
		$adverts[] = $this->parseAdvert($result);
        }
        return $adverts;
    }    
    
    function parseAdvert($advert)
    {
	    $country = $advert['Search']['country'];
	    $city = $advert['Search']['city'];
	    $district = $advert['Search']['district'];
	    $subDistrict = $advert['Search']['subDistrict'];
	    
	    $class = $advert['Advertisement']['type'];
	    $advertId = $advert['Advertisement']['advert_id'];
	    $advertTitle = $advert['Advertisement']['title'];
	    
	    
	    $pictures = $advert['Advertisement']['picture'];
	    foreach($pictures as $key=>$picture)
	    {
		$advert['Advertisement']['picture'][$key]['path'] = 'upload/advert_'.$advertId.'/thumb_'.$picture['name'];
	    }
            

            $advert['Advertisement']['locationLabel'] = $this->getLocationLabel($city,$district,$subDistrict);
            $advert['Advertisement']['locationUrlOptions'] = $this->getAdvertLocationUrlOptions($city,$district,$subDistrict);
            $advert['Advertisement']['urlOptions'] = $this->getAdvertUrlOptions($city,$district,$subDistrict,$class,$advertId,$advertTitle);    
	    
	    $advert['Advertisement']['description'] = Sanitize::html($advert['Advertisement']['description'], array('remove' => true));
            
            return $advert;
    }
    
    public function parseProperties($propertiesString)
    {
            $propertiesString;
            $a = array();
            if($propertiesString!='')
            {
                $properties = explode('[|]',$propertiesString);
                foreach($properties as $property)
                {
                    $p = explode('=>',$property);
                    $p[0] = trim(str_replace("'","",$p[0]));
                    if(count($p)>1)
                    {
                        $p[1] = trim(str_replace("'","",$p[1]));
                        $a[trim($p[0])] = $p[1];
                    } else
                    {
                        $a[trim($p[0])] = null;
                    }
                }
                $properties = $a;
            }
            return $a;
    }   
    
    public function trimArray($str, $set=null)
    {
        if(is_Array($str) || is_Object($str))
            foreach($str as &$s)
                $s=$this->trimArray($s,$set);
        elseif($set===null)$str=trim($str);
        else $str=trim($str,$set);
        return $str;
    }    
    
    function stringToSlug($str) 
    {
        Inflector::rules('transliteration', array('/Ü/' => 'u'));
        Inflector::rules('transliteration', array('/ü/' => 'u'));
        Inflector::rules('transliteration', array('/Ö/' => 'o'));
        Inflector::rules('transliteration', array('/ö/' => 'o'));
        Inflector::rules('transliteration', array('/ö/' => 'o'));      
        $str = Inflector::slug($str,'-');
        $str = strtolower($str);
        return $str;
    }
    
    
    var $stringsToRemoveFromSubDistrict = array(' Mah.',' Köyü');
    

    
    function getAdvertLocationUrlOptions($city,$district,$subDistrict)
    {
        $s='';
	
	/*
        if(strrpos($category, 'lac_summer')===0)
            $s = 'lac-summer';
        if(strrpos($category, 'lac_city')===0)
            $s = 'lac-city';            
	    $category = $s;
	 */
        

        
        
        $urlOptions = array();
        $urlOptions['controller'] = 'searches';
        $urlOptions['action'] = 'index';
        $urlOptions[] = $this->stringToSlug($city);
        $urlOptions[] = $this->stringToSlug($district);
        $urlOptions[] = $this->stringToSlug($subDistrict);
        
        return $urlOptions;
    }
    
    function getAdvertUrlOptions($city,$district,$subDistrict,$class,$advertId,$advertTitle)
    {
	$urlOptions['controller'] = 'advertisements';
	$urlOptions['action'] = 'view';
	$urlOptions[] = $advertId;
	
	return $urlOptions;
	
        $urlOptions['controller'] = 'searches';
        $urlOptions['action'] = 'index';        
	    
        $urlOptions = $this->getAdvertLocationUrlOptions($city,$district,$subDistrict);

        $urlOptions[] = $this->stringToSlug($class);
        $urlOptions[] = $advertId;
        $urlOptions[] = $this->stringToSlug($advertTitle);      
        return $urlOptions;
    }
    
    
    function getLocationLabel($city,$district,$subDistrict)
    {
        $separator = ' / ';
        $s = '';
	$s.=$city.$separator;
        $s.=$district.$separator;
        $s.=$subDistrict;
        
        return $s;
    }
    
    
    function convertPostDateToGet($formName,$specialNames = null)
    {
        if(isset($this->request->params['named']['addNamed']))
        {
            $addNamed = $this->request->params['named']['addNamed'];
            
            $a = explode('[=]',$addNamed);
            $addNamedKey = $a[0];
            $addNamedValue = $a[1];
            
            $url = $this->referer().'/';
            $url = preg_replace('/('.$addNamedKey.':.+?)+(\/)/i', '', $url); 
            
            
            $url = preg_replace('/('.$addNamedKey.':.+?)+(\/)/i', '', $url); 
            $url = rtrim($url, "/");

            $url.='/'.$addNamedKey.':'.$addNamedValue;
            $this->redirect($url);
            exit;
        }
        
        if(isset($this->request->params['named']['removeNamed']))
        {
            $removeNamed = $this->request->params['named']['removeNamed'];
            $url = $this->referer().'/';

            $url = preg_replace('/('.$removeNamed.':.+?)+(\/)/i', '', $url); 
            $this->redirect($url);
            exit;
        }

        
        $controller = $this->request->params['controller'];
        $action = $this->request->params['action'];
        
        
        
        if(is_array($specialNames))
        {
            $specialNames = array_merge(array('page','sort','direction'),$specialNames);
        } else
        {
            $specialNames = array('page','sort','direction');
        }


        
        
        if($this->request->data) 
        {
                $url = array('controller' => $controller, 'action' => $action);
                //$url = array_merge($url,$this->request['named']);
               
                if(is_array($this->request->data[$formName])) 
                {
                        foreach(array_keys($this->request->data[$formName]) as $searchItemKey)
                        {
                                $searchItem = $this->request->data[$formName][$searchItemKey];
                                $this->request->data[$formName][$searchItemKey] = base64_encode(serialize($searchItem));
                        }
                }
                $params = array_merge($url, $this->request->data[$formName]);
                
                $namedParamsOutsidePostData = array();
                foreach($this->request['named'] as $key => $value)
                {
                    if(!isset($this->request->data[$formName][$key]))
                        $namedParamsOutsidePostData[$key] = $value;
                }
                $params = array_merge($params, $namedParamsOutsidePostData);
                
                $this->redirect($params);
        }    


        if(!empty($this->request->params['named']))
        {
            foreach(array_keys($this->request->params['named']) as $searchItemKey)
            {
                if(!in_array($searchItemKey,$specialNames))
                        $this->request->data[$formName][$searchItemKey] = unserialize(base64_decode($this->request->params['named'][$searchItemKey]));
            }
        }  
    }
    
    public function _setUserLoggedIn($userId)
    {
	    CakeSession::write('User.Id',$userId);
	    CakeSession::write('User.LoggedIn',true);
	    $this->setUserPermissions();
	    $this->mergeFavorites();
	    

	    if(CakeSession::check('User.loginRequesterPage'))
		$this->redirect (CakeSession::read('User.loginRequesterPage'));
	    else
		$this->redirect('/');	
    }
    
    
    
    private function diffFavorites($details = false)
    {
	$this->loadModel('Favorite');
        $favoriteListDb = $this->Favorite->listFavorite();
        $favoriteListCk = $this->Cookie->read('favoriteList');
        
        if (!is_array($favoriteListCk)) {
            $temp = str_replace(array('\\', '[', ']', '"'), '', $favoriteListCk);
            if ($temp <> $favoriteListCk)
                $favoriteListCk = explode(',', $temp);
            else
                $favoriteListCk = array();
        }
        if (!is_array($favoriteListDb))
            $favoriteListDb = array();

        $a = array();
	foreach ($favoriteListDb as $b)
	{
	    $a[$b] = $b;
	}
	$favoriteListDb = $a;
	$a = array();
	foreach ($favoriteListCk as $b)
	{
	    $a[$b] = $b;
	}
	$favoriteListCk = $a;
	$a = array_diff($favoriteListCk, $favoriteListDb);
	$favoriteList = array();
	foreach ($a as $b)
	{
	    $favoriteList[] = $b;
	}

	if ($details)
	    return $this->Favorite->favoriteDetails($favoriteList);
	else
	    return $favoriteList;
    }

    private function mergeFavorites()
    {
	$this->loadmodel('Favorite');
	foreach ($this->diffFavorites() as $b)
	{
	    $this->Favorite->addFavorite($b, array());
	}
    }        
    
    
    public function initFacebookLogin()
    {
	    App::import('Vendor', 'facebook', array('file' => 'facebook.php'));
	    $this->loadModel('User');
	    $facebook = new Facebook(array(
		    'appId' => $this->fbAppId,
		    'secret' => $this->fbAppSecret,
		));

	    $user = $facebook->getUser();

	    if ($user)
	    {
		try{$user_profile = $facebook->api('/me');}
		catch (FacebookApiException $e)
		{
		    error_log($e);
		    $user = null;
		}
	    }

	    $loginUrl = $facebook->getLoginUrl(array(
		'scope' => 'read_stream, publish_stream, user_birthday, email',
		'redirect_uri' => 'http://www.tatilevim.com/users/loginAfterFacebookRedirect'
		    ));
	    $this->set('loginUrl', $loginUrl);
    }
    
    /*
     * image upload
     */
	public function prepareToImageUpload()
	{
	    if(CakeSession::check('upload.tempFolder'))
		return;
	    
	    $tempId = uniqid();
	    CakeSession::write('upload.tempFolder','upload/temp_'.$tempId);
	}
	
	public function clearImageTemp()
	{
	    if(CakeSession::check('upload.tempFolder'))
		return;
	    
	    
	    CakeSession::delete('upload.tempFolder');  
	}
	
	public function moveUploadedFilesFromTempToRealTarget($advertId)
	{
	    if(!CakeSession::check('upload.tempFolder'))
		return;
	    
	    rename(CakeSession::read('upload.tempFolder'),'upload/advert_'.$advertId);
	    $this->clearImageTemp();
	}
	
	
	
	public function upload()
	{
	    $this->layout = 'empty';
	    if ($this->request->isPost() || $this->request->isPut())
	    {

		$advertId = (isset($this->data['Advertisement']['advertId']))?$this->data['Advertisement']['advertId']:null;

		$file = $this->data["Advertisement"]['image_upload'];
		$this->prepareToImageUpload();
		if(isset($advertId))
		    $targetFolder = 'upload/advert_'.$advertId;
		else
		    $targetFolder = CakeSession::read('upload.tempFolder');
		
		
		
		@mkdir($targetFolder);
		$this->Image->upload($file, $targetFolder);
	    }

	    $this->set('imageThumbPath', $this->Image->galleryThumbPath);
	    $this->set('imageName', $this->Image->fileName);
	}	    
    
    /*
     * emails
     */
    
    public function _sendUserActivationCodeViaMail($mailAddress, $comfirmCode)
    {
	App::uses('CakeEmail', 'Network/Email');
	$cakeEmail = new CakeEmail();
	$cakeEmail->config('gmail');
	$cakeEmail->from(array('noreply@tatilevim.com' => 'tatilevim.com'));
	$cakeEmail->to($mailAddress);
	$cakeEmail->subject('tatilevim.com üyelik onayı');
	$cakeEmail->emailFormat('text');
	$cakeEmail->template('userActivated','blank'); 

	$cakeEmail->viewVars(array('confirmCode' => $comfirmCode));
	$cakeEmail->viewVars(array('email' => $mailAddress));

	$cakeEmail->send();                            
    }
    
    
    /*
     * setups
     */
    
    public function setUpCustomBookChannelOptions()
    {
	$customBookChannelOptions = array();
	$this->loadModel('Dummy');
	$customBookChannelOptions = $this->Dummy->getSellChannels();
	$this->set(compact('customBookChannelOptions'));
    }
    
    public function setUpCurrencyUnitOptions()
    {
	$this->loadModel('Adverisement');
	$currencyUnitOptions = $this->Advertisement->getCurrencyUnitOptions();
	$this->set(compact('currencyUnitOptions'));
	
    }
    
    public function setUpAdvertAccommodationTypeOptions()
    {
	$this->loadModel('AdvertsClass');
	$accommodationTypeOptions = $this->AdvertsClass->getAccommodationTypes();
	$this->set(compact('accommodationTypeOptions'));	
    }
    
    public function setUpAdvertContactFormOptions()
    {
	$countryId =(isset($this->request->data['Advertisement']['country']))? $this->request->data['Advertisement']['country']:-1;
	$cityId = (isset($this->request->data['Advertisement']['city']))?$this->request->data['Advertisement']['city']:-1;
	$districtId = isset($this->request->data['Advertisement']['district'])?$this->request->data['Advertisement']['district']:-1;

	$this->loadModel('Advertisement');
	
	$selectCountryOptions = $this->Advertisement->getSubLocations('world');
	$selectCityOptions = $this->Advertisement->getSubLocations('country', $countryId);
	$selectDistrictOptions = $this->Advertisement->getSubLocations('city', $cityId);
	$selectSubDistrictOptions = $this->Advertisement->getSubLocations('district', $districtId);

	$this->set(compact('selectCountryOptions'));
	$this->set(compact('selectCityOptions'));
	$this->set(compact('selectDistrictOptions'));
	$this->set(compact('selectSubDistrictOptions'));
    }
    
    public function setUpSellPriceData()
    {
	$demand = (isset($this->request->data['Advertisement']['demand']))?$this->request->data['Advertisement']['demand']:false;
	
	if($demand)
	{
	    $this->loadModel('Advertisement');
	    $this->request->data['Advertisement']['salePrice'] = $this->Advertisement->calculatePriceByHouseDemand($demand,$this->request->data['Advertisement']['advert_id']);
	}
	    
    }
    
    
    public function setUpGuestCountAndPriceOptions()
    {
	$guestCountAndPriceOptions = $this->Advertisement->guestCountAndPriceOptions($this->placeId);	
	$this->set(compact('guestCountAndPriceOptions'));
    }
    
    public function setUpPlaceLogsData()
    {
	if (isset($this->advertPermissions['lp_advert_update']))
	{
	    $placeLogs = $this->Advertisement->getAdvertLogs($this->placeId);
	    $this->set(compact('placeLogs'));
	}
    }
    
    public function setUpScheduleData()
    {
	$scheduleDays = $this->Advertisement->getAdvertSchedule($this->placeId, 8);	
	$this->set(compact('scheduleDays'));
    }
    
    public function setUpSimilarPlacesData()
    {
	$similarPlaces = $this->Advertisement->similarAdverts($this->placeId);	
	$this->set(compact('similarPlaces'));
    }
    
    public function setUpPlaceDetailsProperties()
    {
	$this->loadModel('Dummy');
	$placeDetailProperties = $this->Dummy->getAdvertProperties();
	$this->set(compact('placeDetailProperties'));
    }
    public function setUpCommentsData()
    {
	$this->loadModel('Comment');
	$comments = $this->Comment->getComment($this->placeId, 1);
	$comments = Sanitize::clean($comments, array('encode' => false));

	


	$showRatingInputs = false;
	if (CakeSession::read('User.LoggedIn'))
	{
	    $this->loadModel('User');
	    $r = $this->User->UserRateAdvert($this->placeId);
	    if ($r > 0)
		$showRatingInputs = true;
	}	
	
	$this->set(compact('comments'));
	$this->set(compact('showRatingInputs'));
	
    }
    public function setUpMapData()
    {
	$this->place['Advertisement']['mapData'] = $this->parseProperties($this->place['Advertisement']['geoLocation']);
    }
    
    
    public function setUpPayU()
    {
	App::import('Vendor', 'payu', array('file' => 'openpayu.2.0.php'));	
	$this->loadModel('Advertisement');
	$payUInstallementOptions = $this->Advertisement->getPayu();
	$payUInstallementOptions['available_installments'] = array_merge(array(__('installement_options_no_install')), $payUInstallementOptions['available_installments']);
	
	$this->set(compact('payUInstallementOptions'));
    }
    
    public function setUpCurrentUserData()
    {
	$this->loadModel('TxUser');
	$currentUser = $this->TxUser->userData(CakeSession::read('User.Id'));
	$this->set(compact('currentUser'));
    }

    
    
    /*
     * data manipulations
     */
    function _cleanPicturesPathData($data)
    {
	$d = $data;
	$pictures = $d['Uploads'];
	foreach($pictures as $key=>$picture)
	{
	    unset($d['Uploads'][$key]['path']);
	}
	
	return $d;
    }    
}
?>