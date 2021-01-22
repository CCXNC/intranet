<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    function check_user($username, $password){
        $this->db->select("
            users.id as id,
            users.employee_number as employee_number,
            users.username as username,
            users.password as password,
            users.access_level_id as access_level_id,
            employees.id as emp_id
        "); 
        $this->db->from('users');
        $this->db->join('employees', 'employees.employee_number = users.employee_number','left');
        $this->db->where(' users.username', $username);
        $this->db->where('users.password', md5($password));
        $query = $this->db->get(); 
        return $query;
    }

    public function get_announcements()
	{
        $this->db->where('is_active', 1);
        $this->db->where('category', "loginpage");
		$query = $this->db->get('announcement');

		return $query->result();
	}
}
