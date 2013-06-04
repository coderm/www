<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $i18n = I18n::getInstance();
    $translateKeysCollection = $i18n->translateKeysCollection;
    
    echo '<table class="table">';
    
    $headers = array();
    $headers[] = 'Tr';
    $headers[] = 'En';
    $headers[] = 'Ru';
    
    echo $this->Html->tableHeaders($headers);
    
    foreach($translateKeysCollection as $key):
	$cells = array();
	$cells['tur'] = $i18n->translate($key, null, null, 6, null, 'tur');
	$cells['eng'] = $i18n->translate($key, null, null, 6, null, 'eng');
	$cells['rus'] = $i18n->translate($key, null, null, 6, null, 'rus');
	
	foreach($cells as $langKey=>$val)
	{
	    $cells[$langKey] = $this->Html->link('<i class="icon icon-edit"></i> '.$val, '#',array('escape'=>false,'class'=>'translator '.$langKey,'rel'=>$key));
	}
	echo $this->Html->tableCells($cells);
    endforeach;
    
    echo '</table>';

    
  
?>

<div id="languageEditor" class="modal hide">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Çeviri Aracı</h3>
  </div>
  <div class="modal-body">
    <?php
	echo $this->BSForm->create('Translate');
	echo $this->Html->tag('label','test',array('id'=>'tr_label'));
	echo $this->BSForm->input('translatedText',array('bsSpan'=>5,'cols'=>3,'label'=>false));
    ?>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn save-button">Güncelle</a>
  </div>
</div>

<script>
    
    var lastClickedLocaleTranslateObject;
    
    $('.translator').click(function(event){
	event.preventDefault(); 
	
	lastClickedLocaleTranslateObject = $(event.target);
	

	
	
	
	
	$('#languageEditor').modal();

    });
    
    $('#languageEditor').on('shown', function () {
	
	$('#languageEditor').css('z-index',5000000000);
	var rel = $(lastClickedLocaleTranslateObject).attr('rel');
	var tr_text = $('a.tur[rel="' + rel + '"]').html();
	var target_text = $(lastClickedLocaleTranslateObject).html();
	
	target_text = target_text.replace(/<i[^>]*?>[\s\S]*?<\/i>/gi, '');	
	
	$('#tr_label').html(tr_text);

	
	$('#TranslateTranslatedText').val(target_text);  
	$('#TranslateTranslatedText').focus();  
    })

    
   
    
    $('#languageEditor .save-button').click(function(event){
	event.preventDefault(); 
	
	var rel = lastClickedLocaleTranslateObject.attr('rel');
	var newMsgStr =  $('#TranslateTranslatedText').val();
	
	var lang;
	if(lastClickedLocaleTranslateObject.hasClass('eng'))
	    lang = 'eng';
	else if(lastClickedLocaleTranslateObject.hasClass('tur'))
	    lang = 'tur';
	else if(lastClickedLocaleTranslateObject.hasClass('rus'))
	    lang = 'rus';
	
	$.ajax({
		type: "post",
		data: {lang:lang,msgId:rel, msgStr:newMsgStr},
		url: "/locales/update/",
		dataType: "json",
		success: function(response, status) {
		    var result = response.data.success;
		    if(result)
		    {
			lastClickedLocaleTranslateObject.html('<i class="icon icon-edit"></i> ' + newMsgStr);
			lastClickedLocaleTranslateObject.hide();
			lastClickedLocaleTranslateObject.show(2000);
			
		    } else
		    {
			alert("Güncelleme esnasında bir hata oluştu!");
		    }
		    
		    $('#languageEditor').modal('hide');
		    
		}
	});
    });
    
	
</script>