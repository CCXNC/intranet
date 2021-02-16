<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timekeeping extends CI_Controller {
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

    function index() 
    {
        $data['main_content'] = 'hr/timekeeping/index';
        $this->load->view('inc/navbar', $data);
    }
}
