<div style="position: relative;width:724px;margin-bottom:3px;">
<?php
	    
            $commentId = $comment['Comment']['comment_id'];
            $advertId = $comment['Comment']['advert_id'];
            $status = $comment['Comment']['status'];
            echo '<div class="advertComment rounded10">';
            echo '<span class="comment">"'.$comment['Comment']['comment'].'"</span>';
            
            

            
            
            if($comment['Comment']['scored']==1)
            {
                $rates = array();
                $rates['Karşılama'] = 'check_in_out';
                $rates['Temizlik'] = 'cleaning';
                $rates['Konfor'] = 'comfort';
                $rates['Fiyat/Kalite'] = 'value_for_money';

                $checkInOutRate = $comment['Comment']['check_in_out'];
                $checkInOutRate = $this->Number->precision($checkInOutRate,1);                
                
                echo '<div style="clear:both;margin-top:10px;">';
                foreach($rates as $label=>$code)
                {
                    echo '<div style="width:157px;float:right;margin-left:12px;">';
                    $rate = $comment['Comment'][$code];
                    $rate = $this->Number->precision($rate,1);
                    echo $this->Element("/comments/rateForComment",array("label"=>$label,"value"=>$rate));
                    echo '</div>';
                }
                echo '</div>';            
            }
            echo '<div class="user">'.$comment['CommentedUser']['name'].' '.$comment['CommentedUser']['sname'].' ,'.$comment['Comment']['add_date'].'</div>';
            
            if($status=='passive')
            {
                echo '<div class="operations">';
                    if(isset($advertLink) && $advertLink == true)
                        echo $this->Html->link('[İlana git]',array('controller'=>'advertisements','action'=>'advert',$advertId));
                    
                    echo $this->Html->link('[Sil]',array('controller'=>'comments','action'=>'updateStatus','deleted',$commentId));
                    echo $this->Html->link('[Yayınla]',array('controller'=>'comments','action'=>'updateStatus','active',$commentId));
                echo '</div>';
            }
            
            
            
            
            echo '</div>';
            echo '<div class="comment_tail"></div>';
?>
    <div style="clear:both"></div>
</div>