<div class="row">
<h4 class="headline">Kullanıcı İşlemleri</h4>
</div>
<?php
        echo '<h4>Kullanıcı Ara</h4>';
        echo '<div class="liveSearch row">';
        echo $this->BSForm->create("UserSearch");
        echo $this->BSForm->input('searchString', array('label'=>'İsim, soyisim, telefon numarası ya da mail adresi ile arama yapılabilir)','autocomplete'=>'off','class'=>'span5'));
        echo $this->BSForm->end();
        echo '<div class="results" id="liveSearchResults"></div>';
        echo '</div>';
?>

<?php

$this->Js->get('#UserSearchSearchString')->event('sendSearchRequest', $this->Js->request(array(
            'controller' => 'users',
            
            'action' => 'searchUser/'
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
                                $("#UserSearchSearchString").keyup(function()
                                {
                                    sendSearcQueryRequest()
                                }
                                )
                                
                                function sendSearcQueryRequest()
                                {
                                    if($("#UserSearchSearchString").val().length<3)
                                        return;
                                        
                                    if(lastAjaxSearchQuery==$("#UserSearchSearchString").val())
                                        return;
                                        
                                    if(!ajaxSearchQueryRequestComplete)
                                        return;
                                        

                                    lastAjaxSearchQuery=$("#UserSearchSearchString").val()
                                        
                                    ajaxSearchQueryRequestComplete = false;
                                    $("#UserSearchSearchString").trigger("sendSearchRequest", ["sendSearchRequest", "Event"]);
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
                 
                 window.location = "/users/user/"+($(realTarg).attr("id"));
            '
);


$this->Js->get('#.liveSearch .input')->event('focusout', '
                $("#liveSearchResults").hide();
            '
);

$this->Js->get('#selectedUser .closeButton')->event('click', '
                window.location = "/bookings/index/removeNamed:searhUserId";
            '
);

?>

