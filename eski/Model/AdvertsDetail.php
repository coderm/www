<?php
class AdvertsDetail extends AppModel
{
    public $name = 'AdvertsDetail';
    public $useTable = 'dt_advert_details';
    public $primaryKey = 'advert_detail_id';
        public $belongsTo = array(
        'class' => array(
            'className' => 'DetailsClass',
            'foreignKey' => 'detail_class_id',
            'type' => 'inner'
        ));
}