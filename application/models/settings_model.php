<?php
class Settings_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        public function get_clinic_settings()
        {
            $query = $this->db->get('clinic');
            return $query->row_array();
        }
        public function save_clinic_settings()
        {
            $data->clinic_name = $this->input->post('clinic_name');
            $data->tag_line = $this->input->post('tag_line');
            $data->start_time = $this->input->post('start_time');
            $data->end_time = $this->input->post('end_time');
            $data->clinic_address = $this->input->post('clinic_address');
            $data->landline = $this->input->post('landline');
            $data->mobile = $this->input->post('mobile');
            $data->email = $this->input->post('email');
            
            $this->db->update('clinic', $data, array('clinic_id' =>  1));
        }
        public function get_clinic_start_time()
        {
            $query = $this->db->get('clinic');
            $row = $query->row_array();
            return $row['start_time'];
        }
        public function get_clinic_end_time()
        {
            $query = $this->db->get('clinic');
            $row=$query->row_array();
            return $row['end_time'];
        }
        public function get_invoice_settings()
        {
            $query = $this->db->get('invoice');
            return $query->row_array();
        }
            public function save_invoice_settings()
        {
            $data->static_prefix = $this->input->post('static_prefix');
            $data->left_pad = $this->input->post('left_pad');
            
            $this->db->update('invoice', $data, array('invoice_id' =>  1));
        }
        public function get_invoice_next_id()
        {
            $query = $this->db->get('invoice');
            $row = $query->row_array();
            return $row['next_id'];
        }
        public function increment_next_id()
        {
            $next_id = $this->get_invoice_next_id();
            $next_id++;
            $data->next_id = $next_id;
            
            $this->db->update('invoice', $data, array('invoice_id' =>  1));
        }
        
}
?>
