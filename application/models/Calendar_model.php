<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_model extends CI_Model {

    public function get_calendars_list()
	{
        //$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        //$query = $blaine_timekeeping->get('calendar');

        //return $query->result();

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);

        $blaine_timekeeping->select("
            holiday_calendar.id as id,
            holiday_calendar.type as type,
            holiday_calendar.description as description,
            holiday_calendar.start as start
        ");

        $blaine_timekeeping->from('holiday_calendar');

        $query = $blaine_timekeeping->get();
        return $query->result();
        
	}

    public function add_calendar_list()
    {
        $this->db->trans_start();

        //HOLIDAY INPUT 
        $date = $this->input->post('start');
        $type = $this->input->post('type');
        $description = $this->input->post('description');

        $created_date = date('Y-m-d H:i:s');

        if($type != "Economic Holiday")
        {
            $data_calendar = array(
                'date'            => $date,
                'type'            => $type,
                'description'     => $description,
                'created_date'    => $created_date,
                'created_by'      => $this->session->userdata('username')
            );
    
            //DATABASE CONNECTION TO TIMEKEEPING
            $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
            $blaine_timekeeping->insert('holiday_calendar', $data_calendar);
    
            /*print_r('<pre>');
            print_r($data_calendar);
            print_r('</pre>');*/
    
            $employee = $this->employee_model->get_employees();
            $i = 0;
            foreach($employee as $emp)
            {
                $data_emp_holiday = array(
                    'employee_number' => $employee[$i]->emp_no,
                    'date'            => $date,
                    'type'            => $type,
                    'created_date'    => $created_date,
                    'created_by'      => $this->session->userdata('username')
                );
    
                //DATABASE CONNECTION TO TIMEKEEPING
                $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
                $blaine_timekeeping->insert('employee_holiday', $data_emp_holiday);
    
                /*print_r('<pre>');
                print_r($data_emp_holiday);
                print_r('</pre>');*/
    
                $i++;
            }
        }
        else
        {
            $data_calendar = array(
                'date'            => $date,
                'type'            => $type,
                'description'     => $description,
                'created_date'    => $created_date,
                'created_by'      => $this->session->userdata('username')
            );
    
            //DATABASE CONNECTION TO TIMEKEEPING
            $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
            $blaine_timekeeping->insert('holiday_calendar', $data_calendar);
    
            /*print_r('<pre>');
            print_r($data_calendar);
            print_r('</pre>');*/
        }

        // ACTIVITY LOGS PROCESS
        $data_logs = array(
            'username' => $this->session->userdata('username'),
            'activity' => "Entry Added: Holiday",
            'pc_ip'    => $_SERVER['REMOTE_ADDR'],
            'type'     => 'TIMEKEEPING: HOLIDAY CALENDAR LIST',
            'date'     => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function add_employee_holiday()
    {
        $this->db->trans_start();

        //HOLIDAY INPUT 
        $date = $this->input->post('date');
        $type = $this->input->post('type');

        $created_date = date('Y-m-d H:i:s');

        foreach($this->input->post('employee') as $emp)
        {
            $data_calendar = array(
                'employee_number' => $emp,
                'date'            => $date,
                'type'            => $type,
                'created_date'    => $created_date,
                'created_by'      => $this->session->userdata('username')
            );

            //DATABASE CONNECTION TO TIMEKEEPING
            $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
            $blaine_timekeeping->insert('employee_holiday', $data_calendar);

            /*print_r('<pre>');
            print_r($data_calendar);
            print_r('</pre>');*/
        }
       
        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function get_holidays()
    {
        $query = $this->db->get('blaine_schedules.holiday_calendar');
        return $query->result();
    }

    public function get_calendar_list($id)
    {
        $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);

        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->get('holiday_calendar');

        return $query->row();
    }

    public function get_calendar_list_with_employee($date)
    {
        $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);

        $blaine_timekeeping->where('date', $date);
        $query = $blaine_timekeeping->get('holiday_calendar');

        return $query->row();
    }

    public function get_holiday_employee($date)
    {
        $this->db->select("
            employee_holiday.employee_number as employee_number,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
        ");
        $this->db->from('blaine_schedules.employee_holiday');
        $this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_schedules.employee_holiday.employee_number','left');
        $this->db->where('blaine_schedules.employee_holiday.date', $date);
        $this->db->order_by('blaine_intranet.employees.last_name', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function update_calendar_list($id)
    {
        $this->db->trans_start();

        $start = $this->input->post('start');
        $type = $this->input->post('type');
        $description = $this->input->post('description');

        $updated_date = date('Y-m-d H:i:s');

        // GET OLD DATA BEFORE UPDATE
        $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
        $blaine_timekeeping->select('*');
        $blaine_timekeeping->where('id', $id);
        $datas = $blaine_timekeeping->get('holiday_calendar');
        $holiday_id     = $datas->row()->id;
        $holiday_start  = $datas->row()->date;
        $holiday_type   = $datas->row()->type;
        $holiday_description = $datas->row()->description;

        $entry_data = array(
            'id'            => $holiday_id,
            'date'          => $holiday_start,
            'type'          => $holiday_type,
            'description'   => $holiday_description
        );

        // CONVERT TO JSON ENCODE
        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username' => $this->session->userdata('username'),
            'activity' => "Entry Updated: " . ' ID: ' . $holiday_id,
            'datas'    => "Previous Data: " . $json_data,
            'pc_ip'    => $_SERVER['REMOTE_ADDR'],
            'type'     => 'TIMEKEEPING: HOLIDAY CALENDAR LIST',
            'date'     => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        // PROCESS FOR UPDATE ANNOUNCEMENT
        $data_calendar = array(
            'date'          => $start,
            'type'          => $type,
            'description'   => $description,
            'updated_date'  => $updated_date,
            'updated_by'    => $this->session->userdata('username')
        );

        //DATABASE CONNECTION
        $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
        $blaine_timekeeping->where('id', $id);
        $blaine_timekeeping->update('holiday_calendar', $data_calendar);

        $data_employee = array(
            'date' => $start,
            'updated_date'  => $updated_date,
            'updated_by'    => $this->session->userdata('username')
        );

         //DATABASE CONNECTION
         $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
         $blaine_timekeeping->where('employee_holiday.date', $holiday_start);
         $blaine_timekeeping->update('employee_holiday', $data_employee);

        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function get_economic_holiday()
    {
        $this->db->where('blaine_schedules.holiday_calendar.type', "Economic Holiday");
        $this->db->where('blaine_schedules.holiday_calendar.date >=', date('Y-m-d'));
        $query = $this->db->get('blaine_schedules.holiday_calendar');

        return $query->result();
    }

    public function update_move_to_economic_holiday()
    {
        $this->db->trans_start();

        $regular_date = $this->input->post('regular_date');
        $date = $this->input->post('date');
        foreach($this->input->post('employee') as $emp)
        {
            $data = array(
                'date'         => $date,
                'type'         => "Economic Holiday",
                'updated_date' => date('Y-m-d H:i:s'),
                'updated_by'   => $this->session->userdata('username')
            );
            
            $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
            $blaine_timekeeping->where('employee_holiday.date', $regular_date);
            $blaine_timekeeping->where('employee_holiday.employee_number', $emp);
            $blaine_timekeeping->update('employee_holiday', $data);

            /*print_r('<pre>');
            print_r($data);
            print_r('</pre>');*/
         
        }

        $trans = $this->db->trans_complete();

        return $trans;
    }

    public function delete_calendar_list($id)
    {
        $this->db->trans_start();

        // GET OLD DATA BEFORE UPDATE
        $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
        $blaine_timekeeping->select('*');
        $blaine_timekeeping->where('id', $id);
        $datas = $blaine_timekeeping->get('holiday_calendar');
        $holiday_id = $datas->row()->id;
        $holiday_type = $datas->row()->type;
        $holiday_description = $datas->row()->description;
        $holiday_date = $datas->row()->date;

        $entry_data = array(
            'id'            => $holiday_id,
            'type'          => $holiday_type,
            'description'   => $holiday_description,
            'date'          => $holiday_date
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'  => $this->session->userdata('username'),
            'activity'  => "Entry Deleted: " . ' ID: ' . $id,
            'datas'     => "Deleted Data: " . $json_data,
            'pc_ip'     => $_SERVER['REMOTE_ADDR'],
            'type'      => 'TIMEKEEPING: HOLIDAY CALENDAR LIST',
            'date'      => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        // DELETE PROCESS
        $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
        $blaine_timekeeping->where('id', $id);
        $blaine_timekeeping->delete('holiday_calendar');

        $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
        $blaine_timekeeping->where('employee_holiday.date', $holiday_date);
        $blaine_timekeeping->delete('employee_holiday');

        $trans = $this->db->trans_complete();
        return $trans;

    }


    // CALENDAR
    public function get_events() 
    {
        return $this->db->get("blaine_timekeeping.holiday_calendar");
    }

    public function add_event($data) 
    {
        //$this->db->insert("calendar_events", $data);

        // DATABASE CONNECTION TO TIMEKEEPING
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->insert('holiday_calendar', $data);

        /*print_r('<pre>');
		print_r($data_calendar);
		print_r('</pre>');*/

        $trans = $this->db->trans_complete();
        return $trans;
    }
    
    public function get_event($id) 
    {
        return $this->db->where("blaine_timekeeping.holiday_calendar.id", $id)->get("blaine_timekeeping.holiday_calendar");
    }

    public function update_event($id, $data) 
    {
        $this->db->where("blaine_timekeeping.holiday_calendar.id", $id)->update("blaine_timekeeping.holiday_calendar", $data);
    }

    public function delete_event($id) 
    {
        $this->db->where("blaine_timekeeping.holiday_calendar.id", $id)->delete("blaine_timekeeping.holiday_calendar");
    }
}
