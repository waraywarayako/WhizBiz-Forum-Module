										<?php
										$CI = get_instance();
										foreach($posts->result() as $post):
										$post_link = post_detail_url($post);
										?>
										<tr>
											<th scope="row">
											<a href="<?php echo $post_link; ?>" target="_blank"><img class="img-thumbnail" alt="<?php echo get_post_data_by_lang($post,'title');?>" src="<?php echo get_featured_photo_by_id($post->featured_img);?>" height="80" width="100"></a>
											</th>
											<td><a href="<?php echo $post_link; ?>" target="_blank"><?php echo get_post_data_by_lang($post,'title'); ?></a>
											<?php if(get_post_meta($post->id,'verified',0)==1){ ?>
											<div class="fa fa-check-circle text-success"></div>
											<?php } ?>
											<br/>
											<small class="num-result"><?php echo strip_tags(word_limiter(get_post_data_by_lang($post,'description'),20)); ?><br/><b><i class="fa fa-map-marker"></i> &nbsp; <?php echo get_location_name_by_id($post->city);?></td>
											<td class="text-center"><?php echo $post->rating; ?></td>
										</tr>
										<?php
											endforeach; //foreach
										?>	