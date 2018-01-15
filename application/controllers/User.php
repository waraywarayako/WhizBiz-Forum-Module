<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class User extends CI_Controller {
	
	public function __construct()
    {
    	parent::__construct();
		$this->load->helper('url_helper');
		$this->load->model('auth_model');
		$this->load->helper('date');
		$this->load->helper('text');
		$this->load->library('session');
		$this->load->model('user_model');
		$this->load->model('threads_model');
    }
	
	// *************************************************************
    // ************************ Register New Account
    // *************************************************************
	public function register()
	{	
			if(is_loggedin())
			{
			redirect(base_url());
			}
			$this->load->helper('form');
			$this->load->helper('security');
			$this->load->library('form_validation');
		
			$this->form_validation->set_rules('first_name',	'First Name', 		'required|min_length[3]');
			$this->form_validation->set_rules('last_name',	'Last Name', 		'required|min_length[3]');
			$this->form_validation->set_rules('gender',		'Gender', 			'required');
			$this->form_validation->set_rules('username', 	'Username', 		'required|callback_username_check|min_length[6]');


			$this->form_validation->set_rules('company_name','Company Name', 	'xss_clean');
			$this->form_validation->set_rules('phone','Phone', 	'xss_clean');
			$this->form_validation->set_rules('useremail',	'Email Address', 		'required|valid_email|callback_useremail_check');
			$this->form_validation->set_rules('password', 	'Password', 		'required|matches[repassword]|min_length[6]');
			$this->form_validation->set_rules('repassword',	'Retype Password', 			'required');
			//$this->form_validation->set_rules('terms_conditon','Terms and Condition','xss_clean|callback_terms_check');
			
			//recaptcha Validation
			if(get_settings('forum_settings','enable_recaptcha_validation','')!='No'){
				$this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_validate_captcha');
				$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
			}
			
			$data['title'] = lang_key('create_acc');
			$data['desc'] = get_settings('forum_settings','forum_description','');
			
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('themes/default/layout/header',$data);
			$this->load->view('user/register',$data);
			$this->load->view('themes/default/layout/footer');
		}else{
			
			$this->load->library('encrypt');
			

			$userdata['user_type']	= 3;//2 = users

			$userdata['first_name'] = $this->input->post('first_name');
			$userdata['last_name'] 	= $this->input->post('last_name');
			$userdata['gender'] 	= $this->input->post('gender');			
			$userdata['user_name'] 	= $this->input->post('username');
			$userdata['user_email'] = $this->input->post('useremail');
			$userdata['password'] 	= $this->encrypt->sha1($this->input->post('password'));
			$userdata['confirmation_key'] 	= uniqid();
			$userdata['confirmed'] 	= 0;
			$userdata['status']		= 1;
			
			$this->load->model('user_model');
			$user_id = $this->user_model->insert_user_data($userdata);
			
			add_user_meta($user_id,'company_name',$this->input->post('company_name'));
            add_user_meta($user_id,'phone',$this->input->post('phone'));
			
			$this->send_confirmation_email($userdata);
			$msg = 'success';
			$this->session->set_flashdata('regmsg', $msg);
			redirect(base_url('login'));
		}
	}
	
	#terms validation function
	public function terms_check($str)
	{
		$this->load->model('auth_model');		
		if ($_POST['terms_conditon']=='')
		{
			$this->form_validation->set_message('terms_check', 'You must accept terms and condition');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	
	// *************************************************************
    // ************************ Email Account Check
    // *************************************************************

	#Email validation function
	public function useremail_check($str)
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->is_email_exists($str);
		if ($res>0)
		{
			$this->form_validation->set_message('useremail_check', 'Email already in use');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	#recover user function
	public function useremail_match_check($str)
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->is_email_exists($str);
		if ($res<=0)
		{
			$this->form_validation->set_message('useremail_match_check', lang_key('email_not_matched'));
			return FALSE;
		}
		else if(is_banned($str))
		{
			$this->form_validation->set_message('useremail_match_check', lang_key('banned_acc'));
			return FALSE;		
		}
		else if(is_notconfirmed($str))
		{
			$this->form_validation->set_message('useremail_match_check', lang_key('notconfirmed'));
			return FALSE;		
		}
		else
		{
			return TRUE;
		}
	}
	#resend  user confirmation key function
	public function useremail_not__comfirm_check($str)
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->is_email_exists($str);
		if ($res<=0)
		{
			$this->form_validation->set_message('useremail_not__comfirm_check', lang_key('email_not_matched'));
			return FALSE;
		}
		else if(is_banned($str))
		{
			$this->form_validation->set_message('useremail_not__comfirm_check', lang_key('banned_acc'));
			return FALSE;		
		}
		else if(is_confirmed($str))
		{
			$this->form_validation->set_message('useremail_not__comfirm_check', lang_key('isconfirmed'));
			return FALSE;		
		}
		else
		{
			return TRUE;
		}
	}
	
	#Email validation function for update profile
	public function useremail_updateprofile_check($str)
	{
		$this->load->model('auth_model');
		$id = $this->input->post('id');
		$res = $this->auth_model->is_email_exists_for_edit($str,$id);
		if ($res>0)
		{
			$this->form_validation->set_message('useremail_check', 'Email already in use');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	// *************************************************************
    // ************************ Validate Username
    // *************************************************************


	#username validation function
	public function username_check($str)
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->is_username_exists($str);

		if ($res>0)
		{
			$this->form_validation->set_message('username_check', 'Username allready in use');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	#username validation update profile function
	public function username_updateprofile_check($str)
	{
		$this->load->model('auth_model');
		$id 	= $this->input->post('id');
		$res = $this->auth_model->is_username_exists_for_edit($str,$id);

		if ($res>0)
		{
			$this->form_validation->set_message('username_check', 'Username allready in use');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	
	// *************************************************************
    // ************************ Web Admin Name
    // *************************************************************
	
	#get web admin name and email for email sending
	public function get_admin_email_and_name()
	{
		$this->load->model('option_model');
		$values = $this->option_model->getvalues('webadmin_email');

		if(count($values))
		{
			$data['admin_email'] = (isset($values->webadmin_email))?$values->webadmin_email:'admin@'.$_SERVER['HTTP_HOST'];
			$data['admin_name']  = (isset($values->webadmin_name))?$values->webadmin_name:'Admin';
		}
		else
		{
			$data['admin_email'] = 'admin@'.$_SERVER['HTTP_HOST'];
			$data['admin_name']  = 'Admin';		
		}

		return $data;
	}

	// *************************************************************
    // ************************ Email Acount Confirmation Link
    // *************************************************************	
	
	#send a confirmation email with confirmation link
	public function send_confirmation_email($data=array('username'=>'sc mondal','useremail'=>'shimulcsedu@gmail.com','confirmation_key'=>'1234'))
	{
		$val = $this->get_admin_email_and_name();
		$admin_email = $val['admin_email'];
		$admin_name  = $val['admin_name'];
		
		$link = get_mainsite_url().'/account/confirm/'.$data['user_email'].'/'.$data['confirmation_key']; 
		$this->load->model('system_model');
		$tmpl = $this->system_model->get_email_tmpl_by_email_name('confirmation_email');
		$subject = $tmpl->subject;
		$subject = str_replace("#username",$data['username'],$subject);
		$subject = str_replace("#activationlink",$link,$subject);
		$subject = str_replace("#webadmin",$admin_name,$subject);
		$subject = str_replace("#useremail",$data['user_email'],$subject);

		
		$body = $tmpl->body;
		$body = str_replace("#username",$data['username'],$body);
		$body = str_replace("#activationlink",$link,$body);
		$body = str_replace("#webadmin",$admin_name,$body);
		$body = str_replace("#useremail",$data['user_email'],$body);

				
		$this->load->library('email');
		$this->email->from($admin_email, $admin_name);
		$this->email->to($data['user_email']);
		$this->email->subject($subject);		
		$this->email->message($body);		
		$this->email->send();
	}
	
	
	// *************************************************************
    // ************************ Login Account
    // *************************************************************	
	
	
	#check login from login form
	public function login()
	{
		if(is_loggedin())
		{
			redirect(base_url());
		}
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('useremail','Email','required|xss_clean');
		$this->form_validation->set_rules('password','Password','required|xss_clean');
		$data['title'] = lang_key('login');
		$data['desc'] = get_settings('forum_settings','forum_description','');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('themes/default/layout/header',$data);
			$this->load->view('user/login',$data);
			$this->load->view('themes/default/layout/footer');
		}
		else
		{
			$this->load->model('auth_model');
			$query = $this->auth_model->check_login($this->input->post('useremail'),$this->input->post('password'),'result');
			if($query->num_rows()>0)
			{			
				$row = $query->row();
				if($row->banned==1)
				{
					$logmsg = 'banned';
					$this->session->set_flashdata('logmsg', $logmsg);
					redirect(base_url('login'));
				}
				else if($row->confirmed!=1)
				{
					$logmsg = 'notconfirmed';
					$this->session->set_flashdata('logmsg', $logmsg);
					redirect(base_url('login'));
				}
				else
				{
					$this->session->set_userdata('user_id',$row->id);
					$this->session->set_userdata('user_name',$row->user_name);
					$this->session->set_userdata('user_type',$row->user_type);
					$this->session->set_userdata('user_email',$this->input->post('useremail'));
					$logmsg = 'successlog';
					$this->session->set_flashdata('logmsg', $logmsg);	
					if($this->session->userdata('req_url')!='')
					{
						$req_url = $this->session->userdata('req_url');
						$this->session->set_userdata('req_url','');
						redirect($req_url);
					}
					redirect(base_url());
				}
			}
			else
			{	
				$logmsg = 'incorrect';
				$this->session->set_flashdata('logmsg', $logmsg);	
				redirect(base_url('login'));
			}
		}
	}
	// *************************************************************
    // ************************ Social Login
    // *************************************************************
	
	#controls different signup method routing
	function newaccount($type='',$user_type='business')
	{
		if(is_loggedin())
		{
			redirect(base_url());
		}

		if(get_settings('business_settings','enable_signup','Yes')=='No')
		{
			redirect(base_url());
		}

		if($user_type=='business')
		$this->session->set_userdata('signup_user_type',2);
		else
		$this->session->set_userdata('signup_user_type',3);

		if($type=='fb')
			redirect(base_url('user/fbauth'));

		else if($type=='google_plus')
		{
			redirect(base_url('user/google_plus_auth'));
		}
	}
	
	// *************************************************************
    // ************************ Facebook Login
    // *************************************************************	
	
	//fbauth
	public function fbauth()
	{
		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
		$CI 	= & get_instance();
		$appId 	= get_settings('business_settings','fb_app_id','none');
		$secret = get_settings('business_settings','fb_secret_key','none');
        $config = array('appId'=>$appId,'secret'=>$secret);
        $this->load->library('Facebook', $config);
		
		// Try to get the user's id on Facebook
		$userId = $this->facebook->getUser();
		
		// If user is not yet authenticated, the id will be zero
		if($userId == 0){
			// Generate a login url
			$data['url'] = $this->facebook->getLoginUrl(array('scope'=>'email')); 
			redirect($data['url']);
		} else {
			// Get user's data and print it
			$user = $this->facebook->api('/v2.1/me?fields=first_name,last_name,email,gender,picture');

			if(empty($user['email']))
			{
				$logmsg = 'emailnotshared';
				$this->session->set_flashdata('logmsg', $logmsg);
				redirect(base_url('register'));
			}
			//end

			$user['username']= $user['id'];
			
			$this->load->model('auth_model');

			$row = $this->auth_model->register_user_if_not_exists($user);			

			if(is_banned($row['user_email']))
			{
				$logmsg = 'banned';
				$this->session->set_flashdata('logmsg', $logmsg);
				redirect(base_url('login'));			
			}
			else
			{
				$this->fblogin($row);			
			}
		}
	}
	
	//fblogin
	function fblogin($row)
	{
		$this->session->set_userdata('user_id',$row['id']);
		$this->session->set_userdata('user_name',$row['user_name']);
		$this->session->set_userdata('user_type',$row['user_type']);
		$this->session->set_userdata('user_email',$row['user_email']);
		
		$logmsg = 'successlog';
		$this->session->set_flashdata('logmsg', $logmsg);
		redirect(site_url());
	}
	// *************************************************************
    // ************************ Google Login
    // *************************************************************
	public function google_plus_auth()
	{
		$this->load->library('session');
		$this->load->library('googleplus');
		if($this->session->userdata('user_name'))
		{
			echo 'name: '.$this->session->userdata('user_name');
		}
		
		else
		{
			$authUrl = $this->googleplus->client->createAuthUrl();
			redirect($authUrl);
		}

	}
	
	public function auth_callback()
	{
		$this->load->library('session');
		$this->load->library('googleplus');
		
		try
		{
			if (isset($_GET['code']))
			{
				$this->googleplus->client->authenticate($_GET['code']);
				$this->googleplus->client->getAccessToken();
				$user_data = $this->googleplus->plus->people->get('me');
				
				$user['first_name'] = $user_data['name']['givenName'];
				$user['last_name'] 	= $user_data['name']['familyName'];
				$user['gender'] 	= ($user_data['gender']!='')?$user_data['gender']:'male';
				$user['username'] 	= strstr($user_data['emails']['0']['value'], '@', true);
				$user['email'] 		= $user_data['emails']['0']['value'];

				$this->load->model('auth_model');

				$row = $this->auth_model->register_user_if_not_exists($user,'google');

				if(is_banned($row['user_email']))
				{
					$logmsg = 'banned';
					$this->session->set_flashdata('logmsg', $logmsg);
					redirect(base_url('login'));			
				}
				else
				{							

					$this->session->set_userdata('user_id',$row['id']);
					$this->session->set_userdata('user_name',$row['user_name']);
					$this->session->set_userdata('user_type',$row['user_type']);
					$this->session->set_userdata('user_email',$row['user_email']);
					if($this->session->userdata('req_url')!='')
					{
						$req_url = $this->session->userdata('req_url');
						$this->session->set_userdata('req_url','');
						$logmsg = 'successlog';
						$this->session->set_flashdata('logmsg', $logmsg);
						redirect($req_url);
					}
					else
						$logmsg = 'successlog';
						$this->session->set_flashdata('logmsg', $logmsg);
						redirect(base_url());
					
				}
			}
		}
		catch(Exception $e)
		{
			echo '<pre>';
			print_r($e);
			die;
			
			$msg = '<div class="alert alert-danger">
			        	<button data-dismiss="alert" class="close" type="button">×</button>
			        	<strong><pre>'.($e).'</pre></strong>
			    	</div>';
			$this->session->set_flashdata('msg', $msg);					
			redirect(base_url('login'));
		}
	}
	
	// *************************************************************
    // ************************ Session Destroyed/Logout
    // *************************************************************	
	
	#logout a user
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
	
	// *************************************************************
    // ************************ Recover Password
    // *************************************************************
	public function recover()
	{
		if(is_loggedin())
		{
			redirect(base_url());
		}
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->library('form_validation');
		
		$data['title'] = lang_key('recover_acc');
		$data['desc'] = get_settings('forum_settings','forum_description','');
		
		$this->form_validation->set_rules('useremail',	'Email Address', 'required|callback_useremail_match_check');
		
		//recaptcha validation
		if(get_settings('forum_settings','enable_recaptcha_validation','')!='No'){
			$this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_validate_captcha');
			$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('themes/default/layout/header',$data);
			$this->load->view('user/recover',$data);
			$this->load->view('themes/default/layout/footer');
		}
		else
		{
			$user_email = $this->input->post('useremail');
			$val = $this->auth_model->set_recovery_key($user_email);
			$this->_send_recovery_email($val);
			$logmsg = 'recover';
			$this->session->set_flashdata('logmsg', $logmsg);
			redirect(base_url());	
		}
	}
	
	// *************************************************************
    // ************************ Send Email Recovery
    // *************************************************************
	function _send_recovery_email($data)
	{
		$val = $this->get_admin_email_and_name();
		$admin_email = $val['admin_email'];
		$admin_name  = $val['admin_name'];
		
		$link = get_mainsite_url().'/account/resetpassword/'.$data['user_email'].'/'.$data['recovery_key'];
		$this->load->model('system_model');
		$tmpl = $this->system_model->get_email_tmpl_by_email_name('recovery_email');
		$subject = $tmpl->subject;
		$subject = str_replace("#username",$data['username'],$subject);
		$subject = str_replace("#recoverylink",$link,$subject);
		$subject = str_replace("#webadmin",$admin_name,$subject);

		$body = $tmpl->body;
		$body = str_replace("#username",$data['username'],$body);
		$body = str_replace("#recoverylink",$link,$body);
		$body = str_replace("#webadmin",$admin_name,$body);
		
		$this->load->library('email');
		$this->email->from($admin_email, $admin_name);
		$this->email->to($data['user_email']);
		$this->email->subject($subject);	
		$this->email->message($body);			
		$this->email->send();
	}
	
	// *************************************************************
    // ************************ Resend confirmation key
    // *************************************************************
	public function resend()
	{
		if(is_loggedin())
		{
			redirect(base_url());
		}
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->library('form_validation');
		
		$data['title'] = lang_key('resend');
		$data['desc'] = get_settings('forum_settings','forum_description','');
		
		$this->form_validation->set_rules('useremail',	'Email Address', 'required|callback_useremail_not__comfirm_check');
		
		//recaptcha validation
		if(get_settings('forum_settings','enable_recaptcha_validation','')!='No'){
			$this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_validate_captcha');
			$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('themes/default/layout/header',$data);
			$this->load->view('user/resend',$data);
			$this->load->view('themes/default/layout/footer');
		}
		else
		{
			$user_email = $this->input->post('useremail');
			$val = $this->auth_model->get_confirm_key($user_email);
			$this->_resend_confirmation_key_email($val);
			$logmsg = 'resend';
			$this->session->set_flashdata('logmsg', $logmsg);
			redirect(base_url());	
		}
	}
	
	// *************************************************************
    // ************************ Resend confirmation key
    // *************************************************************
	function _resend_confirmation_key_email($data)
	{
		$val = $this->get_admin_email_and_name();
		$admin_email = $val['admin_email'];
		$admin_name  = $val['admin_name'];
		
		$link = get_mainsite_url().'/account/confirm/'.$data['user_email'].'/'.$data['confirmation_key']; 
		
		$this->load->model('system_model');
		$tmpl = $this->system_model->get_email_tmpl_by_email_name('confirmation_email');
		$subject = $tmpl->subject;
		$subject = str_replace("#username",$data['user_name'],$subject);
		$subject = str_replace("#activationlink",$link,$subject);
		$subject = str_replace("#webadmin",$admin_name,$subject);
		$subject = str_replace("#useremail",$data['user_email'],$subject);

		
		$body = $tmpl->body;
		$body = str_replace("#username",$data['user_name'],$body);
		$body = str_replace("#activationlink",$link,$body);
		$body = str_replace("#webadmin",$admin_name,$body);
		$body = str_replace("#useremail",$data['user_email'],$body);

				
		$this->load->library('email');
		$this->email->from($admin_email, $admin_name);
		$this->email->to($data['user_email']);
		$this->email->subject($subject);		
		$this->email->message($body);		
		$this->email->send();
	}
	
	// *************************************************************
    // ************************ User Information
    // *************************************************************	
	public function account($slug){
		$data['account'] = $this->user_model->get_user_info(get_user_id_by_username($slug));
		if(empty($data['account'])) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 
			$data['title'] = get_user_fullname_from_username($slug);
			$data['desc'] = get_user_meta(get_user_id_by_username($slug), 'about_me');
			$this->load->view('themes/default/layout/header',$data);
			$this->load->view('user/account',$data);
			$this->load->view('themes/default/layout/footer');
		}
	}
	
	// *************************************************************
    // ************************ Edit User Information
    // *************************************************************	
	public function edit($slug){
		$this->load->helper('form');
		$this->load->library('form_validation');
		if(is_notloggedin())
		{
			redirect(base_url());
		}
		
		if(get_user_id_by_username($slug) != $this->session->userdata('user_id'))
		{
			$nopermission = 'nopermission';
			$this->session->set_flashdata('nopermission', $nopermission);
			redirect(base_url());
		}
		
		$data['account'] = $this->user_model->get_user_info(get_user_id_by_username($slug));
		if(empty($data['account'])) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 
			$this->form_validation->set_rules('first_name',	'First Name', 		'required|xss_clean');
			$this->form_validation->set_rules('last_name',	'last Name', 		'required|xss_clean');
			$this->form_validation->set_rules('gender',		'Gender', 			'required|xss_clean');


			//$this->form_validation->set_rules('username', 	'Username', 		'required|callback_username_updateprofile_check|xss_clean');
			$this->form_validation->set_rules('useremail', 	'Email', 		'required|valid_email|callback_useremail_updateprofile_check|xss_clean');
			$this->form_validation->set_rules('signature', 	'Signature', 		'min_length[30]|max_length[500]');
			
			

			if($this->input->post('password')!='' || $this->input->post('confirm_password')!='')
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|xss_clean');
		
			if ($this->form_validation->run() === FALSE) {
				$data['title'] = get_user_fullname_from_username($slug);
				$data['desc'] = get_user_meta(get_user_id_by_username($slug), 'about_me');
				$this->load->view('themes/default/layout/header',$data);
				$this->load->view('user/edit',$data);
				$this->load->view('themes/default/layout/footer');
			}else{
				$id = $this->input->post('id');
				//$userdata['profile_photo'] 	= $this->input->post('profile_photo');
				$userdata['first_name'] 	= $this->input->post('first_name');
				$userdata['last_name'] 		= $this->input->post('last_name');
				$userdata['gender'] 		= $this->input->post('gender');
				//$userdata['user_name'] 		= $this->input->post('username');
				$userdata['user_email'] 	= $this->input->post('useremail');

				if($this->input->post('password')!='') 
				{
					$this->load->library('encrypt');
					$userdata['password'] 	= $this->encrypt->sha1($this->input->post('password'));
				}
				add_user_meta($id,'company_name',$this->input->post('company_name'));
				add_user_meta($id,'phone',$this->input->post('phone'));
				add_user_meta($id,'about_me',$this->input->post('about_me'));
				add_user_meta($id,'fb_profile',$this->input->post('fb_profile'));
				add_user_meta($id,'twitter_profile',$this->input->post('twitter_profile'));
				add_user_meta($id,'li_profile',$this->input->post('li_profile'));
				add_user_meta($id,'gp_profile',$this->input->post('gp_profile'));
				add_user_meta($id,'hide_email',$this->input->post('hide_email'));
				add_user_meta($id,'hide_phone',$this->input->post('hide_phone'));
				add_user_meta($id,'signature',$this->input->post('signature'));

				$this->user_model->update_profile($userdata,$id);
				$msg = 'successupdateprofile';
				$this->session->set_flashdata('updateprofilemsg', $msg);
				redirect(base_url('edit/'.$slug));		
			}
		}	
	}
	
	// *************************************************************
    // ************************ User Information
    // *************************************************************	
	
	//get user topic post
	public function get_topic($user_id='')
    {
		$this->load->helper('text');
		$page = $_GET['page'];
        $items_per_page = get_settings('forum_settings','posts_per_page',10);
		$posts = $this->user_model->get_userpost($user_id, $items_per_page, $page);
		if ($posts->num_rows() < $items_per_page) {
			$msg = 'done';
		} else {
			$msg = 'success';
		}
		if ($posts->num_rows() > 0) {
			$body = $this->load->view('themes/default/user/user_topic_post', array('posts' => $posts), true);
		} else {
			$body = '<tr><th scope="row"></th><td colspan="3"><div class="alert alert-warning">'.lang_key('no_posts').'</div><td></tr>';
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('msg' => $msg, 'body' => $body)));
		$this->output->_display();
		exit;
    }
	
	//get user replies topic post
	public function get_replytopic($user_id='')
    {
		$this->load->helper('text');
		$page = $_GET['page'];
		$items_comment_per_page = get_settings('forum_settings','posts_per_page',10);
		$posts = $this->user_model->get_userreply($user_id, $items_comment_per_page, $page);
		if ($posts->num_rows() < $items_comment_per_page) {
			$msg = 'show';
		} else {
			$msg = 'success';
		}
		if ($posts->num_rows() > 0) {
			$body = $this->load->view('themes/default/user/user_topic_reply', array('posts' => $posts), true);
		} else {
			$body = '<tr><th scope="row"></th><td><div class="alert alert-warning">'.lang_key('no_posts').'</div><td></tr>';
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('msg' => $msg, 'body' => $body)));
		$this->output->_display();
		exit;
    }
	
	//get user business listing post
	public function get_listing($user_id='')
    {
		$this->load->helper('text');
		$page = $_GET['page'];
        $items_per_page = get_settings('forum_settings','posts_per_page',10);
		$posts = $this->user_model->get_userlistingpost($user_id, $items_per_page, $page);
		if ($posts->num_rows() < $items_per_page) {
			$msg = 'listing';
		} else {
			$msg = 'success';
		}
		if ($posts->num_rows() > 0) {
			$body = $this->load->view('themes/default/user/user_listing_post', array('posts' => $posts), true);
		} else {
			$body = '<tr><th scope="row"></th><td colspan="3"><div class="alert alert-warning">'.lang_key('no_posts').'</div><td></tr>';
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('msg' => $msg, 'body' => $body)));
		$this->output->_display();
		exit;
    }
	
	// *************************************************************
    // ************************ recaptcha Validation
    // *************************************************************
	function validate_captcha() {
        $captcha = $this->input->post('g-recaptcha-response');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".get_settings('forum_settings','recaptcha_secretkey','')."&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        
        if ($response . 'success' == false) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


}