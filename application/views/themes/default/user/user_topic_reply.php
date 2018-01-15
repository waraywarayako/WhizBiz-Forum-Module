										<?php
										$CI = get_instance();
										$i = ($_GET['page'])*$limit=get_settings('forum_settings','posts_per_page',10);
										foreach($posts->result() as $post):
										$i++;
										?>
										<tr>
											<th scope="row">#<?php echo $i ?></th>
											<td><?php echo strip_tags(word_limiter($post->comment_content,20)); ?><br/>
											<?php 
											$comment_date = $post->created_at;
											$now = time();
											$datecomment = timespan($comment_date, $now, 1).'&nbsp'.lang_key('ago'); ?>
											<small class="num-result"><?php echo lang_key('comment_on') ?>: <?php echo '<a href="'.base_url("topic/".get_edit_topic_slug_by_id($post->topic_id)).'">'.get_topic_title_by_id($post->topic_id).'</a>&nbsp'. $datecomment; ?></small>
											</td>
										</tr>
										<?php
											endforeach; //foreach
										?>	