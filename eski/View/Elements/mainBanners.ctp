
    <div id="mainBanners">
        <div class="frame"></div>
        <div class="buttons"></div>
    </div>

<?php
            $this->Js->buffer(
            '
                $mainBannerImages = new Array("grs.jpg", "erkenRezervasyon.jpg","banner3.jpg","banner1.jpg","banner2.jpg");
                $mainBannerURLs = new Array("/guvenli_rezervasyon_sistemi/","/gunluk-kiralik-yazlik/","/gunluk-kiralik-yazlik/","/gunluk-kiralik-yazlik/","/gunluk-kiralik-yazlik/");
                var $bannerInterval = "";
                var $currentBannerIndex = 0;
                function initBanners()
                {
                    for(i=1;i<$mainBannerImages.length;i++)
                    {
                        $("#mainBanners").prepend("<img src=\'/img/banner/main/"+$mainBannerImages[i]+"\'/>");
                        $mainBannerImages[i] = $("#mainBanners").children()[0];
                    }
                    for(i=0;i<$mainBannerImages.length;i++)
                    {
                        $("#mainBanners .buttons").prepend("<span class=\'button\'></span>");
                        $("#mainBanners .buttons .button:first").attr("index",$mainBannerImages.length-i-1);
                    }
                    setSelected();
                    startTimer();
                }
                function startTimer()
                {
                    $bannerInterval=window.setInterval("nextBanner()",10000);
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
                
                $("#mainBanners").prepend("<img src=\'/img/banner/main/"+$mainBannerImages[0]+"\'/>");
                $mainBannerImages[0] = $("#mainBanners").children()[0];
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
            $this->Js->get('#mainBanners .frame')->event('click', 
            '
                 window.location.href = $mainBannerURLs[$currentBannerIndex];
            '
            );            
?>
