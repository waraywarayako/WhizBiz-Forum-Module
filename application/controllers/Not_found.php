<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Not_found extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->load->helper('url_helper');	
		$this->load->library('session');
		$this->load->config('forum_plugin');
		$this->load->helper('text');		
    } 

    public function index() { 
        
        $data['title'] = lang_key('404errorheader');
        $data['desc'] = lang_key('404errordesc');
        
        $this->load->view('themes/default/layout/header', $data);
        $this->load->view('errors/html/error_404');
        $this->load->view('themes/default/layout/footer');
    } 
    
} 