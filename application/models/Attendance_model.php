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
			company.code as company_name,
			rank.name as rank_name,
			ob.purpose as ob_purpose,
			ob.remarks as ob_remarks,
			slvl.reason as leave_reason

		");
		$this->db->from('blaine_timekeeping.temp_date');
		$this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.is_active = blaine_timekeeping.temp_date.batch');
		$this->db->join('blaine_timekeeping.employee_biometric', 'blaine_timekeeping.employee_biometric.employee_number = blaine_intranet.employees.employee_number', 'left');
		$this->db->join('blaine_timekeeping.attendance_in', 'blaine_timekeeping.attendance_in.biometric_id = blaine_timekeeping.employee_biometric.biometric_number AND blaine_timekeeping.temp_date.date = blaine_timekeeping.attendance_in.date','left');
		$this->db->join('blaine_timekeeping.attendance_out', 'blaine_timekeeping.attendance_out.biometric_id = blaine_timekeeping.employee_biometric.biometric_number AND blaine_timekeeping.temp_date.date = blaine_timekeeping.attendance_out.date','left');
		$this->db->join('blaine_timekeeping.ob','blaine_timekeeping.ob.date_ob = blaine_timekeeping.temp_date.date AND blaine_timekeeping.ob.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('blaine_timekeeping.slvl','blaine_timekeeping.slvl.leave_date = blaine_timekeeping.temp_date.date AND blaine_timekeeping.slvl.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number');
		$this->db->join('department', 'employment_info.department = department.id');
		$this->db->join('company', 'employment_info.company = company.id');
		$this->db->join('rank', 'employment_info.rank = rank.id');

		$this->db->order_by('employees.last_name','ASC');
		$this->db->order_by('attendance_in.date','ASC');
		$this->db->where('blaine_timekeeping.temp_date.created_by', $this->session->userdata('username'));
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
		$blaine_timekeeping->where('created_by', $this->session->userdata('username'));
		$blaine_timekeeping->delete('temp_date');

		$weekdays = $this->input->post('working_days');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$datediff = (strtotime($end_date) - strtotime($start_date));
		$num_dates = floor($datediff / (60 * 60 * 24));
		$num_dates = $num_dates + 1;

		$data = array(
			'total_days'  => $num_dates
		);

		$cur_date = $start_date;

		if($weekdays != 1)
		{
			for($k = 1; $k <= $num_dates; $k++)
			{	
				$data = array( 
					'date'       => $cur_date,
					'batch'      => 1,
					'created_by' => $this->session->userdata('username')
				);
				
				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->insert('temp_date', $data);
				/*print_r('<pre>');
				print_r($data);
				print_r('</pre>');*/

				$conv_date = strtotime($start_date);
				$cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));
			}	
		}
		else
		{
			for($k = 1; $k <= $num_dates; $k++)
			{	
				$w_date = date('w', strtotime($cur_date));
				if($w_date != 6 && $w_date != 0)
				{
					$data = array( 
						'date'       => $cur_date,
						'batch'      => 1,
						'created_by' => $this->session->userdata('username')
					);
					
					$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
					$blaine_timekeeping->insert('temp_date', $data);
					/*print_r('<pre>');
					print_r($data);
					print_r('</pre>');*/
					
				}

				$conv_date = strtotime($start_date);
				$cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));
			}	
		}
		

		$trans = $this->db->trans_complete();

		return $trans;
	}

	public function individual_generate_dates()
	{
		$this->db->trans_start();

		// DELETE PREVIOUS TEMPORARY DATE
		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
		$blaine_timekeeping->where('created_by', $this->session->userdata('username'));
		$blaine_timekeeping->delete('individual_temp_date');

		$employee_number = $this->input->post('employee');
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
				'employee_number' => $employee_number,
				'date'            => $cur_date,
				'created_by'      => $this->session->userdata('username')
			);
			
			$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
			$blaine_timekeeping->insert('individual_temp_date', $data);
			/*print_r('<pre>');
			print_r($data);
			print_r('</pre>');*/

			$conv_date = strtotime($start_date);
			$cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));
		}	

		/*$data_temp = array( 
			'employee_number' => $employee_number,
			'created_by'      => $this->session->userdata('username')
		);

		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
		$blaine_timekeeping->update('overtime_temp_date', $data_temp);*/

		$trans = $this->db->trans_complete();

		return $trans;
	}

	public function generate_cutoff_dates()
	{
		$this->db->trans_start();

		// DELETE PREVIOUS TEMPORARY DATE
		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
		$blaine_timekeeping->where('created_by !=', NULL);
		$blaine_timekeeping->delete('cut_off_date');

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
				'date'            => $cur_date,
				'created_by'      => $this->session->userdata('username')
			);
			
			$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
			$blaine_timekeeping->insert('cut_off_date', $data);
			/*print_r('<pre>');
			print_r($data);
			print_r('</pre>');*/

			$conv_date = strtotime($start_date);
			$cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));
		}	

		$trans = $this->db->trans_complete();

		return $trans;
	}

	public function get_first_cutoff_date()
	{
		$this->db->select('cut_off_date.date as first_date');
		$this->db->from('blaine_timekeeping.cut_off_date');
		$this->db->limit('1');
		$query = $this->db->get();

		return $query->row();
	}
	
	public function get_last_cutoff_date()
	{
		$this->db->select('cut_off_date.date as last_date');
		$this->db->from('blaine_timekeeping.cut_off_date');
		$this->db->order_by('id', 'DESC');
		$this->db->limit('1');
		$query = $this->db->get();

		return $query->row();
	}

	public function get_first_daily_attendance_date()
	{
		$this->db->select('individual_temp_date.date as first_date_daily_attendance');
		$this->db->from('blaine_timekeeping.individual_temp_date');
		$this->db->where('individual_temp_date.created_by', $this->session->userdata('username'));
		$this->db->limit('1');
		$query = $this->db->get();

		return $query->row();
	}

	public function get_last_daily_attendance_date()
	{
		$this->db->select('individual_temp_date.date as last_date_daily_attendance');
		$this->db->from('blaine_timekeeping.individual_temp_date');
		$this->db->where('individual_temp_date.created_by', $this->session->userdata('username'));
		$this->db->order_by('id', 'DESC');
		$this->db->limit('1');
		$query = $this->db->get();

		return $query->row();
	}

	public function myattendance_generate_dates()
	{
		$this->db->trans_start();

		// DELETE PREVIOUS TEMPORARY DATE
		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
		$blaine_timekeeping->where('created_by', $this->session->userdata('username'));
		$blaine_timekeeping->delete('myattendance_temp_date');

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
				'employee_number' => $this->session->userdata('employee_number'),
				'date'            => $cur_date,
				'created_by'      => $this->session->userdata('username')
			);
			
			$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
			$blaine_timekeeping->insert('myattendance_temp_date', $data);
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

				/*$this->db->query("
					DELETE tbl1 FROM blaine_timekeeping.attendance_in tbl1 INNER JOIN
					blaine_timekeeping.attendance_in tbl2 WHERE tbl1.id > tbl2.id AND tbl1.biometric_id = tbl2.biometric_id AND tbl1.date = tbl2.date
				");*/

				$data = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Added: Employee Number: " . $employee_number,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> "TIMEKEEPING: MANUAL ATTENDANCE - IN",
					'date'		=> date('Y-m-d H:i:s')
				);
		
				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data);
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
				
				/*$this->db->query("
					DELETE tbl1 FROM blaine_timekeeping.attendance_out tbl1 INNER JOIN
					blaine_timekeeping.attendance_out tbl2 WHERE tbl1.id > tbl2.id AND tbl1.biometric_id = tbl2.biometric_id AND tbl1.date = tbl2.date
				");*/

				$data = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Added: Employee Number: " . $employee_number,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> "TIMEKEEPING: MANUAL ATTENDANCE - OUT",
					'date'		=> date('Y-m-d H:i:s')
				);
		
				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data);
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

				// ACTIVITY LOG
				$data_logs = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Added: Employee Number: " .$employee_number,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> "TIMEKEEPING: MANUAL ATTENDANCE - SL",
					'date'		=> date('Y-m-d H:i:s')
				);

				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data_logs);
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

				$data_logs = array(
					'username'		=> $this->session->userdata('username'),
					'activity'		=> "Entry Added: Employee Number: " . $employee_number,
					'pc_ip'			=> $_SERVER['REMOTE_ADDR'],
					'type'			=> "TIMEKEEPING: MANUAL ATTENDANCE - VL",
					'date'			=> date('Y-m-d H:i:s')
				);

				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data_logs);
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

				// ACTIVITY LOGS
				$data_logs = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Added: Employee Number: " . $employee_number,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> "TIMEKEEPING: MANUAL ATTENDANCE - ML",
					'date'		=> date('Y-m-d H:i:s')
				);

				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data_logs);
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

				// ACTIVITY LOG
				$data_logs = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Added: Employee Number: " . $employee_number,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> "TIMEKEEPING: MANUAL ATTENDANCE - NO WORK SCHEDULE",
					'date'		=> date('Y-m-d H:i:s')
				);

				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data_logs);
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

				// ACTIVITY LOG
				$data_logs = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Added: Employee Number: " . $employee_number,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> "TIMEKEEPING: MANUAL ATTENDANCE - FIELD WORK",
					'date'		=> date('Y-m-d H:i:s')
				);

				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data_logs);
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

				// ACTIVITY LOG
				$data_logs = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Added: Employee Number: " . $employee_number,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> "TIMEKEEPING: MANUAL ATTENDANCE - WORK FROM HOME",
					'date'		=> date('Y-m-d H:i:s')
				);

				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data_logs);
			}
			
		}

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function add_individual_manual_attendance()
	{
		$this->db->trans_start(); 

		$employee_number = $this->input->post('employee_number');
		$biometric_id = $this->input->post('biometric_id');
		$date = $this->input->post('date');

		// ADD
		$time_in = $this->input->post('time_in');
		$time_out = $this->input->post('time_out');
		$process =  $this->input->post('process');
		$no_time_out = $this->input->post('no_time_out');
		$attendance = $this->input->post('attendance');

		// EDIT
		$edit_no_time_in = $this->input->post('edit_no_time_in');
		$edit_time_in = $this->input->post('edit_time_in');
		$edit_no_time_out = $this->input->post('edit_no_time_out');
		$edit_time_out = $this->input->post('edit_time_out');
		$edit_remarks = $this->input->post('edit_remarks');

		// DELETE 
		$delete_no_time_in = $this->input->post('delete_no_time_in');
		$delete_time_in = $this->input->post('delete_time_in');
		$delete_no_time_out = $this->input->post('delete_no_time_out');
		$delete_time_out = $this->input->post('delete_time_out');
		$delete_remarks = $this->input->post('delete_remarks');

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

				/*$this->db->query("
					DELETE tbl1 FROM blaine_timekeeping.attendance_in tbl1 INNER JOIN
					blaine_timekeeping.attendance_in tbl2 WHERE tbl1.id > tbl2.id AND tbl1.biometric_id = tbl2.biometric_id AND tbl1.date = tbl2.date
				");*/

				$data_logs = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Added: Employee Number: " . $employee_number,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> "TIMEKEEPING: MANUAL ATTENDANCE - IN",
					'date'		=> date('Y-m-d H:i:s')
				);
		
				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data_logs);
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
				
				/*$this->db->query("
					DELETE tbl1 FROM blaine_timekeeping.attendance_out tbl1 INNER JOIN
					blaine_timekeeping.attendance_out tbl2 WHERE tbl1.id > tbl2.id AND tbl1.biometric_id = tbl2.biometric_id AND tbl1.date = tbl2.date
				");*/

				$data = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Added: Employee Number: " . $employee_number,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> "TIMEKEEPING: MANUAL ATTENDANCE - OUT",
					'date'		=> date('Y-m-d H:i:s')
				);
		
				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data);
			}
		}
		elseif($attendance == 2)
		{
			if($edit_no_time_in == 1)
			{
				// GET RECENT DATA
				$this->db->select('*');
				$this->db->where('blaine_timekeeping.attendance_in.employee_number', $employee_number);
				$this->db->where('blaine_timekeeping.attendance_in.date', $date);
				$datas = $this->db->get('blaine_timekeeping.attendance_in');

				$emp_time_in = $datas->row()->time;
				$emp_generate_in = $datas->row()->generate;

				$entry_data = array(
					'employee_number' => $employee_number,
					'date'            => $date,
					'time'            => $emp_time_in,
					'status'          => 'IN',
					'generate'        => $emp_generate_in,
					'remarks'         => $edit_remarks
				);

				$json_data = json_encode($entry_data);

				$data = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Updated: " . ' Employee Number: ' . $employee_number ,
					'datas'		=> "Previous Data: " . $json_data,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> 'TIMEKEEPING: MANUAL ATTENDANCE - IN',
					'date'		=> date('Y-m-d H:i:s')
				);

				// CALL ACTIVITY LOGS DATABASE
				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data);


				$update_data = array(
					'time'           => $edit_time_in,
					'generate'       => 'MANUAL',
					'generated_by'   => $this->session->userdata('username'),
					'generated_date' => date('Y-m-d H:i:s')
				);

				// UPDATE TIME IN 
				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->where('attendance_in.biometric_id', $biometric_id);
				$blaine_timekeeping->where('attendance_in.date', $date);
				$blaine_timekeeping->update('attendance_in', $update_data);
				
			}

			if($edit_no_time_out == 1)
			{

				// GET RECENT DATA
				$this->db->select('*');
				$this->db->where('blaine_timekeeping.attendance_out.employee_number', $employee_number);
				$this->db->where('blaine_timekeeping.attendance_out.date', $date);
				$datas = $this->db->get('blaine_timekeeping.attendance_out');

				$emp_time_out = $datas->row()->time;
				$emp_generate_out = $datas->row()->generate;

				$entry_data = array(
					'employee_number' => $employee_number,
					'date'            => $date,
					'time'            => $emp_time_out,
					'status'          => 'OUT',
					'generate'        => $emp_generate_out,
					'remarks'         => $edit_remarks
				);

				$json_data = json_encode($entry_data);

				$data = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Updated: " . ' Employee Number: ' . $employee_number ,
					'datas'		=> "Previous Data: " . $json_data,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> 'TIMEKEEPING: MANUAL ATTENDANCE - OUT',
					'date'		=> date('Y-m-d H:i:s')
				);

				// CALL ACTIVITY LOGS DATABASE
				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data); 


				$update_data = array(
					'time'           => $edit_time_out,
					'generate'       => 'MANUAL',
					'generated_by'   => $this->session->userdata('username'),
					'generated_date' => date('Y-m-d H:i:s')
				);

				// UPDATE TIME IN 
				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->where('attendance_out.biometric_id', $biometric_id);
				$blaine_timekeeping->where('attendance_out.date', $date);
				$blaine_timekeeping->update('attendance_out', $update_data);
			}
		}
		elseif($attendance == 3)
		{
			if($delete_no_time_in == 1)
			{
				$entry_data = array(
					'biometric_id'    => $biometric_id,
					'employee_number' => $employee_number,
					'date'            => $date,
					'time'            => $delete_time_in,
					'status'          => 'IN',
					'remarks'         => $delete_remarks
				);

				$json_data = json_encode($entry_data);

				$data = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Deleted: " . ' Employee Number: ' . $employee_number ,
					'datas'		=> "Deleted Data: " . $json_data,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> 'TIMEKEEPING: MANUAL ATTENDANCE - IN',
					'date'		=> date('Y-m-d H:i:s')
				);

				// CALL ACTIVITY LOGS DATABASE
				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data);
				
				// DELETE TIME IN 
				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->where('attendance_in.biometric_id', $biometric_id);
				$blaine_timekeeping->where('attendance_in.date', $date);
				$blaine_timekeeping->delete('attendance_in');

			}

			if($delete_no_time_out == 1)
			{

				$entry_data = array(
					'biometric_id'    => $biometric_id,
					'employee_number' => $employee_number,
					'date'            => $date,
					'time'            => $delete_time_out,
					'status'          => 'OUT',
					'remarks'         => $delete_remarks
				);

				$json_data = json_encode($entry_data);

				$data = array(
					'username'	=> $this->session->userdata('username'),
					'activity'	=> "Entry Deleted: " . ' Employee Number: ' . $employee_number ,
					'datas'		=> "Deleted Data: " . $json_data,
					'pc_ip'		=> $_SERVER['REMOTE_ADDR'],
					'type'		=> 'TIMEKEEPING: MANUAL ATTENDANCE - OUT',
					'date'		=> date('Y-m-d H:i:s')
				);

				// CALL ACTIVITY LOGS DATABASE
				$activity_log = $this->load->database('activity_logs', TRUE);
				$activity_log->insert('blaine_logs', $data);
				
				// DELETE TIME OUT
				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->where('attendance_out.biometric_id', $biometric_id);
				$blaine_timekeeping->where('attendance_out.date', $date);
				$blaine_timekeeping->delete('attendance_out');
			}
		}
	

		$trans = $this->db->trans_complete();
		return $trans;
	}

	public function employee_time()
	{
		$this->db->select("
			employees.employee_number as employee_number,
			attendance_in.date as date_in, 
			attendance_out.date as date_out, 
			attendance_in.time as time_in,
			attendance_out.time as time_out,
			attendance_in.id as in_id,   
			attendance_out.id as out_id, 	
			individual_temp_date.date as temp_date,
			attendance_in.generate as in_generate,
			attendance_out.generate as out_generate,
			employee_biometric.biometric_number as biometric_id,
			attendance_in.generated_by as in_generated,
			attendance_out.generated_by as out_generated,
			attendance_in.generate as in_generate,
			attendance_out.generate as out_generate,
			employee_biometric.biometric_number as biometric_id,
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
			undertime.employee_number as ut_employee_number,
			undertime.date_ut as date_ut,
			undertime.ut_num as ut_num,
			undertime.process_by as ut_process_by,
			undertime.day as ut_day,
			overtime.date_ot as date_ot,
			overtime.employee_number as ot_employee_number,
			overtime.time_start as ot_time_in,
			overtime.time_end as ot_time_out,
			schedules.time_in as sched_time_in,
			schedules.time_out as sched_time_out,
			schedules.grace_period as grace_period,
			schedules.is_flexi as flexi_time,
			employee_holiday.employee_number as holiday_employee_number,
			employee_holiday.date as holiday_date,
			employee_holiday.type as holiday_type,
			employee_holiday.created_by as holiday_created_by,
			employee_schedules.time_in as emp_sched_time_in,
			employee_schedules.time_out as emp_sched_time_out,
			employee_schedules.date as emp_sched_date,
			employee_schedules.grace_period as emp_sched_grace_period,
			employee_schedules.is_flexi as emp_flexi_time,
		");
		$this->db->from('blaine_timekeeping.individual_temp_date');
		$this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_timekeeping.individual_temp_date.employee_number');
		$this->db->join('blaine_timekeeping.employee_biometric', 'blaine_timekeeping.employee_biometric.employee_number = blaine_intranet.employees.employee_number', 'left');
		$this->db->join('blaine_timekeeping.attendance_in', 'blaine_timekeeping.attendance_in.biometric_id = blaine_timekeeping.employee_biometric.biometric_number AND blaine_timekeeping.individual_temp_date.date = blaine_timekeeping.attendance_in.date','left');
		$this->db->join('blaine_timekeeping.attendance_out', 'blaine_timekeeping.attendance_out.biometric_id = blaine_timekeeping.employee_biometric.biometric_number AND blaine_timekeeping.individual_temp_date.date = blaine_timekeeping.attendance_out.date','left');
		$this->db->join('blaine_timekeeping.overtime','blaine_timekeeping.overtime.date_ot = blaine_timekeeping.individual_temp_date.date AND blaine_timekeeping.overtime.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('blaine_timekeeping.ob','blaine_timekeeping.ob.date_ob = blaine_timekeeping.individual_temp_date.date AND blaine_timekeeping.ob.status = blaine_timekeeping.individual_temp_date.batch AND blaine_timekeeping.ob.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('blaine_timekeeping.slvl','blaine_timekeeping.slvl.leave_date = blaine_timekeeping.individual_temp_date.date AND blaine_timekeeping.slvl.status = blaine_timekeeping.individual_temp_date.batch AND blaine_timekeeping.slvl.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('blaine_timekeeping.undertime','blaine_timekeeping.undertime.date_ut = blaine_timekeeping.individual_temp_date.date AND blaine_timekeeping.undertime.status = blaine_timekeeping.individual_temp_date.batch AND blaine_timekeeping.undertime.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('blaine_timekeeping.schedules', 'blaine_timekeeping.schedules.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('blaine_schedules.employee_holiday', 'blaine_timekeeping.individual_temp_date.date = blaine_schedules.employee_holiday.date AND blaine_timekeeping.individual_temp_date.employee_number = blaine_schedules.employee_holiday.employee_number','left');
		$this->db->join('blaine_schedules.employee_schedules', 'blaine_schedules.employee_schedules.date = blaine_timekeeping.individual_temp_date.date AND blaine_timekeeping.individual_temp_date.employee_number = blaine_schedules.employee_schedules.employee_number', 'left');
		$this->db->order_by('blaine_timekeeping.individual_temp_date.date','ASC');
		$this->db->group_by('blaine_timekeeping.individual_temp_date.date');
		$this->db->where('blaine_timekeeping.individual_temp_date.created_by', $this->session->userdata('username'));
		$query = $this->db->get();

		return $query->result();
	}
	public function my_employee_time()
	{
		$this->db->select("
			employees.employee_number as employee_number,
			attendance_in.date as date_in, 
			attendance_out.date as date_out, 
			attendance_in.time as time_in,
			attendance_out.time as time_out,
			attendance_in.id as in_id,   
			attendance_out.id as out_id, 	
			myattendance_temp_date.date as temp_date,
			attendance_in.generate as in_generate,
			attendance_out.generate as out_generate,
			employee_biometric.biometric_number as biometric_id,
			attendance_in.generated_by as in_generated,
			attendance_out.generated_by as out_generated,
			attendance_in.generate as in_generate,
			attendance_out.generate as out_generate,
			employee_biometric.biometric_number as biometric_id,
			schedules.time_in as sched_time_in,
			schedules.time_out as sched_time_out,
			schedules.grace_period as grace_period
		
		");
		$this->db->from('blaine_timekeeping.myattendance_temp_date');
		$this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_timekeeping.myattendance_temp_date.employee_number');
		$this->db->join('blaine_timekeeping.employee_biometric', 'blaine_timekeeping.employee_biometric.employee_number = blaine_intranet.employees.employee_number', 'left');
		$this->db->join('blaine_timekeeping.attendance_in', 'blaine_timekeeping.attendance_in.biometric_id = blaine_timekeeping.employee_biometric.biometric_number AND blaine_timekeeping.myattendance_temp_date.date = blaine_timekeeping.attendance_in.date','left');
		$this->db->join('blaine_timekeeping.attendance_out', 'blaine_timekeeping.attendance_out.biometric_id = blaine_timekeeping.employee_biometric.biometric_number AND blaine_timekeeping.myattendance_temp_date.date = blaine_timekeeping.attendance_out.date','left');
		$this->db->join('blaine_timekeeping.ob','blaine_timekeeping.ob.date_ob = blaine_timekeeping.myattendance_temp_date.date AND blaine_timekeeping.ob.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('blaine_timekeeping.slvl','blaine_timekeeping.slvl.leave_date = blaine_timekeeping.myattendance_temp_date.date AND blaine_timekeeping.slvl.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('blaine_timekeeping.schedules', 'blaine_timekeeping.schedules.employee_number = blaine_intranet.employees.employee_number','left');

		$this->db->order_by('blaine_timekeeping.myattendance_temp_date.date','ASC');
		$this->db->where('blaine_timekeeping.myattendance_temp_date.created_by', $this->session->userdata('username'));
		$query = $this->db->get();

		return $query->result();
	}

	public function employee_absence()
	{
		$this->db->select("
            slvl.id as id,
            slvl.type_name as type_name,
            slvl.type as type,
            slvl.leave_day as leave_day,
            slvl.leave_date as leave_date,
            slvl.leave_num as leave_num,
            slvl.reason as reason,
            slvl.leave_address as leave_address,
            slvl.status as status
        ");
		$this->db->from('blaine_timekeeping.individual_temp_date');
		$this->db->join('blaine_timekeeping.slvl','blaine_timekeeping.slvl.leave_date = blaine_timekeeping.individual_temp_date.date AND blaine_timekeeping.slvl.employee_number = blaine_timekeeping.individual_temp_date.employee_number');
		$this->db->where('blaine_timekeeping.individual_temp_date.created_by', $this->session->userdata('username'));
		$query = $this->db->get();

        return $query->result();
	}

	public function employee_ob()
    {
        $this->db->select("
            ob.id as id,
            ob.date_ob as date_ob,
            ob.destination as destination,
            ob.purpose as purpose,
            ob.transport as transport,
            ob.plate_no as plate_no,
            ob.time_departure as time_departure,
            ob.time_departure_destination as time_departure_destination,
            ob.status as status,
            ob.type as type,
            ob.remarks as remarks
        ");
        $this->db->from('blaine_timekeeping.ob');
		$this->db->join('blaine_timekeeping.individual_temp_date','blaine_timekeeping.ob.date_ob = blaine_timekeeping.individual_temp_date.date AND blaine_timekeeping.ob.employee_number = blaine_timekeeping.individual_temp_date.employee_number');
		$this->db->where('blaine_timekeeping.individual_temp_date.created_by', $this->session->userdata('username'));
        $query = $this->db->get();

        return $query->result();
    }
	
	public function employee_ut()
	{
		$this->db->select("
			undertime.id as id,
			undertime.date_ut as date_ut,
			undertime.time_start as time_start,
			undertime.time_end as time_end,
			undertime.ut_num as ut_num,
			undertime.reason as reason,
			undertime.status as status
		");
		$this->db->from('blaine_timekeeping.undertime');
		$this->db->join('blaine_timekeeping.individual_temp_date','blaine_timekeeping.undertime.date_ut = blaine_timekeeping.individual_temp_date.date AND blaine_timekeeping.undertime.employee_number = blaine_timekeeping.individual_temp_date.employee_number');
		$this->db->where('blaine_timekeeping.individual_temp_date.created_by', $this->session->userdata('username'));
		$query = $this->db->get();

		return $query->result();
	} 

	public function employee_ot()
	{
		$test12 = $this->session->userdata('username');
		$query = $this->db->query("
            SELECT
            a.id as id,
            a.employee_number as employee_number,
            a.date_ot as date_ot,
            a.time_start as time_start,
            a.time_end as time_end,
            a.task as task,
            a.type as type,
			a.status as status,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            attendance_in.time as actual_time_in,
            attendance_out.time as actual_time_out,
            attendance_in.date as date_in, 
            attendance_out.date as date_out, 
            schedules.time_in as sched_time_in,
            schedules.time_out as sched_time_out,
			schedules.is_flexi as emp_flexible_time,
            schedules.grace_period as grace_period,
            employee_schedules.time_in as emp_sched_time_in,
            employee_schedules.time_out as emp_sched_time_out,
            employee_schedules.date as emp_sched_date,
            employee_schedules.grace_period as emp_sched_grace_period,
            b.ot_num as rd,
            c.ot_num as rdot,
            d.ot_num as rh,
            e.ot_num as rhot,
            f.ot_num as sh,
            g.ot_num as shot, 
            h.ot_num as rotam,
            i.ot_num as rotpm,
            h.time_start as am_time_in,
			h.time_end as am_time_out,
			h.day as am_day,
			i.time_start as pm_time_in,
            i.time_end as pm_time_out,
			i.day as pm_day
            FROM blaine_timekeeping.overtime as a
            INNER JOIN blaine_intranet.employees ON blaine_intranet.employees.employee_number = a.employee_number
			INNER JOIN blaine_timekeeping.individual_temp_date ON blaine_timekeeping.individual_temp_date.employee_number = a.employee_number AND  blaine_timekeeping.individual_temp_date.date = a.date_ot
            LEFT JOIN blaine_timekeeping.attendance_in ON blaine_timekeeping.attendance_in.employee_number = a.employee_number AND blaine_timekeeping.attendance_in.date = a.date_ot
            LEFT JOIN blaine_timekeeping.attendance_out ON blaine_timekeeping.attendance_out.employee_number = a.employee_number AND blaine_timekeeping.attendance_out.date = a.date_ot
            LEFT JOIN blaine_timekeeping.schedules ON blaine_timekeeping.schedules.employee_number = a.employee_number
            LEFT JOIN blaine_schedules.employee_schedules ON blaine_schedules.employee_schedules.employee_number = a.employee_number
            LEFT JOIN blaine_timekeeping.overtime as b ON a.employee_number = b.employee_number AND a.date_ot = b.date_ot AND b.type = 'RD'
            LEFT JOIN blaine_timekeeping.overtime as c ON a.employee_number = c.employee_number AND a.date_ot = c.date_ot AND c.type = 'RDOT'
            LEFT JOIN blaine_timekeeping.overtime as d ON a.employee_number = d.employee_number AND a.date_ot = d.date_ot AND d.type = 'RH'
            LEFT JOIN blaine_timekeeping.overtime as e ON a.employee_number = e.employee_number AND a.date_ot = e.date_ot AND e.type = 'RHOT'
            LEFT JOIN blaine_timekeeping.overtime as f ON a.employee_number = f.employee_number AND a.date_ot = f.date_ot AND f.type = 'SH'
            LEFT JOIN blaine_timekeeping.overtime as g ON a.employee_number = g.employee_number AND a.date_ot = g.date_ot AND g.type = 'SHOT'
            LEFT JOIN blaine_timekeeping.overtime as h ON a.employee_number = h.employee_number AND a.date_ot = h.date_ot AND h.type = 'ROT' AND h.day = 'am'
            LEFT JOIN blaine_timekeeping.overtime as i ON a.employee_number = i.employee_number AND a.date_ot = i.date_ot AND i.type = 'ROT' AND i.day = 'pm'
			WHERE blaine_timekeeping.individual_temp_date.created_by = '$test12'
            GROUP BY a.date_ot,a.employee_number
        ")->result();

        return $query;
	}
	
	public function employee_name()
	{
		$this->db->select("
			CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname,
			department.name as department_name
		");
		$this->db->from('blaine_timekeeping.individual_temp_date');
		$this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_timekeeping.individual_temp_date.employee_number');
		$this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number');
		$this->db->join('department', 'employment_info.department = department.id');
		$this->db->where('blaine_timekeeping.individual_temp_date.created_by', $this->session->userdata('username'));
		$query = $this->db->get();

		return $query->row();
	}

	public function my_employee_name()
	{
		$this->db->select("
			CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname,
			department.name as department_name,
			schedules.employee_number as employee_number,
			schedules.biometric_id as biometric_id, 
            schedules.days as days,
            schedules.time_in as time_in,
            schedules.time_out as time_out,
            schedules.grace_period as grace_period,
            schedules.effective_date as effective_date
		");
		$this->db->from('blaine_timekeeping.myattendance_temp_date');
		$this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_timekeeping.myattendance_temp_date.employee_number');
		$this->db->join('employment_info', 'employment_info.employee_number = employees.employee_number');
		$this->db->join('blaine_timekeeping.schedules', 'blaine_intranet.employees.employee_number = blaine_timekeeping.schedules.employee_number', 'left');
		$this->db->join('department', 'employment_info.department = department.id');
		$this->db->where('blaine_timekeeping.myattendance_temp_date.created_by', $this->session->userdata('username'));
		$query = $this->db->get();

		return $query->row();
	}
	
} 
