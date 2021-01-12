<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    function index() {
        $data['announcements'] = $this->announcement_model->get_announcements();
        $data['main_content'] = 'hr/announcement/index';
        $this->load->view('inc/navbar', $data);
    
    }

    public function view_announcement($id) 
    {
        $data['announcement'] = $this->announcement_model->get_announcement($id);
        $data['main_content'] = 'hr/announcement/view';
        $this->load->view('inc/navbar', $data);
    }

    function do_upload() {
        /* printing arrays: comment until
            {
                $error = array('error' => $this->upload->display_errors());
            } 
        */
        //$this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('content', 'Content', 'required|trim');
        $this->form_validation->set_rules('category', 'Category', 'required|trim');

        $config = array(
            'upload_path' => './uploads/announcement/',
            'allowed_types' => "gif|jpg|png|jpeg|pdf|xls|xlsx",
            'overwrite' => TRUE,
            'max_size' => "100000000",
            'max_height' => "100000",
            'max_width' => "100000"
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
            $data['main_content'] = 'hr/announcement/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            $this->announcement_model->add_announcement();
            $this->session->set_flashdata('success_msg', 'Announcement Successfully Added!');
            redirect('announcement/index');

            //$this->session->set_flashdata('success_msg', 'Announcement Successfully Added!');
            //redirect('announcement/index');
        }
        
    
    }

    function edit() {
        $data['main_content'] = 'hr/announcement/edit';
        $this->load->view('inc/navbar', $data);
    
    }
}
