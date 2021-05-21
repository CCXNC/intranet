<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms_model extends CI_Model {

    public function add_attachment()
	{
		$this->db->trans_start();
		$attachment_name = strtoupper($this->input->post('attachment1'));
        $category = $this->input->post('category');
        
		$attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);
		$i = 0;
		$date = date('Y-m-d H:i:s');

		$attach_data = array(
            'name'            => $attachment_name,
            'category'        => $category,
			'attachment'      => $attach1,
			'date'            => $date,
			'created_by'      => $this->session->userdata('username')
		);

        // CONNECTION TO BLAINE FORMS DATABASE.
        $blaine_forms = $this->load->database('blaine_forms', TRUE); 
		$blaine_forms->insert('forms', $attach_data);

		/* print_r('<pre>');
		print_r($resume_data);
		print_r('</pre>'); */

		$data = array(
			'username' => $this->session->userdata('username'),
			//'activity' => "Forms added - " . 'title: ' . $title,
			'activity' => "Entry Added",
			'pc_ip'    => $_SERVER['REMOTE_ADDR'],
			'type'     => 'BLAINE FORMS',
			'date'     => $date
		);

		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);

		$trans = $this->db->trans_complete();
		return $trans;
    }
    
    public function get_all_attachment()
    {
		
		$blaine_forms = $this->load->database('blaine_forms', TRUE); 
		$blaine_forms->where('is_active', 1);
        $query = $blaine_forms->get('forms');

        return $query->result();
	}
	
	public function get_attachment($id)
	{
		// CONNECTION TO BLAINE FORMS DATABASE.
		$blaine_forms = $this->load->database('blaine_forms', TRUE); 

		$blaine_forms->where('id', $id);
		$query = $blaine_forms->get('forms');

        return $query->row();
	}

	public function update_forms($id)
	{
		$this->db->trans_start();
		
		//DATA
		$attachment_name = strtoupper($this->input->post('attachment1'));
        $category = $this->input->post('category');
		$attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);
		$date = date('Y-m-d H:i:s');

		// GET OLD DATA BEFORE UPDATE
		$blaine_forms = $this->load->database('blaine_forms', TRUE); 
		$blaine_forms->select('*');
		$blaine_forms->where('id', $id);
		$datas = $blaine_forms->get('forms');
		$blaine_forms_id = $datas->row()->id;
		$blaine_forms_name = $datas->row()->name;
		$blaine_forms_category = $datas->row()->category;
		
		$entry_data = array (
			'id'		=>	$blaine_forms_id,
			'name'		=>	$blaine_forms_name,
			'category'	=>	$blaine_forms_category
		);

		// CONVERT TO JSON ENCODE
		$json_data = json_encode($entry_data);

		$data = array(
			'username'	=> $this->session->userdata('username'),
			//'activity'	=> "Blaine Forms updated - " . ' id: ' . $id . ' name: ' . $attachment_name,
			'activity'	=> "Entry Updated: " . ' ID: ' . $id,
			'datas'		=> "Previous Data: " . $json_data,
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> 'BLAINE FORMS',
			'date'		=> $date
		);

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 
		$activity_log->insert('blaine_logs', $data);

		//PROCESS FOR UPDATE BLAINE FORMS
		if($attachment1 == NULL)
		{
			$data = array(
				'name'            => $attachment_name,
				'category'        => $category,
				'date'            => $date,
				'updated_by'      => $this->session->userdata('username')
			);

			// CONNECTION TO BLAINE FORMS DATABASE.
			$blaine_forms = $this->load->database('blaine_forms', TRUE); 
			$blaine_forms->where('id', $id);
			$blaine_forms->update('forms', $data);
		}
		else
		{
			$data = array(
				'name'            => $attachment_name,
				'category'        => $category,
				'attachment'      => $attach1,
				'date'            => $date,
				'updated_by'      => $this->session->userdata('username')
			);

			// CONNECTION TO BLAINE FORMS DATABASE.
			$blaine_forms = $this->load->database('blaine_forms', TRUE); 
			$blaine_forms->where('id', $id);
			$blaine_forms->update('forms', $data);
		}	

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function delete_form($id)
	{
		$this->db->trans_start();

		// GET OLD DATA BEFORE UPDATE
		$blaine_forms = $this->load->database('blaine_forms', TRUE); 
		$blaine_forms->select('*');
		$blaine_forms->where('id', $id);
		$datas = $blaine_forms->get('forms');
		$blaine_forms_id = $datas->row()->id;
		$blaine_forms_name = $datas->row()->name;
		$blaine_forms_category = $datas->row()->category;
		
		$entry_data = array (
			'id'		=>	$blaine_forms_id,
			'name'		=>	$blaine_forms_name,
			'category'	=>	$blaine_forms_category
		);

		// CONVERT TO JSON ENCODE
		$json_data = json_encode($entry_data);

		$data = array(
			'username'	=>	$this->session->userdata('username'),
			//'activity'	=>	"Blaine Forms deleted:" . ' id: ' . $blaine_forms_id . ' name: ' . $blaine_forms_name,
			'activity'	=> "Entry Deleted: " . ' ID: ' . $id,
			'datas'		=>	"Deleted Data: " . $json_data,
			//'datas'		=> "Previous Data: " . $json_data,
			'pc_ip'		=>	$_SERVER['REMOTE_ADDR'],
			'type'		=>	'BLAINE FORMS',
			'date'		=>	date('Y-m-d H:i:s')
		);

		// CALL ACTIVITY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);

		// PROCESS FOR DELETE BLAINE FORMS
		$date = date('Y-m-d H:i:s');
		$data = array(
			'is_active' => 0
		);

		// CONNECTION TO BLAINE FORMS DATABASE.
		$blaine_forms = $this->load->database('blaine_forms', TRUE); 
		$blaine_forms->where('id', $id);
		$blaine_forms->update('forms', $data);

		$trans = $this->db->trans_complete();
		return $trans;
	}
}    