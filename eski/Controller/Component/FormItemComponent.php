<?php
class FormItemComponent extends Component 
{
    function getValidations($item)
    {
        $properties = $item['properties'];
        if(!isset($properties))
            return array();
        
        $i = 0;
        $rules = array();
        foreach($properties as $key => $value)
        {
           $rule=null;
           switch($key)
           {
               case 'notEmpty':
                    $rule = array
                    (
                        'rule' => 'notEmpty',
                        'message' => 'Boş bırakılamaz'
                    ); 
                   break;
               case 'minLength':
                    $rule = array
                    (   
                        'rule'=>array('minLength',$value),
                        'message' => 'Minimum '.$value.' karakter girişi yapınız'
                    );               
                   break;
               case 'maxLength':
                    $rule = array
                    (   
                        'rule'=>array('maxLength',$value),
                        'message' => 'Maksimum '.$value.' karakter kullanınız'
                    );               
                   break;
               case 'numeric':
                    $rule = array
                    (   
                        'rule'=>array('numeric'),
                        'allowEmpty'=>true,
                        'message' => 'Sadece rakam kullanınız'
                    );               
                   break;                
               case '':
                   break;
               default:
                   //pr($key.' validasyonunu kontrol edin!');
                   break;
                   
           }
           if($rule!=null)
               $rules['rule'.$i] = $rule;
           $i++;
        }
        
        return $rules;
    }
}

?>