				<?php echo $this->session->flashdata('msg');
				echo form_open('threads/saveeditreply','method="post" class="form-horizontal" id="saveEditTopicReply"'); ?>
				<input type="hidden" value="<?php echo $id  ?>" name="id">
				<span class="text-danger"><?php echo validation_errors();?></span>
				<!-- Text -->
				<div class="form-group">
					<div class="col-lg-12" align="center">
						<textarea type="textarea" id="comment" name="comment" class="form-control" rows="20" placeholder="Type your reply to the topic"><?php echo get_edit_reply_content_by_id($id);?></textarea>
					</div>
				</div>
		
				<!-- recaptcha -->
				<div class="form-group"> 
					<div class="col-lg-12">
						<!-- get yours: https://www.google.com/recaptcha/admin -->
						<div align="center" id="captchareply"></div>
					</div>
				</div>
			
				<!-- Button -->
				<div class="form-group">
					<div class="col-lg-12">
						<input type="submit" class="btn btn-embossed btn-primary btn-hg btn-block" value="<?php echo lang_key('save_edit_reply'); ?>" />
					</div>
				</div>
				<?php echo form_close(); ?>
<!-- Javascript -->
<script type="text/javascript">
CKEDITOR.replace('comment');
</script>

<script type="text/javascript">
	jQuery('#saveEditTopicReply').submit(function(event){
		CKEDITOR.instances.comment.updateElement();
		event.preventDefault();
		var loadUrl = jQuery(this).attr('action');
		jQuery("#editReplyTopic  .modal-body").html("Updating...");
		jQuery.post(
			loadUrl,
			jQuery(this).serialize(),
			function(responseText){
				jQuery("#editReplyTopic  .modal-body").html(responseText);
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
    grecaptcha.render("captchareply", {sitekey: "<?php echo get_settings('forum_settings','recaptcha_sitekey','No'); ?>", theme: "light"});
    }
</script>
<?php } ?>