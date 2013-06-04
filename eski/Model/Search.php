<?php

class Search extends AppModel {

    public $name = 'Search';
    public $useTable = false;
    public $validate = array
            (
    );

    public function find($type = 'first', $query = array()) {
       $md5String = md5(serialize($query));
       if (CakeSession::read('User.LoggedIn')) {
            $results = parent::find($type, $query);
            Cache::write('search_' . $md5String, $results, 'searchCache');
        } else {
              $results = Cache::read('search_' . $md5String, 'searchCache');
            if (!$results) {
                $results = parent::find($type, $query);
                Cache::write('search_' . $md5String, $results, 'searchCache');
            }
        }

        return $results;
    }

    function getNewSearchString($location, $startDate, $endDate, $sqlString) {
        if ($startDate == '' || $endDate == '')
            $daysTotal = 1;
        else
            $daysTotal = 0;
        $md5String = md5(serialize(md5(serialize($location)) .md5(serialize($startDate)) .md5(serialize($endDate)) .md5(serialize($daysTotal)) .md5(serialize($sqlString))  ));
        $results = Cache::read('search_string_' . $md5String, 'hourly');
        if (!$results) {
            $results = $this->query('CALL prt_adverts_src_id_results("' . $location . '","' . $startDate . '","' . $endDate . '","' . $daysTotal . '","' . $sqlString . '")');
            Cache::write('search_string_' . $md5String, $results, 'hourly');
        }
        $searchQuery = $results[0][0]['_sqlstring'];
        //$results = $this->find('all',array( 'conditions' => array('1' => $searchQuery)));
        return $searchQuery;
    }

    function getDetails() {

        $results = Cache::read('prt_adverts_class_detail_0', 'daily');
        if (!$results) {
            $results = $this->query('CALL prt_adverts_class_detail(0)');
            Cache::write('prt_adverts_class_detail_0', $results, 'daily');
        }


        $details = array();
        foreach ($results as $result) {
            $elementType = $result['ldct']['form_element_type'];

            if ($elementType == 'checkbox') {
                if (!isset($details[$result['ldct']['message_text_id']]))
                    $details[$result['ldct']['message_text_id']] = array();

                $details[$result['ldct']['message_text_id']]['items'][] = $result;
                $details[$result['ldct']['message_text_id']]['ldc']['message_text_id'] = $result['ldct']['message_text_id'];
                $details[$result['ldct']['message_text_id']]['type'] = 'multiElements';
                $details[$result['ldct']['message_text_id']]['ldc']['properties'] = $result['ldc']['properties'];
                $details[$result['ldct']['message_text_id']]['ldct']['form_element_type'] = $result['ldct']['form_element_type'];
            } else {
                $details[$result['ldc']['message_text_id']] = $result;
                $details[$result['ldc']['message_text_id']]['type'] = 'sinlgeElement';
            }
            /*
              $items = array();
              foreach($result as $element)
              {
              if($formElement['parentKey'] == $element['ldct']['message_text_id'])
              array_push($items, $element['ldc']);
              }
              $formElements[$formElement['parentKey']]['detail_class_id'] = null;
              $formElements[$formElement['parentKey']]['items'] = $items;
             */
        }
        return $details;
    }

    function getDetailedSearchElements() {
        $results = $this->getDetails();
        $details = array();
        foreach ($results as $result) {
            if (isset($result['ldc']['properties'])) {
                $resultProperties = $result['ldc']['properties'];
                $properties = $this->parseProperties($resultProperties);
                if (isset($properties['search_criteria_type'])) {
                    $result['search_criteria_type'] = $properties['search_criteria_type'];
                    $details[] = $result;
                }
            }
        }
        return $details;
    }
  public function getWaitingAdverts()
    { 
    $result = $this->query('SELECT  * from vw_get_waiting_adverts');
    return $result;
    }
    
    
    public function getMyHouses()
    {
	return;
    }

}