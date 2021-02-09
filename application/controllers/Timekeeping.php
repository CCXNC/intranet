<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timekeeping extends CI_Controller {
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
        $data['main_content'] = 'hr/timekeeping/index';
        $this->load->view('inc/navbar', $data);
    }

    //CALENDAR LIST
    function calendar_list()
    {
        $data['calendars'] = $this->timekeeping_model->get_calendars_list();
        $data['main_content'] = 'hr/timekeeping/calendar/holidaylist/index';
        $this->load->view('inc/navbar', $data);
    }

    function add_calendar_list()
    {
        $this->form_validation->set_rules('date', 'Date', 'required|trim');
        $this->form_validation->set_rules('type', 'Type', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['main_content'] = 'hr/timekeeping/calendar/holidaylist/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->timekeeping_model->add_calendar_list())
            {
                $this->session->set_flashdata('success_msg', 'Holiday Successfully Added!');
                redirect('timekeeping/calendar_list');
            }
        }
    }

    function view_calendar_list($id)
    {
        $data['calendar'] = $this->timekeeping_model->get_calendar_list($id);
        $data['main_content'] = 'hr/timekeeping/calendar/holidaylist/view';
        $this->load->view('inc/navbar', $data);
    }

    function edit_calendar_list($id)
    {
       $this->form_validation->set_rules('date', 'Date', 'required|trim');
       $this->form_validation->set_rules('type', 'Type', 'required|trim');
       $this->form_validation->set_rules('description', 'Description', 'required|trim');

       if($this->form_validation->run() == FALSE)
       {
           $data['calendar'] = $this->timekeeping_model->get_calendar_list($id);
           $data['main_content'] = 'hr/timekeeping/calendar/holidaylist/edit';
           $this->load->view('inc/navbar', $data);
       }
       else{
           if($this->timekeeping_model->update_calendar_list($id))
           {
               $this->session->set_flashdata('success_msg', 'Holiday Successfully Updated!');
               redirect('timekeeping/calendar_list');
           }
       }

    }

    function delete_calendar_list($id)
    {
        if($this->timekeeping_model->delete_calendar_list($id))
        {
            $this->session->set_flashdata('error_msg', 'Holiday Successfully Deleted!');
            redirect('timekeeping/calendar_list');
        }
    }
}
