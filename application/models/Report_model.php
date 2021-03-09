<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function add_ob()
    {
        $explod_employee = explode('|', $this->input->post('employee'));
        $employee_number = $explod_employee[0];
        $department = $explod_employee[1];
        $date_ob = $this->input->post('date_of_ob');
        $destination = $this->input->post('destination');
        $purpose = $this->input->post('purpose');
        $transport = $this->input->post('transport');
        $plate_number = $this->input->post('plate_number');
        $time_of_departure = $this->input->post('time_of_departure');
        $time_of_departure_destination = $this->input->post('time_of_departure_destination');

        $data = array(
            'employee_number'               => $employee_number,
            'date_ob'                       => $date_ob,
            'department'                    => $department,
            'destination'                   => $destination,
            'purpose'                       => $purpose,
            'transport'                     => $transport,
            'plate_no'                      => $plate_number,
            'time_departure'                => $time_of_departure,
            'time_departure_destination'    => $time_of_departure_destination,
            'created_by'                    => $this->session->userdata('username'),
            'created_date'                  => date('Y-m-d H:i:s')
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $query = $blaine_timekeeping->insert('ob', $data);
        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/

        return $query;

    }

    public function get_employees_ob($start_date,$end_date)
    {
        $this->db->select("
            ob.id as id,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            ob.date_ob as date_ob,
            ob.destination as destination,
            ob.purpose as purpose,
            ob.transport as transport,
            ob.plate_no as plate_no,
            ob.time_departure as time_departure,
            ob.time_departure_destination as time_departure_destination
        ");
        $this->db->from('blaine_timekeeping.ob');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.ob.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.ob.department = blaine_intranet.department.id');
        $this->db->where('blaine_timekeeping.ob.date_ob >=', $start_date);
        $this->db->where('blaine_timekeeping.ob.date_ob <=', $end_date);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_employees_obs()
    {
        $this->db->select("
            ob.id as id,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            ob.date_ob as date_ob,
            ob.destination as destination,
            ob.purpose as purpose,
            ob.transport as transport,
            ob.plate_no as plate_no,
            ob.time_departure as time_departure,
            ob.time_departure_destination as time_departure_destination
        ");
        $this->db->from('blaine_timekeeping.ob');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.ob.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.ob.department = blaine_intranet.department.id');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_employee_ob($id)
    {
        $this->db->select("
            ob.id as id,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            ob.date_ob as date_ob,
            ob.destination as destination,
            ob.purpose as purpose,
            ob.transport as transport,
            ob.plate_no as plate_no,
            ob.time_departure as time_departure,
            ob.time_departure_destination as time_departure_destination
        ");
        $this->db->from('blaine_timekeeping.ob');
        $this->db->where('blaine_timekeeping.ob.id', $id);
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.ob.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.ob.department = blaine_intranet.department.id');
        $query = $this->db->get();

        return $query->row();
    }

    public function update_employee_ob($id)
    {
        $date_ob = $this->input->post('date_of_ob');
        $destination = $this->input->post('destination');
        $purpose = $this->input->post('purpose');
        $transport = $this->input->post('transport');
        $plate_number = $this->input->post('plate_number');
        $time_of_departure = $this->input->post('time_of_departure');
        $time_of_departure_destination = $this->input->post('time_of_departure_destination');

        $data = array(
            'date_ob'                       => $date_ob,
            'destination'                   => $destination,
            'purpose'                       => $purpose,
            'transport'                     => $transport,
            'plate_no'                      => $plate_number,
            'time_departure'                => $time_of_departure,
            'time_departure_destination'    => $time_of_departure_destination,
            'updated_by'                    => $this->session->userdata('username'),
            'updated_date'                  => date('Y-m-d H:i:s')
        );
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->update('ob', $data);


        return $query;
    }

    public function delete_employee_ob($id)
    {
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->delete('ob');

        return $query;
    }

}    