<?php

class County extends AppModel {

    public $name = 'County';
    public $useTable = 'lu_county';
    public $primaryKey = 'county_id';

    public function idToMessageTextId($id) {
        $this->recursive = -1;
        $result = Cache::read('county_' . $id, 'luCache');
        if (!$result) {
            $result = $this->findByCountyId($id);
            Cache::write('county_' . $id, $result, 'luCache');
        }
        return $result['County']['message_text_id'];
    }

}