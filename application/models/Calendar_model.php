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
        $start = $this->input->post('start');
        $type = $this->input->post('type');
        $description = $this->input->post('description');

        $created_date = date('Y-m-d H:i:s');

        $data_calendar = array(
            'start'         => $start,
            'type'          => $type,
            'description'   => $description,
            'created_date'  => $created_date,
            'created_by'    => $this->session->userdata('username')
        );

        // DATABASE CONNECTION TO TIMEKEEPING
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->insert('holiday_calendar', $data_calendar);

        /*print_r('<pre>');
		print_r($data_calendar);
		print_r('</pre>');*/

        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function get_calendar_list($id)
    {
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);

        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->get('holiday_calendar');

        return $query->row();
    }

    public function update_calendar_list($id)
    {
        $this->db->trans_start();

        $start = $this->input->post('start');
        $type = $this->input->post('type');
        $description = $this->input->post('description');

        $updated_date = date('Y-m-d H:i:s');

        $data_calendar = array(
            'start'         => $start,
            'type'          => $type,
            'description'   => $description,
            'updated_date'  => $updated_date,
            'updated_by'    => $this->session->userdata('username')
        );

        //DATABASE CONNECTION
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $blaine_timekeeping->update('holiday_calendar', $data_calendar);

        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function delete_calendar_list($id)
    {

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
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
