<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

   public function get_rank()
   {
    $this->db->select("
        rank.name as rank_name, 
        COUNT(employment_info.rank) as count_rank
    ");

    $this->db->from('employment_info');
    $this->db->join('rank', 'employment_info.rank = rank.id');
    $this->db->group_by('employment_info.rank');

    $query = $this->db->get();

    return $query->result();
   }

   public function get_gender()
   {
       $this->db->select("gender as gender_name, COUNT(gender) as count_gender");
       $this->db->from('employees');
       $this->db->group_by('gender');
       $query = $this->db->get();

       return $query->result();
   }
}