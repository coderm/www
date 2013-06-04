<label>Kart Sahibinin Adı Soyadı</label>
<div id="payu-card-cardholder-placeholder" class="card" ></div>
<label>Kart No</label>
<div id="payu-card-number-placeholder" class="card" ></div>
<label>CCV Kodu</label>
<div id="payu-card-cvv-placeholder" class="card" ></div>

<div class="row">
<?php
    $monthOptions = array();
    for($i=1; $i<13;$i++)
	$monthOptions[$i] = ($i>9)?$i:'0'.$i;
    
    echo $this->BSForm->input('CardExpMonth',array('class'=>'card','id'=>'payu-card-expm','bsSpan'=>1,'style'=>'width:100%;','options'=>$monthOptions,'label'=>__('payu_input_label_card_expire_date_moon'))); 
    $yearOptions = array();
    for($i=2013; $i<2026;$i++)
	$yearOptions[$i] = $i;
    
    echo $this->BSForm->input('CardExpYear',array('class'=>'card','id'=>'payu-card-expy','bsSpan'=>2,'style'=>'width:100%;','options'=>$yearOptions,'label'=>__('payu_input_label_card_expire_date_year'))); 
    echo $this->BSForm->newRow();
    $installementOptions = $payUInstallementOptions['available_installments'];
    //echo $this->BSForm->input('Installement',array('class'=>'card','id'=>'payu-card-installment','bsSpan'=>2,'style'=>'width:100%;','options'=>$installementOptions,'label'=>__('payu_input_label_installment_options'))); 
?>
</div>
<input type="hidden"  class="card"  id="payu-card-installment"/>
<input type="submit" id="payu-cc-form-submit" value="Tamam" class="btn btn-large pull-right"/>



<div style="position: absolute;right: 0;top:0;width: 230px;padding: 40px 20px;">
    <p><span id="card-program"></p>
    <p><span id="error"></p>
</div>
		<link rel="stylesheet"  type="text/css" href="https://secure.payu.com.tr/openpayu/v2/client/openpayu-builder-2.0.css">


<?php

$this->Html->script(array('https://secure.payu.com.tr/openpayu/v2/client/json2.js',
				'https://secure.payu.com.tr/openpayu/v2/client/openpayu-2.0.js',
				'https://secure.payu.com.tr/openpayu/v2/client/plugin-payment-2.0.js',
				'https://secure.payu.com.tr/openpayu/v2/client/plugin-installment-2.0.js'
			),array('inline' => false));



$payUIdAccount	= 'HGOEHFME';
$userEmail	= 'onur@tatilevim.com';		
$userFirstName	= $currentUser['User']['name'];
$userLastName	= $currentUser['User']['sname'];
$userPhoneNumber= implode(' ',$currentUser['User']['ldc_user_phone']);
$amount		= '1';
$description	= 'Test ödeme';
$currency	= 'TRY';
$bookingId	= $this->request->data['Booking']['bookingId'];




$this->Js->Buffer(
"
$(function() {
				/*
				//**********************************************************
				//installment setup 
				//**********************************************************
		
				//used to control some stuff when card program is change
				OpenPayU.Installment.onCardChange(function(data) { //optional
					//data.program - Axess, Bonus, Maximum, Advantage, CardFinans, World
					$('#card-program').html(JSON.stringify(data.program));
					getAvailableInstallments();

				});
				

				function getAvailableInstallments()
				{
				    $.ajax({
					url: 'https://secure.payu.com.tr/openpayu/v2/installment_payment.json/get_available_installments/HGOEHFME/100',
					dataType: 'jsonp',
					contentType: 'application/json',
					async: false,
					cache: false,
					success: function (response) {

					    
					},
					error: function (ErrorResponse) {


					}				      
				    }).done(function( html ) {

				    });		
				    
				}
				
				*/
				




				//**********************************************************
				//payment setup
				//**********************************************************
				OpenPayU.Payment.setup({id_account : '".$payUIdAccount."',orderCreateRequestUrl:'/ocr.php'});


				$('#payu-cc-form-submit').click(function() {
					//add preloader
					OpenPayU.Builder.addPreloader('Please wait ... ');
					
					//**********************************************************
					//begin payment 
					//**********************************************************
					OpenPayU.Payment.create({
						//merchant can send to his server side script other additional data from page. (OPTIONAL)
						orderCreateRequestData : {
							Email :			'".$userEmail."',
							FirstName :		'".$userFirstName."', 
							LastName :		'".$userLastName."',
							Amount :		'".$amount."',
							Description :		'".$description."',
							Phone:			'".$userPhoneNumber."',
							Currency :		'".$currency."',
							BookingId :		'".$bookingId."'
						}
					},function(response) {

						if (response.Status.StatusCode == 'OPENPAYU_SUCCESS') {
						    $('#BookingPaymentResult').val(JSON.stringify(response));
						    $('#BookingBookingForm').submit();
						} else {
						    alert('".__('credit_card_payment_error')."');
						    OpenPayU.Builder.removePreloader();
						}
						return false;
					});
					return false;
				});
			}());"
	
	
	);


