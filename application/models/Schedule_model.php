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
        $days = substr(implode(',', $this->input->post('days')), 0);
        $time_in = $this->input->post('time_in');
        $time_out = $this->input->post('time_out');
        $grace_period = $this->input->post('grace_period');
        $effective_date = $this->input->post('effective_date');
        $date = date('Y-m-d H:i:s');

        $data = array(
            'days'            => $days,
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
            schedules.id as id,
            schedules.days as days,
            schedules.time_in as time_in,
            schedules.time_out as time_out,
            schedules.grace_period as grace_period,
            schedules.effective_date as effective_date
        ");
        $this->db->from('blaine_timekeeping.schedules');
        $this->db->where('blaine_timekeeping.schedules.is_schedule', 1);
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
        $days = substr(implode(',', $this->input->post('days')), 0);
        $time_in = $this->input->post('time_in');
        $time_out = $this->input->post('time_out');
        $grace_period = $this->input->post('grace_period');
        $effective_date = $this->input->post('effective_date');
        $date = date('Y-m-d H:i:s');

        $data = array(
            'days'            => $days,
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


}    