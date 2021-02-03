<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    public function index_change_password()
    {
        $data['main_content'] = 'hr/employee/change_password';
        $this->load->view('inc/navbar', $data);
     
    }

    public function change_password($id,$employee_number)
    {
        $this->db->select('*');
		$this->db->where('users.employee_number', $employee_number);
		$datas = $this->db->get('users');
        $password = $datas->row()->password;

        $old_password = $this->input->post('old_password');
        $md5_password = md5($old_password);
        
        if($password != $md5_password)
        {
            $this->session->set_flashdata('error_msg', 'INCORRECT OLD PASSWORD!');
            redirect('homepage/index_change_password');
        }
        else
        {
            if($this->user_model->change_password($employee_number))
            {
                //$this->session->set_flashdata('update_msg', 'Password Successfully Updated!');
                $this->session->sess_destroy();
                redirect('login/index');
            }
        }
    }

    public function reset_password($employee_number)
    {
        if($this->user_model->reset_to_default_password($employee_number))
        {
            $this->session->set_flashdata('success_msg', 'Reset Password Successfully Complete!');
            redirect('employee/index');
        }
    }
}