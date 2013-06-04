<?php
class MailingLinksController extends AppController
{
    public $name = 'MailingLinks';
    public $components = array('Cripto');      
    public function beforeFilter() 
    {
        parent::beforeFilter();
    }
    public function index() 
    {
        $this->MailingLink->recursive = 0;
        $mailingLinks = $this->paginate();
        foreach($mailingLinks as $key=>$mailingLink)
        {
            $mailingLink['MailingLink']['idStr'] = $this->Cripto->encode($mailingLink['MailingLink']['id']);
            $mailingLinks[$key] = $mailingLink;
        }
        $this->set('mailingLinks', $mailingLinks);
    }
    public function view($idString = null) 
    {
        $id = $this->Cripto->decode($idString);
        $this->MailingLink->id = $id;
        if (!$this->MailingLink->exists()) 
        {
            throw new NotFoundException(__('Böyle bir mailing linki yok!'));
        }
        $mailingLink = $this->MailingLink->read(null, $id);
        $mailingLink['MailingLink']['idStr'] = $this->Cripto->encode($mailingLink['MailingLink']['id']);
        $this->set('mailingLink', $mailingLink);
    }

    public function add() 
    {
        if ($this->request->is('post')) 
        {
            $this->MailingLink->create();
            if ($this->MailingLink->save($this->request->data)) 
            {
                $this->Session->setFlash(__('Mailing linki oluşturuldu'));
                $this->redirect(array('action' => 'index'));
            } 
            else
            {
                $this->Session->setFlash(__('Mailing linki kaydedilemedi, lütfen tekrar deneyin.'));
            }
        }
        $this->set('mailingList',$this->getMailingList());
        $this->set('actionList',$this->getActionList());
    }

    public function edit($idString = null) 
    {
        $id = $this->Cripto->decode($idString);
        $this->MailingLink->id = $id;
        if (!$this->MailingLink->exists()) 
        {
            throw new NotFoundException(__('Böyle bir mailing linki yok!'));
        }
        if ($this->request->is('post') || $this->request->is('put'))
        {
            if ($this->MailingLink->save($this->request->data)) 
            {
                $this->Session->setFlash(__('Mailing linki kaydedildi'));
                $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('Mailing linki kaydedilemedi, lütfen tekrar deneyin.'));
            }
        } 
        else
        {
            $this->request->data = $this->MailingLink->read(null, $id);
        }
    }

    public function delete($idString = null) 
    {
        
        $id = $this->Cripto->decode($idString);        

        $this->MailingLink->id = $id;
        if (!$this->MailingLink->exists()) 
        {
            throw new NotFoundException(__('Böyle bir mailing linki yok!'));
        }
        if ($this->MailingLink->delete()) 
        {
            $this->Session->setFlash(__('Mailing linki silindi'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Mailing linki silinemedi!'));
        $this->redirect(array('action' => 'index'));
    }
    
    function getMailingList()
    {
        $this->loadModel('Mailing');
        $mailings = $this->Mailing->find('all');
        $mailingList = array();
        foreach($mailings as $key=>$mailing)
        {
            $id = $mailing['Mailing']['id'];
            //$idStr = $this->Cripto->encode($mailing['Mailing']['id']);
            $mailingList[$id] = '['.$mailing['Mailing']['created'].']'.$mailing['Mailing']['mailing_name'];
        }
        return $mailingList;
    }
    
    function getActionList()
    {
        $a = array();
        $a['go_path'] = 'Bağlantıya git';
        $a['show_in_browser'] = 'Browserda göster';
        $a['show_home_page'] = 'Ana sayfaya git';
        $a['show_campaign_page'] = 'Kampanya sayfasına git';
        $a['unscribe'] = 'Mailing listesinden ayrıl';
        return $a;
    }
}