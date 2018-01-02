<?php

class Patient extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->model('contact_model');
            $this->load->model('patient_model');
            $this->load->model('settings_model');
            $this->load->helper('url');
        }
	public function index()
	{
            $this->load->helper('form');
            
            $data['patients'] = $this->patient_model->find_patient();  
            
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('patient/browse',$data);
            $this->load->view('templates/footer');
	}
        public function insert()
        {
            $contact_id = $this->contact_model->insert_contact();
            $this->contact_model->insert_address($contact_id);
            $patient_id = $this->patient_model->insert_patient($contact_id);
            
            $this->visit($patient_id);
        }
        public function visit($patient_id = null){
            $this->load->helper('form');
            $this->load->library('form_validation');
	
            $this->form_validation->set_rules('notes', 'Notes', 'required');
	
            if ($this->form_validation->run() === false)
            {
                $data['patient_id']=$patient_id;
                $data['patient']=$this->patient_model->get_patient_detail($patient_id); 
                $data['addresses']=$this->contact_model->view_contact_address($data['patient']['contact_id']); 
                $data['visits']=$this->patient_model->get_previous_visits($patient_id); 
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('patient/visit',$data);
                $this->load->view('templates/footer');
            }
            else
            {
                    $this->patient_model->insert_visit();
                    $patient_id = $this->input->post('patient_id');
                    $data['patient_id']=$patient_id;
                    $data['patient']=$this->patient_model->get_patient_detail($patient_id); 
                    $data['addresses']=$this->contact_model->view_contact_address($data['patient']['contact_id']); 
                    $data['visits']=$this->patient_model->get_previous_visits($patient_id); 
                    $this->load->view('templates/header');
                    $this->load->view('templates/menu');
                    $this->load->view('patient/visit',$data);
                    $this->load->view('templates/footer');
            }
        }
        public function delete($patient_id)
        {
            $this->patient_model->delete_patient($patient_id);
            $this->index();
        }
        public function bill($visit_id = null)
        {
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('particular', 'Particular', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            
            if ($this->form_validation->run() === false)
            {
                $data['visit_id'] = $visit_id;
                $patient_id = $this->patient_model->get_patient_id($visit_id); 
                $data['patient_id'] =$patient_id;

                $data['bill_id'] = $this->patient_model->get_bill_id($visit_id); 
                $data['patient']=$this->patient_model->get_patient_detail($patient_id); 
                $data['bill']=$this->patient_model->get_bill($visit_id);
                $data['bill_details']=$this->patient_model->get_bill_detail($visit_id); 
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('patient/bill',$data);
                $this->load->view('templates/footer');
            }
            else
            {
                $bill_id = $this->patient_model->get_bill_id($visit_id);
                if ($bill_id == null)
                   $bill_id = $this->patient_model->create_bill();
                
                $this->patient_model->add_bill_item($bill_id);
                $patient_id = $this->patient_model->get_patient_id($visit_id);
                $data['visit_id'] = $visit_id;
                $data['patient_id'] = $patient_id;
                $data['bill_id'] = $bill_id;
                $data['patient']=$this->patient_model->get_patient_detail($patient_id); 
                $data['bill']=$this->patient_model->get_bill($visit_id);
                $data['bill_details']=$this->patient_model->get_bill_detail($visit_id); 
                
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('patient/bill',$data);
                $this->load->view('templates/footer');
            }
        }
        public function payment($bill_id = null)
        {
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('pay_date', 'Date', 'required');
            $this->form_validation->set_rules('pay_mode', 'Mode of Payment', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            
            if ($this->form_validation->run() === false)
            {
                $data['bill_id']=$bill_id;
                $visit_id =  $this->patient_model->get_visit_id($bill_id);
                $data['visit_id']=$visit_id;
                $data['amount']=$this->patient_model->get_bill_amount($bill_id);
                $data['payment']=$this->patient_model->get_payment($bill_id);
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('patient/payment',$data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->patient_model->insert_payment();
                $bill_id = $this->input->post('bill_id');
                $visit_id =  $this->patient_model->get_visit_id($bill_id);
                redirect('patient/bill/' . $visit_id);
            }
        }
        public function print_receipt($visit_id){
            $data['bill']=$this->patient_model->get_bill($visit_id);
            $patient_id = $data['bill']['patient_id'];
            $data['bill_details']=$this->patient_model->get_bill_detail($visit_id);
            $data['clinic']=$this->settings_model->get_clinic_settings();
            $data['invoice']=$this->settings_model->get_invoice_settings();
            $data['patient']=$this->patient_model->get_patient_detail($patient_id); 
            $this->load->view('patient/receipt',$data);
        }
        public function delete_bill_detail($bill_detail_id,$bill_id,$visit_id,$patient_id){
            $this->patient_model->delete_bill_detail($bill_detail_id,$bill_id);
            $this->bill($visit_id,$patient_id);
        }
}
?>