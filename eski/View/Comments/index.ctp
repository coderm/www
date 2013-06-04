<div class="row">
<h4 class="headline">Onay Bekleyen Yorumlar</h4>
</div>
<?php

    foreach($comments as $comment)
    {
	if(is_array($comment) && isset($comment['Comment']))
	{
	    echo $this->element('/comments/item',array('comment'=>$comment,'advertLink'=>true));
	}
	    
    }
?>


