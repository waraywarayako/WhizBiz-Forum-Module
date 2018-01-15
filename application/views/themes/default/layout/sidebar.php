		<!-- Search Widget -->
		<form action="<?php echo base_url(); ?>search" method="POST">
			<div class="input-group input-group-hg input-group-rounded">
					<input type="text" class="form-control" placeholder="<?php echo lang_key('search') ?>" name="search" value="">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form>
		
		<br/>
		<!-- Featured Post Listing-->
		<?php
		$this->load->helper('text');
		$CI = get_instance();
		$CI->load->database();
		$limit = 5;
		$order = get_settings('business_settings','featured_posts_order','DESC');
		$CI->db->order_by('id',$order);
		$query = $CI->db->get_where('posts',array('status'=>1,'featured'=>1),$limit,0);
		?>
		<?php if($query->num_rows()!=0){?>
			<div align="center"><small class="text-grey"><?php echo lang_key('featured_listing') ?></small></div>
			<table class="table table-striped">
				<tbody>
					<?php foreach ($query->result() as $post) { ?>
					<tr>
						<td><a href="<?php echo post_detail_url($post);?>" target="_blank"><?php echo strip_tags(word_limiter(get_post_data_by_lang($post,'title'),2)); ?></a>
						<?php if(get_post_meta($post->id,'verified',0)==1){ ?>
						<div class="fa fa-check-circle text-success"></div>
						<?php } ?><br/>
						<small class="text-grey"><i class="fa fa-map-marker"></i> &nbsp; <?php echo get_location_name_by_id($post->city);?></small>				
					</tr>
					 <?php } ?>
				</tbody>
			</table>
		<?php }?>	
		<!-- Featured Post Listing-->
		
		<?php
		$this->load->helper('text');
		$CI = get_instance();
		$CI->load->database();
		$limit = 10;
		$CI->db->order_by('id','DESC');
		$queryres = $CI->db->get_where('threads',array('status'=>1),$limit,0);
		?>
		<?php if($queryres->num_rows()!=0){?>
			<div align="center"><small class="text-grey"><?php echo lang_key('latest_topic') ?></small></div>
			<table class="table table-striped">
				<tbody>
					<?php foreach ($queryres->result() as $post) { ?>
					<tr>
						<td><i class="fa fa-angle-right text-grey"></i> <a href="<?php echo base_url('topic/'.$post->thread_slug); ?>" target="_new"><?php echo strip_tags(word_limiter(($post->title),3)); ?></a>		
					</tr>
					 <?php } ?>
				</tbody>
			</table>
		<?php }?>	
		
		
		
		
		<!-- Advertisments -->
		<?php $this->load->view('themes/default/banner/adsense.php'); ?>
		<!-- Advertisments -->