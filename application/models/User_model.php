<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function change_password($employee_number)
    {
        $this->db->trans_start();
        $new_password = $this->input->post('new_password');
      
        $md5_password = md5($new_password);

        $data = array(
            'password' => $md5_password
        );

        $this->db->where('employee_number', $employee_number);
        $this->db->update('users',$data);

        $trans = $this->db->trans_complete();
		return $trans;
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

        // CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 

		$entry_data = "reset_password [entry_id:" . $employee_number . "]";
        $date = date('Y-m-d H:i:s');
		$activity_data = array(
			'username'   => $this->session->userdata('username'),
			'pcname'     => gethostname(),
			'entry_data' => $entry_data,
			'entry_date' => $date
		);
		$activity_log->insert('hris_logs', $activity_data);

        $trans = $this->db->trans_complete();
        return $trans;
    }

}
