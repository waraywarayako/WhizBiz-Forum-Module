		<?php
		$CI = get_instance(); ?>
		<section>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-9">
						<!-- breadcrumb -->
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo lang_key('home');?></a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url().'threadsview/'.get_category_slug_by_id($item['category_id']); ?>"><?php echo lang_key(get_category_name_by_id($item['category_id'])); ?></a></li>
							<li class="breadcrumb-item active"><?php echo $item['title']; ?></li>
						</ol>
						<!-- #bbpforum -->
                        <div id="bbpress-forums">
						
                            <div class="bbp-template-notice info">
                                <p class="bbp-topic-description"><?php echo lang_key('topic_contains').'&nbsp<span class="text-danger">'.custom_number_format($CI->threads_model->countTopicReplyByTopicId($item['id'])).'</span>&nbsp'.lang_key('reply_posted'); ?>
                                    &nbsp;
                                    <a class="bbp-author-name <?php echo get_user_type_by_id_name(get_user_role_by_id($item['user_id']));?>" title="<?php echo get_user_title_by_id($item['user_id']);?>" href="<?php echo base_url('account/'.get_username_by_id($item['user_id'])); ?>"><?php echo get_user_title_by_id($item['user_id']);?></a>
											&nbsp;
											<?php 
											$post_date = $item['created_at'];
											$now = time();
											echo '<span class="text-grey">'.timespan($post_date, $now, 1).'&nbsp'.lang_key('ago').'</span>'; ?>.
                                </p>
                            </div>
							
							
							<!-- Advertisments -->
							<?php require 'banner/adsense.php'; ?>
							<!-- Advertisments -->
							
							

                            <div class="bbp-pagination">
                                <div class="bbp-pagination-count">
                                    <h4><?php echo $item['title']; ?></h4>
                                </div>
                                <div class="bbp-pagination-links"></div>
                            </div>
							
                            <ul class="forums bbp-replies">
                                <li class="bbp-header">
                                    <div class="bbp-reply-author"><?php echo lang_key('author');?></div>
                                    <!-- .bbp-reply-author -->
                                    <div class="bbp-reply-content">
                                        <?php echo lang_key('post');?>
										<?php
										if(get_user_role_by_id($this->session->userdata('user_id')) == '1'){
										?>
										<!-- Lock Post -->
										<span id="subscription-toggle">&nbsp;|&nbsp;
                                            <span id="subscribe-783">
                                                <?php if($item['lock_post'] == 0){ ?>
												<a class="text-primary" onclick="lockPost_modal('<?php echo base_url('threads/lockposttopic/'.$item['id']) ?>')" style="cursor:pointer;" data-toggle="modal"  data-target="#lockPostTopic"><?php echo lang_key('lock_post') ?> <i class="fa fa-lock" aria-hidden="true"></i></a>
												<?php }else{ ?>
												<a class="text-primary" onclick="lockPost_modal('<?php echo base_url('threads/unlockposttopic/'.$item['id']) ?>')" style="cursor:pointer;" data-toggle="modal"  data-target="#lockPostTopic"><?php echo lang_key('unlock_post') ?> <i class="fa fa-unlock" aria-hidden="true"></i></a>
												<?php } ?>
                                            </span>
                                        </span>
										
										<!-- Pin Post -->
                                        <span id="subscription-toggle">
                                            <span id="subscribe-783">
												<?php if($item['pin_post'] == 0){ ?>
												<a class="text-primary" onclick="pinPost_modal('<?php echo base_url('threads/pinposttopic/'.$item['id']) ?>')" style="cursor:pointer;" data-toggle="modal"  data-target="#pinPostTopic"><?php echo lang_key('pin_post') ?> <i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
												<?php }else{ ?>
												<a class="text-primary" onclick="pinPost_modal('<?php echo base_url('threads/unpinposttopic/'.$item['id']) ?>')" style="cursor:pointer;" data-toggle="modal"  data-target="#pinPostTopic"><?php echo lang_key('unpin_post') ?> <i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
												<?php } ?>
										   </span>
                                        </span>
										<?php } ?>
                                    </div>
                                    <!-- .bbp-reply-content -->
                                </li>
                                
								
								<!-- .bbp-header -->
                                <li class="bbp-body">
								
                                    <div id="post-783" class="bbp-reply-header">
                                        <div class="bbp-meta">
                                            <span class="bbp-reply-permalink pull-right text-grey">#<?php echo lang_key('topic_post');?></span>
											<?php if($item['lock_post'] == 1){//if topic is locked ?>
											<span class="pull-right text-grey bbp-admin-links">
												<i class="fa fa-lock"></i> |
											</span>
											<?php }else{//if topic is not locked ?>
												<?php
												if($this->session->userdata('user_id') == $item['user_id'] or get_user_role_by_id($this->session->userdata('user_id')) == '1'){
												?>
												<span class="bbp-admin-links">
													<a href="<?php echo base_url('threads/load_editpost/'.$item['id']) ?>" class="editposttopic"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a onclick="delete_modal('<?php echo base_url('threads/deleteposttopic/'.$item['id']) ?>')" style="cursor:pointer;" data-toggle="modal"  data-target="#deletePostTopic"><i class="fa fa-trash-o" aria-hidden="true"></i></a> | 
												</span>
												<?php } ?>
											<?php }//if topic is locked end ?>
                                        </div>
                                        <!-- .bbp-meta -->
                                    </div>
                                    <!-- #post-783 -->
                                    <div class="odd topic-author topic hentry">
                                        <div class="bbp-reply-author">
                                            <a href="<?php echo base_url('account/'.get_username_by_id($item['user_id'])); ?>" class="bbp-author-avatar">
                                                <img src="<?php echo get_profile_photo_by_id($item['user_id']); ?>" class="avatar photo" alt="<?php echo get_user_title_by_id($item['user_id']);?>" height="80" width="80">
                                            </a>
                                            <a href="<?php echo base_url('account/'.get_username_by_id($item['user_id'])); ?>" class="bbp-author-name <?php echo get_user_type_by_id_name(get_user_role_by_id($item['user_id']));?>"><?php echo get_user_title_by_id($item['user_id']);?></a>
                                            <div class="bbp-author-role"><?php echo get_user_type_by_id(get_user_role_by_id($item['user_id']));?></div>
                                            <div class="bbp-reply-post-date text-default"><small>
											<?php 
											$post_date = $item['created_at'];
											$now = time();
											echo timespan($post_date, $now, 1).'&nbsp'.lang_key('ago'); ?></small></div>
                                        </div>
                                        <!-- .bbp-reply-author -->
                                        <div class="bbp-reply-content">
                                            <p><?php echo str_replace('href=', 'rel="nofollow" href=',$item['content']); ?></p>
											<?php $tags = $item['tags']; ?>
											<?php if($tags != 'n/a' && $tags != ''){ ?>
											<p>
												<?php $tags = explode(',',$tags);
												foreach ($tags as $tag) { ?>
												<span class="label label-primary"><a href="<?php echo base_url('tags/'.tags_url_title($tag)); ?>"><?php echo $tag ?></a></span>
												<?php } ?>
											<p>
											<?php } ?>
											
											<!-- date modified -->
											<?php if($item['updated_at'] != ''){ ?>
											<p class="pull-right"><small class="last-update"><?php echo lang_key('last_update'); ?> <?php 
											$uppost_date = $item['updated_at'];
											$now = time();
											echo timespan($uppost_date, $now, 1).'&nbsp'.lang_key('ago'); ?></small></p>
											<?php } ?>
											
											<!-- signature -->
											<?php $signature = get_user_meta($item['user_id'], 'signature'); 
											if($signature != ''){ ?>
											<br/><hr>
											<?php echo $signature ?>
											<?php } ?>
                                        </div>
                                        <!-- .bbp-reply-content -->
                                    </div>
									<div class="sharethis-inline-share-buttons"></div>
									
                                    <!-- load reply topic -->
									<?php require('threads/topic_reply.php');?>
									<!-- end reply topic -->
									
                                </li>
								
                                <!-- .bbp-body -->
                                <li class="bbp-footer">
                                    <div class="bbp-reply-author"><?php echo lang_key('author');?></div>
                                    <div class="bbp-reply-content">
                                        <?php echo lang_key('post');?>
                                    </div>
                                    <!-- .bbp-reply-content -->
                                </li>
                                <!-- .bbp-footer -->
                            </ul>
							
                            <div class="bbp-pagination">
                                <div class="bbp-pagination-links">
                                <?php echo $this->pagination->create_links(); ?>    
                                </div>
                            </div>
							
							<!-- Advertisments -->
							<?php require 'banner/adsense.php'; ?>
							<!-- Advertisments -->
							
							<!-- You Must Login to Comment Start-->
							<?php if(is_loggedin())
							{ ?>
								<?php if($item['lock_post'] == 1){//if topic is locked start ?>
								<div class="bbp-no-reply">
									<div class="bbp-template-notice">
										<p><i class="fa fa-lock"></i> <?php echo lang_key('topic_is_locked'); ?></p>
									</div>
								</div>
								<?php }else{//not locked ?>
									<div class="bbp-reply-form">
										<fieldset class="bbp-form">
											<legend><?php echo lang_key('reply_topic') ?></legend>
											<div>
												<div class="ajax-loading topic-loading" align="center"><img src="<?php echo base_url();?>/assets/images/gif/loading.gif" alt="loading..."></div>
												<span class="reply-topic-form-holder"></span>
											</div>
										</fieldset>
									</div>
								<?php }//topic lock end ?>	
							<?php }else{ ?>
							<div class="bbp-no-reply">
                                <div class="bbp-template-notice">
                                    <p>
									<?php if($item['lock_post'] == 1){//if topic is locked start ?>
									<i class="fa fa-lock"></i> <?php echo lang_key('topic_is_locked'); ?>
									<?php }else{//not locked ?>
									<i class="fa fa-warning"></i> <?php echo lang_key('you_must_login'); ?>
									<?php }//topic lock end ?>	
									</p>
                                </div>
                            </div>
							<?php } ?>
							<!-- You Must Login to Comment End-->
							
                        </div>
                        <!-- end #bbpforum -->
                    </div>
					
					<!-- Side bar -->
                    <div class="col-xs-12 col-sm-3 hidden-xs">
						<?php $this->load->view('themes/default/layout/sidebar'); ?>
                    </div>
					
					</div>
                </div>
            </div>
        </section>
<!-- Edit Topic Post  Modal-->
<div class="modal fade" id="editPostTopic" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><?php echo lang_key('edit_your_threads'); ?></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- Delete Topic Post  Modal-->
<div class="modal fade" id="deletePostTopic" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><?php echo lang_key('confirm_delete'); ?></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <div class="modal-body">
				<?php echo lang_key('confirm_delete_text_post'); ?>
            </div>
			<div class="modal-footer">
				<a class="btn btn-danger" id="delete_topic_post" href=""><?php echo lang_key('delete'); ?></a>
				<button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link"><?php echo lang_key('cancel'); ?></button>       
            </div>
        </div>
    </div>
</div>
<!-- Pin Topic Post  Modal-->
<div class="modal fade" id="pinPostTopic" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">
				<?php if($item['pin_post'] == 0){ 
					echo lang_key('confirm_pinpost'); 
				}else{
					echo lang_key('confirm_unpinpost'); 
				} 
				?></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <div class="modal-body">
				<?php if($item['pin_post'] == 0){ 
					echo lang_key('confirm_pin_post'); 
				}else{
					echo lang_key('confirm_unpin_post'); 
				} 
				?>
            </div>
			<div class="modal-footer">
				<a class="btn btn-danger" id="pin_topic_post" href="">
				<?php if($item['pin_post'] == 0){ 
					echo lang_key('pin_post'); 
				}else{
					echo lang_key('unpin_post'); 
				} 
				?>
				</a>
				<button type="button" class="btn btn-info" data-dismiss="modal" id="cancel_link"><?php echo lang_key('cancel'); ?></button>       
            </div>
        </div>
    </div>
</div>
<!-- Pin Topic JS -->
<script>	
	function pinPost_modal(pinPost_url)
    {
		jQuery('#pinPostTopic').modal('show', {backdrop: 'static',keyboard :false});
		document.getElementById('pin_topic_post').setAttribute("href" , pinPost_url );
		document.getElementById('pin_topic_post').focus();
    }
</script>
<!-- lock Topic Post  Modal-->
<div class="modal fade" id="lockPostTopic" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">
				<?php if($item['lock_post'] == 0){ 
					echo lang_key('confirm_lockpost'); 
				}else{
					echo lang_key('confirm_unlockpost'); 
				} 
				?></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <div class="modal-body">
				<?php if($item['lock_post'] == 0){ 
					echo lang_key('confirm_lock_post'); 
				}else{
					echo lang_key('confirm_unlock_post'); 
				} 
				?>
            </div>
			<div class="modal-footer">
				<a class="btn btn-danger" id="lock_topic_post" href="">
				<?php if($item['lock_post'] == 0){ 
					echo lang_key('lock_post'); 
				}else{
					echo lang_key('unlock_post'); 
				} 
				?>
				</a>
				<button type="button" class="btn btn-info" data-dismiss="modal" id="cancel_link"><?php echo lang_key('cancel'); ?></button>       
            </div>
        </div>
    </div>
</div>
<!-- lock Topic JS -->
<script>	
	function lockPost_modal(lockPost_url)
    {
		jQuery('#lockPostTopic').modal('show', {backdrop: 'static',keyboard :false});
		document.getElementById('lock_topic_post').setAttribute("href" , lockPost_url );
		document.getElementById('lock_topic_post').focus();
    }
</script>
<!-- Edit Topic JS -->
<script type="text/javascript">
jQuery(document).ready(function(){
    
    jQuery(".editposttopic").click(function(event){
        event.preventDefault();
        var loadUrl = jQuery(this).attr("href");
        jQuery('#editPostTopic').modal('show');
        jQuery("#editPostTopic  .modal-body").html("Loading...");
        jQuery.post(
                loadUrl,
                {},
                function(responseText){
                    jQuery("#editPostTopic  .modal-body").html(responseText);
                },
                "html"
            );
    });
});
</script>
<!-- Delete Topic JS -->
<script>	
	function delete_modal(delete_url)
    {
		jQuery('#deletePostTopic').modal('show', {backdrop: 'static',keyboard :false});
		document.getElementById('delete_topic_post').setAttribute("href" , delete_url );
		document.getElementById('delete_topic_post').focus();
    }
</script>
<!-- Load Reply Form -->
<script type="text/javascript">
var loadUrl = '<?php echo base_url("threads/load_reply_to_topic_view/".$item['id']);?>';
    jQuery.post(
        loadUrl,
        {},
        function(responseText){
			
            jQuery('.reply-topic-form-holder').html(responseText);
            init_reply_topic_js();
        }
    );
	
function init_reply_topic_js()
{
    jQuery('#replytopic-form').submit(function(e){
			CKEDITOR.instances.comment.updateElement();
            var data = jQuery(this).serializeArray();
            jQuery('.topic-loading').show();
            e.preventDefault();
            var loadUrl = jQuery(this).attr('action');
            jQuery.post(
                loadUrl,
                data,
                function(responseText){
                    jQuery('.reply-topic-form-holder').html(responseText);
                    jQuery('.alert-success').each(function(){
                        jQuery('#replytopic-form textarea').each(function(){
                            jQuery(this).val('');
                        });
                    });

                    jQuery('.topic-loading').hide();
                    init_reply_topic_js();
                }
            );
        });
}
</script>