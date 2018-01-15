<section>
	<div class="container">
		<div class="row">
			<!-- Register -->
			<div class="col-lg-6 jumbotron">		
				<p class="lead">Register now for <span class="text-success">FREE</span></p>
                <ul class="list-unstyled" style="line-height: 2">
                    <li><span class="fa fa-check text-success"></span> We are safe and encrypted</li>
                    <li><span class="fa fa-check text-success"></span> We do not share your personal information</li>
                    <li><span class="fa fa-check text-success"></span> Can create topic and discuss with other users</li>
                    <li><span class="fa fa-check text-success"></span> Can make friends and become travel buddies with fellow travelers</li>
                    <li><span class="fa fa-check text-success"></span> Can get free business ads feature listing <small>(only new verified listing)</small></li>
                </ul>
                      <p><a href="<?php echo base_url('register'); ?>" class="btn btn-info btn-block"><?php echo lang_key('yes_register'); ?></a></p>
					  <p><a href="<?php echo base_url('recover'); ?>" class="btn btn-warning btn-block"><?php echo lang_key('recover_acc'); ?></a></p>
			</div>
			
			
			
			
			<!-- Login -->
			<div class="col-lg-6">
				
				<?php echo validation_errors('<div class="alert alert-dismissible alert-danger">', '</div>'); 
				echo form_open('login','class="form-horizontal jumbotron" data-toggle="validator"'); ?>
					
				<div class="col-lg-12">
					<h4><?php echo lang_key('login') ?></h4>
				</div>
					
				<!-- username -->	
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" name="useremail" value="<?php echo set_value('useremail');?>" placeholder="<?php echo lang_key('email'); ?>" class="form-control" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				
				<!-- password -->	
				<div class="form-group">
					<div class="col-lg-12">
						<input type="password" name="password" placeholder="<?php echo lang_key('password'); ?>" class="form-control" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<!-- button -->	
				<div class="form-group">
					<div class="col-lg-12">
					<input type="submit" class="btn btn-embossed btn-primary btn-hg btn-block" value="<?php echo lang_key('login') ?>" />
					</div>
				</div>
				<!-- social login -->	
				<?php
                $fb_enabled = get_settings('business_settings','enable_fb_login','No');
                $gplus_enabled = get_settings('business_settings','enable_gplus_login','No');
                if($fb_enabled=='Yes' || $gplus_enabled=='Yes'){ ?>
				<div class="col-lg-12">
					<h4><?php echo lang_key('social_login') ?></h4>
						<?php if($fb_enabled=='Yes'){?>
						<a class="btn btn-block btn-social btn-facebook" href="<?php echo site_url('user/newaccount/fb');?>">
							<span class="fa fa-facebook"></span> <?php echo lang_key('fb_aut'); ?>
						</a>
						<?php }?>
						
						<?php if($gplus_enabled=='Yes'){?>
						<a class="btn btn-block btn-social btn-google" href="<?php echo site_url('user/newaccount/google_plus');?>">
							<span class="fa fa-google"></span> <?php echo lang_key('google_aut'); ?>
						</a>
						<?php }?>
				</div>
				<?php } ?>
				<?php echo form_close(); ?>	
			</div>
			
			
			
			
				<div class="progress">
                <div class="progress-bar" style="width: 0%;"></div>
                <div class="progress-bar progress-bar-warning" style="width: 10%;"></div>
                <div class="progress-bar progress-bar-danger" style="width: 10%;"></div>
                <div class="progress-bar progress-bar-success" style="width: 10%;"></div>
                <div class="progress-bar progress-bar-info" style="width: 10%;"></div>
				</div>	
		</div>
	</div>
</section>