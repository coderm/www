<?php
App::uses('Sanitize', 'Utility');
class UserGroupPermissionsController extends AppController {

    public $name = 'UserGroupPermissions';
   
    public function index()
    {
       $result = $this->UserGroupPermission->find('all',array('recursive' => 3));
       $this->set('permissions',$result);       

    }  

}