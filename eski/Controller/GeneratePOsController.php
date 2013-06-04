<?php
class GeneratePOsController extends AppController
{
    public $name = 'GeneratePOs';
    
    function index()
    {
        $results = $this->GeneratePO->query('select * from homelet.lu_system_messages');
        $this->set('poList',$results);
    }
}
   
?>
