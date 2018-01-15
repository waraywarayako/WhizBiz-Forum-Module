		<section>
            <div class="container">
                <div class="row">
					<div class="col-xs-12 col-sm-9">
						
						<div class="jumbotron">
							<div class="row">
								<div class="col-md-4">
									<div class="error-icon">
										 <img class="img-thumbnail" src="<?php echo get_profile_photo_by_id($account['id'],'thumb');?>" alt="<?php echo get_user_fullname_from_username($account['user_name']);?>" height="150" width="150"/>
										
									</div><!-- /.error-icon -->
									<div align="center">
										<!-- Social Account -->
										<?php $fb_profile = get_user_meta($account['id'], 'fb_profile'); ?>
										<?php $gp_profile = get_user_meta($account['id'], 'gp_profile'); ?>
										<?php $twitter_profile = get_user_meta($account['id'], 'twitter_profile'); ?>
										<?php $li_profile = get_user_meta($account['id'], 'li_profile'); ?>
										<?php if($fb_profile != '' or $twitter_profile !='' or $gp_profile != '' or $li_profile != '') { ?>
											<hr class="my-4">
											<!-- Facebook -->
											<?php if($fb_profile !='') { ?>
												<a class="btn btn-social-icon btn-facebook" href="https://<?php echo $fb_profile ?>" target="_blank"><span class="fa fa-facebook"></span></a>
											<?php } ?>
											<!-- Google -->
											<?php if($gp_profile !='') { ?>
												<a class="btn btn-social-icon btn-google" href="https://<?php echo $gp_profile ?>" target="_blank"><span class="fa fa-google"></span></a>
											<?php } ?>
											<!-- Twitter -->
											<?php if($twitter_profile !='') { ?>
												<a class="btn btn-social-icon btn-twitter" href="https://<?php echo $twitter_profile?>" target="_blank"><span class="fa fa-twitter"></span></a>
											<?php } ?>
											<!-- Linkedin -->
											<?php if($li_profile !='') { ?>
												<a class="btn btn-social-icon btn-linkedin" href="https://<?php echo $li_profile ?>" target="_blank"><span class="fa fa-linkedin"></span></a>
											<?php } ?>
										<?php } ?>
										<!-- Social Account -->
									</div>
								</div>
								
								<div class="col-md-8">
									<!-- Account Full name-->
									<?php if($account['id'] == $this->session->userdata('user_id')){ ?>
										<h4 class="<?php echo get_user_type_by_id_name(get_user_role_by_id($account['id']));?>"><?php echo get_user_fullname_from_username($account['user_name']).'&nbsp'.'<small><a href="'.base_url('edit/'.get_username_by_id($account['id'])).'" class="account_edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></small>';?></h4>
									<?php }else{ ?>
										<h4 class="<?php echo get_user_type_by_id_name(get_user_role_by_id($account['id']));?>"><?php echo get_user_fullname_from_username($account['user_name']);?></h4>
									<?php } ?>
									<!-- Account Type -->
									<footer class="blockquote-footer"> <?php echo get_user_type_by_id(get_user_role_by_id($account['id']));?></cite></footer>
									
									<!-- About Me -->
									<?php if(get_user_meta($account['id'], 'about_me')!=''){?>
                                    <p class="lead"><?php echo get_user_meta($account['id'], 'about_me'); ?></p>
                                    <?php }?>
								</div>   
							</div>   
						</div>
						
									<!-- Advertisments -->
									<?php $this->load->view('themes/default/banner/adsense.php'); ?>
									<!-- Advertisments -->
					
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="topic-tab" data-toggle="tab" href="#topic" role="tab" aria-controls="topic" aria-selected="true"><?php echo lang_key('topic') ?> <span class="badge badge-primary"><?php echo custom_number_format(get_user_topic_post_count($account['id']));?></span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="comment-tab" data-toggle="tab" href="#comment" role="tab" aria-controls="comment" aria-selected="false"><?php echo lang_key('comment') ?> <span class="badge badge-primary"><?php echo custom_number_format(get_user_topic_comment_post_count($account['id']));?></span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="listing-tab" data-toggle="tab" href="#listing" role="tab" aria-controls="listing" aria-selected="false"><?php echo lang_key('my_listing') ?> <span class="badge badge-primary"><?php echo custom_number_format(get_user_listing_post_count($account['id']));?></span></a>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent">
						
							<!-- 1st tab -->
							<div class="tab-pane fade show active" id="topic" role="tabpanel" aria-labelledby="topic-tab">			
								<!-- Topic Post Table -->
								<table class="table table-striped">
									<thead>
										<tr>
											<th scope="col"></th>
											<th scope="col"><?php echo lang_key('topic') ?></th>
											<th scope="col" class="text-center"><?php echo lang_key('views') ?></th>
											<th scope="col" class="text-center"><?php echo lang_key('reply') ?></th>
										</tr>
									</thead>
									<!-- Load Data -->
									<tbody class="user-topic-post">
									</tbody>
								</table>
								<!-- Ajax Load -->
								<div class="ajax-loading user-topic-post-loading" align="center"><img src="<?php echo base_url();?>/assets/images/gif/loading.gif" alt="loading..."></div>
								<!-- Ajax Load More Button -->
								<div class="col-lg-12">
									<button class="btn btn-embossed btn-primary btn-hg btn-block load-more" data-val = "0" ><?php echo lang_key('load_more'); ?></button>
								</div>
							</div>
							
							<!-- 2nd tab -->
							<div class="tab-pane fade" id="comment" role="tabpanel" aria-labelledby="comment-tab">
								<table class="table table-striped">
									<thead>
										<tr>
											<th scope="col"></th>
											<th scope="col" class="text-center"><?php echo lang_key('comment') ?></th>
										</tr>
									</thead>
									<!-- Load Data -->
									<tbody class="user-topic-comment">
									</tbody>
								</table>
								<!-- Ajax Load -->
								<div class="ajax-loading user-topic-reply-loading" align="center"><img src="<?php echo base_url();?>/assets/images/gif/loading.gif" alt="loading..."></div>
								<!-- Ajax Load More Button -->
								<div class="col-lg-12">
									<button class="btn btn-embossed btn-primary btn-hg btn-block load-more-reply" data-val = "0" ><?php echo lang_key('load_more'); ?></button>
								</div>
							
							</div>
							
							<!-- 3rd tab -->
							<div class="tab-pane fade" id="listing" role="tabpanel" aria-labelledby="listing-tab">
							    <!-- Listing Table -->
								<table class="table table-striped">
									<thead>
										<tr>
											<th scope="col"></th>
											<th scope="col"><?php echo lang_key('business_name') ?></th>
											<th scope="col"><?php echo lang_key('rating') ?></th>
										</tr>
									</thead>
									<!-- Load Data -->
									<tbody class="user-listing-post">
									</tbody>
								</table>
								<!-- Ajax Load -->
								<div class="ajax-loading user-listing-post-loading" align="center"><img src="<?php echo base_url();?>/assets/images/gif/loading.gif" alt="loading..."></div>
								<!-- Ajax Load More Button -->
								<div class="col-lg-12">
									<button class="btn btn-embossed btn-primary btn-hg btn-block load-more-listing" data-val = "0" ><?php echo lang_key('load_more'); ?></button>
								</div>
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
		
		
		<!-- JS Load More Topic -->
		<script>
		 $(document).ready(function(){
            userpost(0);

            $(".load-more").click(function(e){
                e.preventDefault();
                var page = $(this).data('val');
                userpost(page);

            });

        });
		
		var userpost = function (page) {
		$(".user-topic-post-loading").show();
		$(".load-more").show();
		$.ajax({
			url: "<?php echo base_url("user/get_topic/" . $account['id']); ?>",
			type: 'GET',
			data: {
				page: page
			},
			dataType: 'json'
		}).done(function (response) {
			$(".user-topic-post").append(response.body);
			$(".user-topic-post-loading").hide();
			if (response.msg == "done") {
				$(".load-more").hide();
			} else {
				$('.load-more').data('val', ($('.load-more').data('val') + 1));
			}
		});

		};     
		</script>
		
		<!-- JS Load More Reply Topic -->
		<script>
		$(document).ready(function(){
             userreply(0);

            $(".load-more-reply").click(function(e){
                e.preventDefault();
                var page = $(this).data('val');
                 userreply(page);

            });

        });
		
		var  userreply = function (page) {
		$(".user-topic-reply-loading").show();
		$(".load-more-reply").show();
		$.ajax({
			url: "<?php echo base_url("user/get_replytopic/".$account['id']); ?>",
			type: 'GET',
			data: {
				page: page
			},
			dataType: 'json'
		}).done(function (response) {
			$(".user-topic-comment").append(response.body);
			$(".user-topic-reply-loading").hide();
			if (response.msg == "show") {
				$(".load-more-reply").hide();
			} else {
				$('.load-more-reply').data('val', ($('.load-more-reply').data('val') + 1));
			}
		});

		};  
		</script>
		
		
		
		
		<!-- JS Load More listing -->
		<script>
		$(document).ready(function(){
             userlisting(0);

            $(".load-more-listing").click(function(e){
                e.preventDefault();
                var page = $(this).data('val');
                 userlisting(page);

            });

        });
		
		var  userlisting = function (page) {
		$(".user-listing-post-loading").show();
		$(".load-more-listing").show();
		$.ajax({
			url: "<?php echo base_url("user/get_listing/".$account['id']); ?>",
			type: 'GET',
			data: {
				page: page
			},
			dataType: 'json'
		}).done(function (response) {
			$(".user-listing-post").append(response.body);
			$(".user-listing-post-loading").hide();
			if (response.msg == "listing") {
				$(".load-more-listing").hide();
			} else {
				$('.load-more-listing').data('val', ($('.load-more-listing').data('val') + 1));
			}
		});

		};  
		</script>