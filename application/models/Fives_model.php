<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fives_model extends CI_Model {

    public function add_idea()
    {
		$this->db->trans_start();

		$data = $this->input->post('employee');
		$explod_data = explode('|', $data);
		$fullname = $explod_data[0];
		$department_id = $explod_data[1];
		$company_id = $explod_data[2];
		$submit_date = $this->input->post('submit_date');
		//$control_number = $this->input->post('control_number');
		$current = $this->input->post('current');
		$proposal = $this->input->post('proposal');

		//GET PREVIOUS CONTROL NUMBER
		$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
		$blaine_five_s->order_by('id','DESC');
		$blaine_five_s->select('control_number');
		$datas = $blaine_five_s->get('idea');
		$control_number = $datas->row()->control_number;

		// YEAR MONTH
		$current_date = date('ym');

		// SPLIT STRING IN ARRAY [0,1]
        $arr2 = str_split($control_number, 4);

		// INCREMENT CONTRON NUMBER
        $i = $arr2[1] + 1;
		$i = str_pad($i, 3, '0', STR_PAD_LEFT);

		// AUTO GENERATED CONTROL NUMBER
        $crtl_number = $current_date . '' . $i;

		$date = date('Y-m-d H:i:s');

		$data_idea = array(
			'submit_date'			=> $date,
			'control_number'        => $crtl_number,
			'submit_by'       		=> $this->session->userdata('username'),
			'propose_by'            => $fullname,
			'company'       		=> $company_id,
			'department'       		=> $department_id,
			'current'       		=> $current,
			'proposal'       		=> $proposal,
			'created_date'  		=> $date,
			'created_by'    		=> $this->session->userdata('username')
		);

		$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
		$blaine_five_s->insert('idea', $data_idea);

		$attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);

	
		$data_attachment = array(
			'control_number' => $crtl_number,
			'file'           => $attach1,
			'status'         => 'Open',
			'created_date'   => $date,
			'created_by'     => $this->session->userdata('username') 
		);

		$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
		$blaine_five_s->insert('idea_attachment', $data_attachment);
		
		$data = array (
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Added",
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> '5S: SHARE MY IDEA',
			'date'		=> $date
		);

		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);

		$trans = $this->db->trans_complete();
		return $trans;
		
		//print_r('<pre>');
		//print_r($data_idea);
		//print_r('</pre>');

	}

	public function get_ideas()
	{
		//$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 

		$this->db->select("
			idea.id as id,
            idea.submit_date as submit_date,
			idea.control_number as control_number,
			idea.submit_by as submit_by,
			idea.propose_by as propose_by,
			company.name as company,
			department.name as department,
			idea.current as current,
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
		$this->db->select("
			idea.id as id,
            idea.submit_date as submit_date,
			idea.control_number as control_number,
			idea.submit_by as submit_by,
			idea.propose_by as propose_by,
			company.name as company,
			department.name as department,
			idea.current as current,
			idea.proposal as proposal,
			idea.status as status,
			idea_attachment.id as attachment_id,
			idea_attachment.file as attachment,
			implemented_idea.current as before,
			implemented_idea.proposal as after,
			implemented_idea.impact as impact,
			implemented_idea.classification as classification,
			implemented_idea.created_by as implemented_by
		");
		$this->db->from('blaine_five_s.idea');
		// DATABASE.TABLE.FIELD
		$this->db->where('blaine_five_s.idea.id', $id);
		$this->db->join('blaine_intranet.company', 'blaine_intranet.company.id = blaine_five_s.idea.company');
		$this->db->join('blaine_intranet.department', 'blaine_intranet.department.id = blaine_five_s.idea.department');
		$this->db->join('blaine_five_s.idea_attachment', 'blaine_five_s.idea.control_number = blaine_five_s.idea_attachment.control_number', 'left');
		$this->db->join('blaine_five_s.implemented_idea', 'blaine_five_s.idea.control_number = blaine_five_s.implemented_idea.control_number', 'left');
		
		$query = $this->db->get();
		return $query->row();
	}

	public function update_idea($id,$control_number)
	{
		$this->db->trans_start();

		// DATA
		$current = $this->input->post('current');
		$proposal = $this->input->post('proposal');
		$i = 0;
		$date = date('Y-m-d H:i:s');

		// GET OLD DATA BEFORE UPDATE
		$blaine_five_s = $this->load->database('blaine_five_s', TRUE);
		$blaine_five_s->select('*');
		$blaine_five_s->where('id', $id);
		$datas = $blaine_five_s->get('idea');
		$fives_id = $datas->row()->id;
		$fives_current = $datas->row()->current;
		$fives_proposal = $datas->row()->proposal;
		$fives_status = $datas->row()->status;

		$entry_data = array (
			'id'		=> $fives_id,
			'current'	=> $fives_current,
			'proposal'	=> $fives_proposal
		);

		$json_data = json_encode($entry_data);

		$data = array(
			'username'	=>	$this->session->userdata('username'),
			'activity'	=>	"Entry Updated: " . ' ID: ' . $id,
			'datas'		=>	"Previous Data: " .$json_data,
			'pc_ip'		=>	$_SERVER['REMOTE_ADDR'],
			'type'		=>	'5S: SHARE MY IDEA',
			'date'		=>	$date
		);

		// CALL ACTIVITY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);


		// PROCESS FOR UPDATE FIVE S
		$data_idea = array(
			'current'     		=> $current,
			'proposal'     		=> $proposal,
			'updated_date'    	=> $date,
			'status'            => 'Open',
			'updated_by'      	=> $this->session->userdata('username')
		);

		$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
		$blaine_five_s->where('idea.id', $id);
		$blaine_five_s->update('idea', $data_idea);

		$attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);
		$attachment_id = $this->input->post('attachment_id');


		if($attach1 != NULL)
		{	
			$data_attachment = array(
				'file'           => $attach1,
				'created_date'   => $date,
				'created_by'     => $this->session->userdata('username') 
			);

			$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
			$blaine_five_s->where('idea_attachment.id', $attachment_id);
			$blaine_five_s->where('idea_attachment.control_number', $control_number);
			$blaine_five_s->update('idea_attachment', $data_attachment);

		}
		else
		{
			$data_attachment = array(
				'created_date'   => $date,
				'created_by'     => $this->session->userdata('username') 
			);

			$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
			$blaine_five_s->where('idea_attachment.id', $attachment_id);
			$blaine_five_s->where('idea_attachment.control_number', $control_number);
			$blaine_five_s->update('idea_attachment', $data_attachment);
		}
	

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function add_status($id,$control_number,$status)
	{
		$this->db->trans_start();

		$id = $this->input->post('id');
		$control_number = $this->input->post('control_number');
		$status = $this->input->post('status');
		$date = date('Y-m-d H:i:s');
		
		if($status == "Open")
		{
			$data = array(
				'status'         => $status,
			);
	
			$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
			$blaine_five_s->where('idea.id', $id);
			$blaine_five_s->where('idea.control_number', $control_number);
			$blaine_five_s->update('idea', $data);
		}
		elseif($status == "Ongoing")
		{
			$data = array(
				'status'         => $status,
				'ongoing_date'   => $date,
				'ongoing_by'     => $this->session->userdata('username')
			);
	
			$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
			$blaine_five_s->where('idea.id', $id);
			$blaine_five_s->where('idea.control_number', $control_number);
			$blaine_five_s->update('idea', $data);
		}
		elseif($status == "Implemented")
		{
			$data = array(
				'status'             => $status,
				'implemented_date'   => $date,
				'implemented_by'     => $this->session->userdata('username')
			);
	
			$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
			$blaine_five_s->where('idea.id', $id);
			$blaine_five_s->where('idea.control_number', $control_number);
			$blaine_five_s->update('idea', $data);
		}
		

		$remarks = $this->input->post('remarks');
		$attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);

	
		$data_attachment = array(
			'control_number' => $control_number,
			'file'           => $attach1,
			'status'         => $status,
			'remarks'        => $remarks,
			'created_date'   => $date,
			'created_by'     => $this->session->userdata('username'),
		);

		$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
		$blaine_five_s->insert('idea_attachment', $data_attachment);

		$data = array(
			'username' 	=> $this->session->userdata('username'),
			'activity' 	=> "Entry Status Added",
			'pc_ip'	   	=> $_SERVER['REMOTE_ADDR'],
			'type'		=> '5S: SHARE MY IDEA',
			'date'		=> date('Y-m-d H:i:s')
		);

		// CALL ACTIVITY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function get_status($control_number,$status)
	{
		$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
		$blaine_five_s->where('idea_attachment.control_number', $control_number);
		$blaine_five_s->where('idea_attachment.status', $status);
		$blaine_five_s->order_by('idea_attachment.id', 'DESC');
		$query = $blaine_five_s->get('idea_attachment');

		return $query->row();
	}

	public function update_status($control_number,$status)
	{
		$remarks = $this->input->post('remarks');
		$attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);
		$date = date('Y-m-d H:i:s');

		
		if($attach1 != 	NULL)
		{
			$data = array(
				'remarks'      => $remarks,
				'file'         => $attach1,
				'updated_date' => $date,
				'updated_by'   => $this->session->userdata('username')
			);
	
			$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
			$blaine_five_s->where('idea_attachment.control_number', $control_number);
			$blaine_five_s->where('idea_attachment.status', $status);
			$query = $blaine_five_s->update('idea_attachment', $data);
		}
		else
		{
			$data = array(
				'remarks'      => $remarks,
				'updated_date' => $date,
				'updated_by'   => $this->session->userdata('username')
			);
	
			$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
			$blaine_five_s->where('idea_attachment.control_number', $control_number);
			$blaine_five_s->where('idea_attachment.status', $status);
			$query = $blaine_five_s->update('idea_attachment', $data);
		}
		

		return $query;
	}

	public function delete_idea($id)
	{
		// GET OLD DATA BEFORE UPDATE
		$blaine_five_s = $this->load->database('blaine_five_s', TRUE);
		$blaine_five_s->select('*');
		$blaine_five_s->where('id', $id);
		$datas = $blaine_five_s->get('idea');
		$fives_id = $datas->row()->id;
		$fives_current = $datas->row()->current;
		$fives_proposal = $datas->row()->proposal;
		$fives_status = $datas->row()->status;

		$entry_data = array (
			'id'		=> $fives_id,
			'current'	=> $fives_current,
			'proposal'	=> $fives_proposal
		);

		$json_data = json_encode($entry_data);

		$data = array(
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Deleted: " . ' ID: ' . $id,
			'datas'		=> "Previous Data: " . $json_data,
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> '5S: SHARE MY IDEA',
			'date'		=> date('Y-m-d H:i:s')
		);

		// CALL ACTIVITY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);
		

		$data_idea = array(
			'is_active'  => 0
		);
		 
		$blaine_five_s = $this->load->database('blaine_five_s', TRUE);
		$blaine_five_s->where('id', $id);
		$query = $blaine_five_s->update('idea', $data_idea);
	   
	   	return $query;
	}

	public function get_implemented_ideas()
	{
		$this->db->select("
			idea.id as id,
			idea.control_number as control_number,
			idea.submit_by as submit_by,
			idea.propose_by as propose_by,
			company.name as company,
			department.name as department,
			implemented_idea.id as implemented_id,
			implemented_idea.current as current,
			implemented_idea.proposal as proposal,
			implemented_idea.impact as impact,
			implemented_idea.created_date as created_date,
			implemented_idea.classification as classification,
			idea.status as status
		");
		$this->db->from('blaine_five_s.idea');
		$this->db->where('blaine_five_s.idea.is_active', 1);
		$this->db->where('blaine_five_s.idea.status', "Implemented");
		// DATABASE.TABLE.FIELD
		$this->db->join('blaine_intranet.company', 'blaine_intranet.company.id = blaine_five_s.idea.company');
		$this->db->join('blaine_intranet.department', 'blaine_intranet.department.id = blaine_five_s.idea.department');
		$this->db->join('blaine_five_s.implemented_idea', 'blaine_five_s.implemented_idea.control_number = blaine_five_s.idea.control_number');
		$query = $this->db->get();
		return $query->result();
	}

	public function add_implemented_ideas($id,$control_number)
	{
		$this->db->trans_start();

		$before = $this->input->post('current');
		$after = $this->input->post('proposal');
		$impact = $this->input->post('impact');
		$classification = substr(implode(',', $this->input->post('classification')), 0);
		$attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);
		$date = date('Y-m-d H:i:s');

		// IMPLEMENTED IDEA INSERT
		$data_implemented = array(
			'control_number' => $control_number,
			'current'        => $before,
			'proposal'       => $after,
			'impact'         => $impact,
			'file'           => $attach1,
			'classification' => $classification,
			'created_by'     => $this->session->userdata('username'),
			'created_date'   => $date
		);

		$blaine_five_s = $this->load->database('blaine_five_s', TRUE);
		$blaine_five_s->insert('implemented_idea', $data_implemented);


		// IDEA ATTACHMENT INSERT
		$data_attachments = array(
			'control_number' => $control_number,
			'file'           => $attach1,
			'status'         => "Implemented",
			'created_by'     => $this->session->userdata('username'),
			'created_date'   => $date
		);
		$blaine_five_s = $this->load->database('blaine_five_s', TRUE);
		$blaine_five_s->insert('idea_attachment', $data_attachments);

		
		// IDEA UPDATE
		$data_idea = array(
			'status'             => "Implemented",
			'implemented_date'   => $date,
			'implemented_by'     => $this->session->userdata('username')
		);

		$blaine_five_s = $this->load->database('blaine_five_s', TRUE); 
		$blaine_five_s->where('idea.id', $id);
		$blaine_five_s->where('idea.control_number', $control_number);
		$blaine_five_s->update('idea', $data_idea);

		/*print_r('<pre>');
		print_r($data);
		print_r('</pre>');*/

		$trans = $this->db->trans_complete();
		return $trans;
	
	}
	public function get_all_attachments($control_number)
	{
		$blaine_five_s = $this->load->database('blaine_five_s', TRUE);
		$blaine_five_s->where('control_number', $control_number);
		$blaine_five_s->order_by('id','DESC');
		$query= $blaine_five_s->get('idea_attachment');

		return $query->result();
	}

	public function get_classification()
	{
		$blaine_five_s = $this->load->database('blaine_five_s', TRUE);
		$query = $blaine_five_s->get('classification');

		return $query->result();
	}

	public function get_implemented_idea($id)
	{
		$blaine_five_s = $this->load->database('blaine_five_s', TRUE);
		$blaine_five_s->where('id', $id);
		$query = $blaine_five_s->get('implemented_idea');

		return $query->row();
	}

	public function update_implemented_idea($id)
	{
		$before = $this->input->post('current');
		$after = $this->input->post('proposal');
		$impact = $this->input->post('impact');
		$classification = substr(implode(',', $this->input->post('classification')), 0);
		$attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);
		$date = date('Y-m-d H:i:s');

		if($attach1 != NULL)
		{
			$data = array(
				'current'        => $before,
				'proposal'       => $after,
				'impact'         => $impact,
				'classification' => $classification,
				'file'           => $attach1,
				'updated_date'   => $date,
				'updated_by'     => $this->session->userdata('username')
			);
	
			$blaine_five_s = $this->load->database('blaine_five_s', TRUE);
			$blaine_five_s->where('id', $id);
			$query = $blaine_five_s->update('implemented_idea', $data);
		}
		else
		{
			$data = array(
				'current'        => $before,
				'proposal'       => $after,
				'impact'         => $impact,
				'classification' => $classification,
				'updated_date'   => $date,
				'updated_by'     => $this->session->userdata('username')
			);
	
			$blaine_five_s = $this->load->database('blaine_five_s', TRUE);
			$blaine_five_s->where('id', $id);
			$query = $blaine_five_s->update('implemented_idea', $data);
		}

		return $query;
	}

}
