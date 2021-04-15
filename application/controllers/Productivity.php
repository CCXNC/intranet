<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productivity extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }

        if($this->session->userdata('department_id') != 25){
            redirect('homepage');
        }
    }

    public function index_it()
    {
        $data['main_content'] = 'productivity/it/index';
        $this->load->view('inc/navbar', $data);
    }

    public function index_active_directory()
    {
        $data['active_directories'] = $this->it_model->active_directory();
        $data['main_content'] = 'productivity/it/active_directory/index';
        $this->load->view('inc/navbar', $data);
    }
    public function edit_active_directory($id)
    {
        $this->form_validation->set_rules('fullname', 'FULLNAME', 'required|trim');

        if($this->form_validation->run() == FALSE) 
        {
            $data['active_directory'] = $this->it_model->get_active_directory($id);
            $data['main_content'] = 'productivity/it/active_directory/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
           if($this->it_model->update_active_directory($id))
           {
            $this->session->set_flashdata('success_msg', 'ACTIVE DIRECTORY SUCCESSFULLY UPDATED!');
            redirect('productivity/index_active_directory');
           }
        }
      
    }
}     