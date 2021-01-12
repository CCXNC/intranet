<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage_model extends CI_Model {
	
	public function get_announcements()
	{
		$this->db->select("*");
		$this->db->from('announcement');
		$this->db->where('category', "homepage");
	
		$query = $this->db->get();

		return $query->result();
	}
}
