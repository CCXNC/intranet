<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    public function index()
    {
        $data['attachments'] = $this->forms_model->get_all_attachment();
        $data['main_content'] = 'forms/index';
        $this->load->view('inc/navbar', $data);
    }

    public function add_attachment()
    {
        $this->form_validation->set_rules('attachment1', 'Attachment Name', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['main_content'] = 'forms/index';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/blaine_forms/'; 
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
            
            if($this->forms_model->add_attachment())
            {
                $this->session->set_flashdata('success_msg', 'Attachment Successfully Added!');
                redirect('forms/index');
            }
            
        }
        
    }

    public function edit_forms($id)
    {
        $this->form_validation->set_rules('attachment1', 'Attachment Name', 'required|trim');
        $this->form_validation->set_rules('category', 'Category', 'required|trim');
        
        if($this->form_validation->run() == FALSE)
        {
            $data['attachment'] = $this->forms_model->get_attachment($id);
            $data['main_content'] = 'forms/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            // GET PREVIOUS DATA.
            $attachment_file = $this->forms_model->get_attachment($id);
            $prevImage = $attachment_file->attachment;

            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/blaine_forms/';   
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf'; 
                 
                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 

                if(!empty($prevImage) && !empty($imageName)){ 
                     // Remove old file from the server 
                    @unlink('./uploads/blaine_forms/'.$prevImage);  

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
            
            if($this->forms_model->update_forms($id))
            {
                $this->session->set_flashdata('success_msg', 'Blaine Forms Successfully Updated!');
                redirect('forms/index');
            }
        }
      
    }

    public function delete_form($id)
    {
        if($this->forms_model->delete_form($id))
        {
            $this->session->set_flashdata('error_msg', 'Blaine Form Successfully Deleted!');
                redirect('forms/index');
        }
    }
    public function download_attachment($attachment_file)
	{
    	$this->load->helper('download');
		$data = file_get_contents('uploads/blaine_forms/'.$this->uri->segment(3)); // Read the file's contents
		$name = $this->uri->segment(3);
        force_download($name, $data);
        //print_r($data);

       // $data = file_get_contents('uploads/blaine_forms/'.$this->uri->segment(3));
       // $name = $this->uri->segment(3);
       // header("Content-type: application/pdf");
       // header("Content-length: " . filesize($data, $name));

       // readfile($data, $name);

    }

    public function acronyms()
    {
        $data['main_content'] = 'forms/acronyms';
        $this->load->view('inc/navbar', $data);
    }
}     