									<?php 
									$link = $this->pagination->create_links();
									if($this->pagination->cur_page <= 1)
									{
										$i = 0;
									}else{
										$i = 0 + ($this->pagination->cur_page-1)*$this->pagination->per_page;
									}
									foreach($topicreply as $toprep): 
									$i++;?>
									<!-- .reply -->
                                    <div id="post-797" class="bbp-reply-header">
                                        <div class="bbp-meta">
                                            <span class="bbp-reply-permalink pull-right text-grey"><?php echo lang_key('myreply'),' #'.$i ?></span>
											<?php if($item['lock_post'] == 1){//if topic is locked start ?>
											<span class="pull-right text-grey bbp-admin-links">
												<i class="fa fa-lock"></i> |
											</span>
											<?php }else{//not locked ?>
												<?php
												if($this->session->userdata('user_id') == $toprep['user_id'] or get_user_role_by_id($this->session->userdata('user_id')) == '1'){
												?>
												<span class="bbp-admin-links">
													<a href="<?php echo base_url('threads/load_editreply/'.$toprep['id']) ?>" class="editreplytopic"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a onclick="confirm_modal('<?php echo base_url('threads/deletereplytopic/'.$toprep['id']) ?>')" style="cursor:pointer;" data-toggle="modal"  data-target="#deleteReplyTopic"><i class="fa fa-trash-o" aria-hidden="true"></i></a> | 
												</span>
												<?php } ?>
											<?php }//topic lock end ?>
                                        </div>
                                        <!-- .bbp-meta -->
                                    </div>
                                    <!-- #post-797 -->
                                    <div class="even topic-author hentry">
                                        <div class="bbp-reply-author">
                                            <a href="<?php echo base_url('account/'.get_username_by_id($toprep['user_id'])); ?>" class="bbp-author-avatar">
                                                <img src="<?php echo get_profile_photo_by_id($toprep['user_id']); ?>" class="avatar photo" alt="<?php echo get_user_title_by_id($toprep['user_id']);?>" height="80" width="80">
                                            </a>
                                            <a href="<?php echo base_url('account/'.get_username_by_id($toprep['user_id'])); ?>" class="bbp-author-name <?php echo get_user_type_by_id_name(get_user_role_by_id($toprep['user_id']));?>"><?php echo get_user_title_by_id($toprep['user_id']);?></a>
                                            <div class="bbp-author-role"><?php echo get_user_type_by_id(get_user_role_by_id($toprep['user_id']));?></div>
                                            <div class="bbp-reply-post-date"><small><?php 
											$post_date = $toprep['created_at'];
											$now = time();
											echo timespan($post_date, $now, 1).'&nbsp'.lang_key('ago'); ?></small></div>
                                        </div>
                                        <!-- .bbp-reply-author -->
										
										
                                        <div class="bbp-reply-content">
                                            <p><?php echo str_replace('href=', 'rel="nofollow" href=',$toprep['comment_content']); ?></p>
										
										<!-- date modified -->
										<?php if($toprep['updated_at'] != ''){ ?>
										<p class="pull-right"><small class="last-update"><?php echo lang_key('last_update'); ?> <?php 
											$uprep_date = $toprep['updated_at'];
											$now = time();
											echo timespan($uprep_date, $now, 1).'&nbsp'.lang_key('ago'); ?></small></p>
                                        <?php } ?>
										
										<!-- signature -->
										<?php $signature = get_user_meta($toprep['user_id'], 'signature'); 
										if($signature != ''){ ?>
											<br/><hr>
										<?php echo $signature ?>
										<?php } ?>
										</div>
										<!-- .bbp-reply-content -->
										
                                    </div>
                                    <!-- .reply -->
									<?php endforeach ?>
<!-- Edit Topic Reply  Modal-->
<div class="modal fade" id="editReplyTopic" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><?php echo lang_key('edit_your_reply'); ?></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- Delete Topic Reply  Modal-->
<div class="modal fade" id="deleteReplyTopic" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><?php echo lang_key('confirm_delete'); ?></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <div class="modal-body">
				<?php echo lang_key('confirm_delete_text'); ?>
            </div>
			<div class="modal-footer">
				<a class="btn btn-danger" id="delete_topic_reply" href=""><?php echo lang_key('delete'); ?></a>
				<button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link"><?php echo lang_key('cancel'); ?></button>       
            </div>
        </div>
    </div>
</div>
<!-- Edit Topic Reply JS -->
<script type="text/javascript">
jQuery(document).ready(function(){
    
    jQuery(".editreplytopic").click(function(event){
        event.preventDefault();
        var loadUrl = jQuery(this).attr("href");
        jQuery('#editReplyTopic').modal('show');
        jQuery("#editReplyTopic  .modal-body").html("Loading...");
        jQuery.post(
                loadUrl,
                {},
                function(responseText){
                    jQuery("#editReplyTopic  .modal-body").html(responseText);
                },
                "html"
            );
    });
});
</script>
<!-- Delete Topic Reply JS -->
<script>	
	function confirm_modal(delete_url)
    {
		jQuery('#deleteReplyTopic').modal('show', {backdrop: 'static',keyboard :false});
		document.getElementById('delete_topic_reply').setAttribute("href" , delete_url );
		document.getElementById('delete_topic_reply').focus();
    }
</script>