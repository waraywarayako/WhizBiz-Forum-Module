	<!-- NOTIFICATION MESSAGES -->
	<?php //Success Creating Account
	$message = $this->session->flashdata('regmsg');
	if($message == "success"){
	?>
    <script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-check-circle',
            message: "<?php echo lang_key('register_success'); ?>"

        },{
            type: 'success',
            timer: 4000
        });

     });
	</script>
	<?php } ?>
	<?php //Success Update Profile
	$message = $this->session->flashdata('updateprofilemsg');
	if($message == "successupdateprofile"){
	?>
    <script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-check-circle',
            message: "<?php echo lang_key('user_updated'); ?>"

        },{
            type: 'success',
            timer: 4000
        });

     });
	</script>
	<?php } ?>
	<?php //No Permission 
	$message = $this->session->flashdata('nopermission');
	if($message == "nopermission"){
	?>
    <script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-warning',
            message: "<?php echo lang_key('nopermission'); ?>"

        },{
            type: 'danger',
            timer: 4000
        });

     });
	</script>
	<?php } ?>
	
	<?php //The Account is Banned
	$message = $this->session->flashdata('logmsg');
	if($message == "banned"){
	?>
    <script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-times-circle',
            message: "<?php echo lang_key('banned_acc'); ?>"

        },{
            type: 'warning',
            timer: 4000
        });

     });
	</script>
	<?php //The Account is Not Confirmed
	}else if($message == "notconfirmed"){
	?>
	<script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-times-circle',
            message: "<?php echo lang_key('notconfirmed'); ?>"

        },{
            type: 'danger',
            timer: 4000
        });

     });
	</script>
	<?php //Incorrect Email or Password
	}else if($message == "incorrect"){
	?>
	<script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-times-circle',
            message: "<?php echo lang_key('incorrectuser'); ?>"

        },{
            type: 'danger',
            timer: 4000
        });

     });
	</script>
	<?php //Successfuly Login
	}else if($message == "successlog"){
	?>
	<script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-check-circle',
            message: "<?php echo lang_key('login_success'); ?>"

        },{
            type: 'success',
            timer: 4000
        });

     });
	</script>
	<?php //email not shared
	} else if($message == "emailnotshared"){
	?>
	<script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-warning',
            message: "<?php echo lang_key('email_not_shared'); ?>"

        },{
            type: 'danger',
            timer: 4000
        });

     });
	</script>
	<?php //recover password 
	}else if($message == "recover"){
	?>
	<script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-check-circle',
            message: "<?php echo lang_key('reset_password'); ?>"

        },{
            type: 'success',
            timer: 4000
        });

     });
	</script>
	<?php } //resend confirmation key
	else if($message == "resend"){
	?>
	<script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-check-circle',
            message: "<?php echo lang_key('resend_confirm_key'); ?>"

        },{
            type: 'success',
            timer: 4000
        });

     });
	</script>
	<?php } ?>
	<?php //Success Delete Reply
	$message = $this->session->flashdata('deltop');
	if($message == "confirmdelete"){
	?>
    <script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-check-circle',
            message: "<?php echo lang_key('confirmdelete'); ?>"

        },{
            type: 'success',
            timer: 4000
        });

     });
	</script>
	<?php 
	}
	?>
	
	<?php //Success Delete Post
	$message = $this->session->flashdata('delmytop');
	if($message == "confirmdelete"){
	?>
    <script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-check-circle',
            message: "<?php echo lang_key('confirmdeletepost'); ?>"

        },{
            type: 'success',
            timer: 4000
        });

     });
	</script>
	<?php 
	}
	?>
	<?php //Success Pin Post
	$message = $this->session->flashdata('pinmytop');
	if($message == "confirmpin"){
	?>
    <script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-check-circle',
            message: "<?php echo lang_key('confirmpinpost'); ?>"

        },{
            type: 'success',
            timer: 4000
        });

     });
	</script>
	<?php 
	}
	?>
	<?php //Success Unpin Post
	$message = $this->session->flashdata('unpinmytop');
	if($message == "confirmunpin"){
	?>
    <script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-check-circle',
            message: "<?php echo lang_key('confirmunpinpost'); ?>"

        },{
            type: 'success',
            timer: 4000
        });

     });
	</script>
	<?php 
	}
	?>
	<?php //Success Lock Post
	$message = $this->session->flashdata('lockmytop');
	if($message == "confirmlock"){
	?>
    <script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-check-circle',
            message: "<?php echo lang_key('confirmlockpost'); ?>"

        },{
            type: 'success',
            timer: 4000
        });

     });
	</script>
	<?php 
	}
	?>
	<?php //Success Unock Post
	$message = $this->session->flashdata('unlockmytop');
	if($message == "confirmunlock"){
	?>
    <script type="text/javascript">
       $(document).ready(function(){
        $.notify({
            icon: 'fa fa-check-circle',
            message: "<?php echo lang_key('confirmunlockpost'); ?>"

        },{
            type: 'success',
            timer: 4000
        });

     });
	</script>
	<?php 
	}
	?>
	<!-- NOTIFICATION MESSAGES END-->
	
	
	<!-- google analytics-->
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo get_settings('forum_settings','google_analytics_id',''); ?>"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', '<?php echo get_settings('forum_settings','google_analytics_id',''); ?>');
	</script>
	<!-- google analytics-->
	
	<!-- share this property -->
	<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=<?php echo get_settings('forum_settings','sharethis_property',''); ?>&product=inline-share-buttons"></script>
	
	
	<!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
			<ul class="social-links pull-right">
				<li><a href="https://<?php echo get_settings('forum_settings','fb_page',''); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="https://<?php echo get_settings('forum_settings','tw_page',''); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://<?php echo get_settings('forum_settings','insta_page',''); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                <li><a href="https://<?php echo get_settings('forum_settings','yt_page',''); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
            </ul>
			<p class="m-0 pull-left text-white"><?php echo get_settings('forum_settings','forum_footer_text',''); ?></p><br/>
      </div>
      <!-- /.container -->
    </footer>

  <!-- Recaptcha V2 Js -->
  <script src="https://www.google.com/recaptcha/api.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo base_url();?>/assets/vendor/jquery/validator.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/bootstrap-notify/bootstrap-notify.js"></script>
  <!-- Tags input-->
  <script src="<?php echo base_url();?>/assets/tagsinput/bootstrap-tagsinput.min.js"></script>
  </body>
</html>