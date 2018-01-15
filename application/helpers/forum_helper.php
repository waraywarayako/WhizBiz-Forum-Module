<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ********************************************************
// *********************** Website Settings
// ********************************************************

//get whizbiz settings
if ( ! function_exists('get_settings'))
{
	function get_settings($option='',$key='',$default='Yes')
	{
		$settings = get_option($option);
		if(is_array($settings)==FALSE)
		{
			$settings = (array)json_decode($settings->values);
			$val = (isset($settings[$key]))?$settings[$key]:$default;
		}
		else
			$val = $default;

		return $val;
	}
}

//get site options
if ( ! function_exists('get_option'))
{
	function get_option($key='')
	{
		$defined = 0;
		if(defined('OPTIONS_ARRAY'))
		{						
			$options = (array)json_decode(constant('OPTIONS_ARRAY'));
			if(isset($options[$key]))
			{
				$defined = 1;
				return $options[$key];
			}
		}


		if($defined==0)
		{
			$CI = get_instance();
			$CI->load->database();
			$query = $CI->db->get_where('options',array('key'=>$key,'status'=>1));		
			if($query->num_rows()>0)
				$option = $query->row();
			else
				$option = array('error'=>'Key not found');

			$options[$key] = $option;
			if(!defined('OPTIONS_ARRAY'))
				define('OPTIONS_ARRAY',json_encode($options));

			return $option;
		}
	}
}
// ********************************************************
// *********************** Language Directory
// ********************************************************
	
//language
if ( ! function_exists('lang_key'))
{
	function lang_key($key='')
	{
		$CI = get_instance();
		$CI->load->library('yaml');
		$lang =  $CI->yaml->parse_file('./language/en.yml');
			if(count($lang)>0)
			{
				if(!defined('LANG_ARRAY'))
					define('LANG_ARRAY',json_encode($lang));


				if(isset($lang[$key]))
					return $lang[$key];
				else {
					return $key;
				}
			}
			else {
				return $key;
			}
	}
}

// ********************************************************
// *********************** Language Post Data Lang
// ********************************************************

//default lang
if ( ! function_exists('default_lang'))
{
	function default_lang()
	{
			if(defined('DEFAULT_LANG'))
			{
				return constant('DEFAULT_LANG');
			}
			else
			{	
					$CI = get_instance();
					$CI->load->database();
					$query 		= $CI->db->get_where('options',array('key'=>'site_settings'));		
					if($query->num_rows()>0)
					{
						$row = $query->row();
						$settings = json_decode($row->values);
						$default_lang = (!empty($settings->site_lang))?$settings->site_lang:'en';	
					}
					else
						$default_lang = 'en';

					if(!defined('DEFAULT_LANG'))
						define('DEFAULT_LANG',$default_lang);
					return $default_lang;											
			}
	}
}

//get listing post data in by language
if ( ! function_exists('get_post_data_by_lang'))
{
	function get_post_data_by_lang($post,$column='title',$lang='')
	{
		if($lang=='')
			$lang = default_lang();

		if($column=='title')
		{
			$titles = json_decode($post->title);
			if(isset($titles->{$lang}) &&  $titles->{$lang}!='')
				return $titles->{$lang};
			else
				return $titles->{default_lang()};
		}
		else if($column=='address')
		{
			$titles = json_decode($post->address);
			if(isset($titles->{$lang}) &&  $titles->{$lang}!='')
				return $titles->{$lang};
			else
				return $titles->{default_lang()};
		}
		else
		{
			$descriptions = json_decode($post->description);
			if(isset($descriptions->{$lang}) &&  $descriptions->{$lang}!='')
				return $descriptions->{$lang};
			else
				return $descriptions->{default_lang()};
		}
	}
}

//featured photo
if ( ! function_exists('get_featured_photo_by_id'))
{
	function get_featured_photo_by_id($img='')
	{
		if(get_settings('forum_settings','use_ssl','')!='No'){
			$forum_link='https://'.get_settings('forum_settings','main_domain','');
		}else{
			$forum_link='http://'.get_settings('forum_settings','main_domain','');
		}
		
		if($img=='')
		return $forum_link.'/assets/admin/img/preview.jpg';
		else
		return $forum_link.'/uploads/thumbs/'.$img;
	}
}

if ( ! function_exists('get_mainsite_url'))
{
	function get_mainsite_url(){
		//check if site access thru secure address
		if(get_settings('forum_settings','use_ssl','')!='No')
			 $main_url = 'https://'.get_settings('forum_settings','main_domain','').'/'.default_lang();
		else
			 $main_url = 'http://'.get_settings('forum_settings','main_domain','').'/'.default_lang();
			
			//check if using index.php
			if(get_settings('forum_settings','domain_indexphp','')!='No')
				return $main_url.'/index.php';
			else
				return $main_url;
		
	}
}


// ********************************************************
// *********************** POST URL
// ********************************************************

//category title
if ( ! function_exists('get_category_title_by_id'))
{
	function get_category_title_by_id($id='')
	{
		if($id==0)
			return 'No parent';
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('categories',array('id'=>$id));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return lang_key($row->title);
		}
		else
			return '';
	}
}

//post url
if ( ! function_exists('post_detail_url'))
{
	function post_detail_url($post)
	{
		if(get_settings('forum_settings','use_ssl','')!='No'){
			$forum_link='https://'.get_settings('forum_settings','main_domain','');
		}else{
			$forum_link='http://'.get_settings('forum_settings','main_domain','');
		}
		if(get_settings('forum_settings','domain_indexphp','')!='No'){
			$listing_link=$forum_link.'/index.php';
		}else{
			$listing_link=$forum_link;
		}
		$url = $listing_link.'/en/ads/'.$post->unique_id; #never remove this line change the  index.ph/en/ to your default lang e.i /ch/ or /ph/
		$url .= '/'.dbc_url_title(get_category_title_by_id($post->category));
		$title = get_post_data_by_lang($post,'title');
		$url .= '/'.dbc_url_title($title);
		return $url;
	}

}

//post url dash
if ( ! function_exists('dbc_url_title'))
{
	function dbc_url_title($str, $separator = 'dash', $lowercase = FALSE)
	{
		$str = urlencode($str);

		if ($separator == 'dash')
		{
			$search		= '_';
			$replace	= '-';
		}
		else
		{
			$search		= '-';
			$replace	= '_';
		}

		$trans = array(
						'&\#\d+?;'				=> '',
						'&\S+?;'				=> '',
						'\s+'					=> $replace,
						$replace.'+'			=> $replace,
						$replace.'$'			=> $replace,
						'^'.$replace			=> $replace,
						'\.+$'					=> ''
					);

		$str = strip_tags($str);

		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}

        $str = str_replace('&','and',$str);
        $str = str_replace(' ','-',$str);
        $str = str_replace('/','-',$str);
        $str = str_replace('?','-',$str);
        $str = str_replace('《','',$str);
        $str = str_replace('》','',$str);
        $str = str_replace('+','-',$str);
        $str = str_replace('%20','-',$str); 
		$str = str_replace('%26','&',$str); 
		$str = str_replace('%27','',$str); 
		$str = str_replace('%28','',$str); 
		$str = str_replace('%29','',$str); 
		return trim(stripslashes($str));
	}
}

//tags url title
if ( ! function_exists('tags_url_title'))
{
	function tags_url_title($str, $separator = 'dash', $lowercase = TRUE)
	{
		$str = urlencode($str);
		if ($separator == 'dash')
		{
			$search		= '_';
			$replace	= '-';
		}
		else
		{
			$search		= '-';
			$replace	= '_';
		}
		$trans = array(
						'&\#\d+?;'				=> '',
						'&\S+?;'				=> '',
						'\s+'					=> $replace,
						$replace.'+'			=> $replace,
						$replace.'$'			=> $replace,
						'^'.$replace			=> $replace,
						'\.+$'					=> ''
					);
		$str = strip_tags($str);
		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}
		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}
        $str = str_replace('&','and',$str);
        $str = str_replace(' ','-',$str);
        $str = str_replace('/','-',$str);
        $str = str_replace('?','-',$str);
        $str = str_replace('《','',$str);
        $str = str_replace('》','',$str);
        $str = str_replace('+','-',$str);
        $str = str_replace('%20','-',$str); 
		$str = str_replace('%26','&',$str); 
		$str = str_replace('%27','',$str); 
		$str = str_replace('%28','',$str); 
		$str = str_replace('%29','',$str); 
		return trim(stripslashes($str));
	}
}

//search title
if ( ! function_exists('search_title'))
{
	
	function search_title($str, $separator = '&nbsp') {
		$str = ucwords(strtolower($str));

		foreach (array('-', '\'') as $delimiter) {
			if (strpos($str, $delimiter)!==false) 
			{
				$str =implode($delimiter, array_map('ucfirst', explode($delimiter, $str)));
			}
		}
		$str = str_replace('-','&nbsp',$str); 
		$str = str_replace('%20','&nbsp',$str); 
		$str = str_replace('%26','&',$str); 
		$str = str_replace('%27','&nbsp',$str); 
		$str = str_replace('%28','&nbsp',$str); 
		$str = str_replace('%29','&nbsp',$str); 
		return trim(stripslashes($str));
	}
}

//post location name
if ( ! function_exists('get_location_name_by_id'))
{
	function get_location_name_by_id ($id,$translation='yes')
	{
		if($id==0)
			return '';

		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('locations',array('id'=>$id));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$name =  trim(preg_replace('/\s\s+/', ' ',$row->name));
			$name = str_replace("'", "", $name);
			if($translation=='yes')
			return lang_key($name);
			else
			return $name;
		}
		else
		{
			return 'N/A';
		}
	}
}

//post meta
if ( ! function_exists('get_post_meta'))
{
	function get_post_meta ($post_id,$key,$default='n/a')
	{
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('post_meta',array('post_id'=>$post_id,'key'=>$key));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->value;
		}
		else
		{
			return $default;
		}
	}
}

// ********************************************************
// *********************** Custom Number Format for Results
// ********************************************************

//get views format in K/M/B
if ( ! function_exists('custom_number_format'))
{
	function custom_number_format($n, $precision = 1) {
		if ($n < 900) {
        // Default
         $n_format = number_format($n);
		} else if ($n < 900000) {
        // Thausand
        $n_format = number_format($n / 1000, $precision). 'K';
		} else if ($n < 900000000) {
        // Million
        $n_format = number_format($n / 1000000, $precision). 'M';
		} else if ($n < 900000000000) {
        // Billion
        $n_format = number_format($n / 1000000000, $precision). 'B';
		} else {
        // Trillion
        $n_format = number_format($n / 1000000000000, $precision). 'T';
    }
    return $n_format;
	}
}


// ********************************************************
// *********************** Get Category Data by Data
// ********************************************************

//get category permission by id
if ( ! function_exists('get_category_permission_by_id'))
{
    function get_category_permission_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads_cat',array('id'=>$id));
        $row = $query->row();
		return $row->cat_permission;
	}
}

//get parent category name by id
if ( ! function_exists('get_category_name_by_id'))
{
    function get_category_name_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads_cat',array('id'=>$id));
        $row = $query->row();
		return $row->catname;
	}
}

//get parent category slug by id
if ( ! function_exists('get_category_slug_by_id'))
{
    function get_category_slug_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads_cat',array('id'=>$id));
        $row = $query->row();
		return $row->slug;
	}
}

//get  category id by slug
if ( ! function_exists('get_category_id_by_slug'))
{
    function get_category_id_by_slug($slug)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads_cat',array('slug'=>$slug));
        $row = $query->row();
		return $row->id;
	}
}


// ********************************************************
// *********************** Get Post Topic Data
// ********************************************************

//get  edit topic content by id
if ( ! function_exists('get_edit_topic_content_by_id'))
{
    function get_edit_topic_content_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads',array('id'=>$id));
        $row = $query->row();
		return $row->content;
	}
}

//get  edit topic tags by id
if ( ! function_exists('get_edit_topic_tags_by_id'))
{
    function get_edit_topic_tags_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads',array('id'=>$id));
        $row = $query->row();
		return $row->tags;
	}
}

//get  edit topic slug by id
if ( ! function_exists('get_edit_topic_slug_by_id'))
{
    function get_edit_topic_slug_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads',array('id'=>$id));
        $row = $query->row();
		return $row->thread_slug;
	}
}

//get  topic title by id
if ( ! function_exists('get_topic_title_by_id'))
{
    function get_topic_title_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads',array('id'=>$id));
        $row = $query->row();
		return $row->title;
	}
}


//get  edit topic user id by id
if ( ! function_exists('get_edit_topic_user_id_by_id'))
{
    function get_edit_topic_user_id_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads',array('id'=>$id));
        $row = $query->row();
		return $row->user_id;
	}
}

// ********************************************************
// *********************** Get Reply Topic Data
// ********************************************************

//get topic reply
if ( ! function_exists('get_topic_reply'))
{
	function get_topic_reply($topic_id)
	{

		$CI = get_instance();
		$CI->load->database();

		$CI->db->order_by('id', 'asc');
		$CI->db->where('topic_id',$topic_id);
		$CI->db->where('status',1);
		$query = $CI->db->get_where('threads_comment');
		return $query;

	}
}

//get  topic id by slug
if ( ! function_exists('get_topic_id_by_slug'))
{
    function get_topic_id_by_slug($slug)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads',array('thread_slug'=>$slug));
        $row = $query->row();
		return $row->id;
	}
}

//get  topic slug by id
if ( ! function_exists('get_topic_slug_by_id'))
{
    function get_topic_slug_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads',array('id'=>$id));
        $row = $query->row();
		return $row->thread_slug;
	}
}

//get  topic lock stat by id
if ( ! function_exists('get_topic_lock_stat_by_id'))
{
    function get_topic_lock_stat_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads',array('id'=>$id));
        $row = $query->row();
		return $row->lock_post;
	}
}

//get  topic id by  id
if ( ! function_exists('get_topic_id_by_id'))
{
    function get_topic_id_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads_comment',array('id'=>$id));
        $row = $query->row();
		return $row->topic_id;
	}
}

//get  edit reply content by id
if ( ! function_exists('get_edit_reply_content_by_id'))
{
    function get_edit_reply_content_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads_comment',array('id'=>$id));
        $row = $query->row();
		return $row->comment_content;
	}
}


//get  edit reply user id by id
if ( ! function_exists('get_edit_reply_user_id_by_id'))
{
    function get_edit_reply_user_id_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads_comment',array('id'=>$id));
        $row = $query->row();
		return $row->user_id;
	}
}


//get parent category topic by id
if ( ! function_exists('get_parent_cat_topic_by_id'))
{
    function get_parent_cat_topic_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads',array('id'=>$id));
        $row = $query->row();
		return $row->parent_category;
	}
}

//get category topic by id
if ( ! function_exists('get_cat_topic_by_id'))
{
    function get_cat_topic_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('threads',array('id'=>$id));
        $row = $query->row();
		return $row->category_id;
	}
}

// ******************************************************
// ***************** Get Lastest Post
// ******************************************************
	
// get lastest reply by ID
if ( ! function_exists('getLatestReplyById'))
{
    function getLatestReplyById($id) 
	{
		
        $CI = get_instance();
		$CI->load->database();

		$CI->db->order_by('id', 'desc');
		$CI->db->where('topic_id',$id);
		$CI->db->where('status',1);
		$query = $CI->db->get_where('threads_comment');
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->user_id; 
		}
		else
			return 'N/A';
    }
}


// get lastest reply time by User ID
if ( ! function_exists('getLatestReplyTimeByUserId'))
{
    function getLatestReplyTimeByUserId($id) 
	{
		
        $CI = get_instance();
		$CI->load->database();

		$CI->db->order_by('id', 'desc');
		$CI->db->where('topic_id',$id);
		$CI->db->where('status',1);
		$query = $CI->db->get_where('threads_comment');
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->created_at; 
		}
		else
			return 'N/A';
    }
}

// ********************************************************
// *********************** User Functions
// ********************************************************

// get user listing post count
if ( ! function_exists('get_user_listing_post_count'))
{
	function get_user_listing_post_count($user_id)
	{
		$CI = get_instance();
		$CI->load->database();
		$CI->db->where('created_by',$user_id);
		$query = $CI->db->get_where('posts',array('status'=>1));
		return $query->num_rows();
	}
}

// get user topic post count
if ( ! function_exists('get_user_topic_post_count'))
{
	function get_user_topic_post_count($user_id)
	{
		$CI = get_instance();
		$CI->load->database();
		$CI->db->where('user_id',$user_id);
		$query = $CI->db->get_where('threads',array('status'=>1));
		return $query->num_rows();
	}
}


// get user topic comment post count
if ( ! function_exists('get_user_topic_comment_post_count'))
{
	function get_user_topic_comment_post_count($user_id)
	{
		$CI = get_instance();
		$CI->load->database();
		$CI->db->where('user_id',$user_id);
		$query = $CI->db->get_where('threads_comment',array('status'=>1));
		return $query->num_rows();
	}
}


//get user title
if ( ! function_exists('get_user_title_by_id'))
{
	function get_user_title_by_id($id)
	{
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('users',array('id'=>$id));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			if($row->first_name!='')
				return $row->first_name;
			else
				return $row->user_name;
		}
		else
			return 'N/A';
	}
}

//get user name
if ( ! function_exists('get_username_by_id'))
{
	function get_username_by_id($id)
	{
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('users',array('id'=>$id));
		$row = $query->row();
		return $row->user_name;
	}
}

//get user full name
if ( ! function_exists('get_user_fullname_from_username'))
{
    function get_user_fullname_from_username($username)
    {
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('users',array('user_name'=>$username));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			if($row->first_name!='')
				return $row->first_name.' '.$row->last_name;
			else
				return $row->user_name;
		}
		else
			return 'N/A';
        
    }
}

//get user id
if ( ! function_exists('get_user_id_by_username'))
{
	function get_user_id_by_username($username)
	{
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('users',array('user_name'=>$username));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->id;
		}
	}
}


//get user role
if ( ! function_exists('get_user_role_by_id'))
{
    function get_user_role_by_id($id)
    {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('users',array('id'=>$id));
        if($query->num_rows()>0)
        {
            $row = $query->row();
            return $row->user_type;
        }
        else
            return 'N/A';
    }
}

//get user title name color
if ( ! function_exists('get_user_type_by_id_name'))
{
	function get_user_type_by_id_name($id)
	{
		if($id==1)
			return lang_key('text-admin');
		elseif($id==2)
			return lang_key('text-business');
		elseif($id==3)
			return lang_key('text-personal');
	}
}

//get user type
if ( ! function_exists('get_user_type_by_id'))
{
	function get_user_type_by_id($id)
	{
		if($id==1)
			return lang_key('admin_acc');
		elseif($id==2)
			return lang_key('business_acc');
		elseif($id==3)
			return lang_key('personal_acc');
	}
}

//get user profile pic
if ( ! function_exists('get_profile_photo_by_id'))
{
	function get_profile_photo_by_id($id='',$type='')
	{
		if($id==0)
			return 'No found';

		$CI = get_instance();
		$CI->load->database();
		if(get_settings('forum_settings','use_ssl','')!='No'){
			$forum_link='https://'.get_settings('forum_settings','main_domain','');
		}else{
			$forum_link='http://'.get_settings('forum_settings','main_domain','');
		}
		$query = $CI->db->get_where('users',array('id'=>$id));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			if($row->profile_photo=='')
				return $forum_link.'/uploads/profile_photos/nophoto-'.strtolower($row->gender).'.jpg';
			
			if($type=='thumb')
			return $forum_link.'/uploads/profile_photos/thumb/'.$row->profile_photo;
			else
			return $forum_link.'/uploads/profile_photos/'.$row->profile_photo;
		}
		else
		{

			return $main_url.'uploads/profile_photos/nophoto-female.jpg';
		}
	}
}

//get user profile name
if ( ! function_exists('get_profile_photo_name_by_username'))
{
	function get_profile_photo_name_by_username($username='',$type='thumb')
	{
		if($username=='')
			return 'Not found';

		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('users',array('user_name'=>$username));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			if($row->profile_photo!='')
			return $row->profile_photo;
			else
			return 'nophoto-'.strtolower($row->gender).'.jpg';
		}
		else
			return 'nophoto-.jpg';
	}
}

//add user meta
if ( ! function_exists('add_user_meta'))
{
	function add_user_meta ($user_id,$key,$value)
	{
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('user_meta',array('user_id'=>$user_id,'key'=>$key));
		if($query->num_rows()>0)
		{
			$CI->db->update('user_meta',array('value'=>$value),array('user_id'=>$user_id,'key'=>$key));
		}
		else
		{
			$CI->db->insert('user_meta',array('user_id'=>$user_id,'key'=>$key,'value'=>$value));
		}
	}
}

//get user meta
if ( ! function_exists('get_user_meta'))
{
	function get_user_meta ($user_id,$key,$default='')
	{
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('user_meta',array('user_id'=>$user_id,'key'=>$key));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->value;
		}
		else
		{
			return $default;
		}
	}
}

//is admin
if ( ! function_exists('is_admin'))
{
	function is_admin($user_name='',$user_type='')
	{
		if($user_name=='' && $user_type=='')
		{
			$CI = get_instance();
			if($CI->session->userdata('user_name')!='' && $CI->session->userdata('user_type')==1)
				return TRUE;
			else
				return FALSE;			
		}
		else
		{
			if($user_name!='' && $user_type==1)
				return TRUE;
			else
				return FALSE;			

		}
	}
}

//is login
if ( ! function_exists('is_loggedin'))
{
	function is_loggedin()
	{
		$CI = get_instance();
		if($CI->session->userdata('user_name')=='')
			return FALSE;
		else
			return TRUE;
	}
}

//is login
if ( ! function_exists('is_notloggedin'))
{
	function is_notloggedin()
	{
		$CI = get_instance();
		if($CI->session->userdata('user_name')=='')
			return TRUE;
		else
			return FALSE;
	}
}

//is user banned
if ( ! function_exists('is_banned'))
{
	function is_banned($user_email)
	{
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('users',array('user_email'=>$user_email));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			if($row->banned==1)
				return TRUE;
			else
				return FALSE;
		}
		else
			return TRUE;
	}
}

//is user is not commfirmed
if ( ! function_exists('is_notconfirmed'))
{
	function is_notconfirmed($user_email)
	{
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('users',array('user_email'=>$user_email));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			if($row->confirmed!=1)
				return TRUE;
			else
				return FALSE;
		}
		else
			return TRUE;
	}
}

//is user is commfirmed
if ( ! function_exists('is_confirmed'))
{
	function is_confirmed($user_email)
	{
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('users',array('user_email'=>$user_email));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			if($row->confirmed==1)
				return TRUE;
			else
				return FALSE;
		}
		else
			return TRUE;
	}
}

//is user agent
if ( ! function_exists('is_agent'))
{
	function is_agent()
	{
		$CI = get_instance();
		if($CI->session->userdata('user_name')!='' && $CI->session->userdata('user_type')==2)
			return TRUE;
		else if($CI->session->userdata('user_name')!='' && $CI->session->userdata('user_type')==3)
			return TRUE;
		else
			return FALSE;
	}
}