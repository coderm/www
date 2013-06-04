
    <div id="mainBanners" class="large">
        <div id="mainBannersContainer"></div>
        <div class="buttons"></div>
    </div>

<?php
            $this->Js->buffer(
            '
                $mainBannerImages = new Array("denizlere_indik.jpg","otellere_en_iyi_alternatif.jpg","butun_aile_tatilde.jpg","2013_erken_reza_2.jpg","turkiyenin_her_yerinde.jpg","tabela.jpg","istanbul.jpg","aquamarine.jpg");
                $mainBannerURLs = new Array(
					    "#",
					    "#",
					    "#",
					    "#",
					    "#",
                                            "/gunluk-kiraliklar",
                                            "/gunluk-kiralik-evler/istanbul",
                                            "/gunluk-kiralik-yazliklar/aydin/didim/yenihisar-efeler/ekonomik/1261/aqua-marina-sitesinde-sahane-2-1"
                                            );
                var $bannerInterval = "";
                var $currentBannerIndex = 0;
                function initBanners()
                {
                    for(i=1;i<$mainBannerImages.length;i++)
                    {
                        $("#mainBannersContainer").prepend("<img src=\'/img/banner/mainLarge/"+$mainBannerImages[i]+"\'/>");
                        $mainBannerImages[i] = $("#mainBannersContainer").children()[0];
                    }
                    for(i=0;i<$mainBannerImages.length;i++)
                    {
                        $("#mainBanners .buttons").prepend("<span class=\'button\'></span>");
                        $("#mainBanners .buttons .button:first").attr("index",$mainBannerImages.length-i-1);
                    }
                    bannerIndex(0);
                    startTimer();
                }
                function startTimer()
                {
                    $bannerInterval=window.setInterval("nextBanner()",15000);
                };

                function nextBanner()
                {
                    $currentBannerIndex++;
                    if($currentBannerIndex==$mainBannerImages.length)
                        $currentBannerIndex = 0;
                        
                    bannerIndex($currentBannerIndex);
                };
                
                function bannerIndex(index)
                {
                    for(i=0;i<$mainBannerImages.length;i++)
                    {
                        $banner = $mainBannerImages[i];
                        $($banner).stop(false,true);
                    }                

                    $currentBannerIndex = index;
                        
                    for(i=0;i<$mainBannerImages.length;i++)
                    {
                        $banner = $mainBannerImages[i];
                        if(i==$currentBannerIndex)
                            $($banner).fadeIn(500);
                        else
                            $($banner).fadeOut(500);
                    }
                    setSelected()
                    $bannerInterval = window.clearInterval($bannerInterval);
                    startTimer();
                }
                
                function setSelected()
                {
                    for(i=0;i<$mainBannerImages.length;i++)
                    {
                        if(i==$currentBannerIndex)
                            $($("#mainBanners .buttons .button")[i]).addClass("selected");
                        else
                            $($("#mainBanners .buttons .button")[i]).removeClass("selected");
                    }                
                }
                
                $("#mainBannersContainer").prepend("<img src=\'/img/banner/mainLarge/"+$mainBannerImages[0]+"\'/>");
                $mainBannerImages[0] = $("#mainBannersContainer").children()[0];
                $(window).load(function ()
                {
                    initBanners();
                });
            '
            );
            $this->Js->get('#mainBanners .buttons')->event('click', 
            '
                 if($(event.target).hasClass("selected"))
                    return;
                 bannerIndex($(event.target).attr("index"));
            '
            );
            $this->Js->get('#mainBannersContainer')->event('click', 
            '
                 window.location.href = $mainBannerURLs[$currentBannerIndex];
            '
            );            
?>
