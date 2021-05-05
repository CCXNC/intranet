<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productivity extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }

        if($this->session->userdata('department_id') != 25){
            redirect('homepage');
        }
    }

    // IT

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

    public function index_location_directory()
    {
        $data['location_directories'] = $this->it_model->get_location_derictories();
        $data['main_content'] = 'productivity/it/location_directory/index';
        $this->load->view('inc/navbar', $data); 
    }

    public function add_location_directory()
    {
        $this->form_validation->set_rules('name', 'NAME', 'required|trim');
        $this->form_validation->set_rules('telephone_no', 'Telephone Number', 'required|trim');

        if($this->form_validation->run() == FALSE) 
        {
            $data['main_content'] = 'productivity/it/location_directory/index';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
          if($this->it_model->add_location_directory())
          {
            $this->session->set_flashdata('success_msg', 'LOCATION DIRECTORY SUCCESSFULLY ADDED!');
            redirect('productivity/index_location_directory');
          }
        } 
    }

    public function edit_location_directory($id)
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('telephone_no', 'Telephone Number', 'required|trim');

        if($this->form_validation->run() == FALSE) 
        {
            $data['location_directory'] = $this->it_model->get_location_derictory($id);
            $data['main_content'] = 'productivity/it/location_directory/edit';
            $this->load->view('inc/navbar', $data); 
        }
        else
        {
          if($this->it_model->update_location_directory($id))
          {
            $this->session->set_flashdata('success_msg', 'LOCATION DIRECTORY SUCCESSFULLY UPDATED!');
            redirect('productivity/index_location_directory');
          }
        } 
    }

    public function delete_location_directory($id)
    {
        if($this->it_model->delete_location_directory($id))
        {
            $this->session->set_flashdata('error_msg', 'LOCATION DIRECTORY SUCCESSFULLY DELETED!');
            redirect('productivity/index_location_directory');
        }
    }


    // SOTFWARE DEVELOPER 

    public function index_softdev()
    {
        $data['main_content'] = 'productivity/softdev/index';
        $this->load->view('inc/navbar', $data);
    }
}     