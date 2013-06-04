<div class="scheduleContainer rounded10">
    <div class="schedule">
    <?php
        echo '<div style="line-height:23px;margin-bottom:8px;">';
        echo $this->Html->image('schedule/not_aveliable.png', array('alt'=> 'Uygun', 'border' => '0'));
        echo ' Rezerve Edilmiş';
        echo '&nbsp;&nbsp;&nbsp;';
        echo $this->Html->image('schedule/light_blue.png', array('alt'=> 'Uygun', 'border' => '0'));
        echo ' Uygun';
        echo '&nbsp;&nbsp;&nbsp;';    
        echo $this->Html->image('schedule/past_gray.png', array('alt'=> 'Geçmiş Tarih', 'border' => '0'));
        echo ' Geçmiş Tarih';    
        echo '</div>';

        echo $this->Form->input('startDate',array('type'=>'hidden'));
        echo $this->Form->input('endDate',array('type'=>'hidden'));
        $newMonth = 1;

	
        foreach($days as $day)
        {
            $timeStampNow        =    mktime(0,0,0);
            list($yr,$mn,$dt)    =    split('-',$day['day']);
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
                echo '<div year="'.$fullYear.'" month="'.$month.'" class="rounded5 month" >';
                echo '<div style="z-index:3;position:absolute;">';
                    echo '<div class="headline">'.$fullYear.' <span style="font-weight:bold;float:right;font-style:normal;">'.__($monthName).'</span></div>';

                for($i=1;$i<8;$i++)
                {
                        echo '<div class="dayLabel">';
                        echo __('shortDayName'.$i);
                        echo '</div>';
                }

                $i=1;
                while($i!=$dayOfTheWeek)
                {
                        echo '<div class="day empty"></div>';
                        $i++;
                }
            }
            $cssClass = '';


            $isDayAveliable = $day['isDayAveliable'];
            $isDayNotAveliable = $day['isDayNotAveliable'];
            $isDayStartDay = $day['isDayStartDay'];
            $isDayEndDay = $day['isDayEndDay'];
	    



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

            echo '<div class="day '.$cssClass.'" day="'.$dayOfMonth.'">';
                echo $dayOfMonth;
            echo '</div>';

            if($dayOfMonth==$lastDayOfMonth)
            {
                echo '<span style="display:block;position:relative;clear:both;"></span>';
                echo '</div>';
                echo '</div>';
            }
            $newMonth = 0;
        }

	
	/*
	 * close last month
	 */
	echo '<span style="display:block;position:relative;clear:both;"></span>';
	echo '</div>';
	echo '</div>';
	
	/*
	 * close last month end
	 */	

    ?>

	
	
    </div>
<div style="clear:both;position: relative;float:left;width:100%;"></div>                    
</div>
