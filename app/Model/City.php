<?php

class City extends AppModel {

    public $name = 'City';
    public $useTable = 'lu_city';
    public $primaryKey = 'city_id';

    public function idToMessageTextId($id) {
        $this->recursive = -1;
        $result = Cache::read('city_' . $id, 'luCache');
        if (!$result) {
            $result = $this->findByCityId($id);
            Cache::write('city_' . $id,  $result,'luCache');
        }
        return $result['City']['message_text_id'];
    }

}