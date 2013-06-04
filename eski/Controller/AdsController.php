<?php
class AdsController extends AppController
{
    public $name = 'Ads';
    function index()
    {

    }
    
    function beforeFilter()
    {
        
    }
    
    function click($campaginId)
    {
        $url;
        switch ($campaginId)
        {
            case 'istanbula_bekleriz':
                $url = '/gunluk-kiralik-evler/istanbul';
                break;
            default:
                $url = '/';
                break;
    }
        $this->redirect($url);
    }
    
    function serve()
    {
        $this->layout = 'ad';
        
        
        $publisherId = $this->request->named['p'];
        $slotId = $this->request->named['s'];
        $refURL  = $this->request->named['r'];
        $width  = $this->request->named['w'];
        $height = $this->request->named['h'];
        $divId  = $this->request->named['d'];
        
        $this->set('publisherId', $publisherId);
        $this->set('slotId', $slotId);
        $this->set('refURL', $refURL);
        $this->set('width', $width);
        $this->set('height', $height);
        $this->set('divId', $divId);
        
        
        $addList = array();
        $addList['300_250']['summer-breeze-indirim-kampanyasi'] = "<div id=\"flashContent\"><object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"300\" height=\"250\" id=\"summerBreeze300.250\" align=\"middle\"><param name=\"movie\" value=\"http://www.tatilevim.com/ads/summerBreeze300.250.swf?v=2\" /><param name=\"quality\" value=\"high\" /><param name=\"bgcolor\" value=\"#ffffff\" /><param name=\"play\" value=\"true\" /><param name=\"loop\" value=\"true\" /><param name=\"wmode\" value=\"window\" /><param name=\"scale\" value=\"showall\" /><param name=\"menu\" value=\"true\" /><param name=\"devicefont\" value=\"false\" /><param name=\"salign\" value=\"\" /><param name=\"allowScriptAccess\" value=\"sameDomain\" /><!--[if !IE]>--><object type=\"application/x-shockwave-flash\" data=\"http://www.tatilevim.com/ads/summerBreeze300.250.swf?v=2\" width=\"300\" height=\"250\"><param name=\"movie\" value=\"http://www.tatilevim.com/ads/summerBreeze300.250.swf?v=2\" /><param name=\"quality\" value=\"high\" /><param name=\"bgcolor\" value=\"#ffffff\" /><param name=\"play\" value=\"true\" /><param name=\"loop\" value=\"true\" /><param name=\"wmode\" value=\"window\" /><param name=\"scale\" value=\"showall\" /><param name=\"menu\" value=\"true\" /><param name=\"devicefont\" value=\"false\" /><param name=\"salign\" value=\"\" /><param name=\"allowScriptAccess\" value=\"sameDomain\" /><!--<![endif]--><a href=\"http://www.adobe.com/go/getflash\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a><!--[if !IE]>--></object><!--<![endif]--></object></div>";                
        $addList['300_250']['dErken-rezervasyon'] =  "<a href=\"http://www.tatilevim.com/ads/click/p:".$publisherId."/r:".$refURL."/s:".$slotId."\" target=\"_blank\"><img src=\"http://www.tatilevim.com/ads/erken_rezervasyon_300_250.jpg\"/></a>";
        $addList['300_250']['istanbula-bekleriz'] = "<div id=\"flashContent\"><object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"300\" height=\"250\" id=\"istanbulaBekleriz300.250\" align=\"middle\"><param name=\"movie\" value=\"http://www.tatilevim.com/ads/istanbulaBekleriz300.250.swf\" /><param name=\"quality\" value=\"high\" /><param name=\"bgcolor\" value=\"#ffffff\" /><param name=\"play\" value=\"true\" /><param name=\"loop\" value=\"true\" /><param name=\"wmode\" value=\"window\" /><param name=\"scale\" value=\"showall\" /><param name=\"menu\" value=\"true\" /><param name=\"devicefont\" value=\"false\" /><param name=\"salign\" value=\"\" /><param name=\"allowScriptAccess\" value=\"sameDomain\" /><!--[if !IE]>--><object type=\"application/x-shockwave-flash\" data=\"http://www.tatilevim.com/ads/istanbulaBekleriz300.250.swf\" width=\"300\" height=\"250\"><param name=\"movie\" value=\"http://www.tatilevim.com/ads/istanbulaBekleriz300.250.swf\" /><param name=\"quality\" value=\"high\" /><param name=\"bgcolor\" value=\"#ffffff\" /><param name=\"play\" value=\"true\" /><param name=\"loop\" value=\"true\" /><param name=\"wmode\" value=\"window\" /><param name=\"scale\" value=\"showall\" /><param name=\"menu\" value=\"true\" /><param name=\"devicefont\" value=\"false\" /><param name=\"salign\" value=\"\" /><param name=\"allowScriptAccess\" value=\"sameDomain\" /><!--<![endif]--><a href=\"http://www.adobe.com/go/getflash\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a><!--[if !IE]>--></object><!--<![endif]--></object></div>";                
        
        
        switch($slotId)
        {
            case 'fi-125-125':
                    $result = "<div id=\"flashContent\"><object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"125\" height=\"125\" id=\"summerBreeze125.125\" align=\"middle\"><param name=\"movie\" value=\"http://www.tatilevim.com/ads/summerBreeze125.125.swf\" /><param name=\"quality\" value=\"high\" /><param name=\"bgcolor\" value=\"#ffffff\" /><param name=\"play\" value=\"true\" /><param name=\"loop\" value=\"true\" /><param name=\"wmode\" value=\"window\" /><param name=\"scale\" value=\"showall\" /><param name=\"menu\" value=\"true\" /><param name=\"devicefont\" value=\"false\" /><param name=\"salign\" value=\"\" /><param name=\"allowScriptAccess\" value=\"sameDomain\" /><!--[if !IE]>--><object type=\"application/x-shockwave-flash\" data=\"http://www.tatilevim.com/ads/summerBreeze125.125.swf\" width=\"125\" height=\"125\"><param name=\"movie\" value=\"http://www.tatilevim.com/ads/summerBreeze125.125.swf\" /><param name=\"quality\" value=\"high\" /><param name=\"bgcolor\" value=\"#ffffff\" /><param name=\"play\" value=\"true\" /><param name=\"loop\" value=\"true\" /><param name=\"wmode\" value=\"window\" /><param name=\"scale\" value=\"showall\" /><param name=\"menu\" value=\"true\" /><param name=\"devicefont\" value=\"false\" /><param name=\"salign\" value=\"\" /><param name=\"allowScriptAccess\" value=\"sameDomain\" /><!--<![endif]--><a href=\"http://www.adobe.com/go/getflash\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a><!--[if !IE]>--></object><!--<![endif]--></object></div>";                
                break;
            case 'fi-300-125':
                    $result = "<div id=\"flashContent\"><object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"125\" height=\"125\" id=\"summerBreeze125.125\" align=\"middle\"><param name=\"movie\" value=\"http://www.tatilevim.com/ads/summerBreeze125.125.swf\" /><param name=\"quality\" value=\"high\" /><param name=\"bgcolor\" value=\"#ffffff\" /><param name=\"play\" value=\"true\" /><param name=\"loop\" value=\"true\" /><param name=\"wmode\" value=\"window\" /><param name=\"scale\" value=\"showall\" /><param name=\"menu\" value=\"true\" /><param name=\"devicefont\" value=\"false\" /><param name=\"salign\" value=\"\" /><param name=\"allowScriptAccess\" value=\"sameDomain\" /><!--[if !IE]>--><object type=\"application/x-shockwave-flash\" data=\"http://www.tatilevim.com/ads/summerBreeze125.125.swf\" width=\"125\" height=\"125\"><param name=\"movie\" value=\"http://www.tatilevim.com/ads/summerBreeze125.125.swf\" /><param name=\"quality\" value=\"high\" /><param name=\"bgcolor\" value=\"#ffffff\" /><param name=\"play\" value=\"true\" /><param name=\"loop\" value=\"true\" /><param name=\"wmode\" value=\"window\" /><param name=\"scale\" value=\"showall\" /><param name=\"menu\" value=\"true\" /><param name=\"devicefont\" value=\"false\" /><param name=\"salign\" value=\"\" /><param name=\"allowScriptAccess\" value=\"sameDomain\" /><!--<![endif]--><a href=\"http://www.adobe.com/go/getflash\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a><!--[if !IE]>--></object><!--<![endif]--></object></div>";                
                break;   
            case 'fi-300-250':
                    $r = rand(1,2);
                    switch($r)
                    {
                        case 1:
                            $result = $addList['300_250']['dErken-rezervasyon'];
                            break;
                        case 2:
                            $result = $addList['300_250']['istanbula-bekleriz'];
                            break;
                    }
                 
                break;               
            case 'fi-120-60':
                    $result = "<a href=\"http://www.tatilevim.com/ads/click/p:".$publisherId."/r:".$refURL."/s:".$slotId."\" target=\"_blank\"><img src=\"http://www.tatilevim.com/ads/tatilevim_120_60.jpg\"/></a>";
                break;
        } 
        $this->set('result', $result);
    }
    
}
   
?>
