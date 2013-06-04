<?php
class AdvertClassDetail extends AppModel
{
    public $name = 'AdvertClassDetail';
    public $useTable = 'tx_adv_cls_dtl_cls';
    public $primaryKey = 'adv_cls_dtl_cls_id';
    public $belongsTo = array(
        'AdvertClass' => array(
            'className' => 'AdvertsClass',
            'foreignKey' => 'advert_class_id'
        ));
}