<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    public function add_employee()
    {
		$this->db->trans_start();

		//EMPLOYEE INPUT
		$picture = $file_name = $_FILES['userfile']['name'];;
		$employee_number = $this->input->post('employee_number');
		$first_name = $this->input->post('first_name');
		$middle_name = $this->input->post('middle_name');
		$last_name = $this->input->post('last_name');
		$nickname = $this->input->post('nickname');
		$gender = $this->input->post('gender');
		$birthday = $this->input->post('birthday');
		$age = $this->input->post('age');
		$religion = $this->input->post('religion');
		$email = $this->input->post('email');
		$contact_number = $this->input->post('contact_number');
		$marital_status = $this->input->post('marital_status');
		$address = $this->input->post('address');
		$emergency_name = $this->input->post('emergency_name');
		$emergency_contact = $this->input->post('emergency_contact');
		$tin = $this->input->post('tin');
		$sss = $this->input->post('sss');
		$philhealth = $this->input->post('philhealth');
		$pagibig = $this->input->post('pagibig');

		//ACADEME INPUT
		$school = $this->input->post('school');
		$course = $this->input->post('course');
		$year_graduated = $this->input->post('year_graduated');
		$license = $this->input->post('license');

		//EMPLOYMENT INPUT
		$date_hired = $this->input->post('date_hired');
		$company = $this->input->post('company');
		$position = $this->input->post('position');
		$rank = $this->input->post('rank');
		$department = $this->input->post('department');
		$work_group = $this->input->post('work_group');
		$superior = $this->input->post('superior');
		$employee_status = $this->input->post('employee_status');
		$year_of_service = $this->input->post('year_of_service');

		//PARENTS INPUT
		$father_full_name = $this->input->post('father_full_name');
		$mother_full_name = $this->input->post('mother_full_name');
		//SPOUSE INPUT
		$spouse_full_name = $this->input->post('spouse_full_name');
		$spouse_birthday = $this->input->post('spouse_birthday');
		$spouse_age = $this->input->post('spouse_age');
		//CHILDREN INPUT
		$children_birthday   = $this->input->post('children_birthday');
		$children_age        = $this->input->post('children_age');
		$children_gender     = $this->input->post('children_gender');
		$i = 0;
		$date = date('Y-m-d h:i:s');
		
		$data_employee = array(
			'picture'                  => $picture,
			'employee_number'          => $employee_number,
			'first_name'               => $first_name,
			'middle_name'              => $middle_name,
			'last_name'                => $last_name,
			'nick_name'                => $nickname,
			'birthday'                 => $birthday,
			'age'                      => $age,
			'marital_status'           => $marital_status,
			'contact_number'           => $contact_number,
			'email_address'            => $email,
			'emergency_contact_name'   => $emergency_name,
			'emergency_contact_number' => $emergency_contact,
			'address'                  => $address,
			'sss_number'               => $sss,
			'tin_number'               => $tin,
			'pagibig_number'           => $pagibig,
			'philhealth_number'        => $philhealth,
			'created_at'               => $date,
			'created_by'               => $this->session->userdata('username')
		);
		
		$this->db->insert('employees', $data_employee);
		/*print_r('<pre>');
		print_r($data_employee);
		print_r('</pre>');*/

		$data_academe = array(
			'employee_number' => $employee_number,
			'school'          => $school,
			'course'          => $course,
			'year_graduated'  => $year_graduated,
			'license'         => $license,
			'created_at'      => $date,
			'created_by'      => $this->session->userdata('username')
		);

		/*print_r('<pre>');
		print_r($data_academe);
		print_r('</pre>');*/
		$this->db->insert('academe_info', $data_academe);

		$data_parent = array(
			'employee_number' => $employee_number,
			'father_name'     => $father_full_name,
			'mother_name'     => $mother_full_name,
			'created_at'      => $date,
			'created_by'      => $this->session->userdata('username')
		);

		/*print_r('<pre>');
		print_r($data_parent);
		print_r('</pre>');*/
		$this->db->insert('parents_info', $data_parent);

		if($spouse_full_name == NULL) 
		{
			
		} 
		else 
		{
			$data_spouse = array(
				'employee_number' => $employee_number,
				'spouse_name'     => $spouse_full_name,
				'birthday'        => $spouse_birthday,
				'age'             => $spouse_age,
				'created_at'      => $date,
				'created_by'      => $this->session->userdata('username')
			);

			$this->db->insert('family_info', $data_spouse);
			/*print_r('<pre>');
			print_r($data_spouse);
			print_r('</pre>');*/
		}


		$data_employment = array(
			'employee_number'    => $employee_number,
			'date_hired'         => $date_hired,
			'company'            => $company,
			'position'           => $position,
			'work_group'         => $work_group,
			'department'         => $department,
			'immediate_superior' => $superior,
			'employee_status'    => $employee_status,
			'years_of_service'   => $year_of_service,
			'rank'               => $rank,
			'created_at'         => $date,
			'created_by'         => $this->session->userdata('username')
		);

		$this->db->insert('employment_info', $data_employment);
		/*print_r('<pre>');
		print_r($data_employment);
		print_r('</pre>');*/
		$children_full_name = $this->input->post('children_full_name');
	
		foreach($children_full_name as $fullname)
		{
			if($fullname == NULL)
			{

			}
			else
			{
				$data_children = array(
					'employee_number' => $employee_number,
					'child_name'      => $fullname,
					'birthday'        => $children_birthday[$i],
					'age'             => $children_age[$i],
					'gender'          => $children_gender[$i],
					'created_at'      => $date,
					'created_by'      => $this->session->userdata('username')
				);

				$this->db->insert('family_info', $data_children);
				$i++;
			}
		}
	
		
		$trans = $this->db->trans_complete();
		return $trans;
	
	}
	
	public function get_employees()
	{
		$this->db->select("
			employees.picture as picture,
			employees.employee_number as emp_no,
			CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
			employment_info.date_hired as date_hired,
			employee_status.name as employee_status
		");
		$this->db->from('employees');
		$this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number');
		$this->db->join('employee_status', 'employment_info.employee_status = employee_status.id');
		$this->db->order_by('employees.last_name', 'ASC');
		$this->db->where('employees.is_active', 1);

		$query = $this->db->get();

		return $query->result();
	}
	
	public function get_department()
	{
		$query = $this->db->get('department');
		return $query->result();
	}

	public function get_company()
	{
		$query = $this->db->get('company');
		return $query->result();
	}

	public function get_rank()
	{
		$query = $this->db->get('rank');
		return $query->result();
	}

	public function get_employee_status()
	{
		$query = $this->db->get('employee_status');
		return $query->result();
	}

	public function get_work_group()
	{
		$query = $this->db->get('work_group');
		return $query->result();
	}
}
