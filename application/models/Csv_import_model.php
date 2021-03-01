<?php
class Csv_import_model extends CI_Model
{
	public function insert($data) 
	{
		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
		$blaine_timekeeping->insert_batch('attendance_logs', $data);
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
		
		$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
		$blaine_timekeeping->where('id !=', NULL);
		$blaine_timekeeping->delete('attendance_logs');

		$this->db->query("
			DELETE tbl1 FROM blaine_timekeeping.attendance_in tbl1 INNER JOIN
			blaine_timekeeping.attendance_in tbl2 WHERE tbl1.id > tbl2.id AND tbl1.biometric_id = tbl2.biometric_id AND tbl1.date = tbl2.date
		");

		$this->db->query("
			DELETE tbl1 FROM blaine_timekeeping.attendance_out tbl1 INNER JOIN
			blaine_timekeeping.attendance_out tbl2 WHERE tbl1.id > tbl2.id AND tbl1.biometric_id = tbl2.biometric_id AND tbl1.date = tbl2.date
		");

		$trans = $this->db->trans_complete();
		return $trans;
		

	}

}
