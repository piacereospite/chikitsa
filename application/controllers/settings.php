<?php

class Settings extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('settings_model');
        }

	public function clinic()
	{
            $this->load->helper('form');
            $this->load->library('form_validation');
	
            $this->form_validation->set_rules('start_time', 'Clinic Start Time', 'required');
            $this->form_validation->set_rules('end_time', 'Clinic End Time', 'required');
            
            if ($this->form_validation->run() === false)
            {
                $data['clinic'] = $this->settings_model->get_clinic_settings();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('settings/clinic',$data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->settings_model->save_clinic_settings();
                $data['clinic'] = $this->settings_model->get_clinic_settings();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('settings/clinic',$data);
                $this->load->view('templates/footer');
            }
	}
        public function invoice()
	{
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('static_prefix', 'Static Prefix', 'required');
            $this->form_validation->set_rules('left_pad', 'Left Pad', 'required');
            
            if ($this->form_validation->run() === false)
            {
                $data['invoice'] = $this->settings_model->get_invoice_settings();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('settings/invoice',$data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->settings_model->save_invoice_settings();
                $data['invoice'] = $this->settings_model->get_invoice_settings();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('settings/invoice',$data);
                $this->load->view('templates/footer');
            }
	}
}
?>