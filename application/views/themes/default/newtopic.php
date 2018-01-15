				<input type="hidden" name="catname" value="<?php echo $parent->catname; ?>">
				<input type="hidden" name="category" value="<?php echo $parent->id; ?>">
				<input type="hidden" name="redir_slug" value="<?php echo $parent->slug; ?>">
				<input type="hidden" name="parent_cat" value="<?php echo $parent->parent; ?> ">
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
						<input type="text" name="title" id="title" class="form-control" placeholder="<?php echo lang_key('threads_title'); ?>" value="<?php echo set_value('title'); ?>"/>
					</div>
				</div>
				
				
				<!-- slug -->
				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" name="slug" id="slug" class="form-control" placeholder="<?php echo lang_key('seo_url'); ?>" value="<?php echo set_value('slug'); ?>" maxlength="100"/>
						<small class="text-danger"><?php echo lang_key('slug_seo'); ?></small>
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
						<small class="text-danger"><?php echo lang_key('separate_by_commas'); ?></small>
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

<!-- Javascript -->
<script type="text/javascript">
CKEDITOR.replace('text');
</script>