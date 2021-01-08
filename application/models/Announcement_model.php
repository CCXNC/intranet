<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement_model extends CI_Model {

    public function add_announcement()
    {
		$this->db->trans_start();

		//ANNOUNCEMENT INPUT
		$image = $file_name = $_FILES['userfile']['name'];;
		$title = $this->input->post('title');
		$content = $this->input->post('content');
		$i = 0;
		$date = date('Y-m-d h:i:s');
		
		$data_announcement = array(
			'image'                    => $image,
			'title'                    => $title,
			'content'                  => $content,
			'created_date'             => $date,
			'created_by'               => $this->session->userdata('username')
		);
		
		$this->db->insert('announcement', $data_announcement);
		/*print_r('<pre>');
		print_r($data_employee);
		print_r('</pre>');*/	
		
		$trans = $this->db->trans_complete();
		return $trans;
	
	}
	
	public function get_announcement()
	{
		$this->db->select("*");
		$this->db->from('announcement');
	
		$query = $this->db->get();

		return $query->result();
	}
}
