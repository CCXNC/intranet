<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fives_model extends CI_Model {

    public function add_idea()
    {
		$submit_date = $this->input->post('submit_date');
		$control_number = $this->input->post('control_number');
		$current = $this->input->post('current');
		$proposal = $this->input->post('proposal');

		$date = date('Y-m-d H:i:s');

		$data_idea = array(
			'submit_date'			=> $date,
			'control_number'        => $control_number,
			'submit_by'       		=> $this->session->userdata('username'),
			'company'       		=> $this->session->userdata('company_id'),
			'department'       		=> $this->session->userdata('department_id'),
			'current'       		=> $current,
			'proposal'       		=> $proposal,
			'created_date'  		=> $date,
			'created_by'    		=> $this->session->userdata('username')
		);

		$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
		$query = $blaine_five_s->insert('idea', $data_idea);

		return $query;

		/*
			//print_r('<pre>');
			//print_r($data_idea);
			//print_r('</pre>');

			For testing print
			Comment:
			$blaine_five_s->insert('idea', $data_idea);
			$trans = $this->db->trans_complete();
			return $trans;
		*/
	}

	public function get_ideas()
	{
		//$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 

		$this->db->select("
			idea.id as id,
            idea.submit_date as submit_date,
			idea.control_number as control_number,
			idea.submit_by as submit_by,
			company.name as company,
			department.name as department,
			idea.proposal as proposal,
			idea.status as status
		");
		$this->db->from('blaine_five_s.idea');
		$this->db->where('blaine_five_s.idea.is_active', 1);
		// DATABASE.TABLE.FIELD
		$this->db->join('blaine_intranet.company', 'blaine_intranet.company.id = blaine_five_s.idea.company');
		$this->db->join('blaine_intranet.department', 'blaine_intranet.department.id = blaine_five_s.idea.department');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_idea($id)
	{
		//$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
		
		$this->db->select("
			idea.id as id,
			idea.submit_date as submit_date,
			idea.control_number as control_number,
			idea.submit_by as submit_by,
			company.name as company,
			department.name as department,
			idea.current as current,
			idea.proposal as proposal,
			idea.status as status
		");

		$this->db->from('blaine_five_s.idea');
		$this->db->join('blaine_intranet.company', 'blaine_intranet.company.id = blaine_five_s.idea.company');
		$this->db->join('blaine_intranet.department', 'blaine_intranet.department.id = blaine_five_s.idea.department');
		$query = $this->db->get();
		return $query->row();
		
		//$blaine_five_s->from('idea');
		//$blaine_five_s->where('id', $id);
		//$query = $blaine_five_s->get();
		//return $query->row();
		
	}

	public function update_idea($id)
	{

		$current = $this->input->post('current');
		$proposal = $this->input->post('proposal');
		
		$i = 0;
		$date = date('Y-m-d H:i:s');

		$data_idea = array(
			'current'     		=> $current,
			'proposal'     		=> $proposal,
			'updated_date'    	=> $date,
			'updated_by'      	=> $this->session->userdata('username')
		);

		/*print_r('<pre>');
		print_r($data_parent);
		print_r('</pre>');*/
		$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
		$blaine_five_s->where('id', $id);
		$query = $blaine_five_s->update('idea', $data_idea);

		return $query;
	}

	public function delete_idea($id)
	{
		$data_idea = array(
			'is_active'  => 0
		);
		 
		$blaine_five_s = $this->load->database('blaine_five_s', TRUE);
		$blaine_five_s->where('id', $id);
		$query = $blaine_five_s->update('idea', $data_idea);
	   
	   	return $query;
	}
}
