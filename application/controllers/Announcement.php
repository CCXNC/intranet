<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    function add() {
        $data['main_content'] = 'hr/announcement/add';
        $this->load->view('inc/navbar', $data);
    
    }
}
