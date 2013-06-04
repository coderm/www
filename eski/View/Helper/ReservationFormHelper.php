<?php
App::uses('AppHelper', 'View/Helper');
class ReservationFormHelper extends AppHelper
{
    var $helpers = array('Html','Form','BSForm','Js','DatePicker','Session');
    
    function create($advertId,$peopleCountOptions)
    {
            $this->DatePicker->addCssClass("left");
            
            $str = '';
            $str.= '<div id="fixedDiv">';
            $str.= '<div id="fixedDivContainer" style="z-index:50000">';
            $str.= '<div id="reservationForm" style="" class="rounded10">';
                $str.= $this->BSForm->create('Reservation', array('url' => array('controller' => 'advertisements', 'action' => 'booking',$advertId)));            
                $str.= $this->Html->image('reservation/teaser.png',array('border'=>'none'));

		$str.= '<div class="row">';
		$str.= $this->BSForm->hidden('advertId',array('value'=>$advertId));
		$str.= $this->BSForm->hidden('Booking.formType',array('value'=>'booking-new-book'));
		$str.= $this->BSForm->input('checkInDate',array('label'=>false,'before'=>'<i class="icon-calendar alpha60"></i>','div'=>array('style'=>'width:149px;margin-top:10px;'),'class'=>'pickDate','style'=>'width:100%;','placeholder'=>'Giriş Tarihini seç','bsSpan'=>0));
		$str.= $this->BSForm->input('checkOutDate',array('label'=>false,'before'=>'<i class="icon-calendar alpha60"></i>','div'=>array('style'=>'width:149px;'),'class'=>'pickDate','style'=>'width:100%;','placeholder'=>'Çıkış Tarihini seç','bsSpan'=>0));
		$str.= $this->BSForm->input('totalGuests',array('label'=>false,'before'=>'<i class="icon-user alpha60"></i>','div'=>array('style'=>'width:162px;'),'style'=>'width:100%;','placeholder'=>'Kişi Sayısı','bsSpan'=>0,'options'=>$peopleCountOptions));
		$str.= '</div>';
                $str.= '<div id="reservationResult">';
                
                $str.= '</div>';    
		
		$str.= $this->Html->tag('button','<i class="icon-bell icon-white alpha60"></i> Rezervasyon Yap',array('escape'=>false,'class'=>'btn btn-block btn-large btn-warning interactive','id'=>'reservationButton'));
                $str.= $this->Form->end();		
          

            $str.= '</div>';
            $str.= '</div>';
            $str.= '</div>';
            $this->initJS($advertId);
            return $str;
    }
    
    function createCompleteOfferButton($advertId)
    {
            $this->DatePicker->addCssClass("left");
            
            $str = '';
            $str.= '<div id="fixedDiv">';
            $str.= '<div id="fixedDivContainer" style="z-index:50000">';
            $str.= '<div id="reservationForm" style="" class="rounded10">';
                $str.= $this->BSForm->create('Reservation', array('url' => array('controller' => 'advertisements', 'action' => 'booking',$advertId)));            
                $str.= $this->Html->image('reservation/teaser.png',array('border'=>'none'));

		$str.= '<div class="row">';
		$str.= $this->BSForm->hidden('advertId',array('value'=>$advertId));
		$str.= $this->BSForm->hidden('Booking.formType',array('value'=>'booking-new-book'));
		$str.= '</div>';
                $str.= '<div id="reservationResult">';
                
                $str.= '</div>';    
		
		$str.= $this->Html->tag('button','<i class="icon-bell icon-white alpha60"></i> Rezervasyonu Tamamla',array('escape'=>false,'class'=>'btn btn-block btn-large btn-warning interactive','id'=>'reservationButton'));
                $str.= $this->Form->end();		
          

            $str.= '</div>';
            $str.= '</div>';
            $str.= '</div>';
            $this->initJS($advertId);
            return $str;
    }
    
    function initJS($advertId)
    {
            $this->Js->buffer('



                                $(document).ready(function() {
                                    var theLoc = 121;;

                                    $(window).scroll(function() {
                                        if(theLoc >= $(window).scrollTop()) 
                                        {
                                            if($("#fixedDiv").hasClass("reservationFormFixed")) 
                                                $("#fixedDiv").removeClass("reservationFormFixed");         
                                            if($("#fixedDiv").hasClass("reservationFormFixedBottom")) 
                                                $("#fixedDiv").removeClass("reservationFormFixedBottom");                                                  
                                        }
                                        else
                                        { 
					    if($(window).scrollTop()>=$(document).height()-($("#reservationForm").height()+$(".footer-container").height()+100))
                                            {
                                                    if(!$("#fixedDiv").hasClass("reservationFormFixedBottom")) 
                                                        $("#fixedDiv").addClass("reservationFormFixedBottom");
                                            }
                                            else
                                            {
                                                if(!$("#fixedDiv").hasClass("reservationFormFixed")) 
                                                    $("#fixedDiv").addClass("reservationFormFixed");
                                                if($("#fixedDiv").hasClass("reservationFormFixedBottom")) 
                                                    $("#fixedDiv").removeClass("reservationFormFixedBottom");  
                                            }
                                        }
                                    });
                                });
                                

                                var RESERVATION_BUTTON_STATE_ACTIVE = "reservation_button_active";
                                var RESERVATION_BUTTON_STATE_DEACTIVE = "reservation_button_state_deactive";
                                var RESERVATION_BUTTON_STATE_WAITING = "reservation_button_state_waiting";



                                $("#reservationForm .interactive").click
                                (
                                    function(event)
                                    {
					event.preventDefault();
                                        if($("#ReservationCheckInDate").val()=="")
                                        {
                                            $("#ReservationCheckInDate").focus();
                                        } else if($("#ReservationCheckOutDate").val()=="")
                                        {
                                            $("#ReservationCheckOutDate").focus();
                                        } else if($(event.target).attr("id")=="reservationButton")
                                        {
                                            $("#ReservationViewForm").submit();
                                        }
                                    }
                                );
				
                                
                                $("#ReservationCheckInDate").focus
                                (
                                    function ()
                                    {
                                        updateButtonState();
					 requestPrice();
                                    }
                                ); 
                                $("#ReservationCheckOutDate").focus
                                (
                                    function ()
                                    {
                                        updateButtonState()
                                        requestPrice();
                                    }
                                );                       
				$("#ReservationTotalGuests").change
				(
				    function()
				    {
					updateButtonState();
					requestPrice();
				    }
				)
                                $("#reservationButton").focus
                                (
                                    function ()
                                    {
                                        updateButtonState()
                                        requestPrice();
                                    }
                                );
				

                                
                                function requestPrice()
                                {
                                    rezervationState(RESERVATION_BUTTON_STATE_WAITING);
                                    $.ajax({
                                    type: "POST",
                                    url: "/advertisements/calculatePrice/",
                                    data: "advertId='.$advertId.'&checkInDate="+$("#ReservationCheckInDate").val()+"&checkOutDate="+$("#ReservationCheckOutDate").val()+"&totalGuests="+$("#ReservationTotalGuests").val()
                                    }).done(function( msg ) {
                                        $("#reservationResult").html(msg);
                                        updateButtonState();
                                    });
                                }
                                
                                function updateButtonState()
                                {
                                    if($("#ReservationCheckInDate").val()=="" || $("#ReservationCheckOutDate").val()=="")
                                    {
                                        rezervationState(RESERVATION_BUTTON_STATE_DEACTIVE)
                                    } else
                                    {
                                        rezervationState(RESERVATION_BUTTON_STATE_ACTIVE)
                                    }
                                }
                                
                                function rezervationState(val)
                                {
				    $("#reservationForm button").removeClass("btn-primary");
				    $("#reservationForm button").removeClass("btn-alert");
				    $("#reservationForm button").removeClass("btn-info");
				    $("#reservationForm button").removeClass("btn-warning");
                                    switch(val)
                                    {   
                                        case RESERVATION_BUTTON_STATE_ACTIVE:
                                            $("#reservationForm button").addClass("btn-primary");                         
                                        break;
                                        case RESERVATION_BUTTON_STATE_WAITING:
                                            $("#reservationForm button").addClass("btn-primary");                                       
                                        break;  
                                        case RESERVATION_BUTTON_STATE_DEACTIVE:
                                            $("#reservationForm button").addClass("btn-primary");                                      
                                        break;                                         
                                    }
                                }


                                '
                    );  
    }
}

?>
