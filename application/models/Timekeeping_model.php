<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timekeeping_model extends CI_Model {

    public function get_calendars_list()
	{
        //$blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        //$query = $blaine_timekeeping->get('calendar');

        //return $query->result();

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);

        $blaine_timekeeping->select("
            calendar.id as id,
            calendar.date as date,
            calendar.type as type,
            calendar.description as description
        ");

        $blaine_timekeeping->from('calendar');
        $blaine_timekeeping->where('calendar.is_active', 1);

        $query = $blaine_timekeeping->get();
        return $query->result();
        
	}

    public function add_calendar_list()
    {
        $this->db->trans_start();

        //HOLIDAY INPUT
        $date = $this->input->post('date');
        $type = $this->input->post('type');
        $description = $this->input->post('description');

        $created_date = date('Y-m-d H:i:s');

        $data_calendar = array(
            'date'          => $date,
            'type'          => $type,
            'description'   => $description,
            'created_date'  => $created_date,
            'created_by'    => $this->session->userdata('username')
        );

        // DATABASE CONNECTION TO TIMEKEEPING
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->insert('calendar', $data_calendar);

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
        $query = $blaine_timekeeping->get('calendar');

        return $query->row();
    }

    public function update_calendar_list($id)
    {
        $this->db->trans_start();

        $date = $this->input->post('date');
        $type = $this->input->post('type');
        $description = $this->input->post('description');

        $updated_date = date('Y-m-d H:i:s');

        $data_calendar = array(
            'date'          => $date,
            'type'          => $type,
            'description'   => $description,
            'updated_date'  => $updated_date,
            'updated_by'    => $this->session->userdata('username')
        );

        //DATABASE CONNECTION
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $blaine_timekeeping->update('calendar', $data_calendar);

        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function delete_calendar_list($id)
    {
        $data_calendar = array(
            'is_active' => 0
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->update('calendar', $data_calendar);

        return $query;
    }
}
