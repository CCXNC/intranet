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
			'created_date' => date('y-m-d H:i:s')
		);
		$query = $this->db->insert('location_directory', $data);

		return $query;
	}

	public function update_location_directory($id)
	{
		$name = $this->input->post('name');
		$telephone_no = $this->input->post('telephone_no');

		$data = array(
			'name'         => $name,
			'telephone_no' => $telephone_no,
			'updated_by'   => $this->session->userdata('username'),
			'updated_date' => date('y-m-d H:i:s')
		);

		$this->db->where('id', $id);
		$query = $this->db->update('location_directory', $data);

		return $query;
	}

	public function delete_location_directory($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete('location_directory');

		return $query;
	}
}    