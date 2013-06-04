<?php
class Contact extends AppModel {
    var $name = 'Contact'; 
    var $useTable = false; 
 
    var $validate = array(
        'name' => array(
            'rule' => '/.+/',
            'allowEmpty' => false,
            'required' => true,
            'message' => 'Bu alan boş bırakılamaz'
        ),
        'sname' => array(
            'rule' => '/.+/',
            'allowEmpty' => false,
            'required' => true,
            'message' => 'Bu alan boş bırakılamaz'
        ),        
        'subject' => array(
            'rule' => array('minLength', 5),
            'message' => 'Konu 5 karakterden az olamaz'
        ),
        'email' => array(
            'rule' => 'email',
            'message' => 'Lütfen mail adresinizi kontrol ediniz'
        ),
    );
 
    // This is where the magic happens
    public $_schema = array (
            'name' => array('type' => 'string', 'length' => 60),
            'email' => array('type' => 'string', 'length' => 60),
            'message' => array('type' => 'text', 'length' => 2000),
            'subject' => array('type' => 'string', 'length' => 100),
        );
    
}
?>
