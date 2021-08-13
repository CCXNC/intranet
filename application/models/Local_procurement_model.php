<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Local_procurement_model extends CI_Model {
    
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

            /*$blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('supplier.id',$id);
            $blaine_local_procurement->update('supplier', $data_supplier);*/
            
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
                'updated_date'          => $date,
                'updated_by'            => $this->session->userdata('username')
            );

            /*$blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
            $blaine_local_procurement->where('supplier.id',$id);
            $blaine_local_procurement->update('supplier', $data_supplier);*/
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

    public function delete_material($id)
    {
        $data_material = array(
            'is_active' => 0
        );

        $blaine_local_procurement = $this->load->database('blaine_local_procurement', TRUE);
        $blaine_local_procurement->where('id', $id);
        $query = $blaine_local_procurement->update('material', $data_material);

        return $query;
    }
}
