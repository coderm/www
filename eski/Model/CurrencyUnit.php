<?php

class CurrencyUnit extends AppModel {

    public $name = 'CurrencyUnit';
    public $useTable = 'lu_currency_unit';
    public $primaryKey = 'currency_unit_id';

    public function getCurrencyUnit() {

        $results = $this->find('all', array('fields' => array('CurrencyUnit.currency_unit_id', 'CurrencyUnit.message_text_id')));
        $currencyUnit = array();
        foreach ($results as $result) {
            $currencyUnit[$result['CurrencyUnit']['currency_unit_id']] = $result['CurrencyUnit']['message_text_id'];
        }
        return $currencyUnit;
    }

    public function idToMessageTextId($id) {
        $this->recursive = -1;
        $result = Cache::read('currency_' . $id, 'luCache');
        if (!$result) {
            $result = $this->findByCurrencyUnitId($id);
            Cache::write('currency_' . $id, $result, 'luCache');
        }
        return $result['CurrencyUnit']['message_text_id'];
    }

}