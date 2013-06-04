<div style="width:335px;float:left;" class="formContainer module rounded10">
    <h2>Tatil Evi Ara</h2>
<?php
        echo $this->Html->link('Detaylı Arama'.
                                $this->Html->image('')
                                ,
                                '/advertisements/booking/',
                                array('target' => '_self', 'escape' => false,'class'=>'button detailedSearch rounded5',
                                    'style'=>'position:absolute;left:220px;top:16px;')
                                );     
?>
<?php
    echo $this->Form->create('Search');
    echo '<div class="liveSearch">';
    echo $this->Form->input('location', array('label'=>'Nerede?','autocomplete'=>'off'));
        echo '<div class="results" id="liveSearchResults">';
        echo '</div>';
    echo '</div>';
    echo $this->Form->input('startDate', array('label'=>'Başlangıç Tarihi','class'=>'pickDate'));
    echo $this->Form->input('endDate', array('label'=>'Bitiş Tarihi','class'=>'pickDate'));
    echo $this->Form->input('guestCount', array('label'=>'>>Konut Tipi Gelecek<<'));
    echo $this->Form->input('guestCount', array('label'=>'Misafir Sayısı'));
    echo '<center>';
    echo $this->Form->end('ARA');
    echo '</center>';
?>
</div>

<?php
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
                                    $("#liveSearchResults").css("z-index",2500);
                               }
                               else
                                    $("#liveSearchResults").hide();
                                    
                                $("body").click(function (event) { 
                                    $("#liveSearchResults").hide();
                                });    
                            });
                            var liveSearchResultsSelected = false;
                            '
                );        
        $this->Js->get('#liveSearchResults')->event('click', 
        '
             $("#SearchLocation").val($(event.target).html());
             $("#liveSearchResults").hide();
        '
        );    
        
         /*       
        $this->Js->get('.pickDate')->event('click', 
        '
            $("#datePicker").remove();
            $("#liveSearchResults").hide();
            showDatePicker($(event.target));
        ');
        
        
        
        $this->Js->buffer('
                            var months = new Array(
                                            "Ocak",
                                            "Şubat",
                                            "Mart",
                                            "Nisan",
                                            "Mayıs",
                                            "Haziran",
                                            "Temmuz",
                                            "Ağustos",
                                            "Eylül",
                                            "Ekim",
                                            "Kasım",
                                            "Aralık"
                                        );
                                        
                            var days = new Array(
                                            "pt",
                                            "sa",
                                            "çş",
                                            "pe",
                                            "cu",
                                            "ct",
                                            "pz"
                                        );
                                        
                            function showDatePicker(target)
                            {
                                month = 12;
                                year = 2011;
                                drawCalendar(month,year);
                                function drawCalendar(_year,_month)
                                {
                                    var firstDayOfMotnhDate = new Date(_year, _month, 0);
                                    firstDayOfMotnhDate.setDate(1);
                                    var firstDayOfMonthIndex = firstDayOfMotnhDate.getDay();
                                    var lastDayOfMonthDate = new Date(_year, _month, 0);
                                    var lastDayOfMonth = lastDayOfMonthDate.getDate();


                                    datePicker = "<div class=\"rounded5 calendar\" id=\"datePicker\">";
                                    datePicker+= "<div class=\"arrow\"></div>";
                                    datePicker+= "<div style=\"padding:3px;font-size:14px;margin-bottom:4px;font-weight:bold;text-align:center;\">";
                                    datePicker+= "<span class=\"leftArrow\"></span>";
                                    datePicker+= months[month-1]+" ";
                                    datePicker+= "<span style=\"font-weight:normal;\">"+year+"</span>"
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

                                    datePicker+="<div class=\"dayItemContainer\"><span class=\"dayItem rounded5\" day="+s+">"+s+"</span></div>";
                                    };
                                    datePicker+= "<div>";
                                    $(target).parent().css("position","relative");
                                    
                                    if(!$(target).parent().has("#datePicker").length==0)
                                        $("#datePicker").remove();
                                    
                                    
                                    $(target).parent().append(datePicker);
                                    
                                    $("#datePicker").click(function (event) { 
                                        
                                        if($(event.target).hasClass("dayItem"))
                                        {
                                            $(target).val($(event.target).attr("day")+"-"+month+"-"+year);
                                            $("#datePicker").remove();
                                        } else if($(event.target).hasClass("leftArrow"))
                                        {
                                            month--;
                                            if(month==0)
                                             {
                                                month = 12;
                                                year--;
                                             }
                                             drawCalendar(month,year);                                             
                                        } else if($(event.target).hasClass("rightArrow"))
                                        {
                                            month++;
                                            if(month==13)
                                             {
                                                month = 1;
                                                year++;
                                             }
                                                drawCalendar(month,year);                                             
                                        }
                                            event.stopPropagation();                                        
                                    });          
                                    $("body").click(function (event) { 
                                        $("#datePicker").remove();
                                    });     
                                        
                                }
                                
                                                                 
                            }

                            '
                );     
          * 
          */        

?>
