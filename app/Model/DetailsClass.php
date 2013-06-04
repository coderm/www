<?php

class DetailsClass extends AppModel {

    public $name = 'DetailsClass';
    public $useTable = 'lu_details_class';
    public $primaryKey = 'detail_class_id';
       public function idToMessageTextId($id) {
        $this->recursive = -1;
        $result = Cache::read('detail_class_' . $id, 'luCache');
        if (!$result) {
            $result = $this->findByDetailClassId($id);
          Cache::write('detail_class_' . $id, $result,'luCache');
        }
        return $result['DetailsClass']['message_text_id'];
    }

}