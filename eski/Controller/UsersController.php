<?php
App::uses('Sanitize', 'Utility');
class UsersController extends AppController
{
    public $name = 'Users';
    
    
    function profile()
    {
	$userId = $this->Session->read('User.Id');
	
	$this->loadModel('TxUser');
        if($this->request->isPost() || $this->request->isPut())
        {
	    $this->User->set($this->request->data);

            if($this->User->validates())
            {
                $result = $this->TxUser->updateUser($this->request->data);
                if($result['success']==1)
                    $this->Session->setFlash('Bilgileriniz başarıyla güncellenmiştir','flash_notification',array('type'=>'success'));
                else
                    $this->Session->setFlash(__($result['message_text_id']),'flash_notification');
            } else
            {
                $this->Session->setFlash(__('checkYourData'),'flash_notification');
                
            }
        }

	$this->request->data = $this->TxUser->userData($userId);

	if(isset($uds['ldc_user_bank'])):
	    $bankAccountDetails = $uds['ldc_user_bank'];
	    $bankAccountDetails = $this->parseProperties($bankAccountDetails);

	    $d['User']['bankCity'] = $bankAccountDetails['cityId'];
	    $d['User']['bankName'] = $bankAccountDetails['bankId'];

	    $d['User']['bankPayeeTitle'] = $bankAccountDetails['title'];
	    $d['User']['bankOfficeName'] = $bankAccountDetails['branchName'];
	    $d['User']['bankOfficeCode'] = $bankAccountDetails['branchCode'];
	    $d['User']['bankAccountNo'] = $bankAccountDetails['accountNo'];
	    $d['User']['bankAccountIBAN'] = $bankAccountDetails['Iban'];
	endif;

	if(isset($uds['ldc_invoice_title'])):
	    $d['User']['taxTitle'] = $uds['ldc_invoice_title'];
	    $d['User']['taxOffice'] = $uds['ldc_invoice_tax_office'];
	    if(isset($uds['ldc_invoice_tax_id']) && $uds['ldc_invoice_tax_id']!='')
		$d['User']['taxNo'] = $uds['ldc_invoice_tax_id'];
	    if(isset($uds['ldc_user_tc_no']) && $uds['ldc_user_tc_no']!='')
		$d['User']['taxNo'] = $uds['ldc_user_tc_no'];
	    $d['User']['taxAddress'] = $uds['ldc_invoice_address'];
	    $d['User']['taxUserType'] = $uds['ldc_invoice_taxpayer'];
	endif;

	
        

        
        $selectBoxResult =  $this->User->getBankList();
        $items = array();
        foreach($selectBoxResult as $option)
        {
            $items[$option['lu_banking']['banking_id']] = $option['lu_banking']['message_text_id'];
        }
        $this->set('bankList', $items);                  

        $selectBoxResult =  $this->User->query('CALL prt_details_class_content(67,0)');
        $items = array();
        foreach($selectBoxResult as $option)
        {
            $items[$option['content']['id']] = $option['content']['message_text_id'];
        }
        $this->set('cities', $items);        
        
        $usersGroups = $this->User->userGroups();
	
	
        $this->set(compact('usersGroups'));
    }
    
    
    function profile_old()
    {
        $userId = $this->Session->read('User.Id');
        
        $this->User->validate = $this->User->validateForProfile;
        
        $loggedInUserId = CakeSession::read('User.Id');

        
        if($this->request->isPost() || $this->request->isPut())
        {
            $this->User->set( $this->request->data );
            if($this->User->validates())
            {
                $result = $this->User->userUpdate($this->request->data['User']['passwordConfirm'],$this->request->data);

                if($result[0]['lsm']['type'] == 'success')
                    $this->Session->setFlash('Bilgileriniz başarıyla güncellenmiştir');
                else
                    $this->Session->setFlash(__($result[0]['lsm']['message_text_id']));
                
                
            } else
            {
                $this->Session->setFlash(__('checkYourData'));
                
            }
            
            $this->request->data['User']['passwordConfirm'] = '';
            $this->request->data['User']['pass1'] = '';
            $this->request->data['User']['pass2'] = '';
        } else
        {
                     

            $user = $this->User->findByUserSId($userId);
            
            $d = $user;

            $userDetails = $this->User->getUserDetail($userId);

            
            
            $uds = array();
            foreach($userDetails as $userDetail)
            {
                if(isset($userDetail['ldc']))
                    $uds[$userDetail['ldc']['message_text_id']] = $userDetail['dsd']['user_detail'];
            }
            


            if(isset($uds['ldc_user_bank'])):
            $bankAccountDetails = $uds['ldc_user_bank'];
            $bankAccountDetails = $this->parseProperties($bankAccountDetails);

            $d['User']['bankCity'] = $bankAccountDetails['cityId'];
            $d['User']['bankName'] = $bankAccountDetails['bankId'];

            $d['User']['bankPayeeTitle'] = $bankAccountDetails['title'];
            $d['User']['bankOfficeName'] = $bankAccountDetails['branchName'];
            $d['User']['bankOfficeCode'] = $bankAccountDetails['branchCode'];
            $d['User']['bankAccountNo'] = $bankAccountDetails['accountNo'];
            $d['User']['bankAccountIBAN'] = $bankAccountDetails['Iban'];
            endif;
            
            if(isset($uds['ldc_invoice_title'])):
                $d['User']['taxTitle'] = $uds['ldc_invoice_title'];
                $d['User']['taxOffice'] = $uds['ldc_invoice_tax_office'];
                
                if(isset($uds['ldc_invoice_tax_id']) && $uds['ldc_invoice_tax_id']!='')
                    $d['User']['taxNo'] = $uds['ldc_invoice_tax_id'];
                
                if(isset($uds['ldc_user_tc_no']) && $uds['ldc_user_tc_no']!='')
                    $d['User']['taxNo'] = $uds['ldc_user_tc_no'];
                
                $d['User']['taxAddress'] = $uds['ldc_invoice_address'];
                $d['User']['taxUserType'] = $uds['ldc_invoice_taxpayer'];
            endif;
            
            

            $birthDate = $user['User']['birth_date'];

            $birthDate = explode('-',$birthDate);

            $d['User']['date_of_birth']['year'] = $birthDate[0];
            $d['User']['date_of_birth']['month'] = $birthDate[1];
            $d['User']['date_of_birth']['day'] = $birthDate[2];

            $d['User']['gender'] = $user['User']['gender_id'];
            $d['User']['email1'] = $user['User']['primary_email'];
            $d['User']['phoneNumber'] = $user['User']['phone'];

            $this->request->data = $d;
        }
        

        
        $selectBoxResult =  $this->User->getBankList();
        $items = array();
        foreach($selectBoxResult as $option)
        {
            $items[$option['lu_banking']['banking_id']] = $option['lu_banking']['message_text_id'];
        }
        $this->set('bankList', $items);                  

        $selectBoxResult =  $this->User->query('CALL prt_details_class_content(67,0)');
        $items = array();
        foreach($selectBoxResult as $option)
        {
            $items[$option['content']['id']] = $option['content']['message_text_id'];
        }
        $this->set('cities', $items);        
        
        $usersGroups = $this->User->userGroups();
	
	
        $this->set(compact('usersGroups'));
        
        
        //pr($this->User->getUserDetail($userId));
    }

    
    function userLoginHelp()
    {
        
        if($this->request->is('post'))
        {
            $this->User->set($this->request->data);
            if($this->User->validates())
            {
                $helpType = $this->request->data['User']['helpType'];
                $userMailAddress = $this->request->data['User']['email'];
                
                App::uses('CakeEmail', 'Network/Email');
                $cakeEmail = new CakeEmail();
                $cakeEmail->config('gmail');
                $cakeEmail->from(array('noreply@tatilevim.com' => 'tatilevim.com'));
                $cakeEmail->to($userMailAddress);
                $cakeEmail->emailFormat('text');                
                
                
                $sendMail = false;

                $user = $this->User->getUserByMail($userMailAddress);
                
                if(!isset($user['User']))
                {
                    $this->Session->setFlash('Belirttiğiniz e-posta adresi ile kayıtlı kullanıcımız bulunamadı');
                }
                else
                {   
                    switch($helpType)
                    {
                        case "forgotUserName":
                                $userName = $user['User']['uname'];
                                $cakeEmail->template('forgotMyUserName','blank'); 
                                $cakeEmail->viewVars(array('userName' => $userName));
                                $cakeEmail->subject('Kullanıcı Adı Hatırlatma   |   www.tatilevim.com');
                                $sendMail = true;
                            break;
                        case "forgotPassword":
                                $securityCodeForUser = $this->User->createSecurityCodeForNewPasswordRequest($user['User']['user_s_id']);
                                $cakeEmail->template('forgotMyPassword','blank'); 
                                $cakeEmail->viewVars(array('email' => $userMailAddress));                        
                                $cakeEmail->viewVars(array('securityCodeForUser' => $securityCodeForUser));  
                                $cakeEmail->subject('Şifre Yenileme   |   www.tatilevim.com');
                                $sendMail = true;
                            break;
                    }


                    if($sendMail)
                    {
                        if($cakeEmail->send())                   
                        {
                            $this->Session->setFlash('Talebiniz başarıyla alınmıştır. E-posta hesabınızı kontrol ediniz');
                            $this->redirect(array('controller' => 'users', 'action' => 'login'));
                        }
                        else
                            $this->Session->setFlash('İşlemin yapılırken bir hata oluştu, lütfen tekrar deneyiniz.');
                            
                    }

                }
            }   else
	    {
		$this->Session->setFlash('İşlemin yapılırken bir hata oluştu, lütfen tekrar deneyiniz.');
	    }
        }
        
    }
    
    
    
    
    function loginAfterFacebookRedirect()
    {
        App::import('Vendor', 'facebook', array('file' => 'facebook.php')); 

        $facebook = new Facebook(array(
          'appId'  => $this->fbAppId,
          'secret' => $this->fbAppSecret,
        ));      

        $user = $facebook->getUser();        
        
        if ($user) 
        {
          try
          {
            // Proceed knowing you have a logged in user who's authenticated.
            $user_profile = $facebook->api('/me');
          }
          catch (FacebookApiException $e) 
          {
            error_log($e);
            $user = null;
          }
        }
        
        if(isset($user_profile))
        {
            $this->set('userProfile',$user_profile);


            $facebookId = $user_profile['id'];
            $facebookEMail = $user_profile['email'];
            if($user_profile['middle_name']!='')
                $facebookName = $user_profile['first_name'] . ' ' . $user_profile['middle_name'];
            else
                $facebookName = $user_profile['first_name'];

            $facebookSName = $user_profile['last_name'];
            $facebookGender = $user_profile['gender'];
            $facebookDateOfBirth = $user_profile['birthday'];

            $a = explode('/',$facebookDateOfBirth);
            $a = array_reverse($a);
            $facebookDateOfBirth = implode('-', $a);

            if(CakeSession::check(('fb_'.$this->fbAppId.'_user_id')))
            {
		$this->mergeFavorites();
                $result = $this->User->query("call prt_fb_login(".$facebookId.",'".$facebookEMail."','".$facebookName."','".$facebookSName."','".$facebookGender."','".$facebookDateOfBirth."','')");

                $userId = $result[0][0]['user_s_id'];
                CakeSession::write('User.Id',$userId);
                CakeSession::write('User.LoggedIn',true);
                $this->setUserPermissions();
                $this->redirect('/');            
			
            }        
        }
    }    
    
    public $fbAppId = '165333916903567';
    public $fbAppSecret = '828c876e3e0eac70d6cdba07998d7f9f';
    
    function login()
    {
        if($this->request->referer(true) != Router::url(array('controller'=>'users','action'=>'login'))
                && $this->request->referer(true) != Router::url(array('controller'=>'users','action'=>'logViaAuthkey'))
                && $this->request->referer(true) != '/'
		&& CakeSession::read('User.loginRequesterPage') != 'byPass'
                )
        {
            CakeSession::write('User.loginRequesterPage',$this->request->referer(true));
        }
        
	if(CakeSession::read('User.loginRequesterPage') == 'byPass')
	    CakeSession::write('User.loginRequesterPage','/');
        
        
        $this->set('title_for_layout', 'Kullanıcı Girişi');
        $this->set('description_for_layout', '');
        
        if($this->request->is('post'))
        {
            $this->data = Sanitize::clean($this->data,array('encode'=>false));
            $this->User->set( $this->data );
            if ($this->User->validates()) 
            {
                $data = $this->request->data['User'];
                
                $result =  $this->User->query('CALL prt_login(
                                                                "'.$data['uname'].'",
                                                                "'.$data['pass'].'"
                                                                )');
                $message = __($result[0]['lsm']['message_text_id']);

                switch($result[0]['lsm']['type'])
                {
                    case "success":
                        $userId = $result[0]['0']['user_s_id'];
                        $this->_loginUser($userId);
			

                        
                        if(CakeSession::check('User.loginRequesterPage'))
                            $this->redirect (CakeSession::read('User.loginRequesterPage'));
                        else
                            $this->redirect('/');

                    break;
                    case "error":
                        $this->Session->setFlash($message);
                    break;
                }
            }
            else
            {
                    $this->Session->setFlash('Lütfen bilgilerinizi kontrol ediniz');
            }            

        }        
        
        
        
        
        App::import('Vendor', 'facebook', array('file' => 'facebook.php'));        
        
        
        $facebook = new Facebook(array(
          'appId'  => $this->fbAppId,
          'secret' => $this->fbAppSecret,
        ));      

        // Get User ID
        $user = $facebook->getUser();        
        
        if ($user) 
        {
          try
          {
            // Proceed knowing you have a logged in user who's authenticated.
            $user_profile = $facebook->api('/me');
          }
          catch (FacebookApiException $e) 
          {
            error_log($e);
            $user = null;
          }
        }
        


        
        $loginUrl = $facebook->getLoginUrl(array(
		'scope'	=> 'read_stream, publish_stream, user_birthday, email',
                'redirect_uri'	=> 'http://www.tatilevim.com/users/loginAfterFacebookRedirect'
		));
        $this->set('loginUrl',$loginUrl); 
        

        $this->set('user',$user);

    }
    
    
    
    function logOut($redirect = true)
    {
        CakeSession::write('User.Permissions','');
        CakeSession::write('User.Id','');
        CakeSession::write('User.LoggedIn','');        
        CakeSession::destroy();
        
	$this->Cookie->delete('favoriteList');
        
        if($redirect)
            $this->redirect('/');
    }
    
    
    function logViaAuthkey($authkey,$authUserId)
    {
        if($this->User->loginKeyLogin($authkey, $authUserId))
        {
        
            CakeSession::write('User.Id',$authUserId);
            CakeSession::write('User.LoggedIn',true);
            $this->setUserPermissions();   
	    
	    $this->mergeFavorites();
            
            if(CakeSession::check('User.loginRequesterPage'))
                $this->redirect (CakeSession::read('User.loginRequesterPage'));
            else
                $this->redirect(array('controller'=>'users','action'=>'login'));
        }else
        {
            $this->redirect(array('controller'=>'users','action'=>'login'));
        }
   
    }
    
    
    function activate($mail = null, $code = null)
    {
        $this->set('title_for_layout', 'Kullanıcı Aktivasyonu');
        $this->set('description_for_layout', '');
        
        
        if($mail==null)
        {
            if($this->Session->read('User.mail')!=null)
                $mail = $this->Session->read('User.mail');
        }        
        
        if($code==null)
        {
            if($this->request->is('post'))
            {
                $this->User->set( $this->data );
                if ($this->User->validates()) 
                {
                    $data = $this->request->data['User'];
                    $code = $data['activationCode'];
                }        
            }
        }
        
        if($mail!=null && $code!=null)
        {
            $result =  $this->User->query('CALL prt_user_confirm(
                                                            "'.$mail.'",
                                                            "'.$code.'"
                                                            )');


            $message = __($result[0]['lsm']['message_text_id']);
            switch($result[0]['lsm']['type'])
            {
                case "success":
                    $this->Session->setFlash('Aktivasyon işleminiz başarıyla tamamlandı, lütfen giriş yapınız.');
                    $this->redirect('/users/login');
                break;
                case "error":
                    $this->Session->setFlash($message);
                break;
            }   
        }
        $this->set('userMail',$mail);
    }
    
    
    function taxInfoAddUpdate($userId)
    {
        
    }
    
    function registerNew()
    {
	if ($this->request->isPost())
	{
	    $this->User->validate = $this->User->quickRegister;
	    $this->User->set($this->request->data);
	    
	    if ($this->User->validates($this->User->validate))
	    {
		$result = $this->User->registerNewUser($this->request->data);

		if ($result['success'] == 1)
		{
		    $this->Session->setFlash('Başarı ile kaydoldunuz. Lütfen e-posta adresinizi kontrol ederek aktivasyon işlemni tamamlayınız', 'flash_notification');
		    
		    
		    $this->_sendUserActivationCodeViaMail($this->request->data['User']['email'], $result['confirmCode']);
		    $this->redirect('activate');	    
		    //$this->redirect('/');
		} else
		{
		    $this->Session->setFlash(__($result['message_text_id']), 'flash_notification');
		}
	    } else
	    {

		$this->Session->setFlash('Lütfen bilgilerinizi kontrol ediniz', 'flash_notification');
		$this->request->data['User']['passwordNew'] ='';
		$this->request->data['User']['passwordCheck'] = '';
	    }
	}
    }
    
    function register($userId=null)
    {
        $this->set('title_for_layout', 'Yeni Kullanıcı Kaydı');
        $this->set('description_for_layout', '');
        
        $this->set('userId',$userId);
           

        if(!isset($this->userPermissions['lp_user_update']))
            $userId='';
        else
        {
            $results =  $this->User->query('SELECT * FROM vw_user_groups'); // tüm kullanıcı grupları
            $userGroups = array();
            foreach($results as $result)
            {
               $userGroups[$result['vw_user_groups']['group_id']] = $result['vw_user_groups']['message_text_id'];
            }
            $this->set('userGroups',$userGroups);            
        }
        
        
        
        if($this->request->is('post') || !empty($this->data))
        {
            $this->data = Sanitize::clean($this->data,array('encode'=>false));
            $this->User->set( $this->data );
            if ($this->User->validates()) 
            {
                $data = $this->request->data['User'];
                
                $dateOfBirth = $data['dateOfBirth']['year']."-".$data['dateOfBirth']['month']."-".$data['dateOfBirth']['day'];
                

                $result =  $this->User->query('CALL prt_user_registration(
                                                                "'.CakeSession::read('User.Id').'",
                                                                "'.$data['uname'].'",
                                                                "'.$data['email1'].'",
                                                                "'.$data['email2'].'",     
                                                                "'.$data['name'].'",
                                                                "'.$data['sname'].'",
                                                                "'.$data['pass1'].'",
                                                                "'.$data['pass2'].'",
                                                                "'.$data['gender'].'",
                                                                "'.$dateOfBirth.'",
                                                                "'.$data['phoneNumber'].'",
                                                                "'.$userId.'"
                                                                )');
                
                
                
        
                if(isset($this->userPermissions['lp_user_edit_banking_data'])) /// banka hesapları düzenleme için izin istenecek
                {
                    $this->User->addUserBankingDetail($result[0][0]['user_s_id'],$data['bankCity'],$data['bankName'],$data['bankPayeeTitle'],$data['bankOfficeName'],$data['bankOfficeCode'],$data['bankAccountNo'],$data['bankAccountIBAN']);
                }
                
                if(isset($this->userPermissions['lp_user_edit_invoice_data'])) /// fatura bilgilerini için izin istenecek
                {
                    foreach($data as $key=>$val)
                    {
                        $tx = $this->User->taxFormInputsDetailDBTextIdTransections();
                        if(isset($tx[$key]))
                        {
                             $this->User->addUserDetail($result[0][0]['user_s_id'] ,$tx[$key],$val);
                        }
                    }
                }                
                
                $message = __($result[0]['lsm']['message_text_id']);
                $confirmCode = $result[0][0]['confirm_code'];
                switch($result[0]['lsm']['type'])
                {
                    case "success":
                        // SAVE SELECTED GROUPS
                        if(isset($this->userPermissions['lp_user_update']))
                        {
                            if($userId=='')
                                $userId = $result[0][0]['user_s_id'];
                            
                            $selectedGroups = $data['group'];
                            foreach(array_keys($selectedGroups) as $selectedGroupKey)
                            {
                                $this->User->query('CALL prt_user_detail_add('.CakeSession::read('User.Id').','.$userId.', "'.$selectedGroupKey.'",'.$selectedGroups[$selectedGroupKey].')');
                            }
                            $userStatus = $data['status'];
                            $this->User->query('CALL prt_user_detail_add('.CakeSession::read('User.Id').','.$userId.', "du_status",'.$userStatus.')');  
                        }
                        
                        if($result[0]['lsm']['message_text_id'] == 'lsm_user_registration_successful')
                        {
                            $userId = $result[0][0]['user_s_id'];
                            $result =  $this->User->query('SELECT fn_user_group_add("dg_normal_user",'.$userId.')');
                            
                            $msg = 'tatilevim.com üyelik onay kodunuz: \n';
                            $msg.= $confirmCode.'\n\n';
                            $msg.= 'Onay işleminizi aşağıdaki bağlantı adresine gittikten sonra onay kodunuzu girerek gerçekleştirebilirsiniz \n';
                            $msg.= 'http://tatilevim.com/users/activate/'.$data['email1'].'/'.$confirmCode;
                            
                            App::uses('CakeEmail', 'Network/Email');
                            $cakeEmail = new CakeEmail();
                            $cakeEmail->config('gmail');
                            $cakeEmail->from(array('noreply@tatilevim.com' => 'tatilevim.com'));
                            $cakeEmail->to($data['email1']);
                            $cakeEmail->subject('tatilevim.com üyelik onayı');
                            $cakeEmail->emailFormat('text');
                            $cakeEmail->template('userActivated','blank'); 

                            $cakeEmail->viewVars(array('confirmCode' => $confirmCode));
                            $cakeEmail->viewVars(array('email' => $data['email1']));

                            $cakeEmail->send();                            
                            

                            $this->Session->write('User.mail', $data['email1']);
                            $this->Session->write('User.confirm_code', $confirmCode);
                            $this->redirect('activate');
                        } else if($result[0]['lsm']['message_text_id'] == 'lsm_user_update')
                        {
                            $this->Session->setFlash('Kullanıcı bilgilieri başarıyla güncellendi');
                            $this->redirect('/users');
                        }
                    break;
                    case "error":
                        $this->Session->setFlash($message);
                    break;
                }
            }
            else 
            {
                    $this->Session->setFlash('Lütfen bilgilerinizi kontorl ediniz');
            }            

        } else if($userId!='' && isset($this->userPermissions['lp_user_update']))
        {
            $result =  $this->User->query('SELECT * FROM vw_users_list WHERE user_s_id='.$userId);
            $user = $result[0]['vw_users_list'];
            

            
            $this->request->data['User']['id'] = $user['user_s_id'];
            $this->request->data['User']['uname'] = $user['uname'];
            $this->request->data['User']['name'] = $user['name'];
            $this->request->data['User']['sname'] = $user['sname'];
            $this->request->data['User']['email1'] = $user['primary_email'];
            $this->request->data['User']['email2'] = $user['primary_email'];
            $this->request->data['User']['pass1'] = $user['pass'];
            $this->request->data['User']['pass2'] = $user['pass'];
            $dateOfBirth = explode('-',$user['birth_date']);
            $this->request->data['User']['dateOfBirth']['month'] = $dateOfBirth[1];
            $this->request->data['User']['dateOfBirth']['day'] = $dateOfBirth[2];
            $this->request->data['User']['dateOfBirth']['year'] = $dateOfBirth[0];
            $this->request->data['User']['gender'] = $user['gender_id'];
            $this->request->data['User']['phoneNumber'] = $user['phone'];
            
            $userGroups =  $this->User->query('SELECT * FROM vw_users_groups WHERE user_s_id='.$userId);// kullanıcının dahil olduğu gruplar
            foreach($userGroups as $userGroup)
                $this->request->data['User']['group'][$userGroup['vw_users_groups']['message_text_id']] = 1;
            
            $userStatus = $this->User->query('SELECT status FROM vw_users_list WHERE user_s_id='.$userId);// kullanıcının dahil olduğu gruplar
            $this->request->data['User']['status'] = $userStatus[0]['vw_users_list']['status'];
            
            
            
            if(isset($this->userPermissions['lp_user_edit_banking_data']) || isset($this->userPermissions['lp_user_edit_invoice_data']))
            {
                $otherUserDetails = $this->User->getUserDetail($userId);
                
                $tx = $this->User->taxFormInputsDetailDBTextIdTransections();
                $tx = array_flip($tx);
                foreach($otherUserDetails as $userDetail)
                {
                    if(isset($userDetail['ldc']['message_text_id']))
                    {
                        $messageTextId = $userDetail['ldc']['message_text_id'];
                        if(isset($tx[$messageTextId]))
                        {
                            $this->request->data['User'][$tx[$messageTextId]] = $userDetail['dsd']['user_detail'];
                        }
                    }
                }
                
                $tx = $this->User->bankFormInputsDBTextIdTransections();
                $tx = array_flip($tx);
                if(isset($otherUserDetails['userBanks'][1]))
                {
                    foreach($otherUserDetails['userBanks'][1] as $key=>$bankDetail)
                    {
                        if(isset($tx[$key]))
                            $this->request->data['User'][$tx[$key]] = $bankDetail;
                    }
                }

            }
            
            if(isset($this->userPermissions['lp_user_edit_banking_data'])) /// banka hesapları düzenleme için izin istenecek
            {
                $selectBoxResult =  $this->User->getBankList();
                $items = array();
                foreach($selectBoxResult as $option)
                {
                    $items[$option['lu_banking']['banking_id']] = $option['lu_banking']['message_text_id'];
                }
                $this->set('bankList', $items);                  
                
                $selectBoxResult =  $this->User->query('CALL prt_details_class_content(67,0)');
                $items = array();
                foreach($selectBoxResult as $option)
                {
                    $items[$option['content']['id']] = $option['content']['message_text_id'];
                }
                $this->set('cities', $items);     
                
                $otherUserDetails = $this->User->getUserDetail($userId);
            }

            if(isset($this->userPermissions['lp_user_edit_invoice_data'])) /// fatura bilgilerini için izin istenecek
            {
                //fatura bilgileri set edilecek
            }               
            
        }
        $this->set('userId',$userId);
    }
    function index()
    {
        if(!isset($this->userPermissions['lp_user_show_admin_list']))
        {
            $this->Session->setFlash('Lütfen giriş yapınız.');
            $this->redirect('/users/login');
        }
        
        $this->paginate = array(
                                    'limit' => 10,
                                    'order' => array(
                                    'user_s_id' => 'desc'
                                    )
                                );
        
        $results = $this->paginate('User');
        $this->set('modelName','User');
        $this->set('users',$results);
    }
    
    function user($userId)
    {
        if(!isset($this->userPermissions['lp_user_show_admin_list']))
        {
            $this->Session->setFlash('Lütfen giriş yapınız.');
            $this->redirect('/users/login');
        }        
        $result =  $this->User->query('SELECT * FROM vw_users_list WHERE user_s_id='.$userId);
        $this->set('user',$result[0]['vw_users_list']);
    }    
    public $paginate = array(
        'limit' => 15
    );
    
    function delete($userId)
    {
        if(!isset($this->userPermissions['lp_user_delete']))
        {
            $this->Session->setFlash('Lütfen giriş yapınız.');
            $this->redirect('/users/login');
        }
                
        $result = $this->User->query('CALL prt_user_detail_add('.CakeSession::read('User.Id').','.$userId.', "du_status",3)');
        if($result[0]['lsm']['type']=='success')
            $this->Session->setFlash('Silme işlemi başarı ile gerçekleştirildi');
        else
            $this->Session->setFlash('Silme işlemi esnasında bir hata oluştu!');
        
        $this->redirect('/users');
    }
    
    
    function beforeFilter() 
    {
        parent::beforeFilter();
        
        if($this->action == 'index')
             $this->disableCache();
        if($this->action == 'register')
             $this->disableCache();
    }
    
    public function searchHouseHolder ()
    {
        if(!isset($this->userPermissions['lp_user_update']))
        {
            $this->Session->setFlash('Lütfen giriş yapınız.');
            $this->redirect('/users/login');
        }
                      
        $data = $this->request;
        $str = $data['data']['Advertisement']['householderSearch'];
        $results =  $this->User->query('SELECT * FROM vw_users_list_ajax WHERE user_detail LIKE "%'.$str.'%" LIMIT 5');  
        $houseHolders = array();
        foreach($results as $result)
        {
            $houseHolders[] = array('userId'=>$result['vw_users_list_ajax']['user_s_id'], 'userDetails'=>$this->parseProperties($result['vw_users_list_ajax']['user_detail']));
        }
        $this->set("houseHolders",$houseHolders);
        $this->layout = 'ajax';
    }  
    
    public function searchUser ()
    {
        $data = $this->request;
        if(isset($data['data']['UserSearch']['searchString']))
            $str = $data['data']['UserSearch']['searchString'];
        else
            $str = $data['data']['searchString'];
        
        $results =  $this->User->query('SELECT * FROM vw_users_list_ajax WHERE user_detail LIKE "%'.$str.'%" LIMIT 5');  
        $users = array();
        foreach($results as $result)
        {
            $users[] = array('userId'=>$result['vw_users_list_ajax']['user_s_id'], 'userDetails'=>$this->parseProperties($result['vw_users_list_ajax']['user_detail']));
        }
        $this->set("users",$users);
        $this->layout = 'ajax';
    }        
    
    public function searchBookingReleatedUsers ()
    {
        $data = $this->request;
        $str = $data['data']['searchString'];
        $results =  $this->User->query('SELECT * FROM vw_bookings_users_list_ajax WHERE user_detail LIKE "%'.$str.'%" LIMIT 5');  
        $users = array();
        foreach($results as $result)
        {
            $users[] = array('userId'=>$result['vw_bookings_users_list_ajax']['user_s_id'], 'userDetails'=>$this->parseProperties($result['vw_bookings_users_list_ajax']['user_detail']));
        }
        $this->set("users",$users);
        $this->layout = 'ajax';
        $this->render('search_user');
    }     
    
    public function getHouseHolder($id)
    {
        if(!isset($this->userPermissions['lp_user_update']))
        {
            $this->Session->setFlash('Lütfen giriş yapınız.');
            $this->redirect('/users/login');
        }
        return $this->User->getHouseHolder($id);
    }

    
    
    public function changePassword($email=null,$securityCode=null)
    {
        if(isset($email) && isset($securityCode))
        {
            if($this->request->is('post'))
            {
                $this->data = Sanitize::clean($this->data,array('encode'=>false));
                $this->User->set( $this->data );
                if ($this->User->validates()) 
                {
                    $resultMessage = $this->User->updateUserPassViaSecurityCodeForNewPassword($email,$securityCode,$this->request->data['User']['pass1']);
                    
                    switch($resultMessage)
                    {
                        case 'lsm_incorrect_code':
                                $this->Session->setFlash('Şifre yenileme talebiniz gerçekleştirilemiyor. Lütfen yeni talepte bulununuz.');
                                $this->redirect(array('controller' => 'users', 'action' => 'userLoginHelp'));
                            break;
                        case 'lsm_the_pasword_change':
                                $this->Session->setFlash('Şifreniz başarıyla yenilendi');
				CakeSession::write('User.loginRequesterPage','byPass');
                                $this->redirect(array('controller' => 'users', 'action' => 'login'));
                            break;
                        default:
                                $this->Session->setFlash('Bir hata oluştu, lütfen daha sonra tekrar deneyiniz.');
                                $this->redirect('/');
                            break;
                    }
                }
                else
                {
                    $this->Session->setFlash('Lütfen bilgilerinizi kontrol edin');
                }    

                unset($this->request->data['User']['pass1']);
                unset($this->request->data['User']['pass2']);
            }
        } else
        {
            
        }    
    }

    
}
?>
