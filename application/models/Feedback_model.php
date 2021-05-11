<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_model extends CI_Model {

    public function get_employees_feedback($employee_number)
    {
        if($this->session->userdata('department_id') == 25)
        {
            $this->db->select("
                CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname,
                feedback.id as id,
                feedback.is_open as is_open,
                feedback.employee_number as employee_number,
                feedback.category as category,
                feedback.created_date as date,
                feedback.comment as comment,
                feedback.number_comment as number_comment,
                feedback.title as title
            ");

            $this->db->from('blaine_feedback.feedback');
            $this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_feedback.feedback.employee_number');
            
            $query= $this->db->get();

            return $query->result();
        }
        else
        {
            $this->db->select("
            CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname,
            feedback.id as id,
            feedback.employee_number as employee_number,
            feedback.category as category,
            feedback.created_date as date,
            feedback.comment as comment
        ");

        $this->db->from('blaine_feedback.feedback');
        $this->db->where('blaine_feedback.feedback.employee_number', $employee_number);
        $this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_feedback.feedback.employee_number');
        $query= $this->db->get();

        return $query->result();
        }
       
    }

    public function get_employee_feedback($id)
    {
        $this->db->select("
            feedback.id as id,
            feedback.category as category,
            feedback.number_comment as number_comment,
            feedback.title as title
        ");

        $this->db->from('blaine_feedback.feedback');
        $this->db->where('blaine_feedback.feedback.id', $id);
        $this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_feedback.feedback.employee_number');
        $query= $this->db->get();

        return $query->row();
    }

    public function get_employees_comment($id)
    {
        $this->db->select("
            CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) AS fullname,
            comment_list.comment as comment,
            comment_list.file as file,
            comment_list.created_date as date

        ");
        $this->db->from('blaine_feedback.comment_list');
        $this->db->where('blaine_feedback.comment_list.feedback_id', $id);
        $this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_feedback.comment_list.employee_number');
        $query= $this->db->get();

        return $query->result();
    }
    public function add_feedback()
    {
        $this->db->trans_start();
        $category = $this->input->post('category');
        $title = $this->input->post('title');
        $remarks = $this->input->post('remarks');
        $attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);
        $date = date('Y-m-d H:i:s');

        $data = array(
            'employee_number' => $this->session->userdata('employee_number'),
            'category'        => $category,
            'title'           => $title,
            'comment'         => $remarks,
            'number_comment'  => 1,
            'created_date'    => $date,
            'created_by'      => $this->session->userdata('username')
        );

        $blaine_feedback = $this->load->database('blaine_feedback', TRUE);
        $blaine_feedback->insert('feedback', $data);

        // GET LAST DATA
        $this->db->select('blaine_feedback.feedback.id as id');
        $this->db->order_by('blaine_feedback.feedback.id', 'DESC');
		$datas = $this->db->get('blaine_feedback.feedback');
        $id = $datas->row()->id;

        $data_comment = array(
            'feedback_id'     => $id,
            'employee_number' => $this->session->userdata('employee_number'),
            'comment'         => $remarks,
            'file'            => $attach1,
            'created_date'    => $date,
            'created_by'      => $this->session->userdata('username')
        );  
        
        $blaine_feedback = $this->load->database('blaine_feedback', TRUE);
        $blaine_feedback->insert('comment_list', $data_comment);

        $logs_data = array (
            'username' => $this->session->userdata('username'),
            'activity' => "Entry Added",
            'pc_ip'    => $_SERVER['REMOTE_ADDR'],
            'type'     => 'E-FEEDBACK',
            'date'     => $date
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $logs_data);

        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function add_comment()
    {
        $this->db->trans_start();
        $feedback_id = $this->input->post('feedback_id');
        $remarks = $this->input->post('remarks');
        $attachment1 = $_FILES['data1']['name'];
		$attach1 = str_replace(' ', '_', $attachment1);
        $date = date('Y-m-d H:i:s');
        $number_comment = $this->input->post('number_comment');
        
        $plus_comment = $number_comment + 1;

        $data = array(
            'feedback_id'     => $feedback_id,
            'employee_number' => $this->session->userdata('employee_number'),
            'comment'         => $remarks,
            'file'            => $attach1,
            'created_date'    => $date,
            'created_by'      => $this->session->userdata('username')
        );

        $blaine_feedback = $this->load->database('blaine_feedback', TRUE);
        $blaine_feedback->insert('comment_list', $data);

        $data_comment = array(
            'number_comment' => $plus_comment
        );
        
        $blaine_feedback = $this->load->database('blaine_feedback', TRUE);
        $blaine_feedback->where('feedback.id', $feedback_id);
        $blaine_feedback->update('feedback', $data_comment);

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        
        $entry_data ="added a comment on feedback:" . $feedback_id;

        $activity_data = array(
            'username'      => $this->session->userdata('username'),
            'pcname'        => $_SERVER['REMOTE_ADDR'],
            'entry_data'    => $entry_data,
            'entry_date'    => $date
        );
        $activity_log->insert('feedback_logs', $activity_data);

        // BLAINE LOGS

        $logs_data = array (
            'username' => $this->session->userdata('username'),
            'activity' => "Comment Added On Feedback: " . $feedback_id,
            'pc_ip'    => $_SERVER['REMOTE_ADDR'],
            'type'     => 'E-FEEDBACK',
            'date'     => $date
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $logs_data);

        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function update_to_hold_feedback($id)
    {
        $data = array(
            'is_open' => 2
        );

        $blaine_feedback = $this->load->database('blaine_feedback', TRUE);
        $blaine_feedback->where('id', $id);
        $query = $blaine_feedback->update('feedback', $data);

        return $query;
    }

    public function update_to_close_feedback($id)
    {
        $data = array(
            'is_open'    => 0,
            'close_date' => date('Y-m-d H:i:s'),
            'close_by'   => $this->session->userdata('username')
        );

        $blaine_feedback = $this->load->database('blaine_feedback', TRUE);
        $blaine_feedback->where('id', $id);
        $query = $blaine_feedback->update('feedback', $data);

        return $query;
    }

}    