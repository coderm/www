<div class="calendar">
<?php
    echo $this->Form->input('startDate',array('type'=>'hidden'));
    echo $this->Form->input('endDate',array('type'=>'hidden'));
    $newMonth = 1;
    //pr($bookingDays);
    foreach($bookingDays as $day)
    {
        $timeStampNow        =    mktime(0,0,0);
        list($yr,$mn,$dt)    =    split('-',$day[0]['day']);
        $timeStampCurrent    =    mktime(0,0,0,$mn,$dt,$yr);
        $timeStampFirstDay   =    mktime(0,0,0,$mn,1,$yr);
        
        list($y,$m,$t)       =     split('-',date('Y-m-t',$timeStampCurrent)); 
        $timeStampLastDay    =     mktime(0,0,0,$m,$t,$y);
        
        $dayOfMonth = date('d',$timeStampCurrent);
        $lastDayOfMonth = date('d',$timeStampLastDay);
        
        $dayOfTheWeek = date('N',$timeStampCurrent);
        
        $fullYear = date('Y',$timeStampCurrent);
        $month =  date('n',$timeStampCurrent);
         
        if($dayOfMonth == 1)
            $newMonth = 1;
        
        if($newMonth==1)
        {
            $monthName = date('F',$timeStampCurrent);
            echo '<div year="'.$fullYear.'" month="'.$month.'" class="rounded5 calendarMonth" >';
            echo '<div style="z-index:3;position:absolute;">';
                echo '<div class="calendarHeadline">'.__($monthName).' <span style="font-weight:normal;">'.$fullYear.'</span></div>';
            
            for($i=1;$i<8;$i++)
            {
                    echo '<div class="dayItemContainer">';
                    echo '<span style="color:#a8a8a8;font-size:11px;">'.__('shortDayName'.$i).'</span>';
                    echo '</div>';
            }
            $i=1;
            while($i!=$dayOfTheWeek)
            {
                    echo '<div class="calendarDay"></div>';
                    $i++;
            }
        }
        $cssClass = '';
        
        
        $isDayAveliable = false;
        $isDayNotAveliable = false;
        $isDayStartDay = false;
        $isDayEndDay = false;
        
        foreach($day as $dayStatus)
        {
            switch($dayStatus['day_status'])
            {
                case 'free_day':
                    $isDayAveliable = true;
                    break;
                case 'free_day_start':
                    break;                
                case 'free_day_end':
                    break;                
                case 'preparation_day':
                    $isDayNotAveliable = true;
                    break;                
                case 'preparation_day_start':
                    $isDayStartDay = true;
                    break;
                case 'preparation_day_end':
                    $isDayEndDay = true;
                    break;      
                case 'full_day':
                    $isDayNotAveliable = true;
                    break;
                case 'full_day_start':
                    $isDayStartDay = true;
                    break;
                case 'full_day_end':
                    $isDayEndDay = true;
                    break;     
                default:
                    $isDayNotAveliable = true;
                    break;
            }
        }
        
        
        
        
        if($isDayAveliable)
            $cssClass.= ' aveliable';   
        if($isDayEndDay && !$isDayStartDay)
            $cssClass.= ' aveliable start';
        if(!$isDayEndDay && $isDayStartDay)
            $cssClass.= ' aveliable end';
        if($isDayEndDay && $isDayStartDay)
            $cssClass.= ' notAveliable';   
        if($isDayNotAveliable)
            $cssClass.= ' notAveliable';   
        
        
        if($timeStampCurrent <  $timeStampNow)
            $cssClass.= ' past';

        echo '<div class="calendarDay" style="cursor:pointer;">';
            echo '<span class="dayItem '.$cssClass.'" day="'.$dayOfMonth.'">';
            echo $dayOfMonth;
            echo '</span>';
        echo '</div>';
        
        if($dayOfMonth==$lastDayOfMonth)
        {
            echo '<span style="display:block;position:relative;clear:both;"></span>';
            echo '</div>';
            echo '</div>';
        }
        $newMonth = 0;
    }

    
?>
    <div class='reservationActive formContainer rounded10' style="height: auto;">
        <div style="text-align: right;padding:10px;"><a href="javascript:resetCalendar()">Seçimi Temizle</a></div>
        <div class="rounded5" style="padding:15px;text-align: center;">
            <h2>Başlangıç Tarihi:&nbsp;&nbsp;<span class='startDate'></span></h2>
            <h2>Bitiş Tarihi:&nbsp;&nbsp;<span class='endDate'></span></h2>
            <span class='description'></span><br/>
        </div>
    </div>
</div>

<?php

            $this->Js->buffer(
            '
                function resetCalendar()
                {
                    $calendar = $(".calendar");
                    $(".dayItem").removeClass("selected");
                    $calendar.attr("state","");
                    $(".startDate").html("");
                    $(".endDate").html("");
                    $(".description").html("");
                    
                    $("#ReservationStartDate").val("");
                    $("#ReservationEndDate").val("");
                    
                    $calendarStartDate = null;
                    $calendarEndDate = null;
                    
                    $(".reservationActive").hide();
                }
                
                var $calendarStartDate;
                var $calendarEndDate;
            
            
            
                $(document).ready(function()
                {
                    $(".calendar").click(function(event)
                    {
                        if($(event.target).hasClass("past"))
                            return;
                        if(!$(event.target).hasClass("aveliable"))
                            return;

                        $year = $(event.target).parent().parent().parent().attr("year");
                        $month = $(event.target).parent().parent().parent().attr("month");
                        $day = $(event.target).attr("day");

                        if($month<10)
                            $month = "0"+$month;

                        $calendar = $(event.target).parent().parent().parent().parent();


                        $selectedDaysTotal = 0;
                        switch($(event.currentTarget).attr("state"))
                        {
                            case "startDate":
                                $(event.target).addClass("selected");
                                $(event.currentTarget).attr("state","endDate");

                                $selected = false;
                                $error = false;
                                $startDate = null;
                                $endDate = null;
                                
                                $(event.currentTarget).find(".dayItem").each(function(index)
                                {
                                    a = $(event.currentTarget).find(".dayItem").get(index);
                                    if($selected==false && $(a).hasClass("selected"))
                                        $selected = true;
                                    else if($(a).hasClass("selected"))
                                        $selected = false;
                                    else if($selected)
                                    {

                                        if($(a).hasClass("notAveliable") || $(a).hasClass("start") || $(a).hasClass("end"))
                                        {
                                            alert("Bu tarih aralığında başka rezervasyon(lar) bulunuyor. Lütfen tekrar seçim yapın.");
                                            resetCalendar();
                                            $error = true;
                                            return false;
                                        } else
                                        {
                                            $(a).addClass("selected");
                                            $selectedDaysTotal++;
                                        }
                                    }
                                });


                                if($error==false)
                                {
                                    $calendarEndDate = new Date($year, $month-1, $day);

                                    if($calendarStartDate.getTime()>$calendarEndDate.getTime())
                                    {
                                        $de = new Date($calendarStartDate.getTime());
                                        $ds = new Date($calendarEndDate.getTime());
                                        $calendarEndDate = $de;
                                        $calendarStartDate = $ds;
                                    }
                                    $(".reservationActive").show();   
    
                                }
                            break;
                            case "endDate":
                            break;
                            default:
                                $(event.target).addClass("selected");
                                $(event.currentTarget).attr("state","startDate");
                                $calendarStartDate = new Date($year, $month-1, $day);
                            break;
                        }

                        if($calendarStartDate!=null)
                        {
                                $day = $calendarStartDate.getDate();
                                $month = $calendarStartDate.getMonth()+1;
                                $fullYear = $calendarStartDate.getFullYear();

                                if($day<10)
                                    $day = "0"+$day;
                                if($month<10)
                                    $month = "0"+$month;

                                $str = $day+"-"+$month+"-"+$fullYear;

                                $calendar.find(".startDate").html($str);
                                $calendar.find("#ReservationStartDate").val($str); 

                        } 
                        if($calendarEndDate!=null && $calendar.find(".description").html()=="")
                        {
                                $day = $calendarEndDate.getDate();
                                $month = $calendarEndDate.getMonth()+1;
                                $fullYear = $calendarEndDate.getFullYear();

                                if($day<10)
                                    $day = "0"+$day;
                                if($month<10)
                                    $month = "0"+$month;

                                $str = $day+"-"+$month+"-"+$fullYear;

                                $calendar.find(".endDate").html($str);
                                $calendar.find("#ReservationEndDate").val($str);    
                                $selectedDaysTotal++;
                                $calendar.find(".description").html($selectedDaysTotal+" gece "+($selectedDaysTotal+1)+" gün.");
                        }
                    });
             });   
            '
            );

            
?>