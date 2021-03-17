<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
    public function __construct() {
        parent::__construct();
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
        $data['employees'] = $this->employee_model->get_employees();
        $data['main_content'] = 'hr/employee/index';
        $this->load->view('inc/navbar', $data);

        
        /*$data['employees'] = $this->employee_model->get_employees();
        $this->load->view('hr/employee/index', $data);*/
        
    }

    function resigned() 
    {
        $data['employees'] = $this->employee_model->get_resigned();
        $data['main_content'] = 'hr/employee/resigned';
        $this->load->view('inc/navbar', $data);
        
    }
 
     public function view_employee($id,$employee_number) 
    {
        $data['employee'] = $this->employee_model->get_employee($id);
        $data['academe_infos'] = $this->employee_model->get_academe_infos($employee_number);
        $data['children_infos'] = $this->employee_model->get_children_infos($employee_number);
        $data['attachments'] = $this->employee_model->get_attachments($employee_number);
        $data['transfer'] = $this->employee_model->get_transfer_logs($employee_number);
        $data['main_content'] = 'hr/employee/view';
        $this->load->view('inc/navbar', $data);
    }

    function add()  
    {
        $this->form_validation->set_rules('employee_number', 'Employee Number', 'required|trim');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');
        //$this->form_validation->set_rules('birthday', 'BirthDate', 'required|trim');
        //$this->form_validation->set_rules('marital_status', 'Marital Status', 'required|trim');
        //$this->form_validation->set_rules('address', 'Address', 'required|trim');
        //$this->form_validation->set_rules('father_full_name', 'Father Full Name', 'required|trim');
        //$this->form_validation->set_rules('mother_full_name', 'Mother Full Name', 'required|trim');
        //$this->form_validation->set_rules('emergency_name', 'Emergency Full Name', 'required|trim');
        //$this->form_validation->set_rules('emergency_contact', 'Emergency Contact', 'required|trim');
        //$this->form_validation->set_rules('date_hired', 'Date Hired', 'required|trim');
        //$this->form_validation->set_rules('company', 'Business Unit', 'required|trim');
        //$this->form_validation->set_rules('position', 'Position', 'required|trim');
        //$this->form_validation->set_rules('rank', 'Rank', 'required|trim');
        //$this->form_validation->set_rules('employee_status', 'Employee Status', 'required|trim');

        //$data = $imgData = array(); 
        
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
            if(!empty($_FILES['image']['name'])){ 
                $imageName = $_FILES['image']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/employee/'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                 
                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 
                 
                // Upload file to server 
                if($this->upload->do_upload('image')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $imgData['file_name'] = $fileData['file_name']; 
                }else{ 
                    $error = $this->upload->display_errors();  
                } 
            } 

            if($this->employee_model->add_employee())
            {
                $this->session->set_flashdata('success_msg', 'Employee Successfully Added!');
                redirect('schedule/index');
            }
          
        }
    
    }

    public function edit_employee($id,$employee_number)
    {
        $this->form_validation->set_rules('employee_number', 'Employee Number', 'required|trim');
        /*$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');
        $this->form_validation->set_rules('birthday', 'BirthDate', 'required|trim');
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
        $this->form_validation->set_rules('employee_status', 'Employee Status', 'required|trim');*/

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
            // GET PREVIOUS DATA.
            $employee = $this->employee_model->get_employee($id);
            $prevImage = $employee->picture;

            if(!empty($_FILES['image']['name'])){ 
                $imageName = $_FILES['image']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/employee/';  
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                 
                // Load and initialize upload library 
                $this->load->library('upload', $config);  
                $this->upload->initialize($config); 

                if(!empty($prevImage) && !empty($imageName)){ 
                     // Remove old file from the server 
                    @unlink('./uploads/employee/'.$prevImage);  

                     // Upload file to server 
                     if($this->upload->do_upload('image')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $imgData['file_name'] = $fileData['file_name']; 
                    
                    }else{ 
                        $error = $this->upload->display_errors();  
                    } 
                } 
                
            } 

            if($this->employee_model->update_employee($id,$employee_number))
            {
                $this->session->set_flashdata('success_msg', 'Employment Information Successfully Updated!');
                redirect('employee/index');
            }
        }    
    }

    public function employee_termination($id,$employee_number)
    {
        $this->form_validation->set_rules('employee_status', 'Employee Status', 'required|trim');
        $this->form_validation->set_rules('date_termination', 'Date Termination', 'required|trim');
        $this->form_validation->set_rules('date_clearance', 'Date Clearance', 'required|trim');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required|trim');
        
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

    public function employee_movement($id,$employee_number) 
    {    
        $this->form_validation->set_rules('company', 'Company', 'required|trim');
        /*$this->form_validation->set_rules('work_group', 'Work Group', 'required|trim');
        $this->form_validation->set_rules('superior', 'Superior', 'required|trim');
        $this->form_validation->set_rules('rank', 'Rank', 'required|trim');
        $this->form_validation->set_rules('date_transfer', 'Date Transfer', 'required|trim');
        $this->form_validation->set_rules('position', 'Position', 'required|trim');
        $this->form_validation->set_rules('movement_from', 'Movement From', 'required|trim');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required|trim');*/

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

    public function delete_view_employee($id,$employee_number) 
    {
        $data['employee'] = $this->employee_model->get_employee($id);
        $data['academe_infos'] = $this->employee_model->get_academe_infos($employee_number);
        $data['children_infos'] = $this->employee_model->get_children_infos($employee_number);
        $data['transfer'] = $this->employee_model->get_transfer_logs($employee_number);
        $data['main_content'] = 'hr/employee/delete';
        $this->load->view('inc/navbar', $data);
    }

    public function delete_all_information($id,$employee_number) 
    {
        if($this->employee_model->delete_all_information($id,$employee_number))
        {
            $this->session->set_flashdata('error_msg', 'Employee Successfully Deleted!');
            redirect('employee/index');
        }
        
    }

    public function delete_children_information($id,$employee_number) 
    {
        if($this->employee_model->delete_children_information($id,$employee_number))
        {
            $this->session->set_flashdata('error_msg', 'Children Info Successfully Deleted!');
            redirect('employee/index');
        }
        
    }

    public function delete_academe_information($id,$employee_number) 
    {
        if($this->employee_model->delete_academe_information($id,$employee_number))
        {
            $this->session->set_flashdata('error_msg', 'Academe Info Successfully Deleted!');
            redirect('employee/index');
        }
        
    }

	public function employee_attachment($id,$employee_number)
    {
        $this->form_validation->set_rules('attachment', 'Resume', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['employee'] = $this->employee_model->get_employee($id);
            $data['main_content'] = 'hr/employee/attachment';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if(!empty($_FILES['resume']['name'])){ 
                //$imageName = $_FILES['resume']['name']; 
                $file_name = $_FILES["resume"]['name'];
                //$newfile_name= preg_replace('/[^A-Za-z0-9]/', "", $file_name);
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/attachment/'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf'; 
                $config['max_size'] = '100000000'; 
                $config['overwrite'] = True;

                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 
                 
                // Upload file to server 
                if($this->upload->do_upload('resume')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $imgData['file_name'] = $fileData['file_name']; 
                   
                }else{ 
                    $error = $this->upload->display_errors();  
                } 
            } 

            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/attachment/'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf'; 
                $config['max_size'] = '100000000'; 
                $config['overwrite'] = True;

                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 
                 
                // Upload file to server 
                if($this->upload->do_upload('data1')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $imgData['file_name'] = $fileData['file_name']; 
                }else{ 
                    $error = $this->upload->display_errors();  
                } 
            } 

            if(!empty($_FILES['data2']['name'])){ 
                $imageName = $_FILES['data2']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/attachment/'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf'; 
                $config['max_size'] = '100000000'; 
                $config['overwrite'] = True;

                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 
                 
                // Upload file to server 
                if($this->upload->do_upload('data2')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $imgData['file_name'] = $fileData['file_name']; 
                }else{ 
                    $error = $this->upload->display_errors();  
                } 
            } 
            
            if($this->employee_model->attachment($employee_number))
            {
                $this->session->set_flashdata('success_msg', 'Employee Attachment Successfully Added!');
                redirect('employee/index');
            }
            
        }
        
      
    }
    
    public function download_attachment($attachment_file)
	{
		$this->load->helper('download');
		$data = file_get_contents('uploads/attachment/'.$this->uri->segment(3)); // Read the file's contents
		$name = $this->uri->segment(3);
        force_download($name, $data);
        //print_r($data);
    }

    public function reports()
    {
        $data['employees'] = $this->employee_model->get_reports();
        $data['main_content'] = 'hr/employee/reports';
        $this->load->view('inc/navbar', $data);
    }
}
