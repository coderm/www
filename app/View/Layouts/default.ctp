<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$cakeDescription = __d('www.tatilevim.com', 'Mutlu Tatilin Ev Adresi');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset() . "\n"; ?>
    <title><?php echo $title_for_layout . ' | ' . $cakeDescription; ?></title>
    <?php
    if (!isset($description_for_layout))
        $description_for_layout = 'Kiralık Yazlıklar';
    echo $this->Html->meta('icon') . "\n";
    echo $this->Html->meta('description', $description_for_layout) . "\n";
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
    if (isset($metasForLayout)) {
        foreach ($metasForLayout as $meta) {
            echo $meta;
        }
    }
    ?>
    <?php
    echo $this->Html->meta('icon');
    //  echo $this->Html->css(array('style','flexslider','cake.generic'));
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    echo $this->Html->css('flexslider')."\n";
    echo $this->Html->css('style')."\n";
    echo $this->Html->script('jquery-1.10.1.min.js')."\n";
    echo $this->Html->script('jquery.flexslider-min.js')."\n";
    echo $this->Html->script('jquery-accordion.js')."\n";
    echo $this->Html->script('jquery.easytabs.min.js')."\n";
    echo $this->Html->css('flexslider')."\n";
    echo $this->Html->css('bootstrap.min') . "\n";
    echo $this->Html->css('site-1.0') . "\n";
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
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();

    </script>       


    <!-- Start Alexa Certify Javascript -->
    <script type="text/javascript" src="https://d31qbv1cthcecs.cloudfront.net/atrk.js"></script><script type="text/javascript">_atrk_opts = {atrk_acct: "c/zmf1a0CM008f", domain: "tatilevim.com"};
        atrk();</script><noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=c/zmf1a0CM008f" style="display:none" height="1" width="1" alt="" /></noscript>
    <!-- End Alexa Certify Javascript -->                

</head>

<body>
<div id="container">
    <div id="toparea">
        <div class="header" <?php if ($this->params->params['controller'] == 'pages') ; ?> >
            <?php
            echo $this->Html->link(
                    $this->Html->image('tatilevim-logo.jpg', array('alt' => 'www.tatilevim.com', 'border' => '0', 'style' => 'margin-top:14px;')), '/', array('target' => '_self', 'escape' => false)
            );
            ?>  
            <a href="/login" class="loginlink">Kullanıcı Girişi</a>
            <div class="ilanno-ara">
                <form method="post" action="">
                    <input type="text" name="search-words" value="İlan No İle Arama" />
                    <input type="submit" name="submit" class="buton"/>
                    <div class="clear"></div>
                </form>
            </div>
            <?php
            echo $this->Html->link(
                    $this->Html->image('ucretsiz-ilan-ver.jpg', array('alt' => 'Ücretsiz İlan Ver', 'border' => '0', 'class' => 'ucretsiz-ilan-ver')), '/ucretsiz-ilan-ver', array('target' => '_self', 'escape' => false)
            );
            ?>  
        </div>


        <div class="top-bar">
            <div class="search-bar">
                <form method="post" action="" name="toparea-search-form">
                    <div class="nereye radius"><input type="text" value="Nereye gitmek istiyorsunuz?" name="nereye" class="input-nereye"/><span class="sprite nereyeimg"></span></div>
                    <div class="tarih1 radius"><input type="text" value="Başlangıç tarihi" name="nereye" class="input-tarih1"/><span class="sprite tarih1img"></span></div>
                    <div class="tarih2 radius"><input type="text" value="Bitiş tarihi" name="nereye" class="input-tarih2"/><span class="sprite tarih2img"></span></div>
                    <div class="kisi-sayisi radius"><input type="text" value="Kişi sayısı" name="nereye" class="input-kisi-sayisi"/><span class="sprite kisi-sayisisiimg"></span></div>
                    <div class="ara"><input type="submit" class="sprite buton"/></div>
                    <div class="clear"></div>
                </form>
            </div>

        </div>
    </div>
 

        <?php echo $this->Session->flash(); ?>
 

        <?php echo $this->fetch('content'); ?>
  
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

</div>

</body>
</html>
