<?php
App::uses('AppHelper', 'View/Helper');
class DatePickerHelper extends AppHelper
{
    var $helpers = array('Html','Form','Js');
    function init()
    {
        if($this->jsInit == false)
            $this->initJS();
        $this->jsInit = true;
    }
    var $jsInit = false;
    
    function addCssClass($className)
    {
        $this->classString.=" ".$className; 
        $this->Js->buffer('
        var classString = "'.$this->classString.'";'
        );        
    }
    
    function setShowOlderDates($showOlderDates)
    {
        $this->showOlderDates = $showOlderDates;   
        $this->Js->buffer('
        var showOlderDates = '.$this->showOlderDates.';'
        );
        
    }
    
    var $classString = "";
    var $showOlderDates = "false";
    
    function initJS()
    {
            $this->Js->buffer('
                            var $datePickerFocusTest = true;
                            var showOlderDates = false;
                            var classString = "";
                            var months = new Array("Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık");
                            var days = new Array("pt","sa","çş","pe","cu","ct","pz");
                             
                            function showDatePicker(target)
                            {
                                var rule = null;
                                var ruleTargetId = null;
                                var ruleString = $(target).attr("rule");

                                maxZIndex = $.maxZIndex();
                                $(target).parent().css("z-index",maxZIndex);
                                
                                if(ruleString!=null)
                                {
                                   var a = ruleString.split("_");
                                   rule = a[0];
                                   ruleTargetId = a[1];
                                   var targetDateString = $("#"+ruleTargetId).val();
                                   if(targetDateString!="gg-aa-yyyy")
                                   {
                                        var a = targetDateString.split("-");
                                        var minDate = new Date(a[2],a[1]-1,a[0]-1);

                                        var minDate = new Date(minDate.getTime() + (24 * 60 * 60 * 1000)*2);
                                   } else
                                   {
                                        var minDate = new Date();
                                   }
                                   
                                } else
                                {
                                   var minDate = new Date();
                                }
                                
                                
                                drawCalendar(minDate,classString);
                                function drawCalendar(_minDate,cssClass,month,year)
                                {
                                    if(month==null)
                                        _month = _minDate.getMonth()+1;
                                    else
                                        _month = month;
                                        
                                    if(year==null)
                                        _year = _minDate.getFullYear(); 
                                    else
                                        _year = year;
                                    
                                    

                                    var firstDayOfMonthDate = new Date(_year, _month, 0);
                                    firstDayOfMonthDate.setDate(1);
                                    var firstDayOfMonthIndex = firstDayOfMonthDate.getDay();
                                    var lastDayOfMonthDate = new Date(_year, _month, 0);
                                    var lastDayOfMonth = lastDayOfMonthDate.getDate();


                                    datePicker = "<div class=\"rounded5 calendar "+cssClass+"\" id=\"datePicker\">";
                                    datePicker+= "<div class=\"arrow\"></div>";
                                    datePicker+= "<div class=\"monthYearContainer\">";
                                    datePicker+= "<span class=\"leftArrow\"></span>";
                                    datePicker+= months[_month-1]+" ";
                                    datePicker+= "<span style=\"font-weight:normal;\">"+_year+"</span>"
                                    datePicker+= "<span class=\"rightArrow\"></span>";
                                    datePicker+= "</div>";


                                    for(i=0;i<7;i++)
                                    {
                                    datePicker+="<div class=\"dayItemContainer\">";
                                    datePicker+="<span style=\"color:#a8a8a8;font-size:11px;\">"+days[i]+"</span>"
                                    datePicker+="</div>";
                                    }

                                    if(firstDayOfMonthIndex==0)
                                    firstDayOfMonthIndex=7;

                                    for(i=0;i<firstDayOfMonthIndex-1;i++)
                                    {
                                    datePicker+="<div class=\"dayItemContainer\"><span class=\"dayItem rounded5\"></span></div>";
                                    };                                

                                    for(i=0;i<lastDayOfMonth;i++)
                                    {
                                        var s = i+1;    
                                        if(s<10)
                                        s = "0"+s;
                                        
                                        var dateToShow = new Date(_year, _month-1, i+2);


                                        if(dateToShow>=_minDate || showOlderDates==true)
                                            datePicker+="<div class=\"dayItemContainer\"><span class=\"dayItem rounded5\" day="+s+">"+s+"</span></div>";
                                        else
                                            datePicker+="<div class=\"dayItemContainer\" style=\"color:#a1c6db;cursor:default;\"><span class=\"dayItem rounded5 dayItemUnable\" day="+s+">"+s+"</span></div>";
                                    };
                                    
                                    datePicker+= "<div>";
                                    $(target).parent().css("position","relative");

                                    if(!$(target).parent().has("#datePicker").length==0)
                                        $("#datePicker").remove();


                                    $(target).parent().append(datePicker);
                                    $("#datePicker").css("z-index",maxZIndex);
                                    
                                    $("#datePicker").mousedown(function (event) {
                                        if($(event.target).hasClass("dayItem") && !$(event.target).hasClass("dayItemUnable"))
                                        {
                                            lastFocusedPickDateInput=null;
                                            day = $(event.target).attr("day");

                                            month = _month;
                                            if(month<10)
                                                month = "0"+month;
                                            $(target).val(day+"-"+month+"-"+_year);
					    $(target).focus();
                                            $("#datePicker").remove();
                                            $("#datePicker").hide();
                                            
                                            var nextFocusString = $(target).attr("nextFocus");
                                            if(nextFocusString!=null)
                                            {
                                                $("#"+nextFocusString).focus();
                                            }                      
                                        } else if($(event.target).hasClass("leftArrow"))
                                        {
                                            _month--;
                                            if(_month==0)
                                             {
                                                _month = 12;
                                                _year--;
                                             }
                                             drawCalendar(minDate,classString,_month,_year);  
                                             
                                        } else if($(event.target).hasClass("rightArrow"))
                                        {
                                            _month++;
                                            if(_month==13)
                                             {
                                                _month = 1;
                                                _year++;
                                             }
                                             drawCalendar(minDate,classString,_month,_year);                                              
                                        }
                                        
                                        event.stopPropagation();   
                                        
                                        


                                    });  
                                    
                                    $(document).mousedown(function (event) {
                                        $("#datePicker").remove();
                                    }); 
                                    /*
                                    $("#datePicker").mouseenter(function(){
                                        $(target).unbind("focusout");
                                    });                                    
                                    $("#datePicker").mouseleave(function(){
                                        $(target).bind("focusout",function(event){
                                        $("#datePicker").remove();
                                        })
                                    }); 
                                    $(target).bind("focusout",function(event){
                                        $("#datePicker").remove();
                                    })*/
                                }


                            }

                            '
                        );
            
            
            
                        $this->Js->get('.pickDate')->event('focus', 
                        '
                            var input = $(event.target);
                            $("#datePicker").remove();
                            showDatePicker(input);     
                            lastFocusedPickDateInput = input;                                
                        ');

                        /*$this->Js->get('.pickDate')->event('focusout', 
                        '
                            alert("focusout");
                            $("#datePicker").remove();
                        ');*/            
    }
}

?>
