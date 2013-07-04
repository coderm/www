<?php
class ContactsController extends AppController
{
    public $name = 'Contacts';
    
    
    public function index($advertId=null)
    {
        if($this->request->is('post'))
        {
            $this->Contact->create($this->data); 
            if($this->Contact->validates())
            {
                App::uses('CakeEmail', 'Network/Email');
                $cakeEmail = new CakeEmail();
                $cakeEmail->config('gmail');
                $cakeEmail->from(array($this->data['Contact']['email'] => $this->data['Contact']['name'].' '.$this->data['Contact']['sname']));
                $cakeEmail->to('info@tatilevim.com');
                $cakeEmail->subject('[tatilevim.com iletişim formu mesajı] '.$this->data['Contact']['subject']);

                $message = $this->data['Contact']['message']."\n\n";
                $message.= "Gönderen bilgisi:\n";
                $message.= $this->data['Contact']['name'].' '.$this->data['Contact']['sname']."\n";
                $message.= $this->data['Contact']['email']."\n";
                $message.= $this->data['Contact']['phoneNumber']."\n";
                if ($cakeEmail->send($message))
                {
		    $this->Session->setFlash('Mesajınız alınmıştır, en kısa zamanda size geri dönüş yapılacaktır.', 'flash_notification',array('type'=>'success'));
                    $this->redirect('/');
                } else {
                    $this->Session->setFlash('Mesajınız gönderilirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.', 'flash_notification');
                }
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Lütfen bilgileriniz kontrol ediniz.', 'flash_notification');
            }
        }
    }
}
?>
