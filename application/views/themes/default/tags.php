		<section>
            <div class="container">
                <div class="row">
						<div class="col-xs-12 col-sm-9">				
							<!-- #Forum Topic -->
							<div id="bbpress-forums">
									<div class="bbp-template-notice info">
										<p class="bbp-topic-description"><?php echo lang_key('you_are_searching').'&nbsp<b class="text-danger">'.$tags.'</b>&nbsp'.lang_key('with_total_result').'&nbsp<b class="text-danger">'.custom_number_format($this->topic_model->countTagsMatch(str_replace("-"," ",$total_res))).'</b>'; ?>.
										</p>
									</div>
									
									<!-- Advertisments -->
									<?php require 'banner/adsense.php'; ?>
									<!-- Advertisments -->
									
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
											<?php
											$CI = get_instance(); ?>
											<li class="bbp-body">
												<?php if(count($result) > 0){ ?>
												<?php 
												$i = 0;
												foreach($result as $res): 
												$i++;?>
												<?php 
												if($res['pin_post'] == 1){ ?>
												<ul class="topic super-sticky">
													<li class="bbp-topic-title">
													<strong><i class="fa fa-thumb-tack text-success"></i></strong>
												<?php }else{ ?>
												<ul class="topic">
													<li class="bbp-topic-title">
												<?php } ?>
														<a href="<?php echo base_url(); ?>topic/<?php echo $res['thread_slug']; ?>" class="bbp-topic-permalink"><?php echo $res['title']; ?></a>
														<?php if($res['lock_post'] == 1){ ?>
														<i class="fa fa-lock text-grey"></i>
														<?php } ?>
														<p class="bbp-topic-meta">
														
															<?php echo strip_tags(word_limiter($res['content'],20)).'<a href="'.base_url().'topic/'.$res['thread_slug'].'">..Read More</a>'; ?><br/>
															<span class="bbp-topic-started-by"><small class="last-update"><?php echo lang_key('started_by'); ?>:
																<a class="bbp-author-name <?php echo get_user_type_by_id_name(get_user_role_by_id($res['user_id']));?>" title="<?php echo get_user_title_by_id($res['user_id']);?>" href="<?php echo base_url('account/'.get_username_by_id($res['user_id'])); ?>"><?php echo get_user_title_by_id($res['user_id']);?></a>&nbsp;<i> 
																<?php 
																$post_date = $res['created_at'];
																$now = time();
																echo timespan($post_date, $now, 1). '&nbsp'.lang_key('ago') ?></i></small>
																
															</span>
														</p>
													</li>
												<li class="bbp-topic-voice-count num-result"><?php echo custom_number_format($res['post_view']); ?></li>
													<li class="bbp-topic-reply-count num-result"><?php echo custom_number_format($CI->threads_model->countTopicReplyByTopicId($res['id'])); ?></li>
													<li class="bbp-topic-freshness">
														<?php 
														if(getLatestReplyById($res['id'])=='N/A'){
														?><br/>
														<small class="num-result">No Reply</small>
														<?php } else { ?><br/>
														<a title="<?php echo get_user_title_by_id(getLatestReplyById($res['id']));?>" href="<?php echo base_url('account/'.get_username_by_id(getLatestReplyById($res['id']))); ?>" class="bbp-author-avatar <?php echo get_user_type_by_id_name(get_user_role_by_id(getLatestReplyById($res['id'])));?>">
														<img alt="<?php echo get_user_title_by_id(getLatestReplyById($res['id']));?>" class="avatar photo" src="<?php echo get_profile_photo_by_id(getLatestReplyById($res['id'])); ?>" height="20" width="20"/> <?php echo get_user_title_by_id(getLatestReplyById($res['id']));?>
														</a>
														<p class="bbp-topic-meta">
															<span class="bbp-topic-freshness-author last-update">
																<?php 
																
																$repty_time = getLatestReplyTimeByUserId($res['id']);
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
													<span class="text-danger"><?php echo lang_key('no_result_found').'&nbsp<strong>'.$tags.'</strong>'; ?></span>
												</ul>
												<?php } ?>
												
											</li>
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
								
									<!-- Advertisments -->
									<?php require 'banner/adsense.php'; ?>
									<!-- Advertisments -->
								
							</div>
						</div>
					<!-- Side bar -->
                    <div class="col-xs-12 col-sm-3 hidden-xs">
						<?php $this->load->view('themes/default/layout/sidebar'); ?>
                    </div>
					
                </div>
            </div>
        </section>							