<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance extends CI_Controller {
	
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

    public function index()
    {
        $data['main_content'] = 'hr/timekeeping/reports/index';
		$this->load->view('inc/navbar', $data); 
    }

	public function index_raw_data()
	{
		$data['main_content'] = 'hr/timekeeping/reports/raw_data/index';
		$this->load->view('inc/navbar', $data); 
	}
	public function raw_data()
	{
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$data['datas'] = $this->attendance_model->get_raw_datas($start_date,$end_date);
		$data['main_content'] = 'hr/timekeeping/reports/raw_data/view';
		$this->load->view('inc/navbar', $data);
	}

	public function index_attendance()
    {
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');

		if($this->form_validation->run() == FALSE)
		{
			$data['main_content'] = 'hr/timekeeping/reports/attendance/index';
			$this->load->view('inc/navbar', $data); 
		}
		else
		{
			if($this->attendance_model->generate_dates())
			{
				redirect('attendance/view_attendance');
			}
		}
       
    }

	public function view_attendance()
	{
        //$start_date = $this->input->post('start_date');
		//$end_date = $this->input->post('end_date');

		$data['employees'] = $this->attendance_model->get_employees_attendance();
		$data['main_content'] = 'hr/timekeeping/reports/attendance/view';
		$this->load->view('inc/navbar', $data);
	}

	public function add_manual_attendance()
	{
		if($this->attendance_model->add_manual_attendance())
		{
			$this->session->set_flashdata('success_msg', 'Attendance Successfully Added!');
			redirect('attendance/view_attendance');
		}
	}
	
		
}
