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

    public function add_transmittal()
    {
        $data['main_content'] = 'procurement/local/ecanvass/transmittal/add';
        $this->load->view('inc/navbar', $data);
    }

    public function add_ecanvass_report_generation()
    {
        $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/add';
        $this->load->view('inc/navbar', $data);
    }

    public function add_ecanvass_report_generation1()
    {
        $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/add1';
        $this->load->view('inc/navbar', $data);
    }

    public function ecanvass_cost_saving()
    {
        $data['main_content'] = 'procurement/local/ecanvass/cost_saving/index';
        $this->load->view('inc/navbar', $data);
    }

    public function material_canvass()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_canvass/index';
        $this->load->view('inc/navbar', $data);
    }

}