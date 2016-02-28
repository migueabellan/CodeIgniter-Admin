<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model 
{
	public $validation = array(
        array(
            'field' => 'user', 
            'label' => 'user', 
            'rules' => 'trim|xss_clean|required|min_length[5]|max_length[45]'), 
        array(
            'field' => 'pass', 
            'label' => 'pass', 
            'rules' => 'trim|xss_clean|required|min_length[5]|max_length[45]|callback_exist_admin')
        );

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