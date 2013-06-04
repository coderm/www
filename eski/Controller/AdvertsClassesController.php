<?php

class AdvertsClassesController extends AppController {

    public $helpers = array('Html', 'Form');
    public $name = 'AdvertsClasses';

    public function index() {


        if ($this->request->is('post')) {
            $sql = 'DROP TABLE tx_adv_cls_dtl_cls;
                        CREATE TABLE `tx_adv_cls_dtl_cls` (
                        `adv_cls_dtl_cls_id` int(4) NOT NULL AUTO_INCREMENT,
                        `detail_class_id` int(3) NOT NULL,
                        `advert_class_id` int(3) NOT NULL,
                        `enable` tinyint(1) NOT NULL DEFAULT "1",
                        PRIMARY KEY (`adv_cls_dtl_cls_id`),
                        KEY `detail_class_id` (`detail_class_id`),
                        KEY `advert_class_id` (`advert_class_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;INSERT INTO
                                                  tx_adv_cls_dtl_cls(
                                                    detail_class_id
                                                   ,advert_class_id
                                                   ,enable)
                                                VALUES';
            foreach ($this->request->data['AdvertsClassDetails'] as $detailclass => $data) {
                foreach ($data as $advertclass => $data2) {
                    $sql .= '( ' . $detailclass . ',' . $advertclass . ',1),';
                }
            }
            $sql = trim($sql, ',');
            $this->AdvertsClass->query($sql);
        }

        $this->set('AdvertsClasses', $this->AdvertsClass->find('all', array('order' => array('AdvertsClass.ordered'))));
        $this->loadModel('DetailsClass');
        $this->set('DetailsClasses', $this->DetailsClass->find('all', array('order' => array('DetailsClass.ordered'))));
    }

    public function order($path = null, $id = null, $upto = 1) {

        if ($path == 'up') {
            $this->loadModel('DetailsClass');
            $result = $this->DetailsClass->findByDetailClassId($id);
            $ordered = $result['DetailsClass']['ordered'];
            $upto = $ordered - $upto;
            if ($upto < 0)
                $upto = 0;
            if ($ordered > 0) {
                $this->AdvertsClass->query('Update lu_details_class SET ordered = ' . $ordered . ' WHERE ordered = ' . $upto);
                $this->AdvertsClass->query('Update lu_details_class SET ordered = ' . $upto . ' WHERE detail_class_id = ' . $id);
            }
        }
        if ($path == 'down') {
            $this->loadModel('DetailsClass');
            $result = $this->DetailsClass->findByDetailClassId($id);
            $ordered = $result['DetailsClass']['ordered'];
            $upto = $ordered + $upto;
            $this->AdvertsClass->query('Update lu_details_class SET ordered = ' . $ordered . ' WHERE ordered = ' . $upto);
            $this->AdvertsClass->query('Update lu_details_class SET ordered = ' . $upto . ' WHERE detail_class_id = ' . $id);
        }


        $this->loadModel('DetailsClass');
        $this->set('DetailsClasses', $this->DetailsClass->find('all', array('order' => array('DetailsClass.ordered'))));
    }

}