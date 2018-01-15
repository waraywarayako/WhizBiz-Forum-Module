										<?php
										$CI = get_instance();
										$i = ($_GET['page'])*$limit=get_settings('forum_settings','posts_per_page',10);
										foreach($posts->result() as $post):
										$i++;
										?>
										<tr>
											<th scope="row">#<?php echo $i ?></th>
											<td>
											<?php if($post->pin_post== 1){ ?><i class="fa fa-thumb-tack text-success"></i><?php } ?>
											<a href="<?php echo base_url("topic/".$post->thread_slug);?>"><?php echo $post->title; ?></a>
											<?php if($post->lock_post== 1){ ?><i class="fa fa-lock text-grey"></i><?php } ?><br/>
											<small class="num-result"><?php echo strip_tags(word_limiter($post->content,20)); ?><br/><b>
											<?php 
											$posted_date = $post->created_at;
											$now = time();
											echo timespan($posted_date, $now, 1).'&nbsp'.lang_key('ago'); ?></b></small></td>
											<td class="num-result text-center"><?php echo custom_number_format($post->post_view); ?></td>
											<td class="num-result text-center"><?php echo custom_number_format($CI->threads_model->countTopicReplyByTopicId($post->id)); ?></td>
										</tr>
										<?php
											endforeach; //foreach
										?>	