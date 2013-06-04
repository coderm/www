<!-- File: /app/View/Advertisements/booking_details.ctp -->
<div style="width:700px;float:left;" class="formContainer rounded10">
<?php echo $this->element('headline',array('label'=>'Müşteri Bilgileri'))   ?>
    
<?php

    if(!isset($selectedUser))
    {
        echo "<div>";
        echo '<h3>Kayıtlı Kullanıcı Arama</h3>';
        echo '<div class="liveSearch formContainer rounded10" style="padding:0">';
        echo $this->Form->input('searchString', array('label' => 'Arama (isim, soyisim, telefon numarası ya da mail adresi ile arama yapılabilir)', 'autocomplete' => 'off'));
        echo '<div class="results" id="liveSearchResults"></div>';
        echo '</div>';
        echo "</div>";
        echo '<div style="position:relative;clear:both;">&nbsp;</div>';
    } else
    {
        echo "<h3>Kayıtlı Kullanıcı Bilgisi</h3>";
        echo "<table>";
        echo "<tr>";
            echo "<th>Ad - Soyad</th>";
            echo "<th>E-posta</th>";
            echo "<th>Telefon No</th>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>".$selectedUser['User']['uname']." ".$selectedUser['User']['sname']."</td>";
            echo "<td>".$selectedUser['User']['primary_email']."</td>";
            echo "<td>".$selectedUser['User']['phone']."</td>";
        echo "</tr>";
        echo "</table>";
    }

if(!isset($selectedUser))    
    echo "<h3>Yeni Kullanıcı Girişi</h3>";

echo $this->Form->create('User');
if(isset($showUserForm) && $showUserForm)
{
    echo $this->Form->input('name',array('label'=>'Adı'));
    echo $this->Form->input('sname',array('label'=>'Soyadı'));
    echo $this->Form->input('email1',array('label'=>'e-posta adresi'));
    echo $this->Form->input('phoneNumber',array('label'=>'Telefon numarası (örn: 532 555 55 55)','class'=>'phone'));
    //echo $this->Form->input('address',array('label'=>'Açık Adresiniz:'));
    //echo $this->Form->input('city', array('options' => $cities, 'empty' => '-- Seçiniz --','label'=>'İl'), null);
    //echo $this->Form->input('county', array('options' => array(), 'empty' => '-- İl Seçiniz --','label'=>'İlçe','ajaxParent'=>67), null);
}
echo $this->Form->input('totalGuests',array('label'=>'Toplam gelecek kişi sayısı:'));
echo $this->Form->input('note',array('label'=>'Notunuz:','rows'=>5));
echo '<center>';
echo $this->Form->end('Tamam');
echo '</center>';
echo '</div>';
if(isset($showUserForm))
{
            $parentId = '#UserCity';
            $targetId = '#UserCounty';
            
            $this->Js->get($parentId)->event('change', 
            $this->Js->request(array(
            'controller'=>'advertisements',
            'action'=>'getByCategory/68/'
            ), array(
            'update'=>$targetId,
            'async' => true,
            'method' => 'post',
            'dataExpression'=>true,
            'data'=> $this->Js->serializeForm(array(
            'isForm' => true,
            'inline' => true
            ))
            ))
            );
}
?>

<!-- Google Code for Rezervasyon Sayfas&#305;na Gelme Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1009776613;
var google_conversion_language = "tr";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "yBJ0CJui0QIQ5e-_4QM";
var google_conversion_value = 0;
if (5) {
  google_conversion_value = 5;
}
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1009776613/?value=5&amp;label=yBJ0CJui0QIQ5e-_4QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


<script type="text/javascript">$advertId='<?php echo $advertId;?>';</script>
<?php

$this->Js->get('#searchString')->event('sendSearchRequest', $this->Js->request(array(
            'controller' => 'users',
            
            'action' => 'searchUser'
                ), array(
            'update' => '#liveSearchResults',
            'success'=>'ajaxSearchQueryRequestComplete = true;sendSearcQueryRequest();',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);


$this->Js->buffer('
                        lastAjaxSearchQuery = "";
                        ajaxSearchQueryRequestComplete = true;
                        $("#searchString").keyup(function()
                        {
                            sendSearcQueryRequest();

                        }
                        )

                        function sendSearcQueryRequest()
                        {
                            if($("#searchString").val().length<3)
                                return;

                            if(lastAjaxSearchQuery==$("#searchString").val())
                                return;

                            if(!ajaxSearchQueryRequestComplete)
                                return;


                            lastAjaxSearchQuery=$("#searchString").val()

                            ajaxSearchQueryRequestComplete = false;
                            $("#searchString").trigger("sendSearchRequest", ["sendSearchRequest", "Event"]);

                        }

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

$this->Js->get('#liveSearchResults')->event('mousedown', '
                 realTarg = $(event.target);
                 while(!realTarg.hasClass("eventTarget"))
                    realTarg = realTarg.parent();
                 
                 $userId = ($(realTarg).attr("id"));
                 window.location = "/advertisements/booking/"+$advertId+"/userId:"+$userId;
            '
);


$this->Js->get('.liveSearch .input')->event('focusout', '
                $("#liveSearchResults").hide();
            '
);

?>

