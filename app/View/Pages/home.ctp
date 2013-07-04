
 
        <div class="main">

            <!-- orta alan burdan başlıyor-->            
<?php //echo $this->Element('pages/home/advert_list',array('adverts'=>$homePageAdverts,'label'=>'<i class="icon icon-heart icon-h4 alpha60"></i> '.__('headline_home_popular_places'),'modelName'=>'vw_get_adverts')) ;?>

            <div id="mainBannerContainer"><?php echo $this->element('mainBannersLarge',array('adverts'=>$homePageAdverts));?></div>
            <div id="showReelCitiesContainer"><?php echo $this->element('showReelCities');?></div>
            
            <div class="clear"></div>

            <img src="img/serit1.png"  width="950" height="20" class="mt15 " />

            <div class="center-info mb20">

                <div class="infobox1 fleft">
                    <div class="info-image fleft sprite"></div>
                    <div class="info fleft">
                        <div class="baslik">Bulmak Çok Kolay</div>
                        <div class="text">It was popularised in the 1960s withthe release of Letraset sheets containing Lorem Ipsum passages,</div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="infobox2 fleft">
                    <div class="info-image fleft sprite"></div>
                    <div class="info fleft">
                        <div class="baslik">Sınırsız Destek</div>
                        <div class="text">It was popularised in the 1960s withthe release of Letraset sheets containing Lorem Ipsum passages,</div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="infobox3 fleft">
                    <div class="info-image fleft sprite"></div>
                    <div class="info fleft">
                        <div class="baslik">Güvenli Alışveriş</div>
                        <div class="text">It was popularised in the 1960s withthe release of Letraset sheets containing Lorem Ipsum passages,</div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>


            <div id="one-cikanlar">
                
                <div class="baslik">
                    <h1 class="two"><span>ÖNE ÇIKANLAR</span></h1>
                    <p></p>
                </div>

                <ul class="advert-box">
                    <?php $count=0;
                         foreach ($oneCikanlarAdverts as $advert) {
                         // var_dump($advert);exit;
                            foreach ($advert['Advertisement']['picture'] as $picture) {
                             echo ($count % 3 == 2) ? '<li class="resetmargin" style="margin:0px;">' : '<li>';
                      
                            echo '<div class="relative">';
                                echo $this->Html->image($picture['thumb'], array('alt' => $picture['label'], 'border' => '0', 'width'=>'300', 'height'=>'225'));
                                echo '</br>';
                                echo '<div class="fiyatbox2 spritefiyat">
                                        <div class="fiyat">'.$advert["Advertisement"]["demand"].'<sup>'.$advert["Advertisement"]["currency"].'</sup></div>
                                     </div>    
                                <div class="advert-detay">';
                                if(strlen($advert['Advertisement']['title']['tur'])>32){
                                   echo '<h1>'.substr($advert['Advertisement']['title']['tur'],0,32).'..</h1>';
                                 }else{
                                   echo '<h1>'.$advert['Advertisement']['title']['tur'].'</h1>';
                                 }
                                 if(strlen($advert['Advertisement']['title']['address'])>55){
                                   echo '<h2>'.substr($advert["Advertisement"]["address"],0,55).'..</h2>';
                                  }else{
                                   echo '<h2>'.$advert["Advertisement"]["address"].'</h2>';   
                                  }
                                '</div>';
                            echo '</div></li>'; $count++; break;}
                        }?>
                    <li style="margin:0px;">
                        <div class="nereden-ev-kiralamak">
                            <img src="img/nereden-kiralamak-istiyorsunuz.png" alt="" width="295" height="168" /> 
                            <ul>
                                <li><a href="">İstanbul</a></li>
                                <li><a href="">İstanbul</a></li>
                                <li><a href="">İstanbul</a></li>
                                <li><a href="">İstanbul</a></li>
                                <li><a href="">İstanbul</a></li>
                                <li><a href="">İstanbul</a></li>
                                <li><a href="">İstanbul</a></li>
                                <li><a href="">İstanbul</a></li>
                                <li><a href="">İstanbul</a></li>
                            </ul>
                        </div>

                    </li> 
                </ul>
            </div>


            <div id="sondakika-firsatlari">
                <div class="baslik">
                    <h1 class="two"><span>SON DAKİKA FIRSATLARI</span></h1>
                    <p></p>
                </div>
                
                <ul class="advert-box">
                    <?php $count=0;
                         foreach ($lastBooksAdverts as $advert) {
                         // var_dump($advert);exit;
                            foreach ($advert['Advertisement']['picture'] as $picture) {
                             echo ($count % 3 == 2) ? '<li class="resetmargin" style="margin:0px;">' : '<li>';
                      
                            echo '<div class="relative">';
                                echo $this->Html->image($picture['thumb'], array('alt' => $picture['label'], 'border' => '0', 'width'=>'300', 'height'=>'225'));
                                echo '</br>';
                                echo '<div class="fiyatbox2 spritefiyat">
                                        <div class="fiyat">'.$advert["Advertisement"]["demand"].'<sup>'.$advert["Advertisement"]["currency"].'</sup></div>
                                     </div>    
                                <div class="advert-detay">';
                                if(strlen($advert['Advertisement']['title']['tur'])>32){
                                   echo '<h1>'.substr($advert['Advertisement']['title']['tur'],0,32).'..</h1>';
                                 }else{
                                   echo '<h1>'.$advert['Advertisement']['title']['tur'].'</h1>';
                                 }
                                 if(strlen($advert['Advertisement']['title']['address'])>55){
                                   echo '<h2>'.substr($advert["Advertisement"]["address"],0,55).'..</h2>';
                                  }else{
                                   echo '<h2>'.$advert["Advertisement"]["address"].'</h2>';   
                                  }
                                '</div>';
                            echo '</div></li>'; $count++; break;}
                        }?>
                </ul>
                <div class="clear"></div>
            </div>            

            <div id="guncel-rezervasyonlar">
                <div class="baslik">
                    <h1 class="two"><span>GÜNCEL REZARVASYONLAR</span></h1>
                    <p></p>
                </div>
                <ul class="advert-box">
                    <?php $count=0;
                         foreach ($homePageAdverts as $advert) {
                         // var_dump($advert);exit;
                            foreach ($advert['Advertisement']['picture'] as $picture) {
                             echo ($count % 3 == 2) ? '<li class="resetmargin" style="margin:0px;">' : '<li>';
                      
                            echo '<div class="relative">';
                                echo $this->Html->image($picture['thumb'], array('alt' => $picture['label'], 'border' => '0', 'width'=>'300', 'height'=>'225'));
                                echo '</br>';
                                echo '<div class="fiyatbox2 spritefiyat">
                                        <div class="fiyat">'.$advert["Advertisement"]["demand"].'<sup>'.$advert["Advertisement"]["currency"].'</sup></div>
                                     </div>    
                                <div class="advert-detay">';
                                if(strlen($advert['Advertisement']['title']['tur'])>32){
                                   echo '<h1>'.substr($advert['Advertisement']['title']['tur'],0,32).'..</h1>';
                                 }else{
                                   echo '<h1>'.$advert['Advertisement']['title']['tur'].'</h1>';
                                 }
                                 if(strlen($advert['Advertisement']['title']['address'])>55){
                                   echo '<h2>'.substr($advert["Advertisement"]["address"],0,55).'..</h2>';
                                  }else{
                                   echo '<h2>'.$advert["Advertisement"]["address"].'</h2>';   
                                  }
                                '</div>';
                            echo '</div></li>'; $count++; break;}
                        }?>
                </ul>
            </div>            


            <img src="img/serit2.png"  width="950" height="20" class="mt15 " />

            <div class="main-bottom-info">
                <img src="img/tatilevim-cok-yakinda.jpg"  width="628" height="187" alt="where to stay in safranbolu" class="fleft" style="margin-top:5px;"/>

                <div class="epostaliste-mailbirak fleft">
                    <div>
                        <input type="text" class="mail-input">
                            <a href="javascript:;" class="ekle-buton">EKLE</a>
                            <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>










            <!-- orta alan burda bitiyor-->  
        </div>

    

    <script type="text/javascript">
        $(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                animationLoop: true
            });
        });
    </script>

    <!--Social Buttons script-->        
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/it_IT/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <script>!function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
            if (!d.getElementById(id)) {
                js = d.createElement(s);
                js.id = id;
                js.src = p + '://platform.twitter.com/widgets.js';
                fjs.parentNode.insertBefore(js, fjs);
            }
        }(document, 'script', 'twitter-wjs');</script>
    <!---->
<?php
/*
foreach ($homePageAdverts as $advert) {


    foreach ($advert['Advertisement']['picture'] as $picture) {
        echo $this->Html->image($picture['path'], array('alt' => $picture['label'], 'border' => '0'));
        echo '</br>';
        echo $this->Html->image($picture['thumb'], array('alt' => $picture['label'], 'border' => '0'));
        echo '</br>';
        echo $this->Html->image($picture['scrool'], array('alt' => $picture['label'], 'border' => '0'));
        echo '</br>';
    }
}

pr($mainBanners);
pr($homePageAdverts);
pr($lastBooksAdverts);*/

?>