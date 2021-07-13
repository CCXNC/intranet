<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    function index() {
        $data['main_content'] = 'dashboard';
        $this->load->view('inc/navbar', $data);
    }

    function hr_dashboard() {
        $data['male'] = $this->dashboard_model->get_employee_male();
        $data['female'] = $this->dashboard_model->get_employee_female();
        $data['employee'] = $this->dashboard_model->get_total_employees();
        $data['hr_teams'] = $this->dashboard_model->get_hr_employee();
        $data['employee_bdays'] = $this->dashboard_model->get_employee_month_bday();
        $data['employee_new_hires'] = $this->dashboard_model->get_new_hire();
        $data['baby_boomer'] = $this->dashboard_model->get_baby_boomer();
        $data['gen_x'] = $this->dashboard_model->get_generation_x();
        $data['millennial'] = $this->dashboard_model->get_millennials();
        $data['gen_z'] = $this->dashboard_model->get_generation_z();
        $data['main_content'] = 'hr/dashboard/index';
        $this->load->view('inc/navbar', $data);
    }

    public function get_rank()
    {
        $result = $this->dashboard_model->get_rank();
        echo json_encode($result);
    }

    public function get_gender()
    {
        $result = $this->dashboard_model->get_gender();
        echo json_encode($result);
       
    }

    public function get_department()
    {
        $result = $this->dashboard_model->get_department();
        echo json_encode($result);
    }

}
