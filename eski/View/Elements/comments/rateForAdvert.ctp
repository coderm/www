<div class="rate-stars">
    <div class="stars-container">
                <?php 
                    for($i = 0; $i<5; $i++)
                    {
                        if($i<$value)
                            $cssClass = 'ratingStar over';
                        else
                            $cssClass = 'ratingStar';
                        
                        echo '<span class="'.$cssClass.'"></span>';
                    }
                ?>
    </div>
    <label><?php echo $label ?></label>
</div>
