	<?php
	$CI = get_instance(); ?>
		<section>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-9">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h2 class="bdp-title"><?php echo lang_key('comunity_forum'); ?></h2>
								
									<!-- Advertisments -->
									<?php require 'banner/adsense.php'; ?>
									<!-- Advertisments -->
									
								<!--  #Forum Category -->
                                <div id="bdp-forums" class="forum-head">
                                    <ul class="forum-titles">
                                        <li class="bdp-topic-title"><?php echo lang_key('category'); ?></li>
                                        <li class="bdp-topic-voice-count"><?php echo lang_key('topic'); ?></li>
                                        <li class="bdp-topic-reply-count"><?php echo lang_key('reply'); ?></li>
                                        <li class="bdp-topic-view-count"><?php echo lang_key('views'); ?></li>
                                    </ul>
                                    <div class="bdp-forum-body">
									<?php
									$i = 0;
									foreach ($parent_categories->result() as $parent) {
									$i++;
									?>
                                        <ul class="forum">
                                            <li class="bdp-forum-info">
                                                <a class="bdp-forum-title" href="<?php echo base_url(); ?>threadsview/<?php echo $parent->slug ?>"><?php echo lang_key($parent->catname); ?> (<?php echo  custom_number_format($CI->threads_model->countThreadsByParentCategoryId($parent->id));?>)</a>
												<div class="bdp-forum-content"><?php echo strip_tags($parent->description); ?></div>
												<?php //Child Category
												$child_categories = $CI->threads_model->getAllChildThreadsCategories($parent->id, 3);
												$total = $child_categories->num_rows(); ?>
												<div class="tagcloud">
													<?php
													$c=1;
													foreach ($child_categories->result() as $child) :
													if($c<=2)
													{
													?>
													<a href="<?php echo base_url(); ?>threadsview/<?php echo $child->slug; ?>"><?php echo lang_key($child->catname); ?> (<?php echo custom_number_format($CI->threads_model->countThreadsByCategoryId($child->id));?>)</a>
													<?php
													}$c++;
													endforeach;

													if($total>=3){?>
													<a href="<?php echo base_url(); ?>threadsview/<?php echo $parent->slug ?>">View All</a>
													<?php } //end child catego ?>
												</div>
											</li>
                                            <li class="bdp-forum-topic-count"><?php echo custom_number_format($CI->threads_model->countThreadsByCategoryId($parent->id));?></li>
                                            <li class="bdp-forum-reply-count"><?php echo custom_number_format($CI->threads_model->countTopicReplyByCategoryId($parent->id)); ?></li>
                                            <li class="bdp-forum-view-count"><?php echo custom_number_format($CI->threads_model->countTopicTotalViewByCategory($parent->id)); ?></li>
                                        </ul>
									<?php } //end parent category ?>
                                    </div>
                                </div>
								<!-- end #Forum Category -->
								
									<!-- Advertisments -->
									<?php require 'banner/adsense.php'; ?>
									<!-- Advertisments -->
                            </div>
                        </div>
                    </div>
					
					<!-- Side bar -->
                    <div class="col-xs-12 col-sm-3  hidden-xs">
						<?php $this->load->view('themes/default/layout/sidebar'); ?>
                    </div>
					
                </div>
            </div>
        </section>
