											<?php
											$CI = get_instance(); ?>
											<li class="bbp-body">
												<?php if(count($threads_post) > 0){ ?>
												<?php 
												$i = 0;
												foreach($threads_post as $threads): 
												$i++;?>
												<?php 
												if($threads['pin_post'] == 1){ ?>
												<ul class="topic super-sticky">
													<li class="bbp-topic-title">
													<strong><i class="fa fa-thumb-tack text-success"></i></strong>
												<?php }else{ ?>
												<ul class="topic">
													<li class="bbp-topic-title">
												<?php } ?>
														<a href="<?php echo base_url(); ?>topic/<?php echo $threads['thread_slug']; ?>" class="bbp-topic-permalink"><?php echo $threads['title']; ?></a>
														<?php if($threads['lock_post'] == 1){ ?>
														<i class="fa fa-lock text-grey"></i>
														<?php } ?>
														<p class="bbp-topic-meta">
														
															<?php echo strip_tags(word_limiter($threads['content'],20)).'<a href="'.base_url().'topic/'.$threads['thread_slug'].'">..Read More</a>'; ?><br/>
															<span class="bbp-topic-started-by"><small class="last-update"><?php echo lang_key('started_by'); ?>:
																<a class="bbp-author-name <?php echo get_user_type_by_id_name(get_user_role_by_id($threads['user_id']));?>" title="<?php echo get_user_title_by_id($threads['user_id']);?>" href="<?php echo base_url('account/'.get_username_by_id($threads['user_id'])); ?>"><?php echo get_user_title_by_id($threads['user_id']);?></a>&nbsp;<i> 
																<?php 
																$post_date = $threads['created_at'];
																$now = time();
																echo timespan($post_date, $now, 1). '&nbsp'.lang_key('ago') ?></i></small>
																
															</span>
														</p>
													</li>
												<li class="bbp-topic-voice-count num-result"><?php echo custom_number_format($threads['post_view']); ?></li>
													<li class="bbp-topic-reply-count num-result"><?php echo custom_number_format($CI->threads_model->countTopicReplyByTopicId($threads['id'])); ?></li>
													<li class="bbp-topic-freshness">
														<?php 
														if(getLatestReplyById($threads['id'])=='N/A'){
														?><br/>
														<small class="num-result">No Reply</small>
														<?php } else { ?><br/>
														<a title="<?php echo get_user_title_by_id(getLatestReplyById($threads['id']));?>" href="<?php echo base_url('account/'.get_username_by_id(getLatestReplyById($threads['id']))); ?>" class="bbp-author-avatar <?php echo get_user_type_by_id_name(get_user_role_by_id(getLatestReplyById($threads['id'])));?>">
														<img alt="<?php echo get_user_title_by_id(getLatestReplyById($threads['id']));?>" class="avatar photo" src="<?php echo get_profile_photo_by_id(getLatestReplyById($threads['id'])); ?>" height="20" width="20"/> <?php echo get_user_title_by_id(getLatestReplyById($threads['id']));?>
														</a>
														<p class="bbp-topic-meta">
															<span class="bbp-topic-freshness-author last-update">
																<?php 
																
																$repty_time = getLatestReplyTimeByUserId($threads['id']);
																$now = time();
																echo timespan($repty_time, $now, 1). '&nbsp'.lang_key('ago') ?>
															</span>
														</p>
														<?php } ?>
													</li>
												</ul>
												<?php endforeach; ?>
												<?php	}else{ ?>
												<ul class="odd topic type-topic status-publish hentry">
													<span class="text-danger"><?php echo lang_key('no_topic_result'); ?></span>
												</ul>
												<?php } ?>
												
											</li>