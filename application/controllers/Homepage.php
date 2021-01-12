<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }


    function index() {
        $data['announcements'] = $this->homepage_model->get_announcements();
        $data['main_content'] = 'homepage';
        $this->load->view('inc/navbar', $data);
    
    }
}
