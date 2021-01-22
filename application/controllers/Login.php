<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct(); 
        $this->load->model('Login_model');
    }

    function index() {
        $data['announcements'] = $this->login_model->get_announcements();
        $this->load->view('login/index', $data);
    
    }

	/*public function index()
	{
	 	$this->load->library('pagination');

	 	$total_rows = $this->db->count_all('announcement');
	 	$limit = 1;
	 	$start = $this->uri->segment(3);

        $this->db->order_by('created_date','desc');
	 	$this->db->limit($limit, $start);

         $this->db->select("
            image,
            category,
            title,
            content,
            created_date,
            is_active

        ");
        $this->db->from('announcement');
        $this->db->order_by('created_date', 'DESC');
        $this->db->where('category', "loginpage");
        $this->db->where('is_active', 1);
        
        
	  	$query = $this->db->get();
	 	$data['announcement'] = $query->result();
	  	$config['base_url']   = 'http://localhost/blaineintranet/login/index';
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
        $this->load->view('login/index', $data);
    }*/
    
    function auth() {

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $result = $this->Login_model->check_user($username, $password);

        if($result->num_rows() > 0) {

            $data = $result->row_array();
            $username = $data['username'];
            $employee_number = $data['employee_number'];
            $access_level_id = $data['access_level_id'];
            $emp_id = $data['emp_id'];

            $sesdata = array(
                'username' => $username,
                'employee_number' => $employee_number,
                'access_level_id' => $access_level_id,
                'logged_in' => TRUE,
                'emp_id' => $emp_id
            );

            $this->session->set_userdata($sesdata);
            redirect('homepage/index');
            
        } else {

            echo "<script>alert('Incorrect Username or Password!');history.go(-1);</script>";
        }

        $this->load->view('login/index');
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('login/index');
    }
}
