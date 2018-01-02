<?php

class Settings extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('settings_model');
        $this->load->helper('currency_helper');
        $this->load->helper('form');
    }

    public function clinic() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('start_time', 'Clinic Start Time', 'required');
            $this->form_validation->set_rules('end_time', 'Clinic End Time', 'required');

            if ($this->form_validation->run() === false) {
                $data['clinic'] = $this->settings_model->get_clinic_settings();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('settings/clinic', $data);
                $this->load->view('templates/footer');
            } else {
                $this->settings_model->save_clinic_settings();
                $data['clinic'] = $this->settings_model->get_clinic_settings();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('settings/clinic', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function invoice() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('left_pad', 'Left Pad', 'required');
            $this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'required');

            if ($this->form_validation->run() === false) {
                $data['invoice'] = $this->settings_model->get_invoice_settings();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('invoice', $data);
                $this->load->view('templates/footer');
            } else {
                $this->settings_model->save_invoice_settings();
                $data['invoice'] = $this->settings_model->get_invoice_settings();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('invoice', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function treatment() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('treatment', 'Treatment Name', 'trim|required|xss_clean|is_unique[treatments.treatment]');
            $this->form_validation->set_rules('treatment_price', 'Treatment Price', 'trim|required|xss_clean');
            
            $data['currency_postfix'] = $this->settings_model->get_currency_postfix();
            if ($this->form_validation->run() === false) {
                $data['treatments'] = $this->settings_model->get_treatments();                
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('treatments_list', $data);
                $this->load->view('templates/footer');
            } else {
                $this->settings_model->add_treatment();
                $data['treatments'] = $this->settings_model->get_treatments();                
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('treatments_list', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function edit_treatment($id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {


            $data['treatment'] = $this->settings_model->get_edit_treatment($id);
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('edit_treatment', $data);
            $this->load->view('templates/footer');
        }
    }

    public function edit_treatment_id($id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('treatment_price', 'Treatment Price', 'trim|required|xss_clean');

            if ($this->form_validation->run() === false) {
                $this->edit_treatment($id);
            } else {
                $this->settings_model->edit_treatment($id);
                $this->treatment();
            }
        }
    }

    public function delete_treatment($id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->settings_model->delete_treatment($id);
            $this->treatment();
        }
    }
}

?>