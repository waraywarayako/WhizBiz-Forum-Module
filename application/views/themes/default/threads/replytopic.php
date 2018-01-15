	<form id="replytopic-form" method="post" action="<?php echo base_url('threads/reply_topic');?>" role="form">
		<input type="hidden" value="<?php echo $topic_id; ?>" name="topic_id">
		<input type="hidden" value="<?php echo get_cat_topic_by_id($topic_id); ?>" name="cat_id">
		<input type="hidden" value="<?php echo  get_parent_cat_topic_by_id($topic_id); ?>" name="parent_id">
		<span class="text-danger"><?php echo validation_errors();?></span>
		<!-- Text -->
		<div class="form-group">
			<div class="col-lg-12" align="center">
				<textarea type="textarea" id="comment" name="comment" class="form-control" rows="15" placeholder="Type your threads content"><?php echo set_value('comment');?></textarea>
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
		
		<!-- Button -->
		<div class="form-group">
			<div class="col-lg-12">
				<input type="submit" class="btn btn-embossed btn-primary btn-hg btn-block" value="<?php echo lang_key('reply_post'); ?>" />
			</div>
		</div>
		
    </form>
<!-- Javascript -->
<script type="text/javascript">
CKEDITOR.replace( 'comment' );
</script>
<!-- Recaptcha V2 Js -->
<script src="https://www.google.com/recaptcha/api.js"></script>