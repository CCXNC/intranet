<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fives extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');

        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    function standardize() 
    {
        $data['main_content'] = 'fives/standardize/index';
        $this->load->view('inc/navbar', $data);
    }

    function idea() 
    {
        $data['ideas'] = $this->fives_model->get_ideas();
        $data['main_content'] = 'fives/standardize/idea/index';
        $this->load->view('inc/navbar', $data);
    }

    function idea_add() 
    {
        $this->form_validation->set_rules('current', 'Current', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['employees'] = $this->employee_model->get_employees();
            $data['main_content'] = 'fives/standardize/idea/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/idea_attachment/'; 
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

            if($this->fives_model->add_idea())
            {
                $this->session->set_flashdata('success_msg', 'Idea Successfully Added!');
                redirect('fives/idea');
            }
        }
    }

    public function idea_view($id,$control_number) 
    {
        $data['idea'] = $this->fives_model->get_idea($id);
        $data['attachments'] = $this->fives_model->get_all_attachments($control_number);
        $data['main_content'] = 'fives/standardize/idea/view';
        $this->load->view('inc/navbar', $data);
    }

    public function idea_implemented_view($id,$control_number) 
    {
        $data['idea'] = $this->fives_model->get_idea($id);
        $data['attachments'] = $this->fives_model->get_all_attachments($control_number);
        $data['main_content'] = 'fives/standardize/idea/implemented/view';
        $this->load->view('inc/navbar', $data);
    }

    public function idea_edit($id,$control_number)
    {
        $this->form_validation->set_rules('current', 'Current', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['idea'] = $this->fives_model->get_idea($id);
            $data['main_content'] = 'fives/standardize/idea/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {

            // GET PREVIOUS DATA.
            $attachment_file = $this->fives_model->get_idea($id);
            $prevImage = $attachment_file->attachment;

            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                
                // File upload configuration 
                $config['upload_path'] = './uploads/idea_attachment/';   
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf'; 
                
                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 

                if(!empty($prevImage) || !empty($imageName)){ 
                    // Remove old file from the server 
                    @unlink('./uploads/idea_attachment/'.$prevImage);  

                    // Upload file to server 
                    if($this->upload->do_upload('data1')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $imgData['file_name'] = $fileData['file_name']; 
                    
                    }else{ 
                        $error = $this->upload->display_errors(); 
                    } 
                } 
            } 

            if($this->fives_model->update_idea($id,$control_number))
            {
                $this->session->set_flashdata('success_msg', 'Idea Successfully Updated!');
                redirect('fives/idea');
            }
        }    
    }

    function idea_delete($id)
    {
        if($this->fives_model->delete_idea($id))
        {
            $this->session->set_flashdata('error_msg', 'Idea Successfully Deleted!');
            redirect('fives/idea');
        }
        
    }

    public function status($id,$control_number,$status)
    {
        $this->form_validation->set_rules('remarks', 'Remarks', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['attach'] = $this->fives_model->get_status($control_number,$status);
            $data['idea'] = $this->fives_model->get_idea($id);
            $data['main_content'] = 'fives/standardize/idea/status';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/idea_attachment/'; 
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

            if($this->fives_model->add_status($id,$control_number,$status))
            {
                $this->session->set_flashdata('success_msg', 'Status Successfully Updated!');
                redirect('fives/idea');
            }

        }
       
    }

    public function edit_status($control_number,$status)
    {
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['idea'] = $this->fives_model->get_status($control_number,$status);
            $data['main_content'] = 'fives/standardize/idea/edit_status';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            // GET PREVIOUS DATA.
            $attachment_file = $this->fives_model->get_status($control_number,$status);
            $prevImage = $attachment_file->file;

            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                
                // File upload configuration 
                $config['upload_path'] = './uploads/idea_attachment/';   
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf'; 
                
                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 

                if(!empty($prevImage) || !empty($imageName)){ 
                    // Remove old file from the server 
                    @unlink('./uploads/idea_attachment/'.$prevImage);  

                    // Upload file to server 
                    if($this->upload->do_upload('data1')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $imgData['file_name'] = $fileData['file_name']; 
                    
                    }else{ 
                        $error = $this->upload->display_errors(); 
                    } 
                } 
            } 

            if($this->fives_model->update_status($control_number,$status))
            {
                $this->session->set_flashdata('success_msg', 'Edit Status Successfully Updated!');
                redirect('fives/idea');
            }
        }
    }
    
    public function implemented()
    {
        $data['ideas'] = $this->fives_model->get_implemented_ideas();
        $data['main_content'] = 'fives/standardize/idea/implemented/index';
        $this->load->view('inc/navbar', $data);
    }

    public function implemented_add($id,$control_number,$status)
    {
        $this->form_validation->set_rules('current', 'Before', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['attach'] = $this->fives_model->get_status($control_number,$status);
            $data['idea'] = $this->fives_model->get_idea($id);
            $data['main_content'] = 'fives/standardize/idea/status';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/idea_attachment/'; 
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

            if($this->fives_model->add_implemented_ideas($id,$control_number))
            {
                $this->session->set_flashdata('success_msg', '5S Implemented Successfully Added!');
                redirect('fives/implemented');
            }
        }
    } 
    public function edit_implemented_idea($id)
    {
        $this->form_validation->set_rules('current', 'Current', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['classifications'] = $this->fives_model->get_classification();
            $data['idea'] = $this->fives_model->get_implemented_idea($id);
            $data['main_content'] = 'fives/standardize/idea/implemented/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            // GET PREVIOUS DATA.
            $attachment_file = $this->fives_model->get_implemented_idea($id);
            $prevImage = $attachment_file->file;

            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                
                // File upload configuration 
                $config['upload_path'] = './uploads/idea_attachment/';   
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf'; 
                
                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 
    
                if(!empty($prevImage) || !empty($imageName)){ 
                    // Remove old file from the server 
                    @unlink('./uploads/idea_attachment/'.$prevImage);  
    
                    // Upload file to server 
                    if($this->upload->do_upload('data1')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $imgData['file_name'] = $fileData['file_name']; 
                    
                    }else{ 
                        $error = $this->upload->display_errors(); 
                    } 
                } 
            } 

            if($this->fives_model->update_implemented_idea($id))
            {
                $this->session->set_flashdata('success_msg', '5S Implemented Successfully Updated!');
                redirect('fives/implemented');
            }
        }
    }
    
    public function download_attachment($attachment_file)
	{
		$this->load->helper('download');
		$data = file_get_contents('uploads/idea_attachment/'.$this->uri->segment(3)); // Read the file's contents
		$name = $this->uri->segment(3);
        force_download($name, $data);
        //print_r($data);
    }
       
}
