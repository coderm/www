<?php

class TweetsController extends AppController {
public $helpers = array('Html', 'Form');
public $name = 'Tweets';

public function index() {
    $id_str = '153918412328935427';
    $resource ='related_results/show/'.$id_str;
    $TweetQuery = array(
      'count'=>'200',
      'resource'=>$resource,
      'page'=>'1'     
    ); 
   $results = $this->Tweet->find('all',$TweetQuery);
   pr($results);
  
}



}

