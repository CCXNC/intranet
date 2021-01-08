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
		$gender = $this->input->post('gender');
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
		$occupation = $this->input->post('occupation');
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
			'gender'                   => $gender,
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

		$x = 0;
		foreach($school as $schoool)
		{
			if($schoool == NULL)
			{

			}
			else
			{
				$data_academe = array(
					'employee_number' => $employee_number,
					'school'          => $schoool,
					'course'          => $course[$x],
					'year_graduated'  => $year_graduated[$x],
					'license'         => $license[$x],
					'created_at'      => $date,
					'created_by'      => $this->session->userdata('username')
				);
		
				/*print_r('<pre>');
				print_r($data_academe);
				print_r('</pre>');*/
				$this->db->insert('academe_info', $data_academe);
				$x++;
			}
		}


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
				'name'            => $spouse_full_name,
				'birthday'        => $spouse_birthday,
				'age'             => $spouse_age,
				'occupation'      => $occupation,
				'created_at'      => $date,
				'created_by'      => $this->session->userdata('username')
			);

			$this->db->insert('spouse_info', $data_spouse);
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
					'name'            => $fullname,
					'birthday'        => $children_birthday[$i],
					'age'             => $children_age[$i],
					'gender'          => $children_gender[$i],
					'created_at'      => $date,
					'created_by'      => $this->session->userdata('username')
				);

				/*print_r('<pre>');
				print_r($data_children);
				print_r('</pre>');*/
				$this->db->insert('children_info', $data_children);
				$i++;
			}
		}
	
		
		$trans = $this->db->trans_complete();
		return $trans;
	
	}
	
	public function get_employees($emp_status, $emp_department)
	{
		$this->db->select("
			employees.id as id,
			employees.picture as picture,
			employees.employee_number as emp_no,
			CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
			employment_info.date_hired as date_hired,
			employment_info.department as department,
			employee_status.name as employee_status
		");
		$this->db->from('employees');
		$this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number');
		$this->db->join('employee_status', 'employment_info.employee_status = employee_status.id');
		$this->db->order_by('employees.last_name', 'ASC');
		$this->db->where('employees.is_active', 1);
		if($emp_status != 'ALL' && $emp_department != 'ALL') 
		{
			$this->db->where('employment_info.employee_status', $emp_status);
			$this->db->where('employment_info.department', $emp_department);
		}
		$query = $this->db->get();

		return $query->result();
	}
	
	public function get_employee($id)
	{
		$this->db->select("
			employees.id as id,
			employees.picture as picture,
			employees.employee_number as emp_no,
			CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname,
			employees.nick_name as nick_name,
			employees.birthday as birthday,
			employees.age as age,
			employees.marital_status as marital_status,
			employees.contact_number as contact_number,
			employees.email_address as email_address,
			employees.emergency_contact_name as emergency_name,
			employees.emergency_contact_number as contact_number,
			employees.address as address,
			employees.gender as gender,
			employees.sss_number as sss,
			employees.philhealth_number as philhealth,
			employees.pagibig_number as pagibig,
			employees.tin_number as tin,
			
			parents_info.father_name as father_name,
			parents_info.mother_name as mother_name,

			spouse_info.name as spouse_name,
			spouse_info.birthday as spouse_birthday,
			spouse_info.age as spouse_age,
			spouse_info.occupation as spouse_occupation,

			employment_info.company as emp_company,
			employment_info.rank as emp_rank,
			employment_info.department as emp_department,
			employment_info.work_group as emp_workgroup,
			employment_info.employee_status as emp_status,
			
			employment_info.date_hired as date_hired,
			employment_info.department as department,
			employment_info.position as position,
			employment_info.immediate_superior as superior,
			employment_info.years_of_service as years_of_service,

			employee_status.name as employee_status,
			company.name as company_name,
			rank.name as rank_name,
			department.name as department_name,
			work_group.name as work_group

		");
		$this->db->from('employees');
		$this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number');

		/** Connection to Employment Info */
		$this->db->join('employee_status', 'employment_info.employee_status = employee_status.id');
		$this->db->join('company', 'employment_info.company = company.id');
		$this->db->join('rank', 'employment_info.rank = rank.id');
		$this->db->join('department', 'employment_info.department = department.id');
		$this->db->join('work_group', 'employment_info.work_group = work_group.id');

		$this->db->join('parents_info', 'parents_info.employee_number = employees.employee_number','left');
		$this->db->join('spouse_info', 'spouse_info.employee_number = employees.employee_number','left');
		$this->db->order_by('employees.last_name', 'ASC');
		$this->db->where('employees.is_active', 1);
		$this->db->where('employees.id', $id);
	
		$query = $this->db->get();

		return $query->row();
	}

	public function get_academe_infos($employee_number)
	{
		$this->db->where('employee_number', $employee_number);
		$this->db->order_by('year_graduated', 'DESC');
		$query = $this->db->get('academe_info');
		return $query->result();
	}

	public function get_children_infos($employee_number)
	{
		$this->db->where('employee_number', $employee_number);
		$this->db->order_by('birthday', 'DESC');
		$query = $this->db->get('children_info');
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
