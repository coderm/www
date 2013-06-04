<?php
class SearchesController extends AppController
{
    public $components = array('RequestHandler','Image','FormItem');    
    public $name = 'Searches';
    
    public $sqlString = '';
    
    function index($category = 'lac-all',$location=null)
    {
        $startDate = '';
        $endDate = '';
        $peopleCount = '';  
        $sqlAddToEndStr = '';
        
        $this->set('details',$this->Search->getDetailedSearchElements());
        
        $this->sqlString = '';
        
        
        if($this->request->data) 
        {
                $url = array('controller' => 'searches', 'action' => 'index','lac-all');
                if(is_array($this->request->data['Search'])) 
                {
                        foreach(array_keys($this->request->data['Search']) as $searchItemKey)
                        {
                                $searchItem = $this->request->data['Search'][$searchItemKey];
                                $this->request->data['Search'][$searchItemKey] = base64_encode(serialize($searchItem));
                        }
                }
                $params = array_merge($url, $this->request->data['Search']);
                $this->redirect($params);
        }     
        
        
        
        if(!empty($this->request->params['named']))
        {
            foreach(array_keys($this->request->params['named']) as $searchItemKey)
            {
                if($searchItemKey!='page' && $searchItemKey!='sort' && $searchItemKey!='direction')
                    $this->request->data['Search'][$searchItemKey] = unserialize(base64_decode($this->request->params['named'][$searchItemKey]));
            }
        }
	
        if(isset($location))
        {
            $sqlStr = $this->Search->getNewSearchString($location,'','','','');
            $this->set('location', $location);
        }else if(isset($this->request->data['Search']))
        {
            $data = $this->request->data['Search'];
            
            if(isset($this->request->data['Search']['searchType']))
                $searchType = $this->request->data['Search']['searchType'];
            else 
                $searchType = "";
            
            if($searchType=='detailed' || $searchType=='quick' || $searchType=='link')
            {
                if(isset($data['location']))
                    $location = $data['location'];
                
                if(isset($data['peopleCount']))
                    $peopleCount = $data['peopleCount'];
                
                if(isset($data['startDate']))
                    $startDate = $data['startDate'];
                
                if(isset($data['endDate']))
                    $endDate = $data['endDate']; 

                if($startDate!="")
                {
                    $startDate = explode("-", $startDate);
                    $startDate = $startDate[2].'-'.$startDate[1].'-'.$startDate[0];
                }

                if($endDate!="")
                {
                    $endDate = explode("-", $endDate);
                    $endDate = $endDate[2].'-'.$endDate[1].'-'.$endDate[0];
                }

                if($peopleCount!='')
                    $this->addSQLString('ldc_advert_max_guest_count[*]>='.$peopleCount);
            }
        }
        

        if(!isset($sqlStr))
            $sqlStr = '1=1 ';
        
        
        
        
        $results = array();
        
        if(isset($data['searchType']))
        {
            $searchType = $data['searchType'];
            
            
            
            switch($searchType)
            {
                case 'quick':
                        if(isset($data['query']))
                            $sqlAddToEndStr.=' AND (concat(advert_id,\' \',title,\' \',description,\' \',city,\' \',county,\' \',neighborhood,\' \',district,\' \',advert_class)  like \'%'.$data['query'].'%\' or concat(\'#\',house_holder) like \''.$data['query'].'%\' ) ';                        
                            //eskisi $sqlAddToEndStr.=' AND concat(advert_id,\' \',title,\' \',description,\' \',city,\' \',county,\' \',neighborhood,\' \',district,\' \',advert_class)  like \'%'.$data['query'].'%\' ';                        
                    break;
                case 'advertNo':
                        $sqlAddToEndStr.=' AND advert_id LIKE "%'.$data['id'].'%"';
                        //$sqlAddToEndStr.=' AND advert_id IN (select vgad.advert_id from vw_get_advert_details vgad where (\''.$data['id'].'\' like CONCAT(\'%\',vgad.detail,\'%\') AND LENGTH(vgad.detail) > 3) or \''.$data['id'].'\' like CONCAT(\'%\',vgad.advert_id,\'%\') GROUP BY vgad.advert_id)';                        
                    break;
                default:
                    $this->set('crumbString','Detaylı arama');
                    $this->set('crumbController','/searches/detailed');                        
                    $detailedSearchElements = $this->Search->getDetailedSearchElements();
                    $a = array();
                    foreach($detailedSearchElements as $element)
                    {
                        $formElementType = $element['ldct']['form_element_type'];
                        if($formElementType == 'checkbox')
                        {
                            $items = $element['items'];
                            foreach($items as $item)
                            {
                                $item['search_criteria_type'] ='selectable';
                                $a[] = $item;
                            }
                        } else if($formElementType == 'heading')
                        {

                        } else
                        {
                            $a[] = $element;
                        }
                    }
                    $detailedSearchElements = $a;
                    $sqlStr = '';
                    foreach($detailedSearchElements as $element)
                    {
                        $formElementType = $element['ldct']['form_element_type'];
                        $searchCriteriaType = $element['search_criteria_type'];

                        $elementId = $element['ldc']['message_text_id'];
                        
                        if(isset($data[$elementId]))
                        {
                            switch($searchCriteriaType)
                            {
                            case 'equal_to':
                                $value = $data[$elementId];
                                if($value!='')
                                    $this->addSQLString($elementId.'[*]='.$value);  
                                break;
                            case 'between_two_points':
                                $min = $data[$elementId]['min'];
                                $max = $data[$elementId]['max'];
                                if($min!='')
                                    $this->addSQLString($elementId.'[*]>='.$min);
                                if($max!='')
                                    $this->addSQLString($elementId.'[*]<='.$max);
                                break;
                            case 'greater_than_or_equal_to':
                                $value = $data[$elementId];
                                if($value!='')
                                    $this->addSQLString($elementId.'[*]>='.$value);
                                break;
                            case 'smaller_than_or_equal_to':
                                $value = $data[$elementId];
                                if($value!='')
                                    $this->addSQLString($elementId.'[*]<='.$value);
                                break;
                            case 'selectable':
                                $value = $data[$elementId];
                                if($value!=0)
                                    $this->addSQLString($elementId.'[*]='.$value);                                   
                                break;
                            case 'hidden':
                                break;
                            default:
                                echo 'there is no search criteria type like '.$searchCriteriaType.' on system';
                                break;
                            }
                        }

                    }
                    break;
            }
           
        }
        
	    if(isset($this->request->data['Search']['ldc_advert_householder_user_id']) && $this->request->data['Search']['ldc_advert_householder_user_id']!='')
		$this->addSQLString('ldc_advert_householder_user_id[*]='.$this->request->data['Search']['ldc_advert_householder_user_id']);
        
            if($this->sqlString!='')
                $sqlStr = $this->Search->getNewSearchString($location,$startDate,$endDate,$this->sqlString);
            else if($sqlStr=='')
                $sqlStr = '1=1 ';
            
            $sqlStr.= $sqlAddToEndStr;
            

        if(!isset($this->advertPermissions['lp_advert_admin_list']))
            $sqlStr.=' AND (advert_status= "active" OR (advert_id IN (select advert_id FROM dt_advert_details where detail_class_id = 66 AND advert_detail ='.CakeSession::read('User.Id').'))AND advert_status IN ("active","passive","waiting_for_approval")) ';
        //else
          //  $sqlStr.=' AND advert_status= "active" ';
        if(isset($this->advertPermissions['lp_advert_admin_list']))
            $sqlStr.=' AND advert_status IN ("active","passive","waiting_for_approval")'; 
        
 
        if(isset($category) && $category!='lac-all')
        {
            $sqlStr.=' AND advert_class_message_text_id LIKE "'.str_replace('-', '_', $category).'%"'; 
        }

        
        
        if(!isset($this->request->named['sort']))
            $sqlStr.= 'ORDER BY advert_status DESC,on_top_date DESC,show_in_homepage DESC,is_partner DESC,add_date DESC';

        
        
        
        
  
            
        $this->paginate = array(
        'conditions' => array('1' => $sqlStr),
        'limit' => 20
          
        );
        
        $results = $this->paginate('Search');
	

        
        $this->set('modelName','Search');        
        $this->set('adverts',$this->parseAdvertListResults($results));
        $this->set('category',$category);
    }
    
    
    public function waitingForAprovals()
    {
	if(!isset($this->advertPermissions['lp_advert_admin_list']))
	    $this->redirect(array('controller'=>'users','action'=>login));
	
	$results = $this->Search->getWaitingAdverts();
	
	
	foreach ($results as $key=>$result)
	{
	    $results[$key]['Search'] = $result['vw_get_waiting_adverts'];
	    unset($results[$key]['vw_get_waiting_adverts']);
	}
	
	
	
	$this->set('adverts',$this->parseAdvertListResults($results));
	
	$this->set('category','lac-all');
	
    }

    
    function addSQLString($val)
    {
        if($this->sqlString!='')
                $this->sqlString.='[|]';
        $this->sqlString.=$val;
        
    }
    
    
    function detailed()
    {
        $this->set('details',$this->Search->getDetailedSearchElements());
    }
}
?>
