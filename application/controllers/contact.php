<?php

class Contact extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->model('contact_model');
            $this->load->model('patient_model');
            //$this->load->library('session');
            $this->load->helper('url');
        }

	public function index()
	{
            
            $this->load->helper('form');
            
            $name = $this->input->post('search_name');
            $phone = $this->input->post('search_phone');
            $data['contacts'] = $this->contact_model->search_contacts($name,$phone); 
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('contacts/browse', $data);
            $this->load->view('templates/footer');
	}
        
        public function add()
	{
            $this->load->helper('form');
            $this->load->library('form_validation');
	
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
	
            if ($this->form_validation->run() === false)
            {
                    $this->load->view('templates/header');
                    $this->load->view('templates/menu');
                    $this->load->view('contacts/add');
                    $this->load->view('templates/footer');

            }
            else
            {
                    $id = $this->contact_model->insert_contact();
                    $this->contact_model->insert_address($id);
                    $this->contact_model->insert_email($id);
                    $this->index();
                            
            }
	}
        public function delete($id)
        {   
            $this->contact_model->delete_contact($id); 
            $this->contact_model->delete_address($id); 
            $this->index();
        }
        public function search()
        {
            
        }
        public function edit($patient_id=null)
        {
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            
            /*$data['id']= $id;
            $data['bugs'] = $this->bug_model->get_bug($id); 
            $data['bug_details'] = $this->bug_model->get_bug_detail($id); */
            
            if ($this->form_validation->run() === false)
            {
                $contact_id = $this->patient_model->get_contact_id($patient_id); 
                $data['patient_id']=$patient_id;
                $data['contacts'] = $this->contact_model->get_contacts($contact_id); 
                $data['address'] = $this->contact_model->get_contact_address($contact_id); 
                $data['emails'] = $this->contact_model->get_contact_email($contact_id); 
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('contacts/edit', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $patient_id = $this->input->post('patient_id');
                $this->contact_model->update_contact();
                $this->contact_model->update_address();
                $this->contact_model->update_emails();
                redirect('patient/visit/'. $patient_id);
              
            }
        
        }
}