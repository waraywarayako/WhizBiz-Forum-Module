<section>
	<div class="container">
		<div class="row">
			<!-- Recover -->
			<div class="col-lg-6 jumbotron">
				<div class="row">
					<div class="col-md-12">			
						<div class="error-icon">
							<img class="img-thumbnail" id="user_photo" src="<?php echo get_profile_photo_by_id($account['id'],'thumb');?>" alt="<?php echo get_user_fullname_from_username($account['user_name']);?>" height="150" width="150"/>
						</div>
					</div>
				</div>
				<?php  echo validation_errors('<div class="alert alert-dismissible alert-danger">', '</div>'); 
				echo form_open('edit/'.$account['user_name'],'class="form-horizontal" data-toggle="validator"'); ?>
				<input type="hidden" name="id" value="<?php echo $account['id']; ?>"/>
				<!-- usernmae -->	
				<div class="form-group">
					<div class="col-lg-12">
						<label class="control-label"><?php echo lang_key('username'); ?></label>	
						<input type="text" name="username" value="<?php echo $account['user_name'];?>" placeholder="<?php echo lang_key('username'); ?>" class="form-control" disabled>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<!-- email -->	
				<div class="form-group">
					<div class="col-lg-12">
						<label class="control-label"><?php echo lang_key('email'); ?></label>	
						<?php $v = get_user_meta($account['id'], 'hide_email',0);?>
                        <label class="checkbox"><input type="checkbox" name="hide_email" id="hide_email" value="1" <?php echo $v==1?'checked="checked"':'';?>></label>
						<small class="text-danger"><?php echo lang_key('check_to_hide') ?></small>
						<input type="email" name="useremail" value="<?php echo $account['user_email'];?>" placeholder="<?php echo lang_key('email'); ?>" class="form-control" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<!-- firstname -->	
				<div class="form-group">
					<div class="col-lg-12">
						<label class="control-label"><?php echo lang_key('first_name'); ?></label>
						<input type="text" name="first_name" value="<?php echo $account['first_name'];?>" placeholder="<?php echo lang_key('first_name'); ?>" class="form-control" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<!-- lastname -->	
				<div class="form-group">
					<div class="col-lg-12">
						<label class="control-label"><?php echo lang_key('last_name'); ?></label>
						<input type="text" name="last_name" value="<?php echo $account['last_name'];?>" placeholder="<?php echo lang_key('last_name'); ?>" class="form-control" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<!-- gender -->	
				<div class="form-group">
                    <div class="col-lg-12">
						<label class="control-label"><?php echo lang_key('gender'); ?></label>
                        <?php $curr_value=(set_value('gender')!='')?set_value('gender'):$account['gender'];?>
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
				<!-- password -->	
				<div class="form-group">
					<div class="col-lg-12">
						<label class="control-label"><?php echo lang_key('password'); ?></label>
						<input id="inputPassword" type="password" name="password" placeholder="<?php echo lang_key('password'); ?>" class="form-control" minlength="6">
						<div class="help-block with-errors"></div>
						<small class="text-danger"><?php echo lang_key('leave_it_blank') ?></small>
					</div>
				</div>
				<!-- retype password -->	
				<div class="form-group">
					<div class="col-lg-12">
						<label class="control-label"><?php echo lang_key('retype_password'); ?></label>
						<input id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Whoops, Password and Confirm Password don't match" type="password" name="repassword" placeholder="<?php echo lang_key('retype_password'); ?>" class="form-control">
						<div class="help-block with-errors"></div>
						<small class="text-danger"><?php echo lang_key('leave_it_blank') ?></small>
					</div>
				</div>
			</div>
			
			
			
			
			<!-- Login -->
			<div class="col-lg-6 jumbotron">
					
				<!-- phone -->	
				<div class="form-group">
					<div class="col-lg-12">
						<label class="control-label"><?php echo lang_key('phone'); ?></label>	
						<?php $v = get_user_meta($account['id'], 'hide_phone',0);?> 
                        <label class="checkbox"><input type="checkbox" name="hide_phone" id="hide_phone" value="1" <?php echo $v==1?'checked="checked"':'';?>></label>
						<small class="text-danger"><?php echo lang_key('check_to_hide') ?></small>
						<?php $v = (set_value('phone')) ? set_value('phone') : get_user_meta($account['id'], 'phone'); ?>
						<input type="text" name="phone" value="<?php echo $v;?>" placeholder="<?php echo lang_key('phone'); ?>" class="form-control">
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<!-- company -->	
				<div class="form-group">
					<div class="col-lg-12">
						<label class="control-label"><?php echo lang_key('company_name'); ?></label>
						<?php $v = (set_value('company_name')) ? set_value('company_name') : get_user_meta($account['id'], 'company_name'); ?>
						<input type="text" name="company_name" value="<?php echo $v;?>" placeholder="<?php echo lang_key('company_name'); ?>" class="form-control">
					</div>
				</div>
				<!-- about me -->	
				<div class="form-group">
					<div class="col-lg-12">
						<label class="control-label"><?php echo lang_key('about_me'); ?></label>
						<?php $v = (set_value('about_me')) ? set_value('about_me') : get_user_meta($account['id'], 'about_me'); ?>
						<textarea name="about_me" placeholder="<?php echo lang_key('about_me'); ?>" class="form-control"><?php echo $v; ?></textarea>
					</div>
				</div>
				<hr/>
				<!-- facebook -->	
				<div class="form-group">
					<div class="col-lg-12">
						<?php $v = (set_value('fb_profile')) ? set_value('fb_profile') : get_user_meta($account['id'], 'fb_profile'); ?>
						<input type="text" name="fb_profile" value="<?php echo $v;?>" placeholder="<?php echo lang_key('fb_profile'); ?>" class="form-control">
						<small class="text-danger"><?php echo lang_key('social_warning') ?></small>
					</div>
				</div>
				<!-- twitter -->	
				<div class="form-group">
					<div class="col-lg-12">
						<?php $v = (set_value('twitter_profile')) ? set_value('twitter_profile') : get_user_meta($account['id'], 'twitter_profile'); ?>
						<input type="text" name="twitter_profile" value="<?php echo $v;?>" placeholder="<?php echo lang_key('tw_profile'); ?>" class="form-control">
						<small class="text-danger"><?php echo lang_key('social_warning') ?></small>
					</div>
				</div>
				<!-- linkedin -->	
				<div class="form-group">
					<div class="col-lg-12">
						<?php $v = (set_value('li_profile')) ? set_value('li_profile') : get_user_meta($account['id'], 'li_profile'); ?>
						<input type="text" name="li_profile" value="<?php echo $v;?>" placeholder="<?php echo lang_key('link_profile'); ?>" class="form-control">
						<small class="text-danger"><?php echo lang_key('social_warning') ?></small>
					</div>
				</div>
				<!-- google + -->	
				<div class="form-group">
					<div class="col-lg-12">
						<?php $v = (set_value('gp_profile')) ? set_value('gp_profile') : get_user_meta($account['id'], 'gp_profile'); ?>
						<input type="text" name="gp_profile" value="<?php echo $v;?>" placeholder="<?php echo lang_key('google_profile'); ?>" class="form-control">
						<small class="text-danger"><?php echo lang_key('social_warning') ?></small>
					</div>
				</div>
				
				<!-- signature -->
				<div class="form-group">
					<div class="col-lg-12">
						<label class="control-label"><?php echo lang_key('signature'); ?></label>
						<?php $v = (set_value('signature')) ? set_value('signature') : get_user_meta($account['id'], 'signature'); ?>
						<textarea align="center" type="textarea" name="signature" id="signature" class="form-control" rows="10" placeholder="Type your threads content"><?php echo $v; ?></textarea>
					</div>
				</div>
				
				<!-- button -->	
				<div class="col-lg-12">
					<input type="submit" class="btn btn-embossed btn-primary btn-hg btn-block" value="<?php echo lang_key('update_profile') ?>" />
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
<!-- Javascript -->
<script type="text/javascript">
CKEDITOR.replace( 'signature' );
</script>