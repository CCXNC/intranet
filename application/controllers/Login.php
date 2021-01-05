<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct(); 
        $this->load->model('Login_model');
    }

	public function index()
	{
		$this->load->view('login');
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
            $sesdata = array(
                'username' => $username,
                'employee_number' => $employee_number,
                'access_level_id' => $access_level_id,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($sesdata);
            redirect('dashboard/index');
        } else {
            echo "<script>alert('Incorrect Username or Password!');history.go(-1);</script>";
        }
        $this->load->view('login_view');
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('Login');
    }
}
