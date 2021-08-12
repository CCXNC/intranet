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

    function comparative()
    {
        $data['main_content'] = 'procurement/local/ecanvass/comparative/index';
        $this->load->view('inc/navbar', $data);
    }

    function comparative_matsource_view()
    {
        $data['main_content'] = 'procurement/local/ecanvass/comparative/matsource/view';
        $this->load->view('inc/navbar', $data);
    }

    function comparative_pr_view()
    {
        $data['main_content'] = 'procurement/local/ecanvass/comparative/pr/view';
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
        $data['main_content'] = 'procurement/local/ecanvass/material_sourcing/index';
        $this->load->view('inc/navbar', $data);
    }

    public function material_sourcing_matcode()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_sourcing/w_matcode/add';
        $this->load->view('inc/navbar', $data);
    }

    public function material_sourcing_nomatcode()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_sourcing/wo_matcode/add';
        $this->load->view('inc/navbar', $data);
    }

    public function material_sourcing_edit()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_sourcing/edit';
        $this->load->view('inc/navbar', $data);
    }

    public function material_sourcing_view()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_sourcing/view';
        $this->load->view('inc/navbar', $data);
    }

    public function ecanvass_report_generation()
    {
        $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/index';
        $this->load->view('inc/navbar', $data);
    }

    public function report_matsource_add()
    {
        $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/matsource/add';
        $this->load->view('inc/navbar', $data);
    }

    public function report_matsource_add1()
    {
        $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/matsource/add1';
        $this->load->view('inc/navbar', $data);
    }

    public function report_pr_add()
    {
        $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/pr/add';
        $this->load->view('inc/navbar', $data);
    }

    public function report_pr_add1()
    {
        $data['main_content'] = 'procurement/local/ecanvass/ecanvass_report/pr/add1';
        $this->load->view('inc/navbar', $data);
    }

    public function transmittal()
    {
        $data['main_content'] = 'procurement/local/ecanvass/transmittal/index';
        $this->load->view('inc/navbar', $data);
    }

    public function transmittal_pr_add()
    {
        $data['main_content'] = 'procurement/local/ecanvass/transmittal/pr/add';
        $this->load->view('inc/navbar', $data);
    }

    public function transmittal_matsource_add()
    {
        $data['main_content'] = 'procurement/local/ecanvass/transmittal/matsource/add';
        $this->load->view('inc/navbar', $data);
    }
    
    public function material_enrollment_add()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_enrollment/add';
        $this->load->view('inc/navbar', $data);
    }

    public function material_enrollment()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_enrollment/index';
        $this->load->view('inc/navbar', $data);
    }

    public function material_enrollment_edit()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_enrollment/edit';
        $this->load->view('inc/navbar', $data);
    }

    public function material_enrollment_view()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_enrollment/view';
        $this->load->view('inc/navbar', $data);
    }

    public function material_enrollment_csv()
    {
        $data['main_content'] = 'procurement/local/ecanvass/material_enrollment/csv';
        $this->load->view('inc/navbar', $data);
    }
}
