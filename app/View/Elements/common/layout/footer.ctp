
    <div id="footer">
        <div id="bottom-area">
            <div class="bottom-bar">
                <div class="bottom-line">
                    <div class="bottom-line-center">
                        <div class="fleft" style="width:300px;">
                            <input type="text" class="mail-input2 fleft" />
                            <a href="javascript:;" class="ekle-buton2 fleft">EKLE</a>
                            <div class="clear"></div>
                        </div>
                        <div class="bottom-social fright">
                            <ul>
                                <li><a href="" target="_blank" title="facebook" class="facebook-buton sprite"></a></li>
                                <li><a href="" target="_blank" title="twitter" class="twitter-buton sprite"></a></li>
                                <li><a href="" target="_blank" title="google" class="google-buton sprite"></a></li>
                                <li><fb:like href="http://www.tatilevim.com" send="false" layout="button_count" width="400" show_faces="false"></fb:like></li>
                                <li><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.tatilevim.com" data-lang="tr" >Tweet</a></li>
                            </ul>
                        </div>
                        <div class="clear"></div>    
                    </div>

                </div>



                <div class="footer-bottom">
                    <div class="footer-bottom-center">
                        <div class="uye-kuruluslar fleft">
                            <h1 class="">ÜYE KURULUŞLARIMIZ</h1>
                            
                            <div class="logos"><?php
                                echo 
                                        $this->Html->image('uye-kuruluslar.jpg')
                                ?> </div>
                        </div>

                        <div class="footer-links fleft">  
                            <div class="kurumsal fleft">
                                <h1 class=""><?php echo __('footer_institutional'); ?></h1>
                                <ul>
                                    <li><?php echo $this->Html->link(__('footer_about_us'),array('controller'=>'pages', 'action' => 'display','aboutUs'), array('escape' => false)); ?></li>
                                    <li><?php echo $this->Html->link(__('footer_contact'),array('controller'=>'contacts', 'action' => 'index'), array('escape' => false)); ?></li>
                                    <li><?php echo $this->Html->link(__('footer_grs'),array('controller'=>'pages', 'action' => 'display','grs'), array('escape' => false)); ?></li>
                                    <li><?php echo $this->Html->link(__('footer_offers'),array('controller'=>'offers', 'action' => 'index'), array('escape' => false)); ?></li>
                                </ul>
                            </div>

                            <div class="gizlilik fleft">
                                <h1 class=""><?php echo __('footer_privacy'); ?></h1>
                                <ul>
                                    <li><?php echo $this->Html->link(__('footer_booking_terms'),array('controller'=>'pages', 'action' => 'display','cancellationPolicy'), array('escape' => false)); ?></li>
                                    <li><?php echo $this->Html->link(__('footer_user_agreement'),array('controller'=>'pages', 'action' => 'display','membershipAgreement'), array('escape' => false)); ?></li>
                                    <li><?php echo $this->Html->link(__('footer_faq'),array('controller'=>'pages', 'action' => 'display','sss'), array('escape' => false)); ?></li>

                                </ul>
                            </div>
                            <div class="clear"></div>

                        </div> 
                        <div class="clear"></div>

                    </div>
                </div>

            </div>        

            <div class="copyright">
                <div class="copyright-text fleft"><?php echo __('footer_copyright'); ?></div>
                <div class="cards fleft">
                    <a href="" class="payu fleft sprite"></a>
                    <a href="" class="visa fleft sprite"></a>
                    <a href="" class="master fleft sprite"></a>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>


        </div>

    </div>

</div>
