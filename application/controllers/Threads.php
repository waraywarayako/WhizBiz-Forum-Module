<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Threads extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
        parent::__construct();
		$this->load->helper('url_helper');
		$this->load->model('threads_model');
		$this->load->model('topic_model');
		$this->load->helper('text');
		$this->load->helper('date');
		$this->load->library('session');
    }
	public function index()
	{
		$data['title'] = get_settings('forum_settings','forum_name','');
        $data['desc'] = get_settings('forum_settings','forum_description','');
		$data['parent_categories'] = $this->threads_model->getAllParentThreadsCategories();
		
		$this->load->view('themes/default/layout/header',$data);
        $this->load->view('index',$data);
        $this->load->view('themes/default/layout/footer');
	}
	
	
	// *************************************************************
    // ************************ Threads Cat View
    // *************************************************************
	// category
    public function threadsview($slug=null, $offset=0) {
        // get threads category
		$this->load->helper('form');
        $this->load->library('form_validation');
		$this->load->library('pagination');
		
        $data['item'] = $this->threads_model->getThreadsCategory($slug);
		if($data['item']->num_rows()<=0){
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
			$this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
		}else
		foreach ($data['item']->result() as $res) {
			
        
        $data['title'] = $res->catname;
        $data['desc'] = $res->description;
		
		$cat_id = get_category_id_by_slug($slug);
		$total =  get_settings('forum_settings','posts_per_page',10); // total result x page

        // Config setup
        $num_rows = $this->threads_model->getAllThreadsPost($cat_id); // get all threads post per category
        $config['base_url'] = base_url().'threadsview/'.$slug;
        $config['total_rows'] = $num_rows;
        $config['per_page'] = $total;
        $config['num_links'] = $num_rows;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        
        if ($this->input->get('page') != null) {
            $offset = ($this->input->get('page') - 1) * $config['per_page'];
        }
        
        $this->pagination->initialize($config);
        $data['threads_post'] = $this->threads_model->AllThreadsPost($cat_id, $config['per_page'], $offset);
		
        $this->load->view('themes/default/layout/header', $data);
        $this->load->view('threads/threadsview', $data);
        $this->load->view('themes/default/layout/footer');
		}
	}
	
	
	// *************************************************************
    // ************************ Threads Topic View
    // *************************************************************
	// single topic view
    public function topic($slug = NULL, $offset=0) {
		
		$this->load->library('pagination');
        // get single topic
        $data['item'] = $this->topic_model->getTopic($slug);
        if(empty($data['item'])) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 
		
        $data['title'] = $data['item']['title'];
        $data['desc'] = $data['item']['content'];
		//Start Pagination
		$topic_id = get_topic_id_by_slug($slug);
		$total =  get_settings('forum_settings','posts_per_page',10); // total result x page

        // Config setup
        $num_rows = $this->topic_model->getAllReplyThreadsPost($topic_id); // count active secrets in cat
        $config['base_url'] = base_url().'topic/'.$slug;
        $config['total_rows'] = $num_rows;
        $config['per_page'] = $total;
        $config['num_links'] = $num_rows;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        
        if ($this->input->get('page') != null) {
            $offset = ($this->input->get('page') - 1) * $config['per_page'];
        }
        
        $this->pagination->initialize($config);
		
		
		$data['topicreply'] = $this->topic_model->AllReplyThreadsPost($topic_id, $config['per_page'], $offset);
        $this->load->view('themes/default/layout/header', $data);
        $this->load->view('threads/topic', $data);
        $this->load->view('themes/default/layout/footer');
		$this->add_view($slug);
		}
	}
	// add views
    public function add_view($slug) {
        $this->load->helper('cookie');
        $check_visitor = $this->input->cookie(urldecode($slug), FALSE);
        $ip = $this->input->ip_address(); // ip address
        
        if ($check_visitor == false) {
            $cookie = array(
                "name"   => urldecode($slug),
                "value"  => "$ip",
                "expire" =>  time() + 7200,
                "secure" => false
            );
            $this->input->set_cookie($cookie); // set cookie 
            $this->topic_model->update_topicview(urldecode($slug)); // update count views
        }
    }
	
	// *************************************************************
    // ************************ Create New Threads
    // *************************************************************
    public function create() {
		
        $this->load->helper('form');
        $this->load->library('form_validation');

		
        $data['title'] = lang_key('create_new_topic');
        $data['desc'] = '';
        
        $this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[100]|callback_title_check');
        $this->form_validation->set_rules('slug', 'Slug', 'required|min_length[5]|max_length[100]|callback_slug_check');
        $this->form_validation->set_rules('text', 'Topic Content', 'required|min_length[50]|max_length[5000]');
        $this->form_validation->set_rules('category', 'Category', 'required');
		
		//recaptcha Validation
		if(get_settings('forum_settings','enable_recaptcha_validation','')!='No'){
			$this->form_validation->set_rules('g-recaptcha-response', 'reCaptcha validation', 'required|callback_validate_captcha');
			$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
		}
		
		$cat_value = $this->input->post('category');
		if(empty($cat_value)) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 

			if ($this->form_validation->run() === FALSE) {
			
				$this->load->view('themes/default/layout/header', $data);
				$this->load->view('threads/create', $data);
				$this->load->view('themes/default/layout/footer');
			} else {
				$this->threads_model->insertNewThreads();
				$data['parent_categories'] = $this->threads_model->getAllParentThreadsCategories();
				$data['title'] = lang_key('topic_success');
				$slug = $this->input->post('slug');
				$data['redirect_link'] = base_url('topic/'.$slug);
				$this->load->view('themes/default/layout/header', $data);
				$this->load->view('index',$data);
				$this->load->view('themes/default/success');
				$this->load->view('themes/default/layout/footer');
			}
		}
    }
	
	// *************************************************************
    // ************************ Check Topic
    // *************************************************************
	#check topic if exist
	public function title_check($str)
	{
		$res = $this->threads_model->is_topic_exists($str);
		if ($res>0)
		{
			$this->form_validation->set_message('title_check', 'The Topic Name is already exist');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	#check slug if exist
	public function slug_check($str)
	{
		$res = $this->threads_model->is_slug_exists($str);
		if ($res>0)
		{
			$this->form_validation->set_message('slug_check', 'The topic URL is already exist');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	// *************************************************************
    // ************************ Edit Threads View
    // *************************************************************
	public function load_editpost($id='') {
		if(get_topic_lock_stat_by_id($id) != '0'){
			$nopermission = 'nopermission';
			$this->session->set_flashdata('nopermission', $nopermission);
			redirect(base_url());
		}else{
		
			if(get_edit_topic_user_id_by_id($id) != $this->session->userdata('user_id') && get_user_role_by_id($this->session->userdata('user_id')) != '1') 
			{
				$nopermission = 'nopermission';
				$this->session->set_flashdata('nopermission', $nopermission);
				redirect(base_url());
			}
		
			if(empty($id)) {
				$data['title'] = lang_key('404errorheader');
				$data['desc'] = lang_key('404errordesc');
				$this->load->view('themes/default/layout/header', $data);
				$this->load->view('errors/html/error_404');
				$this->load->view('themes/default/layout/footer');
			}else{ 
				$this->load->helper('form');
				$this->load->library('form_validation');
				$data['id'] = $id;
				$this->load->view('themes/default/threads/edit_topic_post',$data);
			}
		}
	}
	public function saveeditpost() {
		$id = $this->input->post('id');
		if(empty($id)) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 
			$this->load->helper('form');
			$this->load->library('form_validation');
		
			$this->form_validation->set_rules('post', 'Threads Content Field Required', 'required|min_length[50]');
			
			//recaptcha Validation
			if(get_settings('forum_settings','enable_recaptcha_validation','')!='No'){
				$this->form_validation->set_rules('g-recaptcha-response', 'reCaptcha validation', 'required|callback_validate_captcha');
				$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
			}
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load_editpost($id);
			}
			//else (get_edit_topic_content_by_id($id) == $this->input->post('post')){
				//$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang_key('no_changes_on_threads').'</div>');
				//$this->load_editpost($id);
			//}
			else{
				$updateeditpost = array(
                'id' => $id,
                'content' => $this->input->post('post'),
                'tags' => $this->input->post('tags'),
                'updated_at' => time()
				);
				$this->topic_model->updatePostTopic($updateeditpost);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('saveedittopic_success').'</div>');
				$this->load_editpost($id);
			}
		}
	}
	
	// *************************************************************
    // ************************ Delete Threads View
    // *************************************************************
	
	public function deleteposttopic($id='') {
		if(get_edit_topic_user_id_by_id($id) != $this->session->userdata('user_id') && get_user_role_by_id($this->session->userdata('user_id')) != '1') 
		{
		$nopermission = 'nopermission';
		$this->session->set_flashdata('nopermission', $nopermission);
		redirect(base_url());
		}
		if(empty($id)) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 
				if(get_topic_lock_stat_by_id($id) != '0'){
					$nopermission = 'nopermission';
					$this->session->set_flashdata('nopermission', $nopermission);
					redirect(base_url());
				}else{
					$deletepost = array(
					'id' => $id,
					'status' => 0
					);
					$delmytop = 'confirmdelete';
					$this->session->set_flashdata('delmytop', $delmytop);	
					$this->topic_model->deletePostTopic($deletepost);
					redirect(base_url());
				}
		}
	}
	// *************************************************************
    // ************************ Pin Lock Post Threads View
    // *************************************************************
	
	//pin post
	public function pinposttopic($id='') {
		if(get_user_role_by_id($this->session->userdata('user_id')) != '1') 
		{
		$nopermission = 'nopermission';
		$this->session->set_flashdata('nopermission', $nopermission);
		redirect(base_url('topic/'.get_topic_slug_by_id(get_topic_id_by_id($id))));
		}
		if(empty($id)) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 
				$pinpost = array(
                'id' => $id,
                'pin_post' => 1
				);
				$pinmytop = 'confirmpin';
				$this->session->set_flashdata('pinmytop', $pinmytop);	
				$this->topic_model->pinPostTopic($pinpost);
				redirect(base_url('topic/'.get_topic_slug_by_id($id)));
		}
	}
	
	//unpin post
	public function unpinposttopic($id='') {
		if(get_user_role_by_id($this->session->userdata('user_id')) != '1') 
		{
		$nopermission = 'nopermission';
		$this->session->set_flashdata('nopermission', $nopermission);
		redirect(base_url('topic/'.get_topic_slug_by_id(get_topic_id_by_id($id))));
		}
		if(empty($id)) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 
				$unpinpost = array(
                'id' => $id,
                'pin_post' => 0
				);
				$unpinmytop = 'confirmunpin';
				$this->session->set_flashdata('unpinmytop', $unpinmytop);	
				$this->topic_model->pinPostTopic($unpinpost);
				redirect(base_url('topic/'.get_topic_slug_by_id($id)));
		}
	}
	
	//lock post
	public function lockposttopic($id='') {
		if(get_user_role_by_id($this->session->userdata('user_id')) != '1') 
		{
		$nopermission = 'nopermission';
		$this->session->set_flashdata('nopermission', $nopermission);
		redirect(base_url('topic/'.get_topic_slug_by_id(get_topic_id_by_id($id))));
		}
		if(empty($id)) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 
				$lockpost = array(
                'id' => $id,
                'lock_post' => 1
				);
				$lockmytop = 'confirmlock';
				$this->session->set_flashdata('lockmytop', $lockmytop);	
				$this->topic_model->pinPostTopic($lockpost);
				redirect(base_url('topic/'.get_topic_slug_by_id($id)));
		}
	}
	
	//unlock post
	public function unlockposttopic($id='') {
		if(get_user_role_by_id($this->session->userdata('user_id')) != '1') 
		{
		$nopermission = 'nopermission';
		$this->session->set_flashdata('nopermission', $nopermission);
		redirect(base_url('topic/'.get_topic_slug_by_id($id)));
		}
		if(empty($id)) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 
				$unlockpost = array(
                'id' => $id,
                'lock_post' => 0
				);
				$unlockmytop = 'confirmunlock';
				$this->session->set_flashdata('unlockmytop', $unlockmytop);	
				$this->topic_model->pinPostTopic($unlockpost);
				redirect(base_url('topic/'.get_topic_slug_by_id($id)));
		}
	}
	
	// *************************************************************
    // ************************ Reply to topic
    // *************************************************************
	public function load_reply_to_topic_view($topic_id='')
	{
		if(get_topic_lock_stat_by_id($topic_id) != '0'){
			$nopermission = 'nopermission';
			$this->session->set_flashdata('nopermission', $nopermission);
			redirect(base_url());
		}else{
			if(empty($topic_id) or empty($this->session->userdata('user_id'))) {
				$data['title'] = lang_key('404errorheader');
				$data['desc'] = lang_key('404errordesc');
				$this->load->view('themes/default/layout/header', $data);
				$this->load->view('errors/html/error_404');
				$this->load->view('themes/default/layout/footer');
			}else{ 
				$this->load->helper('form');
				$this->load->library('form_validation');
				$value['topic_id'] = $topic_id;
				$this->load->view('themes/default/threads/replytopic',$value);
			}
		}
	}
	
	public function reply_topic()
    {	
		$topic_id = $this->input->post('topic_id');
		if(empty($topic_id)) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('comment', 'Comment Field Required', 'required|min_length[50]');
			
			//recaptcha Validation
			if(get_settings('forum_settings','enable_recaptcha_validation','')!='No'){
				$this->form_validation->set_rules('g-recaptcha-response', 'reCaptcha Validation', 'required|callback_validate_captcha');
				$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
			}
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load_reply_to_topic_view($this->input->post('topic_id'));
			}
			else
			{
            $topic_id = $this->input->post('topic_id');
            $this->topic_model->postReplyTopic();
            echo '<div class="alert alert-success">'.lang_key('reply_submited').'</div>';
            $this->load_reply_to_topic_view($topic_id);
			}
		}
    }
	
	// *************************************************************
    // ************************ Edit Reply View
    // *************************************************************
	public function load_editreply($id='') {
		if(get_topic_lock_stat_by_id(get_topic_id_by_id($id)) != '0'){
			$nopermission = 'nopermission';
			$this->session->set_flashdata('nopermission', $nopermission);
			redirect(base_url());
		}else{
			if(get_edit_reply_user_id_by_id($id) != $this->session->userdata('user_id') && get_user_role_by_id($this->session->userdata('user_id')) != '1') 
			{
			$nopermission = 'nopermission';
			$this->session->set_flashdata('nopermission', $nopermission);
			redirect(base_url());
			}
		
			if(empty($id)) {
				$data['title'] = lang_key('404errorheader');
				$data['desc'] = lang_key('404errordesc');
				$this->load->view('themes/default/layout/header', $data);
				$this->load->view('errors/html/error_404');
				$this->load->view('themes/default/layout/footer');
			}else{ 
				$this->load->helper('form');
				$this->load->library('form_validation');
				$data['id'] = $id;
				$this->load->view('themes/default/threads/editreply',$data);
			}
		}
	}
	public function saveeditreply() {
		$id = $this->input->post('id');
		if(empty($id)) {
			$data['title'] = lang_key('404errorheader');
			$data['desc'] = lang_key('404errordesc');
            $this->load->view('themes/default/layout/header', $data);
			$this->load->view('errors/html/error_404');
			$this->load->view('themes/default/layout/footer');
        }else{ 
			$this->load->helper('form');
			$this->load->library('form_validation');
		
			$this->form_validation->set_rules('comment', 'Comment Field Required', 'required|min_length[50]');
			if(get_settings('forum_settings','enable_recaptcha_validation','')!='No'){
				$this->form_validation->set_rules('g-recaptcha-response', 'reCaptcha Validation', 'required|callback_validate_captcha');
				$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
			}
			if ($this->form_validation->run() == FALSE)
			{
				$this->load_editreply($id);
			}elseif (get_edit_reply_content_by_id($id) == $this->input->post('comment')){
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang_key('no_changes_on_comment').'</div>');
				$this->load_editreply($id);
			}else{
				$updateedit = array(
                'id' => $id,
                'comment_content' => $this->input->post('comment'),
                'updated_at' => time()
				);
				$this->topic_model->updateReplyTopic($updateedit);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('saveeditreply_success').'</div>');
				$this->load_editreply($id);
			}
		}
	}
	
	
	// *************************************************************
    // ************************ Delete Reply View
    // *************************************************************
	
	public function deletereplytopic($id='') {
		if(get_topic_lock_stat_by_id(get_topic_id_by_id($id)) != '0'){
			$nopermission = 'nopermission';
			$this->session->set_flashdata('nopermission', $nopermission);
			redirect(base_url());
		}else{
			if(get_edit_reply_user_id_by_id($id) != $this->session->userdata('user_id') && get_user_role_by_id($this->session->userdata('user_id')) != '1') 
			{
				$nopermission = 'nopermission';
				$this->session->set_flashdata('nopermission', $nopermission);
				redirect(base_url());
			}
			if(empty($id)) {
				$data['title'] = lang_key('404errorheader');
				$data['desc'] = lang_key('404errordesc');
				$this->load->view('themes/default/layout/header', $data);
				$this->load->view('errors/html/error_404');
				$this->load->view('themes/default/layout/footer');
			}else{ 
				$deletereply = array(
                'id' => $id,
                'status' => 0
				);
				$deltop = 'confirmdelete';
				$this->session->set_flashdata('deltop', $deltop);	
				$this->topic_model->deleteReplyTopic($deletereply);
				redirect(base_url('topic/'.get_topic_slug_by_id(get_topic_id_by_id($id))));
			}
		}
	}
	
	// *************************************************************
    // ************************ Search Topic
    // *************************************************************
	
	public function search($offset=0) {
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('search', 'Search', 'required');
		$this->load->library('pagination');
        
        
			if(empty($this->input->post('search'))){
				$data['title'] = lang_key('search_blank');
			}else{
				$data['title'] = lang_key('search_result').':&nbsp'.search_title($this->input->post('search'));
			}
				$data['desc'] = lang_key('search_description');
			
			
			$total =  get_settings('forum_settings','posts_per_page',10); // total result x page

			// Config setup
			$num_rows = $this->topic_model->countSearchMatch(); // count active secrets in cat
			$config['base_url'] = base_url().'search';
			$config['total_rows'] = $num_rows;
			$config['per_page'] = $total;
			$config['num_links'] = $num_rows;
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['prev_link'] = '&laquo;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_link'] = '&raquo;';
        
			if ($this->input->get('page') != null) {
				$offset = ($this->input->get('page') - 1) * $config['per_page'];
			}
        
			$this->pagination->initialize($config);
		
			$data['searchkey'] = search_title($this->input->post('search'));
			$data['result'] = $this->topic_model->getSearchMatch($config['per_page'], $offset);
			
			$this->load->view('themes/default/layout/header', $data);
			$this->load->view('threads/search', $data);
			$this->load->view('themes/default/layout/footer');
	}
	// *************************************************************
    // ************************ Tags Search
    // *************************************************************
	public function tags($tags,$offset=0) {
		$tag = search_title($tags);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('search', 'Search', 'required');
		$this->load->library('pagination');
        
			
			if(empty($tags)){
				$data['title'] = lang_key('search_blank');
			}else{
				$data['title'] = lang_key('search_result').':&nbsp'.$tag;
			}
				$data['desc'] = lang_key('search_description');
			
			
			$total =  get_settings('forum_settings','posts_per_page',10); // total result x page

			// Config setup
			$num_rows = $this->topic_model->countTagsMatch(str_replace("-"," ",$tags)); // count active secrets in cat
			$config['base_url'] = base_url().'tags/'.$tags;
			$config['total_rows'] = $num_rows;
			$config['per_page'] = $total;
			$config['num_links'] = $num_rows;
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['prev_link'] = '&laquo;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_link'] = '&raquo;';
        
			if ($this->input->get('page') != null) {
				$offset = ($this->input->get('page') - 1) * $config['per_page'];
			}
        
			$this->pagination->initialize($config);
		
			$data['tags'] = $tag;
			$data['total_res'] = $tags;
			$data['result'] = $this->topic_model->getTagsMatch($config['per_page'],str_replace("-"," ",$tags),$offset);
			
			$this->load->view('themes/default/layout/header', $data);
			$this->load->view('threads/tags', $data);
			$this->load->view('themes/default/layout/footer');
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
