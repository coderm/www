<?php
class ReportsController extends AppController
{
    public $name = 'Reports';
    public $helpers = array('Number');
    
    
    public $regions;
    
    public function beforeFilter() 
    {
        parent::beforeFilter();
        
        if(!isset($this->userPermissions['lp_user_add']))
             $this->redirect(array('controller' => 'users', 'action' => 'login'));
        
        
        $regions = array();
        
        
        $r = array();
        $r['query'] = '';
        $r['label'] = 'Tümü';
        $regions[] = $r;
        
        $r = array();
        $r['query'] = 'İstanbul';
        $r['label'] = 'İstanbul';
        $regions[] = $r;
        
        $r = array();
        $r['query'] = 'İstanbul, Küçükçekmece, Halkalı';
        $r['label'] = 'İstanbul, Halkalı';
        $regions[] = $r;
        
        
        $r = array();
        $r['query'] = 'İstanbul, Beyoğlu';
        $r['label'] = 'İstanbul, Beyoğlu';
        $regions[] = $r;        
        
        $r = array();
        $r['query'] = 'İstanbul, Beşiktaş';
        $r['label'] = 'İstanbul, Beşiktaş';
        $regions[] = $r;             
        
        
        $r = array();
        $r['query'] = 'İstanbul, Beyoğlu, Taksim';
        $r['label'] = 'İstanbul, Taksim';
        $regions[] = $r;        
        
        $r = array();
        $r['query'] = 'İSTANBUL, Pendik, Yenişehir';
        $r['label'] = 'İstanbul, Kurtköy';
        $regions[] = $r;            
        
        
        $r = array();
        $r['query'] = 'İstanbul, Beylikdüzü';
        $r['label'] = 'İstanbul, Beylikdüzü';
        $regions[] = $r;                
        
        $r = array();
        $r['query'] = 'İstanbul, Fatih, Sultanahmet';
        $r['label'] = 'İstanbul, Sultanahmet';
        $regions[] = $r;                
        
        $r = array();
        $r['query'] = 'İstanbul, Ataşehir';
        $r['label'] = 'İstanbul, Ataşehir';
        $regions[] = $r;                 
        
        
        $r = array();
        $r['query'] = 'İstanbul, Bakırköy';
        $r['label'] = 'İstanbul, Bakırköy';
        $regions[] = $r; 
        
        
        
        $r = array();
        $r['query'] = 'Aydın';
        $r['label'] = 'Aydın';
        $regions[] = $r;      
        
        
        
        
        $r = array();
        $r['query'] = 'Aydın, Kuşadası';
        $r['label'] = 'Aydın, Kuşadası';
        $regions[] = $r;              
                
        
        $r = array();
        $r['query'] = 'Aydın, Didim';
        $r['label'] = 'Aydın, Didim';
        $regions[] = $r;              
                
        
        $r = array();
        $r['query'] = 'Muğla';
        $r['label'] = 'Muğla';
        $regions[] = $r;              
                
        
        $r = array();
        $r['query'] = 'Muğla, Bodrum';
        $r['label'] = 'Muğla, Bodrum';
        $regions[] = $r;              
                        
                
        
        $r = array();
        $r['query'] = 'Muğla, Marmaris';
        $r['label'] = 'Muğla, Marmaris';
        $regions[] = $r;              
                        
                
        
        $r = array();
        $r['query'] = 'Muğla, Datça';
        $r['label'] = 'Muğla, Datça';
        $regions[] = $r;              
                        
                
        
        $r = array();
        $r['query'] = 'Muğla, Fethiye';
        $r['label'] = 'Muğla, Fethiye';
        $regions[] = $r;       
        
        
        $r = array();
        $r['query'] = 'Muğla, Ortaca, Dalyan';
        $r['label'] = 'Muğla, Dalyan';
        $regions[] = $r;     
        
        $r = array();
        $r['query'] = 'Antalya';
        $r['label'] = 'Antalya';
        $regions[] = $r;     
        
   
        
        $r = array();
        $r['query'] = 'Antalya, Kemer';
        $r['label'] = 'Antalya, Kemer';
        $regions[] = $r;             
                           
        $r = array();
        $r['query'] = 'Antalya, Kemer, Çamyuva';
        $r['label'] = 'Antalya, Çamyuva';
        $regions[] = $r;             
                           
        $r = array();
        $r['query'] = 'Antalya, Alanya';
        $r['label'] = 'Antalya, Alanya';
        $regions[] = $r;             
                           
        $r = array();
        $r['query'] = 'Antalya, Kaş';
        $r['label'] = 'Antalya, Kaş';
        $regions[] = $r;             
                           
        $r = array();
        $r['query'] = 'Antalya, Kaş, Kalkan';
        $r['label'] = 'Antalya, Kalkan';
        $regions[] = $r;             
                                   
      
        $r = array();
        $r['query'] = 'Antalya, Serik';
        $r['label'] = 'Antalya, Serik';
        $regions[] = $r;             
        

                                   
      
        $r = array();
        $r['query'] = 'Antalya, Serik, Belek';
        $r['label'] = 'Antalya, Belek';
        $regions[] = $r;             
        
        
                                   
      
        $r = array();
        $r['query'] = 'Mersin';
        $r['label'] = 'Mersin';
        $regions[] = $r;             
        
                                   
      
        $r = array();
        $r['query'] = 'Adana';
        $r['label'] = 'Adana';
        $regions[] = $r;             
        
                                   
      
        $r = array();
        $r['query'] = 'Sakarya';
        $r['label'] = 'Sakarya';
        $regions[] = $r;             
                
        $r = array();
        $r['query'] = 'Sinop';
        $r['label'] = 'Sinop';
        $regions[] = $r;   
        
        $r = array();
        $r['query'] = 'Eskişehir';
        $r['label'] = 'Eskişehir';
        $regions[] = $r;           
        
        $this->regions = $regions;
        

    }
    
    public function index($advertId=null)
    {
        $results = $this->Report->getProfits();
        $this->set('totalProfit',$results['totalProfit']);
        
        $this->set('todaysTotalProfit',$results['todaysTotalProfit']);
                
        $this->set('monthlyTotalProfits',$results['monthlyTotalProfits']);
	
        $this->set('monthlyHouseHolderPayments',$this->Report->getHouseholderPayments());
	
	$this->set('monthlyPendingReceivables',$this->Report->getPendingPayments());
	
	pr($this->Report->getHouseholderPayments());
    }
    
    public function portfolioReport()
    {
        Configure::write('debug', 2);
        $regionIndex = 0;
        if($this->request->isPost())
        {
           $regionIndex = $this->request->data['Report']['region'];
        }
        
        $query = $this->regions[$regionIndex]['query'];
        
        

        $results = $this->Report->getAdvertCountByDaily($query);
        
        if(isset($results[0]))
            $startDate = $results[0]['a']['date'];
        else
            $startDate = date("Y-m-d");
        $endDate = date("Y-m-d");
        
        
        $total = 0;
        $daysData = array();
        foreach($results as $result)
        {
            $count = $result['a']['count'];
            $total+= $count;
            $daysData[$result['a']['date']]['count'] = $count;
            $daysData[$result['a']['date']]['total'] = $total;
        }
        
        $dateRangeDays = $this->createDateRangeArray($startDate,$endDate);
        
        
        $regions = $this->regions;
        
        
        
        $options = array();
        
        foreach($regions as $region)
        {
            $options[] = $region['label'];
        }
        
        
                
        $this->set(compact('query'));
        $this->set(compact('options'));
        $this->set(compact('total'));
        $this->set(compact('dateRangeDays'));
        $this->set(compact('daysData'));
        
    }
    
    
    function createDateRangeArray($strDateFrom,$strDateTo)
    {

        $aryRange=array();

        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

        if ($iDateTo>=$iDateFrom)
        {
            array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('Y-m-d',$iDateFrom));
            }
        }
        return $aryRange;
    }    
    
    
    
}
?>
