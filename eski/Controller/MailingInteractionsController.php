<?php
class MailingInteractionsController extends AppController
{
    public $name = 'MailingInteractions';
    public $components = array('Cripto');      
    public function beforeFilter() 
    {
        parent::beforeFilter();
    }
    public function index() 
    {
        $this->MailingInteraction->recursive = 0;
        $mailingInteractions = $this->paginate();
        $this->set('mailings', $mailingInteractions);
    }
}