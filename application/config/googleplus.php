<?php
//updated on version 1.7
$config['googleplus']['application_name'] = 'whizbiz';
$config['googleplus']['client_id'] = get_settings('business_settings','gplus_app_id','');
$config['googleplus']['client_secret'] = get_settings('business_settings','gplus_secret_key','');
$config['googleplus']['redirect_uri'] = site_url('user/auth_callback');
$config['googleplus']['api_key'] = '';
?>