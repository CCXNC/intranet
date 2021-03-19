<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement_model extends CI_Model {

    public function add_announcement()
    {
		//Parsing multiple insertion or updating
		$this->db->trans_start();

		//ANNOUNCEMENT INPUT
		$image = $_FILES['image']['name'];
		$category = $this->input->post('category');
		$title = $this->input->post('title');
		$content = $this->input->post('content');
		$i = 0;
		$date = date('Y-m-d H:i:s');
		
		$data_announcement = array(
			'image'       	=> $image,
			'category'		=> $category,
			'title'         => $title,
			'content'       => $content,
			'created_date'  => $date,
			'created_by'    => $this->session->userdata('username')
		);
		
		$this->db->insert('announcement', $data_announcement);

		
		$data = array(
			'username' => $this->session->userdata('username'),
			//'activity' => "Announcement added - " . ' title: ' . $title,
			'activity' => "Entry Added",
			'pc_ip'    => $_SERVER['REMOTE_ADDR'],
			'type'     => 'ANNOUNCEMENT',
			'date'     => $date
		);

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 
		$activity_log->insert('blaine_logs', $data);

		
		$trans = $this->db->trans_complete();
		return $trans;
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

		//DATA
		$image = $_FILES['image']['name'];
		$title = $this->input->post('title');
		$category = $this->input->post('category');
		$content = $this->input->post('content');
		$i = 0;
		$date = date('Y-m-d H:i:s');

		// GET OLD DATA BEFORE UPDATE
		$this->db->select('*');
		$this->db->where('id', $id);
		$datas = $this->db->get('announcement');
		$announcement_id = $datas->row()->id;
		$announcement_image = $datas->row()->image;
		$announcement_category = $datas->row()->category;
		$announcement_title = $datas->row()->title;
		$announcement_content = $datas->row()->content;

		$entry_data = array(
			'id'            => $announcement_id,
			'image'       	=> $announcement_image,
			'category'		=> $announcement_category,
			'title'         => $announcement_title,
			'content'       => $announcement_content,
		);

		// CONVERT TO JSON ENCODE
		$json_data =json_encode($entry_data);

		$data = array(
			'username' => $this->session->userdata('username'),
			//'activity' => "Announcement updated - " . ' id: ' . $id  . ' title: '. $title,
			'activity' => "Entry Updated: " . ' ID: ' . $id,
			'datas'    => "Previous Data: " . $json_data,
			'pc_ip'    => $_SERVER['REMOTE_ADDR'],
			'type'     => 'ANNOUNCEMENT',
			'date'     => $date
		);

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 
		$activity_log->insert('blaine_logs', $data);

		// PROCESS FOR UPDATE ANNOUNCEMENT
		if($image == NULL)
		{
			$data = array(
				'title'         => $title,
				'category'      => $category,
				'content'       => $content,
				'updated_date'  => $date,
				'updated_by'    => $this->session->userdata('username')
			);
			
			$this->db->where('id', $id);
			$this->db->update('announcement', $data);
		}
		else 
		{
			$data = array(
				'image'         => $image,
				'title'         => $title,
				'category'      => $category,
				'content'		=> $content,
				'updated_date'  => $date,
				'updated_by'    => $this->session->userdata('username')
			);
			
			$this->db->where('id', $id);
			$this->db->update('announcement', $data);
		}

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function delete_announcement($id)
	{
		$this->db->trans_start();

		// GET OLD DATA BEFORE UPDATE
		$this->db->select('*');
		$this->db->where('id', $id);
		$datas = $this->db->get('announcement');
		$announcement_id = $datas->row()->id;
		$announcement_image = $datas->row()->image;
		$announcement_category = $datas->row()->category;
		$announcement_title = $datas->row()->title;
		$announcement_content = $datas->row()->content;

		$entry_data = array(
			'id'            => $announcement_id,
			'image'       	=> $announcement_image,
			'category'		=> $announcement_category,
			'title'         => $announcement_title,
			'content'       => $announcement_content,
		);

		// CONVERT TO JSON ENCODE
		$json_data =json_encode($entry_data);

		$data = array(
			'username' => $this->session->userdata('username'),
			//'activity' => "Announcement deleted:" . ' id:' . $announcement_id  . ' title:'. $announcement_title,
			'activity' => "Entry Deleted: " . ' ID: ' . $id,
			'datas'    => $json_data,
			'pc_ip'    => $_SERVER['REMOTE_ADDR'],
			'type'     => 'ANNOUNCEMENT',
			'date'     => date('Y-m-d H:i:s')
		);

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 
		$activity_log->insert('blaine_logs', $data);

		// PROCESS FOR DELETE ANNOUNCEMENT
		$data = array(
			'is_active'  => 0
		);
		$this->db->where('id', $id);
	   	$this->db->update('announcement', $data);
		
		$trans = $this->db->trans_complete();
	   	return $trans;
	}
}
