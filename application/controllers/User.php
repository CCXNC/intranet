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

    public function change_password($employee_number)
    {
        $this->db->select('*');
		$this->db->where('users.employee_number', $employee_number);
		$datas = $this->db->get('users');
        $password = $datas->row()->password;

        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $retype_password = $this->input->post('retype_password');
        $md5_password = md5($old_password);
        
        if($password != $md5_password)
        {
            $this->session->set_flashdata('error_msg', 'INCORRECT OLD PASSWORD!');
            redirect('user/index_change_password');
        }
        else
        {
            if($new_password == $retype_password)
            {
                if($this->user_model->change_password($employee_number))
                {
                    //$this->session->set_flashdata('update_msg', 'Password Successfully Updated!');
                    $this->session->sess_destroy();
                    redirect('login/index');
                }
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'The password and re-type password do not match!');
                redirect('user/index_change_password');
            }
           
        }
    } 

    public function index_my_attendance()
    {
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');

		if($this->form_validation->run() == FALSE)
		{
            $data['main_content'] = 'myattendance/index';
            $this->load->view('inc/navbar', $data);
		}
		else
		{
			if($this->attendance_model->myattendance_generate_dates())
			{
				redirect('user/view_my_attendance');
			}
		}
      
    }

    public function view_my_attendance()
    {
        $data['employees'] = $this->attendance_model->my_employee_time();
		$data['employee_name'] = $this->attendance_model->my_employee_name();

        $data['start_daily_attendance'] = $this->attendance_model->get_first_my_daily_attendance_date();
		$data['end_daily_attendance'] = $this->attendance_model->get_last_my_daily_attendance_date();

        $start_date = $data['start_daily_attendance']->first_date_daily_attendance;
		$end_date = $data['end_daily_attendance']->last_date_daily_attendance;
		$raw_employee_number = $data['start_daily_attendance']->raw_employee_number;
        
		$data['datas'] = $this->attendance_model->get_raw_datas_individual($raw_employee_number,$start_date,$end_date);

        $data['main_content'] = 'myattendance/view';
        $this->load->view('inc/navbar', $data);
    }
}