<?php class Seo_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
	
	function sitemap_cat_slug() {
		$this->db->order_by('id','asc');
		$this->db->where('status',1);
		$query = $this->db->get('threads_cat');
		return $query;
    }
	
	function sitemap_post_slug() {
		$this->db->order_by('id','desc');
		$this->db->where('status',1);
		$query = $this->db->get('threads');
		return $query;
    }

}