<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    for($i=1; $i<8; $i++)
    {
	echo '<span class="dayName">'.__('shortDayName'.$i).'</span>';
    }

    echo '<div class="myPlacesCalendar" month="'.__(date('m',$date)).'" monthName="'.__(date('F',$date)).'" year="'.__(date('Y',$date)).'">';
    foreach($montlyCalendar as $key=>$day):
	
	    if(is_array($day)):
		$date = strtotime($day['date']);
		$dayOfTheMonth = date('j',$date);
		$demand = ($day['demand']!='')?$day['demand'].' '.$day['currency']:'';		
		$cssClass = $day['_type'];
		echo '<span class="day '.$cssClass.'" day="'.$dayOfTheMonth.'">';
		    echo '<span class="dayOfMonth">'.$dayOfTheMonth.'</span>';
		    echo '<span class="demand">'.$demand.'</span>';
		    echo '<span class="hit left"></span>';
		    echo '<span class="hit right"></span>';
		echo '</span>';
	    else:
		echo '<span class="day">';
		    echo '<span class="hit left"></span>';
		    echo '<span class="hit right"></span>';
		echo '</span>';	
	    endif;
	
    endforeach;
    
    echo '</div>';
    
    
?>
