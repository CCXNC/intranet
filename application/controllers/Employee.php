<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    function index() {
        $data['employees'] = $this->employee_model->get_employees();
        $data['main_content'] = 'hr/employee/index';
        $this->load->view('inc/navbar', $data);
    }

    function do_upload() {

        $this->form_validation->set_rules('employee_number', 'Employee Number', 'required|trim');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');
        $this->form_validation->set_rules('birthday', 'BirthDate', 'required|trim');
        $this->form_validation->set_rules('age', 'Age', 'required|trim');
        $this->form_validation->set_rules('religion', 'Religion', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('marital_status', 'Marital Status', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');
        $this->form_validation->set_rules('father_full_name', 'Father Full Name', 'required|trim');
        $this->form_validation->set_rules('mother_full_name', 'Mother Full Name', 'required|trim');
        $this->form_validation->set_rules('emergency_name', 'Emergency Full Name', 'required|trim');
        $this->form_validation->set_rules('emergency_contact', 'Emergency Contact', 'required|trim');
        $this->form_validation->set_rules('school', 'School', 'required|trim');
        $this->form_validation->set_rules('course', 'Course', 'required|trim');
        $this->form_validation->set_rules('year_graduated', 'Year Graduated', 'required|trim');
        $this->form_validation->set_rules('date_hired', 'Date Hired', 'required|trim');
        $this->form_validation->set_rules('company', 'Business Unit', 'required|trim');
        $this->form_validation->set_rules('position', 'Position', 'required|trim');
        $this->form_validation->set_rules('rank', 'Rank', 'required|trim');
        $this->form_validation->set_rules('employee_status', 'Employee Status', 'required|trim');

        $config = array(
            'upload_path' => './uploads/images/',
            'allowed_types' => "gif|jpg|png|jpeg|pdf|xls|xlsx",
            'overwrite' => TRUE,
            'max_size' => "100000000",
            'max_height' => "768",
            'max_width' => "1024"
        );
        $this->upload->initialize($config);
        if($this->upload->do_upload())
        {
            $data = array('upload_data' => $this->upload->data());
        }
        else
        {
            $error = array('error' => $this->upload->display_errors());
        }
        
        
        if($this->form_validation->run() == FALSE)
        {
            $data['main_content'] = 'hr/employee/add';
            $data['departments'] = $this->employee_model->get_department();
            $data['companies'] = $this->employee_model->get_company();
            $data['ranks'] = $this->employee_model->get_rank();
            $data['statuss'] = $this->employee_model->get_employee_status();
            $data['groups'] = $this->employee_model->get_work_group();
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            $this->employee_model->add_employee();
            $this->session->set_flashdata('success_msg', 'Employee Successfully Added!');
            redirect('employee/index');
        }
        
    
    }
}
