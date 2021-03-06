<?php

class Settings_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_clinic_settings() {
        $query = $this->db->get('clinic');
        return $query->row_array();
    }

    public function save_clinic_settings() {
        $data['clinic_name'] = $this->input->post('clinic_name');
        $data['tag_line'] = $this->input->post('tag_line');
        $data['clinic_address'] = $this->input->post('clinic_address');
        $data['landline'] = $this->input->post('landline');
        $data['mobile'] = $this->input->post('mobile');
        $data['email'] = $this->input->post('email');
        $data['start_time'] = $this->input->post('start_time');
        $data['end_time'] = $this->input->post('end_time');
        $data['time_interval'] = $this->input->post('time_interval');
        $data['next_followup_days'] = $this->input->post('next_followup_days');        
        
        $this->db->update('clinic', $data, array('clinic_id' => 1));
    }

    public function get_clinic_start_time() {
        $query = $this->db->get('clinic');
        $row = $query->row_array();
        if (!$row) {
            return '09:00';
        }
        return $row['start_time'];
    }

    public function get_clinic_end_time() {
        $query = $this->db->get('clinic');
        $row = $query->row_array();
        if (!$row) {
            return '18:00';
        }
        return $row['end_time'];
    }

    public function get_time_interval() {
        $query = $this->db->get('clinic');
        $row = $query->row_array();
        if (!$row) {
            return '0.50';
        }
        return $row['time_interval'];
    }

    public function get_invoice_settings() {
        $query = $this->db->get('invoice');
        return $query->row_array();
    }
    
    public function get_currency_postfix(){
        $this->db->select('currency_postfix');
        $query = $this->db->get('invoice');
        return $query->row_array();        
    }

    public function save_invoice_settings() {
        $data['static_prefix'] = $this->input->post('static_prefix');
        $data['left_pad'] = $this->input->post('left_pad');
        $data['currency_symbol'] = $this->input->post('currency_symbol');
        $data['currency_postfix'] = $this->input->post('currency_postfix');

        $this->db->update('invoice', $data, array('invoice_id' => 1));
    }

    public function get_invoice_next_id() {
        $query = $this->db->get('invoice');
        $row = $query->row_array();
        return $row['next_id'];
    }

    public function increment_next_id() {
        $next_id = $this->get_invoice_next_id();
        $next_id++;
        $data->next_id = $next_id;

        $this->db->update('invoice', $data, array('invoice_id' => 1));
    }
    
    public function get_treatments(){
        $result = $this->db->get('treatments');
        return $result->result_array();
    }
    
    public function add_treatment() {
        $data['treatment'] = $this->input->post('treatment');
        $data['price'] = $this->input->post('treatment_price');
        $this->db->insert('treatments',$data);
    }
    
    public function get_edit_treatment($id) {    
        $this->db->where('id', $id);
        $query = $this->db->get('treatments');
        return $query->row_array();    
    }
    
    public function edit_treatment($id){
        $data['treatment'] = $this->input->post('treatment');
        $data['price'] = $this->input->post('treatment_price');
        $this->db->where('id', $id);
        $this->db->update('treatments', $data);
    }
    
    public function delete_treatment($id) {
        $this->db->delete('treatments', array('id' => $id));
    }
    
    public function get_visit_treatment($visit_id){
        $bill_id = patient_model::get_bill_id($visit_id);
        
        $query = $this->db->get_where('bill_detail', array('bill_id' => $bill_id));
        return $query->result_array();
    }
}

?>
