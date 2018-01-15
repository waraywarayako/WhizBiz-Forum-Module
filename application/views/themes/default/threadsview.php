	<?php
	$CI = get_instance(); ?>
		<section>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-9">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
									<?php
									foreach ($item->result() as $parent) {
									?>
									<!-- breadcrumb -->
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo lang_key('home'); ?></a></li>
										<?php
										$parent_cat = $parent->parent;
										if($parent_cat!=0){?>
										<li class="breadcrumb-item"><a href="<?php echo base_url().'threadsview/'.get_category_slug_by_id($parent->parent); ?>"><?php echo lang_key(get_category_name_by_id($parent->parent)); ?></a></li>
										<?php } ?>
										<li class="breadcrumb-item active"><?php echo lang_key($parent->catname); ?></li>
									</ol>
									
									
									<!-- Advertisments -->
									<?php require 'banner/adsense.php'; ?>
									<!-- Advertisments -->
									
									
									<h2 class="bdp-title"><?php echo lang_key($parent->catname); ?> </h2>
									
									<!--  New topic Button -->
									<?php if(is_loggedin())
									{ ?>
										<?php if(get_category_permission_by_id($parent->id) != 1 or get_user_role_by_id($this->session->userdata('user_id')) == '1') { ?>
										<div class="pull-right">
											<button type="button" class="btn btn-outline-primary btn-sm btnnewThread"><?php echo lang_key('new_topic'); ?></button>
										</div><br/><br/>
										<?php }else{ ?>
										<div class="bbp-template-notice danger">
										<p class="bbp-topic-description"><i class="fa fa-lock" aria-hidden="true"></i> <?php echo lang_key('only_admin_can_create_topic'); ?></p>
										</div>
										<?php } ?>
									<?php } ?>
									
									<!--  #Forum Category -->
									<?php //Sub Category
									$sub_category = $CI->threads_model->getAllSubCatThreadPost($parent->id);
									$total = $sub_category->num_rows(); ?>
									<?php	if($total<=0){ ?>
									<?php }else{?>
									<div id="bdp-forums" class="forum-head">
										<ul class="forum-titles">
											<li class="bdp-topic-title"><?php echo lang_key('sub_category'); ?></li>
											<li class="bdp-topic-voice-count"><?php echo lang_key('topic'); ?></li>
											<li class="bdp-topic-reply-count"><?php echo lang_key('reply'); ?></li>
											<li class="bdp-topic-view-count"><?php echo lang_key('views'); ?></li>
										</ul>
										<div class="bdp-forum-body">
											<?php
											$i = 0;
											foreach ($sub_category->result() as $sub_cat) {
											$i++;
											?>
											<ul class="forum">
												<li class="bdp-forum-info">
													<a class="bdp-forum-title" href="<?php echo base_url(); ?>threadsview/<?php echo $sub_cat->slug ?>"><?php echo lang_key($sub_cat->catname); ?></a>
													<div class="bdp-forum-content"><?php echo strip_tags($sub_cat->description); ?></div>
												</li>
												<li class="bdp-forum-topic-count"><?php echo custom_number_format($CI->threads_model->countThreadsByParentCategoryId($sub_cat->id));?></li>
												<li class="bdp-forum-reply-count"><?php echo custom_number_format($CI->threads_model->countTopicReplyByCategoryId($sub_cat->id)); ?></li>
												<li class="bdp-forum-view-count"><?php echo custom_number_format($CI->threads_model->countTopicTotalViewByCategory($sub_cat->id)); ?></li>
											</ul>
											<?php } //end sub category ?>
										</div>
									</div>
									
									<!-- Advertisments -->
									<?php require 'banner/adsense.php'; ?>
									<!-- Advertisments -->
									<?php } //end sub cat total post ?>
									<!-- end #Forum Category -->
									
									
									
									<!-- #Forum Topic -->
									<div id="bbpress-forums">
										<ul class="bbp-topics" id="bbp-forum-752">
											<li class="bbp-header">
												<ul class="forum-titles">
													<li class="bbp-topic-title"><?php echo lang_key('topic'); ?></li>
													<li class="bbp-topic-voice-count"><?php echo lang_key('views'); ?></li>
													<li class="bbp-topic-reply-count"><?php echo lang_key('reply'); ?></li>
													<li class="bbp-topic-freshness"><?php echo lang_key('latest_reply'); ?></li>
												</ul>
											</li>
											
											<!-- Category Topic Post Start -->
											<?php require('threads/cat_topic_post.php');?>
											<!-- Category Topic Post Start -->
											
											<li class="bbp-footer">
												<div class="tr">
													<p><span class="td colspan4">&nbsp;</span></p>
												</div>
												<!-- .tr -->
											</li>
										</ul>
										<div class="bbp-pagination">
											<div class="bbp-pagination-links">
												<?php echo $this->pagination->create_links(); ?>    
											</div>
										</div>
									</div>
									<!-- end #Forum Topic -->
									<?php } //end parent category ?>
									
									
									<!-- Advertisments -->
									<?php require 'banner/adsense.php'; ?>
									<!-- Advertisments -->
                            </div>
                        </div>
                    </div>
					
					<!-- Side bar -->
                    <div class="col-xs-12 col-sm-3 hidden-xs">
						<?php $this->load->view('themes/default/layout/sidebar'); ?>
                    </div>
					
                </div>
            </div>
        </section>




<!-- Modal -->
<div class="modal fade" id="newThread" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><?php echo lang_key('post_new_topic_header'); ?> <?php echo $parent->catname; ?></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo validation_errors('<div class="alert alert-dismissible alert-danger">', '</div>'); 
				echo form_open('create','method="post" id="save-newtopic-form" class="form-horizontal"'); ?>
            <div class="modal-body">
			<?php require 'newtopic.php'; ?>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang_key('close'); ?></button>
				<button type="submit" class="btn btn-primary"><?php echo lang_key('create_threads'); ?></button>
			</div>
			<?php echo form_close(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">

$(document).ready(function(){
  var show_btn=$('.btnnewThread');
  
    show_btn.click(function(){
      $("#newThread").modal('show');
  })
});
</script>