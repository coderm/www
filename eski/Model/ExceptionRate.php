<?php

class ExceptionRate extends AppModel {

    public $name = 'ExceptionRate';
    public $useTable = 'dt_advert_exception_rates';
    public $primaryKey = 'exception_rate_id';
    public $belongsTo = array(
        'CreatedUser' => array(
            'className' => 'TxUser',
            'foreignKey' => 'created_user_s_id'
        ),
        'ModifiedUser' => array(
            'className' => 'TxUser',
            'foreignKey' => 'modified_user_s_id'
        )
    );

    public function advertMinPrice($advertId) {
        $this->recursive = -1;
        $params = array();
        $params['conditions']['advert_id'] = $advertId;
        $params['conditions']['start_date <='] = date("Y-m-d", mktime(0, 0, 0, date("m") + 3, date("d"), date("Y")));
        $params['conditions']['end_date >='] = date("Y-m-d", time());
        $params['fields'] = array('ifnull(min(demand),0) AS demand ,DATEDIFF("' . $params['conditions']['start_date <='] . '" , "' . $params['conditions']['end_date >='] . '") - ifnull(sum(
            DATEDIFF(if(end_date > "' . $params['conditions']['start_date <='] . '", "' . $params['conditions']['start_date <='] . '", end_date)
         , if(start_date < "' . $params['conditions']['end_date >='] . '", "' . $params['conditions']['end_date >='] . '", start_date))),0)  notSetDays');
        $result = $this->find('all', $params);
        $return = array();
        $return['demand'] =$result['0']['0']['demand'];
        $return['notSetDays'] =$result['0']['0']['notSetDays'];
        return $return;
    }

}