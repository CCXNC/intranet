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
    $this->db->order_by('count_rank', 'DESC');

    $query = $this->db->get();

    return $query->result();
   }

   public function get_gender()
   {
       $this->db->select("gender as gender_name, COUNT(gender) as count_gender");
       $this->db->from('employees');
       $this->db->group_by('gender');
       $this->db->where('blaine_intranet.employees.is_active', 1);
       $query = $this->db->get();

       return $query->result();
   }

   public function get_department()
   {
    $this->db->select("
        department.code as department_code, 
        department.name as department_name, 
        COUNT(employment_info.department) as count_department
    ");

    $this->db->from('employment_info');
    $this->db->join('department', 'employment_info.department = department.id');
    $this->db->group_by('employment_info.department');
    $this->db->order_by('count_department', 'DESC');

    $query = $this->db->get();

    return $query->result();
   }

   public function get_employee_male()
   {
    $this->db->select("COUNT(gender) as total_male");
    $this->db->from('employees');
    $this->db->group_by('gender');
    $this->db->where('blaine_intranet.employees.is_active', 1);
    $this->db->where('gender', "Male");
    $query = $this->db->get();

    return $query->row();
   }

   public function get_employee_female()
   {
    $this->db->select("COUNT(gender) as total_female");
    $this->db->from('employees');
    $this->db->group_by('gender');
    $this->db->where('blaine_intranet.employees.is_active', 1);
    $this->db->where('gender', "Female");
    $query = $this->db->get();

    return $query->row();
   }

   public function get_total_employees()
   {
    $this->db->select("COUNT(employee_number) as total_employee");
    $this->db->from('employees');
    $this->db->where('blaine_intranet.employees.is_active', 1);
    $query = $this->db->get();

    return $query->row();
   }

    public function get_hr_employee()
	{
		$this->db->select("
		    employees.id as id,
            employees.picture as picture,
            employees.employee_number as emp_no,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
		");
		$this->db->from('blaine_intranet.employees');
        $this->db->join('blaine_intranet.employment_info', 'blaine_intranet.employment_info.employee_number = blaine_intranet.employees.employee_number');
		$this->db->order_by('blaine_intranet.employees.last_name', 'ASC');
        $this->db->where('blaine_intranet.employment_info.department', 10);
        $this->db->where('blaine_intranet.employees.is_active', 1);
		
		$query = $this->db->get();

		return $query->result();
	}


    public function get_employee_month_bday()
	{
        $recent_month = date('m');
		$this->db->select("
		    employees.id as id,
            employees.picture as picture,
            employees.employee_number as emp_no,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
		");
		$this->db->from('blaine_intranet.employees');
		$this->db->order_by('blaine_intranet.employees.last_name', 'ASC');
        $this->db->where('Month(employees.birthday)', $recent_month);
        $this->db->where('blaine_intranet.employees.is_active', 1);
		
		$query = $this->db->get();

		return $query->result();
	}

    public function get_new_hire()
	{
        $recent_month = date('m');
        $recent_year = date('Y');
		$this->db->select("
		    employees.id as id,
            employees.picture as picture,
            employees.employee_number as emp_no,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
		");
		$this->db->from('blaine_intranet.employees');
        $this->db->join('blaine_intranet.employment_info', 'blaine_intranet.employment_info.employee_number = blaine_intranet.employees.employee_number');
		$this->db->order_by('blaine_intranet.employees.last_name', 'ASC');
        $this->db->where('MONTH(employment_info.date_hired)', $recent_month);
        $this->db->where('YEAR(employment_info.date_hired)', $recent_year);
        $this->db->where('blaine_intranet.employees.is_active', 1);
		
		$query = $this->db->get();

		return $query->result();
	}

    public function get_baby_boomer()
    {
        $this->db->select("COUNT(birthday) as total_baby_boomer");
        $this->db->from('employees');
        $this->db->where('YEAR(birthday) >=', 1946);
        $this->db->where('YEAR(birthday) <=', 1964);
        $this->db->where('blaine_intranet.employees.is_active', 1);
      
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_generation_x()
    {
        $this->db->select("COUNT(birthday) as total_gen_x");
        $this->db->from('employees');
        $this->db->where('YEAR(birthday) >=', 1965);
        $this->db->where('YEAR(birthday) <=', 1980);
        $this->db->where('blaine_intranet.employees.is_active', 1);
       
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_millennials()
    {
        $this->db->select("COUNT(birthday) as total_millennials");
        $this->db->from('employees');
        $this->db->where('YEAR(birthday) >=', 1981);
        $this->db->where('YEAR(birthday) <=', 1996);
        $this->db->where('blaine_intranet.employees.is_active', 1);

        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_generation_z()
    {
        $this->db->select("COUNT(birthday) as total_gen_z");
        $this->db->from('employees');
        $this->db->where('YEAR(birthday) >=', 1997);
        $this->db->where('YEAR(birthday) <=', 2012);
        $this->db->where('blaine_intranet.employees.is_active', 1);
        
        $query = $this->db->get();
 
        return $query->row();
    }



}