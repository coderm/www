<?php
       $tlOptions = array(
                        'places' => 2,
                        'before' => '',
                        'after' => ' TL',
                        'escape' => false,
                        'decimals' => ',',
                        'thousands' => '.'
                    );
       
       $rowString = '';
       foreach($rowsData as $rowData)
       {
           $s = "";
           if(isset($rowData[0]))
           {
               
               $s.= 'Rezervasyon Hizmet Bedeli: '.$rowData[0]['renter'];
               $s.= "|";
               $s.= $rowData[0]['booking_id'];
               $s.= "|";
               $s.= $this->Number->format($rowData[0]['net'],$tlOptions);
               
               if($rowString!="")
                $rowString.='[|]';
                   
               $rowString.= $s;
           } else
           {
               $amounts = $rowData;
           }
       }
       
       $title = '';
       $taxOffice = '';
       $taxId = '';
       $tcNo = '';
       $invoiceAdress = '';
       
       if(isset($userDetails['ldc_invoice_title']))
        $title = $userDetails['ldc_invoice_title'];
       
       if(isset($userDetails['ldc_invoice_tax_office']))
        $taxOffice = $userDetails['ldc_invoice_tax_office'];
       
       if(isset($userDetails['ldc_invoice_tax_id']))
        $taxId = $userDetails['ldc_invoice_tax_id'];
       
       if(isset($userDetails['ldc_user_tc_no']))
        $tcNo = $userDetails['ldc_user_tc_no'];
       
       if(isset($userDetails['ldc_invoice_address']))
        $invoiceAdress = $userDetails['ldc_invoice_address'];
       
       $name = $user['User']['name'];
       $sname = $user['User']['sname'];
       $address = $user['User']['address'];
       $phone = $user['User']['phone'];
?>
<?php #FORM START ########################################################################################### ?>
<?PHP
        echo $this->Form->create('ConfirmPrint');
        echo $this->Form->hidden('ids',array('value'=>$selectedBookingsString));
        echo $this->Form->end('Fatura Sorunsuz Olarak Basıldı');
?>
<?php #FLASH START ########################################################################################### ?>
<div id="flashContent" style="width:100%;">
    <p>
        To view this page ensure that Adobe Flash Player version 
        10.2.0 or greater is installed. 
    </p>
    <script type="text/javascript"> 
        var pageHost = ((document.location.protocol == "https:") ? "https://" : "http://"); 
        document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='" 
                        + pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
    </script> 
</div>
<?php echo $this->Html->script(array('swfobject'));?>
<script type="text/javascript">
    // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection. 
    var swfVersionStr = "10.2.0";
    // To use express install, set to playerProductInstall.swf, otherwise the empty string. 
    var xiSwfUrlStr = "playerProductInstall.swf";
    var flashvars = {};
    
    flashvars.clientTitle = '<?php echo $title; ?>';
    flashvars.clientName = '<?php echo $name; ?>';
    flashvars.clientSurName = '<?php echo $sname; ?>';
    flashvars.clientPhone = '<?php echo $phone; ?>';
    flashvars.clientTaxOffice = 'Vergi Dairesi: <?php echo $taxOffice; ?>';
    flashvars.clientTaxNo = '\nVergi No: <?php echo $taxId; ?>';
    flashvars.clientTCNo = '<?php echo $tcNo; ?>';
    flashvars.clientAdress = '<?php echo $invoiceAdress; ?>';
    flashvars.invoiceDate = '31.03.2013';
    flashvars.deliveryDate = '-';
    flashvars.deliveryNumber = '-';
    flashvars.totalVAT = '<?php echo $this->Number->format($amounts['vat'],$tlOptions); ?>';
    flashvars.total = '<?php echo $this->Number->format($amounts['total'],$tlOptions); ?>';
    
    flashvars.rowsString = '<?php echo $rowString; ?>';
    
    var params = {};
    params.quality = "high";
    params.bgcolor = "#ffffff";
    params.allowscriptaccess = "sameDomain";
    params.allowfullscreen = "true";
    
    var attributes = {};
    attributes.id = "tatilEvimInvoicePrint";
    attributes.name = "tatilEvimInvoicePrint";
    attributes.align = "middle";
    swfobject.embedSWF(
        "/flash/invoice/tatilEvimInvoicePrint.swf", "flashContent", 
        "598", "846", 
        swfVersionStr, xiSwfUrlStr, 
        flashvars, params, attributes);
    // JavaScript enabled so display the flashContent div in case it is not replaced with a swf object.
    swfobject.createCSS("#flashContent", "display:block;text-align:left;");
</script>
<?php #FLASH END ###########################################################################################?>
