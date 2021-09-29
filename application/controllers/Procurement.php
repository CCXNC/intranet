<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('csv_import_model');
		$this->load->library('csvimport');
		ini_set('max_execution_time',0);
		ini_set('memory_limit','2048M');

        date_default_timezone_set('Asia/Manila');

        if($this->session->userdata('logged_in') !== TRUE){
            redirect('Login');
        }
    }

    function local_procurement() 
    {
        $data['main_content'] = 'procurement/local/index';
        $this->load->view('inc/navbar', $data);
    }
    
    function ecanvass_index()
    {
        $data['main_content'] = 'procurement/local/ecanvass/index';
        $this->load->view('inc/navbar', $data);
    }

    function form_index()
    {
        $data['main_content'] = 'procurement/local/ecanvass/form/index';
        $this->load->view('inc/navbar', $data);
    }

    function form_add()
    {
        $data['employees'] = $this->employee_model->get_employees();
        $data['main_content'] = 'procurement/local/ecanvass/form/add';
        $this->load->view('inc/navbar', $data);
    }

    function form_view()
    {
        $data['main_content'] = 'procurement/local/ecanvass/form/view';
        $this->load->view('inc/navbar', $data);
    }

    function form_edit()
    {
        $data['employees'] = $this->employee_model->get_employees();
        $data['main_content'] = 'procurement/local/ecanvass/form/edit';
        $this->load->view('inc/navbar', $data);
    }

    function supplier_index()
    {
        $data['suppliers'] = $this->local_procurement_model->get_suppliers();
        $data['main_content'] = 'procurement/local/ecanvass/supplier/index';
        $this->load->view('inc/navbar', $data);
    }

    function supplier_add()
    {
        $this->form_validation->set_rules('scode', 'Supplier Code', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['suppliers'] = $this->local_procurement_model->get_suppliers();
            $data['main_content'] = 'procurement/local/ecanvass/supplier/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if(!empty($_FILES['attachment']['name']))
            {
                $imageName = $_FILES['attachment']['name'];

                // File upload configuration
                $config['upload_path'] = './uploads/supplier_attachment/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf';
                $config['max_size'] = '100000000';
                $config['overwrite'] = True;

                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // Upload file to server
                if($this->upload->do_upload('attachment')){
                    // Upload file data
                    $fileData = $this->upload->data();
                    $imgData['file_name'] = $fileData['file_name'];
                }
                else{
                    $error = $this->upload->display_errors();
                }
            }
            if($this->local_procurement_model->add_supplier())
            {
                $this->session->set_flashdata('success_msg', 'Supplier Successfully Added!');
                redirect('procurement/supplier_index');
            }
        }
    }

    function supplier_import_view()
    {
        $data['main_content'] = 'procurement/local/ecanvass/supplier/csv';
        $this->load->view('inc/navbar', $data);
    }

    function supplier_import()
	{
		$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
		foreach($file_data as $row)
		{
			$data[] = array( 
				'scode'	              => $row["VendorCode"],
				'name'		          => $row["SupplierName"],
				'contact_name'        => $row["ContactName"],
                'contact_designation' => $row["ContactDesignation"],
                'contact_number'      => $row["ContactDetail"],
                'email'               => $row["Email"],
                'address'             => $row["Address"],
                'supplier_profile'    => $row["SupplierProfile"]
			);
			
		}
		$this->csv_import_model->insert_supplier($data);
	}

    function material_import()
	{
		$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
		foreach($file_data as $row)
		{
            $data[] = array( 
				'mcode'	              => $row["material_code"],
				'description'		  => $row["material_description"],
                'group_code'          => $row["material_group_code"]
			);
			
		}
		$this->csv_import_model->insert_material($data);
	}
 

    function supplier_view($id)
    {
        $data['supplier'] = $this->local_procurement_model->get_supplier($id);
        $data['main_content'] = 'procurement/local/ecanvass/supplier/view';
        $this->load->view('inc/navbar', $data);
    }
    
    function download_attachment()
    {
        $this->load->helper('download');
        $data = file_get_contents('uploads/supplier_attachment/'.$this->uri->segment(3));
        $name = $this->uri->segment(3);
        force_download($name, $data);
    }

    function download_material_attachment()
    {
        $this->load->helper('download');
        $data = file_get_contents('uploads/material_sourcing_attachment/'.$this->uri->segment(3));
        $name = $this->uri->segment(3);
        force_download($name, $data);
    }

    //EDIT
    public function supplier_edit($id)
    {
        $this->form_validation->set_rules('scode', 'Supplier Code', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['supplier'] = $this->local_procurement_model->get_supplier($id);
            $data['main_content'] = 'procurement/local/ecanvass/supplier/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            // GET PREVIOUS DATA
            $attachment_file = $this->local_procurement_model->get_supplier($id);
            $prevImage = $attachment_file->attachment;

            if(!empty($_FILES['attachment']['name'])){
                $imageName = $_FILES['attachment']['name'];

                // File upload configuration
                $config['upload_path'] = './uploads/supplier_attachment/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docs|xls|xlsx|pdf';

                //Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if(!empty($prevImage) || !empty($imageName)){ 
                    // Remove old file from the server 
                    @unlink('./uploads/supplier_attachment/'.$prevImage);  

                    // Upload file to server 
                    if($this->upload->do_upload('attachment')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $imgData['file_name'] = $fileData['file_name']; 
                    
                    }else{ 
                        $error = $this->upload->display_errors(); 
                    } 
                } 
            }

            if($this->local_procurement_model->update_supplier($id))
            {
                $this->session->set_flashdata('success_msg', 'Supplier Successfully Updated!');
                redirect('procurement/supplier_index');
            }
        }
        
    }

    public function supplier_delete($id)
    {
        if($this->local_procurement_model->delete_supplier($id))
        {
            $this->session->set_flashdata('error_msg', 'Supplier Successfully Deleted!');
            redirect('procurement/supplier_index');
        }
    }


    function comparative_view($canvass_no) 
    {
        $data['suppliers'] = $this->local_procurement_model->get_supplier_report_generation($canvass_no);
        $data['materials'] = $this->local_procurement_model->get_canvass_material_list($canvass_no);
        $data['canvass'] = $this->local_procurement_model->get_report_generation($canvass_no);
        $data['supplier_materials'] = $this->local_procurement_model->supplier_materials($canvass_no);
        $data['cost_aviodances'] = $this->local_procurement_model->get_supplier_materials($canvass_no);

        $data['main_content'] = 'procurement/local/ecanvass/comparative/view';
        $this->load->view('inc/navbar', $data);
    }

    public function add_ecanvass_report_generation()
    {
        $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/add';
        $this->load->view('inc/navbar', $data);
    }

    public function add_ecanvass_report_generation1()
    {
        $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/add1';
        $this->load->view('inc/navbar', $data);
    }

    public function ecanvass_cost_saving()
    {
        $data['main_content'] = 'procurement/local/ecanvass/cost_saving/index';
        $this->load->view('inc/navbar', $data);
    }

    public function material_canvass()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_history/index';
        $this->load->view('inc/navbar', $data);
    }

    public function material_sourcing()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_sourcing/form';
        $this->load->view('inc/navbar', $data);
    }

    public function material_sourcing_index()
    {
        $data['material_sourcings'] = $this->local_procurement_model->get_material_sourcing_list();
        $data['main_content'] = 'procurement/local/ecanvass/material_sourcing/index';
        $this->load->view('inc/navbar', $data);
    }

    public function material_sourcing_matcode()
    {
        $this->form_validation->set_rules('date_required', 'Company', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['employees'] = $this->employee_model->get_employees();
            $data['uoms'] = $this->local_procurement_model->get_uom();
            $data['batch_number'] = $this->local_procurement_model->first_msid();
           
            $data['main_content'] = 'procurement/local/ecanvass/material_sourcing/w_matcode/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            /*if(!empty($_FILES['attachment']['name']))
            {
                $imageName = $_FILES['attachment']['name'];

                // File upload configuration
                $config['upload_path'] = './uploads/material_sourcing_attachment/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf|zip';
                $config['max_size'] = '100000000';
                $config['overwrite'] = True;

                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // Upload file to server
                if($this->upload->do_upload('attachment')){
                    // Upload file data
                    $fileData = $this->upload->data();
                    $imgData['file_name'] = $fileData['file_name'];
                }
                else{
                    $error = $this->upload->display_errors();
                }
            }*/
                
            if($this->local_procurement_model->add_material_sourcing_matcode())
            {
                $data = $this->local_procurement_model->first_msid();
                
                $id = $data->id;
                $msid = $data->msid;

                $this->session->set_flashdata('success_msg', 'Material Sourcing Successfully Added!');
                redirect('procurement/material_sourcing_view/'.$id.'/'.$msid.'');
            }
        }
       
    }

    public function json_material()
    {
        $data = $this->local_procurement_model->get_materials();
        echo json_encode($data);
    }

    public function material_sourcing_nomatcode()
    {
        $this->form_validation->set_rules('date_required', 'Company', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['employees'] = $this->employee_model->get_employees();
            $data['uoms'] = $this->local_procurement_model->get_uom();
            $data['material_groups'] = $this->local_procurement_model->get_material_group();
            $data['batch_number'] = $this->local_procurement_model->first_msid();
            $data['main_content'] = 'procurement/local/ecanvass/material_sourcing/wo_matcode/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            /*if(!empty($_FILES['attachment']['name']))
            {
                $imageName = $_FILES['attachment']['name'];

                // File upload configuration
                $config['upload_path'] = './uploads/material_sourcing_attachment/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|xls|xlsx|pdf|zip';
                $config['max_size'] = '100000000';
                $config['overwrite'] = True;

                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // Upload file to server
                if($this->upload->do_upload('attachment')){
                    // Upload file data
                    $fileData = $this->upload->data();
                    $imgData['file_name'] = $fileData['file_name'];
                }
                else{
                    $error = $this->upload->display_errors();
                }
            }*/
            if($this->local_procurement_model->add_material_sourcing_nomatcode())
            {
                $data = $this->local_procurement_model->first_msid();
                
                $id = $data->id;
                $msid = $data->msid;
                
                $this->session->set_flashdata('success_msg', 'Material Sourcing Successfully Added!');
                redirect('procurement/material_sourcing_view/'.$id.'/'.$msid.'');
            }
        }
       
    }

    public function material_sourcing_edit($id,$msid) 
    {
        $this->form_validation->set_rules('msid', 'Description', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['material_source'] = $this->local_procurement_model->get_material_source($id);
            $data['materials'] = $this->local_procurement_model->get_materials_by_material_sourcing_id($msid);
            $data['material_groups'] = $this->local_procurement_model->get_material_group();
            $data['uoms'] = $this->local_procurement_model->get_uom();
            $data['main_content'] = 'procurement/local/ecanvass/material_sourcing/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->local_procurement_model->update_material_sourcing_matcode())
            {
                $this->session->set_flashdata('success_msg', 'Material Sourcing Successfully Updated!');
                redirect('procurement/material_sourcing_index');
            }
        }

      
    } 

    public function material_sourcing_view($id,$msid)
    {
        $data['material_source'] = $this->local_procurement_model->get_material_source($id);
        $data['materials'] = $this->local_procurement_model->get_materials_by_material_sourcing_id($msid);
        $data['approval_lists'] = $this->local_procurement_model->get_approval_by_material_sourcing_id($msid);
        $data['first_entry'] = $this->local_procurement_model->get_first_approval_by_material_sourcing_id($msid);
        $data['last_entry'] = $this->local_procurement_model->get_last_approval_by_material_sourcing_id($msid);

        $data['main_content'] = 'procurement/local/ecanvass/material_sourcing/view';
        $this->load->view('inc/navbar', $data);
    }

    public function materialsource_approval_process()
    {
        if($this->local_procurement_model->material_source_approval_process())
        {
            $this->session->set_flashdata('success_msg', 'Approve material sourcing successfully updated!');
            redirect('procurement/material_sourcing_index');
        }
    }

    public function ecanvass_report_generation()
    {
        $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/index';
        $this->load->view('inc/navbar', $data);
    }

    public function report_matsource_add()
    {
        $this->form_validation->set_rules('pr_no', 'PR NUMBER', 'required|trim');   

        if($this->form_validation->run() == FALSE)
        {
            $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/matsource/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->local_procurement_model->add_report_generation_msid())
            {
                

                $data = $this->local_procurement_model->last_canvass_no();
                
                $canvass_no = $data->canvass_no;
                $material_pr_no = $data->material_pr_no;
                
                redirect('procurement/report_matsource_add_supplier/'.$canvass_no.'/'.$material_pr_no.'');
            }
        }
         
    }

    public function report_matsource_add_supplier($canvass_no,$material_pr_no)
    {
        $this->form_validation->set_rules('canvass_no', 'Canvass Number', 'required|trim');   

        if($this->form_validation->run() == FALSE)
        {
            $data['canvass'] = $this->local_procurement_model->report_generation($canvass_no);
            $data['suppliers'] = $this->local_procurement_model->get_suppliers();
            $data['materials'] = $this->local_procurement_model->get_canvass_material_list($canvass_no);
            $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/matsource/add1';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->local_procurement_model->add_report_generation_with_supplier())
            {
                $canvass_no = $this->input->post('canvass_no');
                redirect('procurement/comparative_view/'.$canvass_no.'');
            }
        }
      
    }

    public function report_pr_add()
    {
        $this->form_validation->set_rules('pr_no', 'PR NUMBER', 'required|trim');   

        if($this->form_validation->run() == FALSE)
        {
            $data['uoms'] = $this->local_procurement_model->get_uom();
            $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/pr/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->local_procurement_model->add_report_generation())
            {
                

                $data = $this->local_procurement_model->last_canvass_no();
                
                $canvass_no = $data->canvass_no;
                $material_pr_no = $data->material_pr_no;
                
                redirect('procurement/report_pr_add_supplier/'.$canvass_no.'/'.$material_pr_no.'');
            }
        }
     
    }

    public function report_pr_add_supplier($canvass_no,$material_pr_no)
    {
        $this->form_validation->set_rules('canvass_no', 'Canvass Number', 'required|trim');   

        if($this->form_validation->run() == FALSE)
        {
            $data['canvass'] = $this->local_procurement_model->report_generation($canvass_no);
            $data['suppliers'] = $this->local_procurement_model->get_suppliers();
            $data['materials'] = $this->local_procurement_model->get_canvass_material_list($canvass_no);
            $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/pr/add1';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->local_procurement_model->add_report_generation_with_supplier())
            {
                $canvass_no = $this->input->post('canvass_no');
                redirect('procurement/comparative_view/'.$canvass_no.'');
            }
        }
       
    }

    public function json_material_sourcing_list()
    {
        $data = $this->local_procurement_model->get_material_list();
        echo json_encode($data);
    }

    public function json_material_sourcing()
    {
        $data = $this->local_procurement_model->get_material_source_list();
        echo json_encode($data);
    }

    public function json_material_restriction()
    {
        $data = $this->local_procurement_model->get_material_restriction();
        echo json_encode($data);
    }

    public function transmittal()
    {
        $this->form_validation->set_rules('msid', 'Material Source ID', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');

        if($this->form_validation->run() == FALSE){
            $data['material_sourcings'] = $this->local_procurement_model->get_material_sourcing_list();
            $data['suppliers'] = $this->local_procurement_model->get_suppliers();
            $data['main_content'] = 'procurement/local/ecanvass/transmittal/add';
            $this->load->view('inc/navbar', $data);
        }
        else{
            if($this->local_procurement_model->add_transmittal())
            {
                $this->session->set_flashdata('success_msg', 'Transmittal Successfully Added!');
                redirect('procurement/ecanvass_index');
            }
        }
        
    }
    
    public function material_enrollment_add()
    {
        $this->form_validation->set_rules('mcode', 'Material Code', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['material_groups'] = $this->local_procurement_model->get_material_group();
            $data['main_content'] = 'procurement/local/ecanvass/material_enrollment/add';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->local_procurement_model->add_material())
            {
                $this->session->set_flashdata('success_msg', 'Material Successfully Added!');
                redirect('procurement/material_enrollment');
            }
        }
    }

    public function material_enrollment()
    {
        $data['types'] = $this->local_procurement_model->get_material_type();
        $data['materials'] = $this->local_procurement_model->get_materials();
        $data['main_content'] = 'procurement/local/ecanvass/material_enrollment/index';
        $this->load->view('inc/navbar', $data);
    }

    public function material_enrollment_edit($id)
    {
        $this->form_validation->set_rules('mcode', 'Material Code', 'required|trim');

        if($this->form_validation->run() == FALSE)
        {
            $data['material'] = $this->local_procurement_model->get_material($id);
            $data['material_groups'] = $this->local_procurement_model->get_material_group();
            $data['main_content'] = 'procurement/local/ecanvass/material_enrollment/edit';
            $this->load->view('inc/navbar', $data);
        }
        else
        {
            if($this->local_procurement_model->update_material($id))
            {
                $this->session->set_flashdata('success_msg', 'Material Successfully Updated!');
                redirect('procurement/material_enrollment');
            }
        }
       
    }

    public function material_enrollment_view($id)
    {
        $data['types'] = $this->local_procurement_model->get_material_type();
        $data['material'] = $this->local_procurement_model->get_material($id);
        $data['main_content'] = 'procurement/local/ecanvass/material_enrollment/view';
        $this->load->view('inc/navbar', $data);
    }

    public function material_enrollment_delete($id)
    {
        if($this->local_procurement_model->delete_material($id))
        {
            $this->session->set_flashdata('error_msg', 'Material Successfully Deleted!');
            redirect('procurement/material_enrollment');
        }
    }

    public function material_enrollment_csv()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_enrollment/csv';
        $this->load->view('inc/navbar', $data);
    }

    public function email_format()
    {
        $data['main_content'] = 'procurement/local/email';
        $this->load->view('inc/navbar', $data);
    }

    public function transmittal_format()
    {
        $data['main_content'] = 'procurement/local/transmittalemail';
        $this->load->view('inc/navbar', $data);
    }

    public function ecanvass_user_index()
    {
        $data['main_content'] = 'procurement/local/ecanvass/user_index';
        $this->load->view('inc/navbar', $data);
    }

    public function transmittal_list()
    {
        $data['transmittal_lists'] = $this->local_procurement_model->get_transmittal_lists();
        $data['main_content'] = 'procurement/local/ecanvass/transmittal/index';
        $this->load->view('inc/navbar', $data);
    }

    public function transmittal_view($id, $trans_batch_number)
    {
        $data['transmittal_materials'] = $this->local_procurement_model->get_transmittal_material_list($trans_batch_number);
        $data['transmittal_lists'] = $this->local_procurement_model->get_transmittal_list($id);
        $data['main_content'] = 'procurement/local/ecanvass/transmittal/view';
        $this->load->view('inc/navbar', $data);
    }    
}
