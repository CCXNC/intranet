<?php
class Csv_import_model extends CI_Model
{
	public function insert($data) 
	{
		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
		$blaine_timekeeping->insert_batch('attendance_logs', $data);

		$data = array(
			'username' => $this->session->userdata('username'),
			'activity' => "Entry Uploaded-CSV",
			'pc_ip'    => $_SERVER['REMOTE_ADDR'],
			'type'     => 'TIMEKEEPING',
			'date'     => date('Y-m-d H:i:s')
		);

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 
		$activity_log->insert('blaine_logs', $data);
	}

	public function get_last_in()
	{
		$this->db->select('attendance_logs.id as id,attendance_logs.date_time as date');
		$this->db->from('blaine_timekeeping.attendance_logs');
		$this->db->where('attendance_logs.status', '1010');
		$this->db->order_by('attendance_logs.id', 'DESC');
		$query = $this->db->get();

		return $query->row();
	}

	public function get_last_out()
	{
		$this->db->select('attendance_logs.id as id,attendance_logs.date_time as date');
		$this->db->from('blaine_timekeeping.attendance_logs');
		$this->db->where('attendance_logs.status', '1110');
		$this->db->order_by('attendance_logs.id', 'DESC');
		$query = $this->db->get();

		return $query->row();
	}

	public function get_attendance_logs()
	{
		$query = $this->db->query("
			SELECT attendance_logs.biometric_id as biometric_id, attendance_logs.date_time as date_time, attendance_logs.status as status , CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname, employee_biometric.employee_number as employee_number
			FROM blaine_timekeeping.attendance_logs
				LEFT JOIN blaine_timekeeping.employee_biometric
				ON blaine_timekeeping.attendance_logs.biometric_id = blaine_timekeeping.employee_biometric.biometric_number
				LEFT JOIN blaine_intranet.employees
				ON blaine_timekeeping.employee_biometric.employee_number = blaine_intranet.employees.employee_number
					WHERE attendance_logs.id IN (
						SELECT MAX(attendance_logs.id)
						FROM blaine_timekeeping.attendance_logs
						WHERE status='1110'
						GROUP BY attendance_logs.biometric_id, DATE(date_time)
					)
					OR attendance_logs.id IN (
						SELECT MIN(attendance_logs.id)
						FROM blaine_timekeeping.attendance_logs
						WHERE status='1010'
						GROUP BY attendance_logs.biometric_id, DATE(date_time)
					) ORDER BY DATE(date_time) ASC, status
				")->result();

		return $query;
	}

	public function get_raw_attendance_logs()
	{
		$query = $this->db->query("
			SELECT attendance_logs.biometric_id as biometric_id, attendance_logs.date_time as date_time, attendance_logs.status as status , CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname, employee_biometric.employee_number as employee_number
			FROM blaine_timekeeping.attendance_logs
				LEFT JOIN blaine_timekeeping.employee_biometric
				ON blaine_timekeeping.attendance_logs.biometric_id = blaine_timekeeping.employee_biometric.biometric_number
				LEFT JOIN blaine_intranet.employees
				ON blaine_timekeeping.employee_biometric.employee_number = blaine_intranet.employees.employee_number
				")->result();

		return $query;
	}

	public function add_employees_attendance()
	{
		$this->db->trans_start();

		$biometric_id = $this->input->post('biometric_id');
		$count_rows = count($biometric_id);
		$employee_number = $this->input->post('employee_number');
		$date = $this->input->post('date');
		$time = $this->input->post('time');
		$status = $this->input->post('status');
		$date_in = $this->input->post('date_in');
		$date_out = $this->input->post('date_out');

		
		/*$last_entry_date = date('2021-01-26');
		print_r('<pre>');
		print_r($last_entry_date);
		print_r('</pre>');

		print_r('<pre>');
		print_r($date_in);
		print_r('</pre>');

		print_r('<pre>');
		print_r($date_out);
		print_r('</pre>');*/
		

		for($i=0; $count_rows > $i; $i++)
		{
			if($status[$i] == 'IN')
			{
				$data_in = array(
					'biometric_id'    => $biometric_id[$i],
					'employee_number' => $employee_number[$i],
					'date'            => $date[$i],
					'time'            => $time[$i],
					'status'          => $status[$i]
				);

				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->insert('attendance_in', $data_in);
				/*print_r('<pre>');
				print_r($data_in);
				print_r('</pre>');*/
			}
		}
	
		for($i=0; $count_rows > $i; $i++)
		{
			if($status[$i] == 'OUT')
			{
				$data_out = array(
					'biometric_id'    => $biometric_id[$i],
					'employee_number' => $employee_number[$i],
					'date'            => $date[$i],
					'time'            => $time[$i],
					'status'          => $status[$i]
				);
		
				$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
				$blaine_timekeeping->insert('attendance_out', $data_out);

				/*print_r('<pre>');
				print_r($data_out);
				print_r('</pre>');*/
			}
			
		}

		$raw_biometric_id = $this->input->post('raw_biometric_id');
		$raw_count_rows = count($raw_biometric_id);
		$raw_employee_number = $this->input->post('raw_employee_number');
		$raw_date = $this->input->post('raw_date');
		$raw_time = $this->input->post('raw_time');
		$raw_status = $this->input->post('raw_status');
		for($i=0; $raw_count_rows > $i; $i++)
		{
			$raw_data = array(
				'biometric_id'    => $raw_biometric_id[$i],
				'employee_number' => $raw_employee_number[$i],
				'date'            => $raw_date[$i],
				'time'            => $raw_time[$i],
				'status'          => $raw_status[$i]
			);

			$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
			$blaine_timekeeping->insert('raw_data', $raw_data);
			/*print_r('<pre>');
			print_r('----------------------------------------------<br>');
			print_r($raw_data);
			print_r('</pre>');*/
		}

		
		
		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
		$blaine_timekeeping->where('id !=', NULL);
		$blaine_timekeeping->delete('attendance_logs');

		$this->db->query("
			DELETE tbl1 FROM blaine_timekeeping.raw_data tbl1 INNER JOIN
			blaine_timekeeping.raw_data tbl2 WHERE tbl1.id > tbl2.id AND tbl1.biometric_id = tbl2.biometric_id AND tbl1.date = tbl2.date AND tbl1.time = tbl2.time
		");

		$this->db->query("
			DELETE tbl1 FROM blaine_timekeeping.attendance_in tbl1 INNER JOIN
			blaine_timekeeping.attendance_in tbl2 WHERE tbl1.id > tbl2.id AND tbl1.biometric_id = tbl2.biometric_id AND tbl1.date = tbl2.date
		");

		$this->db->query("
			DELETE tbl1 FROM blaine_timekeeping.attendance_out tbl1 INNER JOIN
			blaine_timekeeping.attendance_out tbl2 WHERE tbl1.id > tbl2.id AND tbl1.biometric_id = tbl2.biometric_id AND tbl1.date = tbl2.date
		");

		$data = array(
			'username' => $this->session->userdata('username'),
			'activity' => "Entry Process-CSV",
			'pc_ip'    => $_SERVER['REMOTE_ADDR'],
			'type'     => 'TIMEKEEPING',
			'date'     => date('Y-m-d H:i:s')
		);

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 
		$activity_log->insert('blaine_logs', $data);

		$trans = $this->db->trans_complete();
		return $trans;
		

	}

	public function delete_attendance_logs()
	{
		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
		$blaine_timekeeping->where('id !=', NULL);
		$query = $blaine_timekeeping->delete('attendance_logs');

		$data = array(
			'username' => $this->session->userdata('username'),
			'activity' => "Entry Delete-CSV",
			'pc_ip'    => $_SERVER['REMOTE_ADDR'],
			'type'     => 'TIMEKEEPING',
			'date'     => date('Y-m-d H:i:s')
		);

		// CALL ACVITIY LOGS DATABASE
		$activity_log = $this->load->database('activity_logs', TRUE); 
		$activity_log->insert('blaine_logs', $data);


		return $query;
	}

}
