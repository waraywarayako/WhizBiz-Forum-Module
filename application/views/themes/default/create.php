<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				
				<h3 align="center"><?php echo lang_key('create_new_topic'); ?></h1>
				<?php echo validation_errors('<div class="alert alert-dismissible alert-danger">', '</div>'); 
				echo form_open('create','method="post" class="form-horizontal jumbotron"'); ?>
				
				<input type="hidden" name="category" value="<?php echo set_value('category'); ?>">
				<input type="hidden" name="redir_slug" value="<?php echo set_value('redir_slug'); ?>">
				<input type="hidden" name="parent_cat" value="<?php echo set_value('parent_cat'); ?> ">
				<script>
					$(function() {
					$('#title').change(function() {
					var title = $('#title').val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
					$('#slug').val(title);
					});
					});
				</script>
				<!-- Title -->
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" name="title" id="title" class="form-control" placeholder="Threads Title" value="<?php echo set_value('title'); ?>"/>
					</div>
				</div>
				
				
				<!-- slug -->
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" name="slug" id="slug" class="form-control" placeholder="SEO Friendly URL" value="<?php echo set_value('slug'); ?>" maxlength="100"/>
						<small class="text-danger"><?php echo lang_key('slug_seo') ?></small>
					</div>
				</div>
				
				
				
				<!-- Text -->
				<div class="form-group">
					<div class="col-lg-12" align="center">
						<textarea type="textarea" name="text" id="text" class="form-control" rows="15" placeholder="<?php echo lang_key('threads_content'); ?>"><?php echo set_value('text'); ?></textarea>
					</div>
				</div>
				
				<!-- Tags -->
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" data-role="tagsinput" name="tags" id="tags" class="form-control" value="<?php echo set_value('tags'); ?>"/>
						<small class="text-danger"><?php echo lang_key('separate_by_commas') ?></small>
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
						<input type="submit" class="btn btn-embossed btn-primary btn-hg btn-block" value="<?php echo lang_key('create_thread') ?>" />
					</div>
				</div>
				<?php echo form_close(); ?>
			
				<div class="progress">
					<div class="progress-bar" style="width: 0%;"></div>
					<div class="progress-bar progress-bar-warning" style="width: 10%;"></div>
					<div class="progress-bar progress-bar-danger" style="width: 10%;"></div>
					<div class="progress-bar progress-bar-success" style="width: 10%;"></div>
					<div class="progress-bar progress-bar-info" style="width: 10%;"></div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Javascript -->
<script type="text/javascript">
CKEDITOR.replace( 'text' );	
</script>