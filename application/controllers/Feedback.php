<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }    

    public function index()
    {
        $employee_number = $this->session->userdata('employee_number');
        $data['feedbacks'] = $this->feedback_model->get_employees_feedback($employee_number);
        $data['main_content'] = 'feedback/index';
        $this->load->view('inc/navbar', $data);
    }

    public function add()
    {
        $this->form_validation->set_rules('remarks', 'Remarks', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['employees'] = $this->employee_model->get_employees();
            $data['main_content'] = 'feedback/index';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                
                // File upload configuration 
                $config['upload_path'] = './uploads/feedback_attachment/'; 
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

            if($this->feedback_model->add_feedback())
            {
                $this->session->set_flashdata('success_msg', 'Feedback Successfully Added!');
                redirect('feedback/index');
            }
        }    
    }

    public function add_comment()
    {
        $this->form_validation->set_rules('remarks', 'Remarks', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['feedback'] = $this->feedback_model->get_employee_feedback($id);
            $data['comments'] = $this->feedback_model->get_employees_comment($id);
            $data['main_content'] = 'feedback/view';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                
                // File upload configuration 
                $config['upload_path'] = './uploads/feedback_attachment/'; 
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

            if($this->feedback_model->add_comment())
            {
                $this->session->set_flashdata('success_msg', 'Comment Successfully Added!');
                redirect('feedback/index');
            }
        }    
    }

    public function download_attachment($attachment_file)
	{
		$this->load->helper('download');
		$data = file_get_contents('uploads/feedback_attachment/'.$this->uri->segment(3)); // Read the file's contents
		$name = $this->uri->segment(3);
        force_download($name, $data);
        //print_r($data);
    }

    public function hold_feedback($id)
    {
        if($this->feedback_model->update_to_hold_feedback($id))
        {
            $this->session->set_flashdata('success_msg', 'Status Successfully Updated!');
            redirect('feedback/index');
        }
    }

    public function close_feedback($id)
    {
        if($this->feedback_model->update_to_close_feedback($id))
        {
            $this->session->set_flashdata('success_msg', 'Status Successfully Updated!');
            redirect('feedback/index');
        }
    }

    public function view($id)
    {
        $data['feedback'] = $this->feedback_model->get_employee_feedback($id);
        $data['comments'] = $this->feedback_model->get_employees_comment($id);
        $data['main_content'] = 'feedback/view';
        $this->load->view('inc/navbar', $data);
    }
}        