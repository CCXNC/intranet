<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement_model extends CI_Model {

    public function add_announcement()
    {
		//Parsing multiple insertion or updating
		//$this->db->trans_start();

		//ANNOUNCEMENT INPUT
		$image = $_FILES['image']['name'];
		$category = $this->input->post('category');
		$title = $this->input->post('title');
		$content = $this->input->post('content');
		$i = 0;
		$date = date('Y-m-d h:i:s');
		
		$data_announcement = array(
			'image'                    => $image,
			'category'				   => $category,
			'title'                    => $title,
			'content'                  => $content,
			'created_date'             => $date,
			'created_by'               => $this->session->userdata('username')
		);
		
		$this->db->insert('announcement', $data_announcement);
		/*print_r('<pre>');
		print_r($data_announcement);
		print_r('</pre>');*/
		
		//$trans = $this->db->trans_complete();
		//return $trans;
	}
	
	public function get_announcements()
	{
		$this->db->where('is_active', 1);
		$query = $this->db->get('announcement');

		return $query->result();
	}

	public function get_announcement($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('announcement');

		return $query->row();
	}

	public function update_announcement($id)
	{
		$this->db->trans_start();

		$image = $_FILES['image']['name']; 
		//$picture = $_FILES['image']['name'];
		$date = date('Y-m-d h:i:s');

		$data = array (
			'image'             => $image,
			'category' 			=> $this->input->post('category'),
			'title' 			=> $this->input->post('title'),
			'content' 			=> $this->input->post('content'),
			'updated_date'    	=> $date,
			'updated_by'      	=> $this->session->userdata('username')
		);

		/*print_r('<pre>');
		print_r($data);
		print_r('</pre>');*/

		$this->db->where('id', $id);
		$this->db->update('announcement', $data);
		$trans = $this->db->trans_complete();
		
		return $trans;
	}

	public function delete_announcement($id)
	{
		$data = array(
			'is_active'  => 0
		);
		$this->db->where('id', $id);
	   $query = $this->db->update('announcement', $data);
	   
	   return $query;
	}
}
