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
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
        //$this->form_validation->set_rules('destination', 'Destination', 'trim|required');
        //$this->form_validation->set_rules('purpose', 'Purpose', 'trim|required');
        //$this->form_validation->set_rules('transport', 'Transport', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $data['employees'] = $this->employee_model->get_employees();
            $data['main_content'] = 'hr/timekeeping/reports/ob/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            $this->report_model->add_ob();
        }
    }

    public function edit_employee_ob_fw($id)
    {
        $this->form_validation->set_rules('date_of_ob', 'Date OB', 'trim|required');
        //$this->form_validation->set_rules('destination', 'Destination', 'trim|required');
        //$this->form_validation->set_rules('purpose', 'Purpose', 'trim|required');
        //$this->form_validation->set_rules('transport', 'Transport', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $data['ob'] = $this->report_model->get_employee_ob($id);
            $data['main_content'] = 'hr/timekeeping/reports/ob/edit_fw';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->report_model->update_employee_ob_fw($id))
            {
                $this->session->set_flashdata('success_msg', 'DATA SUCCESSFULLY UPDATED!');
                redirect('reports/index_ob');
            }
        }    
    }

    public function edit_employee_ob_wfh($id)
    {
        $this->form_validation->set_rules('date_of_ob', 'Date OB', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $data['ob'] = $this->report_model->get_employee_ob($id);
            $data['main_content'] = 'hr/timekeeping/reports/ob/edit_wfh';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->report_model->update_employee_ob_wfh($id))
            {
                $this->session->set_flashdata('success_msg', 'DATA SUCCESSFULLY UPDATED!');
                redirect('reports/index_ob');
            }
        }    
    }

    public function view_employee_ob_fw($id)
    {
        $data['ob'] = $this->report_model->get_employee_ob($id);
        $data['main_content'] = 'hr/timekeeping/reports/ob/view_fw';
        $this->load->view('inc/navbar', $data);
    }

    public function view_employee_ob_wfh($id)
    {
        $data['ob'] = $this->report_model->get_employee_ob($id);
        $data['main_content'] = 'hr/timekeeping/reports/ob/view_wfh';
        $this->load->view('inc/navbar', $data);
    }

    public function delete_employee_ob($id)
    {
        if($this->report_model->delete_employee_ob($id))
        {
            $this->session->set_flashdata('error_msg', 'DATA SUCCESSFULLY DELETED!');
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
        //$this->form_validation->set_rules('address_leave', 'Address While On Leave', 'trim|required');
        $this->form_validation->set_rules('reason', 'Reason', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $data['employees'] = $this->employee_model->get_employees();
            $data['main_content'] = 'hr/timekeeping/reports/slvl/add';
            $this->load->view('inc/navbar', $data);
        }   
        else 
        {
            $this->report_model->add_slvl();
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
        //$this->form_validation->set_rules('address_leave', 'Address While On Leave', 'trim|required');
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

    public function index_ot()
    {
        if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data['start_date'] = $this->input->post('start_date');
			$data['end_date'] = $this->input->post('end_date');
            $data['ots'] = $this->report_model->get_employees_ot($data['start_date'], $data['end_date']);
		}
		else                                      
		{                                       
			$data['start_date'] = date('Y-m-d');                         
			$data['end_date'] = date('Y-m-d');     
            $data['ots'] = $this->report_model->get_employees_ots();
		}    
        
        $data['main_content'] = 'hr/timekeeping/reports/overtime/index';
        $this->load->view('inc/navbar', $data);
    }

    public function cutoff_ot()
    {
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $data['main_content'] = 'hr/timekeeping/reports/overtime/ot_cutoff';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->attendance_model-> generate_overtime_dates())
            {
                $this->session->set_flashdata('success_msg', 'OVERTIME EXTRACTION SUCCESSFULLY ADDED!');
                redirect('reports/index_ot');  
            }
        }
      
    }

    public function add_ot()
    {
        $this->form_validation->set_rules('employee', 'Employee Name', 'trim|required');
        //$this->form_validation->set_rules('ot_type', 'OT TYPE', 'trim|required');
        //$this->form_validation->set_rules('ot_num', 'Estimated Number of Hours', 'trim|required');
        //$this->form_validation->set_rules('task', 'Specific Task To Be Done', 'trim|required');

        if($this->form_validation->run() == FALSE) 
        {
            $data['employees'] = $this->employee_model->get_employees();
            $data['main_content'] = 'hr/timekeeping/reports/overtime/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->report_model->add_overtime())
            {
               $this->session->set_flashdata('success_msg', 'OVERTIME SUCCESSFULLY ADDED!');
               redirect('reports/index_ot');
            }
        }    
    }

    public function edit_employee_ot($id)
    {
        $this->form_validation->set_rules('date_ot', 'Date of Overtime', 'trim|required');

        if($this->form_validation->run() == FALSE) 
        {
            $data['ot'] = $this->report_model->get_employee_ot($id);
            $data['main_content'] = 'hr/timekeeping/reports/overtime/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->report_model->update_overtime($id))
            {
                $this->session->set_flashdata('success_msg', 'OVERTIME SUCCESSFULLY UPDATED!');
                redirect('reports/index_ot');
            }
        }    
       
    }

    public function delete_employee_ot($employee_number,$date)
    {
        if($this->report_model->delete_employee_ot($employee_number,$date))
        {
            $this->session->set_flashdata('error_msg', 'OVERTIME SUCCESSFULLY DELETED!');
            redirect('reports/index_ot');
        }
    }
    public function view_employee_ot($id)
    {
        $data['ot'] = $this->report_model->get_employee_ot($id);
        $data['main_content'] = 'hr/timekeeping/reports/overtime/view';
        $this->load->view('inc/navbar', $data);
    }


    public function index_ut()
    {
        if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data['start_date'] = $this->input->post('start_date');
			$data['end_date'] = $this->input->post('end_date');
            $data['uts'] = $this->report_model->get_employees_undertime($data['start_date'], $data['end_date']);
		}
		else                                      
		{                                       
			$data['start_date'] = date('Y-m-d');                         
			$data['end_date'] = date('Y-m-d');     
            $data['uts'] = $this->report_model->get_employees_uts();
		}     

        $data['main_content'] = 'hr/timekeeping/reports/undertime/index';
        $this->load->view('inc/navbar', $data);
    }

    public function add_ut()
    {
        $this->form_validation->set_rules('employee', 'Employee Fullname', 'trim|required');
        $this->form_validation->set_rules('date_ut', 'Date Ut', 'trim|required');
        $this->form_validation->set_rules('time_start', 'Time Start', 'trim|required');
        $this->form_validation->set_rules('time_end', 'Time End', 'trim|required');
        $this->form_validation->set_rules('reason', 'Reason', 'trim|required');

        if($this->form_validation->run() == FALSE) 
        {
            $data['employees'] = $this->employee_model->get_employees();
            $data['main_content'] = 'hr/timekeeping/reports/undertime/add';
            $this->load->view('inc/navbar', $data);
        }
        else 
        {
            if($this->report_model->add_undertime())
            {
                $this->session->set_flashdata('success_msg', 'UNDERTIME SUCCESSFULLY ADDED!');
                redirect('reports/index_ut');
            }
        }
    }

    public function view_employee_ut($id)
    {
        $data['ut'] = $this->report_model->get_employee_ut($id);
        $data['main_content'] = 'hr/timekeeping/reports/undertime/view';
        $this->load->view('inc/navbar', $data);
    }

    public function edit_employee_ut($id)
    {
        $this->form_validation->set_rules('date_ut', 'Date Ut', 'trim|required');
        $this->form_validation->set_rules('time_start', 'Time Start', 'trim|required');
        $this->form_validation->set_rules('time_end', 'Time End', 'trim|required');
        $this->form_validation->set_rules('reason', 'Reason', 'trim|required');

        if($this->form_validation->run() == FALSE) 
        {
            $data['ut'] = $this->report_model->get_employee_ut($id);
            $data['main_content'] = 'hr/timekeeping/reports/undertime/edit';
            $this->load->view('inc/navbar', $data);
        }    
        else 
        {
            if($this->report_model->update_employee_undertime($id))
            {
                $this->session->set_flashdata('success_msg', 'UNDERTIME SUCCESSFULLY UPDATED!');
                redirect('reports/index_ut'); 
            }
        }
    }

    public function delete_employee_ut($id)
    {
        if($this->report_model->delete_employee_undertime($id))
        {
            $this->session->set_flashdata('error_msg', 'UNDERTIME SUCCESSFULLY DELETED!');
            redirect('reports/index_ut');
        }
    }

    public function process_ut()
    {
        foreach($this->input->post('ut') as $ut)
		{
			$explode_data = explode('|', $ut);

			$data = array(  
				'process_by' 	=> $this->session->userdata('username'),
				'process_date'  => date('Y-m-d H:i:s'),
				'status'        => '1'
			);

            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
            $blaine_timekeeping->where('id', $explode_data[0]);
			$blaine_timekeeping->update('undertime', $data);
		}
        
        $this->session->set_flashdata('success_msg', 'LEAVE SUCCESSFULLY PROCESS!');
		redirect('reports/index_ut');
    }


    public function employees_summary_list()
    {
        $data['employees'] = $this->employee_model->get_employees_wc_otp();
        $data['main_content'] = 'hr/timekeeping/reports/summary_list/index';
        $this->load->view('inc/navbar', $data);
    }
}
