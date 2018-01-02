<?php

class Gallery_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_images($patient_id) {
        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('visit_img', array('patient_id' => $patient_id));
        return $query->result_array();
    }
    
    function get_displayid($patient_id){
        //$this->db->select('display_id');
        $query = $this->db->get_where('view_patient', array('patient_id' => $patient_id));
        return $query->row();
    }

    function insert_image($path, $patient_id, $visit_id) {
        
        $data['patient_id'] = $patient_id;
        $data['visit_img_path'] = 'patient_images/'.$path;
        $data['visit_id'] = $visit_id;
        $data['img_name'] = date("d-m-Y");
        $this->db->insert('visit_img', $data);
    }

}

?>
