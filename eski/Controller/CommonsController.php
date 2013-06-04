<?php
class CommonsController extends AppController
{
    public $components = array('RequestHandler');
    public $name = 'Commons';
    
    
    function beforeFilter() 
    {
        parent::beforeFilter();
        
    }   
    
    function getSubLocations($parentLocationType,$parentLocationId = 0)
    {
	Configure::write('debug', 0);
	if($parentLocationId==-1) //seçiniz
	{
	    $results = array();
	    $results['-1'] = '- Seçiniz -';
	} else
	{
	    $results = $this->Common->getSubLocations($parentLocationType,$parentLocationId);
	}
	$this->set(compact('results'));
	$this->set('_serialize',array('results'));
    }
    
    public function calculatePriceByHouseDemandAjax($houseHolderDemand, $advertId=false)
    {
	Configure::write('debug',0);
	
	$this->loadModel('Advertisement');
	$sellPrice = $this->Advertisement->calculatePriceByHouseDemand($houseHolderDemand, $advertId);
	$results["sellPrice"] = $sellPrice;
        $this->set(compact('results'));
	$this->set('_serialize',array('results'));
    }
    
    public function calculateHouseDemandBySellPriceAjax($sellPrice, $advertId=false)
    {
	Configure::write('debug',0);
	
	$this->loadModel('Advertisement');
	$houseHolderDemand = $this->Advertisement->calculateHouseDemandBySellPrice($sellPrice, $advertId);
	$results["demand"] = $houseHolderDemand;
	$this->set(compact('results'));
	$this->set('_serialize',array('results'));
    }    
    
    
    public function getMonthlyCalendarDataAjax($advertId, $year, $month, $monthIndex)
    {
	$this->layout = 'empty';
        $data['advertId'] = $advertId;
	
	$date = mktime(0,0,0,$month+$monthIndex, 1, $year);
	
        $data['year'] = date('Y', $date);
        $data['month'] = date('m', $date);
	
	
	
	$this->loadModel('Advertisement');
        $montlyCalendar = $this->Advertisement->advertCalender($data);
	


	$freeDayKeys = array('weekEndDemand','normDemand','exceptionRate');
	$bookedDayKeys = array('tatilevimBooking','householderBooking');
	$lastType = '';
	foreach ($montlyCalendar as $key=>$day)
	{
	    if(in_array($day['type'],$freeDayKeys))
		$type = 'free';
	    
	     if(in_array($day['type'],$bookedDayKeys))
		$type = 'book';
	     
	    
	    if($type=='book' && $lastType=='book' && $day['position'] == 'begin')
		$type.='-end-start';
	    else if($type == 'book' && $day['position'] == 'begin')
		$type.='-start';		
	    else if($lastType=='book' && $day['position'] == 'begin')
		$type.='-start';
		
	    
	    $lastType = $type;
	    $montlyCalendar[$key]['_type'] = $type;
	}
	
	
	
	
	$firstDayIndex = $montlyCalendar[1]['weekDay'];
	
	
	for($i=0;$i<($firstDayIndex-1);$i++)
	    array_unshift ($montlyCalendar, 'null');
	
	
	
	$this->set(compact('montlyCalendar'));
	$this->set(compact('monthIndex'));
	$this->set(compact('date'));
    }
    

    
}
?>
