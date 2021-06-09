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

    public function edit_schedule($id)
    {
        $this->form_validation->set_rules('time_in', 'Time In', 'trim|required');
        $this->form_validation->set_rules('time_out', 'Time Out', 'trim|required');
        $this->form_validation->set_rules('grace_period', 'Grace Period', 'trim|required');
        $this->form_validation->set_rules('effective_date', 'Effective Date', 'trim|required');

        if($this->form_validation->run() ==  FALSE)
        {
            $data['schedule'] = $this->schedule_model->get_employee_schedule($id);
            $data['main_content'] = 'hr/timekeeping/schedule/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->schedule_model->update_employee_schedule($id))
            {
                $this->session->set_flashdata('success_msg','EMPLOYEE SCHEDULE SUCCESSFULLY UPDATED!');
                redirect('schedule/index');
            }
        }
    }

    public function update_employee_flexi_time($id)
    {
        if($this->schedule_model->update_employee_flexi_time($id))
        {
            $this->session->set_flashdata('success_msg','EMPLOYEE FLEXIBLE SCHEDULE SUCCESSFULLY UPDATED!');
            redirect('schedule/index');
        }
    }

    public function update_employee_regular_time($id)
    {
        if($this->schedule_model->update_employee_regular_time($id))
        {
            $this->session->set_flashdata('success_msg','EMPLOYEE REGULAR SCHEDULE SUCCESSFULLY UPDATED!');
            redirect('schedule/index');
        }
    }

    public function edit_biometric($employee_number)
    {
        $this->form_validation->set_rules('biometric_id', 'Biometric ID', 'trim|required');

        if($this->form_validation->run() ==  FALSE)
        {
            $data['bio'] = $this->schedule_model->get_employee_biometric($employee_number);
            $data['main_content'] = 'hr/timekeeping/schedule/edit_biometric';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->schedule_model->update_employee_biometric($employee_number))
            {
                $this->session->set_flashdata('success_msg','EMPLOYEE BIOMETRIC SUCCESSFULLY UPDATED!');
                redirect('schedule/index');
            }
        }
       
    }

    public function view_schedule($id,$employee_number)
    {
        $data['schedule'] = $this->schedule_model->get_employee_schedule($id);
        $data['schedules'] = $this->schedule_model->get_employee_schedules($employee_number);
        $data['main_content'] = 'hr/timekeeping/schedule/view';
        $this->load->view('inc/navbar', $data);
    }

    public function ui_sample($employee_number)
    {
        $data['employee_schedule'] = $this->schedule_model->get_employee_biometric($employee_number);
        $data['main_content'] = 'hr/timekeeping/schedule/index_schedule';
        $this->load->view('inc/navbar', $data);
    }

    public function add_employee_schedule($employee_number)
    {
        $this->form_validation->set_rules('employee_number', 'Employee Number', 'trim|required');
        
        if($this->form_validation->run() ==  FALSE)
        {
            $data['employee_schedule'] = $this->schedule_model->get_employee_biometric($employee_number);
            $data['main_content'] = 'hr/timekeeping/schedule/add_schedule';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->schedule_model->add_employee_schedules($employee_number))
            {
                $this->session->set_flashdata('success_msg','EMPLOYEE SCHEDULE SUCCESSFULLY ADDED!');
                redirect('schedule/index');
            }
        }
    
    }

}    