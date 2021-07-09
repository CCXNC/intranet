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

   

}
