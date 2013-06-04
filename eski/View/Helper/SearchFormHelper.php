<?php
App::uses('AppHelper', 'View/Helper');
class SearchFormHelper extends AppHelper
{
    var $helpers = array('Html','Form','BSForm','BsHtml','Js','DatePicker');
    
    function beforeRender($viewFile)
    {
        $this->DatePicker->init();
    }
    
    function createModuleForm($width = 335)
    {
            $str = '';
	    $str.= '<div class="row">';
		$str.= '<div id="showReelSearch" class="span3">';
		    $str.= '<h4>'.__('form_headline_show_reel_search').'<i class="icon icon-flag icon-white pull-right"></i></h4>';

		    $str.= '<div class="row">';
		    $str.= $this->BSForm->create('Search',array('action'=>'index'));
		    $str.= $this->BSForm->hidden('searchType',array('value'=>'quick'));
		    $str.= '<div class="liveSearch">';
			$str.= $this->BSForm->input('location', array('label'=>__('form_element_label_show_reel_search_location'),'autocomplete'=>'off','bsSpan'=>3));
			$str.= '<div class="results" id="liveSearchResults"></div>';
		    $str.= '</div>';
		    $str.= $this->BSForm->input('startDate', array('label'=>__('form_element_label_show_reel_search_check_in'),'class'=>'pickDate','bsSpan'=>3));
		    $str.= $this->BSForm->input('endDate', array('label'=>__('form_element_label_show_reel_search_check_out'),'class'=>'pickDate','bsSpan'=>3));
		    $str.= $this->BSForm->newRow();
		    $str.= $this->BSForm->input('peopleCount', array('label'=>__('form_element_label_show_reel_search_total_guests'),'options' => array('Seçiniz',1,2,3,4,5,6,7,8,9,10),'bsSpan'=>2));
		    $str.= $this->BSForm->submit(__('bnt_label_home_show_reel_search'),array('class'=>'btn btn-warning pull-right btn-search'));
		    $str.= $this->BSForm->end();
		    $str.= '</div>';
		$str.= '</div>';
	    $str.='</div>';
            $this->initJS();
            return $str;
    }
    
    function createDetailedModule($details,$width = 221,$isFloatRight = false)
    {
	$str = '';
	$str.= $this->BSForm->create('Search',array('action'=>'index'));
	$str.= $this->BSForm->hidden('searchType',array('value'=>'detailed'));

	
	
	$str.= '<div class="well">';
	$str.= '<div class="row">';
	$str.= '<div class="liveSearch">';
	    $str.= $this->BSForm->input('location', array('label'=>__('form_element_label_show_reel_search_location'),'autocomplete'=>'off','class'=>'input-medium','bsSpan'=>0));
	    $str.= '<div class="results" id="liveSearchResults"></div>';
	$str.= '</div>';
	$str.= $this->BSForm->input('startDate', array('label'=>__('form_element_label_show_reel_search_check_in'),'class'=>'pickDate','class'=>'input-medium','bsSpan'=>0));
	$str.= $this->BSForm->input('endDate', array('label'=>__('form_element_label_show_reel_search_check_out'),'class'=>'pickDate','class'=>'input-medium','bsSpan'=>0));
	$str.= $this->BSForm->newRow();
	$str.= $this->BSForm->input('peopleCount', array('label'=>__('form_element_label_show_reel_search_total_guests'),'options' => array('Seçiniz',1,2,3,4,5,6,7,8,9,10),'bsSpan'=>1));
	$str.= $this->BSForm->submit(__('bnt_label_home_show_reel_search'),array('class'=>'btn btn-primary pull-right','style'=>'margin-top:26px;'));
	
	$str.= '</div>';
	$str.= '</div>';
	
	
	$str.= $this->BsHtml->createAccordion();
	
	if(is_array($details))
	{
	    foreach($details as $detail)
	    {
		$p = $this->parseProperties($detail['ldc']['properties']);

		if($p['search_criteria_type']=='headline')
		{
		    $str.= $this->BsHtml->forceToCloseAccordionItem();
		    $str.= $this->BsHtml->startAccordionItem(array('label'=>__($detail['ldc']['message_text_id'])));
		    
		} else if($p['search_criteria_type']=='selectable')
		{
		    $str.= $this->BsHtml->forceToCloseAccordionItem();
		    $str.= $this->BsHtml->startAccordionItem(array('label'=>__($detail['ldc']['message_text_id'])));
		    $str.= $this->createElement($detail);
		} else
		{
		    $str.= $this->createElement($detail);
		    
		}
		
	    }
	    
	    $str.= $this->BsHtml->forceToCloseAccordionItem();
		
	    
	}
	
	$str.= $this->BsHtml->endAccordion();

	$str.= $this->BSForm->submit(__('bnt_label_home_show_reel_search'),array('class'=>'btn btn-primary pull-right'));
	$str.= $this->BSForm->end();	
	
	$this->initJS();
	return $str;
	
	if(is_array($details))
	{
	    foreach($details as $detail)
		$str.= $this->createElement($detail);
	}
	if(!$this->BsHtml->$isAccordionEnd)
	    $str.=$this->BsHtml->endAccordion();
	    
	$str.= $this->BsHtml->endAccordion();
	$str.= $this->Form->end('ARA');
	    return $str;
	
	    $str = '';
            $str.= '<h5 style="clear:both;">Detaylı Arama</h5>';
            $str.= $this->Form->create('Search',array('action'=>'index'));
            $str.= $this->Form->hidden('searchType',array('value'=>'detailed'));
            $str.= '<div class="liveSearch">';
            $str.= $this->Form->input('location', array('label'=>'Nerede?','autocomplete'=>'off'));
            $str.= '<div class="results" id="liveSearchResults">';
            $str.= '</div>';
            $str.= '</div>';
            $str.= $this->Form->input('startDate', array('label'=>'Başlangıç Tarihi','class'=>'pickDate'));
            $str.= $this->Form->input('endDate', array('label'=>'Bitiş Tarihi','class'=>'pickDate'));
            $str.= $this->Form->input('peopleCount', array('label'=>'Kişi Sayısı','options' => array('Seçiniz',1,2,3,4,5,6,7,8,9,10),'class'=>'fullWidth'));

	    
	    
                //***DETAILS START
		    if(is_array($details))
		    {
			foreach($details as $detail)
			    $str.= $this->createElement($detail);
		    }
		    
                //***DETAILS END
            $str.= '<center>';
            $str.= $this->Form->end('ARA');
            $str.= '</center>';                    
            $str.= '</div>';
            $this->initJS();
            return $str;
    }
    
    function createDetailedForm ($details,$width = 700)
    {
            $str = '';
            $str.= '<div style="width:'.$width.'px;float:left;" class="formContainer detailed rounded10">';
            $str.= $this->_View->element('headline',array('label'=>'Detaylı Arama'));
            $str.= $this->Form->create('Search',array('action'=>'index'));
            $str.= $this->Form->hidden('searchType',array('value'=>'detailed'));
            $str.= '<div class="liveSearch">';
            $str.= $this->Form->input('location', array('label'=>'Nerede?','autocomplete'=>'off'));
            $str.= '<div class="results" id="liveSearchResults">';
            $str.= '</div>';
            $str.= '</div>';
            $str.= $this->Form->input('startDate', array('label'=>'Başlangıç Tarihi','class'=>'pickDate'));
            $str.= $this->Form->input('endDate', array('label'=>'Bitiş Tarihi','class'=>'pickDate'));
            $str.= $this->Form->input('peopleCount', array('label'=>'Kişi Sayısı','options' => array('',1,2,3,4,5,6,7,8,9,10),'default' => 1,'class'=>'fullWidth'));

                //***DETAILS START
                    foreach($details as $detail)
                    {
                        $str.= $this->createElement($detail);
                    }
                //***DETAILS END
            $str.= '<center>';
            $str.= $this->Form->end('ARA');
            $str.= '</center>';                    
            $str.= '</div>';
            $this->initJS();
            return $str;
    }    
    
    
    function createElement($detail)
    {
        $searchCriteriaType = $detail['search_criteria_type'];
        $elementType = $detail['ldct']['form_element_type'];
        $messageTextId = $detail['ldc']['message_text_id'];
        
	
	
        $inputId = $messageTextId;
        $str ='';
        switch($searchCriteriaType)
        {
            case 'equal_to':
                $str.= $this->BSForm->input($inputId, array('label'=>__($messageTextId),'style'=>'width:140px;','bsSpan'=>2));
                break;              
            case 'between_two_points':
                $str.= '<div class="span2">';                
                $str.= '<label>'.__($messageTextId).'</label>';                
                $str.= '<input id="Search'.ucfirst(Inflector::variable($messageTextId.'_min')).'" name="data[Search]['.$messageTextId.'][min]" type="text" style="width:40px;" placeholder="min"></input>';
                $str.= '&nbsp;-&nbsp;';
                $str.= '<input id="Search'.ucfirst(Inflector::variable($messageTextId.'_max')).'" name="data[Search]['.$messageTextId.'][max]" type="text" style="width:40px;" placeholder="max"></input>';
                $str.= '</div>';
                break;
            case 'greater_than_or_equal_to':
                $str.= '<span style="width:225px;display:block;float:left;position:relative;margin-left:1%;margin-bottom:18px;">';              
                $str.= $this->BSForm->input($inputId, array('label'=>__($messageTextId),'style'=>'width:140px;'));
                $str.= '</span>';
                break;     
            case 'smaller_than_or_equal_to':
                $str.= '<span style="width:225px;display:block;float:left;position:relative;margin-left:1%;margin-bottom:8px;margin-bottom:18px;">';                
                $str.= $this->BSForm->input($inputId, array('label'=>__($messageTextId),'style'=>'width:140px;'));
                $str.= '</span>';
                break;
            case 'selectable':
                $items = $detail['items'];
                foreach($items as $checkBoxDetail)
                {
                    $inputId = $checkBoxDetail['ldc']['message_text_id'];
                    
                    $elementType = $checkBoxDetail['ldct']['form_element_type'];
                    $messageTextId = $checkBoxDetail['ldc']['message_text_id'];                    
                    $str.= "<div class='text checkbox'>";              
                    $str.= $this->BSForm->input($inputId, array('label'=>__($messageTextId),'type'=>'checkbox'));
                    $str.= '</div>';
                }
                /*
                if(!$this->selectBlockStarted)
                    $str.= '<span style="clear:both;position:relative;float:left;width:100%;height:9px;">&nbsp;</span>'; !$this->selectBlockStarted = true;               
                $str.= '<span style="width:222px;display:block;float:left;position:relative;padding:8px 0 5px 10px;;">';               
                $str.= $this->Form->checkbox($inputId, array('label'=>__($messageTextId)));
                $str.= '<label for="'.$inputId.'">'.__($messageTextId).'</label>';
                $str.= '</span>';
                */
                break;
            case 'hidden':
                $str.= $this->BSForm->hidden($inputId);
                break;
            default:
                $str.=$searchCriteriaType.' not fount in system';
                break;
        }
        
        
        
        return $str;
    }
    var $selectBlockStarted = false;
    
    
    function initJS()
    {
            $this->Js->get('#SearchLocation')->event('keyup', 
                        $this->Js->request(array(
                        'controller'=>'advertisements',
                        'action'=>'searchLocation/'
                        ), array(
                        'update'=>'#liveSearchResults',
                        'async' => true,
                        'method' => 'post',
                        'dataExpression'=>true,
                        'data'=> $this->Js->serializeForm(array(
                        'isForm' => true,
                        'inline' => true
                        ))
                        ))
                        );

            $this->Js->buffer('
                                $("#liveSearchResults").change(function ()
                                {
                                   if($("#liveSearchResults span").length>0)
                                   {
                                        $("#liveSearchResults").show();
                                        maxZIndex = $.maxZIndex();
                                        $("#liveSearchResults").css("z-index",maxZIndex);
                                   }
                                   else
                                        $("#liveSearchResults").hide();

  
                                });
                                var liveSearchResultsSelected = false;
                                '
                    );        
            
            $this->Js->get('#liveSearchResults')->event('mousedown', 
            '
                 $("#SearchLocation").val($(event.target).html());
                 $("#liveSearchResults").hide();
            '
            );    
           
            
            $this->Js->get('.liveSearch .input')->event('focusout', 
            '
                $("#liveSearchResults").hide();
            '
            );               

    }
}

?>
