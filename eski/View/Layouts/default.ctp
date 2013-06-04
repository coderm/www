<?php $cakeDescription = __d('cake_dev', 'Tatil Evim'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset()."\n"; ?>
	<title><?php echo $title_for_layout .' | '. $cakeDescription; ?></title>
	<?php
        if(!isset($description_for_layout))
            $description_for_layout = 'Kiralık Yazlıklar';
        echo $this->Html->meta('icon')."\n";
        echo $this->Html->meta('description',$description_for_layout)."\n";
        ?>
        <meta name="keywords" content="kiralık yazlık, kiralık yazlıklar, antalya, alanya, bodrum, datça, didim, fethiye, kaş, kuşadası, marmaris">
        <meta name="googlebot" content="index, follow" />
        <meta name="robots" content="all" />
        <meta name="robots" content="index, follow" />
        <meta name="revisit-after" content="1 days" />        
        <meta property="fb:app_id" content="165333916903567" />
        <meta property="og:title" content="Tatil Evim" />
        <meta property="og:image" content="http://tatilevim.com/img/tatilevimFB.png"/>
        <meta property="og:site_name" content="Tatil Evim" />
        <meta property="og:description" content='www.tatilevim.com "tatilin ev adresi"' />
        <?php
            if(isset($metasForLayout))
            {
                foreach($metasForLayout as $meta)
                {
                    echo $meta;
                }
            }
        ?>
        <?php
	echo $this->Html->css('bootstrap.min')."\n";
	echo $this->Html->css('site-1.0')."\n";
	?>
        <!--[if IE 9]>
        <style type="text/css">
            .rounded5
            {
                behavior: none;
            }
            .rounded10
            {
                behavior: none;
            }            
        </style>
        <![endif]-->   
            
            <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-28781930-1']);
            _gaq.push(['_setDomainName', 'tatilevim.com']);
            _gaq.push(['_trackPageview']);

            (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

            </script>       

            
            <!-- Start Alexa Certify Javascript -->
            <script type="text/javascript" src="https://d31qbv1cthcecs.cloudfront.net/atrk.js"></script><script type="text/javascript">_atrk_opts = { atrk_acct: "c/zmf1a0CM008f", domain:"tatilevim.com"}; atrk ();</script><noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=c/zmf1a0CM008f" style="display:none" height="1" width="1" alt="" /></noscript>
            <!-- End Alexa Certify Javascript -->                
        
</head>
<body>
    

        
	<?php 
	    echo $this->Element('/menu/top');
	?>
        
        <!--CONTAINER START-->
	<div id="wrap">
	<div class="container">
                <!--HEADER START-->
		<div id="header" <?php if($this->params->params['controller']=='pages') echo 'style="border:0;"'; ?> >
                        <?php
                        echo $this->Html->link(
                        $this->Html->image('logo.png', array('alt'=> 'www.tatilevim.com', 'border' => '0','style'=>'margin-top:14px;')),
                        '/',
                        array('target' => '_self', 'escape' => false)
                        );
                        ?>                    

 
				    
			<div class="input-append" id="quickSearch">
			    <?php echo $this->element('/common/layout/quick_search');?>
			</div>
						    
                        
                        <div style="position: absolute;right:0;bottom:7px;height: 36px;">
                            <?php 
                                echo $this->Html->link(
                                            $this->Html->image('callNumber.png', array('alt'=> 'Müşteri Hizmetleri', 'border' => '0','style'=>'vertical-align:middle;padding-top:12px;')),
                                            array('controller'=>'contacts', 'action' => 'index'),
                                            array('target' => '_self', 'escape' => false)
                                    );
				
                                echo $this->Html->link(
                                                __('btn_label_common_add_a_place'),
                                                array('controller'=>'advertisements', 'action' => 'add'),
                                                array('target' => '_self', 'escape' => false,'class'=>'btn btn-custom-yellow btn-custom-large','style'=>'margin-left:0px;margin-right:0px;')
                                        );                    
                            ?>

                    </div>
		</div>
                <!--HEADER END-->
                <!--BREADCRUMP START-->
                <?php
                    if(!isset($showBreadCrumb))
                        $showBreadCrumb = true;
                    
                    if($showBreadCrumb)
                    {
                        echo '<div id="breadCrump">';
                        echo $this->Html->getCrumbs(' > ', 'Anasayfa');
                        echo '</div>';
                    }
                ?>
                <!--BREADCRUMP END-->
                <!--CONTENT START-->
                <div id="content">
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $content_for_layout; ?>
                        <div style="clear:both;position: relative;float:left;width:100%;">&nbsp;</div>
                </div>
                <!--CONTENT END-->
                <!--FOOTER START-->


                

                
            <!-- Live Help Start -->
            <div style="position:fixed;right:10px;bottom:10px;z-index: 25000;">
                <!--
                <iframe src="http://www.google.com/talk/service/badge/Show?tk=z01q6amlqbau1qpm1dfr0j2m7ekr559uoju47h0hvhodfa4ajv4fn3too0ttjpui83db7vuq6sn77i4sns4b6daodfet1b5dtn5mmhvkicr9kjf9s2g5gd1f8uoi6h1cal9benk3q4ta42ij8i0b464lrumsn7m5fuei44ehl&amp;w=200&amp;h=60" frameborder="0" allowtransparency="true" width="200" height="60"></iframe>    
                -->
                <!-- webim button --><a href="http://ls.tatilevim.com/webim/client.php?locale=tr&amp;style=simplicity" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('http://ls.tatilevim.com/webim/client.php?locale=tr&amp;style=simplicity&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="http://ls.tatilevim.com/webim/b.php?i=mblue&amp;lang=tr" border="0" width="177" height="61" alt=""/></a><!-- / webim button -->                
             </div> 
            <!-- Live Help End-->                
	</div>
	<div id="push"></div>	    
	</div>
        <!--CONTAINER END-->
	<?php
	    echo $this->Element('/common/layout/footer');
	?>
        <!-- Light Box Start -->
        <?php
            if(isset($isFollowUsViewed))
            {
                if(!$isFollowUsViewed)
                    echo $this->LightBox->followUs();
            }
        ?>
        <!-- Light Box End -->

       
	<!-- scripts_for_layout -->
	<?php echo $this->Html->script(array('jquery','jquery-ui-1.9.2.custom.min'));?>
        <?php echo $this->Html->script(array('http://www.google.com/jsapi'));?>
        <?php echo $this->Html->script(array('bootstrap.min', 'site-1.3', 'jquery.printPage'));?>
	<?php echo $scripts_for_layout; ?>
	
        
        <?php if(isset($showOffset)): ?>
        <script>
            $(document).ready(function(){
                $(window).scrollTop($('#<?php echo $showOffset; ?>').offset().top-100);
            });
            
        </script>
        <?php endif; ?>
        
        <script type="text/javascript">
            $(document).ready(function() {
            var xmlhttp;
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }

            document.cookie="tatilevimcookie";
            var cookieEnabled = (document.cookie.indexOf("tatilevimcookie")!=-1);
            var url = "http://stat.tatilevim.com/track.php?cookie=" + cookieEnabled  + "&action=norm&referer=" + escape(document.referrer);

            $("#trackImage").attr('src',url);
            }); 
        </script>

        <!--[if IE]>
        <script type="text/javascript">
        $(function() {
                var zIndexNumber = 10000;
                $("div").each(function() {
                        if($(this).css("zIndex")=="auto")
                        {                       
                            $(this).css("zIndex", zIndexNumber);
                            zIndexNumber -= 10;
                        }
                });
        });
        </script> 
        <![endif]-->     
        <!-- Js writeBuffer -->
        
	<?php
	if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer();
	?>
<img id="trackImage" width="0" height="0"/>


<?php
	    echo $this->Element('/tools/translate/tool');
?>

</body>
</html>