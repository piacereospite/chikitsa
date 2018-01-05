<?php

class Admin_model extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->database();
    }

    function login($username, $password, $level) {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('level', $level);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                //add all data to session
                $newdata = array(
                    'user_name' => $rows->username,
                    'logged_in' => true,
                );
            }
            $this->session->set_userdata($newdata);
            return true;
        }
        return false;
    }

    function add_user() {
//        $name = $this->input->post('name');
//        $user = $this->input->post('username');
//        $password = $this->input->post('password');
//        $level = $this->input->post('level');
        $data = array(
            'name' => $this->input->post('name'),
            'username' => $this->input->post('username'),
            'level' => $this->input->post('level'),
            'password' => base64_encode($this->input->post('password'))
        );
        $this->db->insert('users', $data);
    }

    function get_users() {
        $query = $this->db->get('users');
        return $query->result_array();
    }

    function get_user_detail($user_id) {
        $query = $this->db->get_where('users', array('userid' => $user_id));
        return $query->result_array();
    }

    function get_doctor($userid = null) {
        if ($userid == null) {
            $query = $this->db->get_where('users', array('level' => 'Doctor'));
            return $query->result_array();
        }else{
            $this->db->select('userid,name');
            $query = $this->db->get_where('users', array('userid' => $userid));
            return $query->row_array();
        }
    }

    function delete_user($id) {
        $this->db->delete('users', array('userid' => $id));
    }

    function get_edit_user($id) {
        $this->db->where('userid', $id);
        $query = $this->db->get('users');
        return $query->row_array();
    }

    function edit_user_data($id) {
        $level = $this->input->post('level');
        $password = base64_encode($this->input->post('newpassword'));
        $data = array(
            'level' => $level,
            'password' => $password
        );

        $this->db->where('userid', $id);
        $this->db->update('users', $data);
    }

    function change_profile($user_id){
        $data['name'] = $this->input->post('name');
        
        $this->db->where('userid', $user_id);
        $this->db->update('users', $data);
    }
    
    function change_password($user_id){
        $data['name'] = $this->input->post('name');
        $data['password'] = base64_encode($this->input->post('newpassword'));
        
        $this->db->where('userid', $user_id);
        $this->db->update('users', $data);
    }
}

?>
