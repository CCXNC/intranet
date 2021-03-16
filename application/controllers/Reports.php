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
        if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data['start_date'] = $this->input->post('start_date');
			$data['end_date'] = $this->input->post('end_date');
            $data['leaves'] = $this->report_model->get_employees_leave($data['start_date'], $data['end_date']);
		}
		else                                      
		{                                       
			$data['start_date'] = date('Y-m-d');                         
			$data['end_date'] = date('Y-m-d');     
            $data['leaves'] = $this->report_model->get_employees_leaves();
		}    
       
        $data['main_content'] = 'hr/timekeeping/reports/slvl/index';
        $this->load->view('inc/navbar', $data);
    }

    public function add_slvl()
    {
        $this->form_validation->set_rules('employee', 'Employee Fullname', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Date of leave (Start)', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Date of leave (End)', 'trim|required');
        $this->form_validation->set_rules('day', 'Day', 'trim|required');
        $this->form_validation->set_rules('address_leave', 'Address While On Leave', 'trim|required');
        $this->form_validation->set_rules('reason', 'Reason', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $data['employees'] = $this->employee_model->get_employees();
            $data['main_content'] = 'hr/timekeeping/reports/slvl/add';
            $this->load->view('inc/navbar', $data);
        }   
        else 
        {
            if($this->report_model->add_slvl())
            {
                $this->session->set_flashdata('success_msg', 'LEAVE SUCCESSFULLY ADDED!');
                redirect('reports/index_slvl');
            }
        } 
    }

    public function view_slvl($id)
    {
        $data['leave'] = $this->report_model->get_employee_leave($id);
        $data['main_content'] = 'hr/timekeeping/reports/slvl/view';
        $this->load->view('inc/navbar', $data);
    }

    public function edit_employee_slvl($id)
    {
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('leave_date', 'Effective Date of leave', 'trim|required');
        $this->form_validation->set_rules('day', 'Day', 'trim|required');
        $this->form_validation->set_rules('address_leave', 'Address While On Leave', 'trim|required');
        $this->form_validation->set_rules('reason', 'Reason', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $data['leave'] = $this->report_model->get_employee_leave($id);
            $data['main_content'] = 'hr/timekeeping/reports/slvl/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->report_model->update_employee_leave($id))
            {
                $this->session->set_flashdata('success_msg', 'LEAVE SUCCESSFULLY UPDATED!');
                redirect('reports/index_slvl');
            }
        }    
    }

    public function delete_employee_slvl($id)
    {
        if($this->report_model->delete_employee_leave($id))
        {
            $this->session->set_flashdata('error_msg', 'LEAVE SUCCESSFULLY DELETED!');
            redirect('reports/index_slvl');
        }
    }

    public function process_ob()
    {
        foreach($this->input->post('ob') as $ob)
		{
			$explode_data = explode('|', $ob);

			$data = array(  
				'process_by' 	=> $this->session->userdata('username'),
				'process_date' => date('Y-m-d H:i:s'),
				'status'        => '1'
			);

            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
            $blaine_timekeeping->where('id', $explode_data[0]);
			$blaine_timekeeping->update('ob', $data);
		}
        $this->session->set_flashdata('success_msg', 'OB SUCCESSFULLY PROCESS!');
		redirect('reports/index_ob');
    }

    public function process_slvl()
    {
        foreach($this->input->post('leave') as $leave)
		{
			$explode_data = explode('|', $leave);

			$data = array(  
				'process_by' 	=> $this->session->userdata('username'),
				'process_date' => date('Y-m-d H:i:s'),
				'status'        => '1'
			);

            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
            $blaine_timekeeping->where('id', $explode_data[0]);
			$blaine_timekeeping->update('slvl', $data);
		}
        $this->session->set_flashdata('success_msg', 'LEAVE SUCCESSFULLY PROCESS!');
		redirect('reports/index_slvl');
    }

    public function index_individual_attendance()
    {
        $data['main_content'] = 'hr/timekeeping/reports/individual_attendance/index';
        $this->load->view('inc/navbar', $data);
    }
}
