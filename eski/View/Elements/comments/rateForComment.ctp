<div style="font-size:10px;text-align: right;">
    <span><?php echo $label ?></span>
    <span>
                <?php 
                    for($i = 0; $i<5; $i++)
                    {
                        if($i<$value)
                            $cssClass = 'ratingStar mini over';
                        else
                            $cssClass = 'ratingStar mini';
                        
                        echo '<span class="'.$cssClass.'"></span>';
                    }
                ?>
    </span>
</div>
