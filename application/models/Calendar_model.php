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

        $data_calendar = array(
            'date'         => $start,
            'type'          => $type,
            'description'   => $description,
            'updated_date'  => $updated_date,
            'updated_by'    => $this->session->userdata('username')
        );

        //DATABASE CONNECTION
        $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
        $blaine_timekeeping->where('id', $id);
        $blaine_timekeeping->update('holiday_calendar', $data_calendar);

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

        $blaine_timekeeping = $this->load->database('blaine_schedules', TRUE);
        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->delete('holiday_calendar');

        return $query;

    }

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
