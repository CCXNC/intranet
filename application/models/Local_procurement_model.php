<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Local_procurement_model extends CI_Model {
    
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
        $batch_number = str_pad($i, 9, '0', STR_PAD_LEFT);
        
        // Email Information
        $subject = "Intranet Auto Email";
        $email = ('jesa.lacambra@blainegroup.com.ph');

        // Material Sourcing 
        $msid = $batch_number;
        $source_id = $this->input->post('source_id');
        $company = $this->input->post('company');
        $sourcing_category = $this->input->post('sourcing_category');
        $date_required = $this->input->post('date_required');
        $date_requested = date('Y-m-d');

        // Material list
        $attachment = $_FILES['attachment1']['name'];
        $description = $this->input->post('description');
        $specification = $this->input->post('specification');
        $quantity = $this->input->post('quantity');
        $uom =  $this->input->post('uom');
        $shelf_life =  $this->input->post('shelf_life');
        $item_application =  $this->input->post('item_application');
        $required_document = $this->input->post('required_document');
        $material_category = $this->input->post('material_category');
        $purpose = $this->input->post('purpose');
        $i = 0;

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


         /** MATERIAL LIST INSERT **/ 
        foreach($this->input->post('material_code') as $mcode)
        {
            $data_material = array(
                'msid'              => $msid,
                'mcode'             => $mcode,
                'description'       => $description[$i],
                'specification'     => $specification[$i],
                'quantity'          => $quantity[$i],
                'uom'               => $uom[$i],
                'shelf_life'        => $shelf_life[$i],
                'item_application'  => $item_application[$i],
                'required_document' => $required_document[$i],
                'category'          => $material_category[$i],
                'remarks'           => $purpose[$i],
                'attachment'        => $attachment[$i],
                'created_by'        => $this->session->userdata('username'),
                'created_date'      => $date
            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->insert('material_sourcing_list', $data_material);

            /*print_r('<pre>');
            print_r($data_material);
            print_r('</pre>');*/

            $i++;
        }

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

        /* Auto-Email After Doing Superior Action Required */
        // Get approval details
        /* $this->db->select("
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
            'smtp_user'     => 'intranet_system@blainegroup.com.ph', // change it to yours
            'smtp_pass'     => 'kGCBYMyUum[2', // change it to yours
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
        $this->email->subject($msid);
        $this->email->message($format);
        if($this->email->send()){
            $this->session->set_flashdata('message', 'Email sent');
        }
        else{
            $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
        }*/

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
        $batch_number = str_pad($i, 9, '0', STR_PAD_LEFT);

        // Email Information
        $subject = "Intranet Auto Email";
        $email = ('jesa.lacambra@blainegroup.com.ph');

        // Material Sourcing 
        $msid = $batch_number;
        
        $company = $this->input->post('company');
        $sourcing_category = $this->input->post('sourcing_category');
        $date_required = $this->input->post('date_required');
        $date_requested = date('Y-m-d');

        // Material list
        $attachment = $_FILES['attachment']['name'];
        $specification = $this->input->post('specification');
        $quantity = $this->input->post('quantity');
        $uom =  $this->input->post('uom');
        $shelf_life =  $this->input->post('shelf_life');
        $item_application =  $this->input->post('item_application');
        $required_document = $this->input->post('required_document');
        $material_category = $this->input->post('material_category');
        $purpose = $this->input->post('purpose');
        $i = 0;

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


         /** MATERIAL LIST INSERT **/ 
        foreach($this->input->post('description') as $description)
        {
            $data_material = array(
                'msid'              => $msid,
                'description'       => $description,
                'specification'     => $specification[$i],
                'quantity'          => $quantity[$i],
                'uom'               => $uom[$i],
                'shelf_life'        => $shelf_life[$i],
                'item_application'  => $item_application[$i],
                'required_document' => $required_document[$i],
                'category'          => $material_category[$i],
                'remarks'           => $purpose[$i],
                'attachment'        => $attachment[$i],
                'created_by'        => $this->session->userdata('username'),
                'created_date'      => $date
            );

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->insert('material_sourcing_list', $data_material);

            /*print_r('<pre>');
            print_r($data_material);
            print_r('</pre>');*/

            $i++;
        }

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

        /* Auto-Email After Doing Superior Action Required */
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

        /*foreach($approval_lists as $approval_list)
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
            'smtp_user'     => 'intranet_system@blainegroup.com.ph', // change it to yours
            'smtp_pass'     => 'kGCBYMyUum[2', // change it to yours
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
        $this->email->subject($msid);
        $this->email->message($format);
        if($this->email->send()){
            $this->session->set_flashdata('message', 'Email sent');
        }
        else{
            $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
        }*/

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
            step_of_approver.name as step_of_approval
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
            material_approval_list.created_by as created_by
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

        // Email Information
        $subject = "Intranet Auto Email";
        $email = ('jesa.lacambra@blainegroup.com.ph');

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

        // Get Superior Approval
        $remarks = $this->input->post('remarks');
        $requestor_approver = $this->input->post('request_approver');
        $primary_approver_superior = $this->input->post('primary_approver_superior');
        $alternate_approver_superior = $this->input->post('alternate_approver_superior');
        $destination_approval = $this->input->post('destination_approval');
        $primary_approver_procurement = $this->input->post('primary_approver1');
        $alternate_approver_procurement = $this->input->post('alternate_approver1');

        // Get email accounts
        $data_explod = explode(',', $this->input->post('email_accounts'));
        
        // Requestor Email
        $req_primary_email1 = $data_explod[0];
        $req_alternate_email1 = $data_explod[1];

        // Superior Email
        $req_primary_email2 = $data_explod[2];
        $req_alternate_email2 = $data_explod[3];

        // Procurement Email
        $procurement = ('jesa.lacambra@blainegroup.com.ph, christian.guarin@blainegroup.com.ph');
        
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
                    'remarks'      => $remarks
                );  
    
                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->where('id', $last_entry_id);
                $blaine_local_procurement->update('material_approval_list', $data_update_last_entry);
    
                /*print_r('<pre>');
                print_r($data_update_last_entry);
                print_r('</pre>');*/
        
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
                        'smtp_user'     => 'intranet_system@blainegroup.com.ph', // change it to yours
                        'smtp_pass'     => 'kGCBYMyUum[2', // change it to yours
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
                    $this->email->subject($msid);
                    $this->email->message($format);
                    if($this->email->send()){
                        $this->session->set_flashdata('message', 'Email sent');
                    }
                    else{
                        $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
                    }
                }
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
                        'alternate_approver' => "MONTEMAYOR, JASMINE DENISSE SANCHEZ",
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
                        'smtp_user'     => 'intranet_system@blainegroup.com.ph', // change it to yours
                        'smtp_pass'     => 'kGCBYMyUum[2', // change it to yours
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
                    $this->email->subject($msid);
                    $this->email->message($format);
                    if($this->email->send()){
                        $this->session->set_flashdata('message', 'Email sent');
                    }
                    else{
                        $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
                    }
                }
                elseif($destination_approval == 0)
                {
                    $data_material_source = array(
                        'role_status' => 'Closed'
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
                        'alternate_approver' => "MONTEMAYOR, JASMINE DENISSE SANCHEZ",
                        'role_status'        => "Procurement",
                        'status'             => 'Done',
                        'created_by'         => $this->session->userdata('username') . ' 0',
                        'created_date'       => $date,
                        'signoff_date'       => $date,
                        'step_approval'      => 6
        
                    );
        
                    $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                    $blaine_local_procurement->insert('material_approval_list', $data_action_required);
        
                    /*print_r('<pre>');
                    print_r($data_action_required);
                    print_r('</pre>');*/
                }
               
               
            }
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
                    'remarks'      => $remarks
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
                    'alternate_approver' => "MONTEMAYOR, JASMINE DENISSE SANCHEZ",
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
                    'smtp_user'     => 'intranet_system@blainegroup.com.ph', // change it to yours
                    'smtp_pass'     => 'kGCBYMyUum[2', // change it to yours
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
                $this->email->subject($msid);
                $this->email->message($format);
                if($this->email->send()){
                    $this->session->set_flashdata('message', 'Email sent');
                }
                else{
                    $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
                }
                
            }
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
                    'remarks'      => $remarks
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
                    'smtp_user'     => 'intranet_system@blainegroup.com.ph', // change it to yours
                    'smtp_pass'     => 'kGCBYMyUum[2', // change it to yours
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
                $this->email->subject($msid);
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
                'remarks'      => $remarks
            );  

            $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('id', $last_entry_id);
            $blaine_local_procurement->update('material_approval_list', $data_update_last_entry);

            /*print_r('<pre>');
            print_r($data_update_last_entry);
            print_r('</pre>');*/
    
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
                    'smtp_user'     => 'intranet_system@blainegroup.com.ph', // change it to yours
                    'smtp_pass'     => 'kGCBYMyUum[2', // change it to yours
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
                $this->email->subject($msid);
                $this->email->message($format);
                if($this->email->send()){
                    $this->session->set_flashdata('message', 'Email sent');
                }
                else{
                    $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
                }
            }
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
                    'smtp_user'     => 'intranet_system@blainegroup.com.ph', // change it to yours
                    'smtp_pass'     => 'kGCBYMyUum[2', // change it to yours
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
                $this->email->subject($msid);
                $this->email->message($format);
                if($this->email->send()){
                    $this->session->set_flashdata('message', 'Email sent');
                }
                else{
                    $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
                }
            }
        
        }

        elseif($process == 2)
        {
            // MATERIAL APPROVAL LIST
            $data_update_last_entry = array(
                'status'        => 'Disapproved',
                'signoff_by'    => $this->session->userdata('username'),
                'signoff_date'  => $date,
                'remarks'       => $remarks,
                'step_approval' => 10 
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

        // MATERIAL APPROVAL LIST
        $data_update_last_entry = array(
            'status'       => 'Done',
            'signoff_by'   => $this->session->userdata('username'),
            'signoff_date' => $date,
            'remarks'      => $remarks
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
        $batch_number = str_pad($i, 9, '0', STR_PAD_LEFT);

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
        $batch_number = str_pad($i, 9, '0', STR_PAD_LEFT);

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

    public function add_report_generation_with_supplier()
    {
        $this->db->trans_start();

        $canvass_no = $this->input->post('canvass_no');
        $accredited = $this->input->post('accredited');
        $other = $this->input->post('others');
        $vat = $this->input->post('vat');
        $wrt = $this->input->post('wrt');
        $pmt = $this->input->post('pmt');
        $del = $this->input->post('del');
        $notes = $this->input->post('notes');
        $date = date('Y-m-d H:i:s');
        $i = 0;

        foreach($this->input->post('supplier') as $supplier)
        {
            if($supplier == 'acc')
            {
                $supplier_data = array(
                    'canvass_no'    => $canvass_no,
                    'supplier_name' => $accredited[$i],
                    'vat'           => $vat[$i],
                    'wrt'           => $wrt[$i],
                    'pmt'           => $pmt[$i],
                    'del'           => $del[$i],
                    'notes'         => $notes[$i],
                    'created_by'    => $this->session->userdata('username'),
                    'created_date'  => $date
                );

                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->insert('supplier_report_generation', $supplier_data);

                /*print_r('<pre>');
                print_r($supplier_data);
                print_r('</pre>');*/
                
            }
            elseif($supplier == 'others')
            {
                $supplier_data = array(
                    'canvass_no'    => $canvass_no,
                    'supplier_name' => $other[$i],
                    'vat'           => $vat[$i],
                    'wrt'           => $wrt[$i],
                    'pmt'           => $pmt[$i],
                    'del'           => $del[$i],
                    'notes'         => $notes[$i],
                    'created_by'    => $this->session->userdata('username'),
                    'created_date'  => $date
                );
                
                $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
                $blaine_local_procurement->insert('supplier_report_generation', $supplier_data);

                /*print_r('<pre>');
                print_r($supplier_data);
                print_r('</pre>');*/

            }
            $i++;
        }

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

        // Email Information
        //$subject = "Intranet Auto Email";
        $email1 = ('jesa.lacambra@blainegroup.com.ph');
        $subject = $this->input->post('subject');
        $ms_requested_date = date('Y-m-d');
        // Procurement Email
        $procurement = ('jesa.lacambra@blainegroup.com.ph');
        // Email Recipient
        //$trans_email_receipt = $email.','.$procurement;

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
        $trans_batch_number = str_pad($i, 9, '0', STR_PAD_LEFT);

        $data = array(
            'transmittal_no'    => $trans_batch_number,
            'msid'              => $msid,
            'ms_request_date'   => $ms_request_date,
            'company'           => $company,
            'requestor'         => $requestor,
            'transmittal_date'  => $transmittal_date,
            'email'             => $email,
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

        // Get Material Table
        $this->db->select("
            transmittal_material_list.transmittal_no as transmittal_no,
            transmittal_material_list.description as description,
            transmittal_material_list.supplier_name as supplier,
            transmittal_material_list.batch_number as batch_number,
            transmittal_material_list.attachment as attachment,
            transmittal.id as trans_id
        ");

        $this->db->from('blaine_local_procurement.transmittal_material_list');
        $this->db->join('blaine_local_procurement.transmittal', 'blaine_local_procurement.transmittal.transmittal_no = blaine_local_procurement.transmittal_material_list.transmittal_no');
        $this->db->where('blaine_local_procurement.transmittal_material_list.transmittal_no', $trans_batch_number);

        $query = $this->db->get();

        $transmittal_lists = $query->result();

        foreach($transmittal_lists as $transmittal_list)
        {
            $e_transmittal_no = $transmittal_list->transmittal_no;
            $e_description = $transmittal_list->description;
            $e_supplier = $transmittal_list->supplier;
            $e_batch_number = $transmittal_list->batch_number;
            $e_attachment = $transmittal_list->attachment;
            $e_trans_id = $transmittal_list->trans_id;

            $transmittal_material .= '<tbody>
                <tr>
                    <td style="font-size:12px">'.$e_description.'</td>
                    <td style="font-size:12px">'.$e_supplier.'</td>
                    <td style="font-size:12px">'.$e_batch_number.'</td>
                    <td style="font-size:12px"><a href="http://localhost/blaineintranet/procurement/transmittal_view/'.$e_trans_id.'/'.$e_transmittal_no.'" style="color: #999999;">'.$e_attachment.'</a></td>
                </tr>
            </tbody>';
        }

        // Get Trans ID
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $query = $blaine_local_procurement->get('transmittal');
        $transmittals = $query->result();

        foreach($transmittals as $transmittal){
            $trans_id = $transmittal->id;
        }

        /*$format .= '<!DOCTYPE html>
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
                                        Transmittal
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="font-size:16px">
                                        Kindly acknowledge receipt of above-captioned sample for testing.
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
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Transmittal No:</b><a href="http://localhost/blaineintranet/procurement/transmittal_view/'.$trans_id.'/'.$trans_batch_number.'" style="color: #999999;">'.$trans_batch_number.'</a></p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Transmittal Date:</b> '.$transmittal_date.'</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Material Source Request ID:</b> '.$msid.'</p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Company:</b> '.$company.'</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>Buyer:</b> '.$this->session->userdata('username').'</p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:260px;padding:0;vertical-align:top;">
                                                                <p style="margin:0 0 12px 0;font-size:13px;line-height:24px;font-family:Arial,sans-serif;"><b>RE:</b> '.$subject.'</p>
                                                            </td>
                                                            <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
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
                                                        <th scope="col" style="font-size:12px">Material Description</th>
                                                        <th scope="col" style="font-size:12px">Supplier</th>
                                                        <th scope="col" style="font-size:12px">Batch Number</th>
                                                        <th scope="col" style="font-size:12px">Supporting Documents</th>
                                                    </tr>
                                                </thead>
                                                '.$transmittal_material.'
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
        </html>';*/

        /*print_r('<pre>');
        print_r($format);
        print_r('</pre>');*/

        /*$config = Array(
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
        $this->email->to($procurement);// change it to yours
        $this->email->cc($email);
        //$this->email->bcc($bcc);
        $this->email->subject($subject);
        $this->email->message($format);
        if($this->email->send()){
            $this->session->set_flashdata('message', 'Email sent');
        }
        else{
            $this->session->set_flashdata('message', show_error($this->email->print_debugger()));
        }*/

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
        /*$blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('is_active', 1);
        $query = $blaine_local_procurement->get('transmittal');

        return $query->result();*/

        $this->db->select('
            transmittal.id as id,
            transmittal.transmittal_no as transmittal_no,
            transmittal.msid as msid,
            transmittal.ms_request_date as ms_request_date,
            transmittal.company as company,
            transmittal.requestor as requestor,
            transmittal.transmittal_date as transmittal_date,
            transmittal.email as email,
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
            transmittal.requestor as requestor,
            transmittal.transmittal_date as transmittal_date,
            transmittal.email as email,
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
    
}
