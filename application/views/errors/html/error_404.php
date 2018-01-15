<section>
    <div class="container">
        <div class="row">
		
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="jumbotron">
						<div class="row">
							<div class="col-md-4">
								<div class="error-icon">
									<span class="icon-eye left"></span>
									<span class="icon-eye right"></span>
									<span class="icon-lip"></span>
								</div><!-- /.error-icon -->
							</div>
							<div class="col-md-8">
							<h4><?php echo lang_key('404errorheader') ?></h4>
							<p><?php echo lang_key('404errordesc') ?></p>
							<form action="<?php echo base_url(); ?>search" method="POST">
								<div class="input-group input-group-hg input-group-rounded">
									<input type="text" class="form-control" placeholder="<?php echo lang_key('search') ?>" name="search" value="">
									<span class="input-group-btn">
										<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</form>
							</div>   
						</div>   
                    </div>
				</div>
			</div>
		</div>
		
    </div>
</div>
</section>