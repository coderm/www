<!-- File: /app/View/Advertisements/add.ctp -->
<?php
    echo $this->Html->addCrumb('Arama Sonuçları', '/searches');
    echo $this->Html->addCrumb('İlan Düzenleme');
?>

<div style="width:950px;float:left;" class="formContainer rounded10 RemoveIE_border-radius">
<?php echo $this->element('headline',array('label'=>'İlan Düzenleme'))   ?>
<?php
echo $this->Form->create('Advertisement',array('type' => 'file'));
echo $this->Form->hidden('operationType');
echo $this->Form->hidden('formId',array('value'=>$formId));

if(isset($fdId))
    echo $this->Form->hidden('fdId',array('value'=>$fdId));///Form database id
foreach($formElements as $element)
{
    echo $this->element('/forms/input',array('element'=>$element,'advert'=>$advert));
}


    if(isset($advertPermissions['lp_advert_status_update']))
    {
        echo '<br/>';        
        echo '<h3>Ev sahibi</h3>';
        echo $this->Form->hidden('houseHolder');
        echo '<div class="liveSearch">';
        echo $this->Form->input('householderSearch', array('label'=>'Arama (isim, soyisim, telefon numarası ya da mail adresi ile arama yapılabilir)','autocomplete'=>'off'));
        echo '<div class="results" id="liveSearchResults"></div>';
        echo '</div>';
        echo '<div id="houseHolderDetails" style="padding:9px;">';
            if(isset($houseHolderDetails))
            {
                $userDetails = $houseHolderDetails['userDetails'];
                    $uname = $userDetails['uname'];
                    $name = $userDetails['name'];
                    $email = $userDetails['email'];
                    $phone = $userDetails['phone'];
                echo '<b>'.$uname.'</b><br/> '.$name.' '.$email.' <h2>'.$phone.'</h2>';
            }
        echo '</div>';
    }
    
    if(isset($advertPermissions['lp_advert_status_update']))
    {
        echo '<br/>';
        echo '<h3>İlan Yönetimi</h3>';
        echo "<div class='input text radio'>";            
            echo '<label>Yayın durumu</label></br>';
            echo $this->Form->radio('status', array('1' => 'Yayında', '0' => 'Yayında değil'), array('legend' => false));
        echo "</div>";
        echo "<div class='input text radio'>";            
            echo '<label>Ana sayfada görüntülensin mi?</label></br>';
            echo $this->Form->radio('homePageStatus', array('1' => 'Evet', '0' => 'Hayır'), array('legend' => false));
        echo "</div>";        
    }


echo "<center>";
$options = array(
    'label' => 'Kaydet',
    'value' => 'Update!',
    'id' => 'formSubmit',
    'name' => 'formSubmit'
);
echo $this->Form->end($options);
echo "</center>";



foreach($formElements as $element)
{
     if(isset($element['properties']['feeder']))
        $feeder = $element['properties']['feeder'];
     else
        $feeder = 0;    
     
    
    if($feeder!=null && $feeder!="0")
    {
            $parentId = '#Advert'.Inflector::variable('isement_'.$element['type'].$feeder);
            $targetId = '#Advert'.Inflector::variable('isement_'.$element['type'].$element['detail_class_id']);
            
            $this->Js->get($parentId)->event('change', 
            $this->Js->request(array(
            'controller'=>'advertisements',
            'action'=>'getByCategory/'.$element['detail_class_id']
            ), array(
            'update'=>$targetId,
            'before'=>'selectReset(\''.$targetId.'\');',
            'async' => true,
            'method' => 'post',
            'dataExpression'=>true,
            'data'=> $this->Js->serializeForm(array(
            'isForm' => true,
            'inline' => true
            ))
            ))
            );
            
            
            $this->Js->get($parentId)->event('reset', 
                    'selectReset(\''.$targetId.'\');'
                    
            );            
    }
}        

            $this->Js->get('#AdvertisementFile')->event('change', 
            '
                document.getElementById("AdvertisementOperationType").value = "upload";
                document.getElementById("AdvertisementEditForm").target = "uploadIFrame";
                $("#AdvertisementEditForm").submit();
                uploadMode(true);
            '
            );
            
            $this->Js->get('#formSubmit')->event('click', 
            '
                document.getElementById("AdvertisementOperationType").value = "submit";
                document.getElementById("AdvertisementEditForm").target = "_self";
                $("#AdvertisementEditForm").submit();
            '
            );
            
            
            
            
            $this->Js->buffer(
                    '

                        function uploadMode(val)
                        {
                            $fileInput = $("#AdvertisementFile");
                            $messageDiv = $("#imageUploadingMessage");
                            if(val)
                            {
                                $fileInput.prop("disabled", true);
                                $messageDiv.show();
                            } else
                            {
                                $fileInput.prop("disabled", false);
                                $messageDiv.hide();
                            }
                        }

                        
                        $("#imagesContainer").sortable();
                        $("#imagesContainer").disableSelection();
                                 

                        function initOnImageDelete()
                        {
                            $(".imageRemove").click(
                                                function()
                                                {
                                                   $(this).parent().parent().parent().remove();
                                                }
                                                );
                        }


                        function drawImages()
                        {
                            $("#imagesContainer").sortable();
                            $("#imagesContainer").disableSelection();
                            initOnImageDelete();
                        }

                        function uploadResultHandler(result,name)
                        {
                            image = $("#imagesContainer").append("<li>"+result+"</li>");
                            $("#imagesContainer span").last().hide();
                            $("#imagesContainer span").last().fadeIn("slow");
                            drawImages();
                            uploadMode(false);                            
                        };
                        

                        

                        drawImages();
                        
                        
                    '
                    )
           

?>
</div>

<?php

            $this->Js->get('#AdvertisementHouseholderSearch')->event('keyup', 
                        'if($(this).val().length>2)
                        {'.
                        $this->Js->request(array(
                        'controller'=>'users',
                        'action'=>'searchHouseHolder/'
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
                        .'};'
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

  
                                });
                                var liveSearchResultsSelected = false;
                                '
                    );     
            
            
            $this->Js->buffer('
                                function selectReset(target)
                                {
                                    $(target).find(\'option\').remove().end().append(\'<option value="">-- Seçiniz --</option>\');
                                    $(target).trigger(\'reset\');
                                }
                                '
                    );                 
            
            $this->Js->get('#liveSearchResults')->event('mousedown', 
            '
                 realTarg = $(event.target);
                 while(!realTarg.hasClass("eventTarget"))
                    realTarg = realTarg.parent();
                 
                 $("#houseHolderDetails").html($(realTarg).html());
                 $("#AdvertisementHouseHolder").val($(realTarg).attr("id"));
                 $("#liveSearchResults").hide();
            '
            );    
           
            
            $this->Js->get('.liveSearch .input')->event('focusout', 
            '
                $("#liveSearchResults").hide();
            '
            );  
            
?>            
