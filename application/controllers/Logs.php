<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }

        if($this->session->userdata('access_level_id') == 3){
            redirect('productivity/index_softdev');
        }
    }

    public function index_logs()
    {
        $data['logs'] = $this->activity_model->get_logs();
        $data['main_content'] = 'logs/index';
        $this->load->view('inc/navbar', $data);
    }
}     