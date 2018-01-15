<?php
defined('BASEPATH') OR exit('No direct script access allowed');


Class Seo extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->helper('url_helper');
		$this->load->model('seo_model');
    }

    function sitemap()
    {

        $data['cat'] = $this->seo_model->sitemap_cat_slug();//select urls from DB to Array
        $data['post'] = $this->seo_model->sitemap_post_slug();//select urls from DB to Array
        header('Content-Type: text/xml;charset=iso-8859-1');
        $this->load->view('sitemap',$data);
    }
}