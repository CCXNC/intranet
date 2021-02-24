<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv_import extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('csv_import_model');
		$this->load->library('csvimport');
	}

	function index()
	{
		$data['main_content'] = 'hr/timekeeping/csv/add';
        $this->load->view('inc/navbar', $data);
	}

	function import()
	{
		$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
		foreach($file_data as $row)
		{
			$data[] = array( 
				'biometric_id'	    =>	$row["Biometric"],
				'date_time'			=>	$row["Date/Time"],
				'status'			=>	$row["Cat1"]. '' .$row["Cat2"] . '' .$row["Cat3"] . '' .$row["Cat4"],
			);

		}
		$this->csv_import_model->insert($data);
	}

	public function view()
	{
		$data['attendances'] = $this->csv_import_model->get_attendance_logs();
		//$data['in'] = $this->csv_import_model->get_last_in();
		//$data['out'] = $this->csv_import_model->get_last_out();
		$data['main_content'] = 'hr/timekeeping/csv/view';
		$this->load->view('inc/navbar', $data);
	}

	public function add_employees_attendance()
	{
		$this->csv_import_model->add_employees_attendance();
	}

	public function index_attendance()
	{
		$data['employees'] = $this->csv_import_model->get_attendances();
		$data['main_content'] = 'hr/timekeeping/reports/index';
		$this->load->view('inc/navbar', $data);
	}
	
		
}
