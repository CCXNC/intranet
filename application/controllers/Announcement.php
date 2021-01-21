<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    /*function index() {
        $data['announcements'] = $this->announcement_model->get_announcements();
        $data['main_content'] = 'hr/announcement/index';
        $this->load->view('inc/navbar', $data);
    
    }*/
    function index() {

        // Get record count
	 	$this->load->library('pagination');

	 	$total_rows = $this->db->count_all('announcement');
	 	$limit = 5;
	 	$start = $this->uri->segment(3);

	 	$this->db->order_by('created_date','desc');
	 	$this->db->limit($limit, $start);
	 	//$keyword    =   $this->input->post('keyword');
	 	//$this->db->like('name', $keyword);

         $this->db->select("
            id,
            image,
            category,
            title,
            content,
            is_active,
            created_date

        ");
        $this->db->from('announcement');
        $this->db->order_by('created_date', 'DESC');
        $this->db->where('is_active', 1);
        
	  	$query = $this->db->get();
	 	$data['announcement'] = $query->result();
	  	$config['base_url']   = 'http://localhost/blaineintranet/Announcement/index';
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
        $data['main_content'] = 'hr/announcement/index';
        $this->load->view('inc/navbar', $data);
    }

    public function view_announcement($id) 
    {
        $data['announcement'] = $this->announcement_model->get_announcement($id);
        $data['main_content'] = 'hr/announcement/view';
        $this->load->view('inc/navbar', $data);
    }

    function add() {

        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('category', 'Category', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['main_content'] = 'hr/announcement/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {

            if(!empty($_FILES['image']['name'])){ 
                $imageName = $_FILES['image']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/announcement/'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                 
                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 
                 
                // Upload file to server 
                if($this->upload->do_upload('image')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $imgData['file_name'] = $fileData['file_name']; 
                }else{ 
                    $error = $this->upload->display_errors();  
                } 
            } 

            $this->announcement_model->add_announcement();
            $this->session->set_flashdata('success_msg', 'Announcement Successfully Added!');
            redirect('announcement/index');

            //$this->session->set_flashdata('success_msg', 'Announcement Successfully Added!');
            //redirect('announcement/index');
        }
        
    
    }

    function edit($id) {
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        //$this->form_validation->set_rules('content', 'Content', 'required|trim');
        $this->form_validation->set_rules('category', 'Category', 'required|trim');
        if($this->form_validation->run() == FALSE)
        {
            $data['main_content'] = 'hr/announcement/edit';
            $data["announcement"] = $this->announcement_model->get_announcement($id);
            $this->load->view('inc/navbar', $data);
        }
        else
        {

            if(!empty($_FILES['image']['name'])){ 
                $imageName = $_FILES['image']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/announcement/'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                 
                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 
                 
                // Upload file to server 
                if($this->upload->do_upload('image')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $imgData['file_name'] = $fileData['file_name']; 
                }else{ 
                    $error = $this->upload->display_errors();  
                } 
            } 
           
            // GET PREVIOUS DATA.
           /* 
            $announcement = $this->announcement_model->get_announcement($id);
            $prevImage = $announcement->image;

            if(!empty($_FILES['image']['name'])){ 
                $imageName = $_FILES['image']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/announcement/';  
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                 
                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 

                if($this->upload->do_upload('image')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $imgData['file_name'] = $fileData['file_name']; 
                     
                    // Remove old file from the server  
                    if(!empty($prevImage)){ 
                        @unlink('./uploads/announcement/'.$prevImage);  
                    } 
                }else{ 
                    $error = $this->upload->display_errors();  
                } 

            } */   

            $this->announcement_model->update_announcement($id);
            $this->session->set_flashdata('success_msg', 'Announcement Successfully Updated!');
            redirect('announcement/index');
        }
    }

    function delete($id){
        if($this->announcement_model->delete_announcement($id))
        {
            $this->session->set_flashdata('error_msg', 'Announcement Successfully Deleted!');
            redirect('announcement/index');
        }
        
    }
}
