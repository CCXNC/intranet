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
        $data['idea'] = $this->fives_model->get_idea();
        $data['main_content'] = 'fives/standardize/idea';
        $this->load->view('inc/navbar', $data);
    }

    function idea_add() 
    {
        $this->form_validation->set_rules('control_number', 'Control Number', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['main_content'] = 'fives/standardize/idea_add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->fives_model->add_idea())
            {
                $this->session->set_flashdata('success_msg', 'Idea Successfully Added!');
                redirect('fives/idea');
                /*
                    For testing print
                    comment: 
                    $this->session->set_flashdata('success_msg', 'Idea Successfully Added!');
                    redirect('fives/standardize/idea');
                */
            }
        }
    }

    public function idea_view($id) 
    {
        $data['idea'] = $this->fives_model->get_ideas($id);
        $data['main_content'] = 'fives/standardize/idea_view';
        $this->load->view('inc/navbar', $data);
    }

    public function idea_edit($id)
    {
        $this->form_validation->set_rules('current', 'Current', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['idea'] = $this->fives_model->get_ideas($id);
            $data['main_content'] = 'fives/standardize/idea_edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            // GET PREVIOUS DATA.
            $idea = $this->fives_model->get_idea($id);
            
            if($this->fives_model->update_idea($id))
            {
                $this->session->set_flashdata('success_msg', 'Idea Successfully Updated!');
                redirect('fives/idea');
            }
        }    
    }
}
