<?php

class Payment extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('patient/patient_model');
        $this->load->model('settings/settings_model');
        $this->load->model('payment_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('currency_helper');
        $this->load->library('form_validation');
    }

    function index($p_id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $data['patient_id'] = $p_id;
            $data['balance'] = $this->payment_model->get_balance_amount($p_id);
            $data['header'] = 'Advance Payment';
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('advance_payment', $data);
            $this->load->view('templates/footer');
        }
    }

    function add() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $result = $this->payment_model->add_payment();
            if($result['payment_type'] == 'advanced'){
                redirect('appointment/index');
            }
            if($result['payment_type'] == 'bill_payment'){
               redirect('patient/bill/' . $result['visit_id'] . '/' . $result['patient_id']); 
            }
        }
    }

    function bill_payment($visit_id, $patient_id, $total_amount, $bill_id) {
        $data['visit_id'] = $visit_id;
        $data['patient_id'] = $patient_id;
        $data['total'] = $total_amount;
        $data['bill_id'] = $bill_id;
        $data['header'] = 'Bill Payment';
        $data['currency_postfix'] = $this->settings_model->get_currency_postfix();

            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('advance_payment', $data);
            $this->load->view('templates/footer');
        }
    }
?>
