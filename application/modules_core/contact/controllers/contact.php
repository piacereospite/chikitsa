<?php

class Contact extends CI_Controller {

    function __construct() {
            parent::__construct();
            $this->load->model('contact_model');
            $this->load->model('patient/patient_model');
            //$this->load->library('session');
            $this->load->helper('url');
        $this->load->helper('form');
        }

    public function index() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $name = $this->input->post('search_name');
            $phone = $this->input->post('search_phone');
            $data['contacts'] = $this->contact_model->search_contacts($name, $phone);
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('contact/browse', $data);
            $this->load->view('templates/footer');
	}
    }
        
    public function add() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
	
            if ($this->form_validation->run() === false) {
                    $this->load->view('templates/header');
                    $this->load->view('templates/menu');
                    $this->load->view('contact/add');
                    $this->load->view('templates/footer');
            } else {
                    $id = $this->contact_model->insert_contact();
                    $this->contact_model->insert_address($id);
                    $this->contact_model->insert_email($id);
                    $this->index();
            }
	}
    }

    public function delete($id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $this->contact_model->delete_contact($id); 
//            $this->contact_model->delete_address($id); 
            $this->index();
        }
    }
            

    public function edit($patient_id = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            
            if ($this->form_validation->run() === false) {
                $contact_id = $this->patient_model->get_contact_id($patient_id);                
                $data['patient_id'] = $patient_id;
                $data['reference_by'] = $this->patient_model->get_reference_by($patient_id);
                $data['contacts'] = $this->contact_model->get_contacts($contact_id);                 
                $data['address'] = $this->contact_model->get_contact_address($contact_id);                 
                //$data['emails'] = $this->contact_model->get_contact_email($contact_id);                 
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('contact/edit', $data);
                $this->load->view('templates/footer');
            } else {
                $name = $this->do_upload();
                if ($name == false) {
                    //echo "No Image" . $name;
                $patient_id = $this->input->post('patient_id');
                $this->contact_model->update_contact();
                $this->contact_model->update_address();
                $this->patient_model->update_reference_by($patient_id);
                //$this->contact_model->update_emails();
                redirect('patient/visit/'. $patient_id);
                } else {
              
                    echo "Upload Image " , $name; //Avoid concatenations in echo statement
                    $patient_id = $this->input->post('patient_id');
                    $this->contact_model->update_contact($name);
                    $this->contact_model->update_address();
                    $this->patient_model->update_reference_by($patient_id);
                    //$this->contact_model->update_emails();
                    redirect('patient/visit/' . $patient_id);
                }
            }
        }
            }
        
    function do_upload() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            //echo "Hi";
            $config['upload_path'] = './profile_picture/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = '100';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['overwrite'] = true;
            $config['file_name'] = $this->input->post('contact_id');

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
//            $error = array('error' => $this->upload->display_errors());
//
//            $this->load->view('upload_form', $error);
                return false;
            } else {

                $data = array('upload_data' => $this->upload->data());
                //echo $data['upload_data']['file_name'];
                //$this->load->view('upload_success', $data);
                return $data['upload_data']['file_name'];
            }
        }
    }

}