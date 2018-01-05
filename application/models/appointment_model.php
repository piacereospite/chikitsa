<?php
class Appointment_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        function add_appointment()
        {
            $data['appointment_date'] = date('Y-m-d H:i:s',strtotime($this->input->post('appointment_date')));
            $data['start_time'] = $this->input->post('start_time');
            $data['end_time'] = $this->input->post('end_time');
            if ($this->input->post('patient_id') <> 0)
            {
                $data['title'] = $this->input->post('patient_name');
            }
            else
            {
                $data['title'] = $this->input->post('title');
            }
            $data['patient_id'] = $this->input->post('patient_id');
            
            $id = $this->input->post('id');
            if ($this->input->post('id') == null){
                //Insert Appointment
                $this->db->insert('appointments', $data);
            }
            else {
                //Edit Appointment
                $this->db->update('appointments', $data, array('appointment_id' =>  $id));
            }
        }
        function add_patient_appointment()
        {
            $data['appointment_date'] = date('Y-m-d',strtotime($this->input->post('appointment_date')));
            $data['start_time'] = $this->input->post('start_time');
            $data['end_time'] = $this->input->post('end_time');
            $data['title'] = $this->input->post('title');
            $data['patient_id'] = $this->input->post('patient_id');
            
            $this->db->insert('appointments', $data);
        }
        function get_appointments($appointment_date)
        {
            $query = $this->db->get_where('appointments', array('appointment_date' => $appointment_date));
            return $query->result_array();
        }
        function get_appointment_at($appointment_date,$start_time)
        {
            $appointment_date = date('Y-m-d',strtotime($appointment_date));
            $query = $this->db->get_where('appointments', array('appointment_date' =>  $appointment_date,'start_time' => $start_time));
            return $query->row_array();
        }
        function delete_appointment($appointment_id)
        {
            $this->db->delete('appointments', array('appointment_id' => $appointment_id)); 
        }
        /********************** To Dos ******************************/
        function get_todos()
        {
            $query = $this->db->get('to_do');
            return $query->result_array();
        }
}



























