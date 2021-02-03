<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct(); 
        $this->load->model('Login_model');
        date_default_timezone_set('Asia/Manila');
    }

    function index() {
        $data['announcements'] = $this->login_model->get_announcements();
        $this->load->view('login/index', $data);
    
    }

    function auth() {

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $result = $this->Login_model->check_user($username, $password);

        if($result->num_rows() > 0) {

            $data = $result->row_array();
            $username = $data['username'];
            $employee_number = $data['employee_number'];
            $access_level_id = $data['access_level_id'];
            $emp_id = $data['emp_id'];
            $company_id = $data['company_id'];
            $department_id = $data['department_id'];

            $sesdata = array(
                'username' => $username,
                'employee_number' => $employee_number,
                'access_level_id' => $access_level_id,
                'logged_in' => TRUE,
                'emp_id' => $emp_id,
                'company_id' => $company_id,
                'department_id' => $department_id
            );

            $this->session->set_userdata($sesdata);

            $this->login_model->user_login();
            redirect('homepage/index');
            
        } else {

            echo "<script>alert('Incorrect Username or Password!');history.go(-1);</script>";
        }

        $this->load->view('login/index');
    }

    function logout() {
        $this->login_model->user_logout();
        $this->session->sess_destroy();
        redirect('login/index');
    }
}
