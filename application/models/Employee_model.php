<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    public function add_employee()
    {
		$this->db->trans_start();

		//EMPLOYEE INPUT
		$picture1 = $_FILES['image']['name'];
		$picture = str_replace(' ', '_', $picture1);
		$employee_number = $this->input->post('employee_number');
		$first_name = strtoupper($this->input->post('first_name'));
		$middle_name = strtoupper($this->input->post('middle_name'));
		$last_name = strtoupper($this->input->post('last_name'));
		$nickname = strtoupper($this->input->post('nickname'));
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

		// ADD TO BIOMETRIC TABLE
		$data_biometric = array(
			'employee_number'  => $employee_number,
			'is_biometric'     => 0
		);

		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->insert('employee_biometric', $data_biometric);

		// ADD TO SCHEDULE TABLE
		$data_schedule = array(
			'employee_number'  => $employee_number,
			'is_schedule'      => 0
		);

		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->insert('schedules', $data_schedule);
	
		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 

		$entry_data = "add_employee [entry_data:" . $employee_number . "]";

		$activity_data = array(
			'username'   => $this->session->userdata('username'),
			'pcname'     => $_SERVER['REMOTE_ADDR'],
			'entry_data' => $entry_data,
			'entry_date' => $date
		);
		$activity_log->insert('hris_logs', $activity_data);
		

		$data = array(
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Added",
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> 'HRIS: 201',
			'date'		=> $date
		);

		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);

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
            employee_status.name as employee_status,
            employment_info.position as position,
            company.code as company,
            department.name as department,
			
			employment_info.company as company_id,
			employment_info.department as department_id,
			employee_biometric.biometric_number as biometric_id,
			
		");
		$this->db->from('blaine_intranet.employees');
        $this->db->join('blaine_intranet.employment_info', 'blaine_intranet.employment_info.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.employee_status', 'blaine_intranet.employment_info.employee_status = blaine_intranet.employee_status.id');
        $this->db->join('blaine_intranet.company', 'blaine_intranet.employment_info.company = blaine_intranet.company.id');
        $this->db->join('blaine_intranet.department', 'blaine_intranet.employment_info.department = blaine_intranet.department.id');
		$this->db->join('blaine_timekeeping.employee_biometric', 'blaine_timekeeping.employee_biometric.employee_number = blaine_intranet.employees.employee_number', 'left');
        $this->db->order_by('blaine_intranet.employees.last_name', 'ASC');
        $this->db->where('blaine_intranet.employees.is_active', 1);
		
		$query = $this->db->get();

		return $query->result();
	}

	public function get_resigned()
	{
		$this->db->select("
		employees.id as id,
            employees.picture as picture,
            employees.employee_number as emp_no,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
			employment_info.date_hired as date_hired,
			employment_info.date_termination as date_termination,
            employee_status.name as employee_status,
            employment_info.position as position,

            company.name as company,
            department.name as department,
		");
		$this->db->from('employees');
        $this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number');
        $this->db->join('employee_status', 'employment_info.employee_status = employee_status.id');
        $this->db->join('company', 'employment_info.company = company.id');
        $this->db->join('department', 'employment_info.department = department.id');
        $this->db->order_by('employees.last_name', 'ASC');
        $this->db->where('employees.is_active', 0);
		
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
		$picture1 = $_FILES['image']['name'];
		$picture = str_replace(' ', '_', $picture1);
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

		// GET OLD DATE BEFORE UPDATE
		$this->db->select('*');
		$this->db->where('id', $id);
		$datas 								= $this->db->get('employees');
		$emp_id 							= $datas->row()->id;
		$emp_picture 						= $datas->row()->picture;
		$emp_empno 							= $datas->row()->employee_number;
		$emp_first_name 					= $datas->row()->first_name;
		$emp_middle_name					= $datas->row()->middle_name;
		$emp_last_name						= $datas->row()->last_name;
		$emp_nick_name						= $datas->row()->nick_name;
		$emp_birthday						= $datas->row()->birthday;
		$emp_age							= $datas->row()->age;
		$emp_gender							= $datas->row()->gender;
		$emp_marital_status					= $datas->row()->marital_status;
		$emp_contact_number					= $datas->row()->contact_number;
		$emp_email_address					= $datas->row()->email_address;
		$emp_emergency_contact_name			= $datas->row()->emergency_contact_name;
		$emp_emergency_contact_number		= $datas->row()->emergency_contact_number;
		$emp_emergency_contact_relationship	= $datas->row()->emergency_contact_relationship;
		$emp_address						= $datas->row()->address;
		$emp_sss_number						= $datas->row()->sss_number;
		$emp_tin_number						= $datas->row()->tin_number;
		$emp_pagibig_number					= $datas->row()->pagibig_number;
		$emp_philhealth_number				= $datas->row()->philhealth_number;

		$entry_data = array(
			'id'								=> $emp_id,
			'picture'							=> $emp_picture,
			'employee_number'					=> $emp_empno,
			'first_name'						=> $emp_first_name,
			'middle_name'						=> $emp_middle_name,
			'last_name'							=> $emp_last_name,
			'nick_name'							=> $emp_nick_name,
			'birthday'							=> $emp_birthday,
			'age'								=> $emp_age,
			'gender'							=> $emp_gender,
			'marital_status'					=> $emp_marital_status,
			'contact_number'					=> $emp_contact_number,
			'email_address'						=> $emp_email_address,
			'emergency_contact_name'			=> $emp_emergency_contact_name,
			'emergency_contact_number'			=> $emp_emergency_contact_number,
			'emergency_contact_relationship'	=> $emp_emergency_contact_relationship,
			'address'							=> $emp_address,
			'sss_number'						=> $emp_sss_number,
			'tin_number'						=> $emp_tin_number,
			'pagibig_number'					=> $emp_pagibig_number,
			'philhealth_number'					=> $emp_philhealth_number
		);

		// CONVERT TO JSON ENCODE
		$json_data = json_encode($entry_data);

		$data = array(
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Updated: " . ' ID: ' . $id,
			'datas'		=> "Previous Data: " . $json_data,
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> 'HRIS: 201',
			'date'		=> $date
		);

		// CALL ACTIVITY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);



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

		
		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 

		$entry_data = "update_employee [entry_id:" . $employee_number . "]";

		$activity_data = array(
			'username'   => $this->session->userdata('username'),
			'pcname'     => $_SERVER['REMOTE_ADDR'],
			'entry_data' => $entry_data,
			'entry_date' => $date
		);
		$activity_log->insert('hris_logs', $activity_data);

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

		// GET OLD DATA BEFORE UPDATE
		$this->db->select('*');
		$this->db->where('id', $id);
		$datas 							= $this->db->get('employment_info');
		$emp_info_id 					= $datas->row()->id;
		$emp_info_employee_number		= $datas->row()->employee_number;
		$emp_info_company				= $datas->row()->company;
		$emp_info_department			= $datas->row()->department;
		$emp_info_position				= $datas->row()->position;
		$emp_info_category				= $datas->row()->category;
		$emp_info_work_group			= $datas->row()->work_group;
		$emp_info_rank					= $datas->row()->rank;
		$emp_info_immediate_superior	= $datas->row()->immediate_superior;
		$emp_info_date_hired			= $datas->row()->date_hired;
		$emp_info_employee_status		= $datas->row()->employee_status;
		$emp_info_years_of_service		= $datas->row()->years_of_service;
		$emp_info_date_termination		= $datas->row()->date_termination;
		$emp_info_date_clearance		= $datas->row()->date_clearance;
		$emp_info_date_probitionary		= $datas->row()->date_probitionary;
		$emp_info_date_regular			= $datas->row()->date_regular;
		$emp_info_remarks				= $datas->row()->remarks;

		$entry_data = array(
			'id'					=> $emp_info_id,
			'employee_number'		=> $emp_info_employee_number,
			'company'				=> $emp_info_company,
			'department'			=> $emp_info_department,
			'position'				=> $emp_info_position,
			'category'				=> $emp_info_category,
			'work_group'			=> $emp_info_work_group,
			'rank'					=> $emp_info_rank,
			'immediate_superior'	=> $emp_info_immediate_superior,
			'date_hired'			=> $emp_info_date_hired,
			'employee_status'		=> $emp_info_employee_status,
			'years_of_service'		=> $emp_info_years_of_service,
			'date_termination'		=> $emp_info_date_termination,
			'date_clearance'		=> $emp_info_date_clearance,
			'date_probitionary'		=> $emp_info_date_probitionary,
			'date_regular'			=> $emp_info_date_regular,
			'remarks'				=> $emp_info_remarks
		);

		// CONVERT TO JSON ENCODE
		$json_data = json_encode($entry_data);

		$data = array(
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Movement Updated: " . ' ID: ' . $id,
			'datas'		=> "Previous Data: " . $json_data,
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> 'HRIS: 201',
			'date'		=> $datetime
		);

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 
		$activity_log->insert('blaine_logs', $data);

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

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 

		$entry_data = "employee_movement [entry_id:" . $employee_number . "]";

		$activity_data = array(
			'username'   => $this->session->userdata('username'),
			'pcname'     => $_SERVER['REMOTE_ADDR'],
			'entry_data' => $entry_data,
			'entry_date' => $datetime
		);
		$activity_log->insert('hris_logs', $activity_data);
		

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

		// GET OLD DATA BEFORE UPDATE
		$this->db->select('*');
		$this->db->where('id', $id);
		$datas 							= $this->db->get('employment_info');
		$emp_info_id 					= $datas->row()->id;
		$emp_info_employee_number		= $datas->row()->employee_number;
		//$emp_info_company				= $datas->row()->company;
		//$emp_info_department			= $datas->row()->department;
		//$emp_info_position				= $datas->row()->position;
		//$emp_info_category				= $datas->row()->category;
		//$emp_info_work_group			= $datas->row()->work_group;
		//$emp_info_rank					= $datas->row()->rank;
		//$emp_info_immediate_superior	= $datas->row()->immediate_superior;
		//$emp_info_date_hired			= $datas->row()->date_hired;
		$emp_info_employee_status		= $datas->row()->employee_status;
		$emp_info_years_of_service		= $datas->row()->years_of_service;
		$emp_info_date_termination		= $datas->row()->date_termination;
		$emp_info_date_clearance		= $datas->row()->date_clearance;
		$emp_info_date_probitionary		= $datas->row()->date_probitionary;
		$emp_info_date_regular			= $datas->row()->date_regular;
		$emp_info_remarks				= $datas->row()->remarks;

		$entry_data = array(
			'id'					=> $emp_info_id,
			'employee_number'		=> $emp_info_employee_number,
			//'company'				=> $emp_info_company,
			//'department'			=> $emp_info_department,
			//'position'				=> $emp_info_position,
			//'category'				=> $emp_info_category,
			//'work_group'			=> $emp_info_work_group,
			//'rank'					=> $emp_info_rank,
			//'immediate_superior'	=> $emp_info_immediate_superior,
			//'date_hired'			=> $emp_info_date_hired,
			'employee_status'		=> $emp_info_employee_status,
			'years_of_service'		=> $emp_info_years_of_service,
			'date_termination'		=> $emp_info_date_termination,
			'date_clearance'		=> $emp_info_date_clearance,
			'date_probitionary'		=> $emp_info_date_probitionary,
			'date_regular'			=> $emp_info_date_regular,
			'remarks'				=> $emp_info_remarks
		);

		// CONVERT TO JSON ENCODE
		$json_data = json_encode($entry_data);

		$data = array(
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Termination Updated: " . ' ID: ' . $id,
			'datas'		=> "Previous Data: " . $json_data,
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> 'HRIS: 201',
			'date'		=> $datetime
		);

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 
		$activity_log->insert('blaine_logs', $data);

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

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 

		$entry_data = "employee_termination [entry_id:" . $employee_number . "]";

		$activity_data = array(
			'username'   => $this->session->userdata('username'),
			'pcname'     => $_SERVER['REMOTE_ADDR'],
			'entry_data' => $entry_data,
			'entry_date' => $datetime
		);
		$activity_log->insert('hris_logs', $activity_data);

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
		$employer = $this->input->post('employer');
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
				'employer'        => $employer,
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

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 

		$entry_data = "add_info [entry_id:" . $employee_number . "]";

		$activity_data = array(
			'username'   => $this->session->userdata('username'),
			'pcname'     => $_SERVER['REMOTE_ADDR'],
			'entry_data' => $entry_data,
			'entry_date' => $date
		);
		$activity_log->insert('hris_logs', $activity_data);

		$data = array(
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Employee Info Added",
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> 'HRIS: 201',
			'date'		=> $date
		);

		// CALL ACTIVITY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);

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
		$this->db->join('employee_status', 'transfer_logs.employee_status = employee_status.id','left');
		$this->db->join('company', 'transfer_logs.company = company.id','left');
		$this->db->join('rank', 'transfer_logs.rank = rank.id','left');
		$this->db->join('department', 'transfer_logs.department = department.id','left');
		$this->db->join('work_group', 'transfer_logs.work_group = work_group.id','left');
		
		$query = $this->db->get();

		return $query->result();
	} 

	public function delete_all_information($id,$employee_number)
	{
		$this->db->trans_start();

		// GET OLD DATE BEFORE UPDATE
		$this->db->select('*');
		$this->db->where('id', $id);
		$datas 								= $this->db->get('employees');
		$emp_id 							= $datas->row()->id;
		$emp_picture 						= $datas->row()->picture;
		$emp_empno 							= $datas->row()->employee_number;
		$emp_first_name 					= $datas->row()->first_name;
		$emp_middle_name					= $datas->row()->middle_name;
		$emp_last_name						= $datas->row()->last_name;
		$emp_nick_name						= $datas->row()->nick_name;
		$emp_birthday						= $datas->row()->birthday;
		$emp_age							= $datas->row()->age;
		$emp_gender							= $datas->row()->gender;
		$emp_marital_status					= $datas->row()->marital_status;
		$emp_contact_number					= $datas->row()->contact_number;
		$emp_email_address					= $datas->row()->email_address;
		$emp_emergency_contact_name			= $datas->row()->emergency_contact_name;
		$emp_emergency_contact_number		= $datas->row()->emergency_contact_number;
		$emp_emergency_contact_relationship	= $datas->row()->emergency_contact_relationship;
		$emp_address						= $datas->row()->address;
		$emp_sss_number						= $datas->row()->sss_number;
		$emp_tin_number						= $datas->row()->tin_number;
		$emp_pagibig_number					= $datas->row()->pagibig_number;
		$emp_philhealth_number				= $datas->row()->philhealth_number;

		$entry_data = array(
			'id'								=> $emp_id,
			'picture'							=> $emp_picture,
			'employee_number'					=> $emp_empno,
			'first_name'						=> $emp_first_name,
			'middle_name'						=> $emp_middle_name,
			'last_name'							=> $emp_last_name,
			'nick_name'							=> $emp_nick_name,
			'birthday'							=> $emp_birthday,
			'age'								=> $emp_age,
			'gender'							=> $emp_gender,
			'marital_status'					=> $emp_marital_status,
			'contact_number'					=> $emp_contact_number,
			'email_address'						=> $emp_email_address,
			'emergency_contact_name'			=> $emp_emergency_contact_name,
			'emergency_contact_number'			=> $emp_emergency_contact_number,
			'emergency_contact_relationship'	=> $emp_emergency_contact_relationship,
			'address'							=> $emp_address,
			'sss_number'						=> $emp_sss_number,
			'tin_number'						=> $emp_tin_number,
			'pagibig_number'					=> $emp_pagibig_number,
			'philhealth_number'					=> $emp_philhealth_number
		);

		// CONVERT TO JSON ENCODE
		$json_data = json_encode($entry_data);

		$data = array(
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Employee Deleted: " . ' ID: ' . $id,
			'datas'		=> $json_data,
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> 'HRIS: 201',
			'date'		=> date('Y-m-d H:i:s')
		);

		// CALL ACTIVITY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);

		
		$this->db->where('id', $id);
		$this->db->where('employee_number', $employee_number);		$this->db->delete('employees');


		//$this->db->where('id', $parent_id);
		$this->db->where('employee_number', $employee_number);
		$this->db->delete('parents_info');

		//$this->db->where('id', $spouse_id);
		$this->db->where('employee_number', $employee_number);
		$this->db->delete('spouse_info');

		//$this->db->where('id', $employment_id);
		$this->db->where('employee_number', $employee_number);
		$this->db->delete('employment_info');

		$this->db->where('employee_number', $employee_number);
		$this->db->delete('children_info');

		$this->db->where('employee_number', $employee_number);
		$this->db->delete('academe_info');

		$this->db->where('blaine_timekeeping.employee_biometric.employee_number', $employee_number);
		$this->db->delete('blaine_timekeeping.employee_biometric');

		$this->db->where('blaine_timekeeping.schedules.employee_number', $employee_number);
		$this->db->delete('blaine_timekeeping.schedules');

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function delete_children_information($id,$employee_number)
	{

		$this->db->trans_start();
		
		// GET OLD DATA BEFORE UPDATE
		$this->db->select('*');
		$this->db->where('id', $id);
		$datas = $this->db->get('children_info');
		$child_id				= $datas->row()->id;
		$child_employee_number  = $datas->row()->employee_number;
		$child_name				= $datas->row()->name;
		$child_birthday			= $datas->row()->birthday;
		$child_age 				= $datas->row()->age;
		$child_gender 			= $datas->row()->gender;

		$entry_data = array(
			'id'				=> $child_id,
			'employee_number'	=> $child_employee_number,
			'name'				=> $child_name,
			'birthday'			=> $child_birthday,
			'age'				=> $child_age,
			'gender'			=> $child_gender
		);

		$json_data = json_encode($entry_data);

		$data = array(
			'username' => $this->session->userdata('username'),
			//'activity' => "Announcement deleted:" . ' id:' . $announcement_id  . ' title:'. $announcement_title,
			'activity' => "Entry Children Deleted: " . ' ID: ' . $id,
			'datas'    => $json_data,
			'pc_ip'    => $_SERVER['REMOTE_ADDR'],
			'type'     => 'HRIS: 201',
			'date'     => date('Y-m-d H:i:s')
		);

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 
		$activity_log->insert('blaine_logs', $data);

		$this->db->where('id', $id);
		$this->db->where('employee_number', $employee_number);
		$this->db->delete('children_info');

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function delete_academe_information($id,$employee_number)
	{

		$this->db->trans_start();

		// GET OLD DATA BEFORE UPDATE
		$this->db->select('*');
		$this->db->where('id', $id);
		$datas = $this->db->get('academe_info');
		$acad_id					= $datas->row()->id;
		$acad_employee_number		= $datas->row()->employee_number;
		$acad_school				= $datas->row()->school;
		$acad_year_graduated		= $datas->row()->year_graduated;
		$acad_course				= $datas->row()->course;
		$acad_license				= $datas->row()->license;

		$entry_data = array(
			'id'					=> $acad_id,
			'employee_number'		=> $acad_employee_number,
			'school'				=> $acad_school,
			'year_graduated'		=> $acad_year_graduated,
			'course'				=> $acad_course,
			'license'				=> $acad_license
		);

		// CONVERT TO JSO ENCODE
		$json_data = json_encode($entry_data);

		$data = array(
			'username'		=> $this->session->userdata('username'),
			'activity'		=> "Entry Academe Deleted: " . ' ID: ' . $id,
			'datas'			=> $json_data,
			'pc_ip'			=> $_SERVER['REMOTE_ADDR'],
			'type'			=> "HRIS: 201",
			'date'			=> date('Y-m-d H:i:s')
		);

		// CALL ACTIVITY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);

		
		$this->db->where('id', $id);
		$this->db->where('employee_number', $employee_number);
		$this->db->delete('academe_info');

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function attachment($employee_number)
	{
		$this->db->trans_start();

		$data = array(
			'username'	=> $this->session->userdata('username'),
			'activity'	=> "Entry Attachment Added",
			'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
			'type'		=> 'HRIS: 201',
			'date'		=> date('Y-m-d H:i:s')
		);

		// CALL ACTIVITY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE);
		$activity_log->insert('blaine_logs', $data);

		$attachment = $this->input->post('attachment');
		$name1 = $this->input->post('attachment1');
		$name2 = $this->input->post('attachment2');

		$resume = $_FILES['resume']['name'];
		$attach1 = str_replace(' ', '_', $resume);

		$attachment1 = $_FILES['data1']['name'];
		$attach2 = str_replace(' ', '_', $attachment1);

		$attachment2 = $_FILES['data2']['name'];
		$attach3 = str_replace(' ', '_', $attachment2);

		$date = date('Y-m-d H:i:s');

		$resume_data = array(
			'employee_number' => $employee_number,
			'name'            => $attachment,
			'file'            => $attach1,
			'created_date'    => $date,
			'created_by'      => $this->session->userdata('username')
		);

		$this->db->insert('attachment', $resume_data);

		/* print_r('<pre>');
		print_r($resume_data);
		print_r('</pre>'); */

		if($name1 != NULL)
		{
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
		}
		
		if($name2 != NULL)
		{
			$data2= array(
				'employee_number' => $employee_number,
				'name'            => $name2,
				'file'            => $attach2,
				'created_date'    => $date,
				'created_by'      => $this->session->userdata('username')
			);
	
			$this->db->insert('attachment', $data2);
			/* print_r('<pre>');
			print_r($data2);
			print_r('</pre>'); */
		}
		
		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 

		$entry_data = "attachment [entry_id:" . $employee_number . "]";

		$activity_data = array(
			'username'   => $this->session->userdata('username'),
			'pcname'     => $_SERVER['REMOTE_ADDR'],
			'entry_data' => $entry_data,
			'entry_date' => $date
		);
		$activity_log->insert('hris_logs', $activity_data);

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function get_reports()
	{
		$this->db->select("
			employees.id as id,
            employees.employee_number as emp_no,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
			employees.birthday as birthday,
			employees.age as age,
			employees.gender as gender,
			employees.marital_status as marital_status,
			employees.contact_number as contact_number,
			employees.email_address as email_address,
			employees.emergency_contact_name as emergency_contact_name,
			employees.emergency_contact_number as emergency_contact_number,
			employees.emergency_contact_relationship as emergency_contact_relationship,
			employees.address as address,
			employees.sss_number as sss_number,
			employees.tin_number as tin_number,
			employees.pagibig_number as pagibig_number,
			employees.philhealth_number as philhealth_number,

            employment_info.date_hired as date_hired,
			employment_info.position as position,
            employee_status.name as employee_status,
            employment_info.position as position,
			employment_info.immediate_superior as superior,
			rank.name as rank,
			work_group.name as work_group,
            company.code as company,
            department.name as department,

			parents_info.father_name as father_name,
			parents_info.mother_name as mother_name,

			spouse_info.name as sps_name,
			spouse_info.birthday as sps_bday,
			spouse_info.age as sps_age,
			spouse_info.occupation as sps_occupation,
			spouse_info.employer as sps_employer,

			academe_info.school as school,
			academe_info.year_graduated as year_graduated,
			academe_info.course as course,
			academe_info.license as license

		");
		$this->db->from('employees');
        $this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number', 'left');
        $this->db->join('employee_status', 'employment_info.employee_status = employee_status.id', 'left');
		$this->db->join('rank', 'employment_info.rank = rank.id', 'left');
		$this->db->join('work_group', 'employment_info.work_group = work_group.id', 'left');
        $this->db->join('company', 'employment_info.company = company.id', 'left');
        $this->db->join('department', 'employment_info.department = department.id', 'left');
		$this->db->join('parents_info', 'parents_info.employee_number = employees.employee_number', 'left');
		$this->db->join('spouse_info', 'spouse_info.employee_number = employees.employee_number', 'left');
		$this->db->join('academe_info', 'academe_info.employee_number = employees.employee_number', 'left');
        $this->db->order_by('employees.last_name', 'ASC');
        $this->db->where('employees.is_active', 1);
		
		$query = $this->db->get();

		return $query->result();
	}
}
