<?php

class UserGroupDetail extends AppModel {

    public $name = 'UserGroupDetail';
    public $useTable = 'dt_user_group_details';
    public $primaryKey = 'user_group_detail_id';
    public $belongsTo = array(
        'DetailsClass' => array(
            'className' => 'DetailsClass',
            'foreignKey' => 'detail_class_id',
            'type' => 'inner'
        )
    );

    public function userDetails($id) {
        $this->recursive = -1;

        $results = $this->find('all', array('conditions' => array('user_group_sellect_id' => $id)));
        $datas = array();
        foreach ($results as $result) {
            $datas[$this->DetailsClass->idToMessageTextId($result['UserGroupDetail']['detail_class_id'])] = $result['UserGroupDetail']['user_group_detail'];
        }
        return $datas;
    }

}

?>
