<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model 

{

	function __construct()

	{

		parent::__construct();

		$this->load->database();

	}

	function insert_user_data($data)
	{
		$this->db->insert('users',$data);
		return $this->db->insert_id();
	}

	
	function get_user_data_array_by_id($id)
	{
		$query = $this->db->get_where('users',array('id'=>$id));
		return $query->row_array();
	}


	function get_user_profile($user_email)
	{
		$query = $this->db->get_where('users',array('user_email'=>$user_email));
		return $query->row();
	}


	//get user profile by id
	function get_user_profile_by_id($id)
	{
		$query = $this->db->get_where('users',array('id'=>$id));
		return $query->row();
	}

	

	function get_user_profile_by_user_name($user_name)
	{
		$query = $this->db->get_where('users',array('user_name'=>$user_name));
		if($query->num_rows()>0)
			return $query->row();
		else
			show_error('User name not valid' , 500 );
	}



	function update_user_by_id($data,$id)
	{

		$this->db->update('users',$data,array('id'=>$id));
	}


	

	


	//update password
	function update_password($password)
	{
		$this->load->library('encrypt');
		$user_email = $this->session->userdata('user_email');
		$data['password'] = $this->encrypt->sha1($password);
		$data['recovery_key'] = '';
		$this->db->update('users',$data,array('user_email'=>$user_email));
	}



	

	function get_post_by_id($id)

	{

		$query = $this->db->get_where('posts',array('id'=>$id));

		if($query->num_rows()>0)

		return $query->row();

		else 

		return FALSE;

	}



	function get_all_user_posts_by_range($start,$limit='',$sort_by='',$id)

	{

		$this->db->order_by($sort_by, "asc");

		$this->db->where('status',1); 

		$this->db->where('created_by',$id);

		if($start=='all')

		$query = $this->db->get('posts');

		else

		$query = $this->db->get('posts',$limit,$start);

		return $query;

	}

	

	function count_all_user_posts($id)

	{

		$this->db->where('status',1); 		

		$this->db->where('created_by',$id); 

		$query = $this->db->get('posts');

		return $query->num_rows();

	}



	function get_all_posts_by_range($start,$limit='',$sort_by='')
	{
		$this->db->order_by($sort_by, "asc");
		if($start=='all')
		$query = $this->db->get('posts');
		else
		$query = $this->db->get('posts',$limit,$start);
		return $query;

	}

	

	function count_all_posts()
	{
		$query = $this->db->get('posts');
		return $query->num_rows();
	}



	function count_all_users()
	{
		$this->db->where('status',1);
		$query = $this->db->get('users');
		return $query->num_rows();
	}
	
	//update user profile
	function update_profile($data,$id)
	{
		$this->db->update('users',$data,array('id'=>$id));
	}
	
	
	// get user information
	function get_user_info($id)
	{
		$query = $this->db->get_where('users', array('id'=>$id));
       return $query->row_array();
	}
	
	// ********************************************************
    // *********************** Get User Topic Post
    // ********************************************************
	
	// get topic post
	function get_userpost($user_id,$per_page,$page)
    {	
		$this->db->where('status', 1);
		$this->db->where('user_id', $user_id);
		$this->db->limit($per_page);
		$this->db->offset($per_page * $page);
		$this->db->order_by('pin_post', 'DESC');
		$this->db->order_by('id', 'DESC');
		return $this->db->get('threads');
    }
	
	// get topic reply
	function get_userreply($user_id,$items_comment_per_page,$page)
    {	
		$this->db->where('status',1);
		$this->db->where('user_id',$user_id);
		$this->db->limit($items_comment_per_page);
		$this->db->offset($items_comment_per_page * $page);
		$this->db->order_by('id','DESC');
		$query = $this->db->get('threads_comment');
		return $query;
    }
	
	// get listing post
	function get_userlistingpost($user_id,$per_page,$page)
    {	
		$this->db->where('status', 1);
		$this->db->where('created_by', $user_id);
		$this->db->limit($per_page);
		$this->db->offset($per_page * $page);
		$this->db->order_by('featured', 'DESC');
		$this->db->order_by('id', 'DESC');
		return $this->db->get('posts');
    }
}