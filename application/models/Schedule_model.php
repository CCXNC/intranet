<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_model extends CI_Model {


    public function add_employee_schedule()
    {
        $data = $this->input->post('employee_number');
        $explod_data = explode('|', $data);
        $employee_number = $explod_data[0];
        $biometric_id = $explod_data[1];
        $id = $explod_data[2];
        //$days = substr(implode(',', $this->input->post('days')), 0); | 'days'            => $days,
        $time_in = $this->input->post('time_in');
        $time_out = $this->input->post('time_out');
        $grace_period = $this->input->post('grace_period');
        $effective_date = $this->input->post('effective_date');
        $date = date('Y-m-d H:i:s');

        $data = array(
            'time_in'         => $time_in,
            'time_out'        => $time_out,
            'grace_period'    => $grace_period,
            'effective_date'  => $effective_date,
            'created_date'    => $date,
            'created_by'      => $this->session->userdata('username'),
            'is_schedule'     => 1
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->update('schedules', $data);

        // ACTIVITY LOGS
        $data_logs = array(
            'username'  => $this->session->userdata('username'),
            'activity'  => "Entry Added: Employee Number: " . $employee_number,
            'pc_ip'     => $_SERVER['REMOTE_ADDR'],
            'type'      => 'TIMEKEEPING: EMPLOYEE SCHEDULE',
            'date'      => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        return $query;
        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/
    }

    public function get_employees_schedule()
    {
        $this->db->select("
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            schedules.employee_number as employee_number,
            schedules.biometric_id as biometric_number,
            schedules.id as id,
            schedules.days as days,
            schedules.time_in as time_in,
            schedules.time_out as time_out,
            schedules.grace_period as grace_period,
            schedules.effective_date as effective_date
        ");
        $this->db->from('blaine_timekeeping.schedules');
        $this->db->where('blaine_intranet.employees.is_active', 1);
        $this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_timekeeping.schedules.employee_number', 'left');
        $query = $this->db->get();
       
        
        return $query->result();
    }

    public function get_employee_schedule($id)
    {
        $this->db->select("
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            schedules.employee_number as employee_number,
            schedules.biometric_id as biometric_id, 
            schedules.id as id,
            schedules.days as days,
            schedules.time_in as time_in,
            schedules.time_out as time_out,
            schedules.grace_period as grace_period,
            schedules.effective_date as effective_date
        ");
        $this->db->from('blaine_timekeeping.schedules');
        $this->db->where('blaine_timekeeping.schedules.id', $id);
        $this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_timekeeping.schedules.employee_number', 'left');
        $query = $this->db->get();
       
        
        return $query->row();
    }

    public function update_employee_schedule($id)
    {
        //$days = substr(implode(',', $this->input->post('days')), 0); |   'days'            => $days,
        $time_in = $this->input->post('time_in');
        $time_out = $this->input->post('time_out');
        $grace_period = $this->input->post('grace_period');
        $effective_date = $this->input->post('effective_date');
        $date = date('Y-m-d H:i:s');

        // GET OLD DATA BEFORE UPDATE
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->select('*');
        $blaine_timekeeping->where('id', $id);
        $datas = $blaine_timekeeping->get('schedules');
        $employee_schedule_id = $datas->row()->id;
        $employee_schedule_employee_number = $datas->row()->employee_number;
        $employee_schedule_time_in = $datas->row()->time_in;
        $employee_schedule_time_out = $datas->row()->time_out;
        $employee_schedule_grace_period = $datas->row()->grace_period;
        $employee_schedule_effective_date = $datas->row()->effective_date;

        $entry_data = array(
            'id'                => $employee_schedule_id,
            'time_in'           => $employee_schedule_time_in,
            'time_out'          => $employee_schedule_time_out,
            'grace_period'      => $employee_schedule_grace_period,
            'effective_date'    => $employee_schedule_effective_date
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'  => $this->session->userdata('username'),
            'activity'  => "Entry Updated: " . 'Employee Number: ' . $employee_schedule_employee_number,
            'datas'     => "Previous Data: " . $json_data,
            'pc_ip'     => $_SERVER['REMOTE_ADDR'],
            'type'      => 'TIMEKEEPING: EMPLOYEE SCHEDULE',
            'date'      => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);
        
        // PROCESS FOR UPDATE
        $data = array(
            'time_in'         => $time_in,
            'time_out'        => $time_out,
            'grace_period'    => $grace_period,
            'effective_date'  => $effective_date,
            'updated_date'    => $date,
            'updated_by'      => $this->session->userdata('username')
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->update('schedules', $data);

        return $query;
    }

    public function get_employees_schedule_select()
    {
        $this->db->select("
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            schedules.employee_number as employee_number,
            schedules.biometric_id as biometric_id, 
            schedules.id as id,
            schedules.days as days,
            schedules.time_in as time_in,
            schedules.time_out as time_out,
            schedules.grace_period as grace_period,
            schedules.effective_date as effective_date
        ");
        $this->db->from('blaine_timekeeping.schedules');
        $this->db->where('blaine_timekeeping.schedules.is_schedule', 0);
        $this->db->where('blaine_intranet.employees.is_active', 1);
        $this->db->order_by('blaine_intranet.employees.last_name', 'ASC');
        $this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_timekeeping.schedules.employee_number', 'left');
        $query = $this->db->get();
       
        
        return $query->result();
    }

    public function get_no_biometric_employees()
    {
        $this->db->select("
        CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
        employee_biometric.id as id,
        employee_biometric.employee_number as employee_number,
        employee_biometric.biometric_number as biometric_id, 
    ");
    $this->db->from('blaine_timekeeping.employee_biometric');
    $this->db->where('blaine_timekeeping.employee_biometric.is_biometric', 0);
    $this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_timekeeping.employee_biometric.employee_number', 'left');
    $query = $this->db->get();
   
    return $query->result(); 

    }

    public function add_biometric()
    {
        $this->db->trans_start();

        $data = $this->input->post('employee_number');
        $explod_data = explode('|', $data);
        $id = $explod_data[0];
        $employee_number = $explod_data[1];
        $biometric_id = $this->input->post('biometric_number');

        $data_biometric = array(
            'biometric_number' => $biometric_id,
            'is_biometric'     => 1
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('employee_biometric.id', $id);
        $blaine_timekeeping->update('employee_biometric', $data_biometric);

        $data_schedule = array(
            'biometric_id' => $biometric_id,
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('schedules.employee_number', $employee_number);
        $blaine_timekeeping->update('schedules', $data_schedule);

        // ACTIVITY LOGS
        $data_logs = array(
            'username'  => $this->session->userdata('username'),
            'activity'  => "Entry Added: Employee Number: " . $employee_number,
            'pc_ip'     => $_SERVER['REMOTE_ADDR'],
            'type'      => 'TIMEKEEPING: EMPLOYEE BIOMETRIC',
            'date'      => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $trans = $this->db->trans_complete();

        return $trans;
    }

    public function get_employee_biometric($employee_number)
    {
        $this->db->select("
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            employee_biometric.id as id,
            employee_biometric.employee_number as employee_number,
            employee_biometric.biometric_number as biometric_id, 
        ");
        $this->db->from('blaine_timekeeping.employee_biometric');
        $this->db->where('blaine_timekeeping.employee_biometric.employee_number', $employee_number);
        $this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_timekeeping.employee_biometric.employee_number', 'left');
        $query = $this->db->get();
    
        return $query->row(); 

    }

    public function update_employee_biometric($employee_number)
    {
        $this->db->trans_start();

        $biometric_id = $this->input->post('biometric_id');

        // GET OLD DATA BEFORE UPDATE
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->select('*');
        $blaine_timekeeping->where('employee_number', $employee_number);
        $datas = $blaine_timekeeping->get('employee_biometric');
        $employee_biometric_id = $datas->row()->id;
        $employee_biometric_number = $datas->row()->biometric_number;

        $entry_data = array(
            'id'                => $employee_biometric_id,
            'biometric_number'  => $employee_biometric_number
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'  => $this->session->userdata('username'),
            'activity'  => "Entry Updated: Employee Number: " . $employee_number,
            'datas'     => "Previous Data: " .$json_data,
            'pc_ip'     => $_SERVER['REMOTE_ADDR'],
            'type'      => 'TIMEKEEPING: EMPLOYEE BIOMETRIC',
            'date'      => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        // PROCESS FOR BIOMETRIC UPDATE
        $data_biometric = array(
            'biometric_number' => $biometric_id,
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('employee_biometric.employee_number', $employee_number);
        $blaine_timekeeping->update('employee_biometric', $data_biometric);

        $data_schedule = array(
            'biometric_id' => $biometric_id,
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('schedules.employee_number', $employee_number);
        $blaine_timekeeping->update('schedules', $data_schedule);

        $trans = $this->db->trans_complete();

        return $trans;
    }

    public function add_employee_schedules($employee_number)
    {
        $this->db->trans_start();

        $employee_number = $this->input->post('employee_number');
        $biometric_number = $this->input->post('biometric_number');
        $time_in = $this->input->post('time_in');
        $time_out = $this->input->post('time_out');
        $grace_period = $this->input->post('grace_period');
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
            $w_date = date('w', strtotime($cur_date));

            if($w_date != 6 && $w_date != 0)
            {
                $data = array( 
                    'employee_number' => $employee_number,
                    'biometric_id'    => $biometric_number,
                    'date'            => $cur_date,
                    'time_in'         => $time_in,
                    'time_out'        => $time_out,
                    'grace_period'    => $grace_period,
                    'created_by'      => $this->session->userdata('username'),
                    'created_date'    => date('Y-m-d H:i:s')
                );
                
                $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
                $blaine_timekeeping->insert('employee_schedules', $data);
                /*print_r('<pre>');
                print_r($data);
                print_r('</pre>');*/
            }
			

			$conv_date = strtotime($start_date);
			$cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));
		}	

        // ACTIVITY LOGS
        $data_logs = array(
            'username'  => $this->session->userdata('username'),
            'activity'  => "Entry Added: Employee Number: " .$employee_number,
            'pc_ip'     => $_SERVER['REMOTE_ADDR'],
            'type'      => 'TIMEKEEPING: EMPLOYEE SCHEDULE - CHANGE SCHEDULE',
            'date'      => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function get_employee_schedules($employee_number)
    {
        $this->db->where('blaine_schedules.employee_schedules.employee_number', $employee_number);
        $query = $this->db->get('blaine_schedules.employee_schedules');
        
        return $query->result();
    }

}    