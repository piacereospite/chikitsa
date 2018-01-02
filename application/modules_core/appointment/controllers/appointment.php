<?php

class Appointment extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('appointment_model');
        $this->load->model('admin/admin_model');
        $this->load->model('patient/patient_model');
        $this->load->model('settings/settings_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('currency_helper');

        $prefs = array(
            'show_next_prev' => true,
            'next_prev_url' => base_url() . 'index.php/appointment/index',
        );
        $this->load->library('calendar', $prefs);
    }

    public function index($year = null, $month = null, $day = null) {

        if ($this->session->userdata('user_name') == '') {                    // Check If session is created or not 
            redirect('login/index');
        } else {
            if ($year == null) {                                              // Get running Year 
                $year = date("Y");
            }
            if ($month == null) {
                $month = date("n");                                           // Get running Month
            }
            if ($day == null) {
                $day = date("j");                                             // Get Today Day
            }
            $data['year'] = $year;
            $data['month'] = $month;
            $data['day'] = $day;
            $appointment_date = date("Y-n-j", gmmktime(0, 0, 0, $month, $day, $year));                      //Generate today date in YYYY-MM-DD formate
            $data['start_time'] = $this->settings_model->get_clinic_start_time();
            $data['end_time'] = $this->settings_model->get_clinic_end_time();
            $data['time_interval'] = $this->settings_model->get_time_interval();
            $data['todos'] = $this->appointment_model->get_todos();
            $level = $this->session->userdata('category');

            if ($level == 'Doctor') {
                $id = $this->session->userdata('id');
                $data['appointments'] = $this->appointment_model->get_appointments_doctor($id, $appointment_date);
                $followup_date = date('Y-m-d', strtotime("+8 days"));
                $data['followups'] = $this->appointment_model->get_followup($followup_date);
                $data['patients'] = $this->patient_model->get_patient();

                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('appointment/browse', $data);
                $this->load->view('templates/footer');
            } else {
                $data['doctors'] = $this->admin_model->get_doctor();

                $i = 0;

                $data['appointments'] = $this->appointment_model->get_appointments($appointment_date);
                $followup_date = date('Y-m-d', strtotime("+8 days"));
                $data['followups'] = $this->appointment_model->get_followup($followup_date);
                $data['patients'] = $this->patient_model->get_patient();

                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('appointment/browse', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function edit($year = null, $month = null, $day = null, $time = null, $patient_id = null, $status = null, $doc = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
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
            $today = date('j-n-Y');

            $app_dt = date("j-n-Y", gmmktime(0, 0, 0, $month, $day, $year));
            if (strtotime($app_dt) < strtotime($today) && $level != 'Administrator') {
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('templates/access_forbidden');
                $this->load->view('templates/footer');
            } else {
                $data['appointment_date'] = $app_dt;

                $data['appointment_time'] = $time;

                $data['app_status'] = $status;
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('patient_name', 'Patient Name', 'required');
                $this->form_validation->set_rules('doctor', 'Doctor Name', 'required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'required');
                $this->form_validation->set_rules('end_time', 'End Time', 'required');
                $this->form_validation->set_rules('appointment_date', 'Date', 'required');

                if ($this->form_validation->run() === false) {

                    $data['clinic_start_time'] = $this->settings_model->get_clinic_start_time();
                    $data['clinic_end_time'] = $this->settings_model->get_clinic_end_time();
                    $data['time_interval'] = $this->settings_model->get_time_interval();
                    $data['doctor'] = $this->admin_model->get_doctor($doc);
                    $data['patients'] = $this->patient_model->get_patient();
                    $data['error'] = '';
                    if ($patient_id) {
                        $data['curr_patient'] = $this->patient_model->get_patient_detail($patient_id);
                    }

                    if ($doc != null) {
                        /* When Adding new patient through Appointment */
                        $data['appointment'] = $this->appointment_model->get_appointment_at($app_dt, $time, $doc);
                        $data['doc_id'] = $doc;
                    } else {
                        $data['appointment'] = $this->appointment_model->get_appointment_at($app_dt, $time);
                    }
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
                    /* echo 'Else in Appoinment edit'; */
                    $this->appointment_model->add_appointment();
                    $year = date("Y", strtotime($this->input->post('appointment_date')));
                    $month = date("m", strtotime($this->input->post('appointment_date')));
                    $day = date("d", strtotime($this->input->post('appointment_date')));
                    $this->index($year, $month, $day);
                }
            }
        }
    }

    function add_appointment_error() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $data['error'] = "This Time is not available";
            $data['patient'] = '';
            $data['appointment'] = '';
            $data['appointment_time'] = '';
            $data['appointment_date'] = '';

            $level = $this->session->userdata('category');
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
        }
    }

//    public function add($patient_id) {
//        if ($this->session->userdata('user_name') == '') {
//            redirect('login/index');
//        } else {
//            $this->load->helper('form');
//            $this->load->library('form_validation');
//            
//            //$this->form_validation->set_rules('title', 'Title', 'required');
//            $this->form_validation->set_rules('start_time', 'Start Time', 'required');
//            $this->form_validation->set_rules('end_time', 'End Time', 'required');
//            $this->form_validation->set_rules('appointment_date', 'Date', 'required');
//            $this->form_validation->set_rules('patient_id', 'Patient', 'required');
//            
//            if ($this->form_validation->run() === FALSE) {
//                $data['start_time']=$this->settings_model->get_clinic_start_time();
//                $data['end_time']=$this->settings_model->get_clinic_end_time();
//                $data['patient'] = $this->patient_model->get_patient_detail($patient_id);
//
//                $level = $this->session->userdata('category');
//                if ($level == 'Administrator') {
//                    $this->load->view('templates/header');
//                    $this->load->view('templates/menu');
//                    $this->load->view('appointment/add', $data);
//                    $this->load->view('templates/footer');
//                } else {
//                $this->load->view('templates/header');
//                $this->load->view('templates/menu');
//                $this->load->view('appointment/add',$data);
//                $this->load->view('templates/footer');
//            }
//            } else {
//                $this->appointment_model->add_patient_appointment();
//                $this->index();
//            }
//	}
//    }

    function delete($id, $appointment_date) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $year = date("Y", strtotime($appointment_date));
            $month = date("m", strtotime($appointment_date));
            $day = date("d", strtotime($appointment_date));
            $this->appointment_model->delete_appointment($id);
            $this->index($year, $month, $day);
        }
    }

    function change_status($app_id, $app_date, $old_status, $start_time, $new_status) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->appointment_model->change_status($app_id, $app_date, $old_status, $start_time, $new_status);
            $this->index();
        }
    }

    function appointment_report() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $data['doctors'] = $this->admin_model->get_doctor();
            $level = $this->session->userdata('category');
            $data['currency_postfix'] = $this->settings_model->get_currency_postfix();
            if ($level == 'Doctor') {
                $this->form_validation->set_rules('app_date', 'Appointment Date', 'required');
                if ($this->form_validation->run() === false) {
                    $data['app_reports'] = null;
                } else {
                    $app_date = date('Y-m-d', strtotime($this->input->post('app_date')));
                    $user_id = $this->session->userdata('id');
                    $data['app_reports'] = $this->appointment_model->get_report($app_date, $user_id);
                }
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('appointment/report', $data);
                $this->load->view('templates/footer');
            } else {
                $this->form_validation->set_rules('app_date', 'Appointment Date', 'required');
                $this->form_validation->set_rules('doctor', 'Doctor Name', 'required');
                if ($this->form_validation->run() === false) {
                    $data['app_reports'] = null;

                    if ($level == 'Administrator') {
                        $this->load->view('templates/header');
                        $this->load->view('templates/menu');
                        $this->load->view('appointment/report', $data);
                        $this->load->view('templates/footer');
                    } else {
                        $this->load->view('templates/header');
                        $this->load->view('templates/menu');
                        $this->load->view('appointment/report', $data);
                        $this->load->view('templates/footer');
                    }
                } else {
                    $app_date = date('Y-m-d', strtotime($this->input->post('app_date')));
                    $user_id = $this->input->post('doctor');
                    $data['app_reports'] = $this->appointment_model->get_report($app_date, $user_id);

                    if ($level == 'Administrator') {
                        $this->load->view('templates/header');
                        $this->load->view('templates/menu');
                        $this->load->view('appointment/report', $data);
                        $this->load->view('templates/footer');
                    } else {
                        $this->load->view('templates/header');
                        $this->load->view('templates/menu');
                        $this->load->view('appointment/report', $data);
                        $this->load->view('templates/footer');
                    }
                }
            }
        }
    }

    function todos() {
        $this->appointment_model->add_todos();
        $this->index();
    }

    function todos_done($done, $id) {
        $this->appointment_model->todo_done($done, $id);
    }

    function delete_todo($id) {
        $this->appointment_model->delete_todo($id);
        $this->index();
    }

}

?>