<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends CI_Model {

    public function get_logs()
	{
		$activity_logs = $this->load->database('activity_logs', TRUE); 
        $activity_logs->order_by('date', 'DESC');
        $query = $activity_logs->get('blaine_logs');


        return $query->result();
	}
}
