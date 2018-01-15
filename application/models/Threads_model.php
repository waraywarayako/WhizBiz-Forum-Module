<?php class Threads_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
	
	// ******************************************************
    // ***************** Threads Category
    // ******************************************************
	
    // get categories
    public function getThreadsCategories() {
        $this->db->order_by('cat_position','asc');
		$this->db->where('status',1);
		$query = $this->db->get_where('threads_cat',array('parent'=>0));
		$categories = array();
		foreach ($query->result() as $row) {
			array_push($categories,$row);
			$this->db->order_by('cat_position','asc');
			$child_query = $this->db->get_where('threads_cat',array('parent'=>$row->id));
			foreach ($child_query->result() as $child) {
				array_push($categories,$child);
			}
		}
		return $categories;
    }
	
	// get all parent categories
	function getAllParentThreadsCategories()
	{
		$this->db->order_by('cat_position','asc');
		$this->db->where('status',1);
		$this->db->where('parent',0);
		$query = $this->db->get('threads_cat');
		return $query;
	}
	
	// get all child categories
	function getAllChildThreadsCategories($id, $limit = 'all')
	{
		$this->db->order_by('cat_position','asc');
		$this->db->where('status',1);
		$this->db->where('parent',$id);
		if($limit!= 'all')
			$this->db->limit($limit);
		$query = $this->db->get('threads_cat');		
		return $query;
	}
	
	// count threads by categories id
	function countThreadsByCategoryId($cat_id)
	{
		$cat_id = $this->db->escape($cat_id ) ;
		$this->db->where("(parent_category = $cat_id OR category_id = $cat_id)");
		$this->db->where('status',1);
		$query = $this->db->get('threads');
		return $query->num_rows();
	}
	// count threads by categories id
	function countThreadsByParentCategoryId($cat_id)
	{
		$cat_id = $this->db->escape($cat_id ) ;
		$this->db->where("category_id = $cat_id");
		$this->db->where('status',1);
		$query = $this->db->get('threads');
		return $query->num_rows();
	}
	
	// count topic view by categories id
	function countTopicViewByCategoryId($cat_id)
	{
		$cat_id = $this->db->escape($cat_id ) ;
		$this->db->where("(parent_category = $cat_id OR category_id = $cat_id)");
		$this->db->where('status',1);
		$query = $this->db->get('threads');
		return $query->num_rows();
	}
	
	//count total views of all topic per category
	function countTopicTotalViewByCategory($id){
		$this->db->select_sum('post_view');
		$this->db->from('threads');
		$this->db->where("(parent_category = $id OR category_id = $id)");
		$query = $this->db->get();
		return $query->row()->post_view;
	}
	
	//get threads categories by slug
	public function getThreadsCategory($slug) {
		$this->db->order_by('id','asc');
		$this->db->where('slug',$slug);
		$query = $this->db->get('threads_cat');
		return $query;
    }
	
	//get parent category name by id
	public function getCategoryName($id) {
		$query = $this->db->get_where('threads_cat', array('parent'=>$id));
		return $query;
    }
	
	// get name threads by slug
    public function getThreadsNameCat($slug) {
        $query = $this->db->get_where('threads_cat', array('slug'=>$slug));
        return $query->row_array();
    }
	// get all threads post
	function getAllSubCatThreadPost($id)
	{
		$this->db->order_by('cat_position','asc');
		$this->db->where('parent',$id);
		$query = $this->db->get('threads_cat');
		return $query;
	}
	
	
	
	
	
	// count topic reply by categories id
	function countTopicReplyByCategoryId($cat_id)
	{
		$cat_id = $this->db->escape($cat_id ) ;
		$this->db->where("(parent_id = $cat_id OR cat_id = $cat_id)");
		$this->db->where('status',1);
		$query = $this->db->get('threads_comment');
		return $query->num_rows();
	}
	
	// count topic reply by topic id
	function countTopicReplyByTopicId($topic_id)
	{
		$topic_id = $this->db->escape($topic_id ) ;
		$this->db->where("topic_id = $topic_id");
		$this->db->where('status',1);
		$query = $this->db->get('threads_comment');
		return $query->num_rows();
	}
	
	// ********************************************************
    // *********************** Get Threads Topic Post
    // ********************************************************
	
	// get all threads post
	function getAllThreadsPost($id)
	{
		$this->db->like('id');
		$this->db->from('threads');
		$this->db->where('category_id',$id);
		$this->db->where('status',1);
		return $this->db->count_all_results();
	}
	
	
	// get active secret by category id
    public function AllThreadsPost($id, $limit=null, $offset=null) {
        $this->db->select('*');
        $this->db->from('threads');
        $this->db->where('category_id', $id);
        $this->db->where('status', 1);
        $this->db->order_by('pin_post', 'DESC');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        $this->db->offset($offset);
        $query = $this->db->get();
        return $query->result_array();
        
    } 
	
	
	// ********************************************************
    // *********************** Create New Threads
    // ********************************************************
	
    public function insertNewThreads() {
        $data = array(
			'title' => $this->input->post('title'),
            'thread_slug' => $this->input->post('slug'),
            'content' => $this->input->post('text'),
            'tags' => $this->security->sanitize_filename($this->input->post('tags', true)),
            'category_id' => $this->security->sanitize_filename($this->input->post('category', true)),
			'parent_category' => $this->security->sanitize_filename($this->input->post('parent_cat', true)),
            'user_id' => $this->session->userdata('user_id'),
            'status' => 1,
            'created_at' => time(),
        );
        return $this->db->insert('threads', $data);
    }
	
	//Check if threads exist
	function is_topic_exists($title)
	{
		$query = $this->db->get_where('threads',array('title'=>$title));
		return $query->num_rows();
	}
	
	//Check if slug exist
	function is_slug_exists($slug)
	{
		$query = $this->db->get_where('threads',array('thread_slug'=>$slug));
		return $query->num_rows();
	}
	
}