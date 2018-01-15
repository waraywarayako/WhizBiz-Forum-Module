				<?php echo $this->session->flashdata('msg');
				echo form_open('threads/saveeditpost','method="post" class="form-horizontal" id="saveEditTopicPost"'); ?>
				<input type="hidden" value="<?php echo $id  ?>" name="id">
				<span class="text-danger"><?php echo validation_errors();?></span>
				<!-- Text -->
				<div class="form-group">
					<div class="col-lg-12" align="center">
						<textarea type="textarea" id="post" name="post" class="form-control" rows="20"><?php echo get_edit_topic_content_by_id($id);?></textarea>
					</div>
				</div>
				
				<!-- Tags -->
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" data-role="tagsinput" name="tags" id="tags" class="form-control" value="<?php 
						if(empty(get_edit_topic_tags_by_id($id))){
							echo set_value('tags');
						}else{
							echo get_edit_topic_tags_by_id($id);	
						} ?>"/>
						<small class="text-danger"><?php echo lang_key('separate_by_commas') ?></small>
					</div>
				</div>
				
								
				<!-- recaptcha -->
				<div class="form-group"> 
					<div class="col-lg-12">
						<!-- get yours: https://www.google.com/recaptcha/admin -->
						<div align="center" id="captcha"></div>
					</div>
				</div>
			
				<!-- Button -->
				<div class="form-group">
					<div class="col-lg-12">
						<button type="submit"  class="btn btn-embossed btn-primary btn-hg btn-block" ><?php echo lang_key('save_edit_threads'); ?></button>
					</div>
				</div>
				<?php echo form_close(); ?>
<!-- Javascript -->
<script type="text/javascript">
CKEDITOR.replace('post');
</script>
<script type="text/javascript">
	jQuery('#saveEditTopicPost').submit(function(event){
		CKEDITOR.instances.post.updateElement();
		event.preventDefault();
		var loadUrl = jQuery(this).attr('action');
		jQuery("#editPostTopic  .modal-body").html("Updating...");
		jQuery.post(
			loadUrl,
			jQuery(this).serialize(),
			function(responseText){
				jQuery("#editPostTopic  .modal-body").html(responseText);
			},
			"html"
		);

	});
</script>	
<?php
if(get_settings('forum_settings','enable_recaptcha_validation','')!='No'){ ?>	
<script>
    createRecaptcha();
    function createRecaptcha() {
    grecaptcha.render("captcha", {sitekey: "<?php echo get_settings('forum_settings','recaptcha_sitekey','No'); ?>", theme: "light"});
    }
</script>
<?php } ?>
<script src="<?php echo base_url();?>/assets/tagsinput/bootstrap-tagsinput.min.js"></script>