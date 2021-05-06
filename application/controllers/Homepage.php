<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    public function employee_profile($id,$employee_number) 
    {
        $data['employee'] = $this->employee_model->get_employee($id);
        $data['academe_infos'] = $this->employee_model->get_academe_infos($employee_number);
        $data['attachments'] = $this->employee_model->get_attachments($employee_number);
        $data['children_infos'] = $this->employee_model->get_children_infos($employee_number);
        $data['transfer'] = $this->employee_model->get_transfer_logs($employee_number);
        $data['main_content'] = 'hr/employee/profile';
        $this->load->view('inc/navbar', $data);
    }

    function index() {

        // Get record count
	 	/*$this->load->library('pagination');

        $this->db->select('*');
        $this->db->from('announcement');
        $this->db->where('category', "homepage");
        $this->db->where('is_active', 1);
        $total_rows = $this->db->count_all_results();
         
	 	$limit = 1;
	 	$start = $this->uri->segment(3);

        $this->db->order_by('created_date','desc');
	 	$this->db->limit($limit, $start);*/
	 	//$keyword    =   $this->input->post('keyword');
	 	//$this->db->like('name', $keyword);

         /*$this->db->select("
            image,
            category,
            title,
            content,
            created_date,
            is_active

        ");
        $this->db->from('announcement');
        $this->db->order_by('created_date', 'DESC');
        $this->db->where('category', "homepage");
        $this->db->where('is_active', 1);
        
        
	  	$query = $this->db->get();
	 	$data['announcement'] = $query->result();
	  	$config['base_url']   = 'http://localhost/blaineintranet/Homepage/index';
	  	$config['total_rows'] = $total_rows;
	  	$config['per_page']   = $limit;

	  	$config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
            
        $config['first_link'] = 'First Page';
        $config['first_tag_open'] = '<span class="btn btn-light firstlink">';
        $config['first_tag_close'] = '</span>';
            
        $config['last_link'] = 'Last Page';
        $config['last_tag_open'] = '<li class=" btn btn-light lastlink">';
        $config['last_tag_close'] = '</li>';
            
        $config['next_link'] = 'Next Page';
        $config['next_tag_open'] = '<li class=" btn btn-light nextlink">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = 'Prev Page';
        $config['prev_tag_open'] = '<span class="btn btn-light prevlink">';
        $config['prev_tag_close'] = '</span>';

        $config['cur_tag_open'] = '<li class="btn btn-light curlink">';
        $config['cur_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li class="btn btn-light numlink">';
        $config['num_tag_close'] = '</li>';
	  
	  	$this->pagination->initialize($config);	
        $data['main_content'] = 'homepage';
        $this->load->view('inc/navbar', $data);*/
        $data['announcements'] = $this->announcement_model->get_announcements();
        $data['main_content'] = 'homepage';
        $this->load->view('inc/navbar', $data);
    
    }

    public function active_directory()
    {
        $data['active_directories'] = $this->it_model->active_directory();
        $data['main_content'] = 'active_directory';
        $this->load->view('inc/navbar', $data);
    }

    public function location_directory()
    {
        $data['location_directories'] = $this->it_model->get_location_derictories();
        $data['main_content'] = 'location_directory';
        $this->load->view('inc/navbar', $data); 
    }
   
}
