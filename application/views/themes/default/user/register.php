<section>
	<div class="container">
		<div class="row">
			<!-- Register -->
			<div class="col-lg-6">		
				<?php echo validation_errors('<div class="alert alert-dismissible alert-danger">', '</div>'); 
				echo form_open('user/register','class="form-horizontal jumbotron" data-toggle="validator"'); ?>
				<div class="col-lg-12">
					<h4><?php echo lang_key('register') ?></h4>
				</div>
				
				<!-- firstname -->
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" name="first_name" value="<?php echo set_value('first_name');?>" placeholder="<?php echo lang_key('first_name'); ?>" class="form-control" minlength="3" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				
				<!-- lastname -->
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" name="last_name" value="<?php echo set_value('last_name');?>" placeholder="<?php echo lang_key('last_name'); ?>" class="form-control" minlength="3" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				
				<!-- gender -->	
				<div class="form-group">
                    <div class="col-lg-12">
                        <?php $curr_value=(set_value('gender')!='')?set_value('gender'):$this->session->userdata('gender');?>
                        <select class="form-control" name="gender" required>
							<option value="" ><?php echo lang_key('choose_gender');?></option>
                            <?php $sel=($curr_value=='male')?'selected="selected"':'';?>
                            <option value="male" <?php echo $sel;?>><?php echo lang_key('male');?></option>
                            <?php $sel=($curr_value=='female')?'selected="selected"':'';?>
                            <option value="female" <?php echo $sel;?>><?php echo lang_key('female');?></option>
                        </select>
						<div class="help-block with-errors"></div>
					</div>
                </div>
				
				<!-- company name -->	
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" name="company_name" value="<?php echo set_value('company_name');?>" placeholder="<?php echo lang_key('company_name'); ?>" minlength="3" class="form-control">
						<div class="help-block with-errors"></div>
					</div>
				</div>
				
				<!-- phone no -->	
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" name="phone" value="<?php echo set_value('phone');?>" placeholder="<?php echo lang_key('phone'); ?>" minlength="7" class="form-control">
						<div class="help-block with-errors"></div>
					</div>
				</div>
				
				<!-- email -->	
				<div class="form-group">
					<div class="col-lg-12">
						<input type="email" name="useremail" value="<?php echo set_value('useremail');?>" placeholder="<?php echo lang_key('email'); ?>" class="form-control" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				
				<!-- username -->	
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" name="username" value="<?php echo set_value('username');?>" placeholder="<?php echo lang_key('username'); ?>" class="form-control" minlength="6" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				
				<!-- password -->	
				<div class="form-group">
					<div class="col-lg-12">
						<input id="inputPassword" type="password" name="password" placeholder="<?php echo lang_key('password'); ?>" class="form-control" minlength="6" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				
				<!-- retype password -->	
				<div class="form-group">
					<div class="col-lg-12">
						<input id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Whoops, Password and Confirm Password don't match" type="password" name="repassword" placeholder="<?php echo lang_key('retype_password'); ?>" class="form-control" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				
				
				<div class="form-group">
                        <div class="col-lg-12">
							<?php echo lang_key('agree_terms'); ?>
                            <!--<input type="hidden" name="terms_conditon" id="terms_conditon" value="<?php echo (isset($_POST['terms_conditon_field']))?$_POST['terms_conditon_field']:'';?>">

                            <!-- Checkbox -->
                            <!-- <div class="checkbox">
                                <label>
									
                                    <input type="checkbox" name="terms_conditon_field" id="terms_conditon_field" <?php echo (isset($_POST['terms_conditon_field']))?'checked':'';?>>
                                    <?php echo lang_key('ive_read_the'); ?> <a target="_blank" href="<?php echo site_url('show/page/terms_and_conditions');?>"><?php echo lang_key('terms_and_conditions'); ?></a>
                                </label>
                            </div>-->
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
				
				<!-- Submit Button -->
				<div class="form-group">
					<div class="col-lg-12">
						<input type="submit" class="btn btn-embossed btn-success btn-hg btn-block" value="<?php echo lang_key('register') ?>" />
					</div>
				</div>
				<?php echo form_close(); ?>		
			</div>
			
			
			
			
			<!-- Login -->
			<div class="col-lg-6">
				
				<?php echo form_open('login','class="form-horizontal jumbotron" data-toggle="validator"'); ?>
					
				<div class="col-lg-12">
					<h4><?php echo lang_key('login') ?></h4>
				</div>
					
				<!-- username -->	
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" name="useremail" placeholder="<?php echo lang_key('email'); ?>" class="form-control" required>
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
				<div class="col-lg-12">
					<input type="submit" class="btn btn-embossed btn-primary btn-hg btn-block" value="<?php echo lang_key('login') ?>" />
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

<script type="text/javascript">
jQuery(document).ready(function(e){
    jQuery('#terms_conditon_field').click(function(e){
        var val = jQuery(this).attr('checked');
        jQuery('#terms_conditon').val(val);

    });

});
</script>