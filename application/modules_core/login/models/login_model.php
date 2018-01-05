<?php

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->database();
    }

    function login($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
//        $this->db->where("level", $level);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                //add all data to session
                $newdata = array(
                    'name' => $rows->name,
                    'user_name' => $rows->username,
                    'category' => $rows->level,
                    'id' => $rows->userid,
                    'logged_in' => true,
                );
            }
            $this->session->set_userdata($newdata);
            return true;
        }
        return false;
    }

}

?>
