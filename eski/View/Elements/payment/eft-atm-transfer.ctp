<div style="overflow: scroll; height: 120px;">
    <h6>Koşullar</h6>
    <p>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
    </p>
    <p>
It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
    </p>
    <p>
Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.	
    </p>
</div>

<?php
    $currency = $creditCardInstallements['common']['currency'];


    $bankAccounts = array();
    $bankAccounts['TRY'] = 'Garanti Bankası Ümraniye Sanayi Şubesi, IBAN: <strong>TR09 0006 2000 7870 0006 2986 17</strong>';
    $bankAccounts['EUR'] = 'Garanti Bankası Ümraniye Sanayi Şubesi, IBAN: <strong>TR76 0006 2000 7870 0009 0949 88</strong>';

    echo '<table class="table">';
    echo '<tr>';
    echo $this->Html->tag('th', 'Ödeme Özeti');
    echo '</tr>';
    echo '<tr>';
    echo $this->Html->tag('td', $creditCardInstallements['common']['eftPrice'].' '.$creditCardInstallements['common']['currency']. ' EFT / Havale');    
    echo '</tr>';
    echo '<tr>';
    echo $this->Html->tag('td',$bankAccounts[$currency]);    
    echo '</tr>';
    echo '</table>';
    
    
    echo $this->BSForm->hidden('Payment.type',array('value'=>'eft'));
    echo $this->BSForm->hidden('Booking.trackId',array('value'=>$creditCardInstallements['common']['trackId']));
    echo $this->BSForm->input('Booking.agreement',array('label'=>'Kullanıcı sözleşmesini kabul ediyorum', 'type'=>'checkbox','div'=>array('style'=>'margin:10px 0;')));
    echo $this->BSForm->newRow();
    echo $this->BSForm->submit('Tamam',array('class'=>'btn btn-primary btn-large quick-advert-submit pull-right disabled', 'id'=>'paymentSubmitButton'));
	    $this->Js->Buffer('
		
	$("#BookingAgreement").click(function(){
	    if($("#BookingAgreement").prop("checked"))
		$("#paymentSubmitButton").removeClass("disabled");
	    else
		$("#paymentSubmitButton").addClass("disabled");

	});
	

	$("#paymentSubmitButton").click(function(e){
	    e.preventDefault;
	    
	    return !$("#paymentSubmitButton").hasClass("disabled");
	});
	


');
	    


?>