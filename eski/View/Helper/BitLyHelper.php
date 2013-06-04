<?php
App::uses('AppHelper', 'View/Helper');
class BitLyHelper extends AppHelper
{
    var $login = "tatilevim";
    var $appkey = "R_382e9104c50d6896cc1e632cc1225719";
    function link($url,$format = 'xml',$version = '2.0.1')
    {
        $bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$this->login.'&apiKey='.$this->appkey.'&format='.$format;
        
        $response = file_get_contents($bitly);
 
        if(strtolower($format) == 'json')
        {
            $response = json_decode($response);
            if ($response->errorCode == 0 && $response->statusCode == 'OK' && isset($response->results->{$url}->shortUrl)) 
            {
                return "\n".$response->results->{$url}->shortUrl;
            }
            else
            {
                return "\n".$url;
            }
        }
        else //xml
        {
            $xml = simplexml_load_string($response);
            return "\n".'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
        }
    }
}  
    
