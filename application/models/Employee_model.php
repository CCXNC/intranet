<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    public function add_employee()
    {
		$this->db->trans_start();

		//EMPLOYEE INPUT
		$picture = $_FILES['image']['name'];
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
		$emergency_relationship = $this->input->post('emergency_relationship');

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
		$category = $this->input->post('category');

		//PARENTS INPUT
		$father_full_name = $this->input->post('father_full_name');
		$mother_full_name = $this->input->post('mother_full_name');
		//SPOUSE INPUT
		$spouse_full_name = $this->input->post('spouse_full_name');
		$spouse_birthday = $this->input->post('spouse_birthday');
		$spouse_age = $this->input->post('spouse_age');
		$occupation = $this->input->post('occupation');
		$employer = $this->input->post('employer');

		//CHILDREN INPUT
		$children_full_name = $this->input->post('children_full_name');
		$children_birthday   = $this->input->post('children_birthday');
		//$children_age        = $this->input->post('children_age');
		$children_gender     = $this->input->post('children_gender');
		
	
		
		$i = 0;
		$date = date('Y-m-d H:i:s');
		
		// AGE EMPLOYEE
		$today = date("Y-m-d");
		$diff = date_diff(date_create($birthday), date_create($today));
		$ageEmployee = $diff->format('%y');

		$data_employee = array(
			'picture'                        => $picture,
			'employee_number'                => $employee_number,
			'first_name'                     => $first_name,
			'middle_name'                    => $middle_name,
			'last_name'                      => $last_name,
			'nick_name'                      => $nickname,
			'birthday'                       => $birthday,
			'age'                            => $ageEmployee,
			'gender'                         => $gender,
			'marital_status'                 => $marital_status,
			'contact_number'                 => $contact_number,
			'email_address'                  => $email,
			'emergency_contact_name'         => $emergency_name,
			'emergency_contact_number'       => $emergency_contact,
			'emergency_contact_relationship' => $emergency_relationship,
			'address'                        => $address,
			'sss_number'                     => $sss,
			'tin_number'                     => $tin,
			'pagibig_number'                 => $pagibig,
			'philhealth_number'              => $philhealth,
			'created_date'                     => $date,
			'created_by'                     => $this->session->userdata('username')
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
					'created_date'    => $date,
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
			'created_date'    => $date,
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
			// AGE SPOUSE
			$today = date("Y-m-d");
			$diff = date_diff(date_create($spouse_birthday), date_create($today));
			$ageSpouse = $diff->format('%y');
			$data_spouse = array(
				'employee_number' => $employee_number,
				'name'            => $spouse_full_name,
				'birthday'        => $spouse_birthday,
				'age'             => $ageSpouse,
				'occupation'      => $occupation,
				'employer'        => $employer,
				'created_date'    => $date,
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
			'date_probitionary'  => $date_hired,
			'company'            => $company,
			'position'           => $position,
			'category'           => $category,
			'work_group'         => $work_group,
			'department'         => $department,
			'immediate_superior' => $superior,
			'employee_status'    => $employee_status,
			'years_of_service'   => $year_of_service,
			'rank'               => $rank,
			'created_date'       => $date,
			'created_by'         => $this->session->userdata('username')
		);

		$this->db->insert('employment_info', $data_employment);
		/*print_r('<pre>');
		print_r($data_employment);
		print_r('</pre>');*/

		
		foreach($children_full_name as $fullname)
		{
			if($fullname == NULL)
			{

			}
			else
			{
				// AGE CHILDREN
				$today = date("Y-m-d");
				$diff = date_diff(date_create($children_birthday[$i]), date_create($today));
				$ageChildren = $diff->format('%y');

				$data_children = array(
					'employee_number' => $employee_number,
					'name'            => $fullname,
					'birthday'        => $children_birthday[$i],
					'age'             => $ageChildren,
					'gender'          => $children_gender[$i],
					'created_date'    => $date,
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
	
	public function get_employees()
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
		$this->db->join('employee_status', 'employment_info.employee_status = employee_status.id','left');
		$this->db->order_by('employees.last_name', 'ASC');
		$this->db->where('employees.is_active', 1);
		
		$query = $this->db->get();

		return $query->result();
	}
	
	public function get_employee($id)
	{
		$this->db->select("
			employees.id as id,
			employees.picture as picture,
			employees.employee_number as emp_no,
			employees.last_name as last_name,
			employees.middle_name as middle_name,
			employees.first_name as first_name, 
			CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname,
			employees.nick_name as nick_name,
			employees.birthday as birthday,
			employees.age as age,
			employees.marital_status as marital_status,
			employees.contact_number as contact_number,
			employees.email_address as email_address,
			employees.emergency_contact_name as emergency_name,
			employees.emergency_contact_number as emergency_contact_number,
			employees.emergency_contact_relationship as emergency_contact_relationship,
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
			spouse_info.employer as spouse_employer,

			parents_info.id as parent_id,
			employment_info.id as employment_id,
			spouse_info.id as spouse_id,

			employment_info.company as emp_company,
			employment_info.rank as emp_rank,
			employment_info.department as emp_department,
			employment_info.work_group as emp_workgroup,
			employment_info.employee_status as emp_status,
			employment_info.date_hired as date_hired,
			employment_info.date_regular as date_regular,
			employment_info.date_probitionary as date_probitionary,
			employment_info.position as position,
			employment_info.immediate_superior as superior,
			employment_info.years_of_service as years_of_service,
			
			employment_info.department as department_id,
			employment_info.company as company_id,
			employment_info.rank as rank_id,
			employment_info.work_group as work_group_id,
			employment_info.category as category_id,
			employment_info.employee_status as employee_status_id,

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

	public function update_employee($id,$employee_number)
	{
		$this->db->trans_start();

		//EMPLOYEE INPUT
		$picture = $_FILES['image']['name'];
		//$employee_number = $this->input->post('employee_number');
		$first_name = $this->input->post('first_name');
		$middle_name = $this->input->post('middle_name');
		$last_name = $this->input->post('last_name');
		$nickname = $this->input->post('nickname');
		$gender = $this->input->post('gender');
		$birthday = $this->input->post('birthday');
		//$age = $this->input->post('age');
		$gender = $this->input->post('gender');
		$religion = $this->input->post('religion');
		$email = $this->input->post('email');
		$contact_number = $this->input->post('contact_number');
		$marital_status = $this->input->post('marital_status');
		$address = $this->input->post('address');

		$emergency_name = $this->input->post('emergency_name');
		$emergency_contact = $this->input->post('emergency_contact');
		$emergency_relationship = $this->input->post('emergency_relationship');

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
		$date_probitionary = $this->input->post('date_probitionary');
		$date_regular = $this->input->post('date_regular');
		$company = $this->input->post('company');
		$position = $this->input->post('position');
		$rank = $this->input->post('rank');
		$department = $this->input->post('department');
		$work_group = $this->input->post('work_group');
		$superior = $this->input->post('superior');
		$employee_status = $this->input->post('employee_status');
		$year_of_service = $this->input->post('year_of_service');
		$category = $this->input->post('category');

		//PARENTS INPUT
		$father_full_name = $this->input->post('father_full_name');
		$mother_full_name = $this->input->post('mother_full_name');

		//SPOUSE INPUT
		$spouse_full_name = $this->input->post('spouse_full_name');
		$spouse_birthday = $this->input->post('spouse_birthday');
		$spouse_age = $this->input->post('spouse_age');
		$occupation = $this->input->post('occupation');
		$employer = $this->input->post('employer');

		//CHILDREN INPUT
		$children_birthday   = $this->input->post('children_birthday');
		//$children_age        = $this->input->post('children_age');
		$children_gender     = $this->input->post('children_gender');

		//IDS
		$parent_id = $this->input->post('parent_id');
		$spouse_id = $this->input->post('spouse_id');
		$children_id = $this->input->post('children_id');
		$academe_id = $this->input->post('academe_id');
		$employment_id = $this->input->post('employment_id');

		$i = 0;
		$date = date('Y-m-d H:i:s');

		// AGE EMPLOYEE
		$today = date("Y-m-d");
		$diff = date_diff(date_create($birthday), date_create($today));
		$ageEmployee = $diff->format('%y');

		if($picture == NULL)
		{
			$data_employee = array(
				
				'first_name'                     => $first_name,
				'middle_name'                    => $middle_name,
				'last_name'                      => $last_name,
				'nick_name'                      => $nickname,
				'birthday'                       => $birthday,
				'age'                            => $ageEmployee,
				'gender'                         => $gender,
				'marital_status'                 => $marital_status,
				'contact_number'                 => $contact_number,
				'email_address'                  => $email,
				'emergency_contact_name'         => $emergency_name,
				'emergency_contact_number'       => $emergency_contact,
				'emergency_contact_relationship' => $emergency_relationship,
				'address'                        => $address,
				'sss_number'                     => $sss,
				'tin_number'                     => $tin,
				'pagibig_number'                 => $pagibig,
				'philhealth_number'              => $philhealth,
				'updated_date'                   => $date,
				'updated_by'                     => $this->session->userdata('username')
			);
			
			/*print_r('<pre>');
			print_r($data_employee);
			print_r('</pre>');*/
			$this->db->where('employees.id', $id);
			$this->db->where('employees.employee_number', $employee_number);
			$this->db->update('employees', $data_employee);
		}
		else 
		{
			$data_employee = array(
				'picture'                        => $picture,
				'first_name'                     => $first_name,
				'middle_name'                    => $middle_name,
				'last_name'                      => $last_name,
				'nick_name'                      => $nickname,
				'birthday'                       => $birthday,
				'age'                            => $ageEmployee,
				'gender'                         => $gender,
				'marital_status'                 => $marital_status,
				'contact_number'                 => $contact_number,
				'email_address'                  => $email,
				'emergency_contact_name'         => $emergency_name,
				'emergency_contact_number'       => $emergency_contact,
				'emergency_contact_relationship' => $emergency_relationship,
				'address'                        => $address,
				'sss_number'                     => $sss,
				'tin_number'                     => $tin,
				'pagibig_number'                 => $pagibig,
				'philhealth_number'              => $philhealth,
				'updated_date'                   => $date,
				'updated_by'                     => $this->session->userdata('username')
			);
			
			/*print_r('<pre>');
			print_r($data_employee);
			print_r('</pre>');*/
			$this->db->where('employees.id', $id);
			$this->db->where('employees.employee_number', $employee_number);
			$this->db->update('employees', $data_employee);
		}
		

		$data_parent = array(
			'id' => $parent_id,
			'father_name'     => $father_full_name,
			'mother_name'     => $mother_full_name,
			'updated_date'    => $date,
			'updated_by'      => $this->session->userdata('username')
		);

		/*print_r('<pre>');
		print_r($data_parent);
		print_r('</pre>');*/
		$this->db->where('parents_info.id', $parent_id);
		$this->db->where('parents_info.employee_number', $employee_number);
		$this->db->update('parents_info', $data_parent);


		if($spouse_id == NULL) 
		{

		}
		else
		{
			// AGE SPOUSE
			$today = date("Y-m-d");
			$diff = date_diff(date_create($spouse_birthday), date_create($today));
			$ageSpouse = $diff->format('%y');

			$data_spouse = array(
				'name'            => $spouse_full_name,
				'birthday'        => $spouse_birthday,
				'age'             => $ageSpouse,
				'occupation'      => $occupation,
				'employer'        => $employer,
				'updated_date'    => $date,
				'updated_by'      => $this->session->userdata('username')
			);
	
			/*print_r('<pre>');
			print_r($data_spouse);
			print_r('</pre>');*/
			$this->db->where('spouse_info.id', $spouse_id);
			$this->db->where('spouse_info.employee_number', $employee_number);
			$this->db->update('spouse_info', $data_spouse);
		}

		$children_full_name = $this->input->post('children_full_name');
		if($children_id != NULL) 
		{
			foreach($children_full_name as $fullname)
			{
				
				// AGE CHILDREN
				$today = date("Y-m-d");
				$diff = date_diff(date_create($children_birthday[$i]), date_create($today));
				$ageChildren = $diff->format('%y');
				
				$data_children = array(
					'name'            => $fullname,
					'birthday'        => $children_birthday[$i],
					'age'             => $ageChildren,
					'gender'          => $children_gender[$i],
					'updated_date'    => $date,
					'updated_by'      => $this->session->userdata('username')
				);

				/*print_r('<pre>');
				print_r($data_children);
				print_r('</pre>');*/
				$this->db->where('children_info.id', $children_id[$i]);
				$this->db->where('children_info.employee_number', $employee_number);
				$this->db->update('children_info', $data_children);
				$i++;
				
			}
		}

		$x = 0;
		if($academe_id != NULL)
		{
			foreach($school as $schoool)
			{
				$data_academe = array(
					'school'          => $schoool,
					'course'          => $course[$x],
					'year_graduated'  => $year_graduated[$x],
					'license'         => $license[$x],
					'updated_date'    => $date,
					'updated_by'      => $this->session->userdata('username')
				);
		
				/*print_r('<pre>');
				print_r($data_academe);
				print_r('</pre>');*/
				$this->db->where('academe_info.id', $academe_id[$x]);
				$this->db->where('academe_info.employee_number', $employee_number);
				$this->db->update('academe_info', $data_academe);
				$x++;
			}
		}

		$data_employment = array(
			'date_hired'         => $date_hired,
			'date_probitionary'  => $date_probitionary,
			'date_regular'       => $date_regular,
			'company'            => $company,
			'position'           => $position,
			'category'           => $category,
			'work_group'         => $work_group,
			'department'         => $department,
			'immediate_superior' => $superior,
			'employee_status'    => $employee_status,
			'years_of_service'   => $year_of_service,
			'rank'               => $rank,
			'updated_date'       => $date,
			'updated_by'         => $this->session->userdata('username')
		);

		/*print_r('<pre>');
		print_r($data_employment);
		print_r('</pre>');*/
		$this->db->where('employment_info.id', $employment_id);
		$this->db->where('employment_info.employee_number', $employee_number);
		$this->db->update('employment_info', $data_employment);

		$trans = $this->db->trans_complete();
		return $trans;


	}

	public function get_attachments($employee_number)
	{
		$this->db->where('employee_number', $employee_number);
		$this->db->order_by('created_date', 'DESC');
		$query = $this->db->get('attachment');
		return $query->result();	
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
		$this->db->order_by('age', 'DESC');
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

	public function update_employee_movement($id,$employee_number)
	{
		$this->db->trans_start();

		$employee_number = $this->input->post('employee_number');
		$employee_status = $this->input->post('employee_status');
		$date_probitionary = $this->input->post('date_probitionary');
		$date_regular = $this->input->post('date_regular');
		$company = $this->input->post('company');
		$position = $this->input->post('position');
		$rank = $this->input->post('rank');
		$department = $this->input->post('department');
		$work_group = $this->input->post('work_group');
		$superior = $this->input->post('superior');
		$movement_from = $this->input->post('movement_from');
		$date_transfer = $this->input->post('date_transfer');
		$remarks = $this->input->post('remarks');
		$credit = $this->input->post('credit');
		$datetime = date('Y-m-d H:i:s');

		// GET RECENT DATA FROM EMPLOYMENT INFO 
		/*$this->db->select('*');
		$this->db->where('employment_info.employee_number', $employee_number);
		$datas = $this->db->get('employment_info');
		$emp_employee_number = $datas->row()->employee_number;
		$emp_company = $datas->row()->company;
		$emp_department = $datas->row()->department;
		$emp_position = $datas->row()->position;
		$emp_work_group = $datas->row()->work_group;
		$emp_position = $datas->row()->position;
		$emp_superior = $datas->row()->immediate_superior;
		$emp_rank = $datas->row()->rank;
		$emp_employee_status = $datas->row()->employee_status;*/

		
		if($department == NULL) 
		{

			$data_transfer = array(
				'employee_number'    => $employee_number,
				'employee_status'    => $employee_status,
				'company'            => $company,
				'position'           => $position,
				'work_group'         => $work_group,
				'rank'               => $rank,
				'position'           => $position,
				'immediate_superior' => $superior,
				'department'         => $movement_from,
				'date_transfer'      => $date_transfer,
				'remarks'            => $remarks,
				'created_date'       => $datetime,
				'created_by'         => $this->session->userdata('username')
			);

				$this->db->insert('transfer_logs', $data_transfer);
				/*print_r('<pre>');
				print_r($data_transfer);
				print_r('</pre>');*/
			
		
			$data_employment = array(
				'company'            => $company,
				'department'         => $movement_from,
				'rank'               => $rank,
				'employee_status'    => $employee_status,
				'work_group'         => $work_group,
				'immediate_superior' => $superior,
				'position'           => $position,
				'date_regular'       => $date_regular,
				'date_probitionary'  => $date_probitionary,
				'updated_date'       => $datetime,
				'updated_by'         => $this->session->userdata('username')
			);
	
			$this->db->where('id', $id);
			$this->db->where('employee_number', $employee_number);
			$this->db->update('employment_info', $data_employment);
			/*print_r('<pre>');
			print_r($data_employment);
			print_r('</pre>');*/
		}
		else 
		{
			$data_transfer = array(
				'employee_number'    => $employee_number,
				'employee_status'    => $employee_status,
				'company'            => $company,
				'position'           => $position,
				'work_group'         => $work_group,
				'rank'               => $rank,
				'position'           => $position,
				'immediate_superior' => $superior,
				'department'         => $department,
				'date_transfer'      => $date_transfer,
				'remarks'            => $remarks,
				'created_date'       => $datetime,
				'created_by'         => $this->session->userdata('username')
			);

				$this->db->insert('transfer_logs', $data_transfer);
				/*print_r('<pre>');
				print_r($data_transfer);
				print_r('</pre>');*/

			$data_employment = array(
				'company'            => $company,
				'department'         => $department,
				'rank'               => $rank,
				'employee_status'    => $employee_status,
				'work_group'         => $work_group,
				'immediate_superior' => $superior,
				'position'           => $position,
				'date_regular'       => $date_regular,
				'date_probitionary'  => $date_probitionary,
				'updated_date'       => $datetime,
				'updated_by'         => $this->session->userdata('username')
			);
	
			$this->db->where('id', $id);
			$this->db->where('employee_number', $employee_number);
			$this->db->update('employment_info', $data_employment);
			/*print_r('<pre>');
			print_r($data_employment);
			print_r('</pre>');*/
		}
		

		$trans = $this->db->trans_complete();
		return $trans;

	}

	public function update_employee_termination($id,$employee_number)
	{
		$this->db->trans_start();

		// EMPLOYMENT INFO
		$employee_status = $this->input->post('employee_status');
		$date_probitionary = $this->input->post('date_probitionary');
		$date_regular = $this->input->post('date_regular');
		$year_of_service = $this->input->post('year_of_service');
		$date_termination = $this->input->post('date_termination');
		$date_clearance = $this->input->post('date_clearance');
		$remarks = $this->input->post('remarks');
		$datetime = date('Y-m-d H:i:s');

		
		$employee_data = array(
			'is_active' => 0
		);

		$this->db->where('id', $id);
		$this->db->update('employees', $employee_data);
					
		/*print_r('<pre>');
		print_r($employee_data);
		print_r('</pre>');*/
		

		$data = array(
			'employee_status'   => $employee_status,
			'date_termination'  => $date_termination,
			'date_clearance'    => $date_clearance,
			'remarks'           => $remarks,
			'updated_date'      => $datetime,
			'updated_by'        => $this->session->userdata('username')

		);

		$this->db->where('employee_number', $employee_number);
		$this->db->update('employment_info', $data);

		/*print_r('<pre>');
		print_r($data);
		print_r('</pre>');*/


		$trans = $this->db->trans_complete();
		return $trans;
		
	}

	public function add_employee_info()
	{
		$this->db->trans_start();

		//SPOUSE INPUT
		$employee_number = $this->input->post('employee_number');
		$spouse_full_name = $this->input->post('spouse_full_name');
		$spouse_birthday = $this->input->post('spouse_birthday');
		//$spouse_age = $this->input->post('spouse_age');
		$occupation = $this->input->post('occupation');
		//CHILDREN INPUT
		$children_birthday   = $this->input->post('children_birthday');
		//$children_age        = $this->input->post('children_age');
		$children_gender     = $this->input->post('children_gender');
		//ACADEME INPUT
		$school = $this->input->post('school');
		$course = $this->input->post('course');
		$year_graduated = $this->input->post('year_graduated');
		$license = $this->input->post('license');
		$date = date('Y-m-d H:i:s');

		if($spouse_full_name == NULL) 
		{
			
		} 
		else 
		{
			// AGE SPOUSE
			$today = date("Y-m-d");
			$diff = date_diff(date_create($spouse_birthday), date_create($today));
			$ageSpouse = $diff->format('%y');

			$data_spouse = array(
				'employee_number' => $employee_number,
				'name'            => $spouse_full_name,
				'birthday'        => $spouse_birthday,
				'age'             => $ageSpouse,
				'occupation'      => $occupation,
				'created_date'    => $date,
				'created_by'      => $this->session->userdata('username')
			);

			$this->db->insert('spouse_info', $data_spouse);
			/*print_r('<pre>');
			print_r($data_spouse);
			print_r('</pre>');*/
		}

		$i = 0;
		$children_full_name = $this->input->post('children_full_name');
		foreach($children_full_name as $fullname)
		{
			if($fullname == NULL)
			{

			}
			else
			{
				// AGE CHILDREN
				$today = date("Y-m-d");
				$diff = date_diff(date_create($children_birthday[$i]), date_create($today));
				$ageChildren = $diff->format('%y');

				$data_children = array(
					'employee_number' => $employee_number,
					'name'            => $fullname,
					'birthday'        => $children_birthday[$i],
					'age'             => $ageChildren,
					'gender'          => $children_gender[$i],
					'created_date'    => $date,
					'created_by'      => $this->session->userdata('username')
				);

				/*print_r('<pre>');
				print_r($data_children);
				print_r('</pre>');*/
				$this->db->insert('children_info', $data_children);
				$i++;
			}
		}

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
					'created_date'    => $date,
					'created_by'      => $this->session->userdata('username')
				);
		
				/*print_r('<pre>');
				print_r($data_academe);
				print_r('</pre>');*/
				$this->db->insert('academe_info', $data_academe);
				$x++;
			}
		}

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function get_transfer_logs($employee_number)
	{
		$this->db->select('
			transfer_logs.position as position,
			transfer_logs.immediate_superior as superior,
			transfer_logs.date_transfer as date,
			transfer_logs.remarks as remarks,
			transfer_logs.created_date as date_created,

			employee_status.name as employee_status,
			department.name as department_name,
			company.name as company_name,
			rank.name as rank_name,
			work_group.name as work_group
		');

		$this->db->from('transfer_logs');
		$this->db->where('transfer_logs.employee_number', $employee_number);
		$this->db->order_by('transfer_logs.created_date', 'DESC');
		$this->db->join('employee_status', 'transfer_logs.employee_status = employee_status.id');
		$this->db->join('company', 'transfer_logs.company = company.id');
		$this->db->join('rank', 'transfer_logs.rank = rank.id');
		$this->db->join('department', 'transfer_logs.department = department.id');
		$this->db->join('work_group', 'transfer_logs.work_group = work_group.id');
		
		$query = $this->db->get();

		return $query->result();
	}

	public function delete_all_information($id,$parent_id,$spouse_id,$employment_id,$employee_number)
	{
		/*$id = $this->input->post('id');
		$parent_id = $this->input->post('parent_id');
		$spouse_id = $this->input->post('spouse_id');
		$employment_id = $this->input->post('employment_id');
		$employee_number = $this->input->post('emp_no');*/
	

		/*$data = array(
			'id'  => $id,
			'parent_id' => $parent_id,
			'spouse_id' => $spouse_id,
			'employment_id' => $employment_id,
			'employee_number' => $employee_number
		);

		print_r('<pre>');
		print_r($data);
		print_r('</pre>');*/


		$this->db->trans_start();
		
		$this->db->where('id', $id);
		$this->db->where('employee_number', $employee_number);
		$this->db->delete('employees');

		$this->db->where('id', $parent_id);
		$this->db->where('employee_number', $employee_number);
		$this->db->delete('parents_info');

		$this->db->where('id', $spouse_id);
		$this->db->where('employee_number', $employee_number);
		$this->db->delete('spouse_info');

		$this->db->where('id', $employment_id);
		$this->db->where('employee_number', $employee_number);
		$this->db->delete('employment_info');

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function delete_children_information($id,$employee_number)
	{

		$this->db->trans_start();
		
		$this->db->where('id', $id);
		$this->db->where('employee_number', $employee_number);
		$this->db->delete('children_info');

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function delete_academe_information($id,$employee_number)
	{

		$this->db->trans_start();
		
		$this->db->where('id', $id);
		$this->db->where('employee_number', $employee_number);
		$this->db->delete('academe_info');

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function attachment($employee_number)
	{
		$this->db->trans_start();

		$attachment = $this->input->post('attachment');
		$name1 = $this->input->post('attachment1');
		$name2 = $this->input->post('attachment2');

		$resume = $_FILES['resume']['name'];
		$attachment1 = $_FILES['data1']['name'];
		$attachment2 = $_FILES['data2']['name'];

		$date = date('Y-m-d H:i:s');

		$resume_data = array(
			'employee_number' => $employee_number,
			'name'            => $attachment,
			'file'            => $resume,
			'created_date'    => $date,
			'created_by'      => $this->session->userdata('username')
		);

		$this->db->insert('attachment', $resume_data);

		/* print_r('<pre>');
		print_r($resume_data);
		print_r('</pre>'); */

		$data1 = array(
			'employee_number' => $employee_number,
			'name'            => $name1,
			'file'            => $attachment1,
			'created_date'    => $date,
			'created_by'      => $this->session->userdata('username')
		);

		$this->db->insert('attachment', $data1);
		/* print_r('<pre>');
		print_r($data1);
		print_r('</pre>'); */

		$data2= array(
			'employee_number' => $employee_number,
			'name'            => $name2,
			'file'            => $attachment2,
			'created_date'    => $date,
			'created_by'      => $this->session->userdata('username')
		);

		$this->db->insert('attachment', $data2);
		/* print_r('<pre>');
		print_r($data2);
		print_r('</pre>'); */

		$trans = $this->db->trans_complete();
		return $trans;
	}
	
}
