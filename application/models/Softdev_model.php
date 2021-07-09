<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Softdev_model extends CI_Model {

    public function get_user_account()
	{
		$this->db->select("
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            users.employee_number as employee_number,
            users.username as username,
            users.default_password as default_password
        ");
        $this->db->from('users');
        $this->db->join('employees', 'users.employee_number = employees.employee_number');
        $query = $this->db->get();

        return $query->result();
	}

    public function reset_to_default_password($employee_number)
    {
        $this->db->trans_start();

        $this->db->select('*');
        $this->db->where('employee_number', $employee_number);
        $query = $this->db->get('users');

        $id = $query->row()->id;
        $default_password = $query->row()->default_password;
        $md5_password = md5($default_password);
 
        $data = array(
            'password' => $md5_password
        );
        $this->db->where('employee_number', $employee_number);
        $this->db->update('users', $data);

        $trans = $this->db->trans_complete();
        return $trans;
    }
}
