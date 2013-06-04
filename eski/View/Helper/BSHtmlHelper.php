<?php
App::uses('HtmlHelper', 'View/Helper');
class BSHtmlHelper extends HtmlHelper
{
    public $isAccordionItemEnd = true;
    public $isAccordionItemDivHasClassRow = true;
    public $accordionId;
    public function createAccordion()
    {
	$this->accordionId = uniqid();
	return '<div class="accordion" id="'.$this->accordionId.'">';
    }
    public function endAccordion()
    {
	return '</div>';
    }
    public function startAccordionItem($options = array())
    {
	$this->isAccordionItemEnd = false;
	
	if(!isset($options['inOut']))
	    $options['inOut'] = 'out';
	
	$collapseDivId = uniqid();
	$str = '<div class="accordion-group">';
	$str.= '<div class="accordion-heading">';
	$str.= '<a class="accordion-toggle collapsed" data-toggle="collapse"  href="#'.$collapseDivId.'">';
	$str.= $options['label'];
	$str.= '</a>';
	$str.= '</div>';
	$str.= '<div id="'.$collapseDivId.'" class="accordion-body collapse '.$options['inOut'].'">';
	$str.= '<div class="accordion-inner">';
	
	if($this->isAccordionItemDivHasClassRow)
	    $str.= '<div class="row">';
	else
	    $str.='<div>';

	return $str;
    }
    public function endAccordionItem()
    {
	$this->isAccordionItemEnd = true;
	$str = '</div>';
	$str.= '</div>';
	$str.= '</div>';
	$str.= '</div>';
	return $str;
    }
    
    public function forceToCloseAccordionItem()
    {
	if($this->isAccordionItemEnd)
	    return '';
	
	
	return $this->endAccordionItem();
    }
    
    

}