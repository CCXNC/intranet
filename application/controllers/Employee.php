<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        date_default_timezone_set('Asia/Manila');
        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }

        if($this->session->userdata('access_level_id') == 3){
            redirect('homepage');
        }
    }

    function index() 
    {
        $data['employees'] = $this->employee_model->get_employees();
        $data['main_content'] = 'hr/employee/index';
        $this->load->view('inc/navbar', $data);

        
        /*$data['employees'] = $this->employee_model->get_employees();
        $this->load->view('hr/employee/index', $data);*/
        
    }

    function resigned() 
    {
        $data['employees'] = $this->employee_model->get_resigned();
        $data['main_content'] = 'hr/employee/resigned';
        $this->load->view('inc/navbar', $data);
        
    }
 
     public function view_employee($id,$employee_number) 
    {
        $data['employee'] = $this->employee_model->get_employee($id);
        $data['academe_infos'] = $this->employee_model->get_academe_infos($employee_number);
        $data['children_infos'] = $this->employee_model->get_children_infos($employee_number);
        $data['attachments'] = $this->employee_model->get_attachments($employee_number);
        $data['transfer'] = $this->employee_model->get_transfer_logs($employee_number);
        $data['main_content'] = 'hr/employee/view';
        $this->load->view('inc/navbar', $data);
    }

    function add()  
    {
        $this->form_validation->set_rules('employee_number', 'Employee Number', 'required|trim');
		/*$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');
        $this->form_validation->set_rules('birthday', 'BirthDate', 'required|trim');
        $this->form_validation->set_rules('marital_status', 'Marital Status', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');
        $this->form_validation->set_rules('father_full_name', 'Father Full Name', 'required|trim');
        $this->form_validation->set_rules('mother_full_name', 'Mother Full Name', 'required|trim');
        $this->form_validation->set_rules('emergency_name', 'Emergency Full Name', 'required|trim');
        $this->form_validation->set_rules('emergency_contact', 'Emergency Contact', 'required|trim');
        $this->form_validation->set_rules('date_hired', 'Date Hired', 'required|trim');
        $this->form_validation->set_rules('company', 'Business Unit', 'required|trim');
        $this->form_validation->set_rules('position', 'Position', 'required|trim');
        $this->form_validation->set_rules('rank', 'Rank', 'required|trim');
        $this->form_validation->set_rules('employee_status', 'Employee Status', 'required|trim');*/

        //$data = $imgData = array(); 
        
        if($this->form_validation->run() == FALSE)
        {
            $data['main_content'] = 'hr/employee/add';
            $data['departments'] = $this->employee_model->get_department();
            $data['companies'] = $this->employee_model->get_company();
            $data['ranks'] = $this->employee_model->get_rank();
            $data['statuss'] = $this->employee_model->get_employee_status();
            $data['groups'] = $this->employee_model->get_work_group();
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if(!empty($_FILES['image']['name'])){ 
                $imageName = $_FILES['image']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/employee/'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                 
                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 
                 
                // Upload file to server 
                if($this->upload->do_upload('image')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $imgData['file_name'] = $fileData['file_name']; 
                }else{ 
                    $error = $this->upload->display_errors();  
                } 
            } 
            $this->db->select('*');
            $this->db->where('id', $this->input->post('department'));
            $datas = $this->db->get('department');
            $department_name = $datas->row()->name;

            $subject = "Intranet Auto Email";
            $fullname = strtoupper($this->input->post('last_name')) . ', ' . strtoupper($this->input->post('first_name')) . ' ' . strtoupper($this->input->post('middle_name'));
            $department = strtoupper($department_name);
            $position = strtoupper($this->input->post('position'));
            $email = ('jesa.lacambra@blainegroup.com.ph, christian.guarin@blainegroup.com.ph');
            //$cc = "";
            //$bcc = $this->input->post('bcc');

            //<p style="margin: 0;"><IMG width="75" height="50" src="http://blainegroup.com.ph/wp-content/uploads/2016/08/BLAINE-RECREATE.png">Blaine Intranet</p>

            $format = '
                <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="content-type" content="text/html; charset=utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0;">
                        <meta name="format-detection" content="telephone=no"/>

                        <style>
                            /* Reset styles */ 
                            body { 
                                margin: 0; 
                                padding: 0; 
                                min-width: 100%; 
                                width: 100% !important; 
                                height: 100% !important;
                            }
                            body, table, td, div, p, a { 
                                -webkit-font-smoothing: antialiased; 
                                text-size-adjust: 100%; 
                                -ms-text-size-adjust: 100%; 
                                -webkit-text-size-adjust: 100%; 
                                line-height: 100%; 
                            }
                            table, td { 
                                mso-table-lspace: 0pt; 
                                mso-table-rspace: 0pt; 
                                border-collapse: collapse !important; 
                                border-spacing: 0; 
                            }
                            img { 
                                border: 0; 
                                line-height: 100%; 
                                outline: none; 
                                text-decoration: none; 
                                -ms-interpolation-mode: bicubic; 
                            }
                            #outlook a { 
                                padding: 0; 
                            }
                            .ReadMsgBody { 
                                width: 100%; 
                            } 
                            .ExternalClass { 
                                width: 100%; 
                            }
                            .ExternalClass, .ExternalClass p, 
                            .ExternalClass span,.ExternalClass font, 
                            .ExternalClass td, .ExternalClass div { 
                                line-height: 100%; 
                            }

                            /* Rounded corners for advanced mail clients only */ 
                            @media all and (min-width: 560px) {
                                .container { 
                                    border-radius: 8px; 
                                    -webkit-border-radius: 8px; 
                                    -moz-border-radius: 8px; 
                                    -khtml-border-radius: 8px;
                                }
                            }

                            /* Set color for auto links (addresses, dates, etc.) */ 
                            a, a:hover {
                                color: #127DB3;
                            }
                            .footer a, .footer a:hover {
                                color: #999999;
                            }
                        </style>

                        <!-- MESSAGE SUBJECT -->
                        <title>BLAINE INTRANET</title>
                    </head>

                    <!-- BODY -->
                    <!-- Set message background color (twice) and text color (twice) -->
                    <body 
                        topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%"
                        style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; 
                        text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%; background-color: #F0F0F0;
                        color: #000000;" bgcolor="#F0F0F0"text="#000000">

                        <!-- SECTION / BACKGROUND -->
                        <!-- Set message background color one again -->
                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;" class="background"><tr><td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;"
                        bgcolor="#F0F0F0">

                            <!-- WRAPPER -->
                            <!-- Set wrapper width (twice) -->
                            <table border="0" cellpadding="0" cellspacing="0" align="center" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit; max-width: 560px;" class="wrapper">

                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                padding-top: 20px; padding-bottom: 20px;">		
                                </td>
                            </tr>
                            <!-- End of WRAPPER -->
                        </table>

                        <!-- WRAPPER / CONTEINER -->
                        <!-- Set conteiner background color -->
                        <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit; max-width: 560px;" class="container">

                            <!-- HEADER -->
                            <!-- Set text color and font family ("sans-serif" or "Georgia, serif") -->
                            <tr>
                                <td  bgcolor="#003060"  align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 24px; font-weight: bold; line-height: 130%;
                                    padding-top: 25px; color: #ffffff; font-family: sans-serif; padding-bottom: 25px;" class="header">
                                    BLAINE INTRANET
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 24px; font-weight: 400; line-height: 160%;
                                    padding-top: 25px; color: #000000; font-family: sans-serif;" class="paragraph">
                                    HRIS 201 MODULE
                                </td>
                            </tr>

                            <!-- LINE -->
                            <!-- Set line color -->
                            <tr>	
                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                    padding-top: 10px;" class="line"><hr
                                    color="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                </td>
                            </tr>
        
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 15px; font-weight: 400; line-height: 160%;
                                    padding-top: 25px; 
                                    color: #000000;
                                    font-family: sans-serif;" class="paragraph">
                                        Please create email and computer account for:
                                </td>
                            </tr>

                            <!-- LIST -->
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%;" class="list-item"><table align="center" border="0" cellspacing="0" cellpadding="0" style="width: inherit; margin: 0; padding: 0; border-collapse: collapse; border-spacing: 0;">
                                    <!-- LIST ITEM -->
                                    <tr>
                                        <!-- LIST ITEM IMAGE -->
                                        <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2 -->
                                        <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0;
                                            padding-top: 30px;
                                            padding-right: 20px;"></td>

                                        <!-- LIST ITEM TEXT -->
                                        <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
                                        <td align="left" valign="top" style="font-size: 17px; font-weight: 400; line-height: 160%; border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
                                            padding-top: 25px;
                                            color: #000000;
                                            font-family: sans-serif;" class="paragraph">
                                                <b style="color: #333333;">Employee Fullname</b>
                                                <p>'.$fullname.'</p>
                                        </td>
                                    </tr>

                                    <!-- LIST ITEM -->
                                    <tr>
                                        <!-- LIST ITEM IMAGE -->
                                        <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2 -->
                                        <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0;
                                            padding-top: 30px;
                                            padding-right: 20px;"></td>

                                        <!-- LIST ITEM TEXT -->
                                        <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
                                        <td align="left" valign="top" style="font-size: 17px; font-weight: 400; line-height: 160%; border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
                                            padding-top: 25px;
                                            color: #000000;
                                            font-family: sans-serif;" class="paragraph">
                                                <b style="color: #333333;">Employee Department</b>
                                                <p>'.$department.'</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- LIST ITEM IMAGE -->
                                        <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2 -->
                                        <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0;
                                            padding-top: 30px;
                                            padding-right: 20px;"></td>

                                        <!-- LIST ITEM TEXT -->
                                        <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
                                        <td align="left" valign="top" style="font-size: 17px; font-weight: 400; line-height: 160%; border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
                                            padding-top: 25px;
                                            color: #000000;
                                            font-family: sans-serif;" class="paragraph">
                                                <b style="color: #333333;">Employee Position</b>
                                                <p>'.$position.'</p>
                                        </td>
                                    </tr>
                                </table></td>
                            </tr>

                            <!-- LINE -->
                            <!-- Set line color -->
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                    padding-top: 25px;" class="line"><hr
                                    color="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                </td>
                            </tr>

                            <!-- PARAGRAPH -->
                            <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
                                    padding-top: 20px;
                                    padding-bottom: 25px;
                                    color: #000000;
                                    font-family: sans-serif;" class="paragraph">
                                        Have a&nbsp;question? Contact us at<a href="mailto:intranet_system@blainegroup.com.ph" target="_blank" style="color: #127DB3; font-family: sans-serif; font-size: 12px; font-weight: 400; line-height: 160%;"><br>intranet_system@blainegroup.com.ph</a>
                                </td>
                            </tr>
                        <!-- End of WRAPPER -->
                        </table>

                        <!-- WRAPPER -->
                        <!-- Set wrapper width (twice) -->
                        <table border="0" cellpadding="0" cellspacing="0" align="center" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                        max-width: 560px;" class="wrapper">

                            <!-- SOCIAL NETWORKS -->
                            <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2 -->


                            <!-- FOOTER -->
                            <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                    padding-top: 20px; padding-bottom: 20px; color: #999999; font-family: sans-serif;" class="footer">
                                    <b>Copyright 2021 - <a href="http://www.blaineintranet/" style="color: #999999;">Blaine Intranet</a> - All Rights Reserved</b>
                                    <br>This is an auto-generated email from Blaine Intranet system. <br>Please do not reply.

                                    <!-- ANALYTICS -->
                                    <!-- https://www.google-analytics.com/collect?v=1&tid={{UA-Tracking-ID}}&cid={{Client-ID}}&t=event&ec=email&ea=open&cs={{Campaign-Source}}&cm=email&cn={{Campaign-Name}} -->
                                    <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                    src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />

                                </td>
                            </tr>
                            <!-- End of WRAPPER -->
                        </table>
                    </body>
                </html>
            ';
    
            $config = Array(
                'protocol'      => 'smtp',
                'smtp_host'     => 'mail.blainegroup.com.ph',
                'smtp_crypto'   => 'ssl',
                'smtp_port'     => 465,
                'smtp_user'     => 'intranet_system@blainegroup.com.ph', // change it to yours
                'smtp_pass'     => 'kGCBYMyUum[2', // change it to yours
                'mailtype'      => 'html',
                'charset'       => 'iso-8859-1',
                'wordwrap'      => TRUE
            );
    
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($config['smtp_user']); // change it to yours
            $this->email->to($email);// change it to yours
            //$this->email->cc($cc);
            //$this->email->bcc($bcc);
            $this->email->subject($subject);
            $this->email->message($format);
            if($this->email->send()){
                $this->session->set_flashdata('message', 'Email sent');
            }
            else{
                $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
            }

            if($this->employee_model->add_employee())
            {
                $this->session->set_flashdata('success_msg', 'Employee Successfully Added!');
                redirect('schedule/index');
            }
          
        }
    
    }

    public function edit_employee($id,$employee_number)
    {
        $this->form_validation->set_rules('employee_number', 'Employee Number', 'required|trim');
        /*$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');
        $this->form_validation->set_rules('birthday', 'BirthDate', 'required|trim');
        $this->form_validation->set_rules('marital_status', 'Marital Status', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');
        $this->form_validation->set_rules('father_full_name', 'Father Full Name', 'required|trim');
        $this->form_validation->set_rules('mother_full_name', 'Mother Full Name', 'required|trim');
        $this->form_validation->set_rules('emergency_name', 'Emergency Full Name', 'required|trim');
        $this->form_validation->set_rules('emergency_contact', 'Emergency Contact', 'required|trim');
        $this->form_validation->set_rules('date_hired', 'Date Hired', 'required|trim');
        $this->form_validation->set_rules('company', 'Business Unit', 'required|trim');
        $this->form_validation->set_rules('position', 'Position', 'required|trim');
        $this->form_validation->set_rules('rank', 'Rank', 'required|trim');
        $this->form_validation->set_rules('employee_status', 'Employee Status', 'required|trim');*/

        if($this->form_validation->run() == FALSE)
        {
            $data['employee'] = $this->employee_model->get_employee($id);
            $data['children_infos'] = $this->employee_model->get_children_infos($employee_number);
            $data['academe_infos'] = $this->employee_model->get_academe_infos($employee_number);
            $data['departments'] = $this->employee_model->get_department();
            $data['companies'] = $this->employee_model->get_company();
            $data['ranks'] = $this->employee_model->get_rank();
            $data['statuss'] = $this->employee_model->get_employee_status();
            $data['groups'] = $this->employee_model->get_work_group();
            $data['main_content'] = 'hr/employee/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            // GET PREVIOUS DATA.
            $employee = $this->employee_model->get_employee($id);
            $prevImage = $employee->picture;

            if(!empty($_FILES['image']['name'])){ 
                $imageName = $_FILES['image']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/employee/';  
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                 
                // Load and initialize upload library 
                $this->load->library('upload', $config);  
                $this->upload->initialize($config); 

                if(!empty($prevImage) && !empty($imageName)){ 
                     // Remove old file from the server 
                    @unlink('./uploads/employee/'.$prevImage);  

                     // Upload file to server 
                     if($this->upload->do_upload('image')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $imgData['file_name'] = $fileData['file_name']; 
                    
                    }else{ 
                        $error = $this->upload->display_errors();  
                    } 
                } 
                
            } 

            if($this->employee_model->update_employee($id,$employee_number))
            {
                $this->session->set_flashdata('success_msg', 'Employment Information Successfully Updated!');
                redirect('employee/index');
            }
        }    
    }

    public function employee_termination($id,$employee_number)
    {
        $this->form_validation->set_rules('employee_status', 'Employee Status', 'required|trim');
        $this->form_validation->set_rules('date_termination', 'Date Termination', 'required|trim');
        $this->form_validation->set_rules('date_clearance', 'Date Clearance', 'required|trim');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required|trim');
        
        if($this->form_validation->run() == FALSE)
        {
            $data['employee'] = $this->employee_model->get_employee($id);
            $data['departments'] = $this->employee_model->get_department();
            $data['companies'] = $this->employee_model->get_company();
            $data['ranks'] = $this->employee_model->get_rank();
            $data['statuss'] = $this->employee_model->get_employee_status();
            $data['groups'] = $this->employee_model->get_work_group();
            $data['main_content'] = 'hr/employee/termination';
            $this->load->view('inc/navbar', $data);
        }
        else 
        {
            if($this->employee_model->update_employee_termination($id,$employee_number));
            {
                $this->session->set_flashdata('success_msg', 'Employment Information Successfully Updated!');
                redirect('employee/index');
            }
            
        }    
    }

    public function employee_movement($id,$employee_number) 
    {    
        $this->form_validation->set_rules('company', 'Company', 'required|trim');
        /*$this->form_validation->set_rules('work_group', 'Work Group', 'required|trim');
        $this->form_validation->set_rules('superior', 'Superior', 'required|trim');
        $this->form_validation->set_rules('rank', 'Rank', 'required|trim');
        $this->form_validation->set_rules('date_transfer', 'Date Transfer', 'required|trim');
        $this->form_validation->set_rules('position', 'Position', 'required|trim');
        $this->form_validation->set_rules('movement_from', 'Movement From', 'required|trim');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required|trim');*/

        if($this->form_validation->run() == FALSE)
        {
            $data['employee'] = $this->employee_model->get_employee($id);
            $data['departments'] = $this->employee_model->get_department();
            $data['companies'] = $this->employee_model->get_company();
            $data['ranks'] = $this->employee_model->get_rank();
            $data['statuss'] = $this->employee_model->get_employee_status();
            $data['groups'] = $this->employee_model->get_work_group();
            $data['main_content'] = 'hr/employee/movement';
            $this->load->view('inc/navbar', $data);
        }
        else 
        {
            if($this->employee_model->update_employee_movement($id,$employee_number))
            {
                $this->session->set_flashdata('success_msg', 'Employment Information Successfully Updated!');
                redirect('employee/index');
            }
             
        }    
    }


    public function add_info($id,$employee_number)
    {
        $this->form_validation->set_rules('employee_number', 'Employee Number', 'required|trim');
      
        if($this->form_validation->run() == FALSE)
        {
            $data['employee'] = $this->employee_model->get_employee($id);
            $data['main_content'] = 'hr/employee/add_info';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            $this->employee_model->add_employee_info();
            $this->session->set_flashdata('success_msg', 'Employee Info Successfully Added!');
            redirect('employee/index');
        }    
    }

    public function delete_view_employee($id,$employee_number) 
    {
        $data['employee'] = $this->employee_model->get_employee($id);
        $data['academe_infos'] = $this->employee_model->get_academe_infos($employee_number);
        $data['children_infos'] = $this->employee_model->get_children_infos($employee_number);
        $data['transfer'] = $this->employee_model->get_transfer_logs($employee_number);
        $data['main_content'] = 'hr/employee/delete';
        $this->load->view('inc/navbar', $data);
    }

    public function delete_all_information($id,$employee_number) 
    {
        if($this->employee_model->delete_all_information($id,$employee_number))
        {
            $this->session->set_flashdata('error_msg', 'Employee Successfully Deleted!');
            redirect('employee/index');
        }
        
    }

    public function delete_children_information($id,$employee_number) 
    {
        if($this->employee_model->delete_children_information($id,$employee_number))
        {
            $this->session->set_flashdata('error_msg', 'Children Info Successfully Deleted!');
            redirect('employee/index');
        }
        
    }

    public function delete_academe_information($id,$employee_number) 
    {
        if($this->employee_model->delete_academe_information($id,$employee_number))
        {
            $this->session->set_flashdata('error_msg', 'Academe Info Successfully Deleted!');
            redirect('employee/index');
        }
        
    }

	public function employee_attachment($id,$employee_number)
    {
        $this->form_validation->set_rules('attachment', 'Resume', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['employee'] = $this->employee_model->get_employee($id);
            $data['main_content'] = 'hr/employee/attachment';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if(!empty($_FILES['resume']['name'])){ 
                //$imageName = $_FILES['resume']['name']; 
                $file_name = $_FILES["resume"]['name'];
                //$newfile_name= preg_replace('/[^A-Za-z0-9]/', "", $file_name);
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/attachment/'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf'; 
                $config['max_size'] = '100000000'; 
                $config['overwrite'] = True;

                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 
                 
                // Upload file to server 
                if($this->upload->do_upload('resume')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $imgData['file_name'] = $fileData['file_name']; 
                   
                }else{ 
                    $error = $this->upload->display_errors();  
                } 
            } 

            if(!empty($_FILES['data1']['name'])){ 
                $imageName = $_FILES['data1']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/attachment/'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf'; 
                $config['max_size'] = '100000000'; 
                $config['overwrite'] = True;

                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 
                 
                // Upload file to server 
                if($this->upload->do_upload('data1')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $imgData['file_name'] = $fileData['file_name']; 
                }else{ 
                    $error = $this->upload->display_errors();  
                } 
            } 

            if(!empty($_FILES['data2']['name'])){ 
                $imageName = $_FILES['data2']['name']; 
                 
                // File upload configuration 
                $config['upload_path'] = './uploads/attachment/'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf'; 
                $config['max_size'] = '100000000'; 
                $config['overwrite'] = True;

                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 
                 
                // Upload file to server 
                if($this->upload->do_upload('data2')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $imgData['file_name'] = $fileData['file_name']; 
                }else{ 
                    $error = $this->upload->display_errors();  
                } 
            } 
            
            if($this->employee_model->attachment($employee_number))
            {
                $this->session->set_flashdata('success_msg', 'Employee Attachment Successfully Added!');
                redirect('employee/index');
            }
            
        }
        
      
    }
    
    public function download_attachment($attachment_file)
	{
		$this->load->helper('download');
		$data = file_get_contents('uploads/attachment/'.$this->uri->segment(3)); // Read the file's contents
		$name = $this->uri->segment(3);
        force_download($name, $data);
        //print_r($data);
    }

    public function reports()
    {
        $data['employees'] = $this->employee_model->get_reports();
        $data['main_content'] = 'hr/employee/reports';
        $this->load->view('inc/navbar', $data);
    }
}
