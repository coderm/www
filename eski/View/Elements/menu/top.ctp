<?php
		    $showTicketTools = true;

		    $languages = array();
		    $languages['tur'] = __('language_name_tur');
		    $languages['eng'] = __('language_name_eng');
		    $languages['rus'] = __('language_name_rus');


                    $loggedIn = CakeSession::read('User.LoggedIn');
                    $userId = CakeSession::read('User.Id');
		    
		    if($loggedIn)
		    {
			$a[] = array('permission'=>null,'label'=>__('top_menu_item_logout'),'url'=>array('controller'=>'users','action'=>'logout'));
			$a[] = array('permission'=>null,'label'=>__('top_menu_item_my_account'),'url'=>array('controller'=>'users','action'=>'profile'));
		    } else
		    {
			$a[] = array('permission'=>null,'label'=>__('top_menu_item_login'),'url'=>array('controller'=>'users','action'=>'login'));
		    }
		    
		    if($totalAdvertsInFavorites>0)
			$a[] = array('permission'=>null,'label'=>__('top_menu_item_my_favorites').' ('.$totalAdvertsInFavorites.')','url'=>array('controller'=>'favorites','action'=>'index'),'class'=>'notify');
		    
		    
		    $a[] = array('permission'=>'lp_user_menu_view_fanout','label'=>__('top_menu_item_bookings'),'url'=>array('controller'=>'bookingFanouts','action'=>'fanout'),'class'=>'');
		    //$a[] = array('permission'=>'lp_user_menu_view_booking','label'=>__('top_menu_item_bookings'),'url'=>array('controller'=>'bookings','action'=>'index'),'class'=>'');
		    $a[] = array('permission'=>'lp_user_menu_view_my_houses','label'=>__('top_menu_item_my_houses'),'url'=>array('controller'=>'renterDashboards'),'class'=>'');
		    $a[] = array('permission'=>'lp_user_menu_view_users','label'=>__('top_menu_item_users'),'url'=>array('controller'=>'users','action'=>'index'),'class'=>'');
		    $a[] = array('permission'=>'lp_user_menu_view_comment','label'=>__('top_menu_item_comments'),'url'=>array('controller'=>'comments','action'=>'index'),'class'=>'');
		    $a[] = array('permission'=>'lp_user_menu_view_invoice','label'=>__('top_menu_item_invoices'),'url'=>array('controller'=>'invoices','action'=>'index'),'class'=>'');

                    
		    
		    $a = array_reverse($a);

?>
    <div class="navbar navbar-inverse navbar-fixed-top">
<?php if(Configure::read('debug')==2):?>
	<div style="position: fixed;">
<div class="btn-group sql" style="margin: 3px 0;">
<button data-toggle="dropdown" class="btn btn-small dropdown-toggle">SQL <span class="caret" style="margin-top:8px"></span></button>
<ul class="dropdown-menu" style="width: 1400px;">
    <div style="padding:10px;height: 300px;overflow: scroll;"><?php echo $this->element('sql_dump'); ?></div>
</ul>
</div>
<div class="btn-group" style="margin: 3px 0;">
<button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Post Data <span class="caret" style="margin-top:8px"></span></button>
<ul class="dropdown-menu" style="width: 1400px;" id="post-data">
    <div style="padding:10px;height: 300px;overflow: scroll;"><?php pr ($this->request->data); ?></div>
</ul>
</div>	
		<?php if($showTicketTools): ?>	    
		<div class="btn-group" style="margin: 3px 0;">
		<a href="#ticket-modal" role="button" class="btn btn-small" data-toggle="modal">Hata Bildir</a>
		</div>	    
		<?php endif;?>
	</div>
<?php endif; ?>	
	
	
      <div class="navbar-inner">
        <div class="container">
<div class="btn-group" style="margin: 3px 0;">
<button data-toggle="dropdown" class="btn btn-small dropdown-toggle"><?php echo __('top_menu_language_button');?> <span class="caret" style="margin-top:8px"></span></button>
<ul class="dropdown-menu">
    <?php
	foreach ($languages as $key=>$language)
	{
	    $link = $this->Html->link($language,array('controller'=>'locales','action'=>'language',$key));
	    echo $this->Html->tag('li',$link);
	}
    ?>
</ul>
</div>



<div class="btn-group pull-right" style="margin: 3px 0;">
	      <?php
		foreach($a as $key=>$menuItem)
		{
		    if(isset($userPermissions[$menuItem['permission']]) || !isset($menuItem['permission']))
		    {
			if(!isset($menuItem['class']))
			    $menuItem['class'] = '';

			
			$button = $this->Html->link($menuItem['label'],$menuItem['url'],array('class'=>'btn btn-small '.$menuItem['class'],'escape'=>false));
			
			echo $button;  
		    }
  		}
	      ?>
</div>
        </div>
      </div>
    </div>    


<?php if($showTicketTools): ?>	
<div class="modal hide fade" id="ticket-modal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Hata Bildir</h3>
  </div>
  <div class="modal-body">
    <?php
	 echo $this->BSForm->create('Ticket');
	 echo $this->BSForm->input('description',array('bsSpan'=>6,'rows'=>3,'label'=>'Açıklama'));
	 echo $this->BSForm->hidden('address',array('value'=>$this->here));
	 echo $this->BSForm->hidden('userAgent', array('value'=>$_SERVER['HTTP_USER_AGENT']));
	 echo $this->BSForm->end();
    ?>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn">Vazgeç</a>
    <a href="#" class="btn btn-warning" id="submit-ticket">Kaydet</a>
  </div>
</div>

<?php

    $this->Js->Buffer('
    $("#submit-ticket").click(function(){
    
	
	
	$.ajax({
		type: "post",
		data: {
			description:$("#TicketDescription").val(),
			address:$("#TicketAddress").val(),
			userAgent:$("#TicketUserAgent").val(),
			html: $("body").html(),
			sql: $(".cake-sql-log").html(),
			postData: $("#post-data").html()
		    },
		url: "/tickets/add/",
		dataType: "json",
		success: function(response, status) {
		    var result = response.data.success;
		    
		    if(result)
		    {
			
		    } else
		    {
			alert("Hata bildirimi esnasında bir hata oluştu!");
		    }
		    
		    $("#ticket-modal").modal("hide");
		    
		}
	});
    });');
?>
<?php endif; ?>