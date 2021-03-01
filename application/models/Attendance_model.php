<?php
class Attendance_model extends CI_Model
{
	public function get_employees_attendance()
	{
		$this->db->select("
			CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname,
			attendance_in.date as date, 
			attendance_in.time as time_in,
			attendance_out.time as time_out,
			attendance_in.id as in_id, 
			attendance_out.id as out_id, 		
		");
		$this->db->from('blaine_intranet.employees');
		$this->db->join('blaine_timekeeping.attendance_in', 'blaine_timekeeping.attendance_in.employee_number = blaine_intranet.employees.employee_number','left');
		$this->db->join('blaine_timekeeping.attendance_out', 'blaine_timekeeping.attendance_in.biometric_id = blaine_timekeeping.attendance_out.biometric_id AND blaine_timekeeping.attendance_in.date = blaine_timekeeping.attendance_out.date ','left');
        //$this->db->where('attendance_in.date', $start_date);      
		//$this->db->where('attendance_in.date <=', $end_date);     
        $this->db->order_by('employees.last_name','ASC');
		$this->db->order_by('attendance_in.date','ASC');
		$query = $this->db->get();
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

	return $query->result();	
	}
}
