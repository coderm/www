<?php
    echo $this->Form->create();
    echo $this->Form->input('region',array('label'=>'Bölge','options'=>$options));
    echo $this->Form->end('Görüntüle');
    
    echo '<br/><h2>'.$query.'</h2><br/>';
    echo 'Toplam '.$total.' ev bulunuyor<br/>';
    
    $todaysTotal = 0;
    if(isset($daysData[$dateRangeDays[count($dateRangeDays)-1]]))
        $todaysTotal = $daysData[$dateRangeDays[count($dateRangeDays)-1]];
    
    echo '<span style="font-size:20px;">Bugün eklenen ev sayısı: <b>'.$todaysTotal.'</b></span>';
?>
<div id="chartContainer" style="overflow: scroll;height:400px;position: relative;">
    <div style="height:400px;width:<?php echo count($dateRangeDays)*7?>px;padding:10px;">
<?php
    $i = 0;
    foreach($dateRangeDays as $day)
    {
        $count = 0;
        $i+=1;
        $w = $i*7;
        if(isset($daysData[$day]))
        {
            $count = $daysData[$day]['count'];
                $total = $daysData[$day]['total'];
        }        
        
        if($count == 0)
            $color = 'red';
        else
            $color = 'blue';
        
        echo '<div style="width:6px;background-color:#ececec;;height:'.($total/8).'px;position:absolute;bottom:0px;left:'.$w.'px;"></div>';
        echo '<div style="width:5px;cursor:pointer;background-color:'.$color.';height:'.(($count+1)*3).'px;position:absolute;bottom:0px;left:'.$w.'px;" class="chartColumn">';
        echo '<span class="countLabel" style="display:none;position:absolute;z-index:100000;top:-30px;left:-150px;background-color:gray;padding:3px;width:150px;">'.$day.' <b>'.$count.' ev</b></span>';
        echo '</div>';
        
    }

    
?>
    </div>
</div>
<?php
    $this->Js->Buffer('
        $(document).ready(function() {
          
          $("#chartContainer").scrollLeft(10000); 

          $(".chartColumn").mouseover(function(event){
            $(event.target).find("span").first().show();
          });
        $(".chartColumn").mouseout(function(event){
            $(event.target).find("span").first().hide();
          });          
        });
    ');
?>

<?php
    return;
?>
<table style="font-size:1px;">
<?php

    $trStyle ='height:1px;margin:0;padding:0;';
    $tdStyle ='height:1px;margin:0;padding:0;';
    $red = 'color:red;font-weight:bold;';
    $gray = 'color:gray;';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    
    $totalStr = '';
    $r = 0;
    

    
    for($i=0;$i<$total;$i++)
                $totalStr.='x';
    
    foreach($dateRangeDays as $day)
    {
        echo '<tr style="'.$trStyle.'">';
        $count = 0;
        $countStr = '';
        
        $total;
        if(isset($daysData[$day]))
        {
            $totalStr = '';
            $count = $daysData[$day]['count'];
            $total = $daysData[$day]['total'];
            
            for($i=0;$i<$count;$i++)
                $countStr.='#######';
            
             for($i=0;$i<$total;$i++)
                $totalStr.='x';
             

        }
        
        
        
        if($count>0)
            $r++;
            
        
        if($r==3)
        {
            $countStr ='<div style="background-color:red;width:auto;display:inline;position:relative;">'.$total;
            
            $countStr.='<span style="font-weight:normal;color:black;font-size:10px;position:absolute;left:-70px;top:-6px;background-color:white;">20-05-2012</span><span style="color:black;display:block;font-size:10px;position:absolute;right:-15px;top:-6px;">'.$count.'</span></div>';
            $r = 0;
        }
        
        
        
        
        
        echo '<td style="'.$tdStyle.'">'.$day.'</td>';
        echo '<td style="'.$tdStyle.$red.'">'.$countStr.'</td>';
        echo '</tr>';
        
        echo '<tr style="'.$trStyle.'">';
        echo '<td style="'.$tdStyle.'"></td>';
        echo '<td style="'.$tdStyle.$gray.'">'.$totalStr.'</td>';
        echo '</tr>';
    }
?>
</table>