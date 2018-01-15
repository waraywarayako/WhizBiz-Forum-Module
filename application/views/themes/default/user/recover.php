<section>
	<div class="container">
		<div class="row">
			<!-- Recover -->
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
					  <p><a href="<?php echo base_url('resend'); ?>" class="btn btn-warning btn-block"><?php echo lang_key('resend_confirmation'); ?></a></p>
			</div>
			
			
			
			
			<!-- Login -->
			<div class="col-lg-6">
				
				<?php  echo validation_errors('<div class="alert alert-dismissible alert-danger">', '</div>'); 
				echo form_open('recover','class="form-horizontal jumbotron" data-toggle="validator"'); ?>
					
				<div class="col-lg-12">
					<h4><?php echo lang_key('recover') ?></h4>
				</div>
					
				<!-- useremail -->	
				<div class="form-group">
					<div class="col-lg-12">
						<input type="email" name="useremail" value="<?php echo set_value('useremail');?>" placeholder="<?php echo lang_key('email'); ?>" class="form-control" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				
				<?php
				if(get_settings('forum_settings','enable_recaptcha_validation','')!='No'){ ?>				
				<!-- recaptcha -->
				<div class="form-group"> 
					<div class="col-lg-12">
						<!-- get yours: https://www.google.com/recaptcha/admin -->
						<div align="center" class="g-recaptcha" data-sitekey="<?php echo get_settings('forum_settings','recaptcha_sitekey','No'); ?>"></div>
					</div>
				</div>
				<?php } ?>
				
				<!-- button -->	
				<div class="col-lg-12">
					<input type="submit" class="btn btn-embossed btn-primary btn-hg btn-block" value="<?php echo lang_key('recover') ?>" />
				</div>
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