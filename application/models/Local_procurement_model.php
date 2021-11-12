<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Local_procurement_model extends CI_Model {

    public function insert($data = array()){ 
        $insert = $this->db->insert_batch('blaine_local_procurement.material_sourcing_list',$data); 
        return $insert?true:false; 
    } 
    public function add_material_sourcing_matcode()
    {
        $this->db->trans_start();
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->order_by('id','DESC');
		$blaine_local_procurement->select('msid');
		$datas = $blaine_local_procurement->get('material_sourcing');
		$inc_number = $datas->row()->msid;

        $arr2 = str_split($inc_number, 9);
        $i = $arr2[0] + 1;
        $batch_number = str_pad($i, 9, 'MS000000', STR_PAD_LEFT);

        // Material Sourcing 
        $msid = $batch_number;
        $source_id = $this->input->post('source_id');
        $company = $this->input->post('company');
        $sourcing_category = $this->input->post('sourcing_category');
        $date_required = $this->input->post('date_required');
        $date_requested = date('Y-m-d');

        // APPROVAL DETAILS 
        $date = date('Y-m-d H:i:s');
        $remarks = $this->input->post('remarks');
        $role_status = ['Requestor','Superior'];
        $status = ['Done','Pending'];
        $material_source_status = $status[1]. ' '.$role_status[1];
        $signoff_by = [$this->session->userdata('username'),' '];
        $signoff_date = [$date,' '];
        $step_approval = [1,2];
        $j = 0;
        $data_explod = explode('|', $this->input->post('requestor_primary1'));
        $data_explod1 = explode('|', $this->input->post('requestor_alternate1'));
        $data_explod2 = explode('|', $this->input->post('requestor_primary2'));
        $data_explod3 = explode('|', $this->input->post('requestor_alternate2'));

        // Email Subject
        $subject = "MSID # " . $msid . " - Request Submission"; 

        $primary_approver = $data_explod[0];
        $emp_no_approver = $data_explod[1];

        $requestor_alternate = $data_explod1[0];
        $emp_no_requestor = $data_explod1[1];

        $primary_approver1 = $data_explod2[0];
        $emp_no_approver1 = $data_explod2[1];

        $requestor_alternate1 = $data_explod3[0];
        $emp_no_requestor1 = $data_explod3[1];

        $access = $emp_no_approver.'|'.$emp_no_requestor.'|'.$emp_no_approver1.'|'.$emp_no_requestor1;

        $req_primary_email1 = $data_explod[2];
        $req_alternate_email1 = $data_explod1[2];
        $req_primary_email2 = $data_explod2[2];
        $req_alternate_email2 = $data_explod3[2];

        $email_recip = $req_primary_email1.','.$req_alternate_email1.','.$req_primary_email2.','.$req_alternate_email2;

        $transmittal_requestor = $primary_approver.'|'.$requestor_alternate;
       
        /** MATERIAL SOURCING INSERT **/ 
        $data_material_source = array(
            'msid'          => $msid,
            'company_id'    => $company,
            'category'      => $sourcing_category,
            'date_required' => $date_required,
            'role_status'   => $material_source_status,
            'created_by'    => $this->session->userdata('username'),
            'created_date'  => $date
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material_sourcing', $data_material_source);

        /*print_r('<pre>');
        print_r($data_material_source);
        print_r('</pre>');*/

        /** APPROVER LIST INSERT **/ 
        $data_material_approver1 = array(
            'msid'               => $msid,
            'primary_approver'   => $primary_approver,
            'alternate_approver' => $requestor_alternate,
            'remarks'            => $remarks,
            'role_status'        => 'Requestor',
            'status'             => 'Done',
            'signoff_by'         => $this->session->userdata('username'),
            'signoff_date'       => $date,
            'created_by'         => $this->session->userdata('username'),
            'created_date'       => $date,
            'step_approval'      => 1
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material_approval_list', $data_material_approver1);

        /*print_r('<pre>');
        print_r($data_material_approver1);
        print_r('</pre>');*/

        $data_material_approver2 = array(
            'msid'               => $msid,
            'primary_approver'   => $primary_approver1,
            'alternate_approver' => $requestor_alternate1,
            'remarks'            => ' ',
            'role_status'        => 'Superior',
            'status'             => 'Pending',
            'signoff_by'         => NULL,
            'signoff_date'       => NULL,
            'created_by'         => $this->session->userdata('username'). ' 0',
            'created_date'       => $date,
            'step_approval'      => 2
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material_approval_list', $data_material_approver2);
     
        /*print_r('<pre>');
        print_r($data_material_approver2);
        print_r('</pre>');*/
        

        $data_restriction_access = array(
            'msid'      => $msid,
            'access'    => $access,
            'email'     => $email_recip,
            'fullname'  => $transmittal_requestor
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material_restriction', $data_restriction_access);

        // Get Company Name
        $this->db->select('*');
        $this->db->where('id', $this->input->post('company'));
        $datas = $this->db->get('company');

        // Request Details
        $bu = $datas->row()->name;

        // AUTO EMAIL - ADD MATERIAL SOURCING FORM WITH MATSOURCE

        // Get approval details
        $this->db->select("
            material_approval_list.primary_approver as primary_approver,
            material_approval_list.alternate_approver as alternate_approver,
            material_approval_list.status as status,
            material_approval_list.remarks as remarks,
            material_approval_list.signoff_by as signoff_by,
            material_approval_list.signoff_date as signoff_date,
            material_approval_list.role_status as role_status,
            step_of_approver.name as step_of_approval
        ");

        $this->db->from('blaine_local_procurement.material_approval_list');
        $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
        $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
        $query = $this->db->get();

        $approval_lists = $query->result();

        foreach($approval_lists as $approval_list)
        {
            $e_step_of_approval = $approval_list->step_of_approval;
            $e_primary_approver = $approval_list->primary_approver;
            $e_alternate_approver = $approval_list->alternate_approver;
            $e_status = $approval_list->status;
            $e_signoff_date = $approval_list->signoff_date;
            $e_signoff_by = $approval_list->signoff_by;
            $e_remarks = $approval_list->remarks;

            $approver .= '<tbody>
                <tr>
                    <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                    <td style="font-size:12px">'.$e_primary_approver.'</td>
                    <td style="font-size:12px">'.$e_alternate_approver.'</td>
                    <td style="font-size:12px">'.$e_status.'</td>
                    <td style="font-size:12px">'.$e_signoff_date.'</td>
                    <td style="font-size:12px"></td>
                    <td style="font-size:12px">'.$e_signoff_by.'</td>
                    <td style="font-size:12px">'.$e_remarks.'</td>
                </tr>
            </tbody>';
        }

        $format .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <meta name="x-apple-disable-message-reformatting">
                <title></title>
                <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                </style>
            </head>
            <body style="margin:0;padding:0;">
                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                        <td align="center" style="padding:0;">
                            <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                <tr>
                                    <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                        BLAINE INTRANET
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                        Electronic Material Sourcing Request
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                    <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                    </td>
                                </tr>
                                <tr>	
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                        <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 30px 0px 30px;">
                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                            <tr>
                                            </tr>
                                            <tr>
                                                <td style="padding:0;">
                                                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$bu.'</p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$sourcing_category.'</p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                        <div class="row">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                        <th scope="col" style="font-size:12px">Step/Approver</th>
                                                        <th scope="col" style="font-size:12px">Primary Approver</th>
                                                        <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                        <th scope="col" style="font-size:12px">Status</th>
                                                        <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                        <th scope="col" style="font-size:12px">Date CT</th>
                                                        <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                        <th scope="col" style="font-size:12px">Remarks</th>
                                                    </tr>
                                                </thead>
                                                '.$approver.'
                                            </table>
                                        </div>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <table border="0" cellpadding="0" cellspacing="0" align="center"
                        width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                        max-width: 560px;" class="wrapper">
                        <tr>
                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                padding-top: 20px;
                                padding-bottom: 20px;
                                color: #999999;
                                font-family: sans-serif;" class="footer">
                                <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                <br>This is an auto-generated email from Blaine Intranet system.
                            </td>
                        </tr>
                    </table>
                </table>
            </body>
        </html>';
            
        $config = Array(
            'protocol'      => 'smtp',
            'smtp_host'     => 'mail.blainegroup.com.ph',
            'smtp_crypto'   => 'ssl',
            'smtp_port'     => 465,
            'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
            'smtp_pass'     => '@Bl@ine2021', // change it to yours
            'mailtype'      => 'html',
            'charset'       => 'iso-8859-1',
            'wordwrap'      => TRUE
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($config['smtp_user']); // change it to yours
        $this->email->to($email_recip);// change it to yours
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

        /*print_r('<pre>');
        print_r($format);
        print_r('</pre>');*/

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Added: With Matcode",
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: MATERIAL SOURCING FORM',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function add_material_sourcing_nomatcode()
    {
        $this->db->trans_start();
 
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->order_by('id','DESC');
		$blaine_local_procurement->select('msid');
		$datas = $blaine_local_procurement->get('material_sourcing');
		$inc_number = $datas->row()->msid;

        $arr2 = str_split($inc_number, 9);
        $i = $arr2[0] + 1;
        $batch_number = str_pad($i, 9, 'MS000000', STR_PAD_LEFT);

        // Material Sourcing 
        $msid = $batch_number;
        $company = $this->input->post('company');
        $sourcing_category = $this->input->post('sourcing_category');
        $date_required = $this->input->post('date_required');
        $date_requested = date('Y-m-d');

        // APPROVAL DETAILS
        $date = date('Y-m-d H:i:s');
        $remarks = $this->input->post('remarks');
        $role_status = ['Requestor','Superior'];
        $status = ['Done','Pending'];
        $material_source_status = $status[1]. ' '.$role_status[1];
        $signoff_by = [$this->session->userdata('username'),' '];
        $signoff_date = [$date,' '];
        $step_approval = [1,2];
        $j = 0;
        $data_explod = explode('|', $this->input->post('requestor_primary1'));
        $data_explod1 = explode('|', $this->input->post('requestor_alternate1'));
        $data_explod2 = explode('|', $this->input->post('requestor_primary2'));
        $data_explod3 = explode('|', $this->input->post('requestor_alternate2'));

        // Email Subject
        $subject = "MSID # " . $msid . " - Request Submission";

        $primary_approver = $data_explod[0];
        $emp_no_approver = $data_explod[1];

        $requestor_alternate = $data_explod1[0];
        $emp_no_requestor = $data_explod1[1];

        $primary_approver1 = $data_explod2[0];
        $emp_no_approver1 = $data_explod2[1];

        $requestor_alternate1 = $data_explod3[0];
        $emp_no_requestor1 = $data_explod3[1];

        $access = $emp_no_approver.'|'.$emp_no_requestor.'|'.$emp_no_approver1.'|'.$emp_no_requestor1;
        
        $req_primary_email1 = $data_explod[2];
        $req_alternate_email1 = $data_explod1[2];
        $req_primary_email2 = $data_explod2[2];
        $req_alternate_email2 = $data_explod3[2];

        $email_recip = $req_primary_email1.', '.$req_alternate_email1.', '.$req_primary_email2.', '.$req_alternate_email2;

        $transmittal_requestor = $primary_approver.'|'.$requestor_alternate;
        /** MATERIAL SOURCING INSERT **/ 
        $data_material_source = array(
            'msid'          => $msid,
            'company_id'    => $company,
            'category'      => $sourcing_category,
            'date_required' => $date_required,
            'role_status'   => $material_source_status,
            'created_by'    => $this->session->userdata('username'),
            'created_date'  => $date
        );


        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material_sourcing', $data_material_source);

        /*print_r('<pre>');
        print_r($data_material_source);
        print_r('</pre>');*/

        /** APPROVER LIST INSERT **/ 
        $data_material_approver1 = array(
            'msid'               => $msid,
            'primary_approver'   => $primary_approver,
            'alternate_approver' => $requestor_alternate,
            'remarks'            => $remarks,
            'role_status'        => 'Requestor',
            'status'             => 'Done',
            'signoff_by'         => $this->session->userdata('username'),
            'signoff_date'       => $date,
            'created_by'         => $this->session->userdata('username'),
            'created_date'       => $date,
            'step_approval'      => 1
        );


        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material_approval_list', $data_material_approver1);

        /*print_r('<pre>');
        print_r($data_material_approver1);
        print_r('</pre>');*/

        $data_material_approver2 = array(
            'msid'               => $msid,
            'primary_approver'   => $primary_approver1,
            'alternate_approver' => $requestor_alternate1,
            'remarks'            => NULL,
            'role_status'        => 'Superior',
            'status'             => 'Pending',
            'signoff_by'         => NULL,
            'signoff_date'       => NULL,
            'created_by'         => $this->session->userdata('username'). ' 0',
            'created_date'       => $date,
            'step_approval'      => 2
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material_approval_list', $data_material_approver2);

        /*print_r('<pre>');
        print_r($data_material_approver2);
        print_r('</pre>');*/

        $data_restriction_access = array(
            'msid'      => $msid,
            'access'    => $access,
            'email'     => $email_recip,
            'fullname'  => $transmittal_requestor
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material_restriction', $data_restriction_access);

        // Get Company Name
        $this->db->select('*');
        $this->db->where('id', $this->input->post('company'));
        $datas = $this->db->get('company');
        $source_id = $this->input->post('source_id');

        // Request Details
        $bu = $datas->row()->name;

        // AUTO EMAIL - ADD MATERIAL SOURCING FORM - WITHOUT MATSOURCE
        
        // Get approval details
        $this->db->select("
            material_approval_list.primary_approver as primary_approver,
            material_approval_list.alternate_approver as alternate_approver,
            material_approval_list.status as status,
            material_approval_list.remarks as remarks,
            material_approval_list.signoff_by as signoff_by,
            material_approval_list.signoff_date as signoff_date,
            material_approval_list.role_status as role_status,
            step_of_approver.name as step_of_approval
        ");

        $this->db->from('blaine_local_procurement.material_approval_list');
        $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
        $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
        $query = $this->db->get();

        $approval_lists = $query->result();

        foreach($approval_lists as $approval_list)
        {
            $e_step_of_approval = $approval_list->step_of_approval;
            $e_primary_approver = $approval_list->primary_approver;
            $e_alternate_approver = $approval_list->alternate_approver;
            $e_status = $approval_list->status;
            $e_signoff_date = $approval_list->signoff_date;
            $e_signoff_by = $approval_list->signoff_by;
            $e_remarks = $approval_list->remarks;

            $approver .= '<tbody>
                <tr>
                    <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                    <td style="font-size:12px">'.$e_primary_approver.'</td>
                    <td style="font-size:12px">'.$e_alternate_approver.'</td>
                    <td style="font-size:12px">'.$e_status.'</td>
                    <td style="font-size:12px">'.$e_signoff_date.'</td>
                    <td style="font-size:12px"></td>
                    <td style="font-size:12px">'.$e_signoff_by.'</td>
                    <td style="font-size:12px">'.$e_remarks.'</td>
                </tr>
            </tbody>';
        }
        $format .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <meta name="x-apple-disable-message-reformatting">
                <title></title>
                <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                </style>
            </head>
            <body style="margin:0;padding:0;">
                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                        <td align="center" style="padding:0;">
                            <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                <tr>
                                    <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                        BLAINE INTRANET
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                        Electronic Material Sourcing Request
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                    <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                    </td>
                                </tr>
                                <tr>	
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                        <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 30px 0px 30px;">
                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                            <tr>
                                            </tr>
                                            <tr>
                                                <td style="padding:0;">
                                                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$bu.'</p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$sourcing_category.'</p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                        <div class="row">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                        <th scope="col" style="font-size:12px">Step/Approver</th>
                                                        <th scope="col" style="font-size:12px">Primary Approver</th>
                                                        <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                        <th scope="col" style="font-size:12px">Status</th>
                                                        <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                        <th scope="col" style="font-size:12px">Date CT</th>
                                                        <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                        <th scope="col" style="font-size:12px">Remarks</th>
                                                    </tr>
                                                </thead>
                                                '.$approver.'
                                            </table>
                                        </div>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <table border="0" cellpadding="0" cellspacing="0" align="center"
                        width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                        max-width: 560px;" class="wrapper">
                        <tr>
                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                padding-top: 20px;
                                padding-bottom: 20px;
                                color: #999999;
                                font-family: sans-serif;" class="footer">
                                <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                <br>This is an auto-generated email from Blaine Intranet system.
                                <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                            </td>
                        </tr>
                    </table>
                </table>
            </body>
        </html>';
            
        $config = Array(
            'protocol'      => 'smtp',
            'smtp_host'     => 'mail.blainegroup.com.ph',
            'smtp_crypto'   => 'ssl',
            'smtp_port'     => 465,
            'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
            'smtp_pass'     => '@Bl@ine2021', // change it to yours
            'mailtype'      => 'html',
            'charset'       => 'iso-8859-1',
            'wordwrap'      => TRUE
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($config['smtp_user']); // change it to yours
        $this->email->to($email_recip);// change it to yours
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

        /*print_r('<pre>');
        print_r($format);
        print_r('</pre>');*/

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Added: Without Matcode",
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: MATERIAL SOURCING FORM',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $trans = $this->db->trans_complete();
        return $trans;

    }

    // OLD UPDATE
    public function update_material_sourcing_matcode()
    {
        $this->db->trans_start();

        $description = $this->input->post('description');
        $specification = $this->input->post('specification');
        $quantity = $this->input->post('quantity');
        $uom =  $this->input->post('uom');
        $shelf_life =  $this->input->post('shelf_life');
        $item_application =  $this->input->post('item_application');
        $required_document = $this->input->post('required_document');
        $material_category = $this->input->post('material_category');
        $purpose = $this->input->post('purpose');
        $mcode = $this->input->post('material_code');
        $date = date('Y-m-d H:i:s');
        $i = 0;

        foreach($this->input->post('mid') as $id)
        {
            $data_material = array(
                'mcode'             => $mcode[$i],
                'description'       => $description[$i],
                'specification'     => $specification[$i],
                'quantity'          => $quantity[$i],
                'uom'               => $uom[$i],
                'shelf_life'        => $shelf_life[$i],
                'item_application'  => $item_application[$i],
                'required_document' => $required_document[$i],
                'category'          => $material_category[$i],
                'remarks'           => $purpose[$i],
                'updated_by'        => $this->session->userdata('username'),
                'updated_date'      => $date
            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('id', $id);
            $blaine_local_procurement->update('material_sourcing_list', $data_material);

            /*print_r('<pre>');
            print_r($data_material);
            print_r('</pre>');*/

            $i++;
        }
        
        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function delete_material_sourcing_list($id)
    {
        // GET OLD DATA BEFORE UPDATE
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->select('*');
        $blaine_local_procurement->where('id', $id);
        $datas = $blaine_local_procurement->get('material_sourcing_list');
        $material_id = $datas->row()->id;
        $material_msid = $datas->row()->msid;
        $material_mcode = $datas->row()->mcode;
        $material_description = $datas->row()->description;
        $material_specification = $datas->row()->specification;
        $material_quantity = $datas->row()->quantity;
        $material_uom = $datas->row()->uom;
        $material_shelf_life = $datas->row()->shelf_life;
        $material_item_application = $datas->row()->item_application;
        $material_required_document = $datas->row()->required_document;
        $material_category = $datas->row()->category;
        $material_remarks = $datas->row()->remarks;
        $material_attachment = $datas->row()->attachment;

        $entry_data = array(
            'id'                => $material_id,
            'msid'              => $material_msid,
            'mcode'             => $material_mcode,
            'description'       => $material_description,
            'specification'     => $material_specification,
            'quantity'          => $material_quantity,
            'uom'               => $material_uom,
            'shelf_life'        => $material_shelf_life,
            'item_application'  => $material_item_application,
            'required_document' => $material_required_document,
            'category'          => $material_category,
            'remarks'           => $material_remarks,
            'attachment'        => $material_attachment
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Deleted: " . ' ID: ' . $id,
            'datas'         => "Deleted Data: " . $json_data,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: MATERIAL SOURCING LIST',
            'date'          => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $data = array(
            'is_active' => 0
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $id);
        $query = $blaine_local_procurement->update('material_sourcing_list', $data);

        return $query;
    }

    public function update_material_sourcing_list($id)
    {
        $attachment = $_FILES['attachment']['name'];
        $description = $this->input->post('description');
        $specification = $this->input->post('specification');
        $quantity = $this->input->post('quantity');
        $uom =  $this->input->post('uom');
        $shelf_life =  $this->input->post('shelf_life');
        $item_application =  $this->input->post('item_application');
        $required_document = $this->input->post('required_document');
        $material_category = $this->input->post('material_category');
        $purpose = $this->input->post('purpose');
        $mcode = $this->input->post('material_code');
        $date = date('Y-m-d H:i:s');

        // ACTIVITY LOG
        // GET OLD DATA BEFORE UPDATE
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->select('*');
        $blaine_local_procurement->where('id', $id);
        $datas = $blaine_local_procurement->get('material_sourcing_list');
        $material_id = $datas->row()->id;
        $material_msid = $datas->row()->msid;
        $material_mcode = $datas->row()->mcode;
        $material_description = $datas->row()->description;
        $material_specification = $datas->row()->specification;
        $material_quantity = $datas->row()->quantity;
        $material_uom = $datas->row()->uom;
        $material_shelf_life = $datas->row()->shelf_life;
        $material_item_application = $datas->row()->item_application;
        $material_required_document = $datas->row()->required_document;
        $material_category = $datas->row()->category;
        $material_remarks = $datas->row()->remarks;
        $material_attachment = $datas->row()->attachment;

        $entry_data = array(
            'id'                    => $material_id,
            'msid'                  => $material_msid,
            'mcode'                 => $material_mcode,
            'description'           => $material_description,
            'specification'         => $material_specification,
            'quantity'              => $material_quantity,
            'uom'                   => $material_uom,
            'shelf_life'            => $material_shelf_life,
            'item_application'      => $material_item_application,
            'required_document'     => $material_required_document,
            'category'              => $material_category,
            'remarks'               => $material_remarks,
            'attachment'            => $material_attachment
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Updated: Material Details: " . ' ID: ' . $id,
            'datas'         => "Previous Data: " .$json_data,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: MATERIAL SOURCING LIST',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);


        $data_material = array(
            'mcode'             => $mcode,
            'description'       => $description,
            'specification'     => $specification,
            'quantity'          => $quantity,
            'uom'               => $uom,
            'shelf_life'        => $shelf_life,
            'item_application'  => $item_application,
            'required_document' => $required_document,
            'category'          => $material_category,
            'remarks'           => $purpose,
            'attachment'        => $attachment,
            'updated_by'        => $this->session->userdata('username'),
            'updated_date'      => $date
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $id);
        $query = $blaine_local_procurement->update('material_sourcing_list', $data_material);

        return $query;
    }

    public function update_material_sourcing($id)
    {
        $company_id = $this->input->post('company_id');
        $sourcing_category = $this->input->post('sourcing_category');
        $date_required = $this->input->post('date_required');

        // ACTIVITY LOG
        // GET OLD DATA BEFORE UPDATE
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->select('*');
        $blaine_local_procurement->where('id', $id);
        $datas = $blaine_local_procurement->get('material_sourcing');
        $material_id = $datas->row()-id;
        $material_msid = $datas->row()->msid;
        $material_category = $datas->row()->category;
        $material_company_id = $datas->row()->company_id;
        $material_date_required = $datas->row()->date_required;

        $entry_data = array(
            'id'            => $material_id,
            'msid'          => $material_msid,
            'category'      => $material_category,
            'company_id'    => $material_company_id,
            'date_required' => $material_date_required
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Updated: Request Details: " . ' ID: ' . $id,
            'datas'         => "Previous Data: " . $json_data,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: MATERIAL SOURCING LIST',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $data = array(
            'category'      => $sourcing_category,
            'company_id'    => $company_id,
            'date_required' => $date_required,
            'updated_date'  => date('Y-m-d H:i:s'),
            'updated_by'    => $this->session->userdata('username')
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $id);
        $query = $blaine_local_procurement->update('material_sourcing', $data);

        return $query;

    }

    public function delete_material_sourcing($id)
    {
        // GET OLD DATA BEFORE UPDATE
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->select('*');
        $blaine_local_procurement->where('id', $id);
        $datas = $blaine_local_procurement->get('material_sourcing');
        $material_id = $datas->row()->id;
        $material_msid = $datas->row()->msid;
        $material_category = $datas->row()->category;
        $material_company_id = $datas->row()->company_id;
        $material_date_required = $datas->row()->date_required;
        $material_role_status = $datas->row()->role_status;

        $entry_data = array(
            'id'                => $material_id,
            'msid'              => $material_msid,
            'category'          => $material_category,
            'company_id'        => $material_company_id,
            'date_required'     => $material_date_required,
            'role_status'       => $material_role_status
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Deleted: " . ' ID: ' . $id,
            'datas'         => "Deleted Data: " . $json_data,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: MATERIAL SOURCING LIST',
            'date'          => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $data = array(
            'is_active' => 0
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $id);
        $query = $blaine_local_procurement->update('material_sourcing', $data);

        return $query;
    }

    public function get_material_sourcing_list()
    {
        $this->db->select("
            material_sourcing.id as id,
            material_sourcing.msid as msid,
            material_sourcing.created_date as request_date,
            CONCAT(employees.last_name, ',', employees.first_name , ', ', employees.middle_name) as requestor_name,
            material_sourcing.date_required as date_required,
            COUNT(material_sourcing_list.msid) as total_material,
            department.name as department_name,
            material_sourcing.role_status as role_status,
            material_restriction.access as emp_access,
            material_restriction.fullname as fullname
        ");
        $this->db->from('blaine_local_procurement.material_sourcing');
        $this->db->join('blaine_local_procurement.material_sourcing_list', 'blaine_local_procurement.material_sourcing_list.msid = blaine_local_procurement.material_sourcing.msid','left');
        $this->db->join('blaine_local_procurement.material_restriction', 'blaine_local_procurement.material_restriction.msid = blaine_local_procurement.material_sourcing.msid','left');
        $this->db->join('blaine_intranet.users', 'blaine_intranet.users.username = blaine_local_procurement.material_sourcing.created_by');
        $this->db->join('blaine_intranet.employees', 'blaine_intranet.employees.employee_number = blaine_intranet.users.employee_number');
        $this->db->join('blaine_intranet.employment_info', 'blaine_intranet.employment_info.employee_number = blaine_intranet.employees.employee_number');
        $this->db->join('blaine_intranet.department', 'blaine_intranet.employment_info.department = blaine_intranet.department.id');
        $this->db->where('blaine_local_procurement.material_sourcing.is_active', 1);
        $this->db->group_by('blaine_local_procurement.material_sourcing_list.msid');

        $query = $this->db->get();

        return $query->result();
    }

    public function first_msid()
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->order_by('id', 'DESC');
        $query = $blaine_local_procurement->get('material_sourcing');

        return $query->row();

    }
    public function get_suppliers()
    {
        $this->db->select("
            supplier.id as id,
            supplier.scode as scode,
            supplier.name as name,
            supplier.contact_name as contact_name,
            supplier.contact_designation as contact_designation,    
            supplier.contact_number as contact_number, 
            supplier.email as email,
            supplier.address as address,
            supplier.supplier_profile as supplier_profile
        ");
        $this->db->from('blaine_local_procurement.supplier');
        $this->db->where('blaine_local_procurement.supplier.is_active', 1);
        $this->db->order_by('blaine_local_procurement.supplier.name', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_supplier($id)
    {
        $this->db->select("
            supplier.id as id,
            supplier.scode as scode,
            supplier.name as name,
            supplier.contact_name as contact_name,
            supplier.contact_designation as contact_designation,
            supplier.contact_number as contact_number,
            supplier.email as email,
            supplier.address as address,
            supplier.supplier_profile as supplier_profile,
            supplier.attachment as attachment
        ");
        $this->db->from('blaine_local_procurement.supplier');
        $this->db->where('blaine_local_procurement.supplier.id', $id);
        
        $query = $this->db->get();
        return $query->row();
    }

    public function get_supplier_logs($scode)
    {
        $this->db->select("
            supplier_logs.id as id,
            supplier_logs.supplier_id as supplier_id,
            supplier_logs.scode as scode,
            supplier_logs.name as name,
            supplier_logs.contact_name as contact_name,
            supplier_logs.contact_designation as contact_designation,
            supplier_logs.contact_number as contact_number,
            supplier_logs.email as email,
            supplier_logs.address as address,
            supplier_logs.supplier_profile as supplier_profile,
            supplier_logs.updated_by as updated_by,
            supplier_logs.updated_date as updated_date
        ");
        $this->db->from('blaine_local_procurement.supplier_logs');
        $this->db->where('blaine_local_procurement.supplier_logs.scode', $scode);

        $query = $this->db->get();
        return $query->result();
    }

    public function add_supplier()
    {
        $this->db->trans_start();

        //Supplier Input
        $attachment = $_FILES['attachment']['name'];
        $scode = $this->input->post('scode');
        $name = $this->input->post('name');
        $contact_name = $this->input->post('contact_name');
        $contact_designation = $this->input->post('contact_designation');
        $contact_number = $this->input->post('contact_number');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $supplier_profile = $this->input->post('supplier_profile');
        $date = date('Y-m-d H:i:s');

        $data_supplier = array(
            'attachment'            => $attachment,
            'scode'                 => $scode,
            'name'                  => $name,
            'contact_name'          => $contact_name,
            'contact_designation'   => $contact_designation,
            'contact_number'        => $contact_number,
            'email'                 => $email,
            'address'               => $address,
            'supplier_profile'      => $supplier_profile,
            'created_by'            => $this->session->userdata('username'),
            'created_date'          => $date
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('supplier', $data_supplier);

        $data = array (
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Added",
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: SUPPLIER ENROLLMENT',
            'date'          => $date
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data);

        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function update_supplier($id)
    {
        // DATA
        $this->db->trans_start();

        $attachment = $_FILES['attachment']['name'];
        $scode = $this->input->post('scode');
        $name = $this->input->post('name');
        $contact_name = $this->input->post('contact_name');
        $contact_designation = $this->input->post('contact_designation');
        $contact_number = $this->input->post('contact_number');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $supplier_profile = $this->input->post('supplier_profile');
        $date = date('Y-m-d H:i:s');

        // GET OLD DATA BEFORE UPDATE
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->select('*');
        $blaine_local_procurement->where('id', $id);
        $datas = $blaine_local_procurement->get('supplier');
        $supplier_id = $datas->row()->id;
        $supplier_scode = $datas->row()->scode;
        $supplier_name = $datas->row()->name;
        $supplier_contact_name = $datas->row()->contact_name;
        $supplier_contact_designation = $datas->row()->contact_designation;
        $supplier_contact_number = $datas->row()->contact_number;
        $supplier_email = $datas->row()->email;
        $supplier_address = $datas->row()->address;
        $supplier_supplier_profile = $datas->row()->supplier_profile;
        $supplier_attachment = $datas->row()->attachment;

        $entry_data = array(
            'id'                    => $supplier_id,
            'scode'                 => $supplier_scode,
            'name'                  => $supplier_name,
            'contact_name'          => $supplier_contact_name,
            'contact_designation'   => $supplier_contact_designation,
            'contact_number'        => $supplier_contact_number,
            'email'                 => $supplier_email,
            'address'               => $supplier_address,
            'supplier_profile'      => $supplier_supplier_profile,
            'attachment'            => $supplier_attachment
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Updated: " . ' ID: ' . $id,
            'datas'         => "Previous Data: " .$json_data,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: SUPPLIER ENROLLMENT',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $data_history = array(
            'supplier_id'           => $supplier_id,
            'scode'                 => $supplier_scode,
            'name'                  => $supplier_name,
            'contact_name'          => $supplier_contact_name,
            'contact_designation'   => $supplier_contact_designation,
            'contact_number'        => $supplier_contact_number,
            'email'                 => $supplier_email,
            'address'               => $supplier_address,
            'supplier_profile'      => $supplier_supplier_profile,
            'updated_by'            => $this->session->userdata('username'),
            'updated_date'          => date('Y-m-d H:i:s')
        );

        $history_log = $this->load->database('blaine_local_procurement', TRUE);
        $history_log->insert('supplier_logs', $data_history);

        if($attachment == NULL)
        {
            $data_supplier = array(
                'scode'                 => $scode,
                'name'                  => $name,
                'contact_name'          => $contact_name,
                'contact_designation'   => $contact_designation,
                'contact_number'        => $contact_number,
                'email'                 => $email,
                'address'               => $address,
                'supplier_profile'      => $supplier_profile,
                'updated_date'          => $date,
                'updated_by'            => $this->session->userdata('username')
            );

           
            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('supplier.id',$id);
            $blaine_local_procurement->update('supplier', $data_supplier);

            /*print_r('<pre>');
            print_r($data_supplier);
            print_r('</pre>');*/
            
        }
        else
        {
            $data_supplier = array(
                'scode'                 => $scode,
                'name'                  => $name,
                'contact_name'          => $contact_name,
                'contact_designation'   => $contact_designation,
                'contact_number'        => $contact_number,
                'email'                 => $email,
                'address'               => $address,
                'supplier_profile'      => $supplier_profile,
                'attachment'            => $attachment,
                'updated_date'          => $date,
                'updated_by'            => $this->session->userdata('username')
            );

           
            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('supplier.id',$id);
            $blaine_local_procurement->update('supplier', $data_supplier);

            /*print_r('<pre>');
            print_r($data_supplier);
            print_r('</pre>');*/
        }
        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function delete_supplier($id)
    {
        // GET OLD DATA BEFORE UPDATE
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->select('*');
        $blaine_local_procurement->where('id', $id);
        $datas = $blaine_local_procurement->get('supplier');
        $supplier_id = $datas->row()->id;
        $supplier_scode = $datas->row()->scode;
        $supplier_name = $datas->row()->name;
        $supplier_contact_name = $datas->row()->contact_name;
        $supplier_contact_designation = $datas->row()->contact_designation;
        $supplier_contact_number = $datas->row()->contact_number;
        $supplier_email = $datas->row()->email;
        $supplier_address = $datas->row()->address;
        $supplier_supplier_profile = $datas->row()->supplier_profile;
        $supplier_attachment = $datas->row()->attachment;

        $entry_data = array(
            'id'                        => $supplier_id,
            'scode'                     => $supplier_scode,
            'name'                      => $supplier_name,
            'contact_name'              => $supplier_contact_name,
            'contact_designation'       => $supplier_contact_designation,
            'contact_number'            => $supplier_contact_number,
            'email'                     => $supplier_email,
            'address'                   => $supplier_address,
            'supplier_profile'          => $supplier_supplier_profile,
            'attachment'                => $supplier_attachment
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Deleted: " . ' ID: ' . $id,
            'datas'         => "Deleted Data: " . $json_data,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: SUPPLIER ENROLLMENT',
            'date'          => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $data_supplier = array(
            'is_active' => 0
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $id);
        $query = $blaine_local_procurement->update('supplier', $data_supplier);

        return $query;
    }

    public function get_materials()
    {
        $this->db->select("
            material.id as id,
            material.mcode as mcode,
            material.description as description,
            material.group_code as code_id,
            material_group.name as group_name
        ");

        $this->db->from('blaine_local_procurement.material');
        $this->db->join('blaine_local_procurement.material_group', 'blaine_local_procurement.material.group_code = blaine_local_procurement.material_group.code');
        
        $this->db->where('blaine_local_procurement.material.is_active', 1);
        $this->db->group_by('mcode');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_material_type()
    {

        $this->db->select("
            material_type.id as id,
            material_type.code as code,
            material_type.type_name as type_name
        ");
        $this->db->from('blaine_local_procurement.material_type');

        $query = $this->db->get();
        return $query->result();

        //$blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        //$blaine_local_procurement->order_by('name', 'ASC');
        //$query = $blaine_local_procurement->get('material_type');

        //return $query->result();
    }

    public function get_material($id)
    {
        $this->db->select("
            material.id as id,
            material.mcode as mcode,
            material.description as description,
            material.group_code as code_id,
            material_group.name as group_name
        ");
        $this->db->from('blaine_local_procurement.material');
        $this->db->join('blaine_local_procurement.material_group', 'blaine_local_procurement.material.group_code = blaine_local_procurement.material_group.code');
        $this->db->where('blaine_local_procurement.material.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function get_material_group()
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->order_by('name', 'ASC');
        $query = $blaine_local_procurement->get('material_group');

        return $query->result();
    }

    public function add_material()
    {
        $this->db->trans_start();

        $mcode = $this->input->post('mcode');
        $description = $this->input->post('description');
        $material_group = $this->input->post('material_group');
        $date = date('Y-m-d H:i:s');

        $data = array(
            'mcode'        => $mcode,
            'description'  => $description,
            'group_code'   => $material_group,
            'created_by'   => $this->session->userdata('username'),
            'created_date' => $date
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material', $data);
        //$query = $blaine_local_procurement->insert('material', $data);

        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Added",
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: MATERIAL ENROLLMENT',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function update_material($id)
    {
        $this->db->trans_start();

        $mcode = $this->input->post('mcode');
        $description = $this->input->post('description');
        $material_group = $this->input->post('material_group');
        $date = date('Y-m-d H:i:s');

        // GET OLD DATA BEFORE UPDATE
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->select('*');
        $blaine_local_procurement->where('id', $id);
        $datas = $blaine_local_procurement->get('material');
        $material_id = $datas->row()->id;
        $material_mcode = $datas->row()->mcode;
        $material_description = $datas->row()->description;
        $material_group_code = $datas->row()->group_code;

        $entry_data = array(
            'id'            => $material_id,
            'mcode'         => $material_mcode,
            'description'   => $material_description,
            'group_code'    => $material_group_code  
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Updated: " . ' ID: ' . $id,
            'datas'         => "Previous Data: " . $json_data,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: MATERIAL ENROLLMENT',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $data = array(
            'mcode'        => $mcode,
            'description'  => $description,
            'group_code'   => $material_group,
            'updated_by'   => $this->session->userdata('username'),
            'updated_date' => $date
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $id);
        $blaine_local_procurement->update('material', $data);
        //$query = $blaine_local_procurement->update('material', $data);

        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function delete_material($id)
    {
        // GET OLD DATA BEFORE UPDATE
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->select('*');
        $blaine_local_procurement->where('id', $id);
        $datas = $blaine_local_procurement->get('material');
        $material_id = $datas->row()->id;
        $material_mcode = $datas->row()->mcode;
        $material_description = $datas->row()->description;
        $material_group_code = $datas->row()->group_code;

        $entry_data = array(
            'id'            => $material_id,
            'mcode'         => $material_mcode,
            'description'   => $material_description,
            'group_code'    => $material_group_code
        );

        $json_data = json_encode($entry_data);

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Deleted: " . ' ID: ' . $id,
            'datas'         => "Deleted Data: " . $json_data,
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: MATERIAL ENROLLMENT',
            'date'          => date('Y-m-d H:i:s')
        );

        // CALL ACTIVITY LOGS DATABASE
        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $data_material = array(
            'is_active' => 0
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $id);
        $query = $blaine_local_procurement->update('material', $data_material);
    
        return $query;
    }

    public function get_uom()
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $query = $blaine_local_procurement->get('uom');

        return $query->result();
    }

    public function get_material_source($id)
    {
      
        $this->db->select("
            material_sourcing.id as id,
            material_sourcing.msid as msid,
            material_sourcing.created_date as request_date,
            material_sourcing.date_required as date_required,
            material_sourcing.category as category,
            material_sourcing.created_date as created_date,
            material_sourcing.role_status as role_status,
            material_sourcing.is_no_transmittal as is_no_transmittal,
            company.name as company_name,
            company.code as code,
            material_restriction.access as emp_access,
            material_restriction.email as email,
            material_restriction.access as access,
            material_approval_list.primary_approver as primary_approver,
            material_approval_list.alternate_approver as alternate_approver,
        ");
        $this->db->from('blaine_local_procurement.material_sourcing');
        $this->db->join('blaine_local_procurement.material_restriction', 'blaine_local_procurement.material_restriction.msid = blaine_local_procurement.material_sourcing.msid','left');
        $this->db->join('blaine_local_procurement.material_approval_list', 'blaine_local_procurement.material_approval_list.msid = blaine_local_procurement.material_sourcing.msid','left');
        $this->db->join('blaine_intranet.company', 'blaine_intranet.company.id = blaine_local_procurement.material_sourcing.company_id');
        $this->db->where('material_approval_list.role_status', 'Superior');
        $this->db->where('material_sourcing.id', $id);
      
        $query = $this->db->get();

        return $query->row();
    }

    public function get_materials_by_material_sourcing_id($msid)
    {

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('msid', $msid);
        $blaine_local_procurement->where('is_active !=', 0);
        $query = $blaine_local_procurement->get('material_sourcing_list');

        return $query->result();
    }

    public function get_material_list()
    {

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $query = $blaine_local_procurement->get('material_sourcing_list');

        return $query->result();
    }
    
    public function get_material_source_list()
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('is_active', 1);
        $query = $blaine_local_procurement->get('material_sourcing');

        return $query->result();
    }

    public function get_material_restriction()
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $query = $blaine_local_procurement->get('material_restriction');

        return $query->result();
    }

    public function get_approval_by_material_sourcing_id($msid)
    {
        $this->db->select("
            material_approval_list.primary_approver as primary_approver,
            material_approval_list.alternate_approver as alternate_approver,
            material_approval_list.status as status,
            material_approval_list.remarks as remarks,
            material_approval_list.signoff_by as signoff_by,
            material_approval_list.signoff_date as signoff_date,
            material_approval_list.role_status as role_status,
            step_of_approver.name as step_of_approval,
            material_approval_list.created_date as created_date,
            material_approval_list.cycle_time as cycle_time
        ");

        $this->db->from('blaine_local_procurement.material_approval_list');
        $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
        $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_last_approval_by_material_sourcing_id($msid)
    {
        $this->db->select("
            material_approval_list.id as id,
            material_approval_list.primary_approver as primary_approver,
            material_approval_list.alternate_approver as alternate_approver,
            material_approval_list.status as status,
            material_approval_list.step_approval as step_approval,
            material_approval_list.role_status as role_status,
            material_approval_list.created_by as created_by,
            material_approval_list.created_date as created_date
        ");

        $this->db->from('blaine_local_procurement.material_approval_list');
        $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
        $this->db->order_by('blaine_local_procurement.material_approval_list.id', 'DESC');
        $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_first_approval_by_material_sourcing_id($msid)
    {
        $this->db->select("
            material_approval_list.primary_approver as primary_approver,
            material_approval_list.alternate_approver as alternate_approver,
            material_approval_list.status as status,
            material_approval_list.role_status as role_status,
            material_approval_list.signoff_by as signoff_by,
            material_approval_list.remarks as remarks
        ");

        $this->db->from('blaine_local_procurement.material_approval_list');
        $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
        $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
        $query = $this->db->get();

        return $query->row();
    }

    public function material_source_approval_process()
    {
        $this->db->trans_start();

        // Get Request Details
        $source_id = $this->input->post('source_id');
        $company = $this->input->post('company');
        $msid = $this->input->post('msid');
        $category = $this->input->post('category');
        $date_required = $this->input->post('date_required');
        $date_requested = $this->input->post('date_requested');

        // Get Date
        $date = date('Y-m-d H:i:s');
        $sign_date = date('Y-m-d');
        
        // Get Requestor Approval
        $last_entry_id = $this->input->post('id');
        $primary_approver = $this->input->post('primary_approver');
        $alternate_approver = $this->input->post('alternate_approver');
        $role_status = $this->input->post('role_status');
        $process = $this->input->post('approve_detail');
        $req_signoff_by = $this->input->post('req_signoff_by');
        $req_remarks = $this->input->post('req_remarks');
        $cycle_time = $this->input->post('cycle_time');
       

        // Get Superior Approval
        $remarks = $this->input->post('remarks');
        $requestor_approver = $this->input->post('request_approver');
        $primary_approver_superior = $this->input->post('primary_approver_superior');
        $alternate_approver_superior = $this->input->post('alternate_approver_superior');
        $destination_approval = $this->input->post('destination_approval');
        $primary_approver_procurement = $this->input->post('primary_approver1');
        $alternate_approver_procurement = $this->input->post('alternate_approver1');

        // Email Subject
        // Step Approver 2 Immediate Superior Approval
        $subject_2 = "MSID # " . $msid . " - Immediate Superior Approval";
        $subject_3 = "MSID # " . $msid . " - Procurement Request Acceptance";
        $subject_4 = "MSID # " . $msid . " - Procurement Report Generation";
        $subject_5 = "MSID # " . $msid . " - Requestor Action Required";
        $subject_6 = "MSID # " . $msid . " - Requestor Feedback";
        $subject_7 = "MSID # " . $msid . " - Request Cancelled";

        // Get email accounts
        $data_explod = explode(',', $this->input->post('email_accounts'));
        
        // Requestor Email
        $req_primary_email1 = $data_explod[0];
        $req_alternate_email1 = $data_explod[1];

        // Superior Email
        $req_primary_email2 = $data_explod[2];
        $req_alternate_email2 = $data_explod[3];

        // Procurement Email
        $procurement = ('primaryprocurement11@gmail.com, alternateprocurement11@gmail.com');
        
        // Superior Approval
        $recipient1 = $req_primary_email1.','.$req_alternate_email1.','.$procurement;
        $recipient1_cc = $req_primary_email2.','.$req_alternate_email2;

        // Procurement Approval
        $recipient2 = $req_primary_email1.','.$req_alternate_email1;
        $recipient2_cc = $req_primary_email2.','.$req_alternate_email2.','.$procurement;

        // Superior Action Required
        $recipient3 = $req_primary_email1.','.$req_alternate_email1;
        $recipient3_cc = $req_primary_email2.','.$req_alternate_email2;

        // Done Superior Action Required
        $recipient4 = $req_primary_email1.','.$req_alternate_email1.','.$req_primary_email2.','.$req_alternate_email2;
        
        // APPROVE
        if($process == 1)
        {
            if($role_status == "Requestor")
            {
               
                $data_update_last_entry = array(
                    'status'       => 'Done',
                    'signoff_by'   => $this->session->userdata('username'),
                    'signoff_date' => $date,
                    'remarks'      => $remarks,
                    'cycle_time'   => $cycle_time
                );  
    
                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->where('id', $last_entry_id);
                $blaine_local_procurement->update('material_approval_list', $data_update_last_entry);
    
                /*print_r('<pre>');
                print_r($data_update_last_entry);
                print_r('</pre>');*/
        
                // REQUESTOR ACTION REQUIRED FROM SUPERIOR
                if($destination_approval == 1)
                {
                    $data_material_source = array(
                        'role_status' => 'Pending Superior'
                    );
        
                    $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                    $blaine_local_procurement->where('msid', $msid);
                    $blaine_local_procurement->update('material_sourcing', $data_material_source);
        
                    /*print_r('<pre>');
                    print_r($data_material_source);
                    print_r('</pre>');*/

                    $data_action_required = array(
                        'msid'               => $msid,
                        'primary_approver'   => $primary_approver_superior,
                        'alternate_approver' => $alternate_approver_superior,
                        'role_status'        => 'Superior',
                        'status'             => 'Pending',
                        'created_by'         => $this->session->userdata('username') . ' 0',
                        'created_date'       => $date,
                        'step_approval'      => 2
        
                    );
        
                    $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                    $blaine_local_procurement->insert('material_approval_list', $data_action_required);
        
                    /*print_r('<pre>');
                    print_r($data_action_required);
                    print_r('</pre>');*/

                    /* Auto-Email After Doing Superior Action Required */
                    // Get approval details
                    $this->db->select("
                        material_approval_list.primary_approver as primary_approver,
                        material_approval_list.alternate_approver as alternate_approver,
                        material_approval_list.status as status,
                        material_approval_list.remarks as remarks,
                        material_approval_list.signoff_by as signoff_by,
                        material_approval_list.signoff_date as signoff_date,
                        material_approval_list.cycle_time as cycle_time,
                        material_approval_list.role_status as role_status,
                        step_of_approver.name as step_of_approval
                    ");

                    $this->db->from('blaine_local_procurement.material_approval_list');
                    $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
                    $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
                    $query = $this->db->get();

                    $approval_lists = $query->result();

                    foreach($approval_lists as $approval_list)
                    {
                        $e_step_of_approval = $approval_list->step_of_approval;
                        $e_primary_approver = $approval_list->primary_approver;
                        $e_alternate_approver = $approval_list->alternate_approver;
                        $e_status = $approval_list->status;
                        $e_signoff_date = $approval_list->signoff_date;
                        $e_cycle_time = $approval_list->cycle_time;
                        $e_signoff_by = $approval_list->signoff_by;
                        $e_remarks = $approval_list->remarks;

                        $approver .= '<tbody>
                            <tr>
                                <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                                <td style="font-size:12px">'.$e_primary_approver.'</td>
                                <td style="font-size:12px">'.$e_alternate_approver.'</td>
                                <td style="font-size:12px">'.$e_status.'</td>
                                <td style="font-size:12px">'.$e_signoff_date.'</td>
                                <td style="font-size:12px">'.$e_cycle_time.'</td>
                                <td style="font-size:12px">'.$e_signoff_by.'</td>
                                <td style="font-size:12px">'.$e_remarks.'</td>
                            </tr>
                        </tbody>';
                    }
                    $format .= '<!DOCTYPE html>
                    <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width,initial-scale=1">
                            <meta name="x-apple-disable-message-reformatting">
                            <title></title>
                            <style>
                                table, td, div, h1, p {font-family: Arial, sans-serif;}
                            </style>
                        </head>
                        <body style="margin:0;padding:0;">
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                                <tr>
                                    <td align="center" style="padding:0;">
                                        <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                            <tr>
                                                <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                                    BLAINE INTRANET
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                                    Electronic Material Sourcing Request
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                                <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                                </td>
                                            </tr>
                                            <tr>	
                                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                                    <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px 30px 0px 30px;">
                                                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                        <tr>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0;">
                                                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                                    <tr>
                                                                        <td style="width:260px;padding:0;vertical-align:top;">
                                                                            <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$company.'</p>
                                                                        </td>
                                                                        <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                        <td style="width:260px;padding:0;vertical-align:top;">
                                                                            <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:260px;padding:0;vertical-align:top;">
                                                                            <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$category.'</p>
                                                                        </td>
                                                                        <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                        <td style="width:260px;padding:0;vertical-align:top;">
                                                                            <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:260px;padding:0;vertical-align:top;">
                                                                            <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                                    <div class="row">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                                    <th scope="col" style="font-size:12px">Step/Approver</th>
                                                                    <th scope="col" style="font-size:12px">Primary Approver</th>
                                                                    <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                                    <th scope="col" style="font-size:12px">Status</th>
                                                                    <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                                    <th scope="col" style="font-size:12px">Date CT</th>
                                                                    <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                                    <th scope="col" style="font-size:12px">Remarks</th>
                                                                </tr>
                                                            </thead>
                                                            '.$approver.'
                                                        </table>
                                                    </div>
                                                    <br>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <table border="0" cellpadding="0" cellspacing="0" align="center"
                                    width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                    max-width: 560px;" class="wrapper">
                                    <tr>
                                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                            padding-top: 20px;
                                            padding-bottom: 20px;
                                            color: #999999;
                                            font-family: sans-serif;" class="footer">
                                            <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                            <br>This is an auto-generated email from Blaine Intranet system.
                                            <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                            src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                                        </td>
                                    </tr>
                                </table>
                            </table>
                        </body>
                    </html>';
                        
                    $config = Array(
                        'protocol'      => 'smtp',
                        'smtp_host'     => 'mail.blainegroup.com.ph',
                        'smtp_crypto'   => 'ssl',
                        'smtp_port'     => 465,
                        'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
                        'smtp_pass'     => '@Bl@ine2021', // change it to yours
                        'mailtype'      => 'html',
                        'charset'       => 'iso-8859-1',
                        'wordwrap'      => TRUE
                    );

                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");
                    $this->email->from($config['smtp_user']); // change it to yours
                    $this->email->to($recipient4);// change it to yours
                    //$this->email->cc($recipient3);
                    //$this->email->bcc($bcc);
                    $this->email->subject($subject_5);
                    $this->email->message($format);
                    if($this->email->send()){
                        $this->session->set_flashdata('message', 'Email sent');
                    }
                    else{
                        $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
                    }
                }

                // REQUESTOR ACTION REQUIRED FROM PROCUREMENT
                elseif($destination_approval == 2)
                {
                    $data_material_source = array(
                        'role_status' => 'Pending Procurement'
                    );
        
                    $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                    $blaine_local_procurement->where('msid', $msid);
                    $blaine_local_procurement->update('material_sourcing', $data_material_source);
        
                    /*print_r('<pre>');
                    print_r($data_material_source);
                    print_r('</pre>');*/

                    $data_action_required = array(
                        'msid'               => $msid,
                        'primary_approver'   => "CATANGUI, SHARON ROSE BALLES",
                        'alternate_approver' => "DEL PILAR, JENIFFER ALVAREZ",
                        'role_status'        => "Procurement",
                        'status'             => 'Pending',
                        'created_by'         => $this->session->userdata('username') . ' 0',
                        'created_date'       => $date,
                        'step_approval'      => 9
        
                    );
        
                    $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                    $blaine_local_procurement->insert('material_approval_list', $data_action_required);
        
                    /*print_r('<pre>');
                    print_r($data_action_required);
                    print_r('</pre>');*/

                    /* Auto-Email After Doing Superior Action Required */
                    // Get approval details
                    $this->db->select("
                        material_approval_list.primary_approver as primary_approver,
                        material_approval_list.alternate_approver as alternate_approver,
                        material_approval_list.status as status,
                        material_approval_list.remarks as remarks,
                        material_approval_list.signoff_by as signoff_by,
                        material_approval_list.signoff_date as signoff_date,
                        material_approval_list.cycle_time as cycle_time,
                        material_approval_list.role_status as role_status,
                        step_of_approver.name as step_of_approval
                    ");

                    $this->db->from('blaine_local_procurement.material_approval_list');
                    $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
                    $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
                    $query = $this->db->get();

                    $approval_lists = $query->result();

                    foreach($approval_lists as $approval_list)
                    {
                        $e_step_of_approval = $approval_list->step_of_approval;
                        $e_primary_approver = $approval_list->primary_approver;
                        $e_alternate_approver = $approval_list->alternate_approver;
                        $e_status = $approval_list->status;
                        $e_signoff_date = $approval_list->signoff_date;
                        $e_cycle_time = $approval_list->cycle_time;
                        $e_signoff_by = $approval_list->signoff_by;
                        $e_remarks = $approval_list->remarks;

                        $approver .= '<tbody>
                            <tr>
                                <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                                <td style="font-size:12px">'.$e_primary_approver.'</td>
                                <td style="font-size:12px">'.$e_alternate_approver.'</td>
                                <td style="font-size:12px">'.$e_status.'</td>
                                <td style="font-size:12px">'.$e_signoff_date.'</td>
                                <td style="font-size:12px">'.$e_cycle_time.'</td>
                                <td style="font-size:12px">'.$e_signoff_by.'</td>
                                <td style="font-size:12px">'.$e_remarks.'</td>
                            </tr>
                        </tbody>';
                    }
                    $format .= '<!DOCTYPE html>
                    <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width,initial-scale=1">
                            <meta name="x-apple-disable-message-reformatting">
                            <title></title>
                            <style>
                                table, td, div, h1, p {font-family: Arial, sans-serif;}
                            </style>
                        </head>
                        <body style="margin:0;padding:0;">
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                                <tr>
                                    <td align="center" style="padding:0;">
                                        <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                            <tr>
                                                <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                                    BLAINE INTRANET
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                                    Electronic Material Sourcing Request
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                                <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                                </td>
                                            </tr>
                                            <tr>	
                                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                                    <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px 30px 0px 30px;">
                                                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                        <tr>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0;">
                                                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                                    <tr>
                                                                        <td style="width:260px;padding:0;vertical-align:top;">
                                                                            <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$company.'</p>
                                                                        </td>
                                                                        <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                        <td style="width:260px;padding:0;vertical-align:top;">
                                                                            <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:260px;padding:0;vertical-align:top;">
                                                                            <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$category.'</p>
                                                                        </td>
                                                                        <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                        <td style="width:260px;padding:0;vertical-align:top;">
                                                                            <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:260px;padding:0;vertical-align:top;">
                                                                            <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                                    <div class="row">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                                    <th scope="col" style="font-size:12px">Step/Approver</th>
                                                                    <th scope="col" style="font-size:12px">Primary Approver</th>
                                                                    <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                                    <th scope="col" style="font-size:12px">Status</th>
                                                                    <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                                    <th scope="col" style="font-size:12px">Date CT</th>
                                                                    <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                                    <th scope="col" style="font-size:12px">Remarks</th>
                                                                </tr>
                                                            </thead>
                                                            '.$approver.'
                                                        </table>
                                                    </div>
                                                    <br>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <table border="0" cellpadding="0" cellspacing="0" align="center"
                                    width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                    max-width: 560px;" class="wrapper">
                                    <tr>
                                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                            padding-top: 20px;
                                            padding-bottom: 20px;
                                            color: #999999;
                                            font-family: sans-serif;" class="footer">
                                            <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                            <br>This is an auto-generated email from Blaine Intranet system.
                                            <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                            src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                                        </td>
                                    </tr>
                                </table>
                            </table>
                        </body>
                    </html>';
                        
                    $config = Array(
                        'protocol'      => 'smtp',
                        'smtp_host'     => 'mail.blainegroup.com.ph',
                        'smtp_crypto'   => 'ssl',
                        'smtp_port'     => 465,
                        'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
                        'smtp_pass'     => '@Bl@ine2021', // change it to yours
                        'mailtype'      => 'html',
                        'charset'       => 'iso-8859-1',
                        'wordwrap'      => TRUE
                    );

                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");
                    $this->email->from($config['smtp_user']); // change it to yours
                    $this->email->to($recipient1);// change it to yours
                    $this->email->cc($recipient1_cc);
                    //$this->email->bcc($bcc);
                    $this->email->subject($subject_5);
                    $this->email->message($format);
                    if($this->email->send()){
                        $this->session->set_flashdata('message', 'Email sent');
                    }
                    else{
                        $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
                    }
                }

            }

            // IMMEDIATE SUPERIOR APPROVAL
            elseif($role_status == 'Superior')
            {
                $data_material_source = array(
                    'role_status' => 'Pending Procurement'
                );
    
                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->where('msid', $msid);
                $blaine_local_procurement->update('material_sourcing', $data_material_source);
    
                /*print_r('<pre>');
                print_r($data_material_source);
                print_r('</pre>');*/
    
    
                $data_update_last_entry = array(
                    'status'       => 'Done',
                    'signoff_by'   => $this->session->userdata('username'),
                    'signoff_date' => $date,
                    'remarks'      => $remarks,
                    'cycle_time'   => $cycle_time
                );  
    
                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->where('id', $last_entry_id);
                $blaine_local_procurement->update('material_approval_list', $data_update_last_entry);
    
                /*print_r('<pre>');
                print_r($data_update_last_entry);
                print_r('</pre>');*/
    
                $data_action_required = array(
                    'msid'               => $msid,
                    'primary_approver'   => "CATANGUI, SHARON ROSE BALLES",
                    'alternate_approver' => "DEL PILAR, JENIFFER ALVAREZ",
                    'role_status'        => "Procurement",
                    'status'             => 'Pending',
                    'created_by'         => $this->session->userdata('username') . ' 0',
                    'created_date'       => $date,
                    'step_approval'      => 3
    
                );
    
                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->insert('material_approval_list', $data_action_required);
    
                /*print_r('<pre>');
                print_r($data_action_required);
                print_r('</pre>');*/

                /* Auto-Email After Superior Approval */
                // Get approval details
                $this->db->select("
                    material_approval_list.primary_approver as primary_approver,
                    material_approval_list.alternate_approver as alternate_approver,
                    material_approval_list.status as status,
                    material_approval_list.remarks as remarks,
                    material_approval_list.signoff_by as signoff_by,
                    material_approval_list.signoff_date as signoff_date,
                    material_approval_list.cycle_time as cycle_time,
                    material_approval_list.role_status as role_status,
                    step_of_approver.name as step_of_approval
                ");

                $this->db->from('blaine_local_procurement.material_approval_list');
                $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
                $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
                $query = $this->db->get();

                $approval_lists = $query->result();

                foreach($approval_lists as $approval_list)
                {
                    $e_step_of_approval = $approval_list->step_of_approval;
                    $e_primary_approver = $approval_list->primary_approver;
                    $e_alternate_approver = $approval_list->alternate_approver;
                    $e_status = $approval_list->status;
                    $e_signoff_date = $approval_list->signoff_date;
                    $e_cycle_time = $approval_list->cycle_time;
                    $e_signoff_by = $approval_list->signoff_by;
                    $e_remarks = $approval_list->remarks;

                    $approver .= '<tbody>
                        <tr>
                            <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                            <td style="font-size:12px">'.$e_primary_approver.'</td>
                            <td style="font-size:12px">'.$e_alternate_approver.'</td>
                            <td style="font-size:12px">'.$e_status.'</td>
                            <td style="font-size:12px">'.$e_signoff_date.'</td>
                            <td style="font-size:12px">'.$e_cycle_time.'</td>
                            <td style="font-size:12px">'.$e_signoff_by.'</td>
                            <td style="font-size:12px">'.$e_remarks.'</td>
                        </tr>
                    </tbody>';
                }
                
                $format .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width,initial-scale=1">
                        <meta name="x-apple-disable-message-reformatting">
                        <title></title>
                        <style>
                            table, td, div, h1, p {font-family: Arial, sans-serif;}
                        </style>
                    </head>
                    <body style="margin:0;padding:0;">
                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                            <tr>
                                <td align="center" style="padding:0;">
                                    <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                        <tr>
                                            <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                                BLAINE INTRANET
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                                Electronic Material Sourcing Request
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                            <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                            </td>
                                        </tr>
                                        <tr>	
                                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                                <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:10px 30px 0px 30px;">
                                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                    <tr>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:0;">
                                                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$company.'</p>
                                                                    </td>
                                                                    <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$category.'</p>
                                                                    </td>
                                                                    <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                                <div class="row">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                                <th scope="col" style="font-size:12px">Step/Approver</th>
                                                                <th scope="col" style="font-size:12px">Primary Approver</th>
                                                                <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                                <th scope="col" style="font-size:12px">Status</th>
                                                                <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                                <th scope="col" style="font-size:12px">Date CT</th>
                                                                <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                                <th scope="col" style="font-size:12px">Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        '.$approver.'
                                                    </table>
                                                </div>
                                                <br>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <table border="0" cellpadding="0" cellspacing="0" align="center"
                                width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                max-width: 560px;" class="wrapper">
                                <tr>
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                        padding-top: 20px;
                                        padding-bottom: 20px;
                                        color: #999999;
                                        font-family: sans-serif;" class="footer">
                                        <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                        <br>This is an auto-generated email from Blaine Intranet system.
                                        <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                        src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                                    </td>
                                </tr>
                            </table>
                        </table>
                    </body>
                </html>';

                

                $config = Array(
                    'protocol'      => 'smtp',
                    'smtp_host'     => 'mail.blainegroup.com.ph',
                    'smtp_crypto'   => 'ssl',
                    'smtp_port'     => 465,
                    'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
                    'smtp_pass'     => '@Bl@ine2021', // change it to yours
                    'mailtype'      => 'html',
                    'charset'       => 'iso-8859-1',
                    'wordwrap'      => TRUE
                );

                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from($config['smtp_user']); // change it to yours
                $this->email->to($recipient1);// change it to yours
                $this->email->cc($recipient1_cc);
                //$this->email->bcc($bcc);
                $this->email->subject($subject_2);
                $this->email->message($format);
                if($this->email->send()){
                    $this->session->set_flashdata('message', 'Email sent');
                }
                else{
                    $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
                }
                
            }

            // PROCUREMENT ACCEPTANCE
            elseif($role_status == 'Procurement')
            {
                $data_material_source = array(
                    'role_status' => 'Open Procurement'
                );
    
                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->where('msid', $msid);
                $blaine_local_procurement->update('material_sourcing', $data_material_source);
    
                /*print_r('<pre>');
                print_r($data_material_source);
                print_r('</pre>');*/

    
                $data_update_last_entry = array(
                    'status'       => 'Done',
                    'signoff_by'   => $this->session->userdata('username'),
                    'signoff_date' => $date,
                    'remarks'      => $remarks,
                    'cycle_time'   => $cycle_time
                );  
    
                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->where('id', $last_entry_id);
                $blaine_local_procurement->update('material_approval_list', $data_update_last_entry);
    
                /*print_r('<pre>');
                print_r($data_update_last_entry);
                print_r('</pre>');*/
        

                $data_action_required = array(
                    'msid'               => $msid,
                    'primary_approver'   => $primary_approver_procurement,
                    'alternate_approver' => $alternate_approver_procurement,
                    'role_status'        => 'Procurement',
                    'status'             => 'Pending',
                    'created_by'         => $this->session->userdata('username') . ' 0',
                    'created_date'       => $date,
                    'step_approval'      => 4
    
                );
    
                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->insert('material_approval_list', $data_action_required);
    
                /*print_r('<pre>');
                print_r($data_action_required);
                print_r('</pre>');*/

                /* Auto-Email After Procurement Approval */
                // Get approval details
                $this->db->select("
                    material_approval_list.primary_approver as primary_approver,
                    material_approval_list.alternate_approver as alternate_approver,
                    material_approval_list.status as status,
                    material_approval_list.remarks as remarks,
                    material_approval_list.signoff_by as signoff_by,
                    material_approval_list.signoff_date as signoff_date,
                    material_approval_list.cycle_time as cycle_time,
                    material_approval_list.role_status as role_status,
                    step_of_approver.name as step_of_approval
                ");

                $this->db->from('blaine_local_procurement.material_approval_list');
                $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
                $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
                $query = $this->db->get();

                $approval_lists = $query->result();

                foreach($approval_lists as $approval_list)
                {
                    $e_step_of_approval = $approval_list->step_of_approval;
                    $e_primary_approver = $approval_list->primary_approver;
                    $e_alternate_approver = $approval_list->alternate_approver;
                    $e_status = $approval_list->status;
                    $e_signoff_date = $approval_list->signoff_date;
                    $e_cycle_time = $approval_list->cycle_time;
                    $e_signoff_by = $approval_list->signoff_by;
                    $e_remarks = $approval_list->remarks;

                    $approver .= '<tbody>
                        <tr>
                            <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                            <td style="font-size:12px">'.$e_primary_approver.'</td>
                            <td style="font-size:12px">'.$e_alternate_approver.'</td>
                            <td style="font-size:12px">'.$e_status.'</td>
                            <td style="font-size:12px">'.$e_signoff_date.'</td>
                            <td style="font-size:12px">'.$e_cycle_time.'</td>
                            <td style="font-size:12px">'.$e_signoff_by.'</td>
                            <td style="font-size:12px">'.$e_remarks.'</td>
                        </tr>
                    </tbody>';
                }
                $format .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width,initial-scale=1">
                        <meta name="x-apple-disable-message-reformatting">
                        <title></title>
                        <style>
                            table, td, div, h1, p {font-family: Arial, sans-serif;}
                        </style>
                    </head>
                    <body style="margin:0;padding:0;">
                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                            <tr>
                                <td align="center" style="padding:0;">
                                    <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                        <tr>
                                            <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                                BLAINE INTRANET
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                                Electronic Material Sourcing Request
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                            <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                            </td>
                                        </tr>
                                        <tr>	
                                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                                <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:10px 30px 0px 30px;">
                                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                    <tr>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:0;">
                                                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$company.'</p>
                                                                    </td>
                                                                    <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$category.'</p>
                                                                    </td>
                                                                    <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                                <div class="row">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                                <th scope="col" style="font-size:12px">Step/Approver</th>
                                                                <th scope="col" style="font-size:12px">Primary Approver</th>
                                                                <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                                <th scope="col" style="font-size:12px">Status</th>
                                                                <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                                <th scope="col" style="font-size:12px">Date CT</th>
                                                                <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                                <th scope="col" style="font-size:12px">Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        '.$approver.'
                                                    </table>
                                                </div>
                                                <br>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <table border="0" cellpadding="0" cellspacing="0" align="center"
                                width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                max-width: 560px;" class="wrapper">
                                <tr>
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                        padding-top: 20px;
                                        padding-bottom: 20px;
                                        color: #999999;
                                        font-family: sans-serif;" class="footer">
                                        <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                        <br>This is an auto-generated email from Blaine Intranet system.
                                        <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                        src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                                    </td>
                                </tr>
                            </table>
                        </table>
                    </body>
                </html>';

                

                $config = Array(
                    'protocol'      => 'smtp',
                    'smtp_host'     => 'mail.blainegroup.com.ph',
                    'smtp_crypto'   => 'ssl',
                    'smtp_port'     => 465,
                    'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
                    'smtp_pass'     => '@Bl@ine2021', // change it to yours
                    'mailtype'      => 'html',
                    'charset'       => 'iso-8859-1',
                    'wordwrap'      => TRUE
                );

                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from($config['smtp_user']); // change it to yours
                $this->email->to($recipient2);// change it to yours
                $this->email->cc($recipient2_cc);
                //$this->email->bcc($bcc);
                $this->email->subject($subject_3);
                $this->email->message($format);
                if($this->email->send()){
                    $this->session->set_flashdata('message', 'Email sent');
                }
                else{
                    $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
                }

            }
        }

        // ACTION REQUIRED
        elseif($process == 3)
        {
            $data_material_source = array(
                'role_status' => 'Pending Requestor'
            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('msid', $msid);
            $blaine_local_procurement->update('material_sourcing', $data_material_source);

            /*print_r('<pre>');
            print_r($data_material_source);
            print_r('</pre>');*/

            $data_update_last_entry = array(
                'status'       => 'Action Required',
                'signoff_by'   => $this->session->userdata('username'),
                'signoff_date' => $date,
                'remarks'      => $remarks,
                'cycle_time'   => $cycle_time
            );  

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('id', $last_entry_id);
            $blaine_local_procurement->update('material_approval_list', $data_update_last_entry);

            /*print_r('<pre>');
            print_r($data_update_last_entry);
            print_r('</pre>');*/
    
            // ACTION REQUIRED FROM SUPERIOR
            if($role_status == 'Superior')
            {
                $data_action_required = array(
                    'msid'               => $msid,
                    'primary_approver'   => $primary_approver,
                    'alternate_approver' => $alternate_approver,
                    'role_status'        => 'Requestor',
                    'status'             => 'Pending',
                    'created_by'         => $this->session->userdata('username') . ' 1',
                    'created_date'       => $date,
                    'step_approval'      => 7
    
                );
    
                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->insert('material_approval_list', $data_action_required);
    
                /*print_r('<pre>');
                print_r($data_action_required);
                print_r('</pre>');*/

                /* Auto-Email After Superior Action Required */
                // Get approval details
                $this->db->select("
                    material_approval_list.primary_approver as primary_approver,
                    material_approval_list.alternate_approver as alternate_approver,
                    material_approval_list.status as status,
                    material_approval_list.remarks as remarks,
                    material_approval_list.signoff_by as signoff_by,
                    material_approval_list.signoff_date as signoff_date,
                    material_approval_list.cycle_time as cycle_time,
                    material_approval_list.role_status as role_status,
                    step_of_approver.name as step_of_approval
                ");

                $this->db->from('blaine_local_procurement.material_approval_list');
                $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
                $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
                $query = $this->db->get();

                $approval_lists = $query->result();

                foreach($approval_lists as $approval_list)
                {
                    $e_step_of_approval = $approval_list->step_of_approval;
                    $e_primary_approver = $approval_list->primary_approver;
                    $e_alternate_approver = $approval_list->alternate_approver;
                    $e_status = $approval_list->status;
                    $e_signoff_date = $approval_list->signoff_date;
                    $e_cycle_time = $approval_list->cycle_time;
                    $e_signoff_by = $approval_list->signoff_by;
                    $e_remarks = $approval_list->remarks;

                    $approver .= '<tbody>
                        <tr>
                            <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                            <td style="font-size:12px">'.$e_primary_approver.'</td>
                            <td style="font-size:12px">'.$e_alternate_approver.'</td>
                            <td style="font-size:12px">'.$e_status.'</td>
                            <td style="font-size:12px">'.$e_signoff_date.'</td>
                            <td style="font-size:12px">'.$e_cycle_time.'</td>
                            <td style="font-size:12px">'.$e_signoff_by.'</td>
                            <td style="font-size:12px">'.$e_remarks.'</td>
                        </tr>
                    </tbody>';
                }
                $format .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width,initial-scale=1">
                        <meta name="x-apple-disable-message-reformatting">
                        <title></title>
                        <style>
                            table, td, div, h1, p {font-family: Arial, sans-serif;}
                        </style>
                    </head>
                    <body style="margin:0;padding:0;">
                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                            <tr>
                                <td align="center" style="padding:0;">
                                    <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                        <tr>
                                            <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                                BLAINE INTRANET
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                                Electronic Material Sourcing Request
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                            <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                            </td>
                                        </tr>
                                        <tr>	
                                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                                <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:10px 30px 0px 30px;">
                                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                    <tr>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:0;">
                                                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$company.'</p>
                                                                    </td>
                                                                    <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$category.'</p>
                                                                    </td>
                                                                    <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                                <div class="row">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                                <th scope="col" style="font-size:12px">Step/Approver</th>
                                                                <th scope="col" style="font-size:12px">Primary Approver</th>
                                                                <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                                <th scope="col" style="font-size:12px">Status</th>
                                                                <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                                <th scope="col" style="font-size:12px">Date CT</th>
                                                                <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                                <th scope="col" style="font-size:12px">Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        '.$approver.'
                                                    </table>
                                                </div>
                                                <br>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <table border="0" cellpadding="0" cellspacing="0" align="center"
                                width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                max-width: 560px;" class="wrapper">
                                <tr>
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                        padding-top: 20px;
                                        padding-bottom: 20px;
                                        color: #999999;
                                        font-family: sans-serif;" class="footer">
                                        <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                        <br>This is an auto-generated email from Blaine Intranet system.
                                        <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                        src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                                    </td>
                                </tr>
                            </table>
                        </table>
                    </body>
                </html>';

                

                $config = Array(
                    'protocol'      => 'smtp',
                    'smtp_host'     => 'mail.blainegroup.com.ph',
                    'smtp_crypto'   => 'ssl',
                    'smtp_port'     => 465,
                    'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
                    'smtp_pass'     => '@Bl@ine2021', // change it to yours
                    'mailtype'      => 'html',
                    'charset'       => 'iso-8859-1',
                    'wordwrap'      => TRUE
                );

                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from($config['smtp_user']); // change it to yours
                $this->email->to($recipient3);// change it to yours
                $this->email->cc($recipient3_cc);
                //$this->email->bcc($bcc);
                $this->email->subject($subject_2);
                $this->email->message($format);
                if($this->email->send()){
                    $this->session->set_flashdata('message', 'Email sent');
                }
                else{
                    $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
                }
            }

            // ACTION REQUIRED FROM PROCUREMENT
            elseif($role_status == 'Procurement')
            {
                $data_action_required = array(
                    'msid'               => $msid,
                    'primary_approver'   => $primary_approver,
                    'alternate_approver' => $alternate_approver,
                    'role_status'        => 'Requestor',
                    'status'             => 'Pending',
                    'created_by'         => $this->session->userdata('username') . ' 2',
                    'created_date'       => $date,
                    'step_approval'      => 7
    
                );
    
                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->insert('material_approval_list', $data_action_required);

                /* Auto-Email After Superior Action Required */
                // Get approval details
                $this->db->select("
                    material_approval_list.primary_approver as primary_approver,
                    material_approval_list.alternate_approver as alternate_approver,
                    material_approval_list.status as status,
                    material_approval_list.remarks as remarks,
                    material_approval_list.signoff_by as signoff_by,
                    material_approval_list.signoff_date as signoff_date,
                    material_approval_list.cycle_time as cycle_time,
                    material_approval_list.role_status as role_status,
                    step_of_approver.name as step_of_approval
                ");

                $this->db->from('blaine_local_procurement.material_approval_list');
                $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
                $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
                $query = $this->db->get();

                $approval_lists = $query->result();

                foreach($approval_lists as $approval_list)
                {
                    $e_step_of_approval = $approval_list->step_of_approval;
                    $e_primary_approver = $approval_list->primary_approver;
                    $e_alternate_approver = $approval_list->alternate_approver;
                    $e_status = $approval_list->status;
                    $e_signoff_date = $approval_list->signoff_date;
                    $e_cycle_time = $approval_list->cycle_time;
                    $e_signoff_by = $approval_list->signoff_by;
                    $e_remarks = $approval_list->remarks;

                    $approver .= '<tbody>
                        <tr>
                            <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                            <td style="font-size:12px">'.$e_primary_approver.'</td>
                            <td style="font-size:12px">'.$e_alternate_approver.'</td>
                            <td style="font-size:12px">'.$e_status.'</td>
                            <td style="font-size:12px">'.$e_signoff_date.'</td>
                            <td style="font-size:12px">'.$e_cycle_time.'</td>
                            <td style="font-size:12px">'.$e_signoff_by.'</td>
                            <td style="font-size:12px">'.$e_remarks.'</td>
                        </tr>
                    </tbody>';
                }
                $format .= '<!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width,initial-scale=1">
                        <meta name="x-apple-disable-message-reformatting">
                        <title></title>
                        <style>
                            table, td, div, h1, p {font-family: Arial, sans-serif;}
                        </style>
                    </head>
                    <body style="margin:0;padding:0;">
                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                            <tr>
                                <td align="center" style="padding:0;">
                                    <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                        <tr>
                                            <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                                BLAINE INTRANET
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                                Electronic Material Sourcing Request
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                            <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                            </td>
                                        </tr>
                                        <tr>	
                                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                                <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:10px 30px 0px 30px;">
                                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                    <tr>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:0;">
                                                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$company.'</p>
                                                                    </td>
                                                                    <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$category.'</p>
                                                                    </td>
                                                                    <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:260px;padding:0;vertical-align:top;">
                                                                        <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                                <div class="row">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                                <th scope="col" style="font-size:12px">Step/Approver</th>
                                                                <th scope="col" style="font-size:12px">Primary Approver</th>
                                                                <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                                <th scope="col" style="font-size:12px">Status</th>
                                                                <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                                <th scope="col" style="font-size:12px">Date CT</th>
                                                                <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                                <th scope="col" style="font-size:12px">Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        '.$approver.'
                                                    </table>
                                                </div>
                                                <br>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <table border="0" cellpadding="0" cellspacing="0" align="center"
                                width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                max-width: 560px;" class="wrapper">
                                <tr>
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                        padding-top: 20px;
                                        padding-bottom: 20px;
                                        color: #999999;
                                        font-family: sans-serif;" class="footer">
                                        <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                        <br>This is an auto-generated email from Blaine Intranet system.
                                        <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                        src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                                    </td>
                                </tr>
                            </table>
                        </table>
                    </body>
                </html>';

                

                $config = Array(
                    'protocol'      => 'smtp',
                    'smtp_host'     => 'mail.blainegroup.com.ph',
                    'smtp_crypto'   => 'ssl',
                    'smtp_port'     => 465,
                    'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
                    'smtp_pass'     => '@Bl@ine2021', // change it to yours
                    'mailtype'      => 'html',
                    'charset'       => 'iso-8859-1',
                    'wordwrap'      => TRUE
                );

                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from($config['smtp_user']); // change it to yours
                $this->email->to($recipient2);// change it to yours
                $this->email->cc($recipient2_cc);
                //$this->email->bcc($bcc);
                $this->email->subject($subject_3);
                $this->email->message($format);
                if($this->email->send()){
                    $this->session->set_flashdata('message', 'Email sent');
                }
                else{
                    $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
                }
            }
        
        }

        // DISAPPROVED
        elseif($process == 2)
        {
            // MATERIAL APPROVAL LIST
            $data_update_last_entry = array(
                'status'        => 'Disapproved',
                'signoff_by'    => $this->session->userdata('username'),
                'signoff_date'  => $date,
                'remarks'       => $remarks,
                'step_approval' => 10,
                'cycle_time'    => $cycle_time
            );  

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('id', $last_entry_id);
            $blaine_local_procurement->update('material_approval_list', $data_update_last_entry);

            // MATERIAL SOURCING 
            $data = array(
                'is_no_transmittal' => $paid_sample_only,
                'role_status'       => 'Disapproved '. $role_status
            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('msid', $msid);
            $blaine_local_procurement->update('material_sourcing', $data);

            // Auto-Email After Disapprove
            // Get Approval Details
            $this->db->select("
                material_approval_list.primary_approver as primary_approver,
                material_approval_list.alternate_approver as alternate_approver,
                material_approval_list.status as status,
                material_approval_list.remarks as remarks,
                material_approval_list.signoff_by as signoff_by,
                material_approval_list.signoff_date as signoff_date,
                material_approval_list.cycle_time as cycle_time,
                material_approval_list.role_status as role_status,
                step_of_approver.name as step_of_approval
            ");

            $this->db->from('blaine_local_procurement.material_approval_list');
            $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
            $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
            $query = $this->db->get();

            $approval_lists = $query->result();

            foreach($approval_lists as $approval_list)
            {
                $e_step_of_approval = $approval_list->step_of_approval;
                $e_primary_approver = $approval_list->primary_approver;
                $e_alternate_approver = $approval_list->alternate_approver;
                $e_status = $approval_list->status;
                $e_signoff_date = $approval_list->signoff_date;
                $e_cycle_time = $approval_list->cycle_time;
                $e_signoff_by = $approval_list->signoff_by;
                $e_remarks = $approval_list->remarks;

                $approver .= '<tbody>
                    <tr>
                        <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                        <td style="font-size:12px">'.$e_primary_approver.'</td>
                        <td style="font-size:12px">'.$e_alternate_approver.'</td>
                        <td style="font-size:12px">'.$e_status.'</td>
                        <td style="font-size:12px">'.$e_signoff_date.'</td>
                        <td style="font-size:12px">'.$e_cycle_time.'</td>
                        <td style="font-size:12px">'.$e_signoff_by.'</td>
                        <td style="font-size:12px">'.$e_remarks.'</td>
                    </tr>
                </tbody>';
            }
            $format .= '<!DOCTYPE html>
            <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width,initial-scale=1">
                    <meta name="x-apple-disable-message-reformatting">
                    <title></title>
                    <style>
                        table, td, div, h1, p {font-family: Arial, sans-serif;}
                    </style>
                </head>
                <body style="margin:0;padding:0;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                        <tr>
                            <td align="center" style="padding:0;">
                                <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                    <tr>
                                        <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                            BLAINE INTRANET
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                            Electronic Material Sourcing Request
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                        <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                        </td>
                                    </tr>
                                    <tr>	
                                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                            <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 30px 0px 30px;">
                                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td style="padding:0;">
                                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                            <tr>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$company.'</p>
                                                                </td>
                                                                <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$category.'</p>
                                                                </td>
                                                                <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                            <div class="row">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                            <th scope="col" style="font-size:12px">Step/Approver</th>
                                                            <th scope="col" style="font-size:12px">Primary Approver</th>
                                                            <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                            <th scope="col" style="font-size:12px">Status</th>
                                                            <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                            <th scope="col" style="font-size:12px">Date CT</th>
                                                            <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                            <th scope="col" style="font-size:12px">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    '.$approver.'
                                                </table>
                                            </div>
                                            <br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <table border="0" cellpadding="0" cellspacing="0" align="center"
                            width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                            max-width: 560px;" class="wrapper">
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                    padding-top: 20px;
                                    padding-bottom: 20px;
                                    color: #999999;
                                    font-family: sans-serif;" class="footer">
                                    <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                    <br>This is an auto-generated email from Blaine Intranet system.
                                    <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                    src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                                </td>
                            </tr>
                        </table>
                    </table>
                </body>
            </html>';
                
            $config = Array(
                'protocol'      => 'smtp',
                'smtp_host'     => 'mail.blainegroup.com.ph',
                'smtp_crypto'   => 'ssl',
                'smtp_port'     => 465,
                'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
                'smtp_pass'     => '@Bl@ine2021', // change it to yours
                'mailtype'      => 'html',
                'charset'       => 'iso-8859-1',
                'wordwrap'      => TRUE
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($config['smtp_user']); // change it to yours
            $this->email->to($recipient2);// change it to yours
            $this->email->cc($recipient2_cc);
            //$this->email->bcc($bcc);
            $this->email->subject($subject_7);
            $this->email->message($format);
            if($this->email->send()){
                $this->session->set_flashdata('message', 'Email sent');
            }
            else{
                $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
            }
        }

        $trans = $this->db->trans_complete();
        return $trans;
        
    }

    public function material_source_report_generation_process()
    {
        $this->db->trans_start();

        $last_entry_id = $this->input->post('id');
        $role_status = $this->input->post('role_status');
        $remarks = $this->input->post('remarks');
        $cycle_time = $this->input->post('cycle_time');
        $msid = $this->input->post('msid');
        $date = date('Y-m-d H:i:s');
        $approve_detail = $this->input->post('approve_detail');
        
        // Email Information
        $source_id = $this->input->post('source_id');
        $company = $this->input->post('company');
        $category = $this->input->post('category');
        $date_required = $this->input->post('date_required');
        $date_requested = $this->input->post('date_requested');
        $subject = "MSID # " . $msid . " - Requestor Feedback";

        // Email Recipient
        $data_explod = explode(',', $this->input->post('email_accounts'));

        // Requestor Email
        $req_primary_email1 = $data_explod[0];
        $req_alternate_email1 = $data_explod[1];

        // Superior Email
        $req_primary_email2 = $data_explod[2];
        $req_alternate_email2 = $data_explod[3];

        // Procurement Email
        $procurement = ('primaryprocurement11@gmail.com, alternateprocurement11@gmail.com');

        // Procurement Approval
        $recipient2 = $req_primary_email1.','.$req_alternate_email1;
        $recipient2_cc = $req_primary_email2.','.$req_alternate_email2.','.$procurement;

        $data_material_source = array(
            'role_status' => 'Pending Procurement'
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('msid', $msid);
        $blaine_local_procurement->update('material_sourcing', $data_material_source);

        $data_update_last_entry = array(
            'status'       => $approve_detail,
            'signoff_by'   => $this->session->userdata('username'),
            'signoff_date' => $date,
            'remarks'      => $remarks,
            'cycle_time'   => $cycle_time
        );  

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $last_entry_id);
        $blaine_local_procurement->update('material_approval_list', $data_update_last_entry);

        /*print_r('<pre>');
        print_r($data_update_last_entry);
        print_r('</pre>');*/

        if($approve_detail == "Approve" || $approve_detail == "Discontinued")
        {
            $data_action_required = array(
                'msid'               => $msid,
                'primary_approver'   => "CATANGUI, SHARON ROSE BALLES",
                'alternate_approver' => "DEL PILAR, JENIFFER ALVAREZ",
                'role_status'        => "Procurement",
                'status'             => 'Pending',
                'created_by'         => $this->session->userdata('username') . ' 0',
                'created_date'       => $date,
                'step_approval'      => 9
    
            );
    
            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->insert('material_approval_list', $data_action_required);

            $this->db->select("
                material_approval_list.primary_approver as primary_approver,
                material_approval_list.alternate_approver as alternate_approver,
                material_approval_list.status as status,
                material_approval_list.remarks as remarks,
                material_approval_list.signoff_by as signoff_by,
                material_approval_list.signoff_date as signoff_date,
                material_approval_list.cycle_time as cycle_time,
                material_approval_list.role_status as role_status,
                step_of_approver.name as step_of_approval
            ");

            $this->db->from('blaine_local_procurement.material_approval_list');
            $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
            $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
            $query = $this->db->get();

            $approval_lists = $query->result();

            foreach($approval_lists as $approval_list)
            {
                $e_step_of_approval = $approval_list->step_of_approval;
                $e_primary_approver = $approval_list->primary_approver;
                $e_alternate_approver = $approval_list->alternate_approver;
                $e_status = $approval_list->status;
                $e_signoff_date = $approval_list->signoff_date;
                $e_cycle_time = $approval_list->cycle_time;
                $e_signoff_by = $approval_list->signoff_by;
                $e_remarks = $approval_list->remarks;

                $approver .= '<tbody>
                    <tr>
                        <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                        <td style="font-size:12px">'.$e_primary_approver.'</td>
                        <td style="font-size:12px">'.$e_alternate_approver.'</td>
                        <td style="font-size:12px">'.$e_status.'</td>
                        <td style="font-size:12px">'.$e_signoff_date.'</td>
                        <td style="font-size:12px">'.$e_cycle_time.'</td>
                        <td style="font-size:12px">'.$e_signoff_by.'</td>
                        <td style="font-size:12px">'.$e_remarks.'</td>
                    </tr>
                </tbody>';
            }

            $format .= '<!DOCTYPE html>
            <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width,initial-scale=1">
                    <meta name="x-apple-disable-message-reformatting">
                    <title></title>
                    <style>
                        table, td, div, h1, p {font-family: Arial, sans-serif;}
                    </style>
                </head>
                <body style="margin:0;padding:0;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                        <tr>
                            <td align="center" style="padding:0;">
                                <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                    <tr>
                                        <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                            BLAINE INTRANET
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                            Electronic Material Sourcing Request
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                        <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                        </td>
                                    </tr>
                                    <tr>	
                                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                            <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 30px 0px 30px;">
                                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td style="padding:0;">
                                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                            <tr>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$company.'</p>
                                                                </td>
                                                                <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$category.'</p>
                                                                </td>
                                                                <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                            <div class="row">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                            <th scope="col" style="font-size:12px">Step/Approver</th>
                                                            <th scope="col" style="font-size:12px">Primary Approver</th>
                                                            <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                            <th scope="col" style="font-size:12px">Status</th>
                                                            <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                            <th scope="col" style="font-size:12px">Date CT</th>
                                                            <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                            <th scope="col" style="font-size:12px">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    '.$approver.'
                                                </table>
                                            </div>
                                            <br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <table border="0" cellpadding="0" cellspacing="0" align="center"
                            width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                            max-width: 560px;" class="wrapper">
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                    padding-top: 20px;
                                    padding-bottom: 20px;
                                    color: #999999;
                                    font-family: sans-serif;" class="footer">
                                    <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                    <br>This is an auto-generated email from Blaine Intranet system.
                                    <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                    src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                                </td>
                            </tr>
                        </table>
                    </table>
                </body>
            </html>';

            $config = Array(
                'protocol'      => 'smtp',
                'smtp_host'     => 'mail.blainegroup.com.ph',
                'smtp_crypto'   => 'ssl',
                'smtp_port'     => 465,
                'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
                'smtp_pass'     => '@Bl@ine2021', // change it to yours
                'mailtype'      => 'html',
                'charset'       => 'iso-8859-1',
                'wordwrap'      => TRUE
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($config['smtp_user']); // change it to yours
            $this->email->to($recipient2);// change it to yours
            $this->email->cc($recipient2_cc);
            //$this->email->bcc($bcc);
            $this->email->subject($subject);
            $this->email->message($format);
            if($this->email->send()){
                $this->session->set_flashdata('message', 'Email sent');
            }
            else{
                $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
            }
        }
        elseif($approve_detail == "Action Required")
        {
            $data_action_required = array(
                'msid'               => $msid,
                'primary_approver'   => "CATANGUI, SHARON ROSE BALLES",
                'alternate_approver' => "DEL PILAR, JENIFFER ALVAREZ",
                'role_status'        => "Procurement",
                'status'             => 'Pending',
                'created_by'         => $this->session->userdata('username') . ' 0',
                'created_date'       => $date,
                'step_approval'      => 4
    
            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->insert('material_approval_list', $data_action_required);
            
            /*print_r('<pre>');
            print_r($data_action_required);
            print_r('</pre>');*/

            $this->db->select("
                material_approval_list.primary_approver as primary_approver,
                material_approval_list.alternate_approver as alternate_approver,
                material_approval_list.status as status,
                material_approval_list.remarks as remarks,
                material_approval_list.signoff_by as signoff_by,
                material_approval_list.signoff_date as signoff_date,
                material_approval_list.cycle_time as cycle_time,
                material_approval_list.role_status as role_status,
                step_of_approver.name as step_of_approval
            ");

            $this->db->from('blaine_local_procurement.material_approval_list');
            $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
            $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
            $query = $this->db->get();

            $approval_lists = $query->result();

            foreach($approval_lists as $approval_list)
            {
                $e_step_of_approval = $approval_list->step_of_approval;
                $e_primary_approver = $approval_list->primary_approver;
                $e_alternate_approver = $approval_list->alternate_approver;
                $e_status = $approval_list->status;
                $e_signoff_date = $approval_list->signoff_date;
                $e_cycle_time = $approval_list->cycle_time;
                $e_signoff_by = $approval_list->signoff_by;
                $e_remarks = $approval_list->remarks;

                $approver .= '<tbody>
                    <tr>
                        <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                        <td style="font-size:12px">'.$e_primary_approver.'</td>
                        <td style="font-size:12px">'.$e_alternate_approver.'</td>
                        <td style="font-size:12px">'.$e_status.'</td>
                        <td style="font-size:12px">'.$e_signoff_date.'</td>
                        <td style="font-size:12px">'.$e_cycle_time.'</td>
                        <td style="font-size:12px">'.$e_signoff_by.'</td>
                        <td style="font-size:12px">'.$e_remarks.'</td>
                    </tr>
                </tbody>';
            }

            $format .= '<!DOCTYPE html>
            <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width,initial-scale=1">
                    <meta name="x-apple-disable-message-reformatting">
                    <title></title>
                    <style>
                        table, td, div, h1, p {font-family: Arial, sans-serif;}
                    </style>
                </head>
                <body style="margin:0;padding:0;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                        <tr>
                            <td align="center" style="padding:0;">
                                <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                    <tr>
                                        <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                            BLAINE INTRANET
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                            Electronic Material Sourcing Request
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                        <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                        </td>
                                    </tr>
                                    <tr>	
                                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                            <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 30px 0px 30px;">
                                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td style="padding:0;">
                                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                            <tr>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$company.'</p>
                                                                </td>
                                                                <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$category.'</p>
                                                                </td>
                                                                <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:260px;padding:0;vertical-align:top;">
                                                                    <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                            <div class="row">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                            <th scope="col" style="font-size:12px">Step/Approver</th>
                                                            <th scope="col" style="font-size:12px">Primary Approver</th>
                                                            <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                            <th scope="col" style="font-size:12px">Status</th>
                                                            <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                            <th scope="col" style="font-size:12px">Date CT</th>
                                                            <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                            <th scope="col" style="font-size:12px">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    '.$approver.'
                                                </table>
                                            </div>
                                            <br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <table border="0" cellpadding="0" cellspacing="0" align="center"
                            width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                            max-width: 560px;" class="wrapper">
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                    padding-top: 20px;
                                    padding-bottom: 20px;
                                    color: #999999;
                                    font-family: sans-serif;" class="footer">
                                    <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                    <br>This is an auto-generated email from Blaine Intranet system.
                                    <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                    src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                                </td>
                            </tr>
                        </table>
                    </table>
                </body>
            </html>';

            $config = Array(
                'protocol'      => 'smtp',
                'smtp_host'     => 'mail.blainegroup.com.ph',
                'smtp_crypto'   => 'ssl',
                'smtp_port'     => 465,
                'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
                'smtp_pass'     => '@Bl@ine2021', // change it to yours
                'mailtype'      => 'html',
                'charset'       => 'iso-8859-1',
                'wordwrap'      => TRUE
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($config['smtp_user']); // change it to yours
            $this->email->to($recipient2);// change it to yours
            $this->email->cc($recipient2_cc);
            //$this->email->bcc($bcc);
            $this->email->subject($subject);
            $this->email->message($format);
            if($this->email->send()){
                $this->session->set_flashdata('message', 'Email sent');
            }
            else{
                $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
            }
    
        }

        $status = $this->input->post('status');
        $notes = $this->input->post('notes');
        $i = 0;

        foreach($this->input->post('trans_id') as $trans_id)
        {
            $data_transmittal = array(
                'id'           => $trans_id,
                'status'       => $status[$trans_id],
                'notes'        => $notes[$i],
                'updated_by'   => $this->session->userdata('username'),
                'updated_date' => $date,
            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('id', $trans_id);
            $blaine_local_procurement->update('transmittal_material_list', $data_transmittal);

            /*print_r('<pre>');
            print_r($data_transmittal);
            print_r('</pre>');*/

            $i++;
        }

        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function material_source_close_process()
    {
        $this->db->trans_start();

        $last_entry_id = $this->input->post('id');
        $role_status = $this->input->post('role_status');
        $remarks = $this->input->post('remarks');
        $cycle_time = $this->input->post('cycle_time');
        $msid = $this->input->post('msid');
        $date = date('Y-m-d H:i:s');

        // Email Information
        $source_id = $this->input->post('source_id');
        $company = $this->input->post('company');
        $category = $this->input->post('category');
        $date_required = $this->input->post('date_required');
        $date_requested = $this->input->post('date_requested');
        $subject = "MSID # " . $msid . " - Procurement Request Acceptance";

        // Email Recipient
        $data_explod = explode(',', $this->input->post('email_accounts'));

        // Requestor Email
        $req_primary_email1 = $data_explod[0];
        $req_alternate_email1 = $data_explod[1];

        // Superior Email
        $req_primary_email2 = $data_explod[2];
        $req_alternate_email2 = $data_explod[3];

        // Procurement Email
        $procurement = ('primaryprocurement11@gmail.com, alternateprocurement11@gmail.com');

        // Procurement Approval
        $recipient2 = $req_primary_email1.','.$req_alternate_email1;
        $recipient2_cc = $req_primary_email2.','.$req_alternate_email2.','.$procurement;

        $data_material_source = array(
            'role_status' => '0 Closed'
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('msid', $msid);
        $blaine_local_procurement->update('material_sourcing', $data_material_source);

        $data_update_last_entry = array(
            'status'       => "Closed",
            'signoff_by'   => $this->session->userdata('username'),
            'signoff_date' => $date,
            'remarks'      => $remarks,
            'cycle_time'   => $cycle_time
        );  

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $last_entry_id);
        $blaine_local_procurement->update('material_approval_list', $data_update_last_entry);

        /*print_r('<pre>');
        print_r($data_update_last_entry);
        print_r('</pre>');*/

        $this->db->select("
            material_approval_list.primary_approver as primary_approver,
            material_approval_list.alternate_approver as alternate_approver,
            material_approval_list.status as status,
            material_approval_list.remarks as remarks,
            material_approval_list.signoff_by as signoff_by,
            material_approval_list.signoff_date as signoff_date,
            material_approval_list.cycle_time as cycle_time,
            material_approval_list.role_status as role_status,
            step_of_approver.name as step_of_approval
        ");

        $this->db->from('blaine_local_procurement.material_approval_list');
        $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
        $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
        $query = $this->db->get();

        $approval_lists = $query->result();

        foreach($approval_lists as $approval_list)
        {
            $e_step_of_approval = $approval_list->step_of_approval;
            $e_primary_approver = $approval_list->primary_approver;
            $e_alternate_approver = $approval_list->alternate_approver;
            $e_status = $approval_list->status;
            $e_signoff_date = $approval_list->signoff_date;
            $e_cycle_time = $approval_list->cycle_time;
            $e_signoff_by = $approval_list->signoff_by;
            $e_remarks = $approval_list->remarks;

            $approver .= '<tbody>
                <tr>
                    <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                    <td style="font-size:12px">'.$e_primary_approver.'</td>
                    <td style="font-size:12px">'.$e_alternate_approver.'</td>
                    <td style="font-size:12px">'.$e_status.'</td>
                    <td style="font-size:12px">'.$e_signoff_date.'</td>
                    <td style="font-size:12px">'.$e_cycle_time.'</td>
                    <td style="font-size:12px">'.$e_signoff_by.'</td>
                    <td style="font-size:12px">'.$e_remarks.'</td>
                </tr>
            </tbody>';
        }

        $format .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <meta name="x-apple-disable-message-reformatting">
                <title></title>
                <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                </style>
            </head>
            <body style="margin:0;padding:0;">
                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                        <td align="center" style="padding:0;">
                            <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                <tr>
                                    <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                        BLAINE INTRANET
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                        Electronic Material Sourcing Request
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                    <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                    </td>
                                </tr>
                                <tr>	
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                        <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 30px 0px 30px;">
                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                            <tr>
                                            </tr>
                                            <tr>
                                                <td style="padding:0;">
                                                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$company.'</p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$category.'</p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                        <div class="row">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                        <th scope="col" style="font-size:12px">Step/Approver</th>
                                                        <th scope="col" style="font-size:12px">Primary Approver</th>
                                                        <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                        <th scope="col" style="font-size:12px">Status</th>
                                                        <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                        <th scope="col" style="font-size:12px">Date CT</th>
                                                        <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                        <th scope="col" style="font-size:12px">Remarks</th>
                                                    </tr>
                                                </thead>
                                                '.$approver.'
                                            </table>
                                        </div>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <table border="0" cellpadding="0" cellspacing="0" align="center"
                        width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                        max-width: 560px;" class="wrapper">
                        <tr>
                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                padding-top: 20px;
                                padding-bottom: 20px;
                                color: #999999;
                                font-family: sans-serif;" class="footer">
                                <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                <br>This is an auto-generated email from Blaine Intranet system.
                                <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                            </td>
                        </tr>
                    </table>
                </table>
            </body>
        </html>';

        $config = Array(
            'protocol'      => 'smtp',
            'smtp_host'     => 'mail.blainegroup.com.ph',
            'smtp_crypto'   => 'ssl',
            'smtp_port'     => 465,
            'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
            'smtp_pass'     => '@Bl@ine2021', // change it to yours
            'mailtype'      => 'html',
            'charset'       => 'iso-8859-1',
            'wordwrap'      => TRUE
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($config['smtp_user']); // change it to yours
        $this->email->to($recipient2);// change it to yours
        $this->email->cc($recipient2_cc);
        //$this->email->bcc($bcc);
        $this->email->subject($subject);
        $this->email->message($format);
        if($this->email->send()){
            $this->session->set_flashdata('message', 'Email sent');
        }
        else{
            $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
        }

        $trans = $this->db->trans_complete();
        return $trans;
       
    }

    public function material_source_report()
    {
        $this->db->trans_start();

        $last_entry_id = $this->input->post('id');
        $remarks = $this->input->post('remarks');
        $msid = $this->input->post('msid');
        $date = date('Y-m-d H:i:s');
        $paid_sample_only = $this->input->post('paid_sample_only');
        $primary_approver = $this->input->post('primary_approver');
        $alternate_approver = $this->input->post('alternate_approver');
        $cycle_time = $this->input->post('cycle_time');

        // Email Information
        $source_id = $this->input->post('source_id');
        $company = $this->input->post('company');
        $category = $this->input->post('category');
        $date_required = $this->input->post('date_required');
        $date_requested = $this->input->post('date_requested');
        $subject = "MSID # " . $msid . " - Procurement Report Generation";

        // Email Recipient
        $data_explod = explode(',', $this->input->post('email_accounts'));

        // Requestor Email
        $req_primary_email1 = $data_explod[0];
        $req_alternate_email1 = $data_explod[1];

        // Superior Email
        $req_primary_email2 = $data_explod[2];
        $req_alternate_email2 = $data_explod[3];

        // Procurement Email
        $procurement = ('primaryprocurement11@gmail.com, alternateprocurement11@gmail.com');

        // Procurement Approval
        $recipient2 = $req_primary_email1.','.$req_alternate_email1;
        $recipient2_cc = $req_primary_email2.','.$req_alternate_email2.','.$procurement;


        // MATERIAL APPROVAL LIST
        $data_update_last_entry = array(
            'status'       => 'Done',
            'signoff_by'   => $this->session->userdata('username'),
            'signoff_date' => $date,
            'remarks'      => $remarks,
            'cycle_time'   => $cycle_time
        );  

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $last_entry_id);
        $blaine_local_procurement->update('material_approval_list', $data_update_last_entry);

        $data_requestor_feedback = array(
            'msid'               => $msid,
            'primary_approver'   => $primary_approver,
            'alternate_approver' => $alternate_approver,
            'role_status'        => 'Requestor',
            'status'             => 'Pending',
            'created_by'         => $this->session->userdata('username') . ' 0',
            'created_date'       => $date,
            'step_approval'      => 5

        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material_approval_list', $data_requestor_feedback);

        // MATERIAL SOURCING 
        $data = array(
            'is_no_transmittal' => $paid_sample_only,
            'role_status'       => 'Pending Requestor'
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('msid', $msid);
        $blaine_local_procurement->update('material_sourcing', $data);

        $this->db->select("
            material_approval_list.primary_approver as primary_approver,
            material_approval_list.alternate_approver as alternate_approver,
            material_approval_list.status as status,
            material_approval_list.remarks as remarks,
            material_approval_list.signoff_by as signoff_by,
            material_approval_list.signoff_date as signoff_date,
            material_approval_list.cycle_time as cycle_time,
            material_approval_list.role_status as role_status,
            step_of_approver.name as step_of_approval
        ");

        $this->db->from('blaine_local_procurement.material_approval_list');
        $this->db->join('blaine_local_procurement.step_of_approver', 'blaine_local_procurement.step_of_approver.id = blaine_local_procurement.material_approval_list.step_approval', 'left');
        $this->db->where('blaine_local_procurement.material_approval_list.msid', $msid);
        $query = $this->db->get();

        $approval_lists = $query->result();

        foreach($approval_lists as $approval_list)
        {
            $e_step_of_approval = $approval_list->step_of_approval;
            $e_primary_approver = $approval_list->primary_approver;
            $e_alternate_approver = $approval_list->alternate_approver;
            $e_status = $approval_list->status;
            $e_signoff_date = $approval_list->signoff_date;
            $e_cycle_time = $approval_list->cycle_time;
            $e_signoff_by = $approval_list->signoff_by;
            $e_remarks = $approval_list->remarks;

            $approver .= '<tbody>
                <tr>
                    <th scope="row" align="left" class="throw" style="font-size:12px">'.$e_step_of_approval.'</th>
                    <td style="font-size:12px">'.$e_primary_approver.'</td>
                    <td style="font-size:12px">'.$e_alternate_approver.'</td>
                    <td style="font-size:12px">'.$e_status.'</td>
                    <td style="font-size:12px">'.$e_signoff_date.'</td>
                    <td style="font-size:12px">'.$e_cycle_time.'</td>
                    <td style="font-size:12px">'.$e_signoff_by.'</td>
                    <td style="font-size:12px">'.$e_remarks.'</td>
                </tr>
            </tbody>';
        }

        $format .= '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <meta name="x-apple-disable-message-reformatting">
                <title></title>
                <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                </style>
            </head>
            <body style="margin:0;padding:0;">
                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                        <td align="center" style="padding:0;">
                            <table role="presentation" style="width:1,000px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                <tr>
                                    <td align="center" style="padding:18px 0 18px 0;background:#003060;color:white; font-size:18px">
                                        BLAINE INTRANET
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding:15px 0 10px 0; font-size:25px">
                                        Electronic Material Sourcing Request
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding:5px 0 10px 0; font-size:20px">
                                    <hr color="#E0E0E0" align="center" width="90%" size="1" noshade style="margin: 0; padding: 0;" />
                                    </td>
                                </tr>
                                <tr>	
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 2.25%; padding-right: 2.25%; width: 100%;" class="line">
                                        <hrcolor="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 30px 0px 30px;">
                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                            <tr>
                                            </tr>
                                            <tr>
                                                <td style="padding:0;">
                                                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Business Unit:</b> '.$company.'</p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source ID:</b> <a href="http://localhost/blaineintranet/procurement/material_sourcing_view/'.$source_id.'/'.$msid.'" style="color: #999999;">'.$msid.'</a></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Sourcing Category:</b> '.$category.'</p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Required:</b> '.$date_required.'</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Date Requested:</b> '.$date_requested.'</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding:10px 30px 10px 30px; width: 100%; font-size: 10px;font-family: sans-serif;">
                                        <div class="row">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr style="background-color:#003060; color: white; padding: 15px 5px 15px 5px;">
                                                        <th scope="col" style="font-size:12px">Step/Approver</th>
                                                        <th scope="col" style="font-size:12px">Primary Approver</th>
                                                        <th scope="col" style="font-size:12px">Alternate Approver</th>
                                                        <th scope="col" style="font-size:12px">Status</th>
                                                        <th scope="col" style="font-size:12px">Date Sign-Off</th>
                                                        <th scope="col" style="font-size:12px">Date CT</th>
                                                        <th scope="col" style="font-size:12px">Sign-Off By</th>
                                                        <th scope="col" style="font-size:12px">Remarks</th>
                                                    </tr>
                                                </thead>
                                                '.$approver.'
                                            </table>
                                        </div>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <table border="0" cellpadding="0" cellspacing="0" align="center"
                        width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                        max-width: 560px;" class="wrapper">
                        <tr>
                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                padding-top: 20px;
                                padding-bottom: 20px;
                                color: #999999;
                                font-family: sans-serif;" class="footer">
                                <b>Copyright 2021 - Blaine Intranet - All Rights Reserved</b>
                                <br>This is an auto-generated email from Blaine Intranet system.
                                <img width="1" height="1" border="0" vspace="0" hspace="0" style="margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"
                                src="https://raw.githubusercontent.com/konsav/email-templates/master/images/tracker.png" />
                            </td>
                        </tr>
                    </table>
                </table>
            </body>
        </html>';

        $config = Array(
            'protocol'      => 'smtp',
            'smtp_host'     => 'mail.blainegroup.com.ph',
            'smtp_crypto'   => 'ssl',
            'smtp_port'     => 465,
            'smtp_user'     => 'procurement_system@blainegroup.com.ph', // change it to yours
            'smtp_pass'     => '@Bl@ine2021', // change it to yours
            'mailtype'      => 'html',
            'charset'       => 'iso-8859-1',
            'wordwrap'      => TRUE
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($config['smtp_user']); // change it to yours
        $this->email->to($recipient2);// change it to yours
        $this->email->cc($recipient2_cc);
        //$this->email->bcc($bcc);
        $this->email->subject($subject);
        $this->email->message($format);
        if($this->email->send()){
            $this->session->set_flashdata('message', 'Email sent');
        }
        else{
            $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
        }

        /*print_r('<pre>');
        print_r($format);
        print_r('</pre>');*/

        $trans = $this->db->trans_complete();

        return $trans;
    }

    public function add_report_generation()
    {
        $this->db->trans_start();

        $pr_no = $this->input->post('pr_no');
        $pr_date = $this->input->post('pr_date');
        $company = $this->input->post('company');
        $date = date('Y-m-d H:i:s');

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->order_by('id','DESC');
		$blaine_local_procurement->select('canvass_no');
		$datas = $blaine_local_procurement->get('report_generation');
		$inc_number = $datas->row()->canvass_no;

        $arr2 = str_split($inc_number, 9);
        $i = $arr2[0] + 1;
        $batch_number = str_pad($i, 9, 'CN000000', STR_PAD_LEFT);

        $data = array(
            'canvass_no'     => $batch_number,
            'material_pr_no' => $pr_no,
            'pr_date'        => $pr_date,
            'company'        => $company,
            'created_by'     => $this->session->userdata('username'),
            'created_date'   => $date
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('report_generation', $data);

        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/


        // REPORT GENETATION LIST
        $description = $this->input->post('description');
        $quantity = $this->input->post('qty');
        $uom = $this->input->post('uom');
        $prev_purchase_unit = $this->input->post('previous');
        $year = $this->input->post('year');
        $currency = $this->input->post('currency');
        $i = 0;

        foreach($this->input->post('mat_code') as $mcode)
        {
            $data_list = array(
                'canvass_no'         => $batch_number,
                'material_pr_no'     => $pr_no,
                'mcode'              => $mcode,
                'description'        => $description[$i],
                'quantity'           => $quantity[$i],
                'uom'                => $uom[$i],
                'prev_purchase_unit' => $prev_purchase_unit[$i],
                'currency'           => $currency[$i],
                'year'               => $year[$i],
                'created_by'         => $this->session->userdata('username'),
                'created_date'       => $date
            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->insert('material_report_generation_list', $data_list);

            /*print_r('<pre>');
            print_r($data_list);
            print_r('</pre>');*/

            $i++;
        }

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Added: PR Only",
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: E-CANVASS REPORT GENERATION STEP:2',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $trans = $this->db->trans_complete();
        return $trans;
    } 

    public function add_report_generation_msid()
    {
        $this->db->trans_start();

        $msid = $this->input->post('msid');
        $pr_no = $this->input->post('pr_no');
        $pr_date = $this->input->post('pr_date');
        $company = $this->input->post('company');
        $date = date('Y-m-d H:i:s');

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->order_by('id','DESC');
		$blaine_local_procurement->select('canvass_no');
		$datas = $blaine_local_procurement->get('report_generation');
		$inc_number = $datas->row()->canvass_no;

        $arr2 = str_split($inc_number, 9);
        $i = $arr2[0] + 1;
        $batch_number = str_pad($i, 9, 'CN000000', STR_PAD_LEFT);

        $data = array(
            'canvass_no'     => $batch_number,
            'msid'           => $msid,
            'material_pr_no' => $pr_no,
            'pr_date'        => $pr_date,
            'company'        => $company,
            'created_by'     => $this->session->userdata('username'),
            'created_date'   => $date
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('report_generation', $data);

        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/


        // REPORT GENETATION LIST
        $description = $this->input->post('description');
        $quantity = $this->input->post('qty');
        $uom = $this->input->post('uom');
        $prev_purchase_unit = $this->input->post('previous');
        $year = $this->input->post('year');
        $currency = $this->input->post('currency');
        $i = 0;

        foreach($this->input->post('mat_code') as $mcode)
        {
            $data_list = array(
                'canvass_no'         => $batch_number,
                'material_pr_no'     => $pr_no,
                'mcode'              => $mcode,
                'description'        => $description[$i],
                'quantity'           => $quantity[$i],
                'uom'                => $uom[$i],
                'prev_purchase_unit' => $prev_purchase_unit[$i],
                'currency'           => $currency[$i],
                'year'               => $year[$i],
                'created_by'         => $this->session->userdata('username'),
                'created_date'       => $date
            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->insert('material_report_generation_list', $data_list);

            /*print_r('<pre>');
            print_r($data_list);
            print_r('</pre>');*/

            $i++;
        }

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Added: With Matsource Request",
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: E-CANVASS REPORT GENERATION STEP:2',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $trans = $this->db->trans_complete();
        return $trans;
    } 

    public function last_canvass_no()
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->order_by('id', 'DESC');
        $query = $blaine_local_procurement->get('report_generation');

        return $query->row();

    }

    public function get_canvass_material_list($canvass_no)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $query = $blaine_local_procurement->get('material_report_generation_list');

        return $query->result();
    }

    public function report_generation($canvass_no)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $query = $blaine_local_procurement->get('report_generation');

        return $query->row();

    }

    public function insert_report_generation_with_supplier($data = array()){ 
        $insert = $this->db->insert_batch('blaine_local_procurement.supplier_report_generation',$data); 
        return $insert?true:false; 
    } 

    public function add_report_generation_with_supplier()
    {
        $this->db->trans_start();

        $canvass_no = $this->input->post('canvass_no');
        $date = date('Y-m-d H:i:s');

        $supplier_name = $this->input->post('supplier_name');
        $moq = $this->input->post('moq');
        $price_per_unit = $this->input->post('price');
        $currency = $this->input->post('currency');
        $a = 0;

        foreach($this->input->post('id') as $material_id)
        {
            $material_list = array(
                'canvass_no'     => $canvass_no,
                'material_id'    => $material_id,
                'supplier_name'  => $supplier_name[$a],
                'moq'            => $moq[$a],
                'price_per_unit' => $price_per_unit[$a],
                'currency'       => $currency[$a],
                'created_by'    => $this->session->userdata('username'),
                'created_date'  => $date
            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->insert('supplier_material_list', $material_list);

            /*print_r('<pre>');
            print_r($material_list);
            print_r('</pre>');*/

            $a++;
        }

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Added",
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: E-CANVASS REPORT GENERATION STEP:3',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);
      
        $trans = $this->db->trans_complete();
        return $trans;
    }

    public function edit_supplier_material($id)
    {
        $this->db->trans_start();
       
        $supplier_name = $this->input->post('supplier_name');
        $moq = $this->input->post('moq');
        $price_per_unit = $this->input->post('price');
        $currency = $this->input->post('currency');
        $date = date('Y-m-d H:i:s');
        $a = 0;

        foreach($this->input->post('material_id') as $material_id)
        {
            $material_list = array(
                'supplier_name'  => $supplier_name[$a],
                'moq'            => $moq[$a],
                'price_per_unit' => $price_per_unit[$a],
                'currency'       => $currency[$a],
                'updated_by'     => $this->session->userdata('username'),
                'updated_date'   => $date
            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('supplier_material_list.id', $material_id);
            $blaine_local_procurement->update('supplier_material_list', $material_list);

            /*print_r('<pre>');
            print_r($material_list);
            print_r('</pre>');*/

            $a++;
        }
        $attachment = $_FILES['image']['name'];
        $canvass_no = $this->input->post('canvass_no');
        $supplier = $this->input->post('supplier');
        $accredited = $this->input->post('accredited');
        $vat = $this->input->post('vat');
        $wrt = $this->input->post('wrt');
        $pmt = $this->input->post('pmt');
        $del = $this->input->post('del');
        $notes = $this->input->post('notes');

        // GET OLD DATA BEFORE UPDATE
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->select('*');
        $blaine_local_procurement->where('id', $id);
        $datas = $blaine_local_procurement->get('supplier_report_generation');
        $report_gen_id = $datas->row()->id;
        $report_gen_canvass_no = $datas->row()->canvass_no;
        $report_gen_supplier_name = $datas->row()->supplier_name;
        $report_gen_supplier_type = $datas->row()->supplier_type;
        $report_gen_vat = $datas->row()->vat;
        $report_gen_wrt = $datas->row()->wrt;
        $report_gen_pmt = $datas->row()->pmt;
        $report_gen_del = $datas->row()->del;
        $report_gen_notes = $datas->row()->notes;

        if($attachment == NULL)
        {

            $entry_data = array(
                'id'                    => $report_gen_id,
                'canvass_no'            => $report_gen_canvass_no,
                'supplier_name'         => $report_gen_supplier_name,
                'supplier_type'         => $report_gen_supplier_type,
                'vat'                   => $report_gen_vat,
                'wrt'                   => $report_gen_wrt,
                'pmt'                   => $report_gen_pmt,
                'del'                   => $report_gen_del,
                'notes'                 => $report_gen_notes
            );
    
            $json_data = json_encode($entry_data);
    
            $data_logs = array(
                'username'      => $this->session->userdata('username'),
                'activity'      => "Entry Updated: " . ' ID: ' . $id,
                'datas'         => "Previous Data: " .$json_data,
                'pc_ip'         => $_SERVER['REMOTE_ADDR'],
                'type'          => 'LOCAL PROCUREMENT: E-CANVASS REPORT GENERATION STEP:4',
                'date'          => date('Y-m-d H:i:s')
            );
    
            $activity_log = $this->load->database('activity_logs', TRUE);
            $activity_log->insert('blaine_logs', $data_logs);

            $data_supplier = array(
                'supplier_name'  => $supplier,
                'vat'            => $vat,
                'wrt'            => $wrt,
                'pmt'            => $pmt,
                'del'            => $del,
                'notes'          => $notes,
                'updated_by'     => $this->session->userdata('username'),
                'updated_date'   => $date,
            );
    
            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('supplier_report_generation.id', $id);
            $blaine_local_procurement->update('supplier_report_generation', $data_supplier);
    
            /*print_r('<pre>');
            print_r($data_supplier);
            print_r('</pre>');*/
        }
        else
        {
            $entry_data = array(
                'id'                    => $report_gen_id,
                'canvass_no'            => $report_gen_canvass_no,
                'supplier_name'         => $report_gen_supplier_name,
                'supplier_type'         => $report_gen_supplier_type,
                'vat'                   => $report_gen_vat,
                'wrt'                   => $report_gen_wrt,
                'pmt'                   => $report_gen_pmt,
                'del'                   => $report_gen_del,
                'notes'                 => $report_gen_notes
            );
    
            $json_data = json_encode($entry_data);
    
            $data_logs = array(
                'username'      => $this->session->userdata('username'),
                'activity'      => "Entry Updated: " . ' ID: ' . $id,
                'datas'         => "Previous Data: " .$json_data,
                'pc_ip'         => $_SERVER['REMOTE_ADDR'],
                'type'          => 'LOCAL PROCUREMENT: E-CANVASS REPORT GENERATION STEP:4',
                'date'          => date('Y-m-d H:i:s')
            );
    
            $activity_log = $this->load->database('activity_logs', TRUE);
            $activity_log->insert('blaine_logs', $data_logs);

            $data_supplier = array(
                'supplier_name'  => $supplier,
                'vat'            => $vat,
                'wrt'            => $wrt,
                'pmt'            => $pmt,
                'del'            => $del,
                'notes'          => $notes,
                'attachment'     => $attachment,
                'updated_by'     => $this->session->userdata('username'),
                'updated_date'   => $date,
            );
    
            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('supplier_report_generation.id', $id);
            $blaine_local_procurement->update('supplier_report_generation', $data_supplier);
    
            /*print_r('<pre>');
            print_r($data_supplier);
            print_r('</pre>');*/
        }
       

        $trans = $this->db->trans_complete();
        return $trans;
        
    }

    public function get_supplier_report_generation($canvass_no)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $query = $blaine_local_procurement->get('supplier_report_generation');

        return $query->result();
    }

    public function get_report_generation($canvass_no)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $query = $blaine_local_procurement->get('report_generation');

        return $query->row();
    }

    public function supplier_materials($canvass_no)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $query = $blaine_local_procurement->get('supplier_material_list');

        return $query->result();
    }

    public function get_supplier_materials($canvass_no)
    {
        $this->db->select('
            SUM(supplier_material_list.price_per_unit) AS total_price_per_material,
            COUNT(supplier_material_list.material_id) AS count_per_material
        ');
        $this->db->from('blaine_local_procurement.supplier_material_list');
        $this->db->where('blaine_local_procurement.supplier_material_list.canvass_no', $canvass_no);
        $this->db->where('blaine_local_procurement.supplier_material_list.price_per_unit !=', 0);
        $this->db->group_by('blaine_local_procurement.supplier_material_list.material_id');

        $query = $this->db->get();

        return $query->result();
    }

    public function add_transmittal()
    {
        $this->db->trans_start();

        // Transmittal
        $attachment = $_FILES['attachment']['name'];
        $msid = $this->input->post('msid');
        $ms_request_date = $this->input->post('ms_request_date');
        $company = $this->input->post('company');
        $requestor = $this->input->post('requestor');
        $transmittal_date = $this->input->post('transmittal_date');
        $email = $this->input->post('email');
        $date = date('Y-m-d H:i:s');

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->order_by('id', 'DESC');
        $blaine_local_procurement->select('transmittal_no');
        $datas = $blaine_local_procurement->get('transmittal');
        $inc_number = $datas->row()->transmittal_no;

        $arr2 = str_split($inc_number, 9);
        $i = $arr2[0] + 1;
        $trans_batch_number = str_pad($i, 9, 'TN000000', STR_PAD_LEFT);

        $data = array(
            'transmittal_no'    => $trans_batch_number,
            'msid'              => $msid,
            'ms_request_date'   => $ms_request_date,
            'company'           => $company,
            'transmittal_date'  => $transmittal_date,
            'attachment'        => $attachment,
            'created_by'        => $this->session->userdata('username'),
            'created_date'      => date('Y-m-d H:i:s')
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('transmittal', $data);

        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/

        // Transmittal Material List
        $attachment1 = $_FILES['attachment1']['name'];
        $description = $this->input->post('description');
        $accredited = $this->input->post('accredited');
        $other = $this->input->post('others');
        $batch_number = $this->input->post('batch_number');
        $i = 0;

        foreach($this->input->post('supplier') as $supplier)
        {
            if($supplier == 'acc')
            {
                $supplier_data = array(
                    'transmittal_no'    => $trans_batch_number,
                    'msid'              => $msid,
                    'description'       => $description[$i],
                    'supplier_name'     => $accredited[$i],
                    'batch_number'      => $batch_number[$i],
                    'attachment'        => $attachment1[$i],
                    'created_by'        => $this->session->userdata('username'),
                    'created_date'      => date('Y-m-d H:i:s')
                );

                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->insert('transmittal_material_list', $supplier_data);
                
                /*print_r('<pre>');
                print_r($supplier_data);
                print_r('</pre>');*/
            }
            elseif($supplier == 'others')
            {
                $supplier_data = array(
                    'transmittal_no'    => $trans_batch_number,
                    'msid'              => $msid,
                    'description'       => $description[$i],
                    'supplier_name'     => $other[$i],
                    'batch_number'      => $batch_number[$i],
                    'attachment'        => $attachment1[$i],
                    'created_by'        => $this->session->userdata('username'),
                    'created_date'      => date('Y-m-d H:i:s')
                );

                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->insert('transmittal_material_list', $supplier_data);
                
                /*print_r('<pre>');
                print_r($supplier_data);
                print_r('</pre>');*/

            }
            $i++;
        }

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Added",
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: TRANSMITTAL REPORT GENERATION',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function get_transmittal_lists()
    {
        $this->db->select('
            transmittal.id as id,
            transmittal.transmittal_no as transmittal_no,
            transmittal.msid as msid,
            transmittal.ms_request_date as ms_request_date,
            transmittal.company as company,
            transmittal.transmittal_date as transmittal_date,
            transmittal.attachment as attachment,
            material_sourcing.id as matsource_id
        ');
        $this->db->from('blaine_local_procurement.transmittal');
        $this->db->join('blaine_local_procurement.material_sourcing', 'blaine_local_procurement.material_sourcing.msid = blaine_local_procurement.transmittal.msid');
        $this->db->where('blaine_local_procurement.transmittal.is_active', 1);
        $query = $this->db->get();

        return $query->result();

    }

    public function get_transmittal_list($id)
    {
        $this->db->select("
            transmittal.id as id,
            transmittal.transmittal_no as transmittal_no,
            transmittal.msid as msid,
            transmittal.ms_request_date as ms_request_date,
            transmittal.company as company,
            transmittal.transmittal_date as transmittal_date,
            transmittal.attachment as attachment
        ");
        $this->db->from('blaine_local_procurement.transmittal');
        $this->db->where('blaine_local_procurement.transmittal.id', $id);
        
        $query = $this->db->get();
        return $query->row();
    }

    public function get_transmittal_material_list($trans_batch_number)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('transmittal_no', $trans_batch_number);
        $query = $blaine_local_procurement->get('transmittal_material_list');

        return $query->result();
    }

    public function add_quotation_materials($canvass_no)
    {
        $this->db->trans_start();

        $canvass_no = $this->input->post('canvass_no');
        $buyer_name = $this->input->post('buyer_name');
        $remarks = $this->input->post('remarks');
        $qty = $this->input->post('qty');
        $uom = $this->input->post('uom');
        $supplier_name = $this->input->post('supplier_name');
        $moq = $this->input->post('moq');
        $price_per_unit = $this->input->post('price_per_unit');
        $currency = $this->input->post('currency');
        $total_price = $this->input->post('total_price');
        $reduction_per_unit = $this->input->post('reduction_per_unit');
        $total_reduction = $this->input->post('total_reduction');
        $saving_unit = $this->input->post('saving_unit');
        $total_saving = $this->input->post('total_saving');
        $i = 0;

        $data_canvass = array(
            'buyer_name' => $buyer_name,
            'remarks'    => $remarks,
            'is_active'  => 1
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $blaine_local_procurement->update('report_generation', $data_canvass);

        /*print_r('<pre>');
        print_r($data_canvass);
        print_r('</pre>');*/

        foreach($this->input->post('material_name') as $material_name)
        {
            $data_material = array(
                'canvass_no'         => $canvass_no,
                'material_name'      => $material_name,
                'quantity'           => $qty[$i],
                'uom'                => $uom[$i],
                'supplier_name'      => $supplier_name[$i],
                'moq'                => $moq[$i],
                'price_per_unit'     => $price_per_unit[$i],
                'currency'           => $currency[$i],
                'total_price'        => $total_price[$i],
                'reduction_per_unit' => $reduction_per_unit[$i],
                'total_reduction'    => $total_reduction[$i],
                'saving_per_unit'    => $saving_unit[$i],
                'total_saving'       => $total_saving[$i],
                'created_by'         => $this->session->userdata('username'),
                'created_date'       => date('Y-m-d H:i:s')

            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->insert('quotation_material_list', $data_material);

            /*print_r('<pre>');
            print_r($data_material);
            print_r('</pre>');*/

            $i++;
        }

        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Added",
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: E-CANVASS REPORT GENERATION STEP:4',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function additional_quotation_materials($canvass_no)
    {
        $this->db->trans_start();

        $canvass_no = $this->input->post('canvass_no');
        $buyer_name = $this->input->post('buyer_name');
        $remarks = $this->input->post('remarks');
        $qty = $this->input->post('qty');
        $uom = $this->input->post('uom');
        $supplier_name = $this->input->post('supplier_name');
        $moq = $this->input->post('moq');
        $price_per_unit = $this->input->post('price_per_unit');
        $currency = $this->input->post('currency');
        $total_price = $this->input->post('total_price');
        $reduction_per_unit = $this->input->post('reduction_per_unit');
        $total_reduction = $this->input->post('total_reduction');
        $saving_unit = $this->input->post('saving_unit');
        $total_saving = $this->input->post('total_saving');
        $i = 0;

        $old_canvass_no =  $this->input->post('old_canvass_no');
        $old_quantity = $this->input->post('old_quantity');
        $old_uom = $this->input->post('old_uom');
        $old_supplier_name = $this->input->post('old_supplier_name'); 
        $old_moq = $this->input->post('old_moq'); 
        $old_price_per_unit = $this->input->post('old_price_per_unit'); 
        $old_currency = $this->input->post('old_currency'); 
        $old_total_price = $this->input->post('old_total_price'); 
        $old_reduction_per_unit = $this->input->post('old_reduction_per_unit'); 
        $old_total_reduction = $this->input->post('old_total_reduction'); 
        $old_saving_per_unit = $this->input->post('old_saving_per_unit'); 
        $old_total_saving = $this->input->post('old_total_saving'); 
        $old_created_by = $this->input->post('old_created_by');
        $old_created_date = $this->input->post('old_created_date');
        $old_is_active = $this->input->post('old_is_active');
        $y = 0;

        // TRANSFER TO MATERIAL LIST LOGS
        foreach($this->input->post('old_material_name') as $old_material_name)
        {
            $data_material_logs = array(
                'canvass_no'         => $old_canvass_no[$y],
                'material_name'      => $old_material_name,
                'quantity'           => $old_quantity[$y],
                'uom'                => $old_uom[$y],
                'supplier_name'      => $old_supplier_name[$y],
                'moq'                => $old_moq[$y],
                'price_per_unit'     => $old_price_per_unit[$y],
                'currency'           => $old_currency[$y],
                'total_price'        => $old_total_price[$y],
                'reduction_per_unit' => $old_reduction_per_unit[$y],
                'total_reduction'    => $old_total_reduction[$y],
                'saving_per_unit'    => $old_saving_per_unit[$y],
                'total_saving'       => $old_total_saving[$y],
                'created_by'         => $old_created_by[$y],
                'created_date'       => $old_created_date[$y],
                'is_active'          => $old_is_active[$y]

            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->insert('quotation_material_list_logs', $data_material_logs);

            $y++;
        }

        // REMOVE OLD DATA
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $blaine_local_procurement->delete('quotation_material_list');

        $data_canvass = array(
            'buyer_name' => $buyer_name,
            'remarks'    => $remarks,
            'is_active'  => 1
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $blaine_local_procurement->update('report_generation', $data_canvass);

        /*print_r('<pre>');
        print_r($data_canvass);
        print_r('</pre>');*/

        // ADD NEW QUOTATION MATERIAL LIST
        foreach($this->input->post('material_name') as $material_name)
        {
            $data_material = array(
                'canvass_no'         => $canvass_no,
                'material_name'      => $material_name,
                'quantity'           => $qty[$i],
                'uom'                => $uom[$i],
                'supplier_name'      => $supplier_name[$i],
                'moq'                => $moq[$i],
                'price_per_unit'     => $price_per_unit[$i],
                'currency'           => $currency[$i],
                'total_price'        => $total_price[$i],
                'reduction_per_unit' => $reduction_per_unit[$i],
                'total_reduction'    => $total_reduction[$i],
                'saving_per_unit'    => $saving_unit[$i],
                'total_saving'       => $total_saving[$i],
                'created_by'         => $this->session->userdata('username'),
                'created_date'       => date('Y-m-d H:i:s')

            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->insert('quotation_material_list', $data_material);

            /*print_r('<pre>');
            print_r($data_material);
            print_r('</pre>');*/

            $i++;
        }

        // BLAINE INTRANET LOGS
        $data_logs = array(
            'username'      => $this->session->userdata('username'),
            'activity'      => "Entry Added",
            'pc_ip'         => $_SERVER['REMOTE_ADDR'],
            'type'          => 'LOCAL PROCUREMENT: E-CANVASS REPORT GENERATION STEP:4',
            'date'          => date('Y-m-d H:i:s')
        );

        $activity_log = $this->load->database('activity_logs', TRUE);
        $activity_log->insert('blaine_logs', $data_logs);

        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function get_material_canvass()
    {
        $this->db->select('
            supplier_material_list.supplier_name as supplier_name,
            supplier_material_list.canvass_no as canvass_no,
            supplier_material_list.moq as moq,
            supplier_material_list.price_per_unit as price_per_unit,
            supplier_material_list.created_by as buyer_name,

            material_report_generation_list.description as material_name,
            material_report_generation_list.quantity as quantity,
            material_report_generation_list.currency as currency,
            material_report_generation_list.uom as uom,
            material_report_generation_list.prev_purchase_unit,
            material_report_generation_list.year as year,

            report_generation.material_pr_no as pr_no,
            report_generation.msid as msid,
            report_generation.created_date as canvass_date,

            supplier_report_generation.pmt as terms,
            supplier_report_generation.attachment as attachment,
            
            material_sourcing.id as idms,
        ');
        $this->db->from('blaine_local_procurement.supplier_material_list');
        $this->db->join('blaine_local_procurement.report_generation', 'blaine_local_procurement.report_generation.canvass_no = blaine_local_procurement.supplier_material_list.canvass_no');
        $this->db->join('blaine_local_procurement.material_report_generation_list', 'blaine_local_procurement.material_report_generation_list.id = blaine_local_procurement.supplier_material_list.material_id');
        $this->db->join('blaine_local_procurement.supplier_report_generation', 'blaine_local_procurement.supplier_report_generation.supplier_name = blaine_local_procurement.supplier_material_list.supplier_name AND blaine_local_procurement.supplier_report_generation.canvass_no = blaine_local_procurement.supplier_material_list.canvass_no');
        $this->db->join('blaine_local_procurement.material_sourcing', 'blaine_local_procurement.material_sourcing.msid = blaine_local_procurement.report_generation.msid', 'left');
        $this->db->where('blaine_local_procurement.supplier_material_list.price_per_unit !=', 0);

        $query = $this->db->get();

        return $query->result();
    }

    public function get_canvass_lists()
    {
        $this->db->select('
            report_generation.canvass_no as canvass_no,
            report_generation.msid as msid,
            report_generation.material_pr_no as pr_no,
            report_generation.company as company,
            report_generation.buyer_name as buyer_name,
            report_generation.created_date as canvass_date,
            SUM(quotation_material_list.total_reduction) as cost_saving,
            SUM(quotation_material_list.total_saving) as cost_avoidance,
            material_sourcing.id as idms
        ');

        $this->db->from('blaine_local_procurement.report_generation');
        $this->db->join('blaine_local_procurement.quotation_material_list', 'blaine_local_procurement.report_generation.canvass_no = blaine_local_procurement.quotation_material_list.canvass_no');
        $this->db->join('blaine_local_procurement.material_sourcing', 'blaine_local_procurement.material_sourcing.msid = blaine_local_procurement.report_generation.msid', 'left');
        $this->db->group_by('blaine_local_procurement.quotation_material_list.canvass_no');
        $this->db->where('blaine_local_procurement.report_generation.is_active', 1);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_total_supplier()
    {
        $this->db->select('
            supplier_report_generation.canvass_no as canvass_no,
            COUNT(distinct(supplier_report_generation.supplier_name)) as total_supplier
        ');
        $this->db->from('blaine_local_procurement.supplier_report_generation');
        $this->db->group_by('blaine_local_procurement.supplier_report_generation.canvass_no');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_net_cost_saving()
    {
        $this->db->select('
            SUM(quotation_material_list.total_reduction) as net_cost_saving
        ');

        $this->db->from('blaine_local_procurement.quotation_material_list');
        $query = $this->db->get();

        return $query->row();
    }

    public function get_cost_avoidance()
    {
        $this->db->select('
            SUM(quotation_material_list.total_saving) as total_saving
        ');

        $this->db->from('blaine_local_procurement.quotation_material_list');
        $query = $this->db->get();

        return $query->row();
    }

    public function get_cost_saving_negative()
    {
        $this->db->select('
            SUM(quotation_material_list.total_reduction) as cost_saving
        ');

        $this->db->from('blaine_local_procurement.quotation_material_list');
        $this->db->where('quotation_material_list.total_reduction <', 0);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_cost_saving()
    {
        $this->db->select('
            SUM(quotation_material_list.total_reduction) as cost_saving
        ');

        $this->db->from('blaine_local_procurement.quotation_material_list');
        $this->db->where('quotation_material_list.total_reduction >', 0);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_canvass_no($msid)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('msid', $msid);
        $query = $blaine_local_procurement->get('report_generation');

        return $query->result();
    }

    public function get_transmittal_no($msid)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('msid', $msid);
        $query = $blaine_local_procurement->get('transmittal');

        return $query->result();
    }

    public function get_material_transmittal_no($msid)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('msid', $msid);
        $query = $blaine_local_procurement->get('transmittal_material_list');

        return $query->result();
    }

    public function get_quotation_material_list($canvass_no)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $query = $blaine_local_procurement->get('quotation_material_list');

        return $query->result();
    }

    public function get_canvass_list($canvass_no)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $query = $blaine_local_procurement->get('report_generation');

        return $query->row();
    }
    
    public function supplier_quotations($canvass_no)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $query = $blaine_local_procurement->get('quotation_material_list');

        return $query->result(); 
    }

    public function get_quotation_material_list_log($canvass_no)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $query = $blaine_local_procurement->get('quotation_material_list_logs');

        return $query->result();
    }

    public function get_quotation_material_list_logs()
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->group_by('canvass_no');
        $query = $blaine_local_procurement->get('quotation_material_list_logs');

        return $query->result();
    }

    public function get_supplier_list_logs()
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->group_by('scode');
        $query = $blaine_local_procurement->get('supplier_logs');

        return $query->result();
    }

    public function get_new_revision_date($canvass_no)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $query = $blaine_local_procurement->get('quotation_material_list');

        return $query->row();
    }

    public function get_old_revision_date($canvass_no)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('canvass_no', $canvass_no);
        $query = $blaine_local_procurement->get('quotation_material_list_logs');

        return $query->row();
    }
}
