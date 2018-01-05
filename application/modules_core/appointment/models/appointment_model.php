<?php

class Appointment_model extends CI_Model {

    public function __construct() {
		$this->load->database();
	}

    function add_appointment() {
        /* Set Local TimeZone as Default TimeZone */
        $timezone = 'Asia/Calcutta';
        if (function_exists('date_default_timezone_set'))
            date_default_timezone_set($timezone);

        $st = date('h:i', strtotime($this->input->post('start_time'))) . ':00';
        $uid = $this->input->post('doctor_id');
        $date = date('Y-m-d', strtotime($this->input->post('appointment_date')));

        //echo $st . " " . $uid . " " . $date . " ";
        $data['appointment_date'] = date('Y-m-d', strtotime($this->input->post('appointment_date')));
            $data['start_time'] = $this->input->post('start_time');
            $data['end_time'] = $this->input->post('end_time');
        $data['userid'] = $this->input->post('doctor_id');
        if ($this->input->post('patient_id') <> 0) {
                $data['title'] = $this->input->post('patient_name');
        } else {
                $data['title'] = $this->input->post('title');
            }
            $data['patient_id'] = $this->input->post('patient_id');
        $p_id = $this->input->post('patient_id');
            
        $query = $this->db->get_where('appointments', array('appointment_date' => $date, 'start_time' => $st, 'userid' => $uid));
        $row = $query->num_rows();

        if ($row == 1) {
            redirect('appointment/add_appointment_error');
        } else {
            $id = $this->input->post('id');
            if ($this->input->post('id') == null){
                if ($p_id <> null) {
                    $data3['followup_date'] = '00:00:00';
                    $this->db->update('patient', $data3, array('patient_id' => $p_id));
                }
                //Insert Appointment
                $data['status'] = 'Appointments';
                $this->db->insert('appointments', $data);
                $app_id = $this->db->insert_id();
                //echo $app_id;
                $data2['appointment_id'] = $app_id;
                $data2['change_date_time'] = date('d/m/Y H:i:s A');
                $data2['start_time'] = $this->input->post('start_time');
                $data2['old_status'] = ' ';
                $data2['status'] = 'Appointment';
                $data2['from_time'] = date('H:i:s');
                $data2['to_time'] = ' ';
                $data2['name'] = $this->session->userdata('name');
                $this->db->insert('appointment_log', $data2);
            } else {
                //Edit Appointment
                $this->db->update('appointments', $data, array('appointment_id' => $id));
            }
        }
    }

//    function add_patient_appointment() {
//            $data['appointment_date'] = date("Y-m-d",strtotime($this->input->post('appointment_date')));
//            $data['start_time'] = $this->input->post('start_time');
//            $data['end_time'] = $this->input->post('end_time');
//            $data['title'] = $this->input->post('title');
//            $data['patient_id'] = $this->input->post('patient_id');
//            
//            $this->db->insert('appointments', $data);
//        }

    function get_appointments($appointment_date) {
        $query = $this->db->get_where('appointments', array('appointment_date' => $appointment_date, 'status !=' => 'Cancel'));
        return $query->result_array();
    }

    function get_appointments_doctor($id, $appointment_date) {
        $query = $this->db->get_where('appointments', array('appointment_date' => $appointment_date, 'userid' => $id));
            return $query->result_array();
        }

    function get_appointment_at($appointment_date, $start_time, $doc = null) {
        $appointment_date = date('Y-m-d', strtotime($appointment_date));
        if ($doc == null) {
            return;
        } else {
            $query = $this->db->get_where('appointments', array('appointment_date' => $appointment_date, 'start_time' => $start_time, 'userid' => $doc));
            return $query->row_array();
        }
    }

    function get_appointment_by_patient($p_id) {
        $date = date('Y-m-d');
        $this->db->select('appointment_id,start_time,appointment_date');
        $query = $this->db->get_where('appointments', array('patient_id' => $p_id, 'appointment_date' => $date));
        $row = $query->num_rows();
        if ($row > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function delete_appointment($appointment_id) {
            $this->db->delete('appointments', array('appointment_id' => $appointment_id)); 
        }
        /********************** To Dos ******************************/

//    function get_todos() {
//            $query = $this->db->get('to_do');
//            return $query->result_array();
//        }

    

    function change_status($id, $app_date, $old_status, $start_time, $new_status) {
        //echo 'Change Status Appointment Model' . $id . " " . $app_date . " " . $old_status . " " . $start_time . " " . $new_status;
		$app_date = $app_date + 1;
		$data['status'] = $new_status;
        $this->db->update('appointments', $data, array('appointment_id' => $id));
	//	echo " After update appointments";
        /* Code to Set Date time Zone For India */

        $timezone = 'Asia/Calcutta';
        if (function_exists('date_default_timezone_set'))
            date_default_timezone_set($timezone);
	//	echo ' After time Set';
		
        /* End Fo Code To Set Tile Zone For India */
        $data2['to_time'] = date('H:i:s');
        $this->db->update('appointment_log', $data2, array('appointment_id' => $id, 'to_time' => '00:00:00'));
				
        $data3['appointment_id'] = $id;
        $data3['change_date_time'] = date('d/m/Y H:i:s');
        $data3['start_time'] = $start_time;
        $data3['old_status'] = $old_status;
        $data3['status'] = $new_status;
        $data3['from_time'] = date('H:i:s');
        $data3['to_time'] = '';
        $data3['name'] = $this->session->userdata('name');
        $this->db->insert('appointment_log', $data3);
    }

    function get_user_id($user_name) {
        $this->db->select('userid');
        $query = $this->db->get_where('users', array('username' => $user_name));
        return $query->row();
    }

    function get_followup($follow_date) {
        $this->db->order_by('followup_date', 'asc');
        $query = $this->db->get_where('patient', array('followup_date <' => $follow_date, 'followup_date !=' => '0000:00:00'));
        return $query->result_array();
    }
    
    public function get_followup_of_patient($patient_id){
        $this->db->select('patient_id,followup_date');
        $query = $this->db->get_where('patient', array('patient_id' => $patient_id));
        return $query->row_array();
    }

    function get_report($app_date, $user_id) {
        $query = $this->db->get_where('view_report', array('userid' => $user_id, 'appointment_date' => $app_date));
        return $query->result_array();
    }
    
    function get_todos(){
        $user_id = $this->session->userdata('id');
        $query = 'Select * FROM ' . $this->db->dbprefix('todos') . ' WHERE userid = ' . $user_id . ' and (done = 0 OR (done_date > DATE_SUB(NOW(), INTERVAL 29 DAY) AND done = 1)) ORDER BY done ASC, add_date DESC;';         
        $result = $this->db->query($query);
        return $result->result_array();
    }

    function add_todos(){
        $data['userid'] = $this->session->userdata('id');
        $data['add_date'] = date('Y-m-d H:i:s');
        $data['done'] = 0;
        $data['todo'] = $this->input->post('task');
        $this->db->insert('todos', $data);
        redirect('appointment/index');
    }
    
    function todo_done($done, $id){
        $data['done'] = $done;
        if($data['done'] == 1){
            $data['done_date'] = date('Y-m-d H:i:s');        
        }else{
            $data['done_date'] = null;
        }
        $this->db->update('todos', $data, array('id_num' => $id));
        return;
    }
    
    function delete_todo($id){
        $this->db->delete('todos', array('id_num' => $id));
        return;
    }
}