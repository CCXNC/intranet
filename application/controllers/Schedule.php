<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }

        if($this->session->userdata('access_level_id') == 3){
            redirect('homepage');
        }
    }

    public function index()
    {
        $data['employees'] = $this->schedule_model->get_no_biometric_employees();
        $data['schedules'] = $this->schedule_model->get_employees_schedule();
        $data['main_content'] = 'hr/timekeeping/schedule/index';
        $this->load->view('inc/navbar', $data);
    }
 
    public function add_schedule()
    {
        $this->form_validation->set_rules('employee_number', 'Employee Number', 'trim|required');
        $this->form_validation->set_rules('employee_number', 'Employee Number', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $data['schedules'] = $this->schedule_model->get_employees_schedule_select();
            $data['main_content'] = 'hr/timekeeping/schedule/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->schedule_model->add_employee_schedule())
            {
                $this->session->set_flashdata('success_msg','EMPLOYEE SCHEDULE SUCCESSFULLY ADDED!');
                redirect('schedule/index');
            }
        }
       
    }

    public function add_biometric()
    {
        $this->form_validation->set_rules('biometric_number', 'Biometric Number', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $data['employees'] = $this->schedule_model->get_no_biometric_employees();
            $data['schedules'] = $this->schedule_model->get_employees_schedule();
            $data['main_content'] = 'hr/timekeeping/schedule/index';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->schedule_model->add_biometric())
            {
                $this->session->set_flashdata('success_msg','EMPLOYEE BIOMETRIC SUCCESSFULLY ADDED!');
                redirect('schedule/index');
            }
        }
    }

}    