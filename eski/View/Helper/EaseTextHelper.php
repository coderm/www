<?php
App::uses('AppHelper', 'View/Helper');
class EaseTextHelper extends AppHelper
{
    public function excerpt($text, $phrase, $radius = 100, $ending = '...')
    {
        if(strlen($text)<=$radius)
            return $text;
        
        return mb_substr($text, 0, $radius, 'UTF-8') . $ending;
    }
}  
    
