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
            employees.id as emp_id,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) as fullname,
            employment_info.company as company_id,
            employment_info.department as department_id,
        "); 
        $this->db->from('users');
        $this->db->join('employees', 'employees.employee_number = users.employee_number','left');
        $this->db->join('employment_info', 'employment_info.employee_number = users.employee_number','left');
        $this->db->where('users.username', $username);
        $this->db->where('users.password', md5($password));
        $query = $this->db->get(); 
        return $query;
    }

    public function get_announcements()
	{
        $this->db->where('is_active', 1);
        $this->db->where('category', "loginpage");
        $this->db->order_by('created_date', 'DESC');
		$query = $this->db->get('announcement', 3);

		return $query->result();
    }
    
    public function user_login()
    {
        $this->db->trans_start();

        // CALL ACVITIY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE); 

        $date = date('Y-m-d H:i:s');

        $data = array(
            'username' => $this->session->userdata('username'),
            'pcname'   => $_SERVER['REMOTE_ADDR'],
            'type'     => 'Login',
            'date'     => $date
        );

        $activity_log->insert('user_log', $data);
        
        $trans = $this->db->trans_complete();

        return $trans;
        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/
    }

    public function user_logout()
    {
        $this->db->trans_start();

        // CALL ACVITIY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE); 

        $date = date('Y-m-d H:i:s');

        $data = array(
            'username' => $this->session->userdata('username'),
            'pcname'   => $_SERVER['REMOTE_ADDR'],
            'type'     => 'Logout',
            'date'     => $date
        );

        $activity_log->insert('user_log', $data);
        
        $trans = $this->db->trans_complete();

        return $trans;
        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/
    }

}
