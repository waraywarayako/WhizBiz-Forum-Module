<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	#************ email functions *************#
	function get_all_emails()
	{
		$query = $this->db->get_where('emailtmpl',array('status'=>1));
		return $query;
	}
	
	function get_email_by_id($id)
	{
		$query = $this->db->get_where('emailtmpl',array('id'=>$id));
		return $query;
	}
	
	#updated on version 1.8
	function get_email_tmpl_by_email_name($name)
	{	   	
		if(isset($content[0]))
		{
			$values = (array)$content[0];
			$values['body'] = nl2br($values['body']);
			return (object)$values;
		}
		else
		{
			$query = $this->db->get_where('emailtmpl',array('email_name'=>$name));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				$values = json_decode($row->values);
				return $values;
			}
			else
			{
				$values = array('subject'=>'Subject Not found','body'=>'body not found');
			}
			return $values;			
		}
	}
	#end
}