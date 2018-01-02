<?php

class Patient extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('contact/contact_model');
        $this->load->model('patient_model');
        $this->load->model('settings/settings_model');
        $this->load->model('admin/admin_model');
        $this->load->model('appointment/appointment_model');
        $this->load->model('stock/stock_model');
        $this->load->model('payment/payment_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('currency');
        $this->load->library('form_validation');
        $this->load->database();
    }

    public function index() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $level = $this->session->userdata('category');
            $data['patients'] = $this->patient_model->find_patient();            
            if ($level == 'Administrator') {
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('patient/browse', $data);
                $this->load->view('templates/footer');
            } else {
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('patient/browse', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function insert() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');

            if ($this->form_validation->run() === false) {                
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('add_patient');
                $this->load->view('templates/footer');
            } else {               
                $contact_id = $this->contact_model->insert_new_patient();
                //$this->contact_model->insert_address($contact_id);
                $patient_id = $this->patient_model->insert_patient($contact_id);                
                
                //$this->visit($patient_id);
                $this->index();
            }
        }
    }

    public function insert_new_patient($start_time = null, $appointment_date = null) {
        list($day, $month, $year) = explode('-', $appointment_date);
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');

            if ($this->form_validation->run() === false) {
                $this->edit_appointment($year, $month, $day, $start_time);
            } else {
                $contact_id = $this->contact_model->insert_contact();
//$this->contact_model->insert_address($contact_id);
                $patient_id = $this->patient_model->insert_patient($contact_id);

                redirect('appointment/edit/' . $year . '/' . $month . '/' . $day . '/' . $start_time . '/' . $patient_id);
            }
        }
    }

    public function edit_appointment($year = null, $month = null, $day = null, $time = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $level = $this->session->userdata('category');
            if ($year == null) {
                $year = date("Y");
            }
            if ($month == null) {
                $month = date("n");
            }
            if ($day == null) {
                $day = date("j");
            }

            $app_dt = date("j-n-Y", gmmktime(0, 0, 0, $month, $day, $year));
            $data['appointment_date'] = $app_dt;

            $data['appointment_time'] = $time;

            $this->form_validation->set_rules('start_time', 'Start Time', 'required');
            $this->form_validation->set_rules('end_time', 'End Time', 'required');
            $this->form_validation->set_rules('appointment_date', 'Date', 'required');

            if ($this->form_validation->run() === false) {
                $data['patients'] = $this->patient_model->get_patient();
                $data['appointment'] = $this->appointment_model->get_appointment_at($app_dt, $time);
                if (isset($data['appointment']['patient_id'])) {
                    $patient_id = $data['appointment']['patient_id'];
                    $data['patient'] = $this->patient_model->get_patient_detail($patient_id);
                }
                if ($level == 'Administrator') {
                    $this->load->view('templates/header');
                    $this->load->view('templates/menu');
                    $this->load->view('appointment/edit', $data);
                    $this->load->view('templates/footer');
                } else {
                    $this->load->view('templates/header');
                    $this->load->view('templates/menu');
                    $this->load->view('appointment/edit', $data);
                    $this->load->view('templates/footer');
                }
            } else {
                $this->appointment_model->add_appointment();
                $year = date("Y", strtotime($this->input->post('appointment_date')));
                $month = date("m", strtotime($this->input->post('appointment_date')));
                $day = date("d", strtotime($this->input->post('appointment_date')));
                $this->index($year, $month, $day);
            }
        }
    }

    public function visit($patient_id = null, $appointment_id = null, $app_date = null, $time = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $data['doctors'] = $this->admin_model->get_doctor();
            $data['treatments'] = $this->settings_model->get_treatments();
            $data['next_followup_days'] = $this->settings_model->get_clinic_settings();
            if ($appointment_id == null) {
                $result = $this->appointment_model->get_appointment_by_patient($patient_id);
                if ($result == false) {
                    $data['appointment_id'] = null;
                    $data['start_time'] = null;
                    $data['appointment_date'] = null;
                } else {
                    $data['appointment_id'] = $result->appointment_id;
                    $data['start_time'] = $result->start_time;
                    $data['appointment_date'] = $result->appointment_date;
                }
            } else {
                $data['appointment_id'] = $appointment_id;
                $data['start_time'] = $time;
                $data['appointment_date'] = $app_date;
            }
            $this->form_validation->set_rules('notes', 'Notes', 'required');

            if ($this->form_validation->run() === false) {
                $data['patient_id'] = $patient_id;
                $data['patient'] = $this->patient_model->get_patient_detail($patient_id);
                $data['addresses'] = $this->contact_model->get_contacts($data['patient']['contact_id']);
                $data['visits'] = $this->patient_model->get_previous_visits($patient_id);
                $data['visit_treatments'] = $this->patient_model->get_visit_treatments();

                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('patient/visit', $data);
                $this->load->view('templates/footer');
            } else {
                $this->patient_model->insert_visit();
                $patient_id = $this->input->post('patient_id');
                $this->patient_model->change_followup_date($patient_id);
                $data['patient_id'] = $patient_id;
                $data['patient'] = $this->patient_model->get_patient_detail($patient_id);
                $data['addresses'] = $this->contact_model->get_contacts($data['patient']['contact_id']);
                $data['visits'] = $this->patient_model->get_previous_visits($patient_id);
                $data['visit_treatments'] = $this->patient_model->get_visit_treatments();

                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('patient/visit', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function edit_visit($visit_id, $patient_id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {

            $this->form_validation->set_rules('notes', 'Note Field', 'required');
            if ($this->form_validation->run() === false) {
                $data['visit'] = $this->patient_model->get_visit_data($visit_id);
                $data['doctor'] = $this->admin_model->get_doctor($data['visit']['userid']);
                $data['follow_up'] = $this->appointment_model->get_followup_of_patient($patient_id);
                $data['treatments'] = $this->settings_model->get_treatments();
                $data['visit_treatments'] = $this->settings_model->get_visit_treatment($visit_id);
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('edit_visit', $data);
                $this->load->view('templates/footer');
            } else {
                $this->patient_model->edit_visit_data($visit_id);
                redirect('patient/visit/' . $patient_id);
            }
        }
    }

    public function delete($patient_id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $this->patient_model->delete_patient($patient_id);
            $this->index();
        }
    }

    public function check_available_stock($required_stock, $item_id) {
        $available_quantity = $this->stock_model->get_available_quantity($item_id);
        $item = $this->stock_model->get_item($item_id);

        if ($available_quantity < $required_stock) {
            $this->form_validation->set_message('check_available_stock', 'Required Quantity ' . $required_stock . ' exceeds Available Stock (' . $available_quantity . ') for Item ' . $item['item_name']);
            return false;
        } else {
            return true;
        }
    }

    public function bill($visit_id = null, $patient_id = null) {
//If user has not logged in , ask him to login
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
//fetch required details
            $bill_id = $this->patient_model->get_bill_id($visit_id);
//            if ($bill_id == NULL)
//                $bill_id = $this->patient_model->create_bill($visit_id, $patient_id);

            $patient_id = $this->patient_model->get_patient_id($visit_id);
            $data['patient_id'] = $patient_id;
            $data['medicine'] = $this->patient_model->get_medicine_total($visit_id);
            $data['treatment'] = $this->patient_model->get_treatment_total($visit_id);
            $data['patient'] = $this->patient_model->get_patient_detail($patient_id);
            $data['visit_id'] = $visit_id;
            $data['adv_payment'] = $this->payment_model->get_balance_amount($patient_id);
            $data['items'] = $this->stock_model->get_items();
            $data['currency_postfix'] = $this->settings_model->get_currency_postfix();
            
            $action = $this->input->post('action');
            $item_id = $this->input->post('item_id');

//adding item
            if ($action == 'medicine') {
                $this->form_validation->set_rules('particular', 'Particular', 'required');
                $this->form_validation->set_rules('quantity', 'Quantity', 'is_natural_no_zero|required|callback_check_available_stock[' . $item_id . ']');

                if ($this->form_validation->run() === false) {
                    
                } else {
                    $item_id = $this->input->post('item_id');
                    $quantity = $this->input->post('quantity');

                    $this->select_item($bill_id, $item_id, $quantity);
                }
                $data['bill_id'] = $bill_id;
                $data['bill'] = $this->patient_model->get_bill($visit_id);
                $data['bill_details'] = $this->patient_model->get_bill_detail($visit_id);
                $data['balance'] = $this->payment_model->get_balance_amount($bill_id);
                $data['treatment'] = $this->patient_model->get_treatment_total($visit_id);
                $data['medicine'] = $this->patient_model->get_medicine_total($visit_id);
                $data['paid_amount'] = $this->payment_model->get_paid_amount($bill_id);
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('bill', $data);
                $this->load->view('templates/footer');
            } else {
//                $this->form_validation->set_rules('treatment', 'Treatment', 'required');
//                $this->form_validation->set_rules('amount', 'Amount', 'required');
//
//                if ($this->form_validation->run() === FALSE) {
//                    
//                } else {
//                    $treatment = $this->input->post('treatment');
//                    $amount = $this->input->post('amount');
//                    $this->patient_model->add_bill_item($action, $bill_id, $treatment, 1, $amount, $amount);
//                }
                $data['bill_id'] = $bill_id;
                $data['bill'] = $this->patient_model->get_bill($visit_id);
                $data['bill_details'] = $this->patient_model->get_bill_detail($visit_id);
                $data['balance'] = $this->payment_model->get_balance_amount($bill_id);
                $data['treatment'] = $this->patient_model->get_treatment_total($visit_id);
                $data['medicine'] = $this->patient_model->get_medicine_total($visit_id);
                $data['paid_amount'] = $this->payment_model->get_paid_amount($bill_id);

                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('bill', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    function bill_detail_report() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $level = $this->session->userdata('category');
            $data['doctors'] = $this->admin_model->get_doctor();
            $this->form_validation->set_rules('bill_from_date', 'From Bill Date', 'required');
            $this->form_validation->set_rules('bill_to_date', 'To Bill Date', 'required');

            if ($this->form_validation->run() === false) {
                if ($level == 'Administrator') {
                    $this->load->view('templates/header');
                    $this->load->view('templates/menu');
                    $this->load->view('patient/bill_detail_report', $data);
                    $this->load->view('templates/footer');
                } else {
                    $this->load->view('templates/header');
                    $this->load->view('templates/menu');
                    $this->load->view('patient/bill_detail_report', $data);
                    $this->load->view('templates/footer');
                }
            } else {
                $data['reports'] = $this->patient_model->get_bill_report();
                if ($level == 'Administrator') {
                    $this->load->view('patient/bill_report', $data);
                } else {
                    $this->load->view('patient/bill_report', $data);
                }
            }
        }
    }

    function select_item($bill_id, $item_id, $required_quantity) {
        $remain_quantity = $this->stock_model->get_remain_quantity($item_id);
// We are assuming that Available Quantity is greater than Required Quantity
        foreach ($remain_quantity as $r_qty) {
//Loop till Quantity is required.
            if ($required_quantity <= 0)
                break;

            if ($r_qty['remain_quantity'] >= $required_quantity) {

                $amt = $required_quantity * $r_qty['mrp'];

                $item = $this->stock_model->get_item($item_id);
                $item_name = $item['item_name'];

                $this->patient_model->add_bill_item('medicine', $bill_id, $item_name, $required_quantity, $amt, $r_qty['mrp'], $r_qty['purchase_id']);
                $this->patient_model->update_available_quantity($required_quantity, $r_qty['purchase_id']);
                $required_quantity = 0;
            } elseif ($r_qty['remain_quantity'] < $required_quantity) {
                $amt = $r_qty['remain_quantity'] * $r_qty['mrp'];

                $item = $this->stock_model->get_item($item_id);
                $item_name = $item['item_name'];

                $this->patient_model->add_bill_item('medicine', $bill_id, $item_name, $r_qty['remain_quantity'], $amt, $r_qty['mrp'], $r_qty['purchase_id']);
                $this->patient_model->update_available_quantity($r_qty['remain_quantity'], $r_qty['purchase_id']);

                $required_quantity = $required_quantity - $r_qty['remain_quantity'];
            }
        }
    }

    public function delete_bill_detail($bill_detail_id, $bill_id, $visit_id, $patient_id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $this->patient_model->delete_bill_detail($bill_detail_id, $bill_id);
            $this->bill($visit_id, $patient_id);
        }
    }

    public function payment($bill_id = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('pay_date', 'Date', 'required');
            $this->form_validation->set_rules('pay_mode', 'Mode of Payment', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');

            if ($this->form_validation->run() === false) {
                $data['bill_id'] = $bill_id;
                $visit_id = $this->patient_model->get_visit_id($bill_id);
                $data['visit_id'] = $visit_id;
                $data['amount'] = $this->patient_model->get_bill_amount($bill_id);
                $data['payment'] = $this->patient_model->get_payment($bill_id);
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('patient/payment', $data);
                $this->load->view('templates/footer');
            } else {
                $this->patient_model->insert_payment();
                $bill_id = $this->input->post('bill_id');
                $visit_id = $this->patient_model->get_visit_id($bill_id);
                redirect('patient/bill/' . $visit_id);
            }
        }
    }

    public function print_receipt($visit_id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $data['bill'] = $this->patient_model->get_bill($visit_id);
            $patient_id = $data['bill']['patient_id'];
            $data['bill_details'] = $this->patient_model->get_bill_detail($visit_id);
            $data['clinic'] = $this->settings_model->get_clinic_settings();
            $data['invoice'] = $this->settings_model->get_invoice_settings();
            $data['patient'] = $this->patient_model->get_patient_detail($patient_id);
            $data['medicine'] = $this->patient_model->get_medicine_total($visit_id);
            $data['treatment'] = $this->patient_model->get_treatment_total($visit_id);
            $bill_id = $this->patient_model->get_bill_id($visit_id);
            $data['balance'] = $this->payment_model->get_balance_amount($bill_id);
            $data['paid_amount'] = $this->payment_model->get_paid_amount($bill_id);
            $data['currency_postfix'] = $this->settings_model->get_currency_postfix();

            $this->load->view('receipt', $data);
        }
    }

    function followup($p_id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $data['patient_id'] = $p_id;
            $data['follow_up'] = $this->appointment_model->get_followup_of_patient($p_id);
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('followup', $data);
            $this->load->view('templates/footer');
        }
    }

    function dismiss_followup($patient_id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $this->patient_model->dismiss_followup($patient_id);
            redirect('appointment/index');
        }
    }

    function change_followup_date($p_id) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index/');
        } else {
            $this->patient_model->change_followup_date($p_id);
            redirect('appointment/index');
        }
    }

    function patient_report() {
        $data['patients_detail'] = $this->patient_model->get_patient_report_patient_ids();
        $this->load->view('patient_report', $data);
    }

}

?>