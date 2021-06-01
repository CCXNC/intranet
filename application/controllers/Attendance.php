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

	public function add_individual_manual_attendance()
	{
		$attendance = $this->input->post('attendance');
		if($this->attendance_model->add_individual_manual_attendance())
		{
			if($attendance == 1)
			{
				$this->session->set_flashdata('success_msg', 'Manual Attendance Successfully Added!');
				redirect('attendance/view_individual_attendance');
			}
			elseif($attendance == 2)
			{
				$this->session->set_flashdata('success_msg', 'Attendance Successfully Updated!');
				redirect('attendance/view_individual_attendance');
			}
			elseif($attendance == 3)
			{
				$this->session->set_flashdata('error_msg', 'Attendance Successfully Deleted!');
				redirect('attendance/view_individual_attendance');
			}
		
		}
	}
	

	public function index_individual_attendance()
    {
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');

		if($this->form_validation->run() == FALSE)
		{
			$data['employees'] = $this->employee_model->get_employees();
			$data['main_content'] = 'hr/timekeeping/reports/individual_attendance/index';
			$this->load->view('inc/navbar', $data);
		}
		else
		{
			if($this->attendance_model->individual_generate_dates())
			{
				redirect('attendance/view_individual_attendance');
			}
		}
       
    }

    public function view_individual_attendance()
    {
		$data['employees'] = $this->attendance_model->employee_time();
		$data['employee_name'] = $this->attendance_model->employee_name();
		$data['employee_leaves'] = $this->attendance_model->employee_absence();
		$data['employee_obs'] = $this->attendance_model->employee_ob();
		$data['employee_ut'] = $this->attendance_model->employee_ut();
		$data['employee_ot'] = $this->attendance_model->employee_ot();
		/*$data['total_absences'] = $this->attendance_model->get_total_absences();
		$data['total_sl'] = $this->attendance_model->get_total_sl();
		$data['total_vl'] = $this->attendance_model->get_total_vl();
		$data['total_ml'] = $this->attendance_model->get_total_ml();
		$data['total_pl'] = $this->attendance_model->get_total_pl();
		$data['total_bl'] = $this->attendance_model->get_total_bl();
		$data['total_spl'] = $this->attendance_model->get_total_spl();*/
        $data['main_content'] = 'hr/timekeeping/reports/individual_attendance/view';
        $this->load->view('inc/navbar', $data);
    }
	
		
}
