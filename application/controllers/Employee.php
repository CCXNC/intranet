<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    function index() {

        // Get record count
	 	$this->load->library('pagination');

	 	$total_rows = $this->db->count_all('employees');
	 	$limit = 10;
	 	$start = $this->uri->segment(3);

	 	$this->db->order_by('employees.last_name','asc');
	 	$this->db->limit($limit, $start);
	 	//$keyword    =   $this->input->post('keyword');
	 	//$this->db->like('name', $keyword);

         $this->db->select("
            employees.id as id,
            employees.picture as picture,
            employees.employee_number as emp_no,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            employment_info.date_hired as date_hired,
            employee_status.name as employee_status,
            employment_info.position as position,

            company.name as company,
            department.name as department,

        ");
        $this->db->from('employees');
        $this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number');
        $this->db->join('employee_status', 'employment_info.employee_status = employee_status.id');
        $this->db->join('company', 'employment_info.company = company.id');
        $this->db->join('department', 'employment_info.department = department.id');
        $this->db->order_by('employees.last_name', 'ASC');
        $this->db->where('employees.is_active', 1);
        
	  	$query = $this->db->get();
	 	$data['employees'] = $query->result();
	  	$config['base_url']   = 'http://localhost/blaineintranet/Employee/index';
	  	$config['total_rows'] = $total_rows;
	  	$config['per_page']   = $limit;

	  	$config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
            
        $config['first_link'] = 'First Page';
        $config['first_tag_open'] = '<span class="btn btn-light firstlink">';
        $config['first_tag_close'] = '</span>';
            
        $config['last_link'] = 'Last Page';
        $config['last_tag_open'] = '<li class=" btn btn-light lastlink">';
        $config['last_tag_close'] = '</li>';
            
        $config['next_link'] = 'Next Page';
        $config['next_tag_open'] = '<li class=" btn btn-light nextlink">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = 'Prev Page';
        $config['prev_tag_open'] = '<span class="btn btn-light prevlink">';
        $config['prev_tag_close'] = '</span>';

        $config['cur_tag_open'] = '<li class="btn btn-light curlink">';
        $config['cur_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li class="btn btn-light numlink">';
        $config['num_tag_close'] = '</li>';
	  
	  	$this->pagination->initialize($config);	
        $data['main_content'] = 'hr/employee/index';
        $this->load->view('inc/navbar', $data);

        /*if($this->input->server('REQUEST_METHOD') == 'POST')
		{ 
            $data['employee_status'] = $this->input->post('employee_status');
            $data['department'] = $this->input->post('department');
		}
		else 
		{
            $data['department'] = 'ALL';
			$data['employee_status'] = 'ALL';
        }*/

        /*$data['employees'] = $this->employee_model->get_employees();
        $data['main_content'] = 'hr/employee/index';
        $this->load->view('inc/navbar', $data);*/
    }

    public function view_employee($id,$employee_number) 
    {
        $data['employee'] = $this->employee_model->get_employee($id);
        $data['academe_infos'] = $this->employee_model->get_academe_infos($employee_number);
        $data['children_infos'] = $this->employee_model->get_children_infos($employee_number);
        $data['transfer'] = $this->employee_model->get_transfer_logs($employee_number);
        $data['main_content'] = 'hr/employee/view';
        $this->load->view('inc/navbar', $data);
    }

    public function employee_termination($id,$employee_number)
    {
        $this->form_validation->set_rules('employee_status', 'Employee Status', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['employee'] = $this->employee_model->get_employee($id);
            $data['departments'] = $this->employee_model->get_department();
            $data['companies'] = $this->employee_model->get_company();
            $data['ranks'] = $this->employee_model->get_rank();
            $data['statuss'] = $this->employee_model->get_employee_status();
            $data['groups'] = $this->employee_model->get_work_group();
            $data['main_content'] = 'hr/employee/termination';
            $this->load->view('inc/navbar', $data);
        }
        else 
        {
            if($this->employee_model->update_employee_termination($id,$employee_number));
            {
                $this->session->set_flashdata('success_msg', 'Employment Information Successfully Updated!');
                redirect('employee/index');
            }
            
        }    
    }

    public function edit_employee($id,$employee_number)
    {
        $this->form_validation->set_rules('employee_number', 'Employee Number', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['employee'] = $this->employee_model->get_employee($id);
            $data['children_infos'] = $this->employee_model->get_children_infos($employee_number);
            $data['academe_infos'] = $this->employee_model->get_academe_infos($employee_number);
            $data['departments'] = $this->employee_model->get_department();
            $data['companies'] = $this->employee_model->get_company();
            $data['ranks'] = $this->employee_model->get_rank();
            $data['statuss'] = $this->employee_model->get_employee_status();
            $data['groups'] = $this->employee_model->get_work_group();
            $data['main_content'] = 'hr/employee/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->employee_model->update_employee($id,$employee_number))
            {
                $this->session->set_flashdata('success_msg', 'Employment Information Successfully Updated!');
                redirect('employee/index');
            }
        }    
    }

    public function employee_movement($id,$employee_number)
    {
        $this->form_validation->set_rules('company', 'Company', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['employee'] = $this->employee_model->get_employee($id);
            $data['departments'] = $this->employee_model->get_department();
            $data['companies'] = $this->employee_model->get_company();
            $data['ranks'] = $this->employee_model->get_rank();
            $data['statuss'] = $this->employee_model->get_employee_status();
            $data['groups'] = $this->employee_model->get_work_group();
            $data['main_content'] = 'hr/employee/movement';
            $this->load->view('inc/navbar', $data);
        }
        else 
        {
            if($this->employee_model->update_employee_movement($id,$employee_number))
            {
                $this->session->set_flashdata('success_msg', 'Employment Information Successfully Updated!');
                redirect('employee/index');
            }
            
        }    
    }

    function do_upload() {

        $this->form_validation->set_rules('employee_number', 'Employee Number', 'required|trim');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');
        $this->form_validation->set_rules('birthday', 'BirthDate', 'required|trim');
        $this->form_validation->set_rules('age', 'Age', 'required|trim');
        $this->form_validation->set_rules('marital_status', 'Marital Status', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');
        $this->form_validation->set_rules('father_full_name', 'Father Full Name', 'required|trim');
        $this->form_validation->set_rules('mother_full_name', 'Mother Full Name', 'required|trim');
        $this->form_validation->set_rules('emergency_name', 'Emergency Full Name', 'required|trim');
        $this->form_validation->set_rules('emergency_contact', 'Emergency Contact', 'required|trim');
        $this->form_validation->set_rules('date_hired', 'Date Hired', 'required|trim');
        $this->form_validation->set_rules('company', 'Business Unit', 'required|trim');
        $this->form_validation->set_rules('position', 'Position', 'required|trim');
        $this->form_validation->set_rules('rank', 'Rank', 'required|trim');
        $this->form_validation->set_rules('employee_status', 'Employee Status', 'required|trim');

        $config = array(
            'upload_path' => './uploads/images/',
            'allowed_types' => "gif|jpg|png|jpeg|pdf|xls|xlsx",
            'overwrite' => TRUE,
            'max_size' => "100000000",
            'max_height' => "768",
            'max_width' => "1024"
        );
        $this->upload->initialize($config);
        if($this->upload->do_upload())
        {
            $data = array('upload_data' => $this->upload->data());
        }
        else
        {
            $error = array('error' => $this->upload->display_errors());
        }
        
        
        if($this->form_validation->run() == FALSE)
        {
            $data['main_content'] = 'hr/employee/add';
            $data['departments'] = $this->employee_model->get_department();
            $data['companies'] = $this->employee_model->get_company();
            $data['ranks'] = $this->employee_model->get_rank();
            $data['statuss'] = $this->employee_model->get_employee_status();
            $data['groups'] = $this->employee_model->get_work_group();
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            $this->employee_model->add_employee();
            $this->session->set_flashdata('success_msg', 'Employee Successfully Added!');
            redirect('employee/index');
        }
    
    }

    public function add_info($id,$employee_number)
    {
        $this->form_validation->set_rules('employee_number', 'Employee Number', 'required|trim');
      
        if($this->form_validation->run() == FALSE)
        {
            $data['employee'] = $this->employee_model->get_employee($id);
            $data['main_content'] = 'hr/employee/add_info';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            $this->employee_model->add_employee_info();
            $this->session->set_flashdata('success_msg', 'Employee Info Successfully Added!');
            redirect('employee/index');
        }    
    }

}
