<?php
class Attendance_model extends CI_Model
{
	public function get_employees_attendance()
	{
		$this->db->select("
			CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname,
			employees.employee_number as employee_number,
			attendance_in.date as date, 
			attendance_in.time as time_in,
			attendance_out.time as time_out,
			attendance_in.id as in_id,   
			attendance_out.id as out_id, 	
			temp_date.date as temp_date,
			attendance_in.generate as in_generate,
			attendance_out.generate as out_generate,
			employee_biometric.biometric_number as biometric_id,
			attendance_in.generated_by as in_generated,
			attendance_out.generated_by as out_generated,
			ob.date_ob as date_ob,
			ob.employee_number as ob_employee_number,
			ob.process_by as ob_process_by,
			ob.created_by as ob_created_by,
			ob.type as ob_type,
			slvl.created_by as leave_created_by,
			slvl.leave_date as date_leave,
			slvl.employee_number as leave_employee_number,
			slvl.process_by as leave_process_by,
			slvl.type_name as type_name,
			slvl.type as leave_type,
			slvl.leave_day as leave_day,
			department.name as department_name,
			department.id as department_id,
			company.id as company_id,
			company.code as company_name
		");
		$this->db->from('blaine_timekeeping.temp_date');
		$this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.is_active = blaine_timekeeping.temp_date.batch');
		$this->db->join('blaine_timekeeping.attendance_in', 'blaine_timekeeping.attendance_in.employee_number = blaine_intranet.employees.employee_number AND blaine_timekeeping.temp_date.date = blaine_timekeeping.attendance_in.date','left');
		//$this->db->join('blaine_timekeeping.attendance_out', 'blaine_timekeeping.attendance_in.employee_number = blaine_intranet.employees.employee_number AND blaine_timekeeping.temp_date.date = blaine_timekeeping.attendance_out.date','left');
		$this->db->join('blaine_timekeeping.attendance_out', 'blaine_timekeeping.attendance_in.biometric_id = blaine_timekeeping.attendance_out.biometric_id AND blaine_timekeeping.attendance_in.date = blaine_timekeeping.attendance_out.date AND blaine_timekeeping.temp_date.date = blaine_timekeeping.attendance_out.date','left');
        $this->db->join('blaine_timekeeping.employee_biometric', 'blaine_timekeeping.employee_biometric.employee_number = blaine_intranet.employees.employee_number', 'left');
		$this->db->join('blaine_timekeeping.ob','blaine_timekeeping.ob.date_ob = blaine_timekeeping.temp_date.date AND blaine_timekeeping.ob.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('blaine_timekeeping.slvl','blaine_timekeeping.slvl.leave_date = blaine_timekeeping.temp_date.date AND blaine_timekeeping.slvl.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number');
		$this->db->join('department', 'employment_info.department = department.id');
		$this->db->join('company', 'employment_info.company = company.id');

		$this->db->order_by('employees.last_name','ASC');
		$this->db->order_by('attendance_in.date','ASC');
		$query = $this->db->get();
		

	return $query->result();	
	}

	public function get_raw_datas($start_date,$end_date)
	{
		$this->db->select("
			raw_data.biometric_id as biometric_id, 
			raw_data.date as date, raw_data.time as time, 
			raw_data.status as status , 
			CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname, 
			employee_biometric.employee_number as employee_number
		");
		$this->db->from('blaine_timekeeping.raw_data');
		$this->db->join('blaine_timekeeping.employee_biometric','blaine_timekeeping.raw_data.biometric_id = blaine_timekeeping.employee_biometric.biometric_number','left');
		$this->db->join('blaine_intranet.employees','blaine_timekeeping.employee_biometric.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->where('raw_data.date >=', $start_date);
		$this->db->where('raw_data.date <=', $end_date);
		$query = $this->db->get();
		/*$query = $this->db->query("
			SELECT raw_data.biometric_id as biometric_id, raw_data.date as date, raw_data.time as time, raw_data.status as status , CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname, employee_biometric.employee_number as employee_number
			FROM blaine_timekeeping.raw_data
				LEFT JOIN blaine_timekeeping.employee_biometric
				ON blaine_timekeeping.raw_data.biometric_id = blaine_timekeeping.employee_biometric.biometric_number
				LEFT JOIN blaine_intranet.employees
				ON blaine_timekeeping.employee_biometric.employee_number = blaine_intranet.employees.employee_number
				WHERE raw_data.date >= $start_date AND raw_data.date <= $end_date
				")->result();*/

		return $query->result();
	} 

	public function generate_dates()
	{
		$this->db->trans_start();

		// DELETE PREVIOUS TEMPORARY DATE
		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
		$blaine_timekeeping->where('id !=', NULL);
		$blaine_timekeeping->delete('temp_date');

		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$datediff = (strtotime($end_date) - strtotime($start_date));
		$num_dates = floor($datediff / (60 * 60 * 24));
		$num_dates = $num_dates + 1;

		$data = array(
			'total_days'  => $num_dates
		);

		$cur_date = $start_date;

		for($k = 1; $k <= $num_dates; $k++)
		{	
			$data = array( 
				'date'  => $cur_date,
				'batch' => 1
			);
			
			$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
			$blaine_timekeeping->insert('temp_date', $data);
			/*print_r('<pre>');
			print_r($data);
			print_r('</pre>');*/

			$conv_date = strtotime($start_date);
			$cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));
		}	

		$trans = $this->db->trans_complete();

		return $trans;
	}

	public function add_manual_attendance()
	{
		$this->db->trans_start(); 

		$employee_number = $this->input->post('employee_number');
		$fullname = $this->input->post('fullname');
		$biometric_id = $this->input->post('biometric_id');
		$date = $this->input->post('date');
		$time_in = $this->input->post('time_in');
		$time_out = $this->input->post('time_out');
		$process =  $this->input->post('process');
		$no_time_out = $this->input->post('no_time_out');

		$attendance = $this->input->post('attendance');
		$other = $this->input->post('other');
		$department = $this->input->post('department_id');
		$company = $this->input->post('company_id');

		if($attendance == 1)
		{
			if($process != 1)
			{
				$data_in = array(
					'biometric_id'    => $biometric_id,
					'employee_number' => $employee_number,
					'date'            => $date,
					'time'            => $time_in,
					'status'          => 'IN',
					'generate'        => 'MANUAL',
					'generated_by'    => $this->session->userdata('username'),
					'generated_date'  => date('Y-m-d H:i:s')
				);

				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->insert('attendance_in', $data_in);
				/*print_r('<pre>');
				print_r($data_in);
				print_r('</pre>');*/	

				$this->db->query("
					DELETE tbl1 FROM blaine_timekeeping.attendance_in tbl1 INNER JOIN
					blaine_timekeeping.attendance_in tbl2 WHERE tbl1.id > tbl2.id AND tbl1.biometric_id = tbl2.biometric_id AND tbl1.date = tbl2.date
				");
			}
			
			if($no_time_out != 1)
			{
				$data_out = array(
					'biometric_id'    => $biometric_id,
					'employee_number' => $employee_number,
					'date'            => $date,
					'time'            => $time_out,
					'status'          => 'OUT',
					'generate'        => 'MANUAL',
					'generated_by'    => $this->session->userdata('username'),
					'generated_date'  => date('Y-m-d H:i:s')
				);
		
				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->insert('attendance_out', $data_out);
				/*print_r('<pre>');
				print_r($data_out);
				print_r('</pre>');*/	
				
				$this->db->query("
					DELETE tbl1 FROM blaine_timekeeping.attendance_out tbl1 INNER JOIN
					blaine_timekeeping.attendance_out tbl2 WHERE tbl1.id > tbl2.id AND tbl1.biometric_id = tbl2.biometric_id AND tbl1.date = tbl2.date
				");
			}
		}	
		else
		{
			if($other == 'SL')
			{
				$data_sl = array(
					'employee_number' => $employee_number,
                    'company'         => $company,
                    'department'      => $department,
					'leave_date'      => $date,
                    'type'            => 'SL',
                    'type_name'       => 'SL',
					'created_by'    => $this->session->userdata('username'),
					'created_date'  => date('Y-m-d H:i:s')
				);

				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->insert('slvl', $data_sl);
			}
			elseif($other == 'VL') 
			{
				$data_vl = array(
					'employee_number' => $employee_number,
                    'company'         => $company,
                    'department'      => $department,
					'leave_date'      => $date,
                    'type'            => 'VL',
                    'type_name'       => 'VL',
					'created_by'    => $this->session->userdata('username'),
					'created_date'  => date('Y-m-d H:i:s')
				);

				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->insert('slvl', $data_vl);
			}
			elseif($other == 'ML') 
			{
				$data_vl = array(
					'employee_number' => $employee_number,
                    'company'         => $company,
                    'department'      => $department,
					'leave_date'      => $date,
                    'type'            => 'ML',
                    'type_name'       => 'ML',
					'created_by'    => $this->session->userdata('username'),
					'created_date'  => date('Y-m-d H:i:s')
				);

				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->insert('slvl', $data_vl);
			}
			elseif($other == 'NO WORK SCHEDULE') 
			{
				$data_nws = array(
					'employee_number' => $employee_number,
                    'company'         => $company,
                    'department'      => $department,
					'leave_date'      => $date,
                    'type'            => 'NO WORK SCHEDULE',
                    'type_name'       => 'NO WORK SCHEDULE',
					'created_by'    => $this->session->userdata('username'),
					'created_date'  => date('Y-m-d H:i:s')
				);

				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->insert('slvl', $data_nws);
			}
			elseif($other == 'FIELD WORK') 
			{
				$data_fw = array(
					'employee_number' => $employee_number,
					'company'         => $company,
                    'department'      => $department,
					'date_ob'         => $date,
                    'type'            => 'FIELD WORK',
					'created_by'      => $this->session->userdata('username'),
					'created_date'    => date('Y-m-d H:i:s')
				);

				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->insert('ob', $data_fw);
			}
			elseif($other == 'WORK FROM HOME') 
			{
				$data_wfh = array(
					'employee_number' => $employee_number,
					'company'         => $company,
                    'department'      => $department,
					'date_ob'         => $date,
                    'type'            => 'WORK FROM HOME',
					'created_by'      => $this->session->userdata('username'),
					'created_date'    => date('Y-m-d H:i:s')
				);

				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->insert('ob', $data_wfh);
			}
			
		}

		$trans = $this->db->trans_complete();
		return $trans;
	}

	
}

/*$query = $this->db->query("
			SELECT attendance_in.date as date, attendance_in.id as in_id, attendance_out.id as out_id, attendance_in.time as time_in, attendance_out.time as time_out , CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname
			FROM blaine_timekeeping.attendance_in
			LEFT JOIN blaine_timekeeping.attendance_out
			ON blaine_timekeeping.attendance_in.biometric_id = blaine_timekeeping.attendance_out.biometric_id AND blaine_timekeeping.attendance_in.date = blaine_timekeeping.attendance_out.date 
			LEFT JOIN blaine_intranet.employees
			ON blaine_timekeeping.attendance_in.employee_number = blaine_intranet.employees.employee_number
			ORDER BY DATE(attendance_in.date) ASC
		")->result();*/
		/*$query = $this->db->query("
			SELECT attendance_in.date as date, attendance_in.id as in_id, attendance_out.id as out_id, attendance_in.time as time_in, attendance_out.time as time_out , CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname
			FROM blaine_timekeeping.attendance_in
				LEFT JOIN blaine_timekeeping.attendance_out
				ON blaine_timekeeping.attendance_in.biometric_id = blaine_timekeeping.attendance_out.biometric_id AND blaine_timekeeping.attendance_in.date = blaine_timekeeping.attendance_out.date 
				LEFT JOIN blaine_intranet.employees
				ON blaine_timekeeping.attendance_in.employee_number = blaine_intranet.employees.employee_number
				WHERE attendance_out.id IN (
					SELECT MAX(attendance_out.id)
					FROM blaine_timekeeping.attendance_out
					WHERE status='OUT'
					GROUP BY attendance_out.biometric_id, DATE(date)
				)
				OR attendance_in.id IN (
					SELECT MIN(attendance_in.id)
					FROM blaine_timekeeping.attendance_in
					WHERE status='IN'
					GROUP BY attendance_in.biometric_id, DATE(date)
				) GROUP BY DATE(attendance_in.date) ASC, attendance_in.biometric_id")->result();*/