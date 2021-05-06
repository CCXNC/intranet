<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class It_model extends CI_Model {

    public function active_directory()
	{
		$this->db->select("
            active_directory.id as id,
			CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            employees.picture as picture,
			company.code as company,
			department.name as department,
			active_directory.email as email,
			active_directory.telephone_no as telephone_no
		");
		$this->db->from('employees');
		$this->db->join('active_directory', 'employees.employee_number = active_directory.employee_number','left');
		$this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number', 'left');
        $this->db->join('company', 'employment_info.company = company.id', 'left');
        $this->db->join('department', 'employment_info.department = department.id', 'left');
		$this->db->order_by('employees.last_name', 'ASC');
        $this->db->where('employees.is_active', 1);
		$query = $this->db->get();

		return $query->result();
	}

    public function get_active_directory($id)
    {
        $this->db->select("
            active_directory.id as id,
			CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            employees.picture as picture,
			company.code as company,
			department.name as department,
			active_directory.email as email,
			active_directory.telephone_no as telephone_no
		");
		$this->db->from('employees');
		$this->db->join('active_directory', 'employees.employee_number = active_directory.employee_number','left');
		$this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number', 'left');
        $this->db->join('company', 'employment_info.company = company.id', 'left');
        $this->db->join('department', 'employment_info.department = department.id', 'left');
		$this->db->order_by('employees.last_name', 'ASC');
        $this->db->where('active_directory.id', $id);
		$query = $this->db->get();

		return $query->row();
    }

	public function update_active_directory($id)
	{
		
		$i = 0;
		$date = date('Y-m-d H:i:s');

		// GET OLD DATA BEFORE UPDATE
		$this->db->select('*');
		$this->db->where('id', $id);
		$datas = $this->db->get('active_directory');
		$id = $datas->row()->id;
		$employee_number = $datas->row()->employee_number;
		$email = $datas->row()->email;
		$telephone_no = $datas->row()->telephone_no;

		$entry_data = array(
			'id'				=> $id,
			'employee_number'	=> $employee_number,
			'email'				=> $email,
			'telephone_no'		=> $telephone_no
		);

		// CONVERT TO JSON ENCODE
		$json_data = json_encode($entry_data);

		$activity_data = array(
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Updated: " . ' ID: ' . $id,
			'datas'		=> "Previous Data: " . $json_data,
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> 'IT: ACTIVE DIRECTORY',
			'date'		=> $date
		);

		// CALL ACTIVITY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $activity_data);

		$email = $this->input->post('email');
		$telephone_no = $this->input->post('telephone_no');

		$data = array(
			'email'        => $email,
			'telephone_no' => $telephone_no,
			'updated_by'   => $this->session->userdata('username'),
			'updated_date' => date('Y-m-d H:i:s')
		);
		$this->db->where('id', $id);
		$query = $this->db->update('active_directory', $data);

	
		return $query;
	}

	public function get_location_derictories()
	{
		$query = $this->db->get('location_directory');
		return $query->result();
	}

	public function get_location_derictory($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('location_directory');
		return $query->row();
	}
	

	public function add_location_directory()
	{
		$name = $this->input->post('name');
		$telephone_no = $this->input->post('telephone_no');

		$data = array(
			'name'         => $name,
			'telephone_no' => $telephone_no,
			'created_by'   => $this->session->userdata('username'),
			'created_date' => date('Y-m-d H:i:s')
		);
		$query = $this->db->insert('location_directory', $data);

		$data = array(
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Added",
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> 'IT: LOCATION DIRECTORY',
			'date'		=> date('y-m-d H:i:s')
		);

		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);

		return $query;
	}

	public function update_location_directory($id)
	{

		$this->db->trans_start();

		$name = $this->input->post('name');
		$telephone_no = $this->input->post('telephone_no');

		//$i = 0;
		//$date = date('Y-m-d H:i:s');

		// GET OLD DATA BEFORE UPDATE
		$this->db->select('*');
		$this->db->where('id', $id);
		$datas = $this->db->get('location_directory');
		$id 				= $datas->row()->id;
		$it_name 			= $datas->row()->name;
		$it_telephone_no 	= $datas->row()->telephone_no;

		$entry_data = array(
			'id'				=> $id,
			'name'				=> $it_name,
			'telephone_no'		=> $it_telephone_no,
		);

		// CONVERT TO JSON ENCODE
		$json_data = json_encode($entry_data);

		$activity_data = array(
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Updated: " . ' ID: ' . $id,
			'datas'		=> "Previous Data: " . $json_data,
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> 'IT: LOCATION DIRECTORY',
			'date'		=> date('Y-m-d H:i:s')
		);

		// CALL ACTIVITY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $activity_data);

		$data = array(
			'name'         => $name,
			'telephone_no' => $telephone_no,
			'updated_by'   => $this->session->userdata('username'),
			'updated_date' => date('Y-m-d H:i:s')
		);

		$this->db->where('id', $id);
		$this->db->update('location_directory', $data);

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function delete_location_directory($id)
	{
		
		// GET OLD DATA BEFORE DELETE
		$this->db->select('*');
		$this->db->where('id', $id);
		$datas = $this->db->get('location_directory');
		$id 			= $datas->row()->id;
		$name 			= $datas->row()->name;
		$telephone_no 	= $datas->row()->telephone_no;

		$entry_data = array(
			'id'			=> $id,
			'name'			=> $name,
			'telephone_no'	=> $telephone_no
		);

		$json_data = json_encode($entry_data);

		$data = array(
			'username'		=> $this->session->userdata('username'),
			'activity'		=> "Entry Location Directory Deleted: " . ' ID: ' . $id,
			'datas'			=> $json_data,
			'pc_ip'			=> $_SERVER['REMOTE_ADDR'],
			'type'			=> "IT: LOCATION DIRECTORY",
			'date'			=> date('Y-m-d H:i:s')
		);

		// CALL ACTIVITY LOGS DATABASE 
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);


		$this->db->where('id', $id);
		$query = $this->db->delete('location_directory');

		return $query;
	}
}    