<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv_import extends CI_Controller {
	
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
		/*ini_set('max_execution_time', 0); // to get unlimited php script execution time

		$test = count($file_data);
		if(empty($_SESSION['i'])){
			$_SESSION['i'] = 0;
		}

		$total = 100;
		for($i=$_SESSION['i'];$i<=$total;$i++)
		{
			$_SESSION['i'] = $i;
			$percent = intval($i/$total * 100)."%";   
			
			sleep(1); // Here call your time taking function like sending bulk sms etc.

			echo '<script>
			parent.document.getElementById("progressbar").innerHTML="<div style=\"width:'.$percent.';background:linear-gradient(to bottom, rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); ;height:35px;\">&nbsp;</div>";
			parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\">'.$percent.' is processed.</div>";</script>';

			ob_flush(); 
			flush(); 
			
		}*/
		$this->csv_import_model->insert($data);
	}

	public function view()
	{
		$data['attendances'] = $this->csv_import_model->get_attendance_logs();
		$data['raw_attendances'] = $this->csv_import_model->get_raw_attendance_logs();
		//$data['in'] = $this->csv_import_model->get_last_in();
		//$data['out'] = $this->csv_import_model->get_last_out();
		$data['main_content'] = 'hr/timekeeping/csv/view';
		$this->load->view('inc/navbar', $data);
	}

	public function add_employees_attendance()
	{
		if($this->csv_import_model->add_employees_attendance())
		{
			$this->session->set_flashdata('success_msg', 'Attendance Successfully Process!');
			redirect('attendance/index_attendance');

			/*ini_set('max_execution_time', 0); // to get unlimited php script execution time

			if(empty($_SESSION['i'])){
				$_SESSION['i'] = 0;
			}

			$total = 100;
			for($i=$_SESSION['i'];$i<=$total;$i++)
			{
				$_SESSION['i'] = $i;
				$percent = intval($i/$total * 100)."%";   
				
				sleep(1); // Here call your time taking function like sending bulk sms etc.

				echo '<script>
				parent.document.getElementById("progressbar").innerHTML="<div style=\"width:'.$percent.';background:linear-gradient(to bottom, rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); ;height:35px;\">&nbsp;</div>";
				parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\">'.$percent.' is processed.</div>";</script>';

				//ob_flush(); 
				flush();
				
			} */
		}
	}

	public function index_attendance()
	{
		$data['employees'] = $this->csv_import_model->get_attendances();
		$data['main_content'] = 'hr/timekeeping/reports/index';
		$this->load->view('inc/navbar', $data);
	}

	public function delete_temp_attendance()
	{
		if($this->csv_import_model->delete_attendance_logs())
		{
			$this->session->set_flashdata('error_msg', 'Attendance Successfully Deleted!');
			redirect('csv_import/index');
		}
	}
	
		
}
