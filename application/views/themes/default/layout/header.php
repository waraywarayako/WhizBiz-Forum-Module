<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/logo-nav.css" rel="stylesheet">
	<!-- Buddy Press Forum -->
	<link href="<?php echo base_url();?>assets/css/buddypress.css" rel="stylesheet">
	<!-- Social Login Button -->
	<link href="<?php echo base_url();?>assets/css/bootstrap-social/bootstrap-social.css" rel="stylesheet">
	<!-- Loading Font Awesome Icons -->
	<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
	<!--Tagsinput -->
	<link href="<?php echo base_url(); ?>assets/tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
	<!-- CKeditor -->
	<script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
	<!-- Javascript -->
	<script src="<?php echo base_url();?>assets/vendor/jquery/jquery-2.1.1.min.js"></script>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/splash/android-chrome-192x192.png" sizes="192x192">
	<link rel="apple-touch-icon" sizes="196x196" href="<?php echo base_url(); ?>assets/images/splash/apple-touch-icon-196x196.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/images/splash/apple-touch-icon-180x180.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/images/splash/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/images/splash/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/images/splash/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/images/splash/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/images/splash/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/images/splash/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/images/splash/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>assets/images/splash/apple-touch-icon-57x57.png">  
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/splash/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/splash/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/splash/favicon-16x16.png" sizes="16x16">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/splash/favicon.ico" type="image/x-icon" /> 
	<?php
    preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $desc, $matches);
    $first_img = isset($matches[1]) ? $matches[1] : base_url('/assets/images/social_img.jpg');
	?>
	<meta name="twitter:card" content="photo" />
	<meta name="twitter:site" content="<?php echo $title; ?>" />
	<meta name="twitter:image" content="<?php echo $first_img; ?>" />
	<meta property="og:title" content="<?php echo $title; ?>" />
	<meta property="og:site_name" content="<?php echo get_settings('forum_settings','forum_name',''); ?>" />
	<meta property="og:url" content="<?php echo current_url(); ?>" />
	<meta property="og:description" content="<?php echo strip_tags(word_limiter($desc,30)); ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo $first_img; ?>" />
	<link rel="canonical" href="<?php echo current_url(); ?>"/>
	<meta name="description" content="<?php echo strip_tags(word_limiter($desc,30)); ?>">
    <meta name="keywords" content="<?php echo get_settings('forum_settings','forum_keyword',''); ?>"/>
	<style>
	 a.brand{	
		background-image:url(<?php echo base_url();?>/assets/images/logo.png);
	}
	</style>
 </head>
<body>

	<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="brand" href="<?php echo base_url();?>"><?php echo get_settings('forum_settings','forum_name',''); ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="<?php echo base_url(); ?>"><?php echo lang_key('home'); ?>
                <span class="sr-only">(current)</span>
              </a>
            </li>
			
			<?php if(is_loggedin())
			{ ?>
			<div class="dropdown show">
				<a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				 <?php echo lang_key('welcome_user').get_user_title_by_id($this->session->userdata('user_id')); ?>
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<?php
					if(get_settings('forum_settings','use_ssl','')!='No'){
						$main_url='https://'.get_settings('forum_settings','main_domain','');
					}else{
						$main_url='http://'.get_settings('forum_settings','main_domain','');
					}
					if(get_settings('forum_settings','domain_indexphp','')!='No'){
						$add_listing=$main_url.'/index.php';
					}else{
						$add_listing=$main_url;
					}
					?>
					<a class="dropdown-item" href="<?php echo base_url('account/'.get_username_by_id($this->session->userdata('user_id'))); ?>"><i class="fa fa-user" aria-hidden="true"></i> <?php echo lang_key('profile'); ?></a>
					<a class="dropdown-item" href="<?php echo $add_listing.'/en/list-business'; ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo lang_key('listing'); ?></a>
					<a class="dropdown-item" href="<?php echo base_url('user/logout'); ?>"><i class="fa fa-power-off" aria-hidden="true"></i> <?php echo lang_key('logout'); ?></a>
				</div>
			</div>
			<?php }else{ ?>
			<li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('register'); ?>"><?php echo lang_key('register') ?></a>
            </li>
			<script>
                $(function() {
                 $('#btn-login').click(function() {
                                window.location = '<?php echo base_url('login'); ?>';
                 });
                });
            </script>
			<li class="nav-item">
              <button id="btn-login" class="btn btn-primary btn-mini"><?php echo lang_key('login') ?></button>
            </li>
			<?php } ?>
          </ul>
        </div>
      </div>
    </nav>
	
	<header class="bg-primary text-white">
      <div class="container text-center">
        <h1><?php echo lang_key('forumheader') ?></h1>
        <p class="lead"><?php echo lang_key('forumsubheader') ?></p>
      </div>
    </header>