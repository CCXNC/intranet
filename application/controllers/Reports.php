<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('csv_import_model');
		$this->load->library('csvimport');

        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }

        if($this->session->userdata('access_level_id') == 3){
            redirect('homepage');
        }
	}

	public function index_ob()
	{
		$data['main_content'] = 'hr/timekeeping/reports/ob/index';
		$this->load->view('inc/navbar', $data); 
	}	

    public function add_ob()
    {
        $data['main_content'] = 'hr/timekeeping/reports/ob/add';
        $this->load->view('inc/navbar', $data);
    }

    public function view_ob()
    {
        $data['main_content'] = 'hr/timekeeping/reports/ob/view';
        $this->load->view('inc/navbar', $data);
    }

    public function index_slvl()
    {
        $data['main_content'] = 'hr/timekeeping/reports/slvl/index';
        $this->load->view('inc/navbar', $data);
    }

    public function add_slvl()
    {
        $data['main_content'] = 'hr/timekeeping/reports/slvl/add';
        $this->load->view('inc/navbar', $data);
    }

    public function view_slvl()
    {
        $data['main_content'] = 'hr/timekeeping/reports/slvl/view';
        $this->load->view('inc/navbar', $data);
    }
}
