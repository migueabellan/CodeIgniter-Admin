<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model 
{
	function __construct() {
		parent::__construct();
	}

	public function genPass($pass='')
	{
		return md5($this->config->item('salt').$pass);
	}
	
	public function existAdmin($user, $pass)
	{
		$this->db->select('*');
		$this->db->where('user', $user);
		$this->db->where('pass', $this->genPass($pass));
		$query = $this->db->get('ci_admin');
	
		return $query->num_rows();
	}
}