<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms_model extends CI_Model {

    public function add_attachment()
	{
		$this->db->trans_start();

		$attachment_name = $this->input->post('attachment1');
        $category = $this->input->post('category');
        
		$attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);

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
		

		$attachment_name = $this->input->post('attachment1');
        $category = $this->input->post('category');
        
		$attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);

		$date = date('Y-m-d H:i:s');

		
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

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 

		$entry_data = "update_forms [entry_id:" . $id . "]";

		$activity_data = array(
			'username'   => $this->session->userdata('username'),
			'pcname'     => gethostname(),
			'entry_data' => $entry_data,
			'entry_date' => $date
		);
		$activity_log->insert('forms_logs', $activity_data);

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function delete_form($id)
	{
		$this->db->trans_start();
		
		$date = date('Y-m-d H:i:s');
		$data = array(
			'is_active' => 0
		);

		// CONNECTION TO BLAINE FORMS DATABASE.
		$blaine_forms = $this->load->database('blaine_forms', TRUE); 
		$blaine_forms->where('id', $id);
		$blaine_forms->update('forms', $data);

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 

		$entry_data = "delete_forms [entry_id:" . $id . "]";

		$activity_data = array(
			'username'   => $this->session->userdata('username'),
			'pcname'     => gethostname(),
			'entry_data' => $entry_data,
			'entry_date' => $date
		);
		$activity_log->insert('forms_logs', $activity_data);

		$trans = $this->db->trans_complete();
		return $trans;
	}
}    