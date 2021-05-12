<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function add_ob()
    {
        $this->db->trans_start();

        $explod_employee = explode('|', $this->input->post('employee'));
        $employee_number = $explod_employee[0];
        $department = $explod_employee[1];
        $company = $explod_employee[2];
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $destination = $this->input->post('destination');
        $purpose = $this->input->post('purpose'); 
        $transport = $this->input->post('transport');
        $plate_number = $this->input->post('plate_number');
        //$time_of_departure = $this->input->post('time_of_departure');
        //$time_of_departure_destination = $this->input->post('time_of_departure_destination');
        $remarks = $this->input->post('remarks');
        $type = $this->input->post('type');
        
        $datas = $this->report_model->get_emp_entry_ob($employee_number,$start_date, $end_date);
        $datas1 = $this->report_model->get_emp_entry_slvl($employee_number,$start_date, $end_date);
      
        /*  print_r('<pre>');
        print_r($datas);
        print_r('</pre>');
        print_r('<pre>');
        print_r($datas1);
        print_r('</pre>');*/

        $datediff = (strtotime($end_date) - strtotime($start_date));
		$num_dates = floor($datediff / (60 * 60 * 24));
		$num_dates = $num_dates + 1;

        $cur_date = $start_date;
        $count_ob = count($datas);
        $count_leave = count($datas1);
        $a = 0;

        if($count_ob != NULL)
        {
            for($k = 1; $k <= $num_dates; $k++)
            {
                if($datas[$a]->date_ob != $cur_date && $datas1[$a]->date_leave != $cur_date)
                {
                    $cur_days = date('w', strtotime($cur_date));
                    if($cur_days != 0 && $cur_days != 6)
                    {
                        if($type == "FIELD WORK")
                        {
                            $data_work = array(
                                'employee_number'  => $employee_number,
                                'date_ob'          => $cur_date,
                                'type'             => $type,
                                'company'          => $company,
                                'department'       => $department,
                                'destination'      => $destination,
                                'purpose'          => $purpose,
                                'transport'        => $transport,
                                'plate_no'         => $plate_number,
                                'created_by'       => $this->session->userdata('username'),
                                'created_date'     => date('Y-m-d H:i:s')
                            );

                            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                            $query = $blaine_timekeeping->insert('ob', $data_work);
                            /*print_r('<pre>');
                            print_r($data_work);
                            print_r('</pre>');*/
                        }
                        elseif($type == "WORK FROM HOME")
                        {
                            $data_wfh = array(
                                'employee_number'  => $employee_number,
                                'date_ob'          => $cur_date,
                                'company'          => $company,
                                'department'       => $department,
                                'type'             => $type,
                                'remarks'          => $remarks,
                                'created_by'       => $this->session->userdata('username'),
                                'created_date'     => date('Y-m-d H:i:s')
                            );

                            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                            $query = $blaine_timekeeping->insert('ob', $data_wfh);
                            /*print_r('<pre>');
                            print_r($data_wfh);
                            print_r('</pre>');*/
                        }
                    }
                
                    $conv_date = strtotime($start_date);
                    $cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));
                }
            
            }

            $this->session->set_flashdata('error_msg', 'PROCESSING ERROR DUE TO DOUBLE ENTRY!');
            redirect('reports/index_ob');
        }
        elseif($count_leave != NULL)
        {
            for($k = 1; $k <= $num_dates; $k++)
            {
                if($datas1[$a]->date_leave != $cur_date)
                {
                    $cur_days = date('w', strtotime($cur_date));
                    if($cur_days != 0 && $cur_days != 6)
                    {
                        if($type == "FIELD WORK")
                        {
                            $data_work = array(
                                'employee_number'  => $employee_number,
                                'date_ob'          => $cur_date,
                                'type'             => $type,
                                'company'          => $company,
                                'department'       => $department,
                                'destination'      => $destination,
                                'purpose'          => $purpose,
                                'transport'        => $transport,
                                'plate_no'         => $plate_number,
                                'created_by'       => $this->session->userdata('username'),
                                'created_date'     => date('Y-m-d H:i:s')
                            );

                            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                            $query = $blaine_timekeeping->insert('ob', $data_work);
                            /*print_r('<pre>');
                            print_r($data_work);
                            print_r('</pre>');*/
                        }
                        elseif($type == "WORK FROM HOME")
                        {
                            $data_wfh = array(
                                'employee_number'  => $employee_number,
                                'date_ob'          => $cur_date,
                                'company'          => $company,
                                'department'       => $department,
                                'type'             => $type,
                                'remarks'          => $remarks,
                                'created_by'       => $this->session->userdata('username'),
                                'created_date'     => date('Y-m-d H:i:s')
                            );

                            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                            $query = $blaine_timekeeping->insert('ob', $data_wfh);
                            /*print_r('<pre>');
                            print_r($data_wfh);
                            print_r('</pre>');*/
                        }
                    }
                
                    $conv_date = strtotime($start_date);
                    $cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));
                }
            
            }

            $this->session->set_flashdata('error_msg', 'PROCESSING ERROR DUE TO DOUBLE ENTRY!');
            redirect('reports/index_ob');
        }
        else
        {
            for($k = 1; $k <= $num_dates; $k++)
            {
                
                $cur_days = date('w', strtotime($cur_date));
                if($cur_days != 0 && $cur_days != 6)
                {
                    if($type == "FIELD WORK")
                    {
                        $data_work = array(
                            'employee_number'  => $employee_number,
                            'date_ob'          => $cur_date,
                            'type'             => $type,
                            'company'          => $company,
                            'department'       => $department,
                            'destination'      => $destination,
                            'purpose'          => $purpose,
                            'transport'        => $transport,
                            'plate_no'         => $plate_number,
                            'created_by'       => $this->session->userdata('username'),
                            'created_date'     => date('Y-m-d H:i:s')
                        );

                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $query = $blaine_timekeeping->insert('ob', $data_work);
                        /*print_r('<pre>');
                        print_r($data_work);
                        print_r('</pre>');*/
                    }
                    elseif($type == "WORK FROM HOME")
                    {
                        $data_wfh = array(
                            'employee_number'  => $employee_number,
                            'date_ob'          => $cur_date,
                            'company'          => $company,
                            'department'       => $department,
                            'type'             => $type,
                            'remarks'          => $remarks,
                            'created_by'       => $this->session->userdata('username'),
                            'created_date'     => date('Y-m-d H:i:s')
                        );

                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $query = $blaine_timekeeping->insert('ob', $data_wfh);
                        /*print_r('<pre>');
                        print_r($data_wfh);
                        print_r('</pre>');*/
                    }
                
                    $conv_date = strtotime($start_date);
                    $cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));
                }
               
            }

            $this->session->set_flashdata('success_msg', 'DATA SUCCESSFULLY ADDED!');
            redirect('reports/index_ob');
        }
        
          

        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function get_emp_entry_ob($employee_number,$start_date,$end_date)
    {
        $this->db->select("
            ob.id as id,
            ob.employee_number as employee_number,
            ob.date_ob as date_ob,
        ");
        $this->db->from('blaine_timekeeping.ob');
        $this->db->where('blaine_timekeeping.ob.date_ob >=', $start_date);
        $this->db->where('blaine_timekeeping.ob.date_ob <=', $end_date);
        $this->db->where('blaine_timekeeping.ob.employee_number ', $employee_number);
        $this->db->order_by('blaine_timekeeping.ob.date_ob', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_emp_entry_slvl($employee_number,$start_date,$end_date)
    {
        $this->db->select("
            slvl.id as id,
            slvl.employee_number as employee_number,
            slvl.leave_date as date_leave,
        ");
        $this->db->from('blaine_timekeeping.slvl');
        $this->db->where('blaine_timekeeping.slvl.leave_date >=', $start_date);
        $this->db->where('blaine_timekeeping.slvl.leave_date <=', $end_date);
        $this->db->where('blaine_timekeeping.slvl.employee_number ', $employee_number);
        $this->db->order_by('blaine_timekeeping.slvl.leave_date', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_employees_ob($start_date,$end_date)
    {
        $this->db->select("
            ob.id as id,
            ob.employee_number as employee_number,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            ob.date_ob as date_ob,
            ob.destination as destination,
            ob.purpose as purpose,
            ob.transport as transport,
            ob.plate_no as plate_no,
            ob.time_departure as time_departure,
            ob.time_departure_destination as time_departure_destination,
            ob.status as status,
            ob.type as type,
            ob.remarks as remarks
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
            ob.employee_number as employee_number,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            ob.date_ob as date_ob,
            ob.destination as destination,
            ob.purpose as purpose,
            ob.transport as transport,
            ob.plate_no as plate_no,
            ob.time_departure as time_departure,
            ob.time_departure_destination as time_departure_destination,
            ob.status as status,
            ob.type as type,
            ob.remarks as remarks
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
            ob.employee_number as employee_number,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            ob.date_ob as date_ob,
            ob.destination as destination,
            ob.purpose as purpose,
            ob.transport as transport,
            ob.plate_no as plate_no,
            ob.time_departure as time_departure,
            ob.time_departure_destination as time_departure_destination,
            ob.status as status,
            ob.type as type,
            ob.remarks as remarks
        ");
        $this->db->from('blaine_timekeeping.ob');
        $this->db->where('blaine_timekeeping.ob.id', $id);
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.ob.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.ob.department = blaine_intranet.department.id');
        $query = $this->db->get();

        return $query->row();
    }

    public function update_employee_ob_fw($id)
    {
        $date_ob = $this->input->post('date_of_ob');
        $destination = $this->input->post('destination');
        $purpose = $this->input->post('purpose');
        $transport = $this->input->post('transport');
        $plate_number = $this->input->post('plate_number');
        //$time_of_departure = $this->input->post('time_of_departure');
        //$time_of_departure_destination = $this->input->post('time_of_departure_destination');

        $data = array(
            'date_ob'                       => $date_ob,
            'destination'                   => $destination,
            'purpose'                       => $purpose,
            'transport'                     => $transport,
            'plate_no'                      => $plate_number,
            'updated_by'                    => $this->session->userdata('username'),
            'updated_date'                  => date('Y-m-d H:i:s')
        );
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->update('ob', $data);


        return $query;
    }

    public function update_employee_ob_wfh($id)
    {
        $date_ob = $this->input->post('date_of_ob');
        $remarks = $this->input->post('remarks');

        $data = array(
            'date_ob'      => $date_ob,
            'remarks'      => $remarks,
            'updated_by'   => $this->session->userdata('username'),
            'updated_date' => date('Y-m-d H:i:s')
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

    public function add_slvl()
    {
        $this->db->trans_start();

        $explod_data = explode('|', $this->input->post('employee'));
        $explod_type = explode('|', $this->input->post('type'));
        $employee_number = $explod_data[0];
        $department = $explod_data[1];
        $company = $explod_data[2];
        $type = $explod_type[0];
        $type_name = $explod_type[1];
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $day = $this->input->post('day');
        $address_leave = $this->input->post('address_leave');
        $reason = $this->input->post('reason');

        $datediff = (strtotime($end_date) - strtotime($start_date));
		$num_dates = floor($datediff / (60 * 60 * 24));
		$num_dates = $num_dates + 1;

        $cur_date = $start_date;

        $datas = $this->report_model->get_emp_entry_ob($employee_number,$start_date, $end_date);
        $datas1 = $this->report_model->get_emp_entry_slvl($employee_number,$start_date, $end_date);
        $count_ob = count($datas);
        $count_leave = count($datas1);
        $a = 0;

        /*print_r('<pre>');
        print_r($datas);
        print_r('</pre>');
        print_r('<pre>');
        print_r($datas1);
        print_r('</pre>');*/

        if($count_ob != NULL)
        {
            for($k = 1; $k <= $num_dates; $k++)
            {
                if($datas1[$a]->date_leave != $cur_date && $datas[$a]->date_ob != $cur_date)
                {
                    if($type != 'ML')
                    {
                        $cur_days = date('w', strtotime($cur_date));
                        if($cur_days != 0 && $cur_days != 6)
                        {
                            if($day == "WD")
                            {
                                $data = array(
                                    'employee_number' => $employee_number,
                                    'company'         => $company,
                                    'department'      => $department,
                                    'type'            => $type,
                                    'type_name'       => $type_name,
                                    'leave_date'      => $cur_date,
                                    'leave_num'       => '1',
                                    'leave_day'       => $day,
                                    'leave_address'   => $address_leave,
                                    'reason'          => $reason,
                                    'created_by'      => $this->session->userdata('username'),
                                    'created_date'    => date('Y-m-d H:i:s') 
                                );
                                
                                $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                                $blaine_timekeeping->insert('slvl', $data);
                                /*print_r('<pre>');
                                print_r($data);
                                print_r('</pre>');*/
                            }
                            else
                            {
                                $data = array(
                                    'employee_number' => $employee_number,
                                    'company'         => $company,
                                    'department'      => $department,
                                    'type'            => $type,
                                    'type_name'       => $type_name,
                                    'leave_date'      => $cur_date,
                                    'leave_address'   => $address_leave,
                                    'reason'          => $reason,
                                    'leave_num'       => '0.5',
                                    'leave_day'       => $day,
                                    'created_by'      => $this->session->userdata('username'),
                                    'created_date'    => date('Y-m-d H:i:s') 
                                );
                    
                                $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                                $blaine_timekeeping->insert('slvl', $data);
                                /*print_r('<pre>');
                                print_r($data);
                                print_r('</pre>');*/
                            }
                        }
                    }
                    else
                    {
                        if($day == "WD")
                            {
                                $data = array(
                                    'employee_number' => $employee_number,
                                    'company'         => $company,
                                    'department'      => $department,
                                    'type'            => $type,
                                    'type_name'       => $type_name,
                                    'leave_date'      => $cur_date,
                                    'leave_num'       => '1',
                                    'leave_day'       => $day,
                                    'leave_address'   => $address_leave,
                                    'reason'          => $reason,
                                    'created_by'      => $this->session->userdata('username'),
                                    'created_date'    => date('Y-m-d H:i:s') 
                                );
                                
                                $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                                $blaine_timekeeping->insert('slvl', $data);
                            }
                            else
                            {
                                $data = array(
                                    'employee_number' => $employee_number,
                                    'company'         => $company,
                                    'department'      => $department,
                                    'type'            => $type,
                                    'type_name'       => $type_name,
                                    'leave_date'      => $cur_date,
                                    'leave_address'   => $address_leave,
                                    'reason'          => $reason,
                                    'leave_num'       => '0.5',
                                    'leave_day'       => $day,
                                    'created_by'      => $this->session->userdata('username'),
                                    'created_date'    => date('Y-m-d H:i:s') 
                                );
                    
                                $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                                $blaine_timekeeping->insert('slvl', $data);
                            
                            }
                    }

                    $conv_date = strtotime($start_date);
                    $cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));

                }
            }

            $this->session->set_flashdata('error_msg', 'PROCESSING ERROR DUE TO DOUBLE ENTRY!');
            redirect('reports/index_slvl');
        }
        elseif($count_leave != NULL)
        {
            for($k = 1; $k <= $num_dates; $k++)
            {
                if($datas1[$a]->date_leave != $cur_date)
                {
                    if($type != 'ML')
                    {
                        $cur_days = date('w', strtotime($cur_date));
                        if($cur_days != 0 && $cur_days != 6)
                        {
                            if($day == "WD")
                            {
                                $data = array(
                                    'employee_number' => $employee_number,
                                    'company'         => $company,
                                    'department'      => $department,
                                    'type'            => $type,
                                    'type_name'       => $type_name,
                                    'leave_date'      => $cur_date,
                                    'leave_num'       => '1',
                                    'leave_day'       => $day,
                                    'leave_address'   => $address_leave,
                                    'reason'          => $reason,
                                    'created_by'      => $this->session->userdata('username'),
                                    'created_date'    => date('Y-m-d H:i:s') 
                                );
                                
                                $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                                $blaine_timekeeping->insert('slvl', $data);
                                /*print_r('<pre>');
                                print_r($data);
                                print_r('</pre>');*/
                            }
                            else
                            {
                                $data = array(
                                    'employee_number' => $employee_number,
                                    'company'         => $company,
                                    'department'      => $department,
                                    'type'            => $type,
                                    'type_name'       => $type_name,
                                    'leave_date'      => $cur_date,
                                    'leave_address'   => $address_leave,
                                    'reason'          => $reason,
                                    'leave_num'       => '0.5',
                                    'leave_day'       => $day,
                                    'created_by'      => $this->session->userdata('username'),
                                    'created_date'    => date('Y-m-d H:i:s') 
                                );
                    
                                $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                                $blaine_timekeeping->insert('slvl', $data);
                                /*print_r('<pre>');
                                print_r($data);
                                print_r('</pre>');*/
                            }
                        }
                    }
                    else
                    {
                        if($day == "WD")
                            {
                                $data = array(
                                    'employee_number' => $employee_number,
                                    'company'         => $company,
                                    'department'      => $department,
                                    'type'            => $type,
                                    'type_name'       => $type_name,
                                    'leave_date'      => $cur_date,
                                    'leave_num'       => '1',
                                    'leave_day'       => $day,
                                    'leave_address'   => $address_leave,
                                    'reason'          => $reason,
                                    'created_by'      => $this->session->userdata('username'),
                                    'created_date'    => date('Y-m-d H:i:s') 
                                );
                                
                                $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                                $blaine_timekeeping->insert('slvl', $data);
                            }
                            else
                            {
                                $data = array(
                                    'employee_number' => $employee_number,
                                    'company'         => $company,
                                    'department'      => $department,
                                    'type'            => $type,
                                    'type_name'       => $type_name,
                                    'leave_date'      => $cur_date,
                                    'leave_address'   => $address_leave,
                                    'reason'          => $reason,
                                    'leave_num'       => '0.5',
                                    'leave_day'       => $day,
                                    'created_by'      => $this->session->userdata('username'),
                                    'created_date'    => date('Y-m-d H:i:s') 
                                );
                    
                                $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                                $blaine_timekeeping->insert('slvl', $data);
                            
                            }
                    }

                    $conv_date = strtotime($start_date);
                    $cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));
            
                }
            }

            $this->session->set_flashdata('error_msg', 'PROCESSING ERROR DUE TO DOUBLE ENTRY!');
            redirect('reports/index_slvl');
        }
     
        else
        {
            for($k = 1; $k <= $num_dates; $k++)
            {
                if($type != 'ML')
                {
                    $cur_days = date('w', strtotime($cur_date));
                    if($cur_days != 0 && $cur_days != 6)
                    {
                        if($day == "WD")
                        {
                            $data = array(
                                'employee_number' => $employee_number,
                                'company'         => $company,
                                'department'      => $department,
                                'type'            => $type,
                                'type_name'       => $type_name,
                                'leave_date'      => $cur_date,
                                'leave_num'       => '1',
                                'leave_day'       => $day,
                                'leave_address'   => $address_leave,
                                'reason'          => $reason,
                                'created_by'      => $this->session->userdata('username'),
                                'created_date'    => date('Y-m-d H:i:s') 
                            );
                            
                            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                            $blaine_timekeeping->insert('slvl', $data);
                            /*print_r('<pre>');
                            print_r($data);
                            print_r('</pre>');*/
                        }
                        else
                        {
                            $data = array(
                                'employee_number' => $employee_number,
                                'company'         => $company,
                                'department'      => $department,
                                'type'            => $type,
                                'type_name'       => $type_name,
                                'leave_date'      => $cur_date,
                                'leave_address'   => $address_leave,
                                'reason'          => $reason,
                                'leave_num'       => '0.5',
                                'leave_day'       => $day,
                                'created_by'      => $this->session->userdata('username'),
                                'created_date'    => date('Y-m-d H:i:s') 
                            );
                
                            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                            $blaine_timekeeping->insert('slvl', $data);
                            /*print_r('<pre>');
                            print_r($data);
                            print_r('</pre>');*/
                        }
                    }
                }
                else
                {
                    if($day == "WD")
                        {
                            $data = array(
                                'employee_number' => $employee_number,
                                'company'         => $company,
                                'department'      => $department,
                                'type'            => $type,
                                'type_name'       => $type_name,
                                'leave_date'      => $cur_date,
                                'leave_num'       => '1',
                                'leave_day'       => $day,
                                'leave_address'   => $address_leave,
                                'reason'          => $reason,
                                'created_by'      => $this->session->userdata('username'),
                                'created_date'    => date('Y-m-d H:i:s') 
                            );
                            
                            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                            $blaine_timekeeping->insert('slvl', $data);
                        }
                        else
                        {
                            $data = array(
                                'employee_number' => $employee_number,
                                'company'         => $company,
                                'department'      => $department,
                                'type'            => $type,
                                'type_name'       => $type_name,
                                'leave_date'      => $cur_date,
                                'leave_address'   => $address_leave,
                                'reason'          => $reason,
                                'leave_num'       => '0.5',
                                'leave_day'       => $day,
                                'created_by'      => $this->session->userdata('username'),
                                'created_date'    => date('Y-m-d H:i:s') 
                            );
                
                            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                            $blaine_timekeeping->insert('slvl', $data);
                         
                        }
                }
               
                $conv_date = strtotime($start_date);
                $cur_date = date('Y-m-d', strtotime('+' . $k .' days', $conv_date));
            }	

            $this->session->set_flashdata('success_msg', 'DATA SUCCESSFULLY ADDED!');
            redirect('reports/index_slvl');
        }
      

        $trans = $this->db->trans_complete();
        return $trans;
       
    }

    public function get_employees_leaves()
    {
        $this->db->select("
            slvl.id as id,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            company.name as company,
            slvl.type_name as type_name,
            slvl.type as type,
            slvl.leave_day as leave_day,
            slvl.leave_date as leave_date,
            slvl.leave_num as leave_num,
            slvl.reason as reason,
            slvl.leave_address as leave_address,
            slvl.status as status
        ");
        $this->db->from('blaine_timekeeping.slvl');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.slvl.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.slvl.department = blaine_intranet.department.id');
        $this->db->join('blaine_intranet.company', 'blaine_timekeeping.slvl.company = blaine_intranet.company.id');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_employee_leave($id)
    {
        $this->db->select("
            slvl.id as id,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            company.name as company,
            slvl.type_name as type_name,
            slvl.type as type,
            slvl.leave_day as leave_day,
            slvl.leave_date as leave_date,
            slvl.leave_num as leave_num,
            slvl.reason as reason,
            slvl.leave_address as leave_address,
            slvl.status as status
        ");
        $this->db->from('blaine_timekeeping.slvl');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.slvl.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.slvl.department = blaine_intranet.department.id');
        $this->db->join('blaine_intranet.company', 'blaine_timekeeping.slvl.company = blaine_intranet.company.id');
        $this->db->where('blaine_timekeeping.slvl.id', $id);
        $query = $this->db->get();

        return $query->row();
    }


    public function get_employees_leave($start_date,$end_date)
    {
        $this->db->select("
            slvl.id as id,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            company.name as company,
            slvl.type_name as type_name,
            slvl.type as type,
            slvl.leave_day as leave_day,
            slvl.leave_date as leave_date,
            slvl.leave_num as leave_num,
            slvl.reason as reason,
            slvl.leave_address as leave_address,
            slvl.status as status
        ");
        $this->db->from('blaine_timekeeping.slvl');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.slvl.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.slvl.department = blaine_intranet.department.id');
        $this->db->join('blaine_intranet.company', 'blaine_timekeeping.slvl.company = blaine_intranet.company.id');
        $this->db->where('blaine_timekeeping.slvl.leave_date >=', $start_date);
        $this->db->where('blaine_timekeeping.slvl.leave_date <=', $end_date);
        $query = $this->db->get();

        return $query->result();
    }

    public function update_employee_leave($id)
    {
        $this->db->trans_start();

        $explod_type = explode('|', $this->input->post('type'));
        $type = $explod_type[0];
        $type_name = $explod_type[1];
        $leave_date = $this->input->post('leave_date');
        $day = $this->input->post('day');
        $address_leave = $this->input->post('address_leave');
        $reason = $this->input->post('reason');

        if($day == "WD")
        {
            $data = array(
                'type'            => $type,
                'type_name'       => $type_name,
                'leave_date'      => $leave_date,
                'leave_day'       => $day,
                'leave_address'   => $address_leave,
                'reason'          => $reason,
                'leave_num'       => '1',
                'updated_by'      => $this->session->userdata('username'),
                'updated_date'    => date('Y-m-d H:i:s') 
            );

            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
            $blaine_timekeeping->where('id', $id);
            $blaine_timekeeping->update('slvl', $data);

        }
        else
        {
            $data = array(
                'type'            => $type,
                'type_name'       => $type_name,
                'leave_date'      => $leave_date,
                'leave_day'       => $day,
                'leave_address'   => $address_leave,
                'reason'          => $reason,
                'leave_num'       => '0.5',
                'updated_by'      => $this->session->userdata('username'),
                'updated_date'    => date('Y-m-d H:i:s') 
            );

            $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
            $blaine_timekeeping->where('id', $id);
            $blaine_timekeeping->update('slvl', $data);
        }
        

        $trans = $this->db->trans_complete();

        return $trans;
    }

    public function delete_employee_leave($id)
    {
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->delete('slvl');

        return $query;
    }

    public function add_undertime()
    {
        $this->db->trans_start();

        $explod_data = explode('|', $this->input->post('employee'));
        $employee_number = $explod_data[0];
        $department = $explod_data[1];
        $company = $explod_data[2];
        $date_ut = $this->input->post('date_ut');
        $time_start = $this->input->post('time_start');
        $time_end = $this->input->post('time_end');
        $reason = $this->input->post('reason');

        // TIME START AND TIME END
        $explod_time_start = explode(':', $time_start);
        $time_start_hr = $explod_time_start[0] * 60;
        $time_start_num = $time_start_hr + $explod_time_start[1];

        $explod_time_end = explode(':', $time_end);
        $time_end_mins = $explod_time_end[0] * 60;
        $time_end_num = $time_end_mins + $explod_time_end[1];
        
        $timediff = $time_end_num - $time_start_num;
        //$total_ut = $timediff / 60;
       
        $data = array(
            'employee_number' => $employee_number,
            'company'         => $company,
            'department'      => $department,
            'date_ut'         => $date_ut,
            'time_start'      => $time_start,
            'time_end'        => $time_end,
            'ut_num'          => $timediff,
            'reason'          => $reason,
            'created_by'      => $this->session->userdata('username'),
            'created_date'    => date('Y-m-d H:i:s')
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->insert('undertime', $data);
        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/

        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function get_employees_undertime($start_date,$end_date)
    {
        $this->db->select("
            undertime.id as id,
            undertime.employee_number as employee_number,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            undertime.date_ut as date_ut,
            undertime.time_start as time_start,
            undertime.time_end as time_end,
            undertime.ut_num as ut_num,
            undertime.reason as reason,
            undertime.status as status
        ");
        $this->db->from('blaine_timekeeping.undertime');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.undertime.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.undertime.department = blaine_intranet.department.id');
        $this->db->where('blaine_timekeeping.undertime.date_ut >=', $start_date);
        $this->db->where('blaine_timekeeping.undertime.date_ut <=', $end_date);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_employees_uts()
    {
        $this->db->select("
            undertime.id as id,
            undertime.employee_number as employee_number,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            undertime.date_ut as date_ut,
            undertime.time_start as time_start,
            undertime.time_end as time_end,
            undertime.ut_num as ut_num,
            undertime.reason as reason,
            undertime.status as status
        ");
        $this->db->from('blaine_timekeeping.undertime');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.undertime.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.undertime.department = blaine_intranet.department.id');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_employee_ut($id)
    {
        $this->db->select("
            undertime.id as id,
            undertime.employee_number as employee_number,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            undertime.date_ut as date_ut,
            undertime.time_start as time_start,
            undertime.time_end as time_end,
            undertime.ut_num as ut_num,
            undertime.reason as reason,
            undertime.status as status
        ");
        $this->db->from('blaine_timekeeping.undertime');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.undertime.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.undertime.department = blaine_intranet.department.id');
        $this->db->where('blaine_timekeeping.undertime.id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function update_employee_undertime($id)
    {
        $this->db->trans_start();

        $date_ut = $this->input->post('date_ut');
        $time_start = $this->input->post('time_start');
        $time_end = $this->input->post('time_end');
        $reason = $this->input->post('reason');

        // TIME START AND TIME END
        $explod_time_start = explode(':', $time_start);
        $time_start_hr = $explod_time_start[0] * 60;
        $time_start_num = $time_start_hr + $explod_time_start[1];

        $explod_time_end = explode(':', $time_end);
        $time_end_mins = $explod_time_end[0] * 60;
        $time_end_num = $time_end_mins + $explod_time_end[1];
        
        $timediff = $time_end_num - $time_start_num;
        //$total_ut = $timediff / 60;
       
        $data = array(
            'date_ut'         => $date_ut,
            'time_start'      => $time_start,
            'time_end'        => $time_end,
            'ut_num'          => $timediff,
            'reason'          => $reason,
            'updated_by'      => $this->session->userdata('username'),
            'updated_date'    => date('Y-m-d H:i:s')
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $blaine_timekeeping->update('undertime', $data);
        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/

        $trans = $this->db->trans_complete();
        return $trans; 
    }

    public function delete_employee_undertime($id)
    {
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->delete('undertime');

        return $query;
    }

    public function add_overtime()
    {
        $this->db->trans_start();

        $explod_data = explode('|', $this->input->post('employee'));
        $employee_number = $explod_data[0];
        $department = $explod_data[1];
        $company = $explod_data[2];
        $date_ot = $this->input->post('date_ot');
        $time_start = $this->input->post('time_start');
        $time_end = $this->input->post('time_end');
        $task = $this->input->post('task');

        // TIME START AND TIME END
        $explod_time_start = explode(':', $time_start);
        $time_start_hr = $explod_time_start[0] * 60;
        $time_start_num = $time_start_hr + $explod_time_start[1];

        $explod_time_end = explode(':', $time_end);
        $time_end_mins = $explod_time_end[0] * 60;
        $time_end_num = $time_end_mins + $explod_time_end[1];
        
        $timediff = $time_end_num - $time_start_num;
        
        //Delivery Drivers Helper Collectors
        $less_daily_mins = $timediff;
        $ot_hrs = floor($less_daily_mins / 60);
        $ot_mins = $less_daily_mins % 60;

        if($ot_mins >= 30) {
            $total_ot = $ot_hrs . '.' . 30;
        } elseif($ot_mins <= 30) {
            $total_ot = $ot_hrs . '.' . 00;
        }
        $data = array(
            'employee_number' => $employee_number,
            'company'         => $company,
            'department'      => $department,
            'date_ot'         => $date_ot,
            'time_start'      => $time_start,
            'time_end'        => $time_end,
            'ot_num'          => $total_ot,
            'task'            => $task,
            'created_by'      => $this->session->userdata('username'),
            'created_date'    => date('Y-m-d H:i:s')
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->insert('overtime', $data);
        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/

        $trans = $this->db->trans_complete();
        return $trans;
        
    }

    public function update_overtime($id)
    {

        $this->db->trans_start();

        $date_ot = $this->input->post('date_ot');
        $time_start = $this->input->post('time_start');
        $time_end = $this->input->post('time_end');
        $task = $this->input->post('task');
        
        // TIME START AND TIME END
        $explod_time_start = explode(':', $time_start);
        $time_start_hr = $explod_time_start[0] * 60;
        $time_start_num = $time_start_hr + $explod_time_start[1];

        $explod_time_end = explode(':', $time_end);
        $time_end_mins = $explod_time_end[0] * 60;
        $time_end_num = $time_end_mins + $explod_time_end[1];
        
        $timediff = $time_end_num - $time_start_num;
        
        //Delivery Drivers Helper Collectors
        $less_daily_mins = $timediff;
        $ot_hrs = floor($less_daily_mins / 60);
        $ot_mins = $less_daily_mins % 60;

        if($ot_mins >= 30) {
            $total_ot = $ot_hrs . '.' . 30;
        } elseif($ot_mins <= 30) {
            $total_ot = $ot_hrs . '.' . 00;
        }
        $data = array(
            'date_ot'         => $date_ot,
            'time_start'      => $time_start,
            'time_end'        => $time_end,
            'ot_num'          => $total_ot,
            'task'            => $task,
            'updated_by'      => $this->session->userdata('username'),
            'updated_date'    => date('Y-m-d H:i:s')
        );

        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $blaine_timekeeping->update('overtime', $data);

        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function get_employees_ot($start_date,$end_date)
    {
        $this->db->select("
            overtime.id as id,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            company.name as company,
            overtime.date_ot as date_ot,
            overtime.time_start as time_start,
            overtime.time_end as time_end,
            overtime.ot_num as ot_num,
            overtime.task as task,
            overtime.status as status,
            attendance_in.time as time_in,
            attendance_out.time as time_out
        ");
        $this->db->from('blaine_timekeeping.overtime');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.overtime.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_timekeeping.attendance_in', 'blaine_timekeeping.overtime.employee_number = blaine_timekeeping.attendance_in.employee_number AND blaine_timekeeping.overtime.date_ot = blaine_timekeeping.attendance_in.date', 'left');
        $this->db->join('blaine_timekeeping.attendance_out', 'blaine_timekeeping.overtime.employee_number = blaine_timekeeping.attendance_out.employee_number AND blaine_timekeeping.overtime.date_ot = blaine_timekeeping.attendance_out.date', 'left');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.overtime.department = blaine_intranet.department.id');
        $this->db->join('blaine_intranet.company', 'blaine_timekeeping.overtime.company = blaine_intranet.company.id');
        $this->db->where('blaine_timekeeping.overtime.date_ot >=', $start_date);
        $this->db->where('blaine_timekeeping.overtime.date_ot <=', $end_date);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_employees_ots()
    {
        $this->db->select("
            overtime.id as id,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            department.name as department,
            company.name as company,
            overtime.date_ot as date_ot,
            overtime.time_start as time_start,
            overtime.time_end as time_end,
            overtime.ot_num as ot_num,
            overtime.task as task,
            overtime.status as status,
            attendance_in.time as time_in,
            attendance_out.time as time_out
        ");
        $this->db->from('blaine_timekeeping.overtime');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.overtime.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_timekeeping.attendance_in', 'blaine_timekeeping.overtime.employee_number = blaine_timekeeping.attendance_in.employee_number AND blaine_timekeeping.overtime.date_ot = blaine_timekeeping.attendance_in.date', 'left');
        $this->db->join('blaine_timekeeping.attendance_out', 'blaine_timekeeping.overtime.employee_number = blaine_timekeeping.attendance_out.employee_number AND blaine_timekeeping.overtime.date_ot = blaine_timekeeping.attendance_out.date', 'left');
        $this->db->join('blaine_intranet.department', 'blaine_timekeeping.overtime.department = blaine_intranet.department.id');
        $this->db->join('blaine_intranet.company', 'blaine_timekeeping.overtime.company = blaine_intranet.company.id');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_employee_ot($id)
    {
        $this->db->select("
            overtime.id as id,
            CONCAT(employees.last_name, ' ', employees.first_name , ' ', employees.middle_name) AS fullname,
            overtime.date_ot as date_ot,
            overtime.time_start as time_start,
            overtime.time_end as time_end,
            overtime.ot_num as ot_num,
            overtime.task as task,
            overtime.status as status
        ");
        $this->db->from('blaine_timekeeping.overtime');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.overtime.employee_number = blaine_intranet.employees.employee_number');
        $query = $this->db->get();


        return $query->row();
    }

    public function delete_employee_ot($id)
    {
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->where('id', $id);
        $query = $blaine_timekeeping->delete('overtime');

        return $query;
    }
}    