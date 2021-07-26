<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');

        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    function local_procurement() 
    {
        $data['main_content'] = 'procurement/local/index';
        $this->load->view('inc/navbar', $data);
    }
    
    function ecanvass_index()
    {
        $data['main_content'] = 'procurement/local/ecanvass/index';
        $this->load->view('inc/navbar', $data);
    }

    function form_index()
    {
        $data['main_content'] = 'procurement/local/ecanvass/form/index';
        $this->load->view('inc/navbar', $data);
    }

    function form_add()
    {
        $data['main_content'] = 'procurement/local/ecanvass/form/add';
        $this->load->view('inc/navbar', $data);
    }
}
