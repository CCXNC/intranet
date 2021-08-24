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
        

        // Material Sourcing 
        $msid = $batch_number;
        $company = $this->input->post('company');
        $sourcing_category = $this->input->post('sourcing_category');
        $date_required = $this->input->post('date_required');

        // Material list
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
       $material_source_status = $status[1]. ' '. '(' .$role_status[1].')' ;
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
            'created_by'         => $this->session->userdata('username'),
            'created_date'       => $date,
            'step_approval'      => 2
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material_approval_list', $data_material_approver2);
     
        /*print_r('<pre>');
        print_r($data_material_approver2);
        print_r('</pre>');*/


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


        // Material Sourcing 
        $msid = $batch_number;
        $company = $this->input->post('company');
        $sourcing_category = $this->input->post('sourcing_category');
        $date_required = $this->input->post('date_required');

        // Material list
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
       $material_source_status = $status[1]. ' '. '(' .$role_status[1].')' ;
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


        //$blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        //$blaine_local_procurement->insert('material_sourcing', $data_material_source);

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
            'created_by'         => $this->session->userdata('username'),
            'created_date'       => $date,
            'step_approval'      => 2
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->insert('material_approval_list', $data_material_approver2);

        /*print_r('<pre>');
        print_r($data_material_approver2);
        print_r('</pre>');*/

        $trans = $this->db->trans_complete();
        return $trans;

    }

    public function get_material_sourcing_list()
    {
        $this->db->select("
            material_sourcing.id as id,
            material_sourcing.msid as msid,
            material_sourcing.created_date as request_date,
            CONCAT(employees.last_name, ',', employees.first_name , ' ', employees.middle_name) as requestor_name,
            material_sourcing.date_required as date_required,
            COUNT(material_sourcing_list.msid) as total_material,
            department.name as department_name,
            material_sourcing.role_status as role_status,
        ");
        $this->db->from('blaine_local_procurement.material_sourcing');
        $this->db->join('blaine_local_procurement.material_sourcing_list', 'blaine_local_procurement.material_sourcing_list.msid = blaine_local_procurement.material_sourcing.msid','left');
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
        $mcode1 = $this->input->post('mcode1');
        $mcode2 = $this->input->post('mcode2');
        $mcode3 = $this->input->post('mcode3');
        $mcode4 = $this->input->post('mcode4');
        $mcode = $mcode1 . '-' . $mcode2 . '-' . $mcode3 . '-' . $mcode4;
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
        $query = $blaine_local_procurement->insert('material', $data);

        /*print_r('<pre>');
        print_r($data);
        print_r('</pre>');*/

        return $query;
    }

    public function update_material($id)
    {
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
        $blaine_local_procurement->where('id', $id);
        $query = $blaine_local_procurement->update('material', $data);

        return $query;

    }

    public function delete_material($id)
    {
        $data_material = array(
            'is_active' => 0
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $id);
        $query = $blaine_local_procurement->update('material', $data_material);
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
            company.name as company_name
        ");
        $this->db->from('blaine_local_procurement.material_sourcing');
        $this->db->join('blaine_intranet.company', 'blaine_intranet.company.id = blaine_local_procurement.material_sourcing.company_id');
        $this->db->where('material_sourcing.id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_materials_by_material_sourcing_id($msid)
    {
        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('msid', $msid);
        $query = $blaine_local_procurement->get('material_sourcing_list');

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
}
