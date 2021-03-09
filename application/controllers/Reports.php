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
		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data['start_date'] = $this->input->post('start_date');
			$data['end_date'] = $this->input->post('end_date');
            $data['obs'] = $this->report_model->get_employees_ob($data['start_date'], $data['end_date']);
		}
		else                                      
		{                                       
			$data['start_date'] = date('Y-m-d');                         
			$data['end_date'] = date('Y-m-d');     
            $data['obs'] = $this->report_model->get_employees_obs();
		}     
        //$data['obs'] = $this->report_model->get_employees_ob($data['start_date'], $data['end_date']);
        $data['main_content'] = 'hr/timekeeping/reports/ob/index';
        $this->load->view('inc/navbar', $data);
	}	

    public function add_ob()
    {
        $this->form_validation->set_rules('employee', 'Employee Fullname', 'trim|required');
        $this->form_validation->set_rules('date_of_ob', 'Date OB', 'trim|required');
        $this->form_validation->set_rules('destination', 'Destination', 'trim|required');
        $this->form_validation->set_rules('purpose', 'Purpose', 'trim|required');
        $this->form_validation->set_rules('transport', 'Transport', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $data['employees'] = $this->employee_model->get_employees();
            $data['main_content'] = 'hr/timekeeping/reports/ob/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->report_model->add_ob())
            {
                $this->session->set_flashdata('success_msg', 'OB SUCCESSFULLY ADDED!');
                redirect('reports/index_ob');
            }
        }
    }

    public function edit_employee_ob($id)
    {
        $this->form_validation->set_rules('date_of_ob', 'Date OB', 'trim|required');
        $this->form_validation->set_rules('destination', 'Destination', 'trim|required');
        $this->form_validation->set_rules('purpose', 'Purpose', 'trim|required');
        $this->form_validation->set_rules('transport', 'Transport', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $data['ob'] = $this->report_model->get_employee_ob($id);
            $data['main_content'] = 'hr/timekeeping/reports/ob/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->report_model->update_employee_ob($id))
            {
                $this->session->set_flashdata('success_msg', 'OB SUCCESSFULLY UPDATED!');
                redirect('reports/index_ob');
            }
        }    
    }

    public function view_employee_ob($id)
    {
        $data['ob'] = $this->report_model->get_employee_ob($id);
        $data['main_content'] = 'hr/timekeeping/reports/ob/view';
        $this->load->view('inc/navbar', $data);
    }

    public function delete_employee_ob($id)
    {
        if($this->report_model->delete_employee_ob($id))
        {
            $this->session->set_flashdata('error_msg', 'OB SUCCESSFULLY DELETED!');
            redirect('reports/index_ob');
        }
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
