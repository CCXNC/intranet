<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    function index() {
        if($this->session->userdata('access_level_id')==='1') {
            $data['main_content'] = 'admin_view';
            $this->load->view('inc/navbar', $data);
        }else {
            echo "Access Denied!";
        }
    }

    public function admin_view()
    {
        $data['main_content'] = 'admin_view';
        $this->load->view('inc/navbar', $data);
    }
}
