<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }

        if($this->session->userdata('access_level_id') == 3){
            redirect('homepage');
        }
    }

    //CALENDAR LIST
    function calendar_list()
    {
        $data['calendars'] = $this->calendar_model->get_calendars_list();
        $data['main_content'] = 'hr/timekeeping/calendar/holidaylist/index';
        $this->load->view('inc/navbar', $data);
    }

    function add_calendar_list()
    {
        $this->form_validation->set_rules('type', 'Type', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['employees'] = $this->employee_model->get_employees();
            $data['main_content'] = 'hr/timekeeping/calendar/holidaylist/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->calendar_model->add_calendar_list())
            {
                $this->session->set_flashdata('success_msg', 'Holiday Successfully Added!');
                redirect('calendar/calendar_list');
            }
        }
    }

    function view_calendar_list($id)
    {
        $data['calendar'] = $this->calendar_model->get_calendar_list($id);
        $data['main_content'] = 'hr/timekeeping/calendar/holidaylist/view';
        $this->load->view('inc/navbar', $data);
    }

    function edit_calendar_list($id)
    {
       $this->form_validation->set_rules('type', 'Type', 'required|trim');
       $this->form_validation->set_rules('description', 'Description', 'required|trim');

       if($this->form_validation->run() == FALSE)
       {
           $data['calendar'] = $this->calendar_model->get_calendar_list($id);
           $data['main_content'] = 'hr/timekeeping/calendar/holidaylist/edit';
           $this->load->view('inc/navbar', $data);
       }
       else{
           if($this->calendar_model->update_calendar_list($id))
           {
               $this->session->set_flashdata('success_msg', 'Holiday Successfully Updated!');
               redirect('calendar/calendar_list');
           }
       }

    }

    function delete_calendar_list($id)
    {
        if($this->calendar_model->delete_calendar_list($id))
        {
            $this->session->set_flashdata('error_msg', 'Holiday Successfully Deleted!');
            redirect('calendar/calendar_list');
        }
    }

    function holiday_calendar()
    {
        $this->load->view('hr/timekeeping/calendar/holiday/index', array());
    }

    public function get_events() 
    {
        // Our Start and End Dates
        $start = $this->input->get('start');

        $startdt = new DateTime('now'); // setup a local datetime
        $startdt->setTimestamp($start); // Set the date based on timestamp
        $format = $startdt->format('Y-m-d'); //$created_date = date('Y-m-d H:i:s');

        $events = $this->calendar_model->get_events($format);

        $data_events = array();

        foreach($events->result() as $r) { 

            $data_events[] = array(
                "id"            => $r->id,
                "type"          => $r->type,
                "description"   => $r->description, //change description to title to print in calendar
                "start"         => $r->start,
                "title"         => $r->description
            );
        }

        echo json_encode(array("events" => $data_events));
        exit();
    }

    public function add_event() 
    {
        /* Our calendar data */
        $name = $this->input->post("name");
        $desc = $this->input->post("description");
        $start_date = $this->input->post("start_date");

        $created_date = date('Y-m-d H:i:s');

        /*if(!empty($start_date)) {
            $sd = DateTime::createFromFormat("Y/m/d H:i", $start_date);
            $start_date = $sd->format("Y-m-d h:i:s");
            $start_date_timestamp = $sd->getTimestamp();
        } else {
            $start_date = date("Y-m-d h:i:s", time());
            $start_date_timestamp = time();
        }

        if(!empty($end_date)) {
            $ed = DateTime::createFromFormat("Y/m/d H:i", $end_date);
            $end_date = $ed->format("Y-m-d h:i:s");
            $end_date_timestamp = $ed->getTimestamp();
        } else {
            $end_date = date("Y-m-d h:i:s", time());
            $end_date_timestamp = time();
        }*/

        $this->calendar_model->add_event(array(
            "type"          => $name,
            "description"   => $desc,
            "start"         => $start_date,
            'created_date'  => $created_date,
            'created_by'    => $this->session->userdata('username')
            )
        );

        redirect(site_url("calendar/holiday_calendar"));
    }

    public function edit_event() 
    {
        $eventid = intval($this->input->post("eventid"));
        $event = $this->calendar_model->get_event($eventid);
        if($event->num_rows() == 0) {
            echo"Invalid Event";
            exit();
        }

        $event->row();

        /* Our calendar data */
        $name = $this->input->post("name");
        $desc = $this->input->post("description");
        $start_date = $this->input->post("start_date");
        $delete = intval($this->input->post("delete"));

        //$stdate = date('Y-m-d\TH:i:s', strtotime($start_date));
        

        //<?php echo date('Y-m-d\TH:i:s', strtotime($calendar->start));

        $updated_date = date('Y-m-d H:i:s');

        if(!$delete) {

            /*if(!empty($start_date)) {
                $sd = DateTime::createFromFormat("Y/m/d H:i", $start_date);
                $start_date = $sd->format("Y-m-d H:i:s");
                $start_date_timestamp = $sd->getTimestamp();
            } else {
                $start_date = date("Y-m-d H:i:s", time());
                $start_date_timestamp = time();
            }

            if(!empty($end_date)) {
                $ed = DateTime::createFromFormat("Y/m/d H:i", $end_date);
                $end_date = $ed->format("Y-m-d H:i:s");
                $end_date_timestamp = $ed->getTimestamp();
            } else {
                $end_date = date("Y-m-d H:i:s", time());
                $end_date_timestamp = time();
            }*/

            $this->calendar_model->update_event($eventid, array(
                "type"          => $name,
                "description"   => $desc,
                "start"         => $start_date,
                'updated_date'  => $updated_date,
                'updated_by'    => $this->session->userdata('username')
                )
            );
            
        } else {
            $this->calendar_model->delete_event($eventid);
        }

        redirect(site_url("calendar/holiday_calendar"));
    }
}
