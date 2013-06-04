<?php
App::uses('Sanitize', 'Utility');
class CommentsController extends AppController
{
    public $name = 'Comments';
    public $helpers = array('Number');
    
    public function beforFilter()
    {
        
    }
    
    public function index()
    {
        if(!$this->userPermissions['lp_user_view_passive_comment'])
        {
            $this->Session->setFlash(__('pleaseLoginFirst'));
            $this->redirect(array('controller'=>'users','action'=>'login'));
        }        
        
        $comments = $this->Comment->getComment();
        $comments = Sanitize::clean($comments, array('encode' => false));
        $this->set(compact('comments'));
        

        
    }
    
    public function add()
    {
        if($this->request->isPost() && isset($this->request->data['Comment']['advertId']))
        {
            
            $message = '';
            $this->helpers = array('Html','Form','Js','Session','Number');
        
            $this->layout = 'ajax';
            
            $advertId = $this->request->data['Comment']['advertId'];
            
            if(strlen(trim($this->request->data['Comment']['comment']))==0)
            {
                $message = 'Lütfen yorumunuzu yazınız';
            } else
            {
                if(isset($this->request->data['Comment']['checkInCheckOut']))
                {
                    $result = $this->Comment->addComment($advertId,
                                                        $this->request->data['Comment']['comment'],
                                                        $this->request->data['Comment']['checkInCheckOut'],
                                                        $this->request->data['Comment']['cleaning'],
                                                        $this->request->data['Comment']['comfort'],
                                                        $this->request->data['Comment']['valueOfMoney']
                                                        );
                } else
                {
                    $result = $this->Comment->addComment($advertId,$this->request->data['Comment']['comment']);
                }
                
               

                if($result[0]['lsm']['type'] == 'success')
                {
                        $message = 'Yorumunuz başarıyla alınmıştır. <u>Yönetici onayından sonra yayınlanacaktır.</u>';
                } else
                {
                    $message = 'Yorum ekleme esnasında bir hata oluştu!';
                }
            }
            

            $showRatingInputs = false;
            if(CakeSession::read('User.LoggedIn'))
            {
                $this->loadModel('User');
                $r = $this->User->UserRateAdvert($advertId);
                if($r>0)
                    $showRatingInputs = true;
            }

            $this->set(compact('showRatingInputs'));       
            
            
            $comments = $this->Comment->getComment($advertId);

            $comments = Sanitize::clean($comments, array('encode' => false));
            
            
            $this->set('isAjax',true);
            $this->set(compact('comments'));
            $this->set(compact('advertId'));
            $this->set(compact('message'));
            $this->request->data['Comment']['comment'] = '';
            
            
        }
    }
    
    public function listView($advertId,$page)
    {
            $message = '';
            $this->helpers = array('Html','Form','Js','Session','Number');
            $this->layout = 'ajax';
            $showRatingInputs = false;
            if(CakeSession::read('User.LoggedIn'))
            {
                $this->loadModel('User');
                $r = $this->User->UserRateAdvert($advertId);
                if($r>0)
                    $showRatingInputs = true;
            }

            $this->set(compact('showRatingInputs'));       
            
            
            $comments = $this->Comment->getComment($advertId,$page);

            $comments = Sanitize::clean($comments, array('encode' => false));
            
            
            $this->set('isAjax',true);
            $this->set(compact('comments'));
            $this->set(compact('advertId'));
            $this->set(compact('message'));
            $this->set(compact('page'));
            $this->request->data['Comment']['comment'] = '';
    }
    
    public function updateStatus($status,$commentId)
    {
        if(!$this->userPermissions['lp_user_comfirm_comment'])
        {
            $this->Session->setFlash(__('pleaseLoginFirst'));
            $this->redirect(array('controller'=>'users','action'=>'login'));
        }
        
        $this->Comment->comfirmComment($commentId,$status);
        $this->redirect($this->referer());
    }
    
    
    public function sendFeedbackMails()
    {
        $this->loadModel('User');
        $this->loadModel('Advertisement');
        $results = $this->User->commentMailList();
	
	if(is_array($results))
	{
	    foreach($results as $result):
		$this->sendMail('feedBack',$result);
	    endforeach;
	} else
	{
	    pr('Gönderilecek mail bulunamadı');
	    die;
	}
}
    
    private function sendMail($mailType, $data)
    {
        App::uses('CakeEmail', 'Network/Email');
        $cakeEmail = new CakeEmail();        
        
        switch($mailType)
        {
            case 'feedBack':
                $advertId = $data['db']['advert_id'];
                $userId = $data['db']['renter_user_s_id'];
                $clientName = $data['dt_users']['name'];
                $clientSName = $data['dt_users']['sname'];
                $clientEmail = $data['dud']['renter_email'];
                $autoLoginKey = $data['dud2']['login_key'];
                $checkInDate = $data['db']['start_date'];
		
		$checkInDate = explode('-', $checkInDate);
		$checkInDate = $checkInDate[2].'/'.$checkInDate[1].'/'.$checkInDate[0];
		
		
                

                $advert = $this->Advertisement->getAdvert2($advertId);
                $advert = $this->parseAdvert($advert,'vw_get_adverts');
                $advertURL = Router::url($advert['vw_get_adverts']['urlOptions']);                
                $advertURL = 'http://tatilevim.com'.$advertURL.'/authUserId:'.$userId.'/authKey:'.$autoLoginKey.'/showOffset:commentsContainer';
                
                $subject = 'Görüşlerinizi Önemsiyoruz!';
                $template = 'comment_feedback';
                $mailAdressToSend = $clientEmail;
                
                          
                
                break;
        }        

        $cakeEmail->config('commentFeedback');
        $cakeEmail->from(array('noreply@tatilevim.com' => 'tatilevim.com'));
        $cakeEmail->to($mailAdressToSend);
        $cakeEmail->subject($subject);
        $cakeEmail->emailFormat('html');
        $cakeEmail->template($template,'blank'); 
        $cakeEmail->helpers(array('Html', 'Number'));

        
        switch ($mailType)
        {
            case 'feedBack':
                $cakeEmail->viewVars(array('clientName' => $clientName));
                $cakeEmail->viewVars(array('clientSName' => $clientSName));
                $cakeEmail->viewVars(array('autoLoginKey' => $autoLoginKey));            
                $cakeEmail->viewVars(array('advertURL' => $advertURL));     
                $cakeEmail->viewVars(array('advertId' => $advertId));   
                $cakeEmail->viewVars(array('checkInDate' => $checkInDate)); 
                
                break;
        }
        
        
        if($cakeEmail->send())
        {
            switch($mailType)
            {
                case 'feedBack':
                    $this->loadModel('User');
                    $this->User->commentMailSent($data['db']['booking_id']);
                    break;
                default:
                    break;
            }
        }
        else
        {
                pr("bir hata oluştu");
        }
    }    
    
}
?>
