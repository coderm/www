    <?php
        foreach($comments as $comment)
        {
            if(is_array($comment) && isset($comment['Comment']))
                echo $this->element('/comments/item',array('comment'=>$comment));
            
        }
        

        echo '<div style="margin-top:10px;" class="formContainer comment">';
        echo '<div class="loading" style="display:none;text-align:center;"><img src="/img/loading.gif"/> Yükleniyor...</div>';
        if(isset($message) && $message!='')
        {
            echo '<div id="commentMessage" style="background-color:#b1d91d;padding:10px; color:#556225;font-weight:bold;" class="rounded5">'.$message.'</div>';
            echo '<script>$("commentMessage").show("slow")</script>';
        }
        
        $itemsPerPage = 5;
        $total = $comments['count'];
        
        if(floor($total/$itemsPerPage) == ($total/$itemsPerPage))
            $totalPages = $total/$itemsPerPage;
        else
        $totalPages = floor($total/$itemsPerPage) + 1;
        
        
        
        if(isset($page))
            $currentPage = $page;
        else
            $currentPage = 1;
        
        if($totalPages>1):
        echo '<div style="text-align:center;">';
        echo '<div>Sayfa '.$currentPage.' / '.$totalPages.'</div>';
        
        for($i = 0;$i<$totalPages;$i++)
        {
            if(($i+1)!=$currentPage)
                echo $this->Js->link(($i+1).' ', array('controller'=>'comments','action'=>'listView',$placeId,$i+1), array('update' => '#commentsContainer',
                                                                                                                            'evalScripts' => false,
                                                                                                                            'before' => $this->Js->get('#commentsContainer div.loading')->effect('fadeIn', array('buffer' => false)),
                                                                                                                            'complete' => $this->Js->get('#commentsContainer')->effect('fadeIn', array('buffer' => false))
                    
                                                                                                                        ));
            else
               echo ($i+1).' ';
        }
        echo '</div>';
        endif;
        
        if($this->Session->read('User.LoggedIn'))
        {
            echo $this->BSForm->create('Comment');
            echo $this->BSForm->hidden('advertId',array('value'=>$placeId));
	    echo '<div class="row">';
            echo $this->BSForm->input('comment',array('rows'=>2,'label'=>false,'bsSpan'=>9));
	    
	    
            if($showRatingInputs)
            {
                echo '<div id="advertRating">';
                echo $this->Element('/comments/ratingInputItem',array('label'=>'Giriş - çıkış işlemleri','id'=>'checkInCheckOut'));
                echo $this->Element('/comments/ratingInputItem',array('label'=>'Temizlik','id'=>'cleaning'));
                echo $this->Element('/comments/ratingInputItem',array('label'=>'Konfor','id'=>'comfort'));
                echo $this->Element('/comments/ratingInputItem',array('label'=>'Fiyat / Kalite oranı','id'=>'valueOfMoney'));
                echo '<div>';
                
                $this->Js->Buffer('$(document).ready(function(){$(".ratingInput").advertRating()});');
            }

            echo $this->Js->submit('Yorum yap', array('url' => '/comments/add', 'update' => '#commentsContainer', 'class'=>'btn pull-right', 'style'=>'margin-right:20px;',
                                                      'before' => $this->Js->get('#commentsContainer div.loading')->effect('fadeIn', array('buffer' => false))
                                                    ));
	    echo '</div>';
	    
            if(isset($isAjax) && $isAjax)
                echo $this->Js->writeBuffer(); 
        } else
        {
            echo 'Yorum yapabilmek için giriş yapmalısınız. Giriş yapmak için ';
            echo $this->Html->link('tıklayın',array('controller'=>'users','action'=>'login'));
        }
	echo '<div style="clear:both;"></div>';
        echo '</div>';
    ?>
    <div style="clear:both;"></div>
    
    
    
    