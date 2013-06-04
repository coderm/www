<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    echo $this->Html->tag('h3',__('place_calendar_headline'));
    echo $this->Element('/common/ui/date_chooser',array('id'=>'calendarDateChooser'));
    echo $this->Html->tag('hr');    
?>
	<div class="alert" id="calendarUpdateMessage">

        </div>
<?php
    
    echo $this->Html->tag('div','',array('class'=>'_myPlacesCalendar','id'=>'myPlacesCalendar'));
    
    
?>
 
<!-- Modal -->
<div id="calendarEditModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3><?php echo __('başlık');?></h3>
  </div>
  <div class="modal-body">
      <div>
	  <?php
	    echo $this->BSForm->create('Book',array('id'=>'calendarEditModalForm'));
	    echo $this->BSForm->hidden('advertId',array('value'=>$placeId));
	    echo $this->BSForm->input('startDate',array('label'=>__('calendar_edit_modal_check_in_date'),'type'=>'text','bsSpan'=>'2','class'=>'pickDate'));
	    echo $this->BSForm->newRow();
	    echo $this->BSForm->input('endDate',array('label'=>__('calendar_edit_modal_check_out_date'),'type'=>'text','bsSpan'=>'2','class'=>'pickDate'));
	    echo $this->BSForm->newRow();
	    echo $this->BSForm->input('ability',array('label'=>__('calendar_edit_modal_ability'),'options'=>array('yes'=>__('calendar_edit_modal_ability_yes'),'no'=>__('calendar_edit_modal_ability_no')),'bsSpan'=>'2','id'=>'calendarEditModalAbilitySelectInput'));
	    echo $this->BSForm->newRow();
	    echo '<div id="calendarEditModalAbilityDivYes">';
	    echo $this->Element('/common/ui/price_calculator');
	    echo '</div>';
	    echo '<div id="calendarEditModalAbilityDivNo" style="display:none">';
	    
	    echo $this->BSForm->input('CustomBook.channel',array('label'=>__('calendar_edit_modal_custom_book_channel'),'options'=>$customBookChannelOptions,'bsSpan'=>'2'));
	    echo $this->BSForm->input('CustomBook.totalPrice',array('label'=>__('calendar_edit_modal_custom_book_total_price'),'type'=>'text','bsSpan'=>'2'));	    
	    echo '</div>';
	    echo $this->BSForm->input('note',array('label'=>__('calendar_edit_modal_note'),'rows'=>'2','bsSpan'=>'6'));

	  ?>
    
      </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __('calendar_edit_modal_close_button_label');?></button>
    <button class="btn btn-primary save" ><?php echo __('calendar_edit_modal_save  _button_label');?></button>
  </div>
</div>


<?php
    
    $year = date("Y");  
    $month = date("n");  
    
    
    $this->Js->Buffer('
	
	    $("#calendarUpdateMessage").hide();
	    var data = [];
	    data.advertId = "'.$placeId.'";
	    data.year = "'.$year.'";
	    data.month = "'.$month.'";
	    $("._myPlacesCalendar").myPlacesCalendar(data);
	    $("._myPlacesCalendar").bind("afterUpdate", function () {
		$("#calendarDateChooser a.btn.dropdown-toggle").html($(".myPlacesCalendar").attr("monthName") + " " + $(".myPlacesCalendar").attr("year"));
	    });
	    
	    $("._myPlacesCalendar").bind("dateSelected", function () {
		var monthYear = "-"+$(".myPlacesCalendar").attr("month")+"-"+$(".myPlacesCalendar").attr("year");
		var day1 = $("._myPlacesCalendar").find("span.day.select-start").attr("day");
		var day2 = $("._myPlacesCalendar").find("span.day.select-end").attr("day");
		
		if(day1<10) day1 = "0"+day1;
		if(day2<10) day2 = "0"+day2;
		
		$("#BookStartDate").val(day1+monthYear);
		$("#BookEndDate").val(day2+monthYear);
		$("#calendarEditModalAbilitySelectInput").val("yes");
		$("#calendarEditModalAbilityDivYes").show();
		$("#calendarEditModalAbilityDivNo").hide();
		$("#calendarEditModal").modal();
		$("#calendarEditModal").bind("hide", function(){
								    $("._myPlacesCalendar").myPlacesCalendar("clear");
								    });
	    });
	    
	    $("#calendarDateChooser").bind("prevButtonClick",function(){$("#myPlacesCalendar").myPlacesCalendar("prevMonth");});
	    $("#calendarDateChooser").bind("nextButtonClick",function(){$("#myPlacesCalendar").myPlacesCalendar("nextMonth");});
	    $("#calendarDateChooser").bind("indexChange",function(e,index){$("#myPlacesCalendar").myPlacesCalendar("setMonthIndex",index);});
	    ');
?>

    
