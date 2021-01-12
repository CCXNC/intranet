<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function get_announcements()
	{
		$this->db->select("*");
		$this->db->where('category', "loginpage");
		$query = $this->db->get('announcement');
		return $query->result();
    }
    
    function check_user($username, $password){
        $this->db->select('*'); 
        $this->db->from('users');
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $query = $this->db->get(); 
        return $query;
    }
}
