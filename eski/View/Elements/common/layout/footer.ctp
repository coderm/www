
<!--FOOTER START-->
	    <div id="footer" class="footer-container">
		<div class="container" style="margin-top:20px">
		    <div class="row">
			<div class="span3">
			    <h5><?php echo __('footer_institutional'); ?></h5>
			    <ul class="nav">
				<li><?php echo $this->Html->link(__('footer_about_us'),array('controller'=>'pages', 'action' => 'display','aboutUs'), array('escape' => false)); ?></li>
				<li><?php echo $this->Html->link(__('footer_contact'),array('controller'=>'contacts', 'action' => 'index'), array('escape' => false)); ?></li>
			    </ul>

			</div>
			<div class="span3">
			    <h5><?php echo __('footer_services'); ?></h5>
			    <ul class="nav">
				<li><?php echo $this->Html->link(__('footer_grs'),array('controller'=>'pages', 'action' => 'display','grs'), array('escape' => false)); ?></li>
				<li><?php echo $this->Html->link(__('footer_offers'),array('controller'=>'offers', 'action' => 'index'), array('escape' => false)); ?></li>
			    </ul>
			</div>
			<div class="span3">
			    <h5><?php echo __('footer_privacy'); ?></h5>
			    <ul class="nav">
			    <li><?php echo $this->Html->link(__('footer_booking_terms'),array('controller'=>'pages', 'action' => 'display','cancellationPolicy'), array('escape' => false)); ?></li>
			    <li><?php echo $this->Html->link(__('footer_user_agreement'),array('controller'=>'pages', 'action' => 'display','membershipAgreement'), array('escape' => false)); ?></li>
			    <li><?php echo $this->Html->link(__('footer_faq'),array('controller'=>'pages', 'action' => 'display','sss'), array('escape' => false)); ?></li>
			    </ul>		
			</div>




			 <div class="span3">
			     	<div>
				       <div class="fb-like pull-right" data-href="http://www.tatilevim.com" data-send="true" data-layout="button_count" data-width="200" data-show-faces="false" data-font="arial"></div>
				</div>
				<div class="clear" style="text-align: right;">
				     <?php
					echo $this->Html->link(
						    $this->Html->image('rssIcon.png', array('alt'=> 'RSS', 'border' => '0')),
						    'http://feeds.feedburner.com/tatilevim?format=xml',
						    array('target' => '_blank', 'escape' => false,'style' => 'clear:none;padding:0;')
					    );                           
					echo $this->Html->link(
						    $this->Html->image('facebookIcon.png', array('alt'=> 'facebook', 'border' => '0')),
						    'http://www.facebook.com/TatilEvim',
						    array('target' => '_blank', 'escape' => false,'style' => 'clear:none;padding:0;')
					    );                                 
					echo $this->Html->link(
						    $this->Html->image('twitterIcon.png', array('alt'=> 'twitter', 'border' => '0')),
						    'http://www.twitter.com/Tatilevim',
						    array('target' => '_blank', 'escape' => false,'style' => 'clear:none;padding:0;')
					    );       

				     ?>
				    </div>                       
			</div>
		    </div>
		    
		    <div class="clear info" style="border-bottom:1px solid #3d98cc;">
			<small><?php echo __('footer_company_title'); ?></small>
			<small class="pull-right"><?php echo __('footer_copyright'); ?></small>
		    </div>
		    
		    <div class="info" style="text-align: center;">
			<small style="font-size:10px;"><?php echo __('footer_legal_disclaimer'); ?></small>
		    </div>

	
		    
		</div>	
	     </div>
<!-- Footer end -->	 

