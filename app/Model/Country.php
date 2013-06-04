<?php

class Country extends AppModel {

    public $name = 'Country';
    public $useTable = 'lu_country';
    public $primaryKey = 'country_id';

    public function idToMessageTextId($id) {
        $this->recursive = -1;
        $result = Cache::read('country_' . $id, 'luCache');
        if (!$result) {
            $result = $this->findByCountryId($id);
            Cache::write('country_' . $id, $result, 'luCache');
        }
        return $result['Country']['message_text_id'];
    }

}