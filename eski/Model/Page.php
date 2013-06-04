<?php
class Page extends AppModel
{
    public $name = 'Page';
    public $useTable = false;
    
    public $validate = array
    (

    );
    
    function getLastAdwerts()
    {
        
        $results = Cache::read('home_page_get_last_9_vw_get_adverts', 'hourly');
        if (!$results)
        {
            $results =  $this->query('SELECT * FROM vw_get_adverts WHERE advert_status="active" && show_in_homepage=1 ORDER BY RAND() LIMIT 9');   
            Cache::write('home_page_get_last_9_vw_get_adverts', $results, 'hourly');
        }                
        
        return $results;
    }
}
?>
