<?php
class AdvertsClass extends AppModel
{
    public $name = 'AdvertsClass';
    public $useTable = 'lu_adverts_class';
    public $primaryKey = 'advert_class_id';
   /*     public $belongsTo = array(
        'upClass' => array(
            'className' => 'AdvertsClass',
            'foreignKey' => 'up_class_id',
            'type' => 'inner'
            
        ));
    */
      public function getAccommodationTypes()
    {
       $results = $this->find('all', array('conditions' => array('AdvertsClass.enable' => '1'), 'fields' => array('AdvertsClass.advert_class_id', 'AdvertsClass.message_text_id')));
    
        $accommodationTypeOptions = array();
	foreach ($results as $result) {
            $accommodationTypeOptions[$result['AdvertsClass']['advert_class_id']] = __($result['AdvertsClass']['message_text_id']) ;
        } 
        return $accommodationTypeOptions;
    }
     public function idToMessageTextId($id)
    {
         $result = $this->findByAdvertClassId($id);
         return $result['AdvertClass']['message_text_id'];         
    }
    
    
}