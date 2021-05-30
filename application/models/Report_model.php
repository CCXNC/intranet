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

                        // ACTIVITY LOGS
                        $data_logs = array(
                            'username'  => $this->session->userdata('username'),
                            'activity'  => "Entry Added: Employee Number: " . $employee_number,
                            'pc_ip'     => $_SERVER['REMOTE_ADDR'],
                            'type'      => 'TIMEKEEPING: FIELD WORK',
                            'date'      => date('Y-m-d H:i:s')
                        );

                        $activity_log = $this->load->database('activity_logs', TRUE);
                        $activity_log->insert('blaine_logs', $data_logs);

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

                        // ACTIVITY LOGS
                        $data_logs = array(
                            'username'  => $this->session->userdata('username'),
                            'activity'  => "Entry Added: Employee Number: " . $employee_number,
                            'pc_ip'     => $_SERVER['REMOTE_ADDR'],
                            'type'      => 'TIMEKEEPING: WORK FROM HOME',
                            'date'      => date('Y-m-d H:i:s')
                        );

                        $activity_log = $this->load->database('activity_logs', TRUE);
                        $activity_log->insert('blaine_logs', $data_logs);
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

        // GET OLD DATA BEFORE UPDATE
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->select('*');
        $blaine_timekeeping->where('id', $id);
        $datas = $blaine_timekeeping->get('ob');
        $employee_fw_id = $datas->row()->id;
        $employee_fw_employee_number = $datas->row()->employee_number;
        $employee_fw_date_ob = $datas->row()->date_ob;
        $employee_fw_destination = $datas->row()->destination;
        $employee_fw_purpose = $datas->row()->purpose;
        $employee_fw_transport = $datas->row()->transport;
        $employee_fw_plate_number = $datas->row()->plate_number;

        $entry_data = array(
            'id'            => $employee_fw_id,
            'date_ob'       => $employee_fw_date_ob,
            'destination'   => $employee_fw_destination,
            'purpose'       => $employee_fw_purpose,
            'transport'     => $employee_fw_transport,
            'plate_number'  => $employee_fw_plate_number

        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'  => $this->session->userdata('username'),
            'activity'  => "Entry Updated: " . 'Employee Number: ' . $employee_fw_employee_number,
            'datas'     => "Previous Data: " . $json_data,
            'pc_ip'     => $_SERVER['REMOTE_ADDR'],
            'type'      => 'TIMEKEEPING: FIELD WORK',
            'date'      => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        // PROCESS FOR UPDATE
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

        // GET OLD DATA BEFORE UPDATE
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->select('*');
        $blaine_timekeeping->where('id', $id);
        $datas = $blaine_timekeeping->get('ob');
        $employee_wfh_id = $datas->row()->id;
        $employee_wfh_employee_number = $datas->row()->employee_number;
        $employee_wfh_date_ob = $datas->row()->date_ob;
        $employee_wfh_remarks = $datas->row()->remarks;

        $entry_data = array(
            'id'        => $employee_wfh_id,
            'date_ob'   => $employee_wfh_date_ob,
            'remarks'   => $employee_wfh_remarks
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'  => $this->session->userdata('username'),
            'activity'  => "Entry Updated: " . 'Employee Number: ' . $employee_wfh_employee_number,
            'datas'     => "Previous Data: " . $json_data,
            'pc_ip'     => $_SERVER['REMOTE_ADDR'],
            'type'      => 'TIMEKEEPING: WORK FROM HOME',
            'date'      => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        // PROCESS FOR UPDATE
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
        $blaine_timekeeping->select('*');
        $blaine_timekeeping->where('id', $id);
        $datas = $blaine_timekeeping->get('ob');
        $employee_ob_id = $datas->row()->id;
        $employee_ob_employee_number = $datas->row()->employee_number;
        $employee_ob_date_ob = $datas->row()->date_ob;
        $employee_ob_type = $datas->row()->type;
        $employee_ob_remarks = $datas->row()->remarks;
        $employee_ob_destination = $datas->row()->destination;
        $employee_ob_purpose = $datas->row()->purpose;
        $employee_ob_transport = $datas->row()->transport;
        $employee_ob_plate_no = $datas->row()->plate_no;

        $entry_data = array(
            'id'            => $employee_ob_id,
            'date_ob'       => $employee_ob_date_ob,
            'type'          => $employee_ob_type,
            'remarks'       => $employee_ob_remarks,
            'destination'   => $employee_ob_destination,
            'purpose'       => $employee_ob_purpose,
            'transport'     => $employee_ob_transport,
            'plate_no'      => $employee_ob_plate_no
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Deleted: " . "ID: " . $employee_ob_id . " Employee Number: " . $employee_ob_employee_number,
            'datas'         => $json_data,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => "TIMEKEEPING: FIELD WORK/WORK FROM HOME",
            'date'          => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);
       
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

                            // ACTIVITY LOGS
                            $data_logs = array(
                                'username'  => $this->session->userdata('username'),
                                'activity'  => "Entry Added: Employee Number: " . $employee_number,
                                'pc_ip'     => $_SERVER['REMOTE_ADDR'],
                                'type'      => 'TIMEKEEPING: LEAVE OF ABSENCE',
                                'date'      => date('Y-m-d H:i:s')
                            );

                            $activity_log = $this->load->database('activity_logs', TRUE);
                            $activity_log->insert('blaine_logs', $data_logs);
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

                            // ACTIVITY LOGS
                            $data_logs = array(
                                'username'  => $this->session->userdata('username'),
                                'activity'  => "Entry Added: Employee Number: " . $employee_number,
                                'pc_ip'     => $_SERVER['REMOTE_ADDR'],
                                'type'      => 'TIMEKEEPING: LEAVE OF ABSENCE',
                                'date'      => date('Y-m-d H:i:s')
                            );

                            $activity_log = $this->load->database('activity_logs', TRUE);
                            $activity_log->insert('blaine_logs', $data_logs);
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
                        
                            // ACTIVITY LOGS
                            $data_logs = array(
                                'username'  => $this->session->userdata('username'),
                                'activity'  => "Entry Added: Employee Number: " . $employee_number,
                                'pc_ip'     => $_SERVER['REMOTE_ADDR'],
                                'type'      => 'TIMEKEEPING: LEAVE OF ABSENCE',
                                'date'      => date('Y-m-d H:i:s')
                            );

                            $activity_log = $this->load->database('activity_logs', TRUE);
                            $activity_log->insert('blaine_logs', $data_logs);
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
                         
                            // ACTIVITY LOGS
                            $data_logs = array(
                                'username'  => $this->session->userdata('username'),
                                'activity'  => "Entry Added: Employee Number: " . $employee_number,
                                'pc_ip'     => $_SERVER['REMOTE_ADDR'],
                                'type'      => 'TIMEKEEPING: LEAVE OF ABSENCE',
                                'date'      => date('Y-m-d H:i:s')
                            );
                            
                            $activity_log = $this->load->database('activity_logs', TRUE);
                            $activity_logs->insert('blaine_logs', $data_logs);
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

        // GET OLD DATA BEFORE UPDATE
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->select('*');
        $blaine_timekeeping->where('id', $id);
        $datas = $blaine_timekeeping->get('slvl');
        $employee_leave_id = $datas->row()->id;
        $employee_leave_employee_number = $datas->row()->employee_number;
        $employee_leave_type = $datas->row()->type;
        $employee_leave_type_name = $datas->row()->type_name;
        $employee_leave_leave_date = $datas->row()->leave_date;
        $employee_leave_leave_day = $datas->row()->leave_day;
        $employee_leave_leave_address = $datas->row()->leave_address;
        $employee_leave_reason = $datas->row()->reason;
        $employee_leave_leave_num = $datas->row()->leave_num;

        // PROCESS FOR UPDATE
        if($day == "WD")
        {

            $entry_data = array(
                'id'                => $employee_leave_id,
                'type'              => $employee_leave_type,
                'type_name'         => $employee_leave_type_name,
                'leave_date'        => $employee_leave_leave_date,
                'leave_day'         => $employee_leave_leave_day,
                'leave_address'     => $employee_leave_leave_address,
                'reason'            => $employee_leave_reason,
                'leave_num'         => $employee_leave_leave_num
            );
    
            $json_data = json_encode($entry_data);
    
            $data_logs = array(
                'username'  => $this->session->userdata('username'),
                'activity'  => "Entry Updated: Employee Number: " . $employee_leave_employee_number,
                'datas'     => "Previous Data: " . $json_data,
                'pc_ip'     => $_SERVER['REMOTE_ADDR'],
                'type'      => 'TIMEKEEPING: LEAVE OF ABSENCE',
                'date'      => date('Y-m-d H:i:s')
            );
    
            // CALL ACTIVITY LOGS DATABASE
            $activity_log = $this->load->database('activity_logs', TRUE);
            $activity_log->insert('blaine_logs', $data_logs);
        
            // PROCESS FOR UPDATE
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
            $entry_data = array(
                'id'                => $employee_leave_id,
                'type'              => $employee_leave_type,
                'type_name'         => $employee_leave_type_name,
                'leave_date'        => $employee_leave_leave_date,
                'leave_day'         => $employee_leave_leave_day,
                'leave_address'     => $employee_leave_leave_address,
                'reason'            => $employee_leave_reason,
                'leave_num'         => $employee_leave_leave_num
            );
    
            $json_data = json_encode($entry_data);
    
            $data_logs = array(
                'username'  => $this->session->userdata('username'),
                'activity'  => "Entry Updated: Employee Number: " . $employee_leave_employee_number,
                'datas'     => "Previous Data: " . $json_data,
                'pc_ip'     => $_SERVER['REMOTE_ADDR'],
                'type'      => 'TIMEKEEPING: LEAVE OF ABSENCE',
                'date'      => date('Y-m-d H:i:s')
            );
    
            // CALL ACTIVITY LOGS DATABASE
            $activity_log = $this->load->database('activity_logs', TRUE);
            $activity_log->insert('blaine_logs', $data_logs);
        
            // PROCESS FOR UPDATE
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
        $blaine_timekeeping->select('*');
        $blaine_timekeeping->where('id', $id);
        $datas = $blaine_timekeeping->get('slvl');
        $employee_leave_id = $datas->row()->id;
        $employee_leave_employee_number = $datas->row()->employee_number;
        $employee_leave_type = $datas->row()->type;
        $employee_leave_type_name = $datas->row()->type_name;
        $employee_leave_leave_date = $datas->row()->leave_date;
        $employee_leave_leave_day = $datas->row()->leave_day;
        $employee_leave_leave_address = $datas->row()->leave_address;
        $employee_leave_reason = $datas->row()->reason;
        $employee_leave_leave_num = $datas->row()->leave_num;

        $entry_data = array(
            'id'                => $employee_leave_id,
            'type'              => $employee_leave_type,
            'type_name'         => $employee_leave_type_name,
            'leave_date'        => $employee_leave_leave_date,
            'leave_day'         => $employee_leave_leave_day,
            'leave_address'     => $employee_leave_leave_address,
            'reason'            => $employee_leave_reason,
            'leave_num'         => $employee_leave_leave_num
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'          => $this->session->userdata('username'),
            'activity'          => "Entry Deleted: " . "ID: " . $employee_leave_id . " Employee Number: " . $employee_leave_employee_number,
            'datas'             => "Deleted Data: " . $json_data,
            'pc_ip'             => $_SERVER['REMOTE_ADDR'],
            'type'              => "TIMEKEEPING: LEAVE OF ABSENCE",
            'date'              => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

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

        // ACTIVITY LOGS
        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Added: Employee Number: " . $employee_number,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'TIMEKEEPING: UNDERTIME',
            'date'          => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOG DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

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

        // GET DATA BEFORE UPDATE
        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
        $blaine_timekeeping->select('*');
        $blaine_timekeeping->where('id', $id);
        $datas = $blaine_timekeeping->get('undertime');
        $employee_undertime_id = $datas->row()->id;
        $employee_undertime_employee_number = $datas->row()->employee_number;
        $employee_undertime_date_ut = $datas->row()->date_ut;
        $employee_undertime_time_start = $datas->row()->time_start;
        $employee_undertime_time_end = $datas->row()->time_end;
        $employee_undertime_ut_num = $datas->row()->ut_num;
        $employee_undertime_reason = $datas->row()->reason;

        $entry_data = array(
            'id'            => $employee_undertime_id,
            'date_ut'       => $employee_undertime_date_ut,
            'time_start'    => $employee_undertime_time_start,
            'time_end'      => $employee_undertime_time_end,
            'ut_num'        => $employee_undertime_ut_num,
            'reason'        => $employee_undertime_reason
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Updated: " . 'Employee Number: ' . $employee_undertime_employee_number,
            'datas'         => "Previous Data: " . $json_data,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'TIMEKEEPING: UNDERTIME',
            'date'          => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);
       
        // PROCESS FOR UPDATE
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
        $blaine_timekeeping->select('*');
        $blaine_timekeeping->where('id', $id);
        $datas = $blaine_timekeeping->get('undertime');
        $employee_undertime_id = $datas->row()->id;
        $employee_undertime_employee_number = $datas->row()->employee_number;
        $employee_undertime_date_ut = $datas->row()->date_ut;
        $employee_undertime_time_start = $datas->row()->time_start;
        $employee_undertime_time_end = $datas->row()->time_end;
        $employee_undertime_ut_num = $datas->row()->ut_num;
        $employee_undertime_reason = $datas->row()->reason;

        $entry_data = array(
            'id'            => $employee_undertime_id,
            'date_ut'       => $employee_undertime_date_ut,
            'time_start'    => $employee_undertime_time_start,
            'time_end'      => $employee_undertime_time_end,
            'ut_num'        => $employee_undertime_ut_num,
            'reason'        => $employee_undertime_reason
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Deleted: " . "ID: " . $employee_undertime_id . " Employee Number: " . $employee_undertime_employee_number,
            'datas'         => "Deleted Data: " . $json_data,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => "TIMEKEEPING: UNDERTIME",
            'date'          => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

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
        $ot_type = $this->input->post('ot_type');
        $no_less_hour = $this->input->post('no_less_hour');
        $i = 0;
        foreach($ot_type as $type)
        {
            // TIME START AND TIME END
            $explod_time_start = explode(':', $time_start[$i]);
            $time_start_hr = $explod_time_start[0] * 60;
            $time_start_num = $time_start_hr + $explod_time_start[1];

            $explod_time_end = explode(':', $time_end[$i]);
            $time_end_mins = $explod_time_end[0] * 60;
            $time_end_num = $time_end_mins + $explod_time_end[1];
            
            $timediff = $time_end_num - $time_start_num;

            $w_date = date('w', strtotime($date_ot[$i]));
        
            if($type == "RD" || $type == "RH" || $type == "SH")
            {
                if($timediff > 480)
                {
                    if($no_less_hour[$i] != 1)
                    {
                        $less_one_hour = $timediff - 60;
                        $sot = 1;

                        $total_ot = '8.0';
                        
                        $rdot_less_rd = $less_one_hour - 480;
                        $rdot_hrs = floor($rdot_less_rd / 60);
                        $rdot_mins = $rdot_less_rd % 60;

                        $total_rdot = $rdot_hrs . '.' . $rdot_mins;
                        /*if($rdot_mins >= 30) {
                            $total_rdot = $rdot_hrs . '.' . 30;
                        } elseif($rdot_mins <= 30) {
                            $total_rdot = $rdot_hrs . '.' . 00;
                        }*/

                        $data = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $type,
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data);
                        /*print_r('<pre>');
                        print_r($data);
                        print_r('</pre>');*/
                        
                        if($type == "RD")
                        {
                            $ot_excess_name = "RDOT";
                        } 
                        elseif($type == "RH")
                        {
                            $ot_excess_name = "RHOT";
                        }
                        elseif($type == "SH")
                        {
                            $ot_excess_name = "SHOT";
                        }
                        
                        $data1 = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $ot_excess_name,
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data1);
                        /*print_r('<pre>');
                        print_r($data1);
                        print_r('</pre>');*/
                    } 
                    else
                    {
                        $less_one_hour = $timediff;
                        $sot = 1;

                        $total_ot = '8.0';
                        
                        $rdot_less_rd = $less_one_hour - 480;
                        $rdot_hrs = floor($rdot_less_rd / 60);
                        $rdot_mins = $rdot_less_rd % 60;

                        $total_rdot = $rdot_hrs . '.' . $rdot_mins;
                        /*if($rdot_mins >= 30) {
                            $total_rdot = $rdot_hrs . '.' . 30;
                        } elseif($rdot_mins <= 30) {
                            $total_rdot = $rdot_hrs . '.' . 00;
                        }*/

                        $data = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $type,
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data);
                        /*print_r('<pre>');
                        print_r($data);
                        print_r('</pre>');*/

                        if($type == "RD")
                        {
                            $ot_excess_name = "RDOT";
                        } 
                        elseif($type == "RH")
                        {
                            $ot_excess_name = "RHOT";
                        }
                        elseif($type == "SH")
                        {
                            $ot_excess_name = "SHOT";
                        }
        
                        $data1 = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $ot_excess_name,
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data1);
                        /*print_r('<pre>');
                        print_r($data1);
                        print_r('</pre>');*/
                    }
                }
                else
                {
                    if($no_less_hour[$i] != 1)
                    {
                        $less_one_hour = $timediff - 60;
                        $sot = 1;
                    }
                    else
                    {
                        $less_one_hour = $timediff;
                        $sot = 0;
                    }    
                        $ot_hrs = floor($less_one_hour / 60);
                        $ot_mins = $less_one_hour % 60;

                        $total_ot = $ot_hrs . '.' . $ot_mins;
                        /*if($ot_mins >= 30) {
                            $total_ot = $ot_hrs . '.' . 30;
                        } elseif($ot_mins <= 30) {
                            $total_ot = $ot_hrs . '.' . 00;
                        }*/

                        $data = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $type,
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data);
                        /*print_r('<pre>');
                        print_r($data);
                        print_r('</pre>');*/
                      
                    
                }
            }
            elseif($type == "RD|RH")
            {
                $explod_type = explode("|", $type);
                //print_r($explod_type[0] . '|' . $explod_type[1]);
               
                if($timediff > 480)
                {
                    if($no_less_hour[$i] != 1)
                    {
                        $less_one_hour = $timediff - 60;
                        $sot = 1;

                        $total_ot = '8.0';
                        
                        $rdot_less_rd = $less_one_hour - 480;
                        $rdot_hrs = floor($rdot_less_rd / 60);
                        $rdot_mins = $rdot_less_rd % 60;

                        $total_rdot = $rdot_hrs . '.' . $rdot_mins;
                        /*if($rdot_mins >= 30) {
                            $total_rdot = $rdot_hrs . '.' . 30;
                        } elseif($rdot_mins <= 30) {
                            $total_rdot = $rdot_hrs . '.' . 00;
                        }*/

                        $data_rd = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[0],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rd);
                        /*print_r('<pre>');
                        print_r($data_rd);
                        print_r('</pre>');*/

                        $data_rh = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[1],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rh);
                        /*print_r('<pre>');
                        print_r($data_rh);
                        print_r('</pre>');*/
                        
                        $data_rdot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "RDOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rdot);
                        /*print_r('<pre>');
                        print_r($data_rdot);
                        print_r('</pre>');*/

                        $data_rhot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "RHOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rhot);
                        /*print_r('<pre>');
                        print_r($data_rhot);
                        print_r('</pre>');*/
                    } 
                    else
                    {
                        $less_one_hour = $timediff;
                        $sot = 1;

                        $total_ot = '8.0';
                        
                        $rdot_less_rd = $less_one_hour - 480;
                        $rdot_hrs = floor($rdot_less_rd / 60);
                        $rdot_mins = $rdot_less_rd % 60;

                        $total_rdot = $rdot_hrs . '.' . $rdot_mins;
                        /*if($rdot_mins >= 30) {
                            $total_rdot = $rdot_hrs . '.' . 30;
                        } elseif($rdot_mins <= 30) {
                            $total_rdot = $rdot_hrs . '.' . 00;
                        }*/

                        $data_rd = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[0],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rd);
                        /*print_r('<pre>');
                        print_r($data_rd);
                        print_r('</pre>');*/

                        $data_rh = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[1],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rh);
                        /*print_r('<pre>');
                        print_r($data_rh);
                        print_r('</pre>');*/
                        
                        $data_rdot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "RDOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rdot);
                        /*print_r('<pre>');
                        print_r($data_rdot);
                        print_r('</pre>');*/

                        $data_rhot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "RHOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rhot);
                        /*print_r('<pre>');
                        print_r($data_rhot);
                        print_r('</pre>');*/
                    }
                }
                else
                {
                    if($no_less_hour[$i] != 1)
                    {
                        $less_one_hour = $timediff - 60;
                        $sot = 1;
                    }
                    else
                    {
                        $less_one_hour = $timediff;
                        $sot = 0;
                    }    
                    $ot_hrs = floor($less_one_hour / 60);
                    $ot_mins = $less_one_hour % 60;

                    $total_ot = $ot_hrs . '.' . $ot_mins;
                    /*if($ot_mins >= 30) {
                        $total_ot = $ot_hrs . '.' . 30;
                    } elseif($ot_mins <= 30) {
                        $total_ot = $ot_hrs . '.' . 00;
                    }*/

                    $data_rd = array(
                        'employee_number' => $employee_number,
                        'company'         => $company,
                        'department'      => $department,
                        'type'            => $explod_type[0],
                        'day'             => 'wd',
                        'date_ot'         => $date_ot[$i],
                        'time_start'      => $time_start[$i],
                        'time_end'        => $time_end[$i],
                        'sot'             => $sot,
                        'ot_num'          => $total_ot,
                        'task'            => $task[$i],
                        'created_by'      => $this->session->userdata('username'),
                        'created_date'    => date('Y-m-d H:i:s')
                    );
    
                    $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                    $blaine_timekeeping->insert('overtime', $data_rd);
                    /*print_r('<pre>');
                    print_r($data_rd);
                    print_r('</pre>');*/

                    $data_rh = array(
                        'employee_number' => $employee_number,
                        'company'         => $company,
                        'department'      => $department,
                        'type'            => $explod_type[1],
                        'day'             => 'wd',
                        'date_ot'         => $date_ot[$i],
                        'time_start'      => $time_start[$i],
                        'time_end'        => $time_end[$i],
                        'sot'             => $sot,
                        'ot_num'          => $total_ot,
                        'task'            => $task[$i],
                        'created_by'      => $this->session->userdata('username'),
                        'created_date'    => date('Y-m-d H:i:s')
                    );
    
                    $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                    $blaine_timekeeping->insert('overtime', $data_rh);
                    /*print_r('<pre>');
                    print_r($data_rh);
                    print_r('</pre>');*/
                    
                }
               
            }
            elseif($type == "RD|SH")
            {
                $explod_type = explode("|", $type);
                //print_r($explod_type[0] . '|' . $explod_type[1]);
               
                if($timediff > 480)
                {
                    if($no_less_hour[$i] != 1)
                    {
                        $less_one_hour = $timediff - 60;
                        $sot = 1;

                        $total_ot = '8.0';
                        
                        $rdot_less_rd = $less_one_hour - 480;
                        $rdot_hrs = floor($rdot_less_rd / 60);
                        $rdot_mins = $rdot_less_rd % 60;

                        $total_rdot = $rdot_hrs . '.' . $rdot_mins;
                        /*if($rdot_mins >= 30) {
                            $total_rdot = $rdot_hrs . '.' . 30;
                        } elseif($rdot_mins <= 30) {
                            $total_rdot = $rdot_hrs . '.' . 00;
                        }*/

                        $data_rd = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[0],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rd);
                        /*print_r('<pre>');
                        print_r($data_rd);
                        print_r('</pre>');*/

                        $data_rh = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[1],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rh);
                        /*print_r('<pre>');
                        print_r($data_rh);
                        print_r('</pre>');*/
                        
                        $data_rdot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "RDOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rdot);
                        /*print_r('<pre>');
                        print_r($data_rdot);
                        print_r('</pre>');*/

                        $data_rhot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "SHOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rhot);
                        /*print_r('<pre>');
                        print_r($data_rhot);
                        print_r('</pre>');*/
                    } 
                    else
                    {
                        $less_one_hour = $timediff;
                        $sot = 1;

                        $total_ot = '8.0';
                        
                        $rdot_less_rd = $less_one_hour - 480;
                        $rdot_hrs = floor($rdot_less_rd / 60);
                        $rdot_mins = $rdot_less_rd % 60;

                        $total_rdot = $rdot_hrs . '.' . $rdot_mins;
                        /*if($rdot_mins >= 30) {
                            $total_rdot = $rdot_hrs . '.' . 30;
                        } elseif($rdot_mins <= 30) {
                            $total_rdot = $rdot_hrs . '.' . 00;
                        }*/

                        $data_rd = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[0],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rd);
                        /*print_r('<pre>');
                        print_r($data_rd);
                        print_r('</pre>');*/

                        $data_rh = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[1],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rh);
                        /*print_r('<pre>');
                        print_r($data_rh);
                        print_r('</pre>');*/
                        
                        $data_rdot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "RDOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rdot);
                        /*print_r('<pre>');
                        print_r($data_rdot);
                        print_r('</pre>');*/

                        $data_rhot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "SHOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rhot);
                        /*print_r('<pre>');
                        print_r($data_rhot);
                        print_r('</pre>');*/
                    }
                }
                else
                {
                    if($no_less_hour[$i] != 1)
                    {
                        $less_one_hour = $timediff - 60;
                        $sot = 1;
                    }
                    else
                    {
                        $less_one_hour = $timediff;
                        $sot = 0;
                    }    
                    $ot_hrs = floor($less_one_hour / 60);
                    $ot_mins = $less_one_hour % 60;

                    $total_ot = $ot_hrs . '.' . $ot_mins;
                    /*if($ot_mins >= 30) {
                        $total_ot = $ot_hrs . '.' . 30;
                    } elseif($ot_mins <= 30) {
                        $total_ot = $ot_hrs . '.' . 00;
                    }*/

                    $data_rd = array(
                        'employee_number' => $employee_number,
                        'company'         => $company,
                        'department'      => $department,
                        'type'            => $explod_type[0],
                        'day'             => 'wd',
                        'date_ot'         => $date_ot[$i],
                        'time_start'      => $time_start[$i],
                        'time_end'        => $time_end[$i],
                        'sot'             => $sot,
                        'ot_num'          => $total_ot,
                        'task'            => $task[$i],
                        'created_by'      => $this->session->userdata('username'),
                        'created_date'    => date('Y-m-d H:i:s')
                    );
    
                    $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                    $blaine_timekeeping->insert('overtime', $data_rd);
                    /*print_r('<pre>');
                    print_r($data_rd);
                    print_r('</pre>');*/

                    $data_rh = array(
                        'employee_number' => $employee_number,
                        'company'         => $company,
                        'department'      => $department,
                        'type'            => $explod_type[1],
                        'day'             => 'wd',
                        'date_ot'         => $date_ot[$i],
                        'time_start'      => $time_start[$i],
                        'time_end'        => $time_end[$i],
                        'sot'             => $sot,
                        'ot_num'          => $total_ot,
                        'task'            => $task[$i],
                        'created_by'      => $this->session->userdata('username'),
                        'created_date'    => date('Y-m-d H:i:s')
                    );
    
                    $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                    $blaine_timekeeping->insert('overtime', $data_rh);
                    /*print_r('<pre>');
                    print_r($data_rh);
                    print_r('</pre>');*/
                    
                }
               
            }
            elseif($type == "RH|SH")
            {
                $explod_type = explode("|", $type);
                //print_r($explod_type[0] . '|' . $explod_type[1]);
               
                if($timediff > 480)
                {
                    if($no_less_hour[$i] != 1)
                    {
                        $less_one_hour = $timediff - 60;
                        $sot = 1;

                        $total_ot = '8.0';
                        
                        $rdot_less_rd = $less_one_hour - 480;
                        $rdot_hrs = floor($rdot_less_rd / 60);
                        $rdot_mins = $rdot_less_rd % 60;

                        $total_rdot = $rdot_hrs . '.' . $rdot_mins;
                        /*if($rdot_mins >= 30) {
                            $total_rdot = $rdot_hrs . '.' . 30;
                        } elseif($rdot_mins <= 30) {
                            $total_rdot = $rdot_hrs . '.' . 00;
                        }*/

                        $data_rd = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[0],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rd);
                        /*print_r('<pre>');
                        print_r($data_rd);
                        print_r('</pre>');*/

                        $data_rh = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[1],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rh);
                        /*print_r('<pre>');
                        print_r($data_rh);
                        print_r('</pre>');*/
                        
                        $data_rdot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "RHOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rdot);
                        /*print_r('<pre>');
                        print_r($data_rdot);
                        print_r('</pre>');*/

                        $data_rhot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "SHOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rhot);
                        /*print_r('<pre>');
                        print_r($data_rhot);
                        print_r('</pre>');*/
                    } 
                    else
                    {
                        $less_one_hour = $timediff;
                        $sot = 1;

                        $total_ot = '8.0';
                        
                        $rdot_less_rd = $less_one_hour - 480;
                        $rdot_hrs = floor($rdot_less_rd / 60);
                        $rdot_mins = $rdot_less_rd % 60;

                        $total_rdot = $rdot_hrs . '.' . $rdot_mins;
                        /*if($rdot_mins >= 30) {
                            $total_rdot = $rdot_hrs . '.' . 30;
                        } elseif($rdot_mins <= 30) {
                            $total_rdot = $rdot_hrs . '.' . 00;
                        }*/

                        $data_rd = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[0],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rd);
                        /*print_r('<pre>');
                        print_r($data_rd);
                        print_r('</pre>');*/

                        $data_rh = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => $explod_type[1],
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_ot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
        
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rh);
                        /*print_r('<pre>');
                        print_r($data_rh);
                        print_r('</pre>');*/
                        
                        $data_rdot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "RHOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rdot);
                        /*print_r('<pre>');
                        print_r($data_rdot);
                        print_r('</pre>');*/

                        $data_rhot = array(
                            'employee_number' => $employee_number,
                            'company'         => $company,
                            'department'      => $department,
                            'type'            => "SHOT",
                            'day'             => 'wd',
                            'date_ot'         => $date_ot[$i],
                            'time_start'      => $time_start[$i],
                            'time_end'        => $time_end[$i],
                            'sot'             => $sot,
                            'ot_num'          => $total_rdot,
                            'task'            => $task[$i],
                            'created_by'      => $this->session->userdata('username'),
                            'created_date'    => date('Y-m-d H:i:s')
                        );
            
                        $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                        $blaine_timekeeping->insert('overtime', $data_rhot);
                        /*print_r('<pre>');
                        print_r($data_rhot);
                        print_r('</pre>');*/
                    }
                }
                else
                {
                    if($no_less_hour[$i] != 1)
                    {
                        $less_one_hour = $timediff - 60;
                        $sot = 1;
                    }
                    else
                    {
                        $less_one_hour = $timediff;
                        $sot = 0;
                    }    
                    $ot_hrs = floor($less_one_hour / 60);
                    $ot_mins = $less_one_hour % 60;

                    $total_ot = $ot_hrs . '.' . $ot_mins;
                    /*if($ot_mins >= 30) {
                        $total_ot = $ot_hrs . '.' . 30;
                    } elseif($ot_mins <= 30) {
                        $total_ot = $ot_hrs . '.' . 00;
                    }*/

                    $data_rd = array(
                        'employee_number' => $employee_number,
                        'company'         => $company,
                        'department'      => $department,
                        'type'            => $explod_type[0],
                        'day'             => 'wd',
                        'date_ot'         => $date_ot[$i],
                        'time_start'      => $time_start[$i],
                        'time_end'        => $time_end[$i],
                        'sot'             => $sot,
                        'ot_num'          => $total_ot,
                        'task'            => $task[$i],
                        'created_by'      => $this->session->userdata('username'),
                        'created_date'    => date('Y-m-d H:i:s')
                    );
    
                    $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                    $blaine_timekeeping->insert('overtime', $data_rd);
                    /*print_r('<pre>');
                    print_r($data_rd);
                    print_r('</pre>');*/

                    $data_rh = array(
                        'employee_number' => $employee_number,
                        'company'         => $company,
                        'department'      => $department,
                        'type'            => $explod_type[1],
                        'day'             => 'wd',
                        'date_ot'         => $date_ot[$i],
                        'time_start'      => $time_start[$i],
                        'time_end'        => $time_end[$i],
                        'sot'             => $sot,
                        'ot_num'          => $total_ot,
                        'task'            => $task[$i],
                        'created_by'      => $this->session->userdata('username'),
                        'created_date'    => date('Y-m-d H:i:s')
                    );
    
                    $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                    $blaine_timekeeping->insert('overtime', $data_rh);
                    /*print_r('<pre>');
                    print_r($data_rh);
                    print_r('</pre>');*/
                    
                }
               
            }
            else
            {
                //Delivery Drivers Helper Collectors
                $less_daily_mins = $timediff;
                $ot_hrs = floor($less_daily_mins / 60);
                $ot_mins = $less_daily_mins % 60;

                if($ot_mins >= 30) {
                    $total_ot = $ot_hrs . '.' . 30;
                } elseif($ot_mins <= 30) {
                    $total_ot = $ot_hrs . '.' . 00;
                }

                $hf = 720;
                
                if($w_date != 6 && $w_date != 0)
                {
                    if($time_start_num < 720)
                    {
                        $day = 'am';
                    }
                    else
                    {
                        $day = 'pm';
                    }
                }
                else
                {
                    $day = 'wd';
                }
                $data = array(
                    'employee_number' => $employee_number,
                    'company'         => $company,
                    'department'      => $department,
                    'type'            => $type,
                    'day'             => $day,
                    'date_ot'         => $date_ot[$i],
                    'time_start'      => $time_start[$i],
                    'time_end'        => $time_end[$i],
                    'sot'             => 0,
                    'ot_num'          => $total_ot,
                    'task'            => $task[$i],
                    'created_by'      => $this->session->userdata('username'),
                    'created_date'    => date('Y-m-d H:i:s')
                );

                $blaine_timekeeping = $this->load->database('blaine_timekeeping', TRUE);
                $blaine_timekeeping->insert('overtime', $data);
                /*print_r('<pre>');
                print_r($data);
                print_r('</pre>');*/
            }
           
            $i++;
        }

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
        $ot_type = $this->input->post('ot_type');
        
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
            'type'            => $ot_type,
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
            overtime.type as type,
            overtime.time_start as time_start,
            overtime.time_end as time_end,
            overtime.ot_num as ot_num,
            overtime.task as task,
            overtime.status as status,
            overtime.day as day,
            overtime.sot as sot,
            attendance_in.time as time_in,
            attendance_out.time as time_out,
            attendance_in.date as date_in, 
			attendance_out.date as date_out, 
          
            schedules.time_in as sched_time_in,
			schedules.time_out as sched_time_out,
			schedules.grace_period as grace_period,
            employee_schedules.time_in as emp_sched_time_in,
			employee_schedules.time_out as emp_sched_time_out,
			employee_schedules.date as emp_sched_date,
			employee_schedules.grace_period as emp_sched_grace_period
        ");
        $this->db->from('blaine_timekeeping.overtime');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.overtime.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_timekeeping.attendance_in', 'blaine_timekeeping.overtime.employee_number = blaine_timekeeping.attendance_in.employee_number AND blaine_timekeeping.overtime.date_ot = blaine_timekeeping.attendance_in.date', 'left');
        $this->db->join('blaine_timekeeping.attendance_out', 'blaine_timekeeping.overtime.employee_number = blaine_timekeeping.attendance_out.employee_number AND blaine_timekeeping.overtime.date_ot = blaine_timekeeping.attendance_out.date', 'left');
        $this->db->join('blaine_timekeeping.schedules', 'blaine_timekeeping.schedules.employee_number = blaine_timekeeping.overtime.employee_number','left');
        $this->db->join('blaine_schedules.employee_schedules', 'blaine_schedules.employee_schedules.date = blaine_timekeeping.overtime.date_ot AND blaine_timekeeping.overtime.employee_number = blaine_schedules.employee_schedules.employee_number', 'left');
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
            overtime.type as type,
            overtime.time_start as time_start,
            overtime.time_end as time_end,
            overtime.ot_num as ot_num,
            overtime.task as task,
            overtime.status as status,
            overtime.day as day,
            overtime.sot as sot,
            attendance_in.time as time_in,
            attendance_out.time as time_out,
            attendance_in.date as date_in, 
			attendance_out.date as date_out, 

            schedules.time_in as sched_time_in,
			schedules.time_out as sched_time_out,
			schedules.grace_period as grace_period,
            employee_schedules.time_in as emp_sched_time_in,
			employee_schedules.time_out as emp_sched_time_out,
			employee_schedules.date as emp_sched_date,
			employee_schedules.grace_period as emp_sched_grace_period
        ");

        $this->db->from('blaine_timekeeping.overtime');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.overtime.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_timekeeping.attendance_in', 'blaine_timekeeping.overtime.employee_number = blaine_timekeeping.attendance_in.employee_number AND blaine_timekeeping.overtime.date_ot = blaine_timekeeping.attendance_in.date', 'left');
        $this->db->join('blaine_timekeeping.attendance_out', 'blaine_timekeeping.overtime.employee_number = blaine_timekeeping.attendance_out.employee_number AND blaine_timekeeping.overtime.date_ot = blaine_timekeeping.attendance_out.date', 'left');
        $this->db->join('blaine_timekeeping.schedules', 'blaine_timekeeping.schedules.employee_number = blaine_timekeeping.overtime.employee_number','left');
        $this->db->join('blaine_schedules.employee_schedules', 'blaine_schedules.employee_schedules.date = blaine_timekeeping.overtime.date_ot AND blaine_timekeeping.overtime.employee_number = blaine_schedules.employee_schedules.employee_number', 'left');
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
            overtime.type as type,
            overtime.time_start as time_start,
            overtime.time_end as time_end,
            overtime.ot_num as ot_num,
            overtime.task as task,
            overtime.status as status
        ");
        $this->db->from('blaine_timekeeping.overtime');
        $this->db->join('blaine_intranet.employees', 'blaine_timekeeping.overtime.employee_number = blaine_intranet.employees.employee_number');
        $this->db->where('blaine_timekeeping.overtime.id', $id);
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