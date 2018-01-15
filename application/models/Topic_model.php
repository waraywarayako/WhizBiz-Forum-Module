<?php class Topic_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
	
	// ******************************************************
    // ***************** Get Topic Post
    // ******************************************************
	
	// get single topic
    public function getTopic($slug) {
		$this->db->where('status',1);
        $query = $this->db->get_where('threads', array('thread_slug'=>$slug));
        return $query->row_array();
    }
	
	// update count view
    public function update_topicview($slug) {
        $this->db->set('post_view', 'post_view+1', FALSE);
        $this->db->where('thread_slug', $slug);
        $this->db->update('threads');
    }
	
	
	// get all threads reply post
	function getAllReplyThreadsPost($id)
	{
		$this->db->like('id');
		$this->db->from('threads_comment');
		$this->db->where('topic_id',$id);
		$this->db->where('status',1);
		return $this->db->count_all_results();
	}
	
	// get active topic by category id
    public function AllReplyThreadsPost($id, $limit=null, $offset=null) {
        $this->db->select('*');
        $this->db->from('threads_comment');
        $this->db->where('topic_id', $id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'asc');
        $this->db->limit($limit);
        $this->db->offset($offset);
        $query = $this->db->get();
        return $query->result_array();
        
    } 
	
	// ********************************************************
    // *********************** Post Topic Reply
    // ********************************************************
	
	// post topic reply
    public function postReplyTopic() {
        $data = array(
            'topic_id' => $this->input->post('topic_id'),
            'cat_id' => $this->input->post('cat_id'),
            'parent_id' => $this->input->post('parent_id'),
			'user_id' => $this->session->userdata('user_id'),
			'comment_content' => $this->input->post('comment'),
            'created_at' => time(),
			'status' => 1,
        );
        return $this->db->insert('threads_comment', $data);
    }
	
	// ********************************************************
    // *********************** Update Reply Topic
    // ********************************************************
	
	// update topic reply
    public function updateReplyTopic($data) {
		$this->db->where('id', $data['id']);
        $this->db->update('threads_comment', $data);
    }
	
	// delete topic reply
    public function deleteReplyTopic($data) {
		$this->db->where('id', $data['id']);
        $this->db->update('threads_comment', $data);
    }
	
	// ********************************************************
    // *********************** Update Threads Topic
    // ********************************************************
	
	// update topic post
    public function updatePostTopic($data) {
		$this->db->where('id', $data['id']);
        $this->db->update('threads', $data);
    }
	
	// delete topic post
    public function deletePostTopic($data) {
		$this->db->where('id', $data['id']);
        $this->db->update('threads', $data);
    }
	
	// pin topic post
    public function pinPostTopic($data) {
		$this->db->where('id', $data['id']);
        $this->db->update('threads', $data);
    }
	
	// ********************************************************
    // *********************** Search Threads Topic
    // ********************************************************
	
	// get active topic search match
    public function getSearchMatch($limit=null, $offset=null) {
		$match = $this->input->post('search');
        $this->db->from('threads');
        $this->db->where('status', 1);
		$search_query_values = explode(' ', $match);
		$counter = 0;
		foreach ($search_query_values as $key => $value) {
		if ($counter == 0) {
			$this->db->like('title', $value);
			$this->db->or_like('content', $value);
			$this->db->or_like('tags', $value);
		}
		else {
			$this->db->like('title', $value);
			$this->db->or_like('content', $value);
			$this->db->or_like('tags', $value);
		}
			$counter++;
		}
		$this->db->order_by('pin_post', 'DESC');
        $this->db->order_by('id', 'DESC');
		$this->db->limit($limit);
        $this->db->offset($offset);
        $query = $this->db->get();
        return $query->result_array(); 
    } 
	// count active topic search match
	public function countSearchMatch() {
		$match = $this->input->post('search');
        $this->db->from('threads');
        $this->db->where('status', 1);
		$search_query_values = explode(' ', $match);
		$counter = 0;
		foreach ($search_query_values as $key => $value) {
		if ($counter == 0) {
			$this->db->like('title', $value);
			$this->db->or_like('content', $value);
			$this->db->or_like('tags', $value);
		}
		else {
			$this->db->like('title', $value);
			$this->db->or_like('content', $value);
			$this->db->or_like('tags', $value);
		}
			$counter++;
		}
        return $this->db->count_all_results(); 
    }

	// ********************************************************
    // *********************** TAGS
    // ********************************************************
	
	// get active topic tags match
    public function getTagsMatch($limit=null, $tags, $offset=null) {
		$match = $tags;
        $this->db->from('threads');
        $this->db->where('status', 1);
		$search_query_values = explode(' ', $match);
		$counter = 0;
		foreach ($search_query_values as $key => $value) {
		if ($counter == 0) {
			$this->db->like('tags', $value);
		}else{
			$this->db->like('tags', $value);
		}
			$counter++;
		}
		$this->db->order_by('pin_post', 'DESC');
        $this->db->order_by('id', 'DESC');
		$this->db->limit($limit);
        $this->db->offset($offset);
        $query = $this->db->get();
        return $query->result_array(); 
    } 
	// count active topic tags match
	public function countTagsMatch($tags) {
		$match = $tags;
        $this->db->from('threads');
        $this->db->where('status', 1);
		$search_query_values = explode(' ', $match);
		$counter = 0;
		foreach ($search_query_values as $key => $value) {
		if ($counter == 0) {
			$this->db->like('tags', $value);
		}else{
			$this->db->like('tags', $value);
		}
			$counter++;
		}
        return $this->db->count_all_results(); 
    }	
}