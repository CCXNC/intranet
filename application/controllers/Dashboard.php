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
        $data['main_content'] = 'hr/dashboard/index';
        $this->load->view('inc/navbar', $data);
    }
}
