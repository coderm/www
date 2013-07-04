<div class="main-slider fleft">
    <div class="flexslider">
        <ul class="slides">
            <?php
              
            foreach ($homePageAdverds as $advert) {
                foreach ($advert['Advertisement']['picture'] as $picture) {
                    var_dump($advert['Advertisement']);exit;
                    ?>
                    <li><?php echo $this->Html->image($picture['path'], array('alt' => $picture['label'], 'border' => '0', 'width' => '692', 'height' => '346')); ?></li>
                    <?php
                    break;  
                }
            }
            ?>
        </ul>
    </div>
</div>
