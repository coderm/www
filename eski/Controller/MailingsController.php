<?php
class MailingsController extends AppController
{
    public $name = 'Mailings';
    public $components = array('Cripto');      
    public function beforeFilter() 
    {
        parent::beforeFilter();
    }
    
    public function click($mailingLinkIdStr)
    {
        $mailingLinkId = $this->Cripto->decode($mailingLinkIdStr);;
        $this->loadModel('MailingLink');
        $this->MailingLink->updateAll(array('click_count'=>'click_count + 1'), array('id'=>$mailingLinkId));
        $mailingLink = $this->MailingLink->read(null, $mailingLinkId);
        $mailingId = $mailingLink['MailingLink']['mailing_id'];
        $mailingIdStr = $this->Cripto->encode($mailingId);
        $mailing = $this->Mailing->read(null, $mailingId);
        
        if(isset($this->request->params['named']['m']))
        {
        $this->loadModel('MailingInteraction');
        $mailAddress = $this->request->params['named']['m'];
        $data = array('mail_address' => $mailAddress, 'mailing_id' => $mailingId, 'mailing_link_id' => $mailingLinkId);
        $this->MailingInteraction->create();
        $this->MailingInteraction->save($data);
        }

        $view = new View($this);
        $html = $view->loadHelper('Html');
        
        $action = $mailingLink['MailingLink']['action'];
        $path = $mailingLink['MailingLink']['path'];
        
        $campaignPath = $mailing['Mailing']['campaign_path'];
        
        switch($action)
        {
            case 'go_path':
                $redirectUrl = $path;
            break;
            case 'show_in_browser':
                $redirectUrl = $html->url("/mailing/".$mailingIdStr."/index.html");
            break;  
            case 'show_home_page':
                $redirectUrl = $html->url("/");
            break;  
            case 'show_campaign_page':
                $redirectUrl = $campaignPath;
            break;   
            case 'unscribe':
                $redirectUrl = $html->url("/"); //ileride yaparız
            break;             
        }
        
        $this->redirect($redirectUrl);
    }
    
    public function image($idString,$imageName)
    {
        $id = $this->Cripto->decode($idString);
        
        if(isset($this->request->params['named']['m']))
        {
            $this->loadModel('MailingInteraction');
            $mailAddress = $this->request->params['named']['m'];
            $data = array('mail_address' => $mailAddress, 'mailing_id' => $id, 'image_viewed' => 1);
            $this->MailingInteraction->create();
            $this->MailingInteraction->save($data);
        }
        
        $this->Mailing->updateAll(array('image_view_count'=>'image_view_count + 1'), array('id'=>$id));
        $this->layout = 'blank'; 
    }
    
    public function index() 
    {
        $this->Mailing->recursive = 0;
        $mailings = $this->paginate();
        foreach($mailings as $key=>$mailing)
        {
            $mailing['Mailing']['idStr'] = $this->Cripto->encode($mailing['Mailing']['id']);
            $mailings[$key] = $mailing;
        }
        $this->set('mailings', $mailings);
    }
    public function view($idString = null) 
    {
        $id = $this->Cripto->decode($idString);
        $this->Mailing->id = $id;
        if (!$this->Mailing->exists()) 
        {
            throw new NotFoundException(__('Böyle bir mailing yok!'));
        }
        $mailing = $this->Mailing->read(null, $id);
        $mailing['Mailing']['idStr'] = $this->Cripto->encode($mailing['Mailing']['id']);
        $this->set('mailing', $mailing);
    }

    public function add() 
    {
        if ($this->request->is('post')) 
        {
            $this->Mailing->create();
            if ($this->Mailing->save($this->request->data)) 
            {
                $this->Session->setFlash(__('Mailing oluşturuldu'));
                $this->redirect(array('action' => 'index'));
            } 
            else
            {
                $this->Session->setFlash(__('Mailing kaydedilemedi, lütfen tekrar deneyin.'));
            }
        }
    }

    public function edit($idString = null) 
    {
        $id = $this->Cripto->decode($idString);
        $this->Mailing->id = $id;
        if (!$this->Mailing->exists()) 
        {
            throw new NotFoundException(__('Böyle bir mailing yok!'));
        }
        if ($this->request->is('post') || $this->request->is('put'))
        {
            if ($this->Mailing->save($this->request->data)) 
            {
                $this->Session->setFlash(__('Mailing kaydedildi'));
                $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('Mailing kaydedilemedi, lütfen tekrar deneyin.'));
            }
        } 
        else
        {
            $this->request->data = $this->Mailing->read(null, $id);
        }
    }

    public function delete($idString = null) 
    {
        
        $id = $this->Cripto->decode($idString);        

        $this->Mailing->id = $id;
        if (!$this->Mailing->exists()) 
        {
            throw new NotFoundException(__('Böyle bir mailing yok!'));
        }
        if ($this->Mailing->delete()) 
        {
            $this->Session->setFlash(__('Mailing silindi'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Mailing silinemedi!'));
        $this->redirect(array('action' => 'index'));
    }
    
    function sendNextMail()
    {
        $customerMail = "squallata@hotmail.com";
        
        App::uses('CakeEmail', 'Network/Email');
        $cakeEmail = new CakeEmail();
        $cakeEmail->config('gmail');
        $cakeEmail->from(array('noreply@tatilevim.com' => 'tatilevim.com'));
        $cakeEmail->to($customerMail);
        $cakeEmail->subject('tatilevim.com erken rezervasyon kampanyası');
        $cakeEmail->emailFormat('html');
        $cakeEmail->template('mailing/test'); 

        //$cakeEmail->viewVars(array('booking' => $booking));

        if($cakeEmail->send())
            echo "mail gönderildi";
    }
}