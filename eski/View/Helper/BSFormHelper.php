<?php

App::uses('FormHelper', 'View/Helper');

class BSFormHelper extends FormHelper
{

    public $defaultSpanClass;

    public function defaultSpanClass($val)
    {
	$this->defaultSpanClass = $val;
    }

    public function create($model = null, $options = array())
    {
	return parent::create($model, $options);
    }

    public function input($fieldName, $options = array())
    {
	if (!isset($options['div']))
	    $options['div'] = false;

	if (isset($options['class']))
	    $cssClass = $options['class'];
	else
	    $cssClass = '';
	
	if (isset($options['div']['class']))
	    $divCssClass = $options['div']['class'];
	else
	    $divCssClass = '';

	if(isset($options['type']) && $options['type']=='date')
	{
	    $cssClass.= ' span2';
	    $divCssClass.= ' span6';
	    $options['separator'] = ' ';
	} else
	{


		if (isset($options['bsSpan']))
		{
		    $cssClass.= ' span' . $options['bsSpan'];
		    $divCssClass.= ' span' . $options['bsSpan'];
		} else
		{
		    $cssClass.= ' span7';
		    $divCssClass.= ' span7';
		} 
	}
	
	
	if(isset($options['before']))
	{
	    $divCssClass.= ' input-prepend';
	    $options['before'] = '<span class="add-on">'.$options['before'].'</span>';
	}
	

	$options['class'] = $cssClass;
	$options['div']['class'] = $divCssClass;
	
	
	


	return parent::input($fieldName, $options);
    }
    
    public function radio( $fieldName, $options = array ( ), $attributes = array ( ) )
    {
	$attributes['label'] = false;
	$attributes['separator'] = '</label><label class="radio">';	

	$result = parent::radio($fieldName,$options,$attributes);
	
	$result = '<label class="radio">'.$result.'</label>';
	
	return $result;
    }
    
    

    public function newRow()
    {
	return '<div class="clear"></div>';
    }
    

}