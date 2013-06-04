<?php

class Neighborhood extends AppModel {

    public $name = 'Neighborhood';
    public $useTable = 'lu_neighborhood';
    public $primaryKey = 'neighborhood_id';

    public function idToMessageTextId($id) {
        $this->recursive = -1;
        $result = Cache::read('neighborhood_' . $id, 'luCache');
        if (!$result) {
            $result = $this->findByNeighborhoodId($id);
            Cache::write('neighborhood_' . $id, $result, 'luCache');
        }
        if (isset($result['Neighborhood']['message_text_id']))
            return $result['Neighborhood']['message_text_id'];
        else
            return 'NULL';
    }

}