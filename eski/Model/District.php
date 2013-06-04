<?php

class District extends AppModel {

    public $name = 'District';
    public $useTable = 'lu_district';
    public $primaryKey = 'district_id';

    public function idToMessageTextId($id) {
        $this->recursive = -1;
        $result = Cache::read('district_' . $id, 'luCache');
        if (!$result) {
            $result = $this->findByDistrictId($id);
            Cache::write('district_' . $id, $result, 'luCache');
        }
        return $result['District']['message_text_id'];
    }

}